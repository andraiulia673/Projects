/** Clasa Controller pentru autentificare
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.controllers;
import jakarta.servlet.http.HttpSession;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;
import com.bmt.webapp.models.LoginDto;
import com.bmt.webapp.models.RegisterDto;
import com.bmt.webapp.services.AuthService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;


@Controller
@RequestMapping("/auth")
public class AuthController {

    @Autowired
    private AuthService authService;


    //GET si POST pentru partea de login
    @GetMapping("/login")
    public String loginPage() {
        return "auth/login";
    }

    @PostMapping("/login")
    public String login(@ModelAttribute LoginDto loginDto, Model model) {
        String result = authService.login(loginDto);
        if (result.equals("Autentificare reușită.")) {
            return "redirect:/home/home"; // redirectionare catre home daca logarea e valida
        }
        model.addAttribute("error", result);
        return "auth/login"; // raman in login daca inregistrarea e invalida
    }

    //GET si POST pentru partea de register
    @GetMapping("/register")
    public String registerPage() {
        return "auth/register";
    }

    @PostMapping("/register")
    public String registerUser(@ModelAttribute RegisterDto registerDto, Model model)
    {
        String result = authService.register(registerDto);

        if (!result.equals("Înregistrare reușită.")) {
            model.addAttribute("error", result);
            return "auth/register"; // raman in register daca inregistrarea e invalida
        }

        return "redirect:/auth/login"; // redirectionare catre login daca inregistrarea e valida
    }

    //GET pentru partea de logout
    @GetMapping("/logout")
    public String logout() {
        // obt sesiunea din RequestContextHolder
        ServletRequestAttributes attributes = (ServletRequestAttributes) RequestContextHolder.currentRequestAttributes();
        HttpSession session = attributes.getRequest().getSession();

        // incheie sesiunea
        session.invalidate();

        // redirectionare la login
        return "redirect:/auth/login";
    }
}
