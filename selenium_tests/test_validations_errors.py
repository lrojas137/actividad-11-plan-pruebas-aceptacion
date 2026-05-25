from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

BASE_URL = "http://127.0.0.1:8000"


def test_login_required_fields(driver):
    """
    Verifica que los campos email y password existan
    y sean obligatorios en el formulario de login.
    """
    driver.delete_all_cookies()
    driver.get(f"{BASE_URL}/login")

    wait = WebDriverWait(driver, 10)

    email_input = wait.until(
        EC.presence_of_element_located((By.NAME, "email"))
    )
    password_input = driver.find_element(By.NAME, "password")

    assert email_input.get_attribute("required") is not None
    assert password_input.get_attribute("required") is not None

    print("Validación login: campos email y password son obligatorios.")


def test_invalid_login_credentials(driver):
    """
    Verifica que el sistema rechace credenciales incorrectas.
    """
    driver.delete_all_cookies()
    driver.get(f"{BASE_URL}/login")

    wait = WebDriverWait(driver, 10)

    email_input = wait.until(
        EC.presence_of_element_located((By.NAME, "email"))
    )
    password_input = driver.find_element(By.NAME, "password")

    email_input.clear()
    email_input.send_keys("usuario_invalido@test.com")

    password_input.clear()
    password_input.send_keys("PasswordIncorrecto123")

    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert (
        "credenciales" in body_text
        or "credentials" in body_text
        or "no coinciden" in body_text
        or "incorrect" in body_text
        or "failed" in body_text
    )

    print("Validación login: credenciales incorrectas rechazadas correctamente.")


def test_guest_user_cannot_access_admin_panel(driver):
    """
    Verifica que un usuario no autenticado no pueda ingresar a /admin.
    """
    driver.delete_all_cookies()
    driver.get(f"{BASE_URL}/admin")
    time.sleep(2)

    current_url = driver.current_url.lower()
    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "/login" in current_url or "email" in body_text or "password" in body_text

    print("Validación permisos: usuario no autenticado redirigido al login al intentar entrar a /admin.")


def test_guest_user_cannot_access_patient_profile(driver):
    """
    Verifica que un usuario no autenticado no pueda ingresar a /patients/1.
    """
    driver.delete_all_cookies()
    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    current_url = driver.current_url.lower()
    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "/login" in current_url or "email" in body_text or "password" in body_text

    print("Validación permisos: usuario no autenticado redirigido al login al intentar entrar a /patients/1.")


driver = webdriver.Chrome()

try:
    test_login_required_fields(driver)
    test_invalid_login_credentials(driver)
    test_guest_user_cannot_access_admin_panel(driver)
    test_guest_user_cannot_access_patient_profile(driver)

    print("Todas las pruebas Selenium de validaciones y mensajes de error finalizaron correctamente.")

finally:
    driver.quit()