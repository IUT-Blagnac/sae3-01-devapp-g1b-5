package ReadFile;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.util.HashMap;

public class ReadFile {
    public static void main(String[] args) {
        readFile("src/main/resources/mesures.txt");
    }

    public static HashMap<String, String> dictDonnes;

    public static HashMap<String, String> getDictDonnes() {
        return dictDonnes;
    }

    public static void readFile(String pathToFile){
        try {
            BufferedReader reader = new BufferedReader(new FileReader(new File(pathToFile)));
            dictDonnes = new HashMap<>();
            String ligne;
            while((ligne = reader.readLine()) != null){

                    String[] val = ligne.split("-");
                    dictDonnes.put("C02", val[0]);
                    System.out.println(val[0]);
                    dictDonnes.put("Temp", val[1]);
                    System.out.println(val[1]);
                    dictDonnes.put("Hum", val[2]);
                    System.out.println(val[2]);

            }
            System.out.println(dictDonnes.get("C02"));
            System.out.println(dictDonnes);
        } catch (Exception ex){
            System.err.println("Error. "+ex.getMessage());
        }

    }
}
