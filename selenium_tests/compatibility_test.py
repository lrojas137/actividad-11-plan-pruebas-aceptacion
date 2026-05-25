from selenium import webdriver
from selenium.webdriver.common.by import By
import time

BASE_URL = "http://127.0.0.1:8000"

browsers = {
    "Chrome": webdriver.Chrome,
    "Edge": webdriver.Edge
}

for browser_name, browser_driver in browsers.items():
    driver = browser_driver()

    try:
        driver.get(f"{BASE_URL}/login")
        time.sleep(2)

        assert driver.find_element(By.NAME, "email")
        assert driver.find_element(By.NAME, "password")

        print(f"{browser_name}: login cargó correctamente.")

    finally:
        driver.quit()

print("Pruebas de compatibilidad finalizadas correctamente.")