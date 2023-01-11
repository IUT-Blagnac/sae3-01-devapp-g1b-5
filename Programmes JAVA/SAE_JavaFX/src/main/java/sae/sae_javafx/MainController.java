package sae.sae_javafx;

import ReadFile.ReadFile;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Scene;
import javafx.scene.chart.LineChart;
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
        final int maxN = 3;
        final int minX = 0;
        final int maxX = 5;
        double minY = Double.MAX_VALUE;
        double maxY = -Double.MAX_VALUE;
        for (int n = 0; n <= maxN; n++) {
            final LineChart.Series series = new LineChart.Series<>();
            series.setName(String.format("n = %d", n));
            for (int x = minX; x <= maxX; x++) {
                final double value = Math.pow(x, n);
                minY = Math.min(minY, value);
                maxY = Math.max(maxY, value);
                final LineChart.Data data = new LineChart.Data(x, value);
                series.getData().add(data);
            }
            linechartC02.getData().add(series);
        }
    }

}