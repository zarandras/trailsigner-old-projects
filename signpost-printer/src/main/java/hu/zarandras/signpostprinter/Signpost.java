/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.Color;
import java.io.File;
import java.io.IOException;
import java.lang.reflect.Field;
import java.util.Properties;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.font.PDType0Font;
import org.apache.pdfbox.pdmodel.graphics.PDXObject;
import org.apache.pdfbox.pdmodel.graphics.form.PDFormXObject;

/**
 *
 * @author Andras
 */
public class Signpost {

    /**
     *  Signpost direction 
     */
    public enum Direction {
        LEFT,
        RIGHT,
        NONE
    };
    
    // signpost configuration:
    private static SpProperties spProp;

    public static SpProperties getSpProp() {
        return spProp;
    }

    public static void setSpProp(SpProperties spProp) {
        Signpost.spProp = spProp;
        SignpostRow.setSprProp(spProp.sprProp);
    }
    
    public static void setSpPropFromProperties(Properties prop) {
        SpProperties spp;
        spp = new SpProperties(prop);
        setSpProp(spp);
    }
    
    // signpost data:
    private int baseX;
    private int baseY;
    
    private int id;
    private String trailmark;
    private Direction direction;
    private SignpostRow[] rows;
    private int rowCount; // SignpostRow count (actual)
    private String footerLeftText;
    private String footerRightText;
    
    // rendering target:
    private PDDocument document;
    private PDPageContentStream contentStream;
    
    // picto catalog
    private PictoCatalog pictoCatalog;

    // font
    private PDFont font = null;
    
    // inner settings (relative positions, computed):
    private int mainPanelX; // main panel relative x position, depends on direction
    private int trailmarkCenterX; // trailmark base x position, depends on direction
    
    public Signpost(int id) {
        this.id = id;
        rows = new SignpostRow[spProp.ROW_COUNT];
        rowCount = 0;
    }
    
    public void addRow(int idx, SignpostRow row) {
        if (rows[idx] == null) {
            rowCount++;
        }
        rows[idx] = row;
        row.setParentSignpost(this);
        row.setHeight(spProp.ROW_HEIGHT);
        row.setWidth(spProp.ROW_WIDTH);
    }

    /**
     *
     * @param contentStream destination stram (pdf box page content stream)
     * @param document destionation pdf document object
     * @param baseX left position on page in pixels
     * @param baseY bottom position on page in pixels
     */
    public void renderToContentStream(PDPageContentStream contentStream, PDDocument document, int baseX, int baseY) throws IOException, PictoLoadException {
        setDocument(document);
        setContentStream(contentStream);
        setBaseXY(baseX, baseY);
        renderToContentStream();
    }
    
    public void renderToContentStream() throws IOException, PictoLoadException {
        // load font if not loaded
        try {
            if (font == null)
                font = PDType0Font.load(document, new File(spProp.FONT_FILE_NAME));
        } catch (IOException e) {
            throw new PictoLoadException("A megadott betűtípus nem tölthető be: " + spProp.FONT_FILE_NAME, e);
        }
        
        // render frame and trail mark
        if (direction == Direction.LEFT) {
            drawSignpostFrameAsLeft();
            drawSignpostTrailmarkIntoArrowPart();
        } else if (direction == Direction.RIGHT) {
            drawSignpostFrameAsRight();
            drawSignpostTrailmarkIntoArrowPart();
        } else { // Direction.NONE
            drawSignpostFrameRect();
        }
        
        // render rows
        for (int i=0; i < spProp.ROW_COUNT; ++i) {
            if (rows[i] == null)
                continue;
            
            rows[i].renderToContentStream(this, baseX + mainPanelX + spProp.ROW_INDENT_X, baseY + 2*spProp.ROW_INDENT_Y + (spProp.ROW_COUNT - i - 1) * (spProp.ROW_HEIGHT + spProp.ROW_INDENT_Y));
        }
      
        // render footer - left and right part in different sizes
        float shrinkScale = 1;
        if (getFooterLeftText() != null) {
            getContentStream().beginText();
            getContentStream().setTextScaling(shrinkScale, 1, 0, 0);
            getContentStream().setFont(getFont(), spProp.FOOTER_LEFT_FONT_SIZE);
            getContentStream().moveTextPositionByAmount(Math.round((baseX + mainPanelX + spProp.ROW_INDENT_X) / shrinkScale), baseY + spProp.ROW_INDENT_Y / 2);
            getContentStream().drawString(getFooterLeftText());
            getContentStream().endText();
        }

        if (getFooterRightText() != null) {
            double w = getFont().getStringWidth(getFooterRightText()) / 1000 * spProp.FOOTER_RIGHT_FONT_SIZE;
            getContentStream().beginText();
            getContentStream().setTextScaling(shrinkScale, 1, 0, 0);
            getContentStream().setFont(getFont(), spProp.FOOTER_RIGHT_FONT_SIZE);
            getContentStream().moveTextPositionByAmount(Math.round((baseX + mainPanelX + spProp.MAIN_PANEL_WIDTH - spProp.ROW_INDENT_X - w) / shrinkScale), baseY + spProp.ROW_INDENT_Y / 2);
            getContentStream().drawString(getFooterRightText());
            getContentStream().endText();
        }
        
        // render extras
        ;
    }
    
    private Color getBGColor () {
        float[] hsbvals = new float[4];
        Color.RGBtoHSB(spProp.BG_COLOR[0], spProp.BG_COLOR[1], spProp.BG_COLOR[2], hsbvals);
        return Color.getHSBColor(hsbvals[0], hsbvals[1], hsbvals[2]);
    }
    
    private void drawSignpostFrameAsRight() throws IOException {
        if (spProp.HAS_BG_COLOR) {
            contentStream.setNonStrokingColor(getBGColor());
            contentStream.addLine(baseX, baseY, baseX + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH + spProp.ARROW_WIDTH, baseY + spProp.SIGNPOST_HEIGHT / 2);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX, baseY);
            contentStream.fill(1);
            contentStream.closeAndStroke();
        }

        // frame:
        if (spProp.HAS_FRAME) {
            contentStream.setLineWidth(1);
            contentStream.setStrokingColor(spProp.FRAME_COLOR);
            contentStream.addLine(baseX, baseY, baseX + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH + spProp.ARROW_WIDTH, baseY + spProp.SIGNPOST_HEIGHT / 2);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX, baseY);
            contentStream.closeAndStroke();
        }

        // mounting panel cutting marks
        if (spProp.HAS_MOUNTING_PANEL) {
            contentStream.setLineWidth(0.5f);
            contentStream.setStrokingColor(spProp.FRAME_COLOR);
            contentStream.addLine(baseX - spProp.MOUNTING_PANEL_WIDTH + spProp.CUTTING_MARK_LENGTH, baseY, baseX - spProp.MOUNTING_PANEL_WIDTH, baseY);
            contentStream.lineTo(baseX - spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.CUTTING_MARK_LENGTH);
            contentStream.addLine(baseX - spProp.MOUNTING_PANEL_WIDTH + spProp.CUTTING_MARK_LENGTH, baseY + spProp.SIGNPOST_HEIGHT, baseX - spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX - spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT - spProp.CUTTING_MARK_LENGTH);
            contentStream.stroke();
        }
    }

    private void drawSignpostFrameAsLeft() throws IOException {
        if (spProp.HAS_BG_COLOR) {
            contentStream.setNonStrokingColor(getBGColor());
            contentStream.addLine(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY, baseX + spProp.ARROW_WIDTH, baseY);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT / 2);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.fill(1);
            contentStream.closeAndStroke();
        }

        // frame
        if (spProp.HAS_FRAME) {
            contentStream.setLineWidth(1);
            contentStream.setStrokingColor(spProp.FRAME_COLOR);
            contentStream.addLine(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY, baseX + spProp.ARROW_WIDTH, baseY);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT / 2);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.closeAndStroke();
        }
        
        // mounting panel cutting marks
        if (spProp.HAS_MOUNTING_PANEL) {
            contentStream.setLineWidth(0.5f);
            contentStream.setStrokingColor(spProp.FRAME_COLOR);
            contentStream.addLine(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH - spProp.CUTTING_MARK_LENGTH, baseY, baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH, baseY);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.CUTTING_MARK_LENGTH);
            contentStream.addLine(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH - spProp.CUTTING_MARK_LENGTH, baseY + spProp.SIGNPOST_HEIGHT, baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.ARROW_WIDTH + spProp.MAIN_PANEL_WIDTH + spProp.MOUNTING_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT - spProp.CUTTING_MARK_LENGTH);
            contentStream.stroke();
        }
    }

    private void drawSignpostFrameRect() throws IOException {
        if (spProp.HAS_BG_COLOR) {
            contentStream.setNonStrokingColor(getBGColor());
            contentStream.addLine(baseX + spProp.MAIN_PANEL_WIDTH, baseY, baseX, baseY);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.fill(1);
            contentStream.closeAndStroke();
        }

        // frame
        if (spProp.HAS_FRAME) {
            contentStream.setLineWidth(1);
            contentStream.setStrokingColor(spProp.FRAME_COLOR);
            contentStream.addLine(baseX + spProp.MAIN_PANEL_WIDTH, baseY, baseX, baseY);
            contentStream.lineTo(baseX, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY + spProp.SIGNPOST_HEIGHT);
            contentStream.lineTo(baseX + spProp.MAIN_PANEL_WIDTH, baseY);
            contentStream.closeAndStroke();
        }
        
        // no mounting panel for rect-shaped signposts
    }

    /**
     * Puts the signpost trail mark into the arrow part (left or right, as this.direction)
     * 
     */
    private void drawSignpostTrailmarkIntoArrowPart() throws IOException, PictoLoadException {
        // add picto
        String[] trailmarks = trailmark.split("\\|");
        PDXObject ximage;
        int cx = baseX + trailmarkCenterX;
        int cy = baseY + spProp.SIGNPOST_HEIGHT / 2;
        int dx;
        switch (trailmarks.length) {
            case 1:
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[0]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx, baseY + spProp.SIGNPOST_HEIGHT / 2, spProp.TRAILMARK_WIDTH, spProp.TRAILMARK_HEIGHT);
                break;
            case 2:
                    dx = spProp.TRAILMARK_WIDTH / 8;
                    if (direction == Direction.RIGHT)
                        dx = -dx;
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[0]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx + dx, cy + spProp.TRAILMARK_HEIGHT * 4 / 5 / 2 + 2, spProp.TRAILMARK_WIDTH * 4 / 5, spProp.TRAILMARK_HEIGHT * 4 / 5);
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[1]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx + dx, cy - spProp.TRAILMARK_HEIGHT * 4 / 5 / 2 - 2, spProp.TRAILMARK_WIDTH * 4 / 5, spProp.TRAILMARK_HEIGHT * 4 / 5);
                break;
            case 3:
            case 4: // no 4 marks... - future feature if needed
                    dx = spProp.TRAILMARK_WIDTH / 6;
                    if (direction == Direction.RIGHT)
                        dx = -dx;
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[0]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx + dx, cy + spProp.TRAILMARK_HEIGHT * 2 / 3 + 3, spProp.TRAILMARK_WIDTH * 2 / 3, spProp.TRAILMARK_HEIGHT * 2 / 3);
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[1]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx + dx, cy, spProp.TRAILMARK_WIDTH * 2 / 3, spProp.TRAILMARK_HEIGHT * 2 / 3);
                    ximage = pictoCatalog.getPictoAsObjectImage(trailmarks[2]);
                    if (ximage != null)
                        drawImageCentered(ximage, cx + dx, cy - spProp.TRAILMARK_HEIGHT * 2 / 3 - 3, spProp.TRAILMARK_WIDTH * 2 / 3, spProp.TRAILMARK_HEIGHT * 2 / 3);
                break;
            default:
                break;
        }
    }
    
    // also called back by SignpostRow at rendering
    protected void drawImageCentered(PDXObject ximage, int centerX, int centerY, int w, int h) throws IOException {
        float wf = w;
        float hf = h;
        // adjust w and h to relative w/h for pdf pictos:
        if (ximage instanceof PDFormXObject) {
            wf /= ((PDFormXObject) ximage).getBBox().getWidth();
            hf /= ((PDFormXObject) ximage).getBBox().getHeight();
        } 
        
        // draw picto
        getContentStream().drawXObject(ximage, centerX - w / 2, centerY - h / 2, wf, hf);

        // add frame:
        /*
        getContentStream().setStrokingColor(Color.black);
        getContentStream().setLineWidth(1);
        getContentStream().addRect(baseX + centerX - w / 2, baseY + centerY - h / 2, w, h);
        getContentStream().closeAndStroke();
        */
    }
    
    public PictoCatalog getPictoCatalog() {
        return pictoCatalog;
    }

    public void setPictoCatalog(PictoCatalog pictoCatalog) {
        this.pictoCatalog = pictoCatalog;
    }

    public int getMainPanelX() {
        return mainPanelX;
    }

    public void setMainPanelX(int mainPanelX) {
        this.mainPanelX = mainPanelX;
    }

    public int getTrailmarkCenterX() {
        return trailmarkCenterX;
    }

    public void setTrailmarkCenterX(int trailmarkCenterX) {
        this.trailmarkCenterX = trailmarkCenterX;
    }

    public PDPageContentStream getContentStream() {
        return contentStream;
    }

    public void setContentStream(PDPageContentStream contentStream) {
        this.contentStream = contentStream;
    }

    public PDDocument getDocument() {
        return document;
    }

    public void setDocument(PDDocument document) {
        this.document = document;
    }

    public int getBaseX() {
        return baseX;
    }

    public void setBaseX(int baseX) {
        this.baseX = baseX;
    }

    public int getBaseY() {
        return baseY;
    }

    public void setBaseY(int baseY) {
        this.baseY = baseY;
    }
    
    /*    
     * @param baseX left position on page in pixels
     * @param baseY bottom position on page in pixels
    */
    public void setBaseXY(int baseX, int baseY) {
        setBaseX(baseX);
        setBaseY(baseY);
    }
    
    public String getTrailmark() {
        return trailmark;
    }

    public void setTrailmark(String trailmark) {
        this.trailmark = trailmark;
    }

    public Direction getDirection() {
        return direction;
    }

    public void setDirection(Direction direction) {
        this.direction = direction;
        mainPanelX = ((direction == Direction.LEFT) ? spProp.ARROW_WIDTH : 0);
        trailmarkCenterX = ((direction == Direction.LEFT) ? spProp.ARROW_WIDTH - spProp.TRAILMARK_WIDTH / 2 : spProp.MAIN_PANEL_WIDTH + spProp.TRAILMARK_WIDTH / 2);
    }
    
    public String getFooterLeftText() {
        return footerLeftText;
    }

    public void setFooterLeftText(String footerLeftText) {
        this.footerLeftText = footerLeftText;
    }

    public String getFooterRightText() {
        return footerRightText;
    }

    public void setFooterRightText(String footerRightText) {
        this.footerRightText = footerRightText;
    }

    public PDFont getFont() {
        return font;
    }

    /* built-in font name!
    public void setFont(PDFont font) {
        this.font = font;
    }
    */
    
    @Override
    public String toString() {
        StringBuilder s = new StringBuilder(rowCount * 64);
        s.append("TÁBLA: #").append(Integer.toString(id)).append("  ");
        s.append((direction == Direction.LEFT) ? "<]" : ((direction == Direction.RIGHT) ? "[>" : "[]" ));
        s.append("  ").append(trailmark).append("\n");
        for (int i = 0; i < rowCount; ++i) {
            s.append(rows[i].toString()).append("\n");
        }
        s.append(footerLeftText).append("   ").append(footerRightText);
        return s.toString();

    }
    
}
