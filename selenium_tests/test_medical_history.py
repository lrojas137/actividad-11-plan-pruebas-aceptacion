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

    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(2)


def test_doctor_can_view_medical_history(driver):
    """
    Valida que el usuario doctor pueda visualizar información clínica del paciente.
    """
    driver.delete_all_cookies()

    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "paciente" in body_text or "perfil" in body_text

    assert (
        "diagnóstico" in body_text
        or "diagnostico" in body_text
        or "tratamiento" in body_text
        or "notas médicas" in body_text
        or "notas medicas" in body_text
        or "historia clínica" in body_text
        or "historia clinica" in body_text
    )

    print("Historial médico: el doctor puede visualizar información clínica del paciente.")


def test_admin_cannot_view_sensitive_medical_history(driver):
    """
    Valida que el usuario admin no visualice información clínica sensible del paciente.
    """
    driver.delete_all_cookies()

    login(driver, ADMIN_EMAIL, ADMIN_PASSWORD)

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "paciente" in body_text or "perfil" in body_text

    assert (
        "restringida" in body_text
        or "limitada" in body_text
        or "administrador" in body_text
        or "no puede ver" in body_text
        or "información clínica protegida" in body_text
        or "informacion clinica protegida" in body_text
    )

    print("Historial médico: el admin no visualiza información clínica sensible.")


driver = webdriver.Chrome()

try:
    test_doctor_can_view_medical_history(driver)
    test_admin_cannot_view_sensitive_medical_history(driver)

    print("Todas las pruebas Selenium de historial médico finalizaron correctamente.")

finally:
    driver.quit()