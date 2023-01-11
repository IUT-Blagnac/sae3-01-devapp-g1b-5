package sae.sae_javafx;

import javafx.application.Platform;

import java.util.TimerTask;

//Code d'une tâche gérée par Timer qui met à jour aléatoirement un quartier du PieChart.

public class TaskBackground extends TimerTask {

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;

    // Nombre de quartiers dans le PieChart
    private int nbColsOfPieChart;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbColsOfPieChart : nombre de quartiers dans le PieChart
    public TaskBackground(MainFrameController _mf, int _nbColsOfPieChart) {
        this.mf = _mf;
        this.nbColsOfPieChart = _nbColsOfPieChart;
    }

    // Corps de la tâche lorsque elle est activée
    @Override
    public void run() {
        // Paramètres de la mise à jour d'un quartier au hasard du PieChart
        int count = (int) (Math.random() * 100);
        int col = (int) (Math.random() * nbColsOfPieChart);

        // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
        // Ce Runnable sera exécuté par le thread GUI "dès que possible"
        Platform.runLater(new Runnable() {
            @Override
            public void run() {
                TaskBackground.this.mf.miseAJourPieChart(count, col);
            }
        });

        // Documentation de Platform.runLater ()
        // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

        System.out.println("TaskBackground");
    }
}
