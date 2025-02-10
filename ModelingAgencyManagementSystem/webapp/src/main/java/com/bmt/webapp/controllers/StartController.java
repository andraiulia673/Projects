/** Clasa Controller pentru pagina de start
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.controllers;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

//pentru pagina de start adica login
@Controller
public class StartController {
    @GetMapping("/")
    public String start(){
        return "auth/login";
    }
}