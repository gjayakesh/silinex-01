# Password Storage in Silinex CMS

The CMS stores user passwords securely using **bcrypt** hashing. When a user creates an account or updates their password, the raw password is never stored directly. Instead, the following steps are performed:

1. **Hashing**
   ```php
   $hash = password_hash($plainPassword, PASSWORD_BCRYPT);
   ```
   - `PASSWORD_BCRYPT` uses the **bcrypt** algorithm with a default cost factor (currently 10). This provides a strong, adaptive hash that is computationally expensive to brute‑force.
   - The resulting hash includes the salt and cost parameters, so there is no need to store a separate salt.

2. **Storing**
   - The generated hash is saved in the `users.password` column (type `TEXT`).
   - Example insertion:
     ```php
     $stmt = $pdo->prepare('INSERT INTO users (email, password, ...) VALUES (?, ?, ...)');
     $stmt->execute([$email, $hash, ...]);
     ```

3. **Verification**
   - When a user logs in or changes their password, the stored hash is retrieved and verified against the supplied password:
     ```php
     if (password_verify($providedPassword, $storedHash)) {
         // Password is correct
     }
     ```
   - `password_verify` automatically extracts the salt and cost from the stored hash and performs the appropriate check.

4. **Re‑hashing** (optional)
   - If the application ever decides to increase the cost factor, you can detect outdated hashes with `password_needs_rehash` and re‑hash the password upon successful login.
   - Example:
     ```php
     if (password_needs_rehash($storedHash, PASSWORD_BCRYPT, ['cost' => 12])) {
         $newHash = password_hash($providedPassword, PASSWORD_BCRYPT, ['cost' => 12]);
         // Update the DB with $newHash
     }
     ```

### Security Benefits
- **Adaptive work factor**: The cost can be increased over time as hardware improves.
- **Built‑in salt**: Prevents rainbow‑table attacks.
- **Resistant to timing attacks**: `password_verify` uses constant‑time comparison.

### Migration Path
If future requirements demand a different algorithm (e.g., Argon2), the same workflow applies: generate a new hash with the desired algorithm, store it, and optionally migrate existing passwords gradually upon successful verification.

---

*This document is located at `docs/password_storage.md` in the CMS repository.*
