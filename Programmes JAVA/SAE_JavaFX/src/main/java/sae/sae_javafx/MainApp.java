package sae.sae_javafx;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

import java.io.IOException;

public class MainApp extends Application {
    private BorderPane rootPane;
    private Stage primaryStage;

    @Override
    public void start(Stage stage){
        try {
            this.primaryStage = stage;
            this.rootPane = new BorderPane();
            Scene scene = new Scene(rootPane);

            primaryStage.setScene(scene);
            primaryStage.setTitle("Application Gestion des données");

            FXMLLoader fxmlLoader = new FXMLLoader(MainApp.class.getResource("main.fxml"));

            BorderPane borderPane = fxmlLoader.load();
            MainController ctrl = fxmlLoader.getController();

            ctrl.initContext(primaryStage);
            rootPane.setCenter(borderPane);
            primaryStage.show();


        } catch (IOException e) {
            System.out.println("Ressource FXML non disponible");
            e.printStackTrace();
            System.exit(1);
        }
    }

    public static void main(String[] args) {
        launch();
    }
}