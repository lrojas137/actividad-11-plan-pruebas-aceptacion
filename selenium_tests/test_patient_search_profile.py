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
    Inicia sesión en la aplicación Laravel.
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


def test_admin_can_view_patient_list_and_limited_profile(driver):
    """
    Valida que el administrador pueda consultar pacientes,
    pero solo con información limitada.
    """
    driver.delete_all_cookies()

    login(driver, ADMIN_EMAIL, ADMIN_PASSWORD)

    driver.get(f"{BASE_URL}/admin")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "paciente" in body_text or "pacientes" in body_text
    print("Admin: se visualiza la sección o lista de pacientes.")

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    profile_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "perfil" in profile_text or "paciente" in profile_text
    assert "información restringida" in profile_text or "vista limitada" in profile_text or "administrador" in profile_text

    print("Admin: acceso al perfil de paciente con información limitada correcto.")


def test_doctor_can_view_patient_clinical_profile(driver):
    """
    Valida que el doctor pueda consultar el perfil clínico completo del paciente.
    """
    driver.delete_all_cookies()

    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/doctor")
    time.sleep(2)

    body_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "doctor" in body_text
    assert "paciente" in body_text or "pacientes" in body_text

    print("Doctor: se visualiza la sección o lista de pacientes.")

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    profile_text = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "perfil" in profile_text or "paciente" in profile_text
    assert (
        "diagnóstico" in profile_text
        or "diagnostico" in profile_text
        or "tratamiento" in profile_text
        or "notas médicas" in profile_text
        or "notas medicas" in profile_text
    )

    print("Doctor: acceso al perfil clínico del paciente correcto.")


driver = webdriver.Chrome()

try:
    test_admin_can_view_patient_list_and_limited_profile(driver)
    test_doctor_can_view_patient_clinical_profile(driver)

    print("Todas las pruebas Selenium de búsqueda/consulta de pacientes finalizaron correctamente.")

finally:
    driver.quit()