/** Clasa Controller pentru pagina de home
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
//pentru pagina de home
@Controller
@RequestMapping("/home")
public class HomeController {

    @GetMapping("/home")
    public String home() {
        return "home/home";
    }
}
