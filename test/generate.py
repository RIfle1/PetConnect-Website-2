import datetime
import random
import sys


dap_id = 1
dap_date = datetime.datetime(2023,1,1)



for i in range(730):


    dap_bpm = random.randint(80, 100)
    dap_co2 = random.randint(800, 1200)
    dap_DB = random.randint(0, 10)
    dap_Temp = random.randint(37, 40)
    
    


    # dap_bpm += 10
 

 




    print(f"INSERT INTO Data_Device (dapID, dapBPM, dapCO2, dapDecibel, dapTemp, dapDate, Device_devID) VALUES ('{dap_id}', '{dap_bpm}', '{dap_co2}','{dap_DB}','{dap_Temp}','{dap_date}', '98765');")
    dap_id += 1
    dap_date += datetime.timedelta(hours=1)