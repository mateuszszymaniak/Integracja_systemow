import matplotlib
import requests

url = "http://localhost/Integracja_systemow/REST/main/read"
response = requests.get(url)
print(response)

print()
print(response.json())