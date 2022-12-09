import json
import yaml
import os

from Crypto.Util.number import long_to_bytes, bytes_to_long


import paho.mqtt.client as mqtt

tabCo2 = []
tabTemp= []
tabHum = []

def get_data(mqtt, obj, msg):
    jsonMsg = json.loads(msg.payload)
    donneeCo2 = jsonMsg["object"]["co2"]
    print("Concentration CO2 : ", donneeCo2, " ppm")
    donneeTemp = jsonMsg["object"]["temperature"]
    print("Température : ", donneeTemp, "°C")
    donneeHum = jsonMsg["object"]["humidity"]
    print("Humidité : ", donneeHum, "%")
    moy_tableaux(donneeCo2, donneeTemp, donneeHum)

    ouv = os.open("fichier.txt",os.O_WRONLY|os.O_CREAT,0o644)
    os.write(ouv,bytes(str(donneeCo2), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeTemp), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeHum), 'utf-8'))
    os.close(ouv)
    
    
def moy_tableaux(dCo2, dTemp, dHum):
    global tabCo2, tabTemp, tabHum 
    tabCo2.append(dCo2)
    tabTemp.append(dTemp)
    tabHum.append(dHum)
    if len(tabCo2) >= 10:
        print(sum(tabCo2[len(tabCo2) - 10 :] ) / 10)
    if len(tabTemp) >= 10:
        print(sum(tabTemp[len(tabTemp) - 10 :] ) / 10)
    if len(tabHum) >= 10:
        print(sum(tabHum[len(tabHum) - 10 :] ) / 10)
    
    
print("Connexion au broker MQTT...")

with open("config_yaml.yml", "r") as ymlfile:
    param = yaml.safe_load(ymlfile)

client = mqtt.Client()
client.connect(param["config"]["mqttserver"], param["config"]["mqttport"], 600)


#client.subscribe([("application/1/device/24e124128c011586/event/up",0),("application/1/device/24e124128c017943/event/up",2)])
client.subscribe(param["config"]["device"])

client.on_message = get_data


client.loop_forever()