# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'mainview.ui'
#
# Created by: PyQt5 UI code generator 5.9.2
#
# WARNING! All changes made in this file will be lost!

from tracemalloc import start
from urllib import request, response
from PyQt5 import QtCore, QtGui, QtWidgets
from PyQt5.QtWidgets import QInputDialog, QLineEdit, QDialog, QApplication
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

        self.label = QtWidgets.QLabel(Dialog)
        self.label.setGeometry(QtCore.QRect(100, 10, 120, 20))
        self.label.setObjectName("label")

        self.comboBox = QtWidgets.QComboBox(Dialog)
        self.comboBox.setGeometry(QtCore.QRect(80, 30, 151, 31))
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

        self.label_2 = QtWidgets.QLabel(Dialog)
        self.label_2.setGeometry(QtCore.QRect(100, 80, 120, 20))
        self.label_2.setObjectName("label_2")

        self.radioButton_year = QtWidgets.QRadioButton(Dialog)
        self.radioButton_year.setGeometry(QtCore.QRect(80, 90, 70, 31))
        self.radioButton_year.setText("Roczny")
        self.radioButton_year.setChecked(True)

        self.radioButton_month = QtWidgets.QRadioButton(Dialog)
        self.radioButton_month.setGeometry(QtCore.QRect(160, 90, 100, 31))
        self.radioButton_month.setText("Miesięczny")

        self.retranslateUi(Dialog)
        self.buttonBox.accepted.connect(Dialog.accept)
        self.buttonBox.rejected.connect(Dialog.reject)
        QtCore.QMetaObject.connectSlotsByName(Dialog)

    def retranslateUi(self, Dialog):
        _translate = QtCore.QCoreApplication.translate
        Dialog.setWindowTitle(_translate("Dialog", "Generowanie wykresu dofinansowań unijnych"))
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
        self.label.setText(_translate("Dialog", "Wybierz województwo"))
        self.label_2.setText(_translate("Dialog", "Wybierz rodzaj raportu"))


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


def woj(chart, chosen_chart):
    xAxis = []
    yAxis = []
    time_value_dict = {}

    for indx, project in enumerate(chart["chart"]):
        if (type(project) == dict):
            if(chosen_chart == "Roczny"):
                if project['start'][:4] in time_value_dict:
                    time_value_dict[project['start'][:4]] += round(float(project['total_value']))
                else:
                    time_value_dict[project['start'][:4]] = round(float(project['total_value']))
            else: 
                if project['start'][:7] in time_value_dict:
                    time_value_dict[project['start'][:7]] += round(float(project['total_value']))
                else:
                    time_value_dict[project['start'][:7]] = round(float(project['total_value']))

    for x in time_value_dict:
        # print(f"{x} -> {time_value_dict[x]}")
        xAxis.append(x)
        yAxis.append(time_value_dict[x])
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
            woj_name = str(ui.comboBox.currentText())
            chart_type_year = ui.radioButton_year
            chart_type_month = ui.radioButton_month

            if (chart_type_year.isChecked()):
                chosen_chart = str(ui.radioButton_year.text())
            if (chart_type_month.isChecked()):
                chosen_chart = str(ui.radioButton_month.text())

            rep_woj_name = woj_name.replace('Ś', 'S').replace('Ą', 'A').replace('Ł', 'L').replace('Ó', 'O').replace('Ę', 'E').replace('Ń', 'N')
            if ('-' in rep_woj_name):
                rep_woj_name = rep_woj_name[:rep_woj_name.find('-')]

            url = f"http://localhost/Integracja_systemow/REST/main/read/chart/{rep_woj_name}"
            chart = conn(url)

            x, y = woj(chart, chosen_chart)

            # disable science numeric
            plt.ticklabel_format(style='plain')
            # rotate data on axis (up-down)
            plt.xticks(rotation=90)
            
            #fullscreen
            figManager = plt.get_current_fig_manager()
            figManager.window.showMaximized()

            suptitle = f"{chosen_chart} wykres dofinansowań unijnych"
            title = f"Wojewodztwo: {woj_name}"
            plt.suptitle(suptitle)
            plt.title(title)

            plt.ylabel("Kwota dofinansowania w zł")
            if (chosen_chart == "Roczny"):
                plt.xlabel("Lata")
            else:
                plt.xlabel("Miesiące")

            plt.plot(x, y, 'bo-')
            plt.show()
        else:
            QApplication.quit
            sys.exit()
    QApplication.quit
    sys.exit()
