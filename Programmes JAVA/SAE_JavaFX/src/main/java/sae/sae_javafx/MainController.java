package sae.sae_javafx;

import ReadFile.ReadFile;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Scene;
import javafx.scene.chart.CategoryAxis;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.NumberAxis;
import javafx.scene.chart.XYChart;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ButtonType;
import javafx.scene.control.Label;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;

import java.io.IOException;
import java.net.URL;
import java.util.Optional;
import java.util.ResourceBundle;

public class MainController implements Initializable {


    private Stage primaryStage;

    public void initContext(Stage _containingStage) {
        this.primaryStage = _containingStage;
        this.configure();
    }

    private void configure() {
        this.primaryStage.setOnCloseRequest(e -> this.closeWindow(e));
    }

    // Gestion du stage
    private Object closeWindow(WindowEvent e) {
        this.actionQuitter();
        e.consume();
        return null;
    }

    @Override
    public void initialize(URL location, ResourceBundle resources) {
        setLabelText();
    }

    @FXML
    private void actionQuitter() {

        Alert confirm = new Alert(Alert.AlertType.CONFIRMATION);
        confirm.setTitle("Fermeture de l'application");
        confirm.setHeaderText("Voulez-vous réellement quitter ?");
        confirm.initOwner(this.primaryStage);

        confirm.getButtonTypes().setAll(ButtonType.YES, ButtonType.NO);

        Optional<ButtonType> response = confirm.showAndWait();

        if (response.orElse(null) == ButtonType.YES) {
            this.primaryStage.close();
        } else if (response.orElse(null) == ButtonType.NO) {
            System.out.println("On reste encore un peu");
            confirm.close();
        }
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


    public LineChart getLinechartC02() {
        return linechartC02;
    }

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

    public void setLabelText() {
        ReadFile.readFile("src/main/resources/mesures.txt");
        labelC02.setText("C02 : " + ReadFile.dictDonnes.get("C02") + " ppm");
        labelTemp.setText("Température : " + ReadFile.dictDonnes.get("Temp") + " °C");
        labelHum.setText("Humidité : " + ReadFile.dictDonnes.get("Hum")+ " %");
    }
    @FXML
    private Button buttonOpenConfig;

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

    public void infoDataLineChartC02() {
        this.seriesC02 = new XYChart.Series<>();
        yaxisC02.setLabel("C02 (ppm)");
        xaxisC02.setLabel("Temps");
        this.seriesC02.getData().add(new XYChart.Data<String, Double>("1", Double.parseDouble(ReadFile.dictDonnes.get("C02"))));
        this.linechartC02.getData().add(this.seriesC02);

    }

    public void infoDataLineChartTemp() {
        this.seriesTemp = new XYChart.Series<>();
        yaxisTemp.setLabel("Température (°C)");
        xaxisTemp.setLabel("Temps");
        this.seriesTemp.getData().add(new XYChart.Data<String, Double>("1", Double.parseDouble(ReadFile.dictDonnes.get("Temp"))));
        this.linechartTemp.getData().add(this.seriesTemp);

    }

    public void infoDataLineChartHum() {
        this.seriesHum = new XYChart.Series<>();
        yaxisHum.setLabel("Humidité (%)");
        xaxisHum.setLabel("Temps");
        this.seriesHum.getData().add(new XYChart.Data<String, Double>("1", Double.parseDouble(ReadFile.dictDonnes.get("Hum"))));
        this.linechartHum.getData().add(this.seriesHum);

    }



}