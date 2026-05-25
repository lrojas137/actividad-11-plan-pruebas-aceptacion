from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

BASE_URL = "http://127.0.0.1:8000"

ADMIN_EMAIL = "admin@test.com"
ADMIN_PASSWORD = "Admin12345!"

DOCTOR_EMAIL = "doctor@test.com"
DOCTOR_PASSWORD = "Doctor12345!"


def login(driver, email, password):
    """
    Inicia sesión en la aplicación usando el formulario de login.
    """
    driver.get(f"{BASE_URL}/login")

    wait = WebDriverWait(driver, 10)

    email_input = wait.until(
        EC.presence_of_element_located((By.NAME, "email"))
    )
    password_input = driver.find_element(By.NAME, "password")

    email_input.clear()
    email_input.send_keys(email)

    password_input.clear()
    password_input.send_keys(password)

    submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
    submit_button.click()

    time.sleep(2)


def test_admin_access(driver):
    """
    Valida que el usuario administrador pueda acceder al panel admin.
    """
    driver.delete_all_cookies()

    login(driver, ADMIN_EMAIL, ADMIN_PASSWORD)

    driver.get(f"{BASE_URL}/admin")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "administrador" in body_text or "admin" in body_text

    print("Prueba admin: acceso al panel administrador correcto.")


def test_doctor_access(driver):
    """
    Valida que el usuario doctor pueda acceder al panel doctor.
    """
    driver.delete_all_cookies()

    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/doctor")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "doctor" in body_text

    print("Prueba doctor: acceso al panel doctor correcto.")


def test_admin_cannot_access_doctor_panel(driver):
    """
    Valida que el usuario administrador no pueda acceder al panel doctor.
    """
    driver.delete_all_cookies()

    login(driver, ADMIN_EMAIL, ADMIN_PASSWORD)

    driver.get(f"{BASE_URL}/doctor")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert (
        "403" in body_text
        or "permiso" in body_text
        or "no autorizado" in body_text
        or "autorización" in body_text
    )

    print("Prueba permisos: admin bloqueado correctamente al intentar entrar al panel doctor.")


def test_doctor_cannot_access_admin_panel(driver):
    """
    Valida que el usuario doctor no pueda acceder al panel administrador.
    """
    driver.delete_all_cookies()

    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/admin")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert (
        "403" in body_text
        or "permiso" in body_text
        or "no autorizado" in body_text
        or "autorización" in body_text
    )

    print("Prueba permisos: doctor bloqueado correctamente al intentar entrar al panel admin.")


driver = webdriver.Chrome()

try:
    test_admin_access(driver)
    test_doctor_access(driver)
    test_admin_cannot_access_doctor_panel(driver)
    test_doctor_cannot_access_admin_panel(driver)

    print("Todas las pruebas Selenium de login y roles finalizaron correctamente.")

finally:
    driver.quit()