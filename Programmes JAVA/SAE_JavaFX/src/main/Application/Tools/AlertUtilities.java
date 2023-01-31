package Tools;

import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;
import javafx.stage.Stage;

import java.util.Optional;

public class AlertUtilities {

    public static boolean confirmYesCancel(Stage _fen, String _title, String _message, String _content, AlertType _al) {

        if (_al == null) {
            _al = AlertType.INFORMATION;
        }
        Alert alert = new Alert(_al);
        alert.initOwner(_fen);
        alert.setTitle(_title);
        if (_message == null || !_message.equals(""))
            alert.setHeaderText(_message);
        alert.setContentText(_content);

        Optional<ButtonType> option = alert.showAndWait();
        if (option.isPresent() && option.get() == ButtonType.OK) {
            return true;
        }
        return false;
    }

    public static void showAlert(Stage _fen, String _title, String _message, String _content, AlertType _al) {

        if (_al == null) {
            _al = AlertType.INFORMATION;
        }
        Alert alert = new Alert(_al);
        alert.initOwner(_fen);
        alert.setTitle(_title);
        if (_message == null || !_message.equals(""))
            alert.setHeaderText(_message);
        alert.setContentText(_content);

        alert.showAndWait();
    }
}
