from types import SimpleNamespace

import matplotlib
import requests
import json

url = "http://localhost/Integracja_systemow/REST/main/read"
response = requests.get(url)

try:
    response = requests.get(url)
    json_struct = json.dumps(response.json(), indent=4)

    if (response.status_code == 200):
        array = json.loads(json_struct)

        print(response.json())

        print()
        print(array['project'][0]['title'])
        print(type(array['project'][0]['idproject']))

    elif (response.status_code == 404):
        print("Result not found!")

except requests.ConnectionError as error:
    print(error)
