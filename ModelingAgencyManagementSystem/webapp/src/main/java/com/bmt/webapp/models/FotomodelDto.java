/** Clasa Controller pentru erori la partea de adaugare/editare fotomodel
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.models;

import jakarta.validation.constraints.*;

//data transfer la crearea/editarea fotomodelelor
public class FotomodelDto {

    @NotEmpty(message = "Completarea campului 'Nume' e obligatorie")
    private String nume;

    @NotEmpty(message = "Completarea campului 'Prenume' e obligatorie")
    private String prenume;

    @NotEmpty(message = "Completarea campului 'Email' e obligatorie")
    @Email
    private String email;

    private int varsta;
    private String sex;
    private float inaltime;

    @NotEmpty(message = "Completarea campului 'Status' e obligatorie")
    private String status;

    public @NotEmpty(message = "Completarea campului 'Nume' e obligatorie") String getNume() {
        return nume;
    }

    public void setNume(@NotEmpty(message = "Completarea campului 'Nume' e obligatorie") String nume) {
        this.nume = nume;
    }

    public @NotEmpty(message = "Completarea campului 'Prenume' e obligatorie") String getPrenume() {
        return prenume;
    }

    public void setPrenume(@NotEmpty(message = "Completarea campului 'Prenume' e obligatorie") String prenume) {
        this.prenume = prenume;
    }

    public @NotEmpty(message = "Completarea campului 'Email' e obligatorie") @Email String getEmail() {
        return email;
    }

    public void setEmail(@NotEmpty(message = "Completarea campului 'Email' e obligatorie") @Email String email) {
        this.email = email;
    }

    public int getVarsta() {
        return varsta;
    }

    public void setVarsta(int varsta) {
        this.varsta = varsta;
    }

    public String getSex() {
        return sex;
    }

    public void setSex(String sex) {
        this.sex = sex;
    }

    public float getInaltime() {
        return inaltime;
    }

    public void setInaltime(float inaltime) {
        this.inaltime = inaltime;
    }

    public @NotEmpty(message = "Completarea campului 'Status' e obligatorie") String getStatus() {
        return status;
    }

    public void setStatus(@NotEmpty(message = "Completarea campului 'Status' e obligatorie") String status) {
        this.status = status;
    }
}
