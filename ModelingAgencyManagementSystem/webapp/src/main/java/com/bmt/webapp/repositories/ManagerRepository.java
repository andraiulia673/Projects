/** Clasa Controller pentru functii de cautare la manageri
 * @author Cojocaru Iulia Alexandra
 * @version 12 Ianuarie 2024
 */
package com.bmt.webapp.repositories;

import com.bmt.webapp.models.Manager;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.Optional;
//functiile necesare pentru manager
@Repository
public interface ManagerRepository extends JpaRepository<Manager, Integer> {
    Optional<Manager> findByEmail(String email);
    Optional<Manager> findByParola(String parola);
}
