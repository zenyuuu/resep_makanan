# Selenium AAA Pattern - Panduan Teknis

## Pengenalan AAA Pattern

**AAA (Arrange-Act-Assert)** adalah pattern standard untuk menulis test yang jelas dan maintainable.

Setiap test dibagi menjadi 3 fase:

```
┌─────────────────────────────────────────────────────────┐
│ TEST EXECUTION FLOW                                      │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  1. ARRANGE (Setup)                                     │
│     ├─ Initialize test data                            │
│     ├─ Configure test environment                      │
│     └─ Navigate to initial page/state                 │
│                                                        │
│  2. ACT (Execute)                                      │
│     ├─ Perform user interactions                       │
│     ├─ Click buttons, fill forms                       │
│     └─ Trigger business logic                          │
│                                                        │
│  3. ASSERT (Verify)                                    │
│     ├─ Verify expected outcomes                        │
│     ├─ Check page state/content                        │
│     └─ Validate results                                │
│                                                        │
└─────────────────────────────────────────────────────────┘
```

## Struktur Test - Contoh Lengkap

### Contoh 1: Login Test (Simple)

```python
def test_successful_login_manager(self):
    """
    Scenario: Manager berhasil login
    AAA:
    - Arrange: Siap dengan email & password manager
    - Act: Isi form dan klik login
    - Assert: Redirect ke dashboard, user info muncul
    """
    
    # ═══════════════════════════════════════════════════════════
    # ARRANGE - Setup initial state
    # ═══════════════════════════════════════════════════════════
    # Credentials sudah tersedia di config.py
    email = MANAGER_EMAIL
    password = MANAGER_PASSWORD
    
    # Open login page
    self.driver.get(f"{BASE_URL}/login")
    
    # Verify page loaded
    self.assertIn("Login", self.driver.title)
    
    # ═══════════════════════════════════════════════════════════
    # ACT - Perform user action
    # ═══════════════════════════════════════════════════════════
    # Fill email field
    email_field = self.driver.find_element(By.ID, "email")
    email_field.send_keys(email)
    
    # Fill password field
    password_field = self.driver.find_element(By.ID, "password")
    password_field.send_keys(password)
    
    # Submit form
    submit_button = self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
    submit_button.click()
    
    # ═══════════════════════════════════════════════════════════
    # ASSERT - Verify expected outcome
    # ═══════════════════════════════════════════════════════════
    # Wait for redirect to dashboard
    self.wait.until(EC.url_contains("/dashboard"))
    
    # Verify current URL
    self.assertIn("/dashboard", self.driver.current_url)
    
    # Verify dashboard content
    dashboard_title = self.driver.find_element(By.CSS_SELECTOR, ".page-title")
    self.assertIn("Dashboard", dashboard_title.text)
```

### Contoh 2: CRUD Test (Complex)

```python
def test_create_karyawan_successfully(self):
    """
    Scenario: Manager berhasil menambah karyawan baru
    AAA:
    - Arrange: Setup form dengan data baru
    - Act: Submit karyawan baru
    - Assert: Karyawan tersimpan di database dan visible di list
    """
    
    # ═══════════════════════════════════════════════════════════
    # ARRANGE - Setup test data
    # ═══════════════════════════════════════════════════════════
    
    # Test data untuk karyawan baru
    new_karyawan = {
        "nama": "Budi Santoso",
        "email": "budi@perusahaan.com",
        "departemen": "IT",
        "gaji": "5000000",
    }
    
    # Navigate to create form
    self.driver.get(f"{BASE_URL}/karyawan")
    self.wait.until(EC.presence_of_element_located((By.CSS_SELECTOR, "table")))
    
    # Click "Tambah Karyawan" button
    add_button = self.driver.find_element(By.ID, "btn-tambah-karyawan")
    add_button.click()
    
    # Wait for create form
    self.wait.until(EC.url_contains("/karyawan/create"))
    
    # ═══════════════════════════════════════════════════════════
    # ACT - Fill form dan submit
    # ═══════════════════════════════════════════════════════════
    
    # Fill nama field
    nama_field = self.driver.find_element(By.CSS_SELECTOR, "input[name='nama']")
    nama_field.send_keys(new_karyawan["nama"])
    
    # Fill email field
    email_field = self.driver.find_element(By.CSS_SELECTOR, "input[name='email']")
    email_field.send_keys(new_karyawan["email"])
    
    # Select departemen
    departemen_select = self.driver.find_element(By.CSS_SELECTOR, "select[name='departemen']")
    departemen_select.find_element(By.XPATH, f"//option[text()='{new_karyawan['departemen']}']").click()
    
    # Fill gaji field
    gaji_field = self.driver.find_element(By.CSS_SELECTOR, "input[name='gaji']")
    gaji_field.send_keys(new_karyawan["gaji"])
    
    # Submit form
    submit_button = self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
    submit_button.click()
    
    # ═══════════════════════════════════════════════════════════
    # ASSERT - Verify creation success
    # ═══════════════════════════════════════════════════════════
    
    # Verify redirect to list page
    self.wait.until(EC.url_contains("/karyawan"))
    
    # Verify success message appears
    success_message = self.driver.find_element(By.CSS_SELECTOR, ".alert-success")
    self.assertIn("berhasil", success_message.text.lower())
    
    # Verify new karyawan appears in list
    page_source = self.driver.page_source
    self.assertIn(new_karyawan["nama"], page_source)
    self.assertIn(new_karyawan["email"], page_source)
```

## Wait Strategies

### 1. Implicit Wait
Menunggu element sampai timeout untuk setiap find operation.

```python
# Set di setUp()
self.driver.implicitly_wait(5)  # 5 seconds

# Digunakan secara automatic
element = self.driver.find_element(By.ID, "element")  # Tunggu 5 detik
```

### 2. Explicit Wait (WebDriverWait)
Menunggu sampai condition tertentu terpenuhi.

```python
# Setup
self.wait = WebDriverWait(self.driver, 10)

# Wait sampai element visible
element = self.wait.until(
    EC.visibility_of_element_located((By.ID, "element"))
)

# Wait sampai URL berubah
self.wait.until(EC.url_contains("/dashboard"))

# Wait sampai element clickable
self.wait.until(EC.element_to_be_clickable((By.ID, "button")))
```

### 3. Common Expected Conditions

```python
from selenium.webdriver.support import expected_conditions as EC

# Element ada di DOM
EC.presence_of_element_located((By.ID, "element"))

# Element visible (rendered + displayed)
EC.visibility_of_element_located((By.ID, "element"))

# Element clickable (visible + enabled)
EC.element_to_be_clickable((By.ID, "button"))

# URL contains string
EC.url_contains("/dashboard")

# Title contains string
EC.title_contains("Dashboard")

# Element selected (checkbox/radio)
EC.element_to_be_selected((By.ID, "checkbox"))

# Text present in element
EC.text_to_be_present_in_element((By.ID, "status"), "Active")
```

## Helper Methods Pattern

### Mengapa Helper Methods?

```python
# ✗ Tanpa helper - Code repetition
def test_login_1(self):
    self.driver.get(f"{BASE_URL}/login")
    self.driver.find_element(By.ID, "email").send_keys("user@example.com")
    self.driver.find_element(By.ID, "password").send_keys("password123")
    self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    self.wait.until(EC.url_contains("/dashboard"))

def test_login_2(self):
    self.driver.get(f"{BASE_URL}/login")
    self.driver.find_element(By.ID, "email").send_keys("admin@example.com")
    self.driver.find_element(By.ID, "password").send_keys("admin123")
    self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    self.wait.until(EC.url_contains("/dashboard"))

# ✓ Dengan helper - DRY principle
def login(self, email, password):
    self.driver.get(f"{BASE_URL}/login")
    self.driver.find_element(By.ID, "email").send_keys(email)
    self.driver.find_element(By.ID, "password").send_keys(password)
    self.driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    self.wait.until(EC.url_contains("/dashboard"))

def test_login_1(self):
    self.login("user@example.com", "password123")

def test_login_2(self):
    self.login("admin@example.com", "admin123")
```

## Element Locators

### Types of Selectors

```python
from selenium.webdriver.common.by import By

# 1. ID - Most specific, fastest
element = self.driver.find_element(By.ID, "email")

# 2. NAME - For form fields
element = self.driver.find_element(By.NAME, "email")

# 3. CLASS_NAME - For elements with class
element = self.driver.find_element(By.CLASS_NAME, "btn-primary")

# 4. CSS_SELECTOR - Flexible, powerful
element = self.driver.find_element(By.CSS_SELECTOR, "button.btn-primary")

# 5. XPATH - Most flexible (slowest)
element = self.driver.find_element(By.XPATH, "//button[contains(text(), 'Login')]")

# 6. TAG_NAME - By HTML tag
element = self.driver.find_element(By.TAG_NAME, "button")

# 7. LINK_TEXT - For links
element = self.driver.find_element(By.LINK_TEXT, "Click Here")
```

### CSS Selector Examples

```python
# Class selector
By.CSS_SELECTOR, ".button"

# ID selector
By.CSS_SELECTOR, "#email"

# Attribute selector
By.CSS_SELECTOR, "input[type='submit']"

# Child combinator
By.CSS_SELECTOR, "div.form button.primary"

# Attribute contains
By.CSS_SELECTOR, "button[aria-label*='Login']"

# First of type
By.CSS_SELECTOR, "table tbody tr:first-of-type"

# Nth child
By.CSS_SELECTOR, "tr:nth-child(3)"
```

### XPath Examples

```python
# Contains text
By.XPATH, "//button[contains(text(), 'Login')]"

# Exact text
By.XPATH, "//button[text()='Login']"

# Parent element
By.XPATH, "//input[@id='email']/parent::form"

# Following sibling
By.XPATH, "//label[text()='Email']/following-sibling::input"

# Attribute value
By.XPATH, "//button[@type='submit']"
```

## Test Organization

### Structure Rekomendasi

```
tests/
├── base_test.py              # Base class & helpers
├── config.py                 # Configuration
├── test_authentication.py    # Auth tests
├── test_crud.py              # CRUD tests
├── test_validation.py        # Form validation tests
└── test_edge_cases.py        # Edge case tests
```

### Test Naming Convention

```python
# Format: test_<feature>_<scenario>
def test_login_with_valid_credentials(self):
    pass

def test_login_with_invalid_password(self):
    pass

def test_create_karyawan_with_duplicate_email(self):
    pass

def test_delete_karyawan_with_cascade_delete(self):
    pass
```

## Error Handling

### Try-Catch dalam Tests

```python
def test_with_error_handling(self):
    try:
        # Arrange
        self.driver.get(f"{BASE_URL}/dashboard")
        
        # Act
        element = self.driver.find_element(By.ID, "missing-element")
        element.click()
        
    except NoSuchElementException as e:
        # Take screenshot for debugging
        self.driver.save_screenshot("error_screenshot.png")
        self.fail(f"Element not found: {e}")
    
    except TimeoutException as e:
        self.fail(f"Timeout waiting for element: {e}")
```

### Common Exceptions

```python
from selenium.common.exceptions import (
    NoSuchElementException,
    TimeoutException,
    StaleElementReferenceException,
    ElementNotInteractableException,
)

# Element tidak ditemukan
NoSuchElementException

# Wait timeout
TimeoutException

# Element ada tapi reference invalid
StaleElementReferenceException

# Element ada tapi tidak bisa di-interact
ElementNotInteractableException
```

## Performance Tips

### 1. Minimize Wait Times

```python
# ✗ Bad - Long implicit wait untuk semua operation
self.driver.implicitly_wait(30)

# ✓ Good - Specific wait hanya saat diperlukan
self.driver.implicitly_wait(5)
self.wait = WebDriverWait(self.driver, 10)
```

### 2. Reuse WebDriver Instance

```python
# ✗ Bad - Create new driver setiap test
def test_1(self):
    driver = webdriver.Chrome()

# ✓ Good - Reuse driver dari setUp
def setUp(self):
    self.driver = webdriver.Chrome()
```

### 3. Use Headless Mode untuk CI

```python
options = webdriver.ChromeOptions()
options.add_argument("--headless")  # Faster (no UI rendering)
options.add_argument("--no-sandbox")

driver = webdriver.Chrome(options=options)
```

## Debugging

### 1. Screenshot on Failure

```python
def tearDown(self):
    if sys.exc_info()[0]:  # If exception occurred
        self.driver.save_screenshot(f"{self._testMethodName}_failure.png")
    self.driver.quit()
```

### 2. Print Page Source

```python
def test_debug(self):
    self.driver.get(f"{BASE_URL}/page")
    
    # Print page HTML untuk debug
    print(self.driver.page_source)
    
    # Print specific element
    element = self.driver.find_element(By.ID, "element")
    print(f"Element HTML: {element.get_attribute('outerHTML')}")
```

### 3. Browser Console Logs

```python
def get_browser_logs(self):
    """Get JavaScript console logs"""
    logs = self.driver.get_log('browser')
    for log in logs:
        print(f"{log['level']}: {log['message']}")
```

## Contoh Test Lengkap dengan AAA

```python
class TestKaryawanCRUD(BaseTest):
    
    def setUp(self):
        """Arrange - Setup awal"""
        super().setUp()
        # Pre-condition: Login
        self.login(MANAGER_EMAIL, MANAGER_PASSWORD)
    
    def test_complete_karyawan_workflow(self):
        """
        Scenario: Complete workflow - Create → View → Update → Delete
        """
        
        # ═════════════════════════════════════════════════════
        # ARRANGE 1 - Setup untuk CREATE
        # ═════════════════════════════════════════════════════
        self.driver.get(f"{BASE_URL}/karyawan")
        self.click_element_safe(By.ID, "btn-create")
        
        # ═════════════════════════════════════════════════════
        # ACT 1 - CREATE karyawan
        # ═════════════════════════════════════════════════════
        self.fill_form({
            "input[name='nama']": "Test User",
            "input[name='email']": "test@example.com",
        })
        self.click_element_safe(By.CSS_SELECTOR, "button[type='submit']")
        
        # ═════════════════════════════════════════════════════
        # ASSERT 1 - Verify CREATE
        # ═════════════════════════════════════════════════════
        self.assert_page_contains_text("Test User")
        
        # ═════════════════════════════════════════════════════
        # ARRANGE 2 - Setup untuk UPDATE
        # ═════════════════════════════════════════════════════
        self.click_element_safe(By.CSS_SELECTOR, ".btn-edit:first-of-type")
        
        # ═════════════════════════════════════════════════════
        # ACT 2 - UPDATE karyawan
        # ═════════════════════════════════════════════════════
        self.fill_form({
            "input[name='nama']": "Updated Test User",
        })
        self.click_element_safe(By.CSS_SELECTOR, "button[type='submit']")
        
        # ═════════════════════════════════════════════════════
        # ASSERT 2 - Verify UPDATE
        # ═════════════════════════════════════════════════════
        self.assert_page_contains_text("Updated Test User")
        
        # ═════════════════════════════════════════════════════
        # ARRANGE 3 - Setup untuk DELETE
        # ═════════════════════════════════════════════════════
        self.driver.get(f"{BASE_URL}/karyawan")
        
        # ═════════════════════════════════════════════════════
        # ACT 3 - DELETE karyawan
        # ═════════════════════════════════════════════════════
        self.click_element_safe(By.CSS_SELECTOR, ".btn-delete:first-of-type")
        self.click_element_safe(By.ID, "btn-confirm-delete")
        
        # ═════════════════════════════════════════════════════
        # ASSERT 3 - Verify DELETE
        # ═════════════════════════════════════════════════════
        # (Karyawan tidak ada di list lagi)
        self.assert_page_contains_text("deleted successfully")
```

---

**Summary:**
- Setiap test = Arrange (Setup) → Act (Do) → Assert (Verify)
- Gunakan helper methods untuk code reuse
- Explicit wait lebih baik dari implicit wait
- Selectors: ID > Name > CSS > XPath (dalam hal speed)
- Test harus independent dan repeatable
