/** Clasa Controller pentru elementele din tabela fotomodele
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.controllers;

import com.bmt.webapp.models.*;
import com.bmt.webapp.repositories.FotomodelRepository;
import com.bmt.webapp.services.FileService;
import jakarta.validation.Valid;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.*;
import org.springframework.web.bind.annotation.*;
import org.springframework.core.io.*;
import org.springframework.http.*;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.List;


@Controller
@RequestMapping("/fotomodele")
public class FotomodeleController {
    @Autowired
    private FotomodelRepository fotomodelRepo;

    //FUNCTIE PENTRU FILTRU - cautare dupa status
    @GetMapping(params = "status")
    public String getFotomodeleByStatus(@RequestParam String status, Model model) {
        List<Fotomodel> fotomodele;
        if ("toate".equalsIgnoreCase(status)) {
            fotomodele = fotomodelRepo.findAll(Sort.by(Sort.Direction.DESC, "id"));
        } else {
            fotomodele = fotomodelRepo.findByStatus(status);
        }
        model.addAttribute("fotomodele", fotomodele);
        return "fotomodele/index";
    }

//AFISAREA INTREGULUI TABEL
    @GetMapping({"", "/"})
    public String getFotomodele(Model model) {
        var fotomodele = fotomodelRepo.findAll(Sort.by(Sort.Direction.DESC, "id"));
        model.addAttribute("fotomodele", fotomodele);
        return "fotomodele/index";
    }

    //GET si POST pentru crearea unei noi entitati
    @GetMapping("/create")
    public String createFotomodel(Model model){
        FotomodelDto fotomodelDto = new FotomodelDto();
        model.addAttribute("fotomodelDto", fotomodelDto);

        return "fotomodele/create";
    }

    @PostMapping("/create")
    public String createFotomodel(
        @Valid @ModelAttribute FotomodelDto fotomodelDto,
        BindingResult result
        ){
        if(fotomodelRepo.findByEmail(fotomodelDto.getEmail()) != null)
        {
            result.addError(new FieldError("fotomodelDto","email", fotomodelDto.getEmail(), false, null, null, "Email address is already used")
            );
        }
        if(result.hasErrors()){
            return "fotomodele/create";
        }
        Fotomodel fotomodel = new Fotomodel();
        fotomodel.setNume(fotomodelDto.getNume());
        fotomodel.setPrenume(fotomodelDto.getPrenume());
        fotomodel.setEmail(fotomodelDto.getEmail());
        fotomodel.setVarsta(fotomodelDto.getVarsta());
        fotomodel.setSex(fotomodelDto.getSex());
        fotomodel.setInaltime(fotomodelDto.getInaltime());
        fotomodel.setStatus(fotomodelDto.getStatus());

        fotomodelRepo.save(fotomodel);


        return "redirect:/fotomodele";
    }
    //GET si POST pentru editarea unei entitati
    @GetMapping("/edit")
    public String editFotomodel(Model model, @RequestParam int id){
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if(fotomodel == null){
            return "redirect:/fotomodele";
        }
        FotomodelDto fotomodelDto = new FotomodelDto();
        fotomodelDto.setNume(fotomodel.getNume());
        fotomodelDto.setPrenume(fotomodel.getPrenume());
        fotomodelDto.setEmail(fotomodel.getEmail());
        fotomodelDto.setVarsta(fotomodel.getVarsta());
        fotomodelDto.setSex(fotomodel.getSex());
        fotomodelDto.setInaltime(fotomodel.getInaltime());
        fotomodelDto.setStatus(fotomodel.getStatus());

        model.addAttribute("fotomodel", fotomodel);
        model.addAttribute("fotomodelDto", fotomodelDto);

        return "fotomodele/edit";
    }

    @PostMapping("/edit")
    public String editFotomodel(Model model, @RequestParam int id,
                                @Valid @ModelAttribute FotomodelDto fotomodelDto,
                                BindingResult result) {
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if (fotomodel == null) {
            return "redirect:/fotomodele";
        }
        model.addAttribute("fotomodel", fotomodel);
        if (result.hasErrors()) {
            return "fotomodele/edit";
        }
        fotomodel.setNume(fotomodelDto.getNume());
        fotomodel.setPrenume(fotomodelDto.getPrenume());
        fotomodel.setEmail(fotomodelDto.getEmail());
        fotomodel.setVarsta(fotomodelDto.getVarsta());
        fotomodel.setSex(fotomodelDto.getSex());
        fotomodel.setInaltime(fotomodelDto.getInaltime());
        fotomodel.setStatus(fotomodelDto.getStatus());
        try {
            fotomodelRepo.save(fotomodel);
        } catch (Exception ex) {
            result.addError(new FieldError("fotomodelDto", "email", fotomodelDto.getEmail(),
                    false, null, null, "Adresa de email e deja folosita"));
            return "fotomodele/edit";
        }
        return "redirect:/fotomodele";
    }
    //GET pentru stergerea unei entitati
    @GetMapping("/delete")
    public String deleteFotomodel(@RequestParam int id){
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if(fotomodel != null)
        {
            fotomodelRepo.delete(fotomodel);
        }
        return "redirect:/fotomodele";
    }

    @Autowired
    private FileService fileService;

    //functii pentru vizualizare, incarcarea,descarcarea si stergerea CV-ULUI
    @GetMapping("/viewCV")
    public String viewCV(@RequestParam int id, Model model) {
        // cautam fotomodelul dupa id
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);

        if (fotomodel != null) {
            model.addAttribute("fotomodel", fotomodel);  // adaugam fotomodelul in model pentru a-l folosi în view

            // verificăm dacă CV-ul este deja incarcat
            if (fotomodel.getCvPath() == null) {
                model.addAttribute("error", "Nu ai încărcat un CV pentru acest fotomodel.");
            }

            return "fotomodele/viewCV";  //  pagina viewCV.html
        }

        return "redirect:/fotomodele";  //nu exista- redirecționăm la lista de fotomodele
    }

    // Salvarea CV-ului
    @PostMapping("/upload-cv")
    public String uploadCv(@RequestParam int id, @RequestParam("cvFile") MultipartFile cvFile, Model model) {
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if (fotomodel == null) {
            return "redirect:/fotomodele";
        }

        try {
            // daca a nu fost selectat un fișier
            if (cvFile.isEmpty()) {
                model.addAttribute("error", "Te rugăm să selectezi un fișier pentru a încărca CV-ul.");
                model.addAttribute("fotomodel", fotomodel);
                return "fotomodele/viewCV";
            }

            // salveaza fișierul pe server
            String filePath = fileService.saveFile(cvFile, "cv_" + id + ".pdf");
            fotomodel.setCvPath(filePath);
            fotomodelRepo.save(fotomodel);
        } catch (IOException e) {
            e.printStackTrace();
            model.addAttribute("error", "A apărut o eroare la încărcarea CV-ului.");
            model.addAttribute("fotomodel", fotomodel);
            return "fotomodele/viewCV";
        }

        return "redirect:/fotomodele";
    }


    // descarcarea CV-ului
    @GetMapping("/download-cv")
    public ResponseEntity<Resource> downloadCv(@RequestParam int id) {
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if (fotomodel == null || fotomodel.getCvPath() == null) {
            return ResponseEntity.notFound().build();
        }

        try {
            Path filePath = Paths.get(fotomodel.getCvPath());
            Resource resource = new UrlResource(filePath.toUri());
            return ResponseEntity.ok()
                    .contentType(MediaType.APPLICATION_PDF)
                    .header(HttpHeaders.CONTENT_DISPOSITION, "attachment; filename=\"" + filePath.getFileName() + "\"")
                    .body(resource);
        } catch (Exception e) {
            return ResponseEntity.internalServerError().build();
        }
    }

    // stergerea CV-ului
    @PostMapping("/delete-cv")
    public String deleteCv(@RequestParam int id) {
        Fotomodel fotomodel = fotomodelRepo.findById(id).orElse(null);
        if (fotomodel != null && fotomodel.getCvPath() != null) {
            try {
                // stergem fisierul de pe server
                Files.deleteIfExists(Paths.get(fotomodel.getCvPath()));
                fotomodel.setCvPath(null);  // stergem din baza de date
                fotomodelRepo.save(fotomodel);
            } catch (IOException e) {
                e.printStackTrace();
                return "redirect:/fotomodele?error";  // test de eroare
            }
        }
        return "redirect:/fotomodele";
    }
}
