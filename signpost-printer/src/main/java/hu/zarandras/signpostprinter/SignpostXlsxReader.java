/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.awt.Color;
import java.io.Closeable;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Iterator;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.xssf.usermodel.XSSFColor;
import org.apache.poi.ss.usermodel.Row;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;

/**
 *
 * @author Andras
 */
class SignpostXlsxReader implements Iterable<Signpost>, Closeable {
    
    private static int idCounter;
        
    class SXRIterator implements Iterator<Signpost> {

        private final Iterator<Row> rowIterator;
        private Signpost nextSignpost;

        public SXRIterator(Iterator<Row> rowIterator) {
            this.rowIterator = rowIterator;
            setIdCounter(0);
            //preReadNextSignpost();
            nextSignpost = null; // next and hasNext will pre-read -> no error can be produced here
        }

        private void preReadNextSignpost() {
            nextSignpost = null;
            while (rowIterator.hasNext() && nextSignpost == null) {
                try {
                    nextSignpost = createSignpostFromXlsxRow(rowIterator.next());
                } catch (SignpostFormatException e) {
                    logger.log(e.getSeverity(), "Tábla formátum hiba - a tábla ki lesz hagyva: ", e);
                    nextSignpost = null;
                }
            }
        }

        @Override
        public boolean hasNext() {
            // initialization if needed
            if (nextSignpost == null)
                preReadNextSignpost();
            
            return (nextSignpost != null);
        }

        @Override
        public Signpost next() {
            // initialization if needed
            if (nextSignpost == null)
                preReadNextSignpost();

            Signpost currentSignpost = nextSignpost;
            preReadNextSignpost();
            return currentSignpost;
        }
           
    }
    
    private SXRIterator it = null;
    private final Logger logger;

    SignpostXlsxReader(Logger logger, String fileName) throws FileNotFoundException, IOException {
        this(logger, fileName, null);
    }
    
    SignpostXlsxReader(Logger logger, String fileName, String sheetName) throws IOException {
        this.logger = logger;
        //get file
        FileInputStream file = new FileInputStream(new File(fileName));

        //Get the workbook instance for XLS file 
        XSSFWorkbook workbook = new XSSFWorkbook(file);

        //Get first sheet from the workbook - TODO: replace to named Export ??? !!!
        XSSFSheet sheet;
        if (sheetName == null) {
            sheet = workbook.getSheetAt(0);
        } else {
            sheet = workbook.getSheet(sheetName);
        }

        //Get iterator to all the rows in current sheet
        Iterator<Row> rowIterator = sheet.iterator();
        
        // create own iterator for querying
        it = new SXRIterator(rowIterator);
    }

    @Override
    public Iterator<Signpost> iterator() {
        return it;
    }
    
    @Override
    public void close() throws IOException {
        // do nothing
    }
    
    protected String getCellRef(Cell c) {
        StringBuilder s = new StringBuilder(5);
        if (c.getColumnIndex() >= 26)
            s.append((char)('A' + (c.getColumnIndex() / 26 - 1)));
        s.append((char)('A' + c.getColumnIndex() % 26)).append(Integer.toString(c.getRowIndex()+1));
        return s.toString();
    }
    
    protected boolean isCellEmpty(Cell c) {
        if (c == null)
            return true;
        if (c.getCellType() == Cell.CELL_TYPE_BLANK)
            return true;        
        if (c.getCellType() == Cell.CELL_TYPE_NUMERIC && c.getNumericCellValue() == 0)
            return true;
        if (c.getCellType() == Cell.CELL_TYPE_STRING && c.getStringCellValue().isEmpty())
            return true;
        // any other case:
        return false;
    }
    
    /**
     * Generates a Signpost object from an excel table row
     * @param xlsxRow
     * @return new signpost or null if the xlsx row is invalid
     */
    public Signpost createSignpostFromXlsxRow(Row row) throws SignpostFormatException {
        Cell cell;
        int id;
        //skip the unnumbered rows - seek for positive numeric value in first col
        cell = row.getCell(0);
        if (isCellEmpty(cell) || cell.getCellType() == Cell.CELL_TYPE_STRING)
            // silently skip empty row / row with empty/string first cell
            return null;
        if (cell.getCellType() == Cell.CELL_TYPE_FORMULA && cell.getCellFormula().endsWith("+1")) {
            id = incIdCounter();
        } else if (cell.getCellType() == Cell.CELL_TYPE_NUMERIC && cell.getNumericCellValue() >= 1) {
            id = (int) cell.getNumericCellValue();
            setIdCounter(id);
        } else { // non-string value and invalid id:
            throw new SignpostFormatException(Level.WARNING, Integer.toString(cell.getRowIndex()+1) + ". excel sor kihagyva");
        }

        Signpost signpost = new Signpost(id);
        String inputText;
                
        // indicates centered row text alignment for H (placemark) signs
        boolean centerAlign = false;
        
        // set direction from column E
        cell = row.getCell(4);
        inputText = ((!isCellEmpty(cell) && cell.getCellType() == Cell.CELL_TYPE_STRING) ? cell.getStringCellValue() : "");
        if (!isCellEmpty(cell) && cell.getCellType() != Cell.CELL_TYPE_STRING) // nem string tablairany
            throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A táblairány kód nem szövegként van megadva!");
        switch (inputText) {
            case "B":
                signpost.setDirection(Signpost.Direction.LEFT);
                break;
            case "J":
                signpost.setDirection(Signpost.Direction.RIGHT);
                break;
            case "H":
                signpost.setDirection(Signpost.Direction.NONE);
                centerAlign = true;
                break;
            default:
                // this is a non-signpost row
                if (isCellEmpty(cell))
                    // if cell is not filled, skip silently
                    return null;
                else 
                    // cell is filled with invalid direction value:
                    throw new SignpostFormatException(Level.WARNING, Integer.toString(cell.getRowIndex()+1) + ". excel sor kihagyva (hibás táblairány kód: " + inputText + ", cella: " + getCellRef(cell) + ")");
        }
        
        // set signpost trailmarks from cols N-O-P-Q [#13-16]
        String trailmarkString = "";
        for (int i=13; i < 17; ++i) {
            cell = row.getCell(i);
            if (isCellEmpty(cell))
                continue;
            if (cell.getCellType() != Cell.CELL_TYPE_STRING) // nem string utjelzes
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: Az útjelzés nem szövegként van megadva!");

            inputText = cell.getStringCellValue();
            if (inputText != null && !inputText.isEmpty()) {
                if (!trailmarkString.isEmpty())
                    trailmarkString += "|";
                trailmarkString += inputText;
            }
        }
        signpost.setTrailmark(trailmarkString);
        
                
        
        //read 4 signpost rows by 4*5 cols, starting from cols S-T-U-V(-W):
        for (int rownum = 0; rownum < 4; ++rownum) {
            int i = 18 + rownum * 5;

            // main text
            cell = row.getCell(i);
            String mainText = ((!isCellEmpty(cell) && cell.getCellType() == Cell.CELL_TYPE_STRING) ? cell.getStringCellValue() : "");
            if (!isCellEmpty(cell) && cell.getCellType() != Cell.CELL_TYPE_STRING)
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A célpont neve nem szövegként van megadva!");
                
            Color fgColor = null;
            Color bgColor = null;
            if (cell != null) {
                // get non-default format: bg color and font color -> set as banner in signpost row
                XSSFWorkbook wb = (XSSFWorkbook) cell.getSheet().getWorkbook();
                
                // indexed color - not used:
                //int idxFontColor = wb.getFontAt(cell.getCellStyle().getFontIndex()).getColor();
                //if (idxFontColor > 0)
                //    throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A betűszín beépített színként van megadva (#" + Integer.toBinaryString(idxFontColor)+ "), nem lesz figyelembe véve!");
                
                // non-indexed color used
                XSSFColor fontColor = wb.getFontAt(cell.getCellStyle().getFontIndex()).getXSSFColor();
                if (fontColor != null && !fontColor.isAuto()) {
                    float[] hsbvals = new float[3];
                    byte[] rgbvals;
                    int[] rgbvalsUnsigned = new int[3];

                    rgbvals = fontColor.getRgb();
                    for (int j = 0; j < 3; ++j) {
                        rgbvalsUnsigned[j] = ((rgbvals[j] >= 0) ? rgbvals[j] : 0x100 + rgbvals[j]);
                    }
                    Color.RGBtoHSB(rgbvalsUnsigned[0], rgbvalsUnsigned[1], rgbvalsUnsigned[2], hsbvals);
                    fgColor = Color.getHSBColor(hsbvals[0], hsbvals[1], hsbvals[2]);

                    rgbvals = ((XSSFColor) cell.getCellStyle().getFillForegroundColorColor()).getRgb();
                    for (int j = 0; j < 3; ++j) {
                        rgbvalsUnsigned[j] = ((rgbvals[j] >= 0) ? rgbvals[j] : 0x100 + rgbvals[j]);
                    }
                    Color.RGBtoHSB(rgbvalsUnsigned[0], rgbvalsUnsigned[1], rgbvalsUnsigned[2], hsbvals);
                    bgColor = Color.getHSBColor(hsbvals[0], hsbvals[1], hsbvals[2]);

                }
            }
            ++i;
            
            // picto text
            cell = row.getCell(i);
            String pictoText = ((!isCellEmpty(cell) && cell.getCellType() == Cell.CELL_TYPE_STRING) ? cell.getStringCellValue() : "");
            if (!isCellEmpty(cell) && cell.getCellType() != Cell.CELL_TYPE_STRING)
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A piktogram nem szövegként van megadva!");
            ++i;

            // km text
            cell = row.getCell(i);
            String kmText = "";
            if (!isCellEmpty(cell)) {
                switch (cell.getCellType()) {
                    case Cell.CELL_TYPE_STRING: 
                        kmText = cell.getStringCellValue();
                        if (!kmText.isEmpty() && !kmText.endsWith("km") && !kmText.endsWith("felé"))
                            kmText += " km";
                        break;
                    case Cell.CELL_TYPE_NUMERIC:
                        double km = (Math.round(cell.getNumericCellValue()*10)+0.0)/10;
                        kmText = ((km > 0) ? Double.toString(km).replace('.', ',') + " km" : "");
                        break;
                    default:
                        // missing or error
                        throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A km nem szövegként vagy számként van megadva!");
                }
            }
            ++i;

            cell = row.getCell(i);
            String timeText = "";
            if (!isCellEmpty(cell)) {
                switch (cell.getCellType()) {
                    case Cell.CELL_TYPE_STRING: 
                        timeText = cell.getStringCellValue();
                        break;
                    case Cell.CELL_TYPE_NUMERIC: // in minutes
                        long minutes = Math.round(cell.getNumericCellValue());
                        if (minutes == 0) {
                            timeText = "";
                        } else {
                            timeText = Long.toString(minutes / 60) + ":" + ((minutes % 60 < 10) ? "0" : "") + Long.toString(minutes % 60);
                        }
                        break;
                    default:
                        // missing or error
                        throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A menetidő nem szövegként vagy számként van megadva!");
                }
            }
            ++i;
            
            // col W - row comment:
            cell = row.getCell(i);
            inputText = ((!isCellEmpty(cell) && cell.getCellType() == Cell.CELL_TYPE_STRING) ? cell.getStringCellValue() : "");
            if (!isCellEmpty(cell) && cell.getCellType() != Cell.CELL_TYPE_STRING)
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A sorkomment nem szövegként van megadva!");

            String rowComment = inputText;
            // this signpost row last value as extra remark ("|" indicates line divider between this & next row instead) 
            
            SignpostRow spRow = new SignpostRow(mainText, pictoText, kmText, timeText);
            if (fgColor != null) {
                spRow.setFgColor(fgColor);
            }
            if (bgColor != null) {
                spRow.setBgColor(bgColor);
            }
            if (rowComment != null) {
                spRow.setRowComment(rowComment);
            }
            if (centerAlign) {
                spRow.setCenterAlign(true);
            }
            signpost.addRow(rownum, spRow);
        }
        
        // read footer texts from cols AM,AN
        cell = row.getCell(25+13);
        if (!isCellEmpty(cell)) {
            if (cell.getCellType() != Cell.CELL_TYPE_STRING)
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A lábléc bal felirata nem szövegként van megadva!");
            inputText = cell.getStringCellValue();
            signpost.setFooterLeftText(inputText);
        }
        cell = row.getCell(25+14);
        if (!isCellEmpty(cell)) {
            if (cell.getCellType() != Cell.CELL_TYPE_STRING)
                throw new SignpostFormatException(Level.WARNING, getCellRef(cell) + " excel cella: A lábléc jobb felirata nem szövegként van megadva!");
            inputText = cell.getStringCellValue();
            signpost.setFooterRightText(inputText);
        }

        return signpost;
    }
    
    public int getIdCounter() {
        return idCounter;
    }

    public final void setIdCounter(int i) {
        idCounter = i;
    }

    public int incIdCounter() {
        return ++idCounter;
    }
        
}
