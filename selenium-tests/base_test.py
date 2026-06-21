import unittest
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from webdriver_manager.chrome import ChromeDriverManager
from config import BASE_URL


class BaseTest(unittest.TestCase):
    """Base class untuk semua Selenium tests dengan AAA pattern"""

    def setUp(self):
        """Arrange - Setup WebDriver dan konfigurasi"""
        options = webdriver.ChromeOptions()
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument("--start-maximized")

        self.driver = webdriver.Chrome(
            service=Service(ChromeDriverManager().install()),
            options=options
        )
        self.driver.implicitly_wait(5)
        self.wait = WebDriverWait(self.driver, 10)

    def tearDown(self):
        """Cleanup - Close WebDriver setelah test selesai"""
        self.driver.quit()

    # Helper Methods

    def login(self, email, password):
        """
        Helper: Login dengan email dan password
        Menunggu hingga redirect (bisa ke dashboard atau karyawan)
        """
        self.driver.get(f"{BASE_URL}/login")
        self.driver.find_element(By.ID, "email").send_keys(email)
        self.driver.find_element(By.ID, "password").send_keys(password)
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        # Wait untuk redirect - bisa ke /dashboard, /karyawan, atau page lain
        self.wait.until(lambda driver: '/login' not in driver.current_url)

    def logout(self):
        """Helper: Logout dari sistem"""
        # Click profile dropdown
        self.driver.find_element(By.ID, "profile-dropdown").click()
        # Click logout button
        self.driver.find_element(By.ID, "logout-btn").click()
        self.wait.until(EC.url_contains("/login"))

    def find_element_safe(self, by, value, timeout=10):
        """
        Helper: Find element dengan explicit wait
        Return element jika ditemukan, None jika timeout
        """
        try:
            element = self.wait.until(
                EC.presence_of_element_located((by, value)),
                timeout=timeout
            )
            return element
        except:
            return None

    def click_element_safe(self, by, value):
        """Helper: Click element setelah element clickable"""
        element = self.wait.until(EC.element_to_be_clickable((by, value)))
        element.click()

    def fill_form(self, form_data):
        """
        Helper: Isi multiple form fields sekaligus
        form_data: dict {selector: value, ...}
        """
        for selector, value in form_data.items():
            field = self.driver.find_element(By.CSS_SELECTOR, selector)
            field.clear()
            field.send_keys(value)

    def assert_element_visible(self, by, value, message=""):
        """Assert: Element harus visible"""
        element = self.find_element_safe(by, value)
        self.assertIsNotNone(element, message or f"Element {value} tidak ditemukan")

    def assert_element_text(self, by, value, expected_text):
        """Assert: Element harus contain text tertentu"""
        element = self.find_element_safe(by, value)
        self.assertIn(expected_text, element.text)

    def assert_url_contains(self, expected_url):
        """Assert: Current URL harus contain string tertentu"""
        self.assertIn(expected_url, self.driver.current_url)

    def assert_page_contains_text(self, text):
        """Assert: Page source harus contain text tertentu"""
        self.assertIn(text, self.driver.page_source)
