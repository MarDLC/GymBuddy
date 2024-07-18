<?php
// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymbuddy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dati dell'admin
$email = 'personalTrainer@gmail.com';
$username = 'personalTrainer';
$first_name = 'mario';
$last_name = 'del corvo';
$password = 'Mmario.1!';
$role = 'personalTrainer';

// Hash della password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Inizio della transazione
$conn->begin_transaction();

try {
    // Inserimento nella tabella `user`
    $stmt = $conn->prepare("INSERT INTO `user` (`email`, `username`, `first_name`, `last_name`, `password`, `role`) VALUES (?, ?, ?, ?, ?, ?)");

    // Associa i parametri alla query
    // "ssssss" significa che tutti e sei i parametri sono stringhe
    $stmt->bind_param("ssssss", $email, $username, $first_name, $last_name, $hashed_password, $role);

    // Esegui la query
    $stmt->execute();

    // Ottieni l'ultimo id generato
    $last_id = $conn->insert_id;

    // Inserimento nella tabella `admin`
    $stmt = $conn->prepare("INSERT INTO `personaltrainer` (`idUser`) VALUES (?)");

    // Associa il parametro alla query
    // "i" significa che il parametro è un intero
    $stmt->bind_param("i", $last_id);

    // Esegui la query
    $stmt->execute();

    // Commit della transazione
    $conn->commit();

    echo "Admin inserito con successo!";
} catch (Exception $e) {
    // Rollback della transazione in caso di errore
    $conn->rollback();
    echo "Errore: " . $e->getMessage();
}

// Chiusura della connessione
$conn->close();
?>
