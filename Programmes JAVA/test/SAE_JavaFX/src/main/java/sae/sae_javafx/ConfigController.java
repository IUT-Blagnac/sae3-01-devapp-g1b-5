package sae.sae_javafx;

import config.Config;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.*;
import org.yaml.snakeyaml.Yaml;

import java.io.*;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import java.util.ResourceBundle;

public class ConfigController implements Initializable {

    @Override
    public void initialize(URL url, ResourceBundle resourceBundle) {
        //this.config = Config.parseFile("src/main/resources/config_yaml.yml");
        readConfigData();
    }
    private Config config;

    @FXML
    private Spinner<Integer> spinnerSeuilC02;

    @FXML
    private Spinner<Integer> spinnerSeuilTemp;

    @FXML
    private Spinner<Integer> spinnerSeuilHum;

    @FXML
    private Spinner<Integer> spinnerFrequence;

    @FXML
    private TextField nomDeServ;

    @FXML
    private TextField numDePort;

    @FXML
    private ChoiceBox<String> device;

    @FXML
    private Button buttonValiderSeuil;

    @FXML
    private Button buttonValiderFrequence;

    public void readConfigData() {
        try {
            // Créer un parseur de fichier yml
            Yaml yaml = new Yaml();
            // Charger le fichier yml en mémoire
            InputStream inputStream = new FileInputStream(new File("src/main/resources/config_yaml.yml"));
            // Parser le fichier yml et récupérer les données dans un Map<String, Map>
            Map<String, Map> data = yaml.load(inputStream);

            // Récupérer les données dans le Map et les affecter aux spinners

            System.out.println(data);
            System.out.println(data.get("config").get("mqttserver"));
            System.out.println(data.get("frequence").get("valeur"));
            System.out.println(data.get("seuilMax").get("CO2"));

            //recup donnée config serv
            String nomServ = (String) data.get("config").get("mqttserver");
            String numPort = (String) data.get("config").get("mqttport").toString();
            String numDevice = (String) data.get("config").get("device");

            //recup frequence
            int intfrequence = (int) data.get("frequence").get("valeur");

            //recup seuil max des données
            int intseuilCO2 = (int) data.get("seuilMax").get("CO2");
            int intseuilTemp = (int) data.get("seuilMax").get("Temp");
            int intseuilHum = (int) data.get("seuilMax").get("Hum");

            this.nomDeServ.setText(nomServ);
            this.numDePort.setText(numPort);
            this.device.getItems().clear();
            this.device.getItems().addAll("Device1","Device2","tous");


            SpinnerValueFactory<Integer> valueFactoryFrequence = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000, intfrequence);
            this.spinnerFrequence.setValueFactory(valueFactoryFrequence);

            SpinnerValueFactory<Integer> valueFactoryCO2 = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 10000,intseuilCO2);
            this.spinnerSeuilC02.setValueFactory(valueFactoryCO2);

            SpinnerValueFactory<Integer> valueFactoryTemp = new SpinnerValueFactory.IntegerSpinnerValueFactory(-100, 100,intseuilTemp);
            this.spinnerSeuilTemp.setValueFactory(valueFactoryTemp);

            SpinnerValueFactory<Integer> valueFactoryHum = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 100,intseuilHum);
            this.spinnerSeuilHum.setValueFactory(valueFactoryHum);

        } catch (Exception e) {
            System.out.println(e.getMessage());
            System.exit(1);
        }
    }

    public String returnValue(){
        String fin = "";
        String saisie = device.getValue();
        if(saisie.equals("Device1")){
            fin = "24e124128c011586";
        } else if (saisie.equals("Device2")) {
            fin = "24e124128c017943";
        } else{
            fin = "+";
        }
        return fin;
    }

    public void actionValider(ActionEvent event) throws FileNotFoundException {

        Map<String, String> dataMapConfig = new HashMap<>();
        dataMapConfig.put("mqttserver", this.nomDeServ.getText());
        dataMapConfig.put("mqttport", this.numDePort.getText());
        String valeur = returnValue();
        dataMapConfig.put("device", "application/1/device/"+valeur+"/event/up");

        Map<String, Integer> dataMapFrequence = new HashMap<>();
        dataMapFrequence.put("valeur", this.spinnerFrequence.getValue());

        Map<String, Integer> dataMapSeuiMax = new HashMap<>();
        dataMapSeuiMax.put("CO2", this.spinnerSeuilC02.getValue());
        dataMapSeuiMax.put("Temp", this.spinnerSeuilTemp.getValue());
        dataMapSeuiMax.put("Hum", this.spinnerSeuilHum.getValue());

        Map<String, Map> dataMap = new HashMap<>();
        dataMap.put("config", dataMapConfig);
        dataMap.put("frequence", dataMapFrequence);
        dataMap.put("seuilMax", dataMapSeuiMax);

        PrintWriter writer = new PrintWriter(new File("src/main/resources/config_yaml.yml"));
        Yaml yaml = new Yaml();
        yaml.dump(dataMap, writer);

        readConfigData();

    }



}

