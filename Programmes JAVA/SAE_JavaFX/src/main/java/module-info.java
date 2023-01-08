module sae.sae_javafx {
    requires javafx.controls;
    requires javafx.fxml;
    requires org.yaml.snakeyaml;


    opens sae.sae_javafx to javafx.fxml;
    exports sae.sae_javafx;
}