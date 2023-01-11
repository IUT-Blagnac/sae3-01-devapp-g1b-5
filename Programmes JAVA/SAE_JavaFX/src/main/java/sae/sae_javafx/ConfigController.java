package sae.sae_javafx;

import config.ConfigData;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Button;
import javafx.scene.control.Spinner;
import javafx.scene.control.SpinnerValueFactory;
import org.yaml.snakeyaml.Yaml;

import java.io.*;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import java.util.ResourceBundle;

public class ConfigController implements Initializable {

    @FXML
    private Spinner<Integer> spinnerSeuilC02;

    @FXML
    private Spinner<Integer> spinnerSeuilTemp;

    @FXML
    private Spinner<Integer> spinnerSeuilHum;

    @FXML
    private Spinner<Integer> spinnerFrequence;

    @FXML
    private Button buttonValiderSeuil;

    @FXML
    private Button buttonValiderFrequence;

    public ConfigData readConfigData() {
        ConfigData configData = new ConfigData();
        try {
            // Créer un parseur de fichier yml
            Yaml yaml = new Yaml();
            // Charger le fichier yml en mémoire
            InputStream inputStream = new FileInputStream(new File("src/main/resources/config_yaml.yml"));
            // Parser le fichier yml et récupérer les données dans un Map<String, Object>
            Map<String, Object> data = yaml.load(inputStream);
            // Fermez le FileInputStream
            inputStream.close();
            // Récupérer les données dans le Map et les affecter à l'objet ConfigData


            int frequence = (int) data.get("frequence.valeur");
            // Créez un spinner
            spinnerFrequence = new Spinner<>();
            SpinnerValueFactory<Integer> valueFactory = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 100, frequence);
            System.out.println(frequence);
            spinnerFrequence.setValueFactory(valueFactory);

            configData.setMqttServer((String) data.get("config.mqttserver"));
            System.out.println(configData.getMqttServer());
            configData.setMqttPort((int) data.get("config.mqttport"));
            configData.setDevice((String) data.get("config.device"));
            configData.setFrequence((int) data.get("frequence.valeur"));
            Map<String, Integer> seuilMax = new HashMap<>();
            seuilMax.put("CO2", (int) data.get("seuilMax.CO2"));
            seuilMax.put("Temp", (int) data.get("seuilMax.Temp"));
            seuilMax.put("Hum", (int) data.get("seuilMax.Hum"));
            configData.setSeuilMax(seuilMax);
            System.out.println(configData.getFrequence());
        } catch (FileNotFoundException e) {
            throw new RuntimeException(e);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
        return configData;
    }

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        //readConfigData();
    }
}

