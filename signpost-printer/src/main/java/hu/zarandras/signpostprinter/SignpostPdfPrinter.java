/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.geom.AffineTransform;
import java.io.Closeable;
import java.io.IOException;
import java.lang.reflect.Field;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.PDResources;
import org.apache.pdfbox.pdmodel.common.PDRectangle;

/**
 *
 * @author Andras
 */
class SignpostPdfPrinter implements Closeable {

    /**
     *  constants & config properties: pixels to mm-s, pdf page size
     */
    public final double MM_TO_PIXELS = 72.0 / 25.4;
    private static PDRectangle pdf_PAGE_SIZE = PDRectangle.A1;
    private static int pdf_INDENT_X = 50;
    private static int pdf_SPACING_Y = 10;

    private final PictoCatalog pictoCatalog;
    private final String outputFileName;
    private final PDDocument document;
    private PDPageContentStream contentStream;
    private int currentYBasePos;
    
    public static void setPdfProperties(String pageSize, int indentX, int spacingY) {
        try {
            Field field = Class.forName("org.apache.pdfbox.pdmodel.common.PDRectangle").getField(pageSize);
            pdf_PAGE_SIZE = (PDRectangle) field.get(null);
        } catch (Exception e) {
            pdf_PAGE_SIZE = null; // Not defined
        }
        pdf_INDENT_X = indentX;
        pdf_SPACING_Y = spacingY;
    }

    public static PDRectangle getPdf_PAGE_SIZE() {
        return pdf_PAGE_SIZE;
    }

    public static int getPdf_INDENT_X() {
        return pdf_INDENT_X;
    }

    public static int getPdf_SPACING_Y() {
        return pdf_SPACING_Y;
    }
    
    
    SignpostPdfPrinter(String outputFileName, String pictoCatalogFileName) throws PictoLoadException, IOException {

        this.outputFileName = outputFileName;
        this.document = new PDDocument();

        // INIT PICTO CATALOG:
        pictoCatalog = new PictoCatalog(document);
        pictoCatalog.loadPictoDict(pictoCatalogFileName);

        beginNewPage();
    }
    

    public void print(Signpost nextSignpost) throws IOException, PictoLoadException {
        if (currentYBasePos < pdf_SPACING_Y) {
            endCurrentPage();
            beginNewPage();
        }

        // add line:
        //contentStream.setStrokingColor(Color.gray); //?
        //contentStream.setLineWidth(5);
        //contentStream.drawLine(50,550,500,550);

        if (nextSignpost.getPictoCatalog() == null)
            nextSignpost.setPictoCatalog(pictoCatalog);
        
        // print the signpost:
        try {
            nextSignpost.renderToContentStream(contentStream, document, pdf_INDENT_X + ((nextSignpost.getDirection() != Signpost.Direction.LEFT) ? Signpost.getSpProp().ARROW_WIDTH : 0), currentYBasePos);
        } catch (IOException e) {
            throw new IOException("Hiba az alábbi tábla kiírásakor: " + nextSignpost.toString(), e);
        } finally {
            currentYBasePos -= pdf_SPACING_Y + Signpost.getSpProp().SIGNPOST_HEIGHT;
        }
    }

    @Override
    public void close() throws IOException {
            endCurrentPage();
            
            // Save the results and ensure that the document is properly closed:
            document.save(outputFileName);
            document.close();
    }

    private void beginNewPage() throws IOException {
        PDPage page = new PDPage(pdf_PAGE_SIZE);
        //PDRectangle cropBox = page.getCropBox();
        page.setResources(new PDResources()); // for pdf include
        document.addPage( page );

        // Start a new content stream which will "hold" the to be created content
        contentStream = new PDPageContentStream(document, page);

        // transform coordinates so that sizes can be given in mm's instead of pixels
        AffineTransform coordTransform = new AffineTransform();
        coordTransform.scale(MM_TO_PIXELS, MM_TO_PIXELS);
        contentStream.concatenate2CTM(coordTransform);
    
        currentYBasePos = (int) Math.round((page.getCropBox().getHeight() - 2 * pdf_SPACING_Y) / MM_TO_PIXELS) - Signpost.getSpProp().SIGNPOST_HEIGHT;
    }

    private void endCurrentPage() throws IOException {
        // Make sure that the content stream is closed:
        contentStream.close();
    }
    
}
