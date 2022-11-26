/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.util.Iterator;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Andras
 */
public class SignpostPrinterMainCLI {
    
    public static String configPropFileName = "config.properties";
    
    public Properties readPropFromStream(String propFileName) throws IOException {
        InputStream inputStream = null;
        Properties prop = new Properties();
        try {
            //inputStream = getClass().getClassLoader().getResourceAsStream(propFileName);
            //if (inputStream != null) {
            //    prop.load(inputStream);
            //} else {
            //    throw new FileNotFoundException("A paraméterfájl (" + propFileName + ") nem található!");
            //}
            
            // read properties from working directory instead of resources:
            inputStream = new FileInputStream(new File(propFileName));
            prop.load(inputStream);
            
        } catch (FileNotFoundException e) {
            throw new IOException("A paraméterfájl (" + propFileName + ") nem található!", e);
        } catch (Exception e) {
            throw new IOException("Hiba a paraméterek beolvasása közben a (" + propFileName + ") fájlból!", e);
        } finally {
            if (inputStream != null)
                inputStream.close();
        }
        return prop;
    }

    public void doMain(String[] args) throws IOException {
        
        // if CLI arguments given, the first one is the config properties file:
        if (args.length >= 1) {
            configPropFileName = args[0];
        }
        // get properties
        InputStream inputStream = null;
        Properties prop = readPropFromStream(configPropFileName);
        
        // default arguments:
        String inputFileName = prop.getProperty("inputFileName");
        String outputFileName = prop.getProperty("outputFileName");
        String pictoDictFileName = prop.getProperty("pictoDictFileName");
        String signpostPropFileName = prop.getProperty("signpostPropFileName");

        // get actual CLI arguments if any (overwrite those read from properties file):
        if (args.length >= 5) {
            pictoDictFileName = args[4];
        }
        if (args.length >= 4) {
            signpostPropFileName = args[3];
        }
        if (args.length >= 3) {
            outputFileName = args[2];
        }
        if (args.length >= 2) {
            inputFileName = args[1];
        }

        // read PDF print properties
        SignpostPdfPrinter.setPdfProperties(
                prop.getProperty("Pdf_PAGE_SIZE"), 
                Integer.valueOf(prop.getProperty("Pdf_INDENT_X")),
                Integer.valueOf(prop.getProperty("Pdf_SPACING_Y"))
        );
        
        
        // read signpost properties
        Properties spProp = readPropFromStream(signpostPropFileName);
        Signpost.setSpPropFromProperties(spProp);

        Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.INFO, "TÁBLANYOMTATÁS - bemeneti és kimeneti fájl: " + inputFileName + " >> " + outputFileName);
        Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.INFO, "Táblaparaméterek: " + signpostPropFileName + ", piktogramkönyvtár: " + pictoDictFileName);
                
        try (
            SignpostXlsxReader input = new SignpostXlsxReader(Logger.getLogger(SignpostPrinterMainCLI.class.getName()), inputFileName);
            SignpostPdfPrinter output = new SignpostPdfPrinter(outputFileName, pictoDictFileName);
        ) {
            Iterator<Signpost> it = input.iterator();
            while (it.hasNext()) {
                try {
                    Signpost sp = it.next();
                    Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.INFO, "Tábla beolvasva: " + sp.toString());
                    output.print(sp);
                    Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.INFO, "Tábla kiírva.\n");
                } catch (IOException | PictoLoadException ex) {
                    Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.SEVERE, "Tábla beolvasási/kiírási hiba!", ex);
                }
            }
        } catch (Throwable e) {
            e.printStackTrace();
        }
    }
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        SignpostPrinterMainCLI main = new SignpostPrinterMainCLI();
        try {
            main.doMain(args);
            /*
            try {
            testWriteToPDF("SignpostsOutput.pdf");
            } catch (IOException | PictoLoadException ex) {
            Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.SEVERE, null, ex);
            }
            */
        } catch (IOException ex) {
            Logger.getLogger(SignpostPrinterMainCLI.class.getName()).log(Level.SEVERE, "A program futása hiba miatt leállt!", ex);
        }
    }
    
    private static void testWriteToPDF(String fileName) throws IOException, PictoLoadException {

        SignpostPdfPrinter output = new SignpostPdfPrinter("SignpostsOutput.pdf", "picto_dict.txt");

        Signpost signpost;

        // add test Signposts - read from file:
        SignpostXlsxReader input = new SignpostXlsxReader(Logger.getLogger(SignpostPrinterMainCLI.class.getName()), "tabla_export_urlap_proba.xlsx");
        for (int i = 0; i < 6 && input.iterator().hasNext(); ++i) {
            signpost = input.iterator().next();
            output.print(signpost);
        }

        // add test signpost #2 built-in:
        signpost = new Signpost(1);
        signpost.setDirection(Signpost.Direction.RIGHT);
        signpost.setTrailmark("[Vm+]");

        signpost.addRow(0, new SignpostRow("82-es főút, Cuha-völgyi [Vm+][P] betérő","[busz]","1,1 km","0:20"));
        signpost.addRow(1, new SignpostRow("Akli [Z] elág.","[természet]","33,0 km","10:45"));
        signpost.addRow(2, new SignpostRow("Zirci Ciszterci Apátság","[központ][kegyhely]","125    km",null)); 
        signpost.addRow(3, new SignpostRow("[MÁRIA ÚT]", null, null, "Csíksomlyó felé"));

        output.print(signpost);

        output.close();
    }

}
