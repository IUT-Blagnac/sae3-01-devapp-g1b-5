package sae.sae_javafx;

import ReadFile.ReadFile;
import javafx.application.Platform;

import java.util.TimerTask;

//Code d'une tâche gérée par Timer qui met à jour aléatoirement un quartier du PieChart.

public class TaskBackground extends TimerTask {

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbColsOfPieChart : nombre de quartiers dans le PieChart
    public TaskBackground(MainFrameController _mf) {
        this.mf = _mf;
    }

    // Corps de la tâche lorsque elle est activée
    @Override
    public void run() {

        // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
        // Ce Runnable sera exécuté par le thread GUI "dès que possible"
        Platform.runLater(new Runnable() {
            @Override
            public void run() {
                ReadFile.readFile("src/main/resources/mesures.txt");
                //TaskBackground.this.mf.MajGraphesCO2();
                //TaskBackground.this.mf.MajGraphesTEMP();
                //TaskBackground.this.mf.MajGraphesHUM();

            }
        });

        // Documentation de Platform.runLater ()
        // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

        System.out.println("TaskBackground");
    }
}
