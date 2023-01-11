import json
import yaml
import os
import time

import paho.mqtt.client as mqtt

def get_data(mqtt, obj, msg):
    global param
    jsonMsg = json.loads(msg.payload)
    donneeCo2 = jsonMsg["object"]["co2"]
    print("Concentration CO2 : ", donneeCo2, " ppm")
    donneeTemp = jsonMsg["object"]["temperature"]
    print("Température : ", donneeTemp, "°C")
    donneeHum = jsonMsg["object"]["humidity"]
    print("Humidité : ", donneeHum, "%")

    ouv = os.open("fichier.txt",os.O_WRONLY|os.O_CREAT|os.O_TRUNC,0o644)
    os.write(ouv,bytes(str(donneeCo2), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeTemp), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeHum), 'utf-8'))
    os.close(ouv)

   
print("Connexion au broker MQTT...")

with open("config_yaml.yml", "r") as ymlfile:
    param = yaml.safe_load(ymlfile)

client = mqtt.Client()
client.connect(param["config"]["mqttserver"], param["config"]["mqttport"], 600)


#client.subscribe([("application/1/device/24e124128c011586/event/up",0),("application/1/device/24e124128c017943/event/up",2)])
client.subscribe(param["config"]["device"])

client.on_message = get_data


client.loop_forever()
