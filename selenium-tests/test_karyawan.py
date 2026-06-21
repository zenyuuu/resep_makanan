import unittest
from selenium.webdriver.common.by import By
from base_test import BaseTest
from config import BASE_URL, KARYAWAN_EMAIL, KARYAWAN_PASSWORD


class TestKaryawanAkses(BaseTest):
    def setUp(self):
        super().setUp()
        self.login(KARYAWAN_EMAIL, KARYAWAN_PASSWORD)

    def test_01_hanya_lihat_data_sendiri(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        rows = self.driver.find_elements(By.CSS_SELECTOR, 'tbody tr')
        self.assertEqual(len(rows), 1)

    def test_02_tidak_lihat_tombol_tambah(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        tambah = self.driver.find_elements(By.LINK_TEXT, 'Tambah Karyawan')
        self.assertEqual(len(tambah), 0)

    def test_03_tidak_lihat_tombol_edit_hapus(self):
        self.driver.get(f"{BASE_URL}/karyawan")
        rows = self.driver.find_elements(By.CSS_SELECTOR, 'tbody tr')
        if len(rows) > 0:
            # Check if edit/delete buttons exist in first row
            row = rows[0]
            edit_buttons = row.find_elements(By.LINK_TEXT, 'Edit')
            delete_buttons = row.find_elements(By.LINK_TEXT, 'Delete')
            # Karyawan seharusnya tidak bisa edit/delete data orang lain
            self.assertEqual(len(edit_buttons), 0)
            self.assertEqual(len(delete_buttons), 0)

    def test_04_tidak_bisa_akses_create(self):
        self.driver.get(f"{BASE_URL}/karyawan/create")
        self.assertIn('403', self.driver.page_source)


if __name__ == "__main__":
    unittest.main()


if __name__ == "__main__":
    unittest.main()
