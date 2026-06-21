import unittest
from selenium.webdriver.common.by import By
from base_test import BaseTest
from config import BASE_URL, USER_EMAIL, USER_PASSWORD


class TestLoginMauMasakApa(BaseTest):

    def test_01_halaman_login_tampil(self):
        self.driver.get(f'{BASE_URL}/login')
        self.assertTrue(self.driver.find_element(By.ID, 'email').is_displayed())
        self.assertTrue(self.driver.find_element(By.ID, 'password').is_displayed())

    def test_02_login_gagal_password_salah(self):
        self.driver.get(f'{BASE_URL}/login')
        self.driver.find_element(By.ID, 'email').send_keys(USER_EMAIL)
        self.driver.find_element(By.ID, 'password').send_keys('salah_password')
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        self.assertIn('/login', self.driver.current_url)

    def test_03_login_berhasil_redirect_dashboard(self):
        self.login(USER_EMAIL, USER_PASSWORD)
        self.assertIn('/dashboard', self.driver.current_url)

    def test_04_logout_berhasil(self):
        self.login(USER_EMAIL, USER_PASSWORD)
        self.wait.until(lambda d: '/login' not in d.current_url)
        logout_form = self.driver.find_element(By.CSS_SELECTOR, 'form[action*="logout"]')
        logout_form.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()
        self.wait.until(lambda d: '/login' in d.current_url or d.current_url.endswith('/'))
        self.assertNotIn('/dashboard', self.driver.current_url)

    def test_05_user_dapat_akses_form_tambah_resep(self):
        self.login(USER_EMAIL, USER_PASSWORD)
        self.driver.get(f'{BASE_URL}/reseps/create')
        self.assertIn('/create', self.driver.current_url)

    def test_06_tambah_resep_berhasil(self):
        self.login(USER_EMAIL, USER_PASSWORD)
        self.driver.get(f'{BASE_URL}/reseps/create')
        self.driver.find_element(By.ID, 'judul').send_keys('Resep Selenium Test')
        self.driver.find_element(By.ID, 'bahan').send_keys('Bahan selenium')
        self.driver.find_element(By.ID, 'langkah').send_keys('Langkah selenium')
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        self.wait.until(lambda d: '/reseps' in d.current_url and '/create' not in d.current_url)
        self.assertIn('Resep Selenium Test', self.driver.page_source)

    def test_07_guest_tidak_dapat_akses_create(self):
        self.driver.get(f'{BASE_URL}/reseps/create')
        self.assertIn('/login', self.driver.current_url)


if __name__ == '__main__':
    unittest.main()
