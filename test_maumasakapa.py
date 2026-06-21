import unittest
from selenium.webdriver.common.by import By
from base_test import BaseTest
from config import BASE_URL, USER_EMAIL, USER_PASSWORD


class TestLoginMauMasakApa(BaseTest):

    # State: Halaman Awal → Halaman Login
    def test_01_halaman_login_tampil(self):
        # Arrange
        self.driver.get(f'{BASE_URL}/login')
        # Assert
        self.assertTrue(self.driver.find_element(By.ID, 'email').is_displayed())
        self.assertTrue(self.driver.find_element(By.ID, 'password').is_displayed())

    # State: Halaman Login → Login Gagal
    def test_02_login_gagal_password_salah(self):
        # Arrange
        self.driver.get(f'{BASE_URL}/login')
        # Act
        self.driver.find_element(By.ID, 'email').send_keys(USER_EMAIL)
        self.driver.find_element(By.ID, 'password').send_keys('salah_password')
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        # Assert
        self.assertIn('/login', self.driver.current_url)

    # State: Halaman Login → Dashboard (Login Berhasil)
    def test_03_login_berhasil_redirect_dashboard(self):
        # Act
        self.login(USER_EMAIL, USER_PASSWORD)
        # Assert
        self.assertIn('/dashboard', self.driver.current_url)

    # State: Dashboard → Halaman Login (Logout)
    def test_04_logout_berhasil(self):
        # Arrange
        self.login(USER_EMAIL, USER_PASSWORD)
        # Act — klik dropdown lalu logout
        self.wait.until(lambda d: '/login' not in d.current_url)
        logout_form = self.driver.find_element(By.CSS_SELECTOR, 'form[action*="logout"]')
        logout_form.find_element(By.CSS_SELECTOR, 'button[type="submit"]').click()
        # Assert
        self.wait.until(lambda d: '/login' in d.current_url or d.current_url.endswith('/'))
        self.assertNotIn('/dashboard', self.driver.current_url)

    # State: Dashboard → Halaman Create Resep
    def test_05_user_dapat_akses_form_tambah_resep(self):
        # Arrange
        self.login(USER_EMAIL, USER_PASSWORD)
        # Act
        self.driver.get(f'{BASE_URL}/reseps/create')
        # Assert
        self.assertIn('/create', self.driver.current_url)

    # State: Form Tambah → Daftar Resep (Submit Berhasil)
    def test_06_tambah_resep_berhasil(self):
        # Arrange
        self.login(USER_EMAIL, USER_PASSWORD)
        self.driver.get(f'{BASE_URL}/reseps/create')
        # Act
        self.driver.find_element(By.ID, 'judul').send_keys('Resep Selenium Test')
        self.driver.find_element(By.ID, 'bahan').send_keys('Bahan selenium')
        self.driver.find_element(By.ID, 'langkah').send_keys('Langkah selenium')
        self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        # Assert
        self.wait.until(lambda d: '/reseps' in d.current_url and '/create' not in d.current_url)
        self.assertIn('Resep Selenium Test', self.driver.page_source)

    # State: Halaman Resep → Guest akses /create → redirect login
    def test_07_guest_tidak_dapat_akses_create(self):
        # Act (tanpa login)
        self.driver.get(f'{BASE_URL}/reseps/create')
        # Assert
        self.assertIn('/login', self.driver.current_url)


if __name__ == '__main__':
    unittest.main()
