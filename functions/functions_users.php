<?php

include __DIR__ . '/db.php';

function adduser($username, $password) {
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO bbusers (username, password) VALUES (:user, :pass)");

        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', sha1("MY-SECRET-SAUCE" . $password));

        $stmt->execute();

        return ($stmt->rowCount() > 0);
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

function userExists($username, $password) {
    global $db;

    try {
        $stmt = $db->prepare("SELECT COUNT(*) FROM bbusers WHERE username = :user AND password = :pass");
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', sha1("MY-SECRET-SAUCE" . $password));
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

// When registering a user
function registerUser($username, $password) {
    global $db;
    
    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $db->prepare("INSERT INTO bbusers (username, password) VALUES (:user, :pass)");
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', $hashedPassword);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        return false;
    }
}

// When logging in
function login($username, $password) {
    global $db; 

    try {
        $stmt = $db->prepare("SELECT * FROM bbusers WHERE username = :user and password = :pass");
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', sha1("MY-SECRET-SAUCE" . $password));
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


         // If a user is found, set session variables and generate a token
         if ($user) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['token'] = bin2hex(random_bytes(32));
            return true;
        } else {
            // If no user is found, return false
            return false;
        }

        return true;
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

// Get a user's information from the database
function getUser($id) {
    global $db;
    try {
        $stmt = $db->prepare("SELECT * FROM bbusers WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the user or return null if not found
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : false;
    } catch (PDOException $e) {
        // Log the error (replace with your logging mechanism)
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function updateUser($username, $password) {
    global $db;

    try {
        $stmt = $db->prepare("UPDATE bbusers SET password = :pass WHERE username = :user");

        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', sha1("MY-SECRET-SAUCE" . $password));

        $stmt->execute();

        return ($stmt->rowCount() > 0);
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

function deleteUser($id) {
    global $db;

    try {
        $stmt = $db->prepare("DELETE FROM bbusers WHERE id = :id");

        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Unset and destroy the session
            session_start();
            session_unset();
            session_destroy();
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: view_players.php');
    exit();
}
    