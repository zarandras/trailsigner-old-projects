/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.HashMap;
import javax.imageio.ImageIO;
import org.apache.pdfbox.io.IOUtils;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageTree;
import org.apache.pdfbox.pdmodel.graphics.PDXObject;
import org.apache.pdfbox.pdmodel.graphics.form.PDFormXObject;
import org.apache.pdfbox.pdmodel.graphics.image.LosslessFactory;


/**
 *
 * @author Andras
 */
public class PictoCatalog {
    
    private HashMap<String, String> pictoName2FileDict; // picto names to file names to load from
    private HashMap<String, PDXObject> catalogMap; // picto names to preloaded image objects
    
    private String pictoDictFileName; // picto names to file names dictionary file name
    private final PDDocument document; // target document to store the images as resources in

    public HashMap<String, String> getPictoDict() {
        return pictoName2FileDict;
    }

    public PictoCatalog(PDDocument document) {
        this.catalogMap = new HashMap();
        this.document = document;
    }
    
    public String getPictoDictFileName() {
        return pictoDictFileName;
    }

    public void loadPictoDict(String pictoDictFileName) throws PictoLoadException {
        this.pictoDictFileName = pictoDictFileName;
        doLoadPictoDict();
    }

    public double getPictoScale(String name) {
        int percentPos = name.lastIndexOf('%');
        if (percentPos == -1)
            return 1.0;
        return Integer.valueOf(name.substring(percentPos + 1, name.length() - 1)) / 100.0;
    }

    public PDXObject getPictoAsObjectImage(String name) throws PictoLoadException {
        if (name == null || name.isEmpty())
            return null;
        // Delete picto relative size (height, eg. 1.2* in string -> [MÁRIA ÚT%120])
        name = name.replaceFirst("%.*]", "]");
        PDXObject picto = catalogMap.get(name);
        if (picto == null) {
            picto = addPictoByName(name);
        }
        return picto;
    }

    private static PDFormXObject importAsXObject(PDDocument target, PDPage page) throws IOException {
    final InputStream src = page.getContents();
    if (src != null)
        {
            final PDFormXObject xobject = new PDFormXObject(target);

            OutputStream os = xobject.getPDStream().createOutputStream();
            InputStream is = src;
            try
            {
                IOUtils.copy(is, os);
            }
            finally
            {
                IOUtils.closeQuietly(is);
                IOUtils.closeQuietly(os);
            }

            xobject.setResources(page.getResources());
            xobject.setBBox(page.getCropBox());

            return xobject;
        }
        return null;
    }

    private PDXObject addPictoByName(String name) throws PictoLoadException {
        String pictoFilename = pictoName2FileDict.get(name);
        if (pictoFilename == null) {
            throw new PictoLoadException("Az alábbi piktogram nem található: " + name);
        }
        try {
            PDXObject ximage;
            if (pictoFilename.toLowerCase().endsWith(".pdf")) {
                PDDocument source = PDDocument.load(new File(pictoFilename));
                PDPageTree pages = source.getDocumentCatalog().getPages();
                /*PDFormXObject*/ ximage = importAsXObject(document, pages.get(0));
                source.close();
            } else { // bitmap - png, jpg, etc
                BufferedImage tmp_image = ImageIO.read(new File(pictoFilename));
                BufferedImage image = new BufferedImage(tmp_image.getWidth(), tmp_image.getHeight(), BufferedImage.TYPE_4BYTE_ABGR);
                image.createGraphics().drawRenderedImage(tmp_image, null);
                /*PDImageXObject*/ ximage = LosslessFactory.createFromImage(document, image);
            }
            catalogMap.put(name, ximage);
            return ximage;
        } catch (IOException e) {
            throw new PictoLoadException("Hiba az alábbi piktogram betöltésekor: " + name + " - fájlnév: " + pictoFilename + ".", e);
        }
    }

    private void doLoadPictoDict() throws PictoLoadException {
        try (BufferedReader reader = new BufferedReader(new FileReader(new File(pictoDictFileName)))) {
            String inputLine;
            pictoName2FileDict = new HashMap();
            while((inputLine = reader.readLine()) != null) {
                // Ignore empty lines
                //   and comments starting with # :
                if (inputLine.equals("") || inputLine.charAt(0) == '#')
                    continue;
                String[] words = inputLine.split("]\\s*");
                pictoName2FileDict.put(words[0] + "]", words[1]);
            }
        } catch (IOException e) { /* typically FileNotFoundException */
            throw new PictoLoadException("A piktogramkönyvtár fájl nem található vagy nem olvasható: " + pictoDictFileName);
        }
    }
    
}
