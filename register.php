<?php 
    require 'config/db.php'; 
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $username = $_POST['username'] ?? null; 
        $email = $_POST['email'] ?? null; 
        $password = $_POST['password'] ?? null;  

        if (!$username || !$email || !$password) {
            die("Por favor, completa todos los campos.");
        }

        // Encriptar contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
 
        try { 
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)"; 
            $stmt = $conn->prepare($sql);  
             
            $stmt->execute([
                ':username' => $username, 
                ':email' => $email, 
                ':password' => $hashed_password
            ]); 

            echo "Registro exitoso."; 
        } catch (PDOException $e) { 
            echo "Error: " . $e->getMessage(); 
        } 
    } 
?>