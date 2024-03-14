<?php
namespace Classes;
use PDO;
class Database {
    private static $instance;
    private $pdo;
    $host = 'localhost';
    $dbname = 'prvi_zadatak';
    $username = 'your_username';
    $password = 'your_password';
    
    // Connect to the database using PDO
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    // Query the users table and display the results
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Display the results
        foreach ($users as $user) {
            echo "User ID: " . $user['id'] . ", Username: " . $user['username'] . ", Email: " . $user['email'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}?>