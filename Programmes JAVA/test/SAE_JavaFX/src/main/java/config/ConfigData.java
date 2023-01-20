package config;

import java.util.Map;

// Classe de modèle pour représenter les données de votre fichier yml
public class ConfigData {
    private String mqttServer;
    private int mqttPort;
    private String device;
    private int frequence;
    private Map<String, Integer> seuilMax;

    // Getters et setters
    public String getMqttServer() {
        return mqttServer;
    }

    public void setMqttServer(String mqttServer) {
        this.mqttServer = mqttServer;
    }

    public int getMqttPort() {
        return mqttPort;
    }

    public void setMqttPort(int mqttPort) {
        this.mqttPort = mqttPort;
    }

    public String getDevice() {
        return device;
    }

    public void setDevice(String device) {
        this.device = device;
    }

    public int getFrequence() {
        return frequence;
    }

    public void setFrequence(int frequence) {
        this.frequence = frequence;
    }

    public Map<String, Integer> getSeuilMax() {
        return seuilMax;
    }

    public void setSeuilMax(Map<String, Integer> seuilMax) {
        this.seuilMax = seuilMax;
    }
}
