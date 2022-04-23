# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'mainview.ui'
#
# Created by: PyQt5 UI code generator 5.9.2
#
# WARNING! All changes made in this file will be lost!

from PyQt5 import QtCore, QtGui, QtWidgets
from PyQt5.QtWidgets import QInputDialog, QLineEdit, QDialog
import matplotlib.pyplot as plt
import numpy as np
import requests
import json

class Ui_Dialog(object):
    def setupUi(self, Dialog):
        Dialog.setObjectName("Dialog")
        Dialog.resize(402, 174)
        self.buttonBox = QtWidgets.QDialogButtonBox(Dialog)
        self.buttonBox.setGeometry(QtCore.QRect(270, 30, 81, 241))
        self.buttonBox.setOrientation(QtCore.Qt.Vertical)
        self.buttonBox.setStandardButtons(QtWidgets.QDialogButtonBox.Cancel|QtWidgets.QDialogButtonBox.Ok)
        self.buttonBox.setObjectName("buttonBox")
        self.comboBox = QtWidgets.QComboBox(Dialog)
        self.comboBox.setGeometry(QtCore.QRect(80, 40, 151, 31))
        self.comboBox.setObjectName("comboBox")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")
        self.comboBox.addItem("")

        self.retranslateUi(Dialog)
        self.buttonBox.accepted.connect(Dialog.accept)
        self.buttonBox.rejected.connect(Dialog.reject)
        QtCore.QMetaObject.connectSlotsByName(Dialog)

    def retranslateUi(self, Dialog):
        _translate = QtCore.QCoreApplication.translate
        Dialog.setWindowTitle(_translate("Dialog", "Dialog"))
        self.comboBox.setItemText(0, _translate("Dialog", "DOLNOŚLĄSKIE"))
        self.comboBox.setItemText(1, _translate("Dialog", "KUJAWSKO-POMORSKIE"))
        self.comboBox.setItemText(2, _translate("Dialog", "LUBELSKIE"))
        self.comboBox.setItemText(3, _translate("Dialog", "LUBUSKIE"))
        self.comboBox.setItemText(4, _translate("Dialog", "ŁÓDZKIE"))
        self.comboBox.setItemText(5, _translate("Dialog", "MAŁOPOLSKIE"))
        self.comboBox.setItemText(6, _translate("Dialog", "MAZOWIECKIE"))
        self.comboBox.setItemText(7, _translate("Dialog", "OPOLSKIE"))
        self.comboBox.setItemText(8, _translate("Dialog", "PODKARPACKIE"))
        self.comboBox.setItemText(9, _translate("Dialog", "PODLASKIE"))
        self.comboBox.setItemText(10, _translate("Dialog", "POMORSKIE"))
        self.comboBox.setItemText(11, _translate("Dialog", "ŚLĄSKIE"))
        self.comboBox.setItemText(12, _translate("Dialog", "ŚWIĘTOKRZYSKIE"))
        self.comboBox.setItemText(13, _translate("Dialog", "WARMIŃSKO-MAZURSKIE"))
        self.comboBox.setItemText(14, _translate("Dialog", "WIELKOPOLSKIE"))
        self.comboBox.setItemText(15, _translate("Dialog", "ZACHODNIOPOMORSKIE"))


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
        if woj in project['location_place']:
            id.append(location['project'][indx]['idproject'])
    for indx, project in enumerate(finance['project']):
        if project['idproject'] in id:
            yAxis.append(finance['finance'][indx]['total_value'])
            #yAxis = np.array(yAxis)
    for indx, project in enumerate(duration['project']):
        if project['idproject'] in id:
            xAxis.append(duration['duration'][indx]['start'][:7])
            #xAxis = np.array(xAxis)
    return (xAxis, yAxis)


if __name__ == "__main__":
    import sys
    app = QtWidgets.QApplication(sys.argv)
    Dialog = QtWidgets.QDialog()
    ui = Ui_Dialog()
    ui.setupUi(Dialog)
    while True:
        Dialog.show()
        result = Dialog.exec()
        if result == QDialog.Accepted:
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
        else:
            break
    sys.exit(app.exec_())

