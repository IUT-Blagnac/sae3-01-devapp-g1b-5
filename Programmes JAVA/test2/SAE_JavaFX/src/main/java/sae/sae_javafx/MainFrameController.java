package sae.sae_javafx;

import ReadFile.ReadFile;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Scene;
import javafx.scene.chart.*;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;
import org.yaml.snakeyaml.Yaml;

import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;
import java.util.Map;
import java.util.ResourceBundle;
import java.util.Timer;

public class MainFrameController implements Initializable {

    // Fenêtre physique
    private Stage primaryStage;

    // Thread
    private RunBackground rb;

    //Liste des données
    private ArrayList<Double> listeCO2 = new ArrayList<Double>();
    private ArrayList<Double> listeTEMP = new ArrayList<Double>();
    private ArrayList<Double> listeHUM = new ArrayList<Double>();

    // Manipulation de la fenêtre

    public void initContext(Stage _containingStage) {
        this.primaryStage = _containingStage;
        this.configure();
        this.setLabelText();
    }

    public void displayDialog() {

        this.primaryStage.show();

        ReadFile.readFile("src/main/resources/mesures.txt");

            //on définie le graphique pour le CO2
            this.seriesC02 = new XYChart.Series<>();
            yaxisC02.setLabel("C02 (ppm)");
            xaxisC02.setLabel("Temps");
            this.listeCO2.add(Double.parseDouble(ReadFile.dictDonnes.get("C02")));

            //on définie le graphique pour la température
            this.seriesTemp = new XYChart.Series<>();
            yaxisTemp.setLabel("Température (°C)");
            xaxisTemp.setLabel("Temps");
            this.listeTEMP.add(Double.parseDouble(ReadFile.dictDonnes.get("Temp")));

            //on définie le graphique pour l'humidité
            this.seriesHum = new XYChart.Series<>();
            yaxisHum.setLabel("Humidité (%)");
            xaxisHum.setLabel("Temps");
            this.listeHUM.add(Double.parseDouble(ReadFile.dictDonnes.get("Hum")));

            // Création du "code" à exécuter en thread (un Runnable)
            this.rb = new RunBackground(this);

            // Création d'un thread pour exécuter notre code de rb (rb.run())
            Thread t = new Thread(this.rb);

            // Démarrage du thread
            t.start();


    }

    private void configure() {
        this.primaryStage.setOnCloseRequest(e -> this.closeWindow(e));
    }

    // Gestion du stage
    private Object closeWindow(WindowEvent e) {
        this.doQuit();
        e.consume();
        return null;
    }

    @FXML
    private LineChart linechartC02;

    @FXML
    private NumberAxis yaxisC02 = new NumberAxis(0,5000,50);

    @FXML
    private CategoryAxis xaxisC02;

    private XYChart.Series<String, Double> seriesC02;

    @FXML
    private NumberAxis yaxisTemp = new NumberAxis(0,5000,50);

    @FXML
    private CategoryAxis xaxisTemp;

    private XYChart.Series<String, Double> seriesTemp;

    @FXML
    private NumberAxis yaxisHum = new NumberAxis(0,5000,50);

    @FXML
    private CategoryAxis xaxisHum;

    private XYChart.Series<String, Double> seriesHum;


    @FXML
    private LineChart linechartTemp;

    @FXML
    private LineChart linechartHum;

    @FXML
    private Label labelC02;

    @FXML
    private Label labelTemp;

    @FXML
    private Label labelHum;

    @Override
    public void initialize(URL location, ResourceBundle resources) {
    }

    /**
     * Méthode qui va initialiser les 3 labels présent de la page principale
     */
    public void setLabelText() {
        labelC02.setText("C02 : ");
        labelTemp.setText("Température : ");
        labelHum.setText("Humidité : ");
    }
    @FXML
    private Button buttonOpenConfig;

    /**
     * Méthode qui permet d'ouvrir le menu de configuration lors de l'appuis du bouton buttonOpenConfig
     * @param event
     */
    public void openConfig(ActionEvent event) {
        try {
            // Charger le fichier fxml de votre nouvelle interface
            FXMLLoader loader = new FXMLLoader(getClass().getResource("config.fxml"));
            // Créer l'objet du controller associé
            ConfigController controller = loader.getController();
            // Créer la scène de votre nouvelle interface
            Scene scene = new Scene(loader.load());

            // Créer la fenêtre de votre nouvelle interface
            Stage stage = new Stage();
            //stage.getIcons().add(new Image("src/main/resources/Logo.ico"));
            stage.setTitle("Configuration");
            stage.setScene(scene);

            // Afficher votre nouvelle interface
            stage.show();

            //controller.readConfigData();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    /**
     * Méthode qui ferme correctement la page ainsi que le thread lors du cliquage du bouton de fermeture
     */
    @FXML
    private void doQuit() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter Appli Principale",
                "Etes vous sur de vouloir quitter l'appli ?", null, AlertType.CONFIRMATION)) {

            // Arrêt "propre" du thread de mise à jour
            this.rb.stopIt();

            this.primaryStage.close();

            // Optionnel : arrêt de l'application (ici tout s'arrête proprement)
            //System.exit(0);
        }
    }

    /**
     * Méthode de mise à jour du graphe CO2 durant le thread
     */
    public void MajGraphesCO2() {
        //on récupère les données CO2 et on les affiche dans le label
        this.labelC02.setText("C02 : " + ReadFile.dictDonnes.get("C02") + " ppm");

        //On ajoute à chaque fois les données reçues pour faire office de stockage
        this.listeCO2.add(Double.parseDouble(ReadFile.dictDonnes.get("C02")));

        //On créer un new graphe
        this.seriesC02 = new XYChart.Series<>();
        yaxisC02.setLabel("C02 (ppm)");
        xaxisC02.setLabel("Temps");
        this.seriesC02.getData().clear();

        //On parcours notre liste de stockage et on rentre l'ensemble des données dans le new graphe
        for (int i = 1; i < listeCO2.size(); i++) {
            this.seriesC02.getData().add(new XYChart.Data<String, Double>("" + i, listeCO2.get(i)));
        }

        //On écrase l'ancien avec le nouveau
        this.linechartC02.getData().add(this.seriesC02);
    }

    public void MajGraphesHUM() {
        this.labelHum.setText("Humidité : " + ReadFile.dictDonnes.get("Hum")+ " %");
        this.listeHUM.add(Double.parseDouble(ReadFile.dictDonnes.get("Hum")));
        this.seriesHum = new XYChart.Series<>();
        yaxisHum.setLabel("Humidité (%)");
        xaxisHum.setLabel("Temps");
        this.seriesHum.getData().clear();
        for (int j = 1; j < listeHUM.size(); j++) {
            this.seriesHum.getData().add(new XYChart.Data<String, Double>("" + j, listeHUM.get(j)));
        }
        this.linechartHum.getData().add(this.seriesHum);
    }

    public void MajGraphesTEMP() {
        this.labelTemp.setText("Température : " + ReadFile.dictDonnes.get("Temp") + " °C");
        this.listeTEMP.add(Double.parseDouble(ReadFile.dictDonnes.get("Temp")));
        this.seriesTemp = new XYChart.Series<>();
        yaxisTemp.setLabel("Température (°C)");
        xaxisTemp.setLabel("Temps");
        this.seriesTemp.getData().clear();
        for (int k = 1; k < listeTEMP.size(); k++) {
            this.seriesTemp.getData().add(new XYChart.Data<String, Double>("" + k, listeTEMP.get(k)));
        }
        this.linechartTemp.getData().add(this.seriesTemp);
    }
}
