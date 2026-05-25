from selenium import webdriver
from selenium.webdriver.common.by import By
import time

# Prueba rápida para verificar que Selenium puede abrir la aplicación Laravel.
driver = webdriver.Chrome()

try:
    driver.get("http://127.0.0.1:8000/login")
    time.sleep(2)

    # Verifica que el formulario de login tenga campos de email y password.
    email_field = driver.find_element(By.NAME, "email")
    password_field = driver.find_element(By.NAME, "password")

    print("Selenium abrió la aplicación correctamente.")
    print("Campo email encontrado:", email_field is not None)
    print("Campo password encontrado:", password_field is not None)

finally:
    driver.quit()