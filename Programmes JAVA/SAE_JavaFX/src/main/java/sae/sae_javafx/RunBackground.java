package sae.sae_javafx;

import javafx.application.Platform;

// Code d'un thread qui met à jour aléatoirement un quartier du PieChart.

public class RunBackground implements Runnable {

    // Contrôle de l'exécution du thread : isRun == true => s'exécute
    private boolean isRun;

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;

    // Nombre de quartiers dans le PieChart
    private int nbColsOfPieChart;

    // Valeur de mise à jour du PieChart
    private int count;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbColsOfPieChart : nombre de quartiers dans le PieChart
    public RunBackground(MainFrameController _mf, int _nbColsOfPieChart) {
        this.mf = _mf;
        this.nbColsOfPieChart = _nbColsOfPieChart;
        this.count = 100;
        this.isRun = true;
    }

    // Corps du thread
    @Override
    public void run() {
        // Tant que le thread courant s'exécute
        while (this.isRun) {
            // Paramètres de la mise à jour d'un quartier au hasard du PieChart
            this.count++;
            int col = (int) (Math.random() * this.nbColsOfPieChart);

            // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
            // Ce Runnable sera exécuté par le thread GUI "dès que possible"
            Platform.runLater(new Runnable() {
                @Override
                public void run() {
                    RunBackground.this.mf.miseAJourPieChart(RunBackground.this.count, col);
                }
            });

            // Documentation de Platform.runLater ()
            // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

            System.out.println("RunBackground");

            // Le thread courant se met en attente 3 secondes (il "s'endort" et ne prend plus le processeur)
            try {
                Thread.sleep(3000L);
            } catch (InterruptedException e) {
            }
        }
    }

    // Méthode pour arrêter le thread courant (c'est à dire que la méthode run() se termine)
    public void stopIt() {
        this.isRun = false;
    }

}
