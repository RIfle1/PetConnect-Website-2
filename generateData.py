
# Génerateur de données pour la table Data_Device
# nécessite de la version PYTHON 3.6 pour fonctionner
import datetime
import random
import sys


dap_id = 1
dap_date = datetime.datetime(2023,1,1)


for i in range(565):

    longitude = random.uniform(2,3)
    latitude = random.uniform(48,49)
    
    dap_bpm = random.randint(80, 100)
    dap_co2 = random.randint(800, 1200)
    dap_DB = random.randint(0, 10)
    dap_Temp = random.randint(37, 40)
    
    deviceID = "98765"
    
    
    print(f"INSERT INTO Data_Device (dapID, dapBPM, dapLatitude, dapLongitude, dapCO2, dapDecibel, dapTemp, dapDate, Device_devID) VALUES ('{dap_id}', '{dap_bpm}','{latitude}','{longitude}', '{dap_co2}','{dap_DB}','{dap_Temp}','{dap_date}', '{deviceID}');")
    dap_id += 1
    dap_date += datetime.timedelta(hours=1)
    
    
    # range(730): 1mois de 31 jours
    # range(565): 24 jours + 12h