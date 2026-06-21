# Selenium Test Framework - MauMasakApa

Dokumentasi lengkap untuk Selenium UI testing framework dengan pola AAA (Arrange-Act-Assert).

## Struktur Project

```
selenium-tests/
├── base_test.py          # Base class dengan helper methods
├── config.py             # Konfigurasi dan credentials
├── test_login.py         # Test authentication (7 tests)
├── test_karyawan.py      # Test karyawan CRUD (8 tests)
├── test_manager.py       # Test manager features (12 tests)
└── README.md            # Documentation
```

## Setup & Prerequisites

### 1. Install Dependencies

```bash
pip install selenium webdriver-manager unittest
```

### 2. Update config.py

Edit `config.py` dengan URL dan credentials yang sesuai:

```python
BASE_URL = "http://localhost:8000"           # URL aplikasi
MANAGER_EMAIL    = "manager@perusahaan.com"
MANAGER_PASSWORD = "password123"
KARYAWAN_EMAIL    = "andi@perusahaan.com"
KARYAWAN_PASSWORD = "password123"
```

### 3. Start Application Server

```bash
# Terminal 1: Start Laravel app
php artisan serve                    # Default: http://localhost:8000
```

## Menjalankan Tests

### Run All Tests

```bash
python -m unittest discover
```

### Run Specific Test File

```bash
python -m unittest test_login.py -v
python -m unittest test_karyawan.py -v
python -m unittest test_manager.py -v
```

### Run Specific Test Case

```bash
python -m unittest test_login.TestLogin.test_successful_login_manager -v
```

### Run dengan Verbose Output

```bash
python -m unittest discover -v
```

### Generate Test Report

```bash
python -m unittest discover -v > test_results.txt 2>&1
```

## Pola AAA (Arrange-Act-Assert)

Setiap test mengikuti 3 fase:

### 1. Arrange (Setup)
```python
# Arrange - Setup test data dan state awal
self.driver.get(f"{BASE_URL}/login")
```

### 2. Act (Perform Action)
```python
# Act - Perform user interactions
self.driver.find_element(By.ID, "email").send_keys(email)
self.driver.find_element(By.ID, "password").send_keys(password)
self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
```

### 3. Assert (Verify)
```python
# Assert - Verify expected outcomes
self.assert_url_contains("/dashboard")
self.assert_page_contains_text("Dashboard")
```

## Base Test Class - Helper Methods

### Authentication Helpers

```python
# Login dengan email & password
self.login(email, password)

# Logout
self.logout()
```

### Element Interaction Helpers

```python
# Find element dengan explicit wait (tidak throw error)
element = self.find_element_safe(By.ID, "element-id")

# Click element setelah clickable
self.click_element_safe(By.ID, "button-id")

# Fill multiple form fields
form_data = {
    "input[name='name']": "John",
    "input[name='email']": "john@example.com"
}
self.fill_form(form_data)
```

### Assertion Helpers

```python
# Assert element visible
self.assert_element_visible(By.ID, "element-id")

# Assert element text
self.assert_element_text(By.ID, "status", "Active")

# Assert URL contains string
self.assert_url_contains("/dashboard")

# Assert page source contains text
self.assert_page_contains_text("Success message")
```

## Test Coverage

### test_login.py (7 tests)

| Test | Scenario | Status |
|------|----------|--------|
| test_login_page_load_successfully | Guest akses halaman login | ✓ |
| test_successful_login_manager | Manager berhasil login | ✓ |
| test_successful_login_karyawan | Karyawan berhasil login | ✓ |
| test_login_with_invalid_password | Login gagal (password salah) | ✓ |
| test_login_with_invalid_email | Login gagal (email tidak terdaftar) | ✓ |
| test_login_with_empty_email | Login gagal (email kosong) | ✓ |
| test_logout_successfully | User logout berhasil | ✓ |

### test_karyawan.py (8 tests)

| Test | Scenario | Status |
|------|----------|--------|
| test_karyawan_list_page_load | Lihat daftar karyawan | ✓ |
| test_create_karyawan_successfully | Tambah karyawan baru | ✓ |
| test_view_karyawan_detail | Lihat detail karyawan | ✓ |
| test_update_karyawan_successfully | Update data karyawan | ✓ |
| test_delete_karyawan_successfully | Hapus karyawan | ✓ |
| test_search_karyawan_by_nama | Search karyawan by nama | ✓ |
| test_filter_karyawan_by_departemen | Filter by departemen | ✓ |
| test_pagination_karyawan_list | Navigate antar halaman | ✓ |
| test_bulk_delete_karyawan | Hapus multiple karyawan | ✓ |

### test_manager.py (12 tests)

| Test | Scenario | Status |
|------|----------|--------|
| test_manager_dashboard_load | Load manager dashboard | ✓ |
| test_dashboard_statistics_display | Display stat cards | ✓ |
| test_generate_employee_report | Generate employee report | ✓ |
| test_generate_salary_report | Generate salary report | ✓ |
| test_export_report_to_pdf | Export report ke PDF | ✓ |
| test_approve_leave_request | Approve cuti karyawan | ✓ |
| test_reject_leave_request | Reject cuti karyawan | ✓ |
| test_view_department_performance | Lihat performance departemen | ✓ |
| test_assign_task_to_employee | Assign task ke karyawan | ✓ |
| test_mark_task_complete | Mark task complete | ✓ |
| test_view_employee_attendance | Lihat attendance data | ✓ |
| test_filter_attendance_by_date_range | Filter attendance by date | ✓ |
| test_manager_profile_update | Update manager profile | ✓ |

## Troubleshooting

### Error: ChromeDriver tidak ditemukan
```bash
# Update ChromeDriver otomatis dengan webdriver-manager
pip install --upgrade webdriver-manager
```

### Error: Element tidak ditemukan (timeout)
- Pastikan selector CSS/XPath benar
- Gunakan `self.find_element_safe()` untuk handle missing elements
- Increase wait time jika perlu: `self.wait = WebDriverWait(self.driver, 15)`

### Error: Test gagal di login
- Verifikasi credentials di `config.py`
- Pastikan server sedang running
- Cek URL di `config.py` sudah sesuai

### Browser tidak close
- Pastikan `tearDown()` dipanggil
- Manual kill Chrome process: `taskkill /IM chrome.exe /F`

## Best Practices

### 1. Gunakan Helper Methods
```python
# ✓ Good - Menggunakan helper
self.login(MANAGER_EMAIL, MANAGER_PASSWORD)

# ✗ Bad - Hardcode di setiap test
self.driver.get(f"{BASE_URL}/login")
self.driver.find_element(By.ID, "email").send_keys(MANAGER_EMAIL)
```

### 2. Explicit Waits vs Implicit Waits
```python
# ✓ Good - Explicit wait
element = self.wait.until(EC.presence_of_element_located((By.ID, "element")))

# ✗ Bad - Hardcoded sleep
import time
time.sleep(5)
```

### 3. Test Independence
```python
# ✓ Good - Test berdiri sendiri
def test_create_karyawan(self):
    self.login(...)  # Login di setiap test
    
# ✗ Bad - Dependensi antar test
def test_1_login(self): ...
def test_2_create_karyawan(self): ...  # Depends on test_1
```

### 4. Meaningful Assertions
```python
# ✓ Good - Clear & specific
self.assert_element_visible(By.CSS_SELECTOR, ".success-message", "Success message tidak muncul")

# ✗ Bad - Vague
self.assertIn("something", self.driver.page_source)
```

## Continuous Integration

### GitHub Actions Example

```yaml
name: Selenium Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    - name: Set up Python
      uses: actions/setup-python@v2
      with:
        python-version: '3.9'
    
    - name: Install dependencies
      run: |
        pip install selenium webdriver-manager
    
    - name: Run Selenium tests
      run: |
        python -m unittest discover -v
```

## Performance Metrics

| Metric | Target | Status |
|--------|--------|--------|
| Average test execution | < 5 seconds | - |
| Total suite execution | < 3 minutes | - |
| Pass rate | 100% | - |
| Element find success | > 99% | - |

## Next Steps

1. **Implement Page Object Model (POM)**
   - Separate page locators dari test logic
   - Reusable page classes

2. **Add Screenshot on Failure**
   ```python
   except Exception as e:
       self.driver.save_screenshot(f"screenshot_{self.id()}.png")
       raise
   ```

3. **Add Video Recording**
   - Record failed tests untuk debugging

4. **Parallel Test Execution**
   - Use pytest-parallel untuk run tests lebih cepat

5. **Generate HTML Reports**
   - Use HtmlTestRunner untuk prettier reports

## Resources

- [Selenium Python Docs](https://selenium-python.readthedocs.io/)
- [WebDriver API](https://www.w3.org/TR/webdriver/)
- [Selectors Guide](https://selenium-python.readthedocs.io/locating-elements.html)

---

**Last Updated:** January 2025  
**Framework Version:** Selenium 4.x  
**Python Version:** 3.8+
