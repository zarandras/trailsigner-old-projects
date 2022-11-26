/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package hu.zarandras.signpostprinter;

/**
 *
 * @author Andras
 */
class PictoLoadException extends Exception {

    public PictoLoadException(String message) {
        super(message);
    }

    public PictoLoadException(String message, Throwable throwable) {
        super(message, throwable);
    }    
}
