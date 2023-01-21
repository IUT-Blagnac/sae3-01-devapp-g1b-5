package View;

import Model.Config;
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

//classe de manipulation de la fenêtre de configuration des données
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

    /**
     * Méthode qui va lire les paramêtres présent dans le fichier de configuration et pré-remplir les champs pour chaque donnée
     * dans la page de modification des paramêtres de configuration
     */
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
            String numDevice = (String) data.get("config").get("device");

            //recup du num de port
            String numPort = (String) data.get("numPort").get("mqttport").toString();

            //recup frequence
            int intfrequence = (int) data.get("frequence").get("valeur");

            //recup seuil max des données
            int intseuilCO2 = (int) data.get("seuilMax").get("CO2");
            int intseuilTemp = (int) data.get("seuilMax").get("Temp");
            int intseuilHum = (int) data.get("seuilMax").get("Hum");

            //on pré-replis les champs nom de serv, num de port et device
            this.nomDeServ.setText(nomServ);
            this.numDePort.setText(numPort);
            this.device.getItems().clear();
            this.device.getItems().addAll("Device1","Device2","TOUS");

            //on pré-remplis le champs de la fréquence
            SpinnerValueFactory<Integer> valueFactoryFrequence = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 1000, intfrequence);
            this.spinnerFrequence.setValueFactory(valueFactoryFrequence);

            //on pré-remplis le champs pour le CO2
            SpinnerValueFactory<Integer> valueFactoryCO2 = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 10000,intseuilCO2);
            this.spinnerSeuilC02.setValueFactory(valueFactoryCO2);

            //on pré-remplis le champs pour la température
            SpinnerValueFactory<Integer> valueFactoryTemp = new SpinnerValueFactory.IntegerSpinnerValueFactory(-100, 100,intseuilTemp);
            this.spinnerSeuilTemp.setValueFactory(valueFactoryTemp);

            //on pré-remplis le champs pour l'humidité'
            SpinnerValueFactory<Integer> valueFactoryHum = new SpinnerValueFactory.IntegerSpinnerValueFactory(0, 100,intseuilHum);
            this.spinnerSeuilHum.setValueFactory(valueFactoryHum);

        } catch (Exception e) {
            System.out.println(e.getMessage());
            System.exit(1);
        }
    }

    /**
     * Méthode qui va retourner le numéro de device en fonction des choix de l'utilisateur dans la choiceBox "device"
     * @return String Le numéro de device correspondant ou "+" pour symboliser l'ensemble des device
     */
    public String returnValue(){
        String fin = "+";
        String saisie = device.getValue();
        if(saisie != null) {
            switch (saisie) {
                case "Device1":
                    fin = "24e124128c011586";
                case "Device2":
                    fin = "24e124128c017943";
                case "TOUS":
                    fin = "+";
            }
        }
        return fin;
    }

    /**
     * Méthode qui va se lancer lorsque l'on clique sur le bouton "Valider" dans la page de configuration des données
     * Cette méthode va écraser l'ancien fichier de configuration avec un nouveau identique, comportant les paramêtres modifiés par l'utilisateur
     * @param event
     * @throws FileNotFoundException
     */
    public void actionValider(ActionEvent event) throws FileNotFoundException {

        Map<String, String> dataMapConfig = new HashMap<>();
        dataMapConfig.put("mqttserver", this.nomDeServ.getText());
        String valeur = returnValue();
        dataMapConfig.put("device", "application/1/device/"+valeur+"/event/up");

        Map<String, Integer> dataMapPort = new HashMap<>();
        dataMapPort.put("mqttport", Integer.parseInt(this.numDePort.getText()));

        Map<String, Integer> dataMapFrequence = new HashMap<>();
        dataMapFrequence.put("valeur", this.spinnerFrequence.getValue());

        Map<String, Integer> dataMapSeuiMax = new HashMap<>();
        dataMapSeuiMax.put("CO2", this.spinnerSeuilC02.getValue());
        dataMapSeuiMax.put("Temp", this.spinnerSeuilTemp.getValue());
        dataMapSeuiMax.put("Hum", this.spinnerSeuilHum.getValue());

        Map<String, Map> dataMap = new HashMap<>();
        dataMap.put("config", dataMapConfig);
        dataMap.put("numPort",dataMapPort);
        dataMap.put("frequence", dataMapFrequence);
        dataMap.put("seuilMax", dataMapSeuiMax);

        PrintWriter writer = new PrintWriter(new File("src/main/resources/config_yaml.yml"));
        Yaml yaml = new Yaml();
        yaml.dump(dataMap, writer);

        readConfigData();

    }



}

