/** Clasa Controller pentru functii de cautare la fotomodele
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.repositories;

import com.bmt.webapp.models.Fotomodel;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
//functiile necesare pentru fotomodele
public interface FotomodelRepository extends JpaRepository<Fotomodel, Integer> {

    public Fotomodel findByEmail(String email);
    List<Fotomodel> findByStatus(String status);
}
