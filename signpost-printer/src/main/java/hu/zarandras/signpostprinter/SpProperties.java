/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.Color;
import java.lang.reflect.Field;
import java.util.Properties;

/**
 *
 * @author Andras
 */
public class SpProperties {
    
    /**
     * Signpost Rows properties subclass:
     */
    public static class SprProperties {
        public Color TEXT_COLOR;
        public int FONT_SIZE;
        public float FONT_HEIGHT_CORRECTION_RATIO;

        public int HORIZ_SPACING;
        public int PICTO_HEIGHT;
        public int COMMENT_FONT_SIZE;
        public int COMMENT_Y_CENTER_SPACING;
        public int HORIZ_LINE_WIDTH;

        // banner-style row banner extension:
        public int BANNER_EXT_X_ARROW;
        public int BANNER_EXT_Y1;
        public int BANNER_EXT_X_NONARROW;
        public int BANNER_EXT_Y2;

        public int TIME_TEXT_WIDTH;
        public int KM_TEXT_WIDTH;
        public double TIME_TEXT_SHRINK_SCALE;
        public double KM_TEXT_SHRINK_SCALE;
    }
    
    /**
     *  signpost total height
     */
    public int SIGNPOST_HEIGHT;
    /**
     *  main signpost panel width in pixels
     */
    public int MAIN_PANEL_WIDTH;
    /**
     *  arrow part width in pixels
     */
    public int ARROW_WIDTH;
    /**
     *  total signpost width
     */
    public int SIGNPOST_WIDTH;
    /**
     *  row x position offset in pixels
     */
    public int ROW_COUNT;
    public int ROW_INDENT_X;
    public int ROW_INDENT_Y; // bottom: 2x
    public int ROW_HEIGHT;
    public int ROW_WIDTH;
    public int TRAILMARK_WIDTH;
    public int TRAILMARK_HEIGHT;
    public String FONT_FILE_NAME;
    public int FOOTER_LEFT_FONT_SIZE;
    public int FOOTER_RIGHT_FONT_SIZE;
    /**
     *  signpost frame color
     */
    public boolean HAS_FRAME; // has frame? (if false, no signpost frame is drawn)
    public Color FRAME_COLOR;
    /**
     *  signpost fill (background) color
     */
    public boolean HAS_BG_COLOR; // has bg color? (if false, no signpost bg fill is applied)
    public int[] BG_COLOR; // int[3], backround color in rgb
    /**
     * signpost mounting panel
     */
    public boolean HAS_MOUNTING_PANEL; // if yes, a cutting mark will be added to the opposite side of the arrow (extended signpost part for mounting)
    public int MOUNTING_PANEL_WIDTH;
    public int CUTTING_MARK_LENGTH;
    /**
     * SIGNPOST ROWs PROPERTIES
     */
    public SprProperties sprProp;

    protected final int getInt(Properties prop, String key) {
        return Integer.valueOf(prop.getProperty(key));
    }

    protected final float getFloat(Properties prop, String key) {
        return Float.valueOf(prop.getProperty(key));
    }

    protected final boolean getBoolean(Properties prop, String key) {
        String s = prop.getProperty(key);
        if (s.equals("0") || s.toLowerCase().equals("false")) {
            return false;
        }
        // any other value results true:
        return true;
    }

    protected final Color getColor(Properties prop, String key) {
        Color color;
        try {
            Field field = Class.forName("java.awt.Color").getField(prop.getProperty(key));
            color = (Color) field.get(null);
        } catch (Exception e) {
            color = null; // Not defined
        }
        return color;
    }

    public SpProperties() {
    }

    /**
     *  constructor from Properties object
     */
    public SpProperties(Properties prop) {
        SIGNPOST_HEIGHT = getInt(prop, "Sp_SIGNPOST_HEIGHT");
        MAIN_PANEL_WIDTH = getInt(prop, "Sp_MAIN_PANEL_WIDTH");
        ARROW_WIDTH = getInt(prop, "Sp_ARROW_WIDTH");
        SIGNPOST_WIDTH = getInt(prop, "Sp_SIGNPOST_WIDTH");
        ROW_COUNT = getInt(prop, "Sp_ROW_COUNT");
        ROW_INDENT_X = getInt(prop, "Sp_ROW_INDENT_X");
        ROW_INDENT_Y = getInt(prop, "Sp_ROW_INDENT_Y");
        ROW_HEIGHT = getInt(prop, "Sp_ROW_HEIGHT");
        ROW_WIDTH = getInt(prop, "Sp_ROW_WIDTH");
        TRAILMARK_WIDTH = getInt(prop, "Sp_TRAILMARK_WIDTH");
        TRAILMARK_HEIGHT = getInt(prop, "Sp_TRAILMARK_HEIGHT");
        FONT_FILE_NAME = prop.getProperty("Sp_FONT_FILE_NAME");
        FOOTER_LEFT_FONT_SIZE = getInt(prop, "Sp_FOOTER_LEFT_FONT_SIZE");
        FOOTER_RIGHT_FONT_SIZE = getInt(prop, "Sp_FOOTER_RIGHT_FONT_SIZE");
        HAS_FRAME = getBoolean(prop, "Sp_HAS_FRAME");
        FRAME_COLOR = getColor(prop, "Sp_FRAME_COLOR");
        HAS_BG_COLOR = getBoolean(prop, "Sp_HAS_BG_COLOR");
        
        BG_COLOR = new int[3];
        String rgbS = prop.getProperty("Sp_BG_COLOR");
        if (rgbS.substring(0, 2).equals("0x")) {
            int rgb = Integer.valueOf(rgbS.substring(2), 16);
            BG_COLOR[0] = rgb / 0x10000;
            BG_COLOR[1] = rgb % 0x10000 / 0x100;
            BG_COLOR[2] = rgb % 0x100;
        } // else none
        
        HAS_MOUNTING_PANEL = getBoolean(prop, "Sp_HAS_MOUNTING_PANEL");
        MOUNTING_PANEL_WIDTH = getInt(prop, "Sp_MOUNTING_PANEL_WIDTH");
        CUTTING_MARK_LENGTH = getInt(prop, "Sp_CUTTING_MARK_LENGTH");
        
        // Read SIGNPOST ROWs PROPERTIES :
        sprProp = new SprProperties();
        sprProp.TEXT_COLOR = getColor(prop, "Sp_TEXT_COLOR");
        sprProp.FONT_SIZE = getInt(prop, "Sp_FONT_SIZE");
        sprProp.FONT_HEIGHT_CORRECTION_RATIO = getFloat(prop, "Sp_FONT_HEIGHT_CORRECTION_RATIO");
        sprProp.HORIZ_SPACING = getInt(prop, "Sp_HORIZ_SPACING");
        sprProp.PICTO_HEIGHT = getInt(prop, "Sp_PICTO_HEIGHT");
        sprProp.COMMENT_FONT_SIZE = getInt(prop, "Sp_COMMENT_FONT_SIZE");
        sprProp.COMMENT_Y_CENTER_SPACING = getInt(prop, "Sp_COMMENT_Y_CENTER_SPACING");
        sprProp.HORIZ_LINE_WIDTH = getInt(prop, "Sp_HORIZ_LINE_WIDTH");
        sprProp.BANNER_EXT_X_ARROW = getInt(prop, "Sp_BANNER_EXT_X_ARROW");
        sprProp.BANNER_EXT_Y1 = getInt(prop, "Sp_BANNER_EXT_Y1");
        sprProp.BANNER_EXT_X_NONARROW = getInt(prop, "Sp_BANNER_EXT_X_NONARROW");
        sprProp.BANNER_EXT_Y2 = getInt(prop, "Sp_BANNER_EXT_Y2");
        sprProp.TIME_TEXT_WIDTH = getInt(prop, "Sp_TIME_TEXT_WIDTH");
        sprProp.KM_TEXT_WIDTH = getInt(prop, "Sp_KM_TEXT_WIDTH");
        sprProp.TIME_TEXT_SHRINK_SCALE = getFloat(prop, "Sp_TIME_TEXT_SHRINK_SCALE");
        sprProp.KM_TEXT_SHRINK_SCALE = getFloat(prop, "Sp_KM_TEXT_SHRINK_SCALE");
    }
    
}
