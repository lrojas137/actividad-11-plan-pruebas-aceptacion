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
    driver.get(f"{BASE_URL}/login")
    wait = WebDriverWait(driver, 10)

    email_input = wait.until(EC.presence_of_element_located((By.NAME, "email")))
    password_input = driver.find_element(By.NAME, "password")

    email_input.clear()
    email_input.send_keys(email)

    password_input.clear()
    password_input.send_keys(password)

    driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
    time.sleep(2)


def smoke_login_page(driver):
    driver.delete_all_cookies()
    driver.get(f"{BASE_URL}/login")

    wait = WebDriverWait(driver, 10)
    wait.until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "password")

    print("SMOKE-001: Página de login cargó correctamente.")


def smoke_admin_access(driver):
    driver.delete_all_cookies()
    login(driver, ADMIN_EMAIL, ADMIN_PASSWORD)

    driver.get(f"{BASE_URL}/admin")
    time.sleep(2)

    body = driver.find_element(By.TAG_NAME, "body").text.lower()
    assert "admin" in body or "administrador" in body

    print("SMOKE-002: Admin accedió correctamente al panel.")


def smoke_doctor_access(driver):
    driver.delete_all_cookies()
    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/doctor")
    time.sleep(2)

    body = driver.find_element(By.TAG_NAME, "body").text.lower()
    assert "doctor" in body

    print("SMOKE-003: Doctor accedió correctamente al panel.")


def smoke_guest_blocked(driver):
    driver.delete_all_cookies()

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    current_url = driver.current_url.lower()
    body = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "/login" in current_url or "email" in body or "password" in body

    print("SMOKE-004: Usuario no autenticado fue redirigido al login.")


def smoke_doctor_patient_profile(driver):
    driver.delete_all_cookies()
    login(driver, DOCTOR_EMAIL, DOCTOR_PASSWORD)

    driver.get(f"{BASE_URL}/patients/1")
    time.sleep(2)

    body = driver.find_element(By.TAG_NAME, "body").text.lower()

    assert "paciente" in body or "perfil" in body
    assert (
        "diagnóstico" in body
        or "diagnostico" in body
        or "tratamiento" in body
        or "notas médicas" in body
        or "notas medicas" in body
    )

    print("SMOKE-005: Doctor visualizó correctamente el perfil clínico del paciente.")


driver = webdriver.Chrome()

try:
    smoke_login_page(driver)
    smoke_admin_access(driver)
    smoke_doctor_access(driver)
    smoke_guest_blocked(driver)
    smoke_doctor_patient_profile(driver)

    print("Smoke test suite crítico finalizado correctamente.")

finally:
    driver.quit()