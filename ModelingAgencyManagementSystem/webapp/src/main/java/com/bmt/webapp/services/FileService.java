/** Clasa Controller pentru incarcate/descarcare CV
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.services;

import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;

@Service
public class FileService {

    // functie pentru salvarea fisierelor
    public String saveFile(MultipartFile file, String fileName) throws IOException {
        Path path = Paths.get("uploads", fileName);
        Files.write(path, file.getBytes());
        return path.toString();
    }

    // fc pentru stergerea fisierelor
    public void deleteFile(String filePath) throws IOException {
        Path path = Paths.get(filePath);
        if (Files.exists(path)) {
            Files.delete(path);
        }
    }
}
