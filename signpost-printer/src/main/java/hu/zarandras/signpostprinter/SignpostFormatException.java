/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

import java.util.logging.Level;

/**
 *
 * @author Andras
 */
class SignpostFormatException extends Exception {
    
    private final Level severity;

    public SignpostFormatException(Level severity, String message) {
        super(message);
        this.severity = severity;
    }

    public SignpostFormatException(Level severity, String message, Throwable throwable) {
        super(message, throwable);
        this.severity = severity;
    }    

    public Level getSeverity() {
        return severity;
    }

}
