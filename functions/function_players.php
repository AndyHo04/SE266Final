<?php

include __DIR__ . '/db.php';

//Get a players information from the database
function getPlayers(){
    global $db;

        $results =[];
        $stmt = $db->prepare("SELECT players.playerid, players.name, players.age, players.position, players.team, players.height, players.weight,
        evaluations.stars, evaluations.skills_rating, evaluations.potential_rating, evaluations.athletism_rating, evaluations.game_iq FROM players LEFT JOIN evaluations ON players.playerid = evaluations.playerid ORDER BY evaluations.stars DESC");
        if($stmt->execute() && $stmt->rowCount() > 0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    
}

function getPlayer($name){
    global $db;

    try {
        $results =[];
        $sql = "SELECT players.playerid, players.name, players.age, players.position, players.team, players.height, players.weight,
        evaluations.stars, evaluations.skills_rating, evaluations.potential_rating, evaluations.athletism_rating, evaluations.game_iq FROM players LEFT JOIN evaluations ON players.playerid = evaluations.playerid WHERE players.name = :name";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        if($stmt->execute() && $stmt->rowCount() > 0){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $results;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

function addPlayer($name, $age, $position, $team, $height, $weight, $stars, $skills_rating, $potential_rating, $athletism_rating, $game_iq){
    global $db;

    try {
        $stmt = $db->prepare("INSERT INTO players (name, age, position, team, height, weight) VALUES (:name, :age, :position, :team, :height, :weight)");
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':age', $age);
        $stmt->bindValue(':position', $position);
        $stmt->bindValue(':team', $team);
        $stmt->bindValue(':height', $height);
        $stmt->bindValue(':weight', $weight);
        $stmt->execute();
        $player_id = $db->lastInsertId();
        $stmt = $db->prepare("INSERT INTO evaluations (playerid, stars, skills_rating, potential_rating, athletism_rating, game_iq) VALUES (:player_id, :stars, :skills_rating, :potential_rating, :athletism_rating, :game_iq)");
        $stmt->bindValue(':player_id', $player_id);
        $stmt->bindValue(':stars', $stars);
        $stmt->bindValue(':skills_rating', $skills_rating);
        $stmt->bindValue(':potential_rating', $potential_rating);
        $stmt->bindValue(':athletism_rating', $athletism_rating);
        $stmt->bindValue(':game_iq', $game_iq);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}

function updatePlayer($name, $age, $position, $team, $height, $weight, $stars, $skills_rating, $potential_rating, $athletism_rating, $game_iq){
    global $db;

    try {
        // Retrieve the player's ID based on their name
        $stmt = $db->prepare("SELECT playerid FROM players WHERE name = :name");
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($player) {
            $playerId = $player['playerid'];

            // Update players table
            $stmt = $db->prepare("UPDATE players SET name = :name, age = :age, position = :position, team = :team, height = :height, weight = :weight WHERE playerid = :id");
            $stmt->bindValue(':id', $playerId);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':age', $age);
            $stmt->bindValue(':position', $position);
            $stmt->bindValue(':team', $team);
            $stmt->bindValue(':height', $height);
            $stmt->bindValue(':weight', $weight);
            $stmt->execute();

            // Update evaluations table - Fixed column name from player_id to playerid
            $stmt = $db->prepare("UPDATE evaluations SET stars = :stars, skills_rating = :skills_rating, potential_rating = :potential_rating, athletism_rating = :athletism_rating, game_iq = :game_iq WHERE playerid = :id");
            $stmt->bindValue(':id', $playerId);
            $stmt->bindValue(':stars', $stars);
            $stmt->bindValue(':skills_rating', $skills_rating);
            $stmt->bindValue(':potential_rating', $potential_rating);
            $stmt->bindValue(':athletism_rating', $athletism_rating);
            $stmt->bindValue(':game_iq', $game_iq);
            $stmt->execute();

            return true; // Changed to return true instead of checking rowCount()
        }
        return false;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}

function deletePlayer($name){
    global $db;

    try {
        // Retrieve the player's ID based on their name
        $stmt = $db->prepare("SELECT playerid FROM players WHERE name = :name");
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($player) {
            $playerId = $player['playerid'];

            // Start transaction
            $db->beginTransaction();

            // Delete from evaluations table first - Fixed column name from player_id to playerid
            $stmt = $db->prepare("DELETE FROM evaluations WHERE playerid = :id");
            $stmt->bindValue(':id', $playerId);
            $stmt->execute();

            // Delete from players table
            $stmt = $db->prepare("DELETE FROM players WHERE playerid = :id");
            $stmt->bindValue(':id', $playerId);
            $stmt->execute();

            // Commit transaction
            $db->commit();
            return true;
        }
        return false;
    } catch (PDOException $e) {
        // Rollback transaction on error
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        error_log($e->getMessage());
        return false;
    }
}

//Search for a player in the database
function searchPlayer($name, $age, $position, $stars){
    global $db;

    try {
        $results = [];
        $sql = "SELECT players.playerid, players.name, players.age, players.position, players.team, players.height, players.weight,
                evaluations.stars, evaluations.skills_rating, evaluations.potential_rating, evaluations.athletism_rating, evaluations.game_iq 
                FROM players 
                LEFT JOIN evaluations ON players.playerid = evaluations.playerid 
                WHERE 1=1";

        if ($name !== "") {
            $sql .= " AND players.name LIKE :name";
        }
        if ($age !== "") {
            $sql .= " AND players.age LIKE :age";
        }
        if ($position !== "") {
            $sql .= " AND players.position LIKE :position";
        }
        if ($stars !== "") {
            $sql .= " AND evaluations.stars LIKE :stars";
        }

        $stmt = $db->prepare($sql);

        if ($name !== "") {
            $stmt->bindValue(':name', '%' . $name . '%');
        }
        if ($age !== "") {
            $stmt->bindValue(':age', '%' . $age . '%');
        }
        if ($position !== "") {
            $stmt->bindValue(':position', '%' . $position . '%');
        }
        if ($stars !== "") {
            $stmt->bindValue(':stars', '%' . $stars . '%');
        }

        if($stmt->execute() && $stmt->rowCount() > 0){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error, rethrow, etc.)
        return false;
    }
}
