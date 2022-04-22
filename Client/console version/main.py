import matplotlib.pyplot as plt
import numpy as np
import requests
import json

def woj(array, woj="LUBELSKIE"):
    tab = np.array()
    tab[0] = np.array()
    tab[1] = np.array()
    for project in array['project_location']:
        if woj in project['location']:
            id = project['idproject_location']


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

        woj(array)

    elif (response.status_code == 404):
        print("Result not found!")

except requests.ConnectionError as error:
    print(error)
