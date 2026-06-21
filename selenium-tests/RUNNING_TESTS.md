# Menjalankan Selenium Tests

Panduan lengkap untuk setup, running, dan debugging Selenium test suite.

## Prerequisite

### System Requirements
- Python 3.8+
- Chrome/Chromium browser
- Internet connection (untuk download ChromeDriver)

### Check Python Version
```bash
python --version
# Expected: Python 3.8.x atau lebih baru
```

## Installation

### 1. Install Python Packages

```bash
# Navigate ke project directory
cd c:\Users\lenovo\selenium-tests

# Install required packages
pip install selenium webdriver-manager

# Or install all at once
pip install -r requirements.txt
```

### requirements.txt
```
selenium==4.15.2
webdriver-manager==4.0.0
```

### 2. Create requirements.txt
```bash
pip freeze > requirements.txt
```

## Configuration

### Update config.py

Edit `config.py` dengan credentials dan URL yang sesuai:

```python
BASE_URL = "http://localhost:8000"

# Manager credentials (untuk manager tests)
MANAGER_EMAIL    = "manager@perusahaan.com"
MANAGER_PASSWORD = "password123"

# Karyawan credentials (untuk karyawan tests)
KARYAWAN_EMAIL    = "andi@perusahaan.com"
KARYAWAN_PASSWORD = "password123"
```

## Starting Application

### Terminal 1: Start Laravel Server

```bash
# Navigate ke Laravel project
cd c:\Users\lenovo\resep_makanan

# Start development server
php artisan serve

# Output expected:
# Laravel development server started: http://127.0.0.1:8000
```

### Verify Server Running

```bash
# Terminal 2: Test connectivity
curl http://localhost:8000

# Or open in browser
http://localhost:8000
```

## Running Tests

### Terminal 2: Run Test Suite

#### 1. Run All Tests

```bash
python -m unittest discover -v
```

**Output Expected:**
```
test_login_page_load_successfully (test_login.TestLogin) ... ok
test_successful_login_manager (test_login.TestLogin) ... ok
test_login_with_invalid_password (test_login.TestLogin) ... ok
...
----------------------------------------------------------------------
Ran 27 tests in 45.234s

OK
```

#### 2. Run Specific Test File

```bash
# Run only login tests
python -m unittest test_login -v

# Run only karyawan tests
python -m unittest test_karyawan -v

# Run only manager tests
python -m unittest test_manager -v
```

#### 3. Run Specific Test Class

```bash
# Run TestLogin class
python -m unittest test_login.TestLogin -v

# Run TestKaryawan class
python -m unittest test_karyawan.TestKaryawan -v
```

#### 4. Run Specific Test Method

```bash
# Run single test
python -m unittest test_login.TestLogin.test_successful_login_manager -v

# Run multiple specific tests
python -m unittest \
    test_login.TestLogin.test_successful_login_manager \
    test_karyawan.TestKaryawan.test_create_karyawan_successfully \
    -v
```

#### 5. Run with Pattern Matching

```bash
# Run tests matching pattern
python -m unittest discover -p "test_login*.py" -v

# Run tests yang contain 'login'
python -m unittest discover -k "login" -v
```

## Test Execution Output

### Verbose Output

```bash
python -m unittest discover -v
```

Output:
```
test_login_page_load_successfully (test_login.TestLogin.test_login_page_load_successfully) ... ok
test_successful_login_manager (test_login.TestLogin.test_successful_login_manager) ... ok
test_login_with_invalid_password (test_login.TestLogin.test_login_with_invalid_password) ... FAIL
...
======================================================================
FAIL: test_login_with_invalid_password (test_login.TestLogin)
----------------------------------------------------------------------
Traceback (most recent call last):
  File "test_login.py", line XX, in test_login_with_invalid_password
    self.assertIn("invalid", self.driver.page_source)
AssertionError: "invalid" not found in page source
----------------------------------------------------------------------

Ran 27 tests in 45.23s

FAILED (failures=1)
```

### Non-Verbose Output

```bash
python -m unittest discover
```

Output:
```
...........................
----------------------------------------------------------------------
Ran 27 tests in 45.23s

OK
```

## Saving Test Results

### Save to Text File

```bash
python -m unittest discover -v > test_results.txt 2>&1

# View results
type test_results.txt
```

### Save with HTML Report

```bash
# Install HtmlTestRunner
pip install html-testrunner

# Create runner script
```

**test_runner.py:**
```python
import unittest
import HtmlTestRunner

if __name__ == '__main__':
    loader = unittest.TestLoader()
    suite = loader.discover('.', pattern='test_*.py')
    
    runner = HtmlTestRunner.HTMLTestRunner(
        output='test_reports',
        verbosity=2
    )
    runner.run(suite)
```

Run:
```bash
python test_runner.py

# Output: test_reports/index.html
```

## Test Execution Timeline

### Example Test Run (27 tests, ~2 min)

```
Test Suite Execution Timeline
════════════════════════════════════════════════════════════════

📋 SETUP PHASE (1-2 sec)
   └─ Parse test files
   └─ Load configuration
   └─ Initialize WebDriver

🧪 TEST PHASE (90-120 sec)
   
   test_login.py (7 tests, ~25 sec)
   ├─ test_login_page_load_successfully ✓ (3s)
   ├─ test_successful_login_manager ✓ (5s)
   ├─ test_successful_login_karyawan ✓ (5s)
   ├─ test_login_with_invalid_password ✓ (4s)
   ├─ test_login_with_invalid_email ✓ (3s)
   ├─ test_login_with_empty_email ✓ (2s)
   └─ test_logout_successfully ✓ (3s)
   
   test_karyawan.py (9 tests, ~45 sec)
   ├─ test_karyawan_list_page_load ✓ (3s)
   ├─ test_create_karyawan_successfully ✓ (8s)
   ├─ test_view_karyawan_detail ✓ (4s)
   ├─ test_update_karyawan_successfully ✓ (7s)
   ├─ test_delete_karyawan_successfully ✓ (5s)
   ├─ test_search_karyawan_by_nama ✓ (4s)
   ├─ test_filter_karyawan_by_departemen ✓ (4s)
   ├─ test_pagination_karyawan_list ✓ (3s)
   └─ test_bulk_delete_karyawan ✓ (5s)
   
   test_manager.py (11 tests, ~50 sec)
   ├─ test_manager_dashboard_load ✓ (3s)
   ├─ test_dashboard_statistics_display ✓ (3s)
   ├─ test_generate_employee_report ✓ (6s)
   └─ ... (8 more tests)

📊 REPORT PHASE (1-2 sec)
   └─ Compile results
   └─ Print summary

════════════════════════════════════════════════════════════════
✓ TOTAL: 27 PASSED in 2m 15s
```

## Debugging Failed Tests

### 1. Check Error Output

```bash
python -m unittest test_login.TestLogin.test_login_with_invalid_password -v
```

Error output akan menunjukkan:
- Test name
- Error message
- Stack trace
- Expected vs actual values

### 2. Enable Debug Mode

Modify `base_test.py`:

```python
def setUp(self):
    super().setUp()
    # Enable debug mode
    self.debug = True
    
    if self.debug:
        print(f"\n🧪 Starting test: {self._testMethodName}")
        print(f"URL: {BASE_URL}")
```

### 3. Add Screenshots on Failure

Modify `tearDown()` in `base_test.py`:

```python
import sys
import os

def tearDown(self):
    # Check if test failed
    if sys.exc_info()[0]:  # If exception occurred
        # Create screenshots directory
        os.makedirs("screenshots", exist_ok=True)
        
        # Save screenshot with test name
        screenshot_path = f"screenshots/{self._testMethodName}_FAILED.png"
        self.driver.save_screenshot(screenshot_path)
        
        print(f"\n📸 Screenshot saved: {screenshot_path}")
    
    self.driver.quit()
```

### 4. Print Page Source

```python
def test_debug_page_source(self):
    self.driver.get(f"{BASE_URL}/dashboard")
    
    # Print entire page source
    print("\n=== PAGE SOURCE ===")
    print(self.driver.page_source)
    
    # Or save to file
    with open("page_source.html", "w") as f:
        f.write(self.driver.page_source)
```

### 5. Check Element Exists

```python
def test_debug_element(self):
    self.driver.get(f"{BASE_URL}/karyawan")
    
    try:
        element = self.find_element_safe(By.ID, "missing-button")
        if element:
            print(f"✓ Element found: {element.tag_name}")
        else:
            print(f"✗ Element not found")
            
            # Print all buttons to debug
            all_buttons = self.driver.find_elements(By.TAG_NAME, "button")
            print(f"Found {len(all_buttons)} buttons on page")
            for btn in all_buttons:
                print(f"  - {btn.get_attribute('id')}: {btn.text}")
    
    except Exception as e:
        print(f"✗ Error: {e}")
```

### 6. Add Console Logging

```python
def test_with_logging(self):
    self.driver.get(f"{BASE_URL}/login")
    
    # Get JavaScript console logs
    logs = self.driver.get_log('browser')
    
    print("\n=== CONSOLE LOGS ===")
    for log in logs:
        print(f"[{log['level']}] {log['message']}")
```

## Common Issues & Solutions

### Issue 1: ChromeDriver not found

**Error:**
```
selenium.common.exceptions.WebDriverException: 
Message: unknown error: Chrome failed to start
```

**Solution:**
```bash
# Make sure Chrome is installed
# Update webdriver-manager
pip install --upgrade webdriver-manager

# Or manually download ChromeDriver from:
# https://chromedriver.chromium.org/
```

### Issue 2: Element not found (timeout)

**Error:**
```
selenium.common.exceptions.TimeoutException: 
Message: timeout waiting for presence of element
```

**Solution:**
```python
# 1. Check selector is correct
# 2. Increase wait time
self.wait = WebDriverWait(self.driver, 15)  # 15 seconds

# 3. Use explicit wait
element = self.wait.until(EC.presence_of_element_located((By.ID, "element")))

# 4. Debug - print page source
print(self.driver.page_source)
```

### Issue 3: Server not running

**Error:**
```
urllib3.exceptions.NewConnectionError: 
Unable to connect to 127.0.0.1:8000
```

**Solution:**
```bash
# Start Laravel server in separate terminal
php artisan serve

# Verify server is running
curl http://localhost:8000
```

### Issue 4: Test data already exists

**Error:**
```
AssertionError: Email already registered
```

**Solution:**
```python
# Use unique email for each test
import uuid

def setUp(self):
    super().setUp()
    self.unique_id = str(uuid.uuid4())[:8]

def test_create_user(self):
    email = f"user_{self.unique_id}@example.com"
    # Use email in test
```

### Issue 5: Stale element reference

**Error:**
```
StaleElementReferenceException: 
Element is no longer attached to the DOM
```

**Solution:**
```python
# Re-find element after page change
# Instead of storing reference:
element = self.find_element_safe(By.ID, "element")
element.click()
element.text  # ✗ May fail if page refreshed

# Better approach:
self.click_element_safe(By.ID, "element")
element = self.find_element_safe(By.ID, "element")  # Re-find
text = element.text  # ✓ OK
```

## Performance Profiling

### Measure Test Execution Time

```python
import time

class BaseTest(unittest.TestCase):
    def setUp(self):
        self.start_time = time.time()
        super().setUp()
    
    def tearDown(self):
        elapsed = time.time() - self.start_time
        print(f"\n⏱️ Test execution time: {elapsed:.2f}s")
        super().tearDown()
```

### Run Tests and Show Timing

```bash
python -m unittest discover -v 2>&1 | grep "Test execution time"
```

## Continuous Integration Setup

### GitHub Actions Workflow

**.github/workflows/selenium-tests.yml:**
```yaml
name: Selenium UI Tests

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=3

    steps:
    - uses: actions/checkout@v3
    
    - name: Set up Python
      uses: actions/setup-python@v4
      with:
        python-version: '3.10'
    
    - name: Install dependencies
      run: |
        python -m pip install --upgrade pip
        pip install selenium webdriver-manager
    
    - name: Set up PHP & Laravel
      run: |
        sudo apt-get update
        sudo apt-get install php php-mysql -y
        composer install
        php artisan key:generate
        php artisan migrate --env=testing
    
    - name: Start Laravel server
      run: php artisan serve &
    
    - name: Run Selenium tests
      run: python -m unittest discover -v
    
    - name: Upload screenshots on failure
      if: failure()
      uses: actions/upload-artifact@v3
      with:
        name: screenshots
        path: screenshots/
```

## Tips & Tricks

### 1. Run Faster

```bash
# Headless mode (no UI = faster)
options.add_argument("--headless")

# Disable images
options.add_argument("--disable-images")

# Disable CSS/JS
options.add_argument("--disable-plugins")
```

### 2. Parallel Execution

```bash
# Install pytest
pip install pytest pytest-xdist

# Run tests in parallel
pytest -n auto
```

### 3. Generate HTML Report

```python
# test_runner.py
import unittest
from html import HTML

if __name__ == '__main__':
    suite = unittest.TestLoader().discover('.')
    runner = unittest.TextTestRunner(verbosity=2)
    runner.run(suite)
```

---

**Quick Reference:**

| Command | Description |
|---------|-------------|
| `python -m unittest discover -v` | Run all tests |
| `python -m unittest test_login -v` | Run login tests |
| `python -m unittest test_login.TestLogin.test_successful_login_manager -v` | Run specific test |
| `python -m unittest discover > results.txt 2>&1` | Save results to file |

**Status Indicators:**
- ✓ Test passed
- ✗ Test failed  
- ⊘ Test skipped
- ⏱️ Test timing
- 📸 Screenshot captured
- 🐍 Python error

---

**Last Updated:** January 2025
