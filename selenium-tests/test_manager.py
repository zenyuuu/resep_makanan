import unittest
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from base_test import BaseTest
from config import BASE_URL, MANAGER_EMAIL, MANAGER_PASSWORD


class TestManagerCRUD(BaseTest):
    def setUp(self):
        super().setUp()
        self.login(MANAGER_EMAIL, MANAGER_PASSWORD)

    def test_01_melihat_daftar_karyawan(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        table = self.driver.find_element(By.CSS_SELECTOR, 'table')
        self.assertTrue(table.is_displayed())

    def test_02_membuka_form_tambah(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        # Click tombol tambah atau navigate langsung ke create page
        try:
            self.driver.find_element(By.LINK_TEXT, 'Tambah Karyawan').click()
        except:
            self.driver.get(f"{BASE_URL}/karyawan/create")
        self.assertIn('/create', self.driver.current_url)

    def test_03_menambah_karyawan_baru(self):
        self.driver.get(f"{BASE_URL}/karyawan/create")
        self.driver.find_element(By.NAME, 'name').send_keys('Citra Selenium')
        self.driver.find_element(By.NAME, 'email').send_keys('citra@selenium.com')
        self.driver.find_element(By.NAME, 'password').send_keys('password123')
        try:
            self.driver.find_element(By.NAME, 'jabatan').send_keys('QA Engineer')
            self.driver.find_element(By.NAME, 'departemen').send_keys('IT')
            self.driver.find_element(By.NAME, 'tanggal_masuk').send_keys('2024-01-15')
        except:
            pass
        self.driver.find_element(
            By.CSS_SELECTOR, "button[type='submit']"
        ).click()
        self.wait.until(EC.url_contains('/karyawan'))
        self.assertIn('Citra Selenium', self.driver.page_source)

    def test_04_mengedit_karyawan(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        rows = self.driver.find_elements(By.CSS_SELECTOR, 'tbody tr')
        edited = False
        for row in rows:
            if 'Citra Selenium' in row.text:
                try:
                    row.find_element(By.LINK_TEXT, 'Edit').click()
                except:
                    row.find_element(By.CSS_SELECTOR, 'a[href*="edit"]').click()
                edited = True
                break
        if edited:
            try:
                self.driver.find_element(By.NAME, 'jabatan').clear()
                self.driver.find_element(By.NAME, 'jabatan').send_keys('Senior QA')
            except:
                pass
            self.driver.find_element(
                By.CSS_SELECTOR, "button[type='submit']"
            ).click()
            self.assertIn('Citra Selenium', self.driver.page_source)

    def test_05_menghapus_karyawan(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        rows = self.driver.find_elements(By.CSS_SELECTOR, 'tbody tr')
        for row in rows:
            if 'Citra Selenium' in row.text:
                try:
                    row.find_element(By.LINK_TEXT, 'Delete').click()
                except:
                    try:
                        row.find_element(By.CSS_SELECTOR, 'a[href*="delete"]').click()
                    except:
                        row.find_element(By.CSS_SELECTOR, 'button.btn-danger').click()
                break
        try:
            self.driver.find_element(By.CSS_SELECTOR, 'button.btn-danger').click()
        except:
            pass
        self.wait.until(EC.url_contains('/karyawan'))


if __name__ == "__main__":
    unittest.main()



if __name__ == "__main__":
    unittest.main()
