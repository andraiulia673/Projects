/** Clasa Controller pentru impunerea conditiilor la autentificari
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.services;

import com.bmt.webapp.models.Manager;
import com.bmt.webapp.models.LoginDto;
import com.bmt.webapp.models.RegisterDto;
import com.bmt.webapp.repositories.ManagerRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class AuthService {

    @Autowired
    private ManagerRepository managerRepository;

    public String register(RegisterDto registerDto) {
        if (managerRepository.findByEmail(registerDto.getEmail()).isPresent()) {
            return "Emailul există deja.";
        }

        if (managerRepository.findByParola(registerDto.getParola()).isPresent()) {
            return "Parola există deja..";
        }//teste pentru register daca parola sau emailul exista deja

        // crearea unui nou manager dupa ce se inregistreaza
        Manager manager = new Manager();
        manager.setNume(registerDto.getNume());
        manager.setPrenume(registerDto.getPrenume());
        manager.setEmail(registerDto.getEmail());
        manager.setParola(registerDto.getParola());

        // se salveaza in baza de date
        managerRepository.save(manager);

        return "Înregistrare reușită.";
    }

    public String login(LoginDto loginDto) {
        //test daca emailul si parola sunt corecte la login
        Manager manager = managerRepository.findByEmail(loginDto.getEmail())
                .orElse(null);

        if (manager == null) {
            return "Email incorect.";
        }

        if (!manager.getParola().equals(loginDto.getParola())) {
            return "Parolă incorectă.";
        }

        return "Autentificare reușită.";
    }
}

