package sae.sae_javafx;

import ReadFile.ReadFile;
import javafx.application.Platform;
import org.yaml.snakeyaml.Yaml;

import java.io.File;
import java.io.FileInputStream;
import java.io.InputStream;
import java.util.Map;

// Code d'un thread qui met à jour aléatoirement un quartier du PieChart.

public class RunBackground implements Runnable {

    // Contrôle de l'exécution du thread : isRun == true => s'exécute
    private boolean isRun;

    // Controller pour la mise à jour des PieChart
    private MainFrameController mf;

    // Constructeur
    // _mf : le controller contenant le PieChart
    // _nbColsOfPieChart : nombre de quartiers dans le PieChart
    public RunBackground(MainFrameController _mf) {
        this.mf = _mf;
        this.isRun = true;
    }

    // Corps du thread
    @Override
    public void run() {
        try {
            // Créer un parseur de fichier yml
            Yaml yaml = new Yaml();
            // Charger le fichier yml en mémoire
            InputStream inputStream = new FileInputStream(new File("src/main/resources/config_yaml.yml"));
            // Parser le fichier yml et récupérer les données dans un Map<String, Map>
            Map<String, Map> data = yaml.load(inputStream);

            // Tant que le thread courant s'exécute
            while (this.isRun) {

                // Mise en file d'attente (dans un Runnable) de la mise à jour du PieChart via mf.miseAJourPieChart()
                // Ce Runnable sera exécuté par le thread GUI "dès que possible"
                Platform.runLater(new Runnable() {
                    @Override
                    public void run() {
                        ReadFile.readFile("src/main/resources/mesures.txt");
                        RunBackground.this.mf.MajGraphesCO2();
                        RunBackground.this.mf.MajGraphesTEMP();
                        RunBackground.this.mf.MajGraphesHUM();
                        ;
                    }
                });

                // Documentation de Platform.runLater ()
                // If you need to update a GUI component from a non-GUI thread, you can use that to put your update in a queue and it will be handled by the GUI thread as soon as possible.

                System.out.println("RunBackground");
                int intfrequence = (int) data.get("frequence").get("valeur");
                // Le thread courant se met en attente 3 secondes (il "s'endort" et ne prend plus le processeur)
                try {
                    Thread.sleep(intfrequence*1000);
                } catch (InterruptedException e) {
                }
            }
        } catch (Exception e) {
            System.out.println(e.getMessage());
            System.exit(1);
        }
    }

    // Méthode pour arrêter le thread courant (c'est à dire que la méthode run() se termine)
    public void stopIt() {
        this.isRun = false;
    }

}
