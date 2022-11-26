/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.Color;
import java.io.IOException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.font.PDFont;
import org.apache.pdfbox.pdmodel.graphics.PDXObject;
import org.apache.pdfbox.pdmodel.graphics.form.PDFormXObject;
import org.apache.pdfbox.pdmodel.graphics.image.PDImageXObject;

/**
 *
 * @author Andras
 */
public class SignpostRow {
    
    // signpost configuration:
    private static SpProperties.SprProperties sprProp;

    public static SpProperties.SprProperties getSprProp() {
        return sprProp;
    }

    public static void setSprProp(SpProperties.SprProperties sprProp) {
        SignpostRow.sprProp = sprProp;
    }
    
    private Signpost parentSignpost;

    private String mainText;
    private String pictoText;
    private String kmText;
    private String timeText;
    private String rowComment; // "|" at end indicates horiz line below this row

    // colors for a banner-style row
    Color fgColor = null;
    Color bgColor = null;
    boolean centerAlign = false; // for placemarks - main text centered

    private double mainTextShrinkScale = 1.0;
    
    private int baseX;
    private int baseY;
    private int width;
    private int height;
    
    //computed:
    private int mainTextX;
    private int timeTextX;
    private int kmTextX;
    private int pictoTextX;
    private int mainTextEndX;
    
    public SignpostRow(String mainText, String pictoText, String kmText, String timeText) {
        this.mainText = mainText;
        this.pictoText = pictoText;
        this.kmText = kmText;
        this.timeText = timeText;
    }

    public Color getFgColor() {
        return fgColor;
    }

    public void setFgColor(Color fgColor) {
        this.fgColor = fgColor;
    }

    public Color getBgColor() {
        return bgColor;
    }

    public void setBgColor(Color bgColor) {
        this.bgColor = bgColor;
    }
    
    public SignpostRow() {
        this.mainText = "";
        this.pictoText = "";
        this.kmText = "";
        this.timeText = "";
    }

    public SignpostRow(Signpost parentSignpost) {
        this.parentSignpost = parentSignpost;
        
        this.mainText = "";
        this.pictoText = "";
        this.kmText = "";
        this.timeText = "";
    }

    public void renderToContentStream(Signpost parentSignpost, int baseX, int baseY) throws IOException, PictoLoadException {
        setParentSignpost(parentSignpost);
        setBaseXY(baseX, baseY);
        renderToContentStream();
    }

    public void renderToContentStream() throws IOException, PictoLoadException {
        if (timeText == null)
            timeText = "";
        if (kmText == null)
            kmText = "";
        if (pictoText == null)
            pictoText = "";
        
        PDFont font = parentSignpost.getFont();

        timeTextX = (int) Math.round(width - font.getStringWidth(timeText) / 1000 * sprProp.FONT_SIZE * sprProp.TIME_TEXT_SHRINK_SCALE);
        kmTextX = (int) Math.round(width - sprProp.TIME_TEXT_WIDTH - sprProp.HORIZ_SPACING - font.getStringWidth(kmText) / 1000 * sprProp.FONT_SIZE * sprProp.KM_TEXT_SHRINK_SCALE);
        int mainTextAndPictoEndX = getTextWidthWithPictos(mainText + " " + pictoText, mainTextShrinkScale);
        int mainTextAndPictoMaxWidth = width;
        if (!kmText.isEmpty()) {
            mainTextAndPictoMaxWidth -= sprProp.TIME_TEXT_WIDTH + sprProp.HORIZ_SPACING + sprProp.KM_TEXT_WIDTH + sprProp.HORIZ_SPACING;
        } else if (!timeText.isEmpty()) {
            mainTextAndPictoMaxWidth -= sprProp.TIME_TEXT_WIDTH + sprProp.HORIZ_SPACING;
        }
                
        // shrink text if needed
        while (mainTextAndPictoEndX > mainTextAndPictoMaxWidth) {
            mainTextShrinkScale = mainTextShrinkScale * 4.0 / 5;
            mainTextAndPictoEndX = getTextWidthWithPictos(mainText + " " + pictoText, mainTextShrinkScale);
        }
        mainTextEndX = (int) Math.round(getTextWidthWithPictos(mainText, mainTextShrinkScale));
        //pictoTextX = ((mainTextEndX > (mainTextAndPictoMaxWidth * 2 / 3)) ? mainTextEndX + sprProp.HORIZ_SPACING : (mainTextAndPictoMaxWidth * 2 / 3));
        pictoTextX = mainTextAndPictoMaxWidth - getTextWidthWithPictos(pictoText);
                        
        if (bgColor != null) { // render banner
            getContentStream().setNonStrokingColor(bgColor);
            int bannerExtX1 = ((parentSignpost.getDirection() == Signpost.Direction.LEFT)  ? sprProp.BANNER_EXT_X_ARROW : sprProp.BANNER_EXT_X_NONARROW);
            int bannerExtX2 = ((parentSignpost.getDirection() == Signpost.Direction.RIGHT) ? sprProp.BANNER_EXT_X_ARROW : sprProp.BANNER_EXT_X_NONARROW);
            getContentStream().addRect(baseX - bannerExtX1, baseY - sprProp.BANNER_EXT_Y1, width + bannerExtX1 + bannerExtX2, height + sprProp.BANNER_EXT_Y1 + sprProp.BANNER_EXT_Y2);
            getContentStream().fill();
            getContentStream().closeAndStroke();
        }
        if (isCenterAlign()) {
            mainTextX = (width - mainTextEndX) / 2;
        } else {
            mainTextX = 0;
        }
        renderTextWithPictos(mainText, mainTextX, mainTextShrinkScale);
        renderTextWithPictos(pictoText, pictoTextX);
        renderTextWithPictos(kmText, kmTextX, sprProp.KM_TEXT_SHRINK_SCALE);
        renderTextWithPictos(timeText, timeTextX, sprProp.TIME_TEXT_SHRINK_SCALE);
        
        // render comment or add horiz line if indicated by "|":
        float shrinkScale = 1; // TODO: auto-adjust to fit
        if (getRowComment() != null) {
            if (getRowComment().equals("|")) {
                getContentStream().setStrokingColor(Color.black);
                getContentStream().setLineWidth(sprProp.HORIZ_LINE_WIDTH);
                getContentStream().drawLine(baseX, baseY + sprProp.COMMENT_Y_CENTER_SPACING, baseX + width, baseY + sprProp.COMMENT_Y_CENTER_SPACING);
            } else {
                getContentStream().beginText();
                getContentStream().setTextScaling(shrinkScale, 1, 0, 0);
                getContentStream().setFont(getFont(), sprProp.COMMENT_FONT_SIZE);
                float fontHeight = getFont().getFontDescriptor().getFontBoundingBox().getHeight() / 1000 * sprProp.COMMENT_FONT_SIZE * sprProp.FONT_HEIGHT_CORRECTION_RATIO;
                getContentStream().moveTextPositionByAmount(Math.round(baseX / shrinkScale), baseY + sprProp.COMMENT_Y_CENTER_SPACING - fontHeight / 2);
                getContentStream().drawString(getRowComment());
                getContentStream().endText();
            }
        }
        
    
    }
    
    private int getPictoWidth(PDXObject ximage) {
        if (ximage instanceof PDImageXObject) {
            return sprProp.PICTO_HEIGHT * ((PDImageXObject) ximage).getWidth() / ((PDImageXObject) ximage).getHeight();
        } 
        if (ximage instanceof PDFormXObject) { 
            return Math.round(sprProp.PICTO_HEIGHT * ((PDFormXObject) ximage).getBBox().getWidth() / ((PDFormXObject) ximage).getBBox().getHeight());
        }
        throw new IllegalArgumentException("Unknown object type: Picto image is not type of PDImageXObject or PDFormXObject.");
    }
    
    private int getTextWidthWithPictos(String text) throws IOException, PictoLoadException {
        return getTextWidthWithPictos(text, 1.0);
    }
    
    private int getTextWidthWithPictos(String text, double shrinkScale) throws IOException, PictoLoadException {
        if (text == null) {
            return 0;
        }
        int xx = 0; // current x position
        String t = text;
        String token;
        int l; // substring length
        while (!t.isEmpty()) {
            if (t.charAt(0) == '[') { 
                l = t.indexOf(']');
                token = t.substring(0, l + 1);
                t = t.substring(l + 1);
                
                PDXObject ximage = getPictoCatalog().getPictoAsObjectImage(token);
                int pictoWidth = getPictoWidth(ximage);
                double pictoScale = getPictoCatalog().getPictoScale(token);
                pictoWidth *= pictoScale;
                
                xx += pictoWidth + ((!t.isEmpty() && t.charAt(0)=='[') ? sprProp.HORIZ_SPACING : 0);
            } else { // normal text
                l = t.indexOf('[');
                if (l == -1) {
                    token = t;
                    t = "";
                } else {
                    token = t.substring(0, l);
                    t = t.substring(l);
                }

                xx += (getFont().getStringWidth(token) / 1000 * sprProp.FONT_SIZE + sprProp.HORIZ_SPACING) * shrinkScale;
            }
        }
        return xx;
    }

    private void renderTextWithPictos(String text, int x) throws IOException, PictoLoadException {
        renderTextWithPictos(text, x, 1);
    }
    
    private void renderTextWithPictos(String text, int x, double shrinkScale) throws IOException, PictoLoadException {
        if (text == null) {
            // do nothing
            return;
        }
        getContentStream().setNonStrokingColor(sprProp.TEXT_COLOR);
        getContentStream().setFont(getFont(), sprProp.FONT_SIZE);
        int xx = x; // current x position (relative)
        String t = text;
        String token;
        int l; // substring length
        while (!t.isEmpty()) {
            if (t.charAt(0) == '[') { 
                l = t.indexOf(']');
                token = t.substring(0, l + 1);
                t = t.substring(l + 1);
                
                PDXObject ximage = getPictoCatalog().getPictoAsObjectImage(token);
                int pictoWidth = getPictoWidth(ximage);
                int pictoHeight = sprProp.PICTO_HEIGHT;
                double pictoScale = getPictoCatalog().getPictoScale(token);
                pictoWidth *= pictoScale;
                pictoHeight *= pictoScale;
                drawImageCentered(ximage, baseX + xx + pictoWidth / 2, baseY + height / 2, pictoWidth, pictoHeight);
                
                xx += pictoWidth + ((!t.isEmpty() && t.charAt(0)=='[') ? sprProp.HORIZ_SPACING : 0);
            } else { // normal text
                l = t.indexOf('[');
                if (l == -1) {
                    token = t;
                    t = "";
                } else {
                    token = t.substring(0, l);
                    t = t.substring(l);
                }

                getContentStream().beginText();
                float fontHeight = getFont().getFontDescriptor().getFontBoundingBox().getHeight() / 1000 * sprProp.FONT_SIZE * sprProp.FONT_HEIGHT_CORRECTION_RATIO;
                if (fgColor != null) {
                    getContentStream().setNonStrokingColor(fgColor); // sets text color
                }
                getContentStream().setTextScaling(shrinkScale, 1, 0, 0);
                getContentStream().moveTextPositionByAmount(Math.round((baseX + xx) / shrinkScale), baseY + height / 2 - fontHeight / 2);
                getContentStream().drawString(token);
                getContentStream().endText();
                
                xx += (getFont().getStringWidth(token) / 1000 * sprProp.FONT_SIZE + sprProp.HORIZ_SPACING) * shrinkScale;
            }
        }
    }

    private void drawImageCentered(PDXObject ximage, int centerX, int centerY, int w, int h) throws IOException {
        parentSignpost.drawImageCentered(ximage, centerX, centerY, w, h);
    }
    
    public PDDocument getDocument() {
        return parentSignpost.getDocument();
    }

    public PDPageContentStream getContentStream() {
        return parentSignpost.getContentStream();
    }

    public PictoCatalog getPictoCatalog() {
        return parentSignpost.getPictoCatalog();
    }

    public PDFont getFont() {
        return parentSignpost.getFont();
    }

    public String getMainText() {
        return mainText;
    }

    public void setMainText(String mainText) {
        this.mainText = mainText;
    }

    public String getPictoText() {
        return pictoText;
    }

    public void setPictoText(String pictoText) {
        this.pictoText = pictoText;
    }

    public String getKmText() {
        return kmText;
    }

    public void setKmText(String kmText) {
        this.kmText = kmText;
    }

    public String getTimeText() {
        return timeText;
    }

    public void setTimeText(String timeText) {
        this.timeText = timeText;
    }

    public double getMainTextShrinkRatio() {
        return mainTextShrinkScale;
    }

    public void setMainTextShrinkRatio(double mainTextShrinkRatio) {
        this.mainTextShrinkScale = mainTextShrinkRatio;
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
    
    public int getWidth() {
        return width;
    }

    public void setWidth(int width) {
        this.width = width;
    }

    public int getHeight() {
        return height;
    }

    public void setHeight(int height) {
        this.height = height;
    }

    public Signpost getParentSignpost() {
        return parentSignpost;
    }

    public void setParentSignpost(Signpost parentSignpost) {
        this.parentSignpost = parentSignpost;
    }

    public String getRowComment() {
        return rowComment;
    }

    public void setRowComment(String rowComment) {
        this.rowComment = rowComment;
    }
    
    public boolean isCenterAlign() {
        return centerAlign;
    }

    public void setCenterAlign(boolean centerAlign) {
        this.centerAlign = centerAlign;
    }
    
    @Override
    public String toString() {
        return mainText + "  " + pictoText + "  " + kmText + "  " + timeText + 
                ((rowComment == null || rowComment.isEmpty()) ? "" : "  [" + rowComment + "]");
    }
    
}
