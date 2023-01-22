import json, yaml, os, signal
import paho.mqtt.client as mqtt
import threading
import time

donneeCo2 = "-"
donneeHum = "-"
donneeTemp = "-"


def get_data(mqtt, obj, msg):
    global donneeCo2, donneeHum, donneeTemp
    #jsonMsg = json.loads(msg.payload)
    jsonMsg = json.loads(msg.payload.decode('utf-8'))
    donneeCo2 = jsonMsg["object"]["co2"]
    print("Concentration CO2 : ", donneeCo2, " ppm")
    donneeTemp = jsonMsg["object"]["temperature"]
    print("Température : ", donneeTemp, "°C")
    donneeHum = jsonMsg["object"]["humidity"]
    print("Humidité : ", donneeHum, "%")

    if donneeCo2 > param["seuilMax"]["CO2"]:
        print("Attention, le taux de CO2 dépasse les normes !")
    if donneeTemp > param["seuilMax"]["Temp"]:
        print("Attention, la température dépasse les normes !")
    if donneeHum > param["seuilMax"]["Hum"]:
        print("Attention, le taux d'humidité dépasse les normes !")

    #signal.alarm(param["frequence"]["valeur"])
    test(1,1)


def test(signum, code):
    global donneeCo2,donneeHum,donneeTemp
    print("Ecriture des données...")
    ouv = os.open("D:/COURS IUT/SAE3.01/Programmes JAVA/SAE_JavaFX/src/main/resources/mesures.txt",os.O_WRONLY|os.O_CREAT|os.O_TRUNC,0o644)
    os.write(ouv,bytes(str(donneeCo2), 'utf-8'))
    print(donneeCo2)
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeTemp), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeHum), 'utf-8'))
    os.close(ouv)

print("Connexion au broker MQTT...")

with open("D:/COURS IUT/SAE3.01/Programmes JAVA/SAE_JavaFX/src/main/resources/config_yaml.yml", "r") as ymlfile:
    param = yaml.safe_load(ymlfile)



def loop1_10():
    while True:
        time.sleep(param["frequence"]["valeur"])
        print(param["frequence"]["valeur"])
        print("thread ecriture")
        if donneeCo2 != "-":
            test(1,1)



client = mqtt.Client()
client.connect(param["config"]["mqttserver"], param["numPort"]["mqttport"], 600)


#client.subscribe([("application/1/device/24e124128c011586/event/up",0),("application/1/device/24e124128c017943/event/up",2)])
client.subscribe(param["config"]["device"])

#signal.signal(signal.SIGALRM, test)
client.on_message = get_data

threading.Thread(target=loop1_10).start()

client.loop_forever()

