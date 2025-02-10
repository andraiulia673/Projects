/** Clasa Controller pentru erori la logare
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.models;

//data transfer la login
public class LoginDto {
    private String email;
    private String parola;

    // Getteri și setteri
    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getParola() {
        return parola;
    }

    public void setParola(String parola) {
        this.parola = parola;
    }
}
