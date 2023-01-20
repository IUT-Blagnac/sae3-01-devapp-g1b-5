module sae.sae_javafx {
    requires javafx.controls;
    requires javafx.fxml;
    requires org.yaml.snakeyaml;
    requires com.fasterxml.jackson.annotation;
    requires com.fasterxml.jackson.databind;
    requires com.fasterxml.jackson.dataformat.yaml;


    opens sae.sae_javafx to javafx.fxml;
    exports sae.sae_javafx;
}