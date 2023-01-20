import json, yaml, os, time, signal


import paho.mqtt.client as mqtt

#fonction qui récupère les données des capteurs et gère les seuils max
def get_data(mqtt, obj, msg):
    global donneeCo2, donneeHum, donneeTemp

    jsonMsg = json.loads(msg.payload.decode('utf-8')) 

    #on récupère les données en C02 du capteur
    donneeCo2 = jsonMsg["object"]["co2"]
    #on récupère les données en température du capteur
    donneeTemp = jsonMsg["object"]["temperature"]
    #on récupère les données en humidité du capteur
    donneeHum = jsonMsg["object"]["humidity"]

    #vérification des données par rapport aux seuils max définis dans le fichier de configuration
    if donneeCo2 > param["seuilMax"]["CO2"]:
        print("Attention, le taux de CO2 dépasse les normes !")
    if donneeTemp > param["seuilMax"]["Temp"]:
        print("Attention, la température dépasse les normes !")
    if donneeHum > param["seuilMax"]["Hum"]:
        print("Attention, le taux d'humidité dépasse les normes !")

    #compteur par rapport à la fréquence choisie dans le fichier de configuration
    signal.alarm(param["frequence"]["valeur"])

#méthode qui se lance chaque fois que le signal alarm est terminé ou intercepté
#elle permet de créer un fichier texte, si besoin, et d'y écrire les données reçu par le capteur
def ecriture(signum, code):
    print("Ecriture des données...")
    #on ouvre le fichier seulement en écriture, on le créer si il n'existe pas, et on remplace ses données à chaque nouvelle
    ouv = os.open("fichier.txt",os.O_WRONLY|os.O_CREAT|os.O_TRUNC,0o644)
    #on écrit les données dans le fichier
    os.write(ouv,bytes(str(donneeCo2), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeTemp), 'utf-8'))
    os.write(ouv,b"-")
    os.write(ouv,bytes(str(donneeHum), 'utf-8'))
    os.close(ouv)
    
print("Connexion au broker MQTT...")

#on ouvre le fichier de config en lecture seulement, et on copie ses données sous forme de dictionnaire dans "param"
with open("config_yaml.yml", "r") as ymlfile:
    param = yaml.safe_load(ymlfile)

client = mqtt.Client()
#on se connecte au broker en fonction des paramêtres serveur du fichier de configuration
client.connect(param["config"]["mqttserver"], param["numPort"]["mqttport"], 600)
client.subscribe(param["config"]["device"])

#on execute la méthode "get_data"
client.on_message = get_data
#on lance la méthode "écriture" lorsque le signal alarm est reçu
signal.signal(signal.SIGALRM, ecriture)
signal.alarm(param["frequence"]["valeur"])

#on boucle à l'infinis le programme ci-dessus
client.loop_forever()
