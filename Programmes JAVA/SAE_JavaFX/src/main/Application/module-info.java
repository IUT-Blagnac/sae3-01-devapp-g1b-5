module Application {
    requires javafx.controls;
    requires javafx.fxml;
    requires org.yaml.snakeyaml;
    requires com.fasterxml.jackson.annotation;
    requires com.fasterxml.jackson.databind;
    requires com.fasterxml.jackson.dataformat.yaml;


    exports View;
    opens View to javafx.fxml;
    exports Tools;
    opens Tools to javafx.fxml;
    exports Control;
    opens Control to javafx.fxml;
}