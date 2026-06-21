import unittest
from selenium.webdriver.common.by import By
from base_test import BaseTest
from config import BASE_URL, MANAGER_EMAIL, MANAGER_PASSWORD, KARYAWAN_EMAIL, KARYAWAN_PASSWORD


class TestLogin(BaseTest):
    def test_01_halaman_login_tampil(self):
        self.driver.get(f"{BASE_URL}/login")
        self.assertTrue(
            self.driver.find_element(By.ID, 'email').is_displayed()
        )
        self.assertTrue(
            self.driver.find_element(By.ID, 'password').is_displayed()
        )

    def test_02_manager_berhasil_login(self):
        self.login(MANAGER_EMAIL, MANAGER_PASSWORD)
        self.assertIn('/karyawan', self.driver.current_url)

    def test_03_karyawan_berhasil_login(self):
        self.login(KARYAWAN_EMAIL, KARYAWAN_PASSWORD)
        self.assertIn('/dashboard', self.driver.current_url)

    def test_04_login_gagal_password_salah(self):
        self.driver.get(f"{BASE_URL}/login")
        self.driver.find_element(By.ID, 'email').send_keys(MANAGER_EMAIL)
        self.driver.find_element(By.ID, 'password').send_keys('salah')
        self.driver.find_element(
            By.CSS_SELECTOR, "button[type='submit']"
        ).click()
        self.assertIn('/login', self.driver.current_url)

    def test_05_logout_berhasil(self):
        self.login(MANAGER_EMAIL, MANAGER_PASSWORD)
        self.logout()
        self.assertIn('/login', self.driver.current_url)


if __name__ == "__main__":
    unittest.main()


if __name__ == "__main__":
    unittest.main()
