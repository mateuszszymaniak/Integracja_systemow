import matplotlib.pyplot as plt
import numpy as np
import requests
import json


def conn(url):
    try:
        response = requests.get(url)
        json_struct = json.dumps(response.json(), indent=4)

        if (response.status_code == 200):
            array = json.loads(json_struct)

            # print(response.json())
            return array

        elif (response.status_code == 404):
            print("Result not found!")

    except requests.ConnectionError as error:
        print(error)


def woj(location, finance, duration, woj="LUBELSKIE"):
    id = []
    xAxis = []
    yAxis = []

    for indx, project in enumerate(location['project_location']):
        if woj in project['location']:
            id.append(location['project'][indx]['idproject'])
    for indx, project in enumerate(finance['project']):
        if project['idproject'] in id:
            yAxis.append(finance['finance'][indx]['total_value'])
            yAxis = np.array(yAxis)
    for indx, project in enumerate(duration['project']):
        if project['idproject'] in id:
            xAxis.append(duration['duration'][indx]['start'][:4])
            xAxis = np.array(xAxis)
    return (xAxis, yAxis)


url = "http://localhost/Integracja_systemow/REST/main/read/location"
location = conn(url)

url = "http://localhost/Integracja_systemow/REST/main/read/finance"
finance = conn(url)

url = "http://localhost/Integracja_systemow/REST/main/read/duration"
duration = conn(url)
x, y = woj(location, finance, duration, "LUBELSKIE")
# print(arr)

plt.plot(x, y, 'bo-')
plt.show()