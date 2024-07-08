<?php

// Include l'autoloader using a relative path
require_once 'C:\\xampp\\htdocs\\BetaTestGymBuddy\\app\\config\\autoloader.php';

// Test for the class EPersonalTrainer
function testEAdmin($pdo){
    // Creation of an instance of ERegisteredUser
    $admin = new EAdmin('testAdmin@example.com', 'testadmin', 'Test', 'Admin', 'password123');

    // Test of the constructor and getter methods
    assert($admin->getEmail() === 'testAdmin@example.com');
    assert($admin->getUsername() === 'testadmin');
    assert($admin->getFirstName() === 'Test');
    assert($admin->getLastName() === 'Admin');
    assert(password_verify('password123', $admin->getPassword()));
    assert($admin->role === 'admin');

    // Test of the setter methods
    $admin->setEmail('newemail@example.com');
    assert($admin->getEmail() === 'newemail@example.com');

    $admin->setUsername('newusername');
    assert($admin->getUsername() === 'newusername');

    $admin->setFirstName('NewFirstName');
    assert($admin->getFirstName() === 'NewFirstName');

    $admin->setLastName('NewLastName');
    assert($admin->getLastName() === 'NewLastName');

    $admin->setPassword('newpassword123');
    assert(password_verify('newpassword123', $admin->getPassword()));

    // Test of the getEntity method
    assert(EAdmin::getEntity() === EAdmin::class);

    echo "All tests for EAdmin have passed.\n";
}


function testFAdminGetObjBindCreateDelete($pdo){
    // Creazione di un'istanza di EAdmin per il test
    $admin = new EAdmin('testFAdmin@example.com', 'testuser', 'Test', 'FAdmin', 'password123');

    // Preparazione di un'istruzione SELECT per verificare se l'utente esiste già
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $admin->getEmail()]);

    // Se l'utente esiste già, aggiorna il record
    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idUser = $user['idUser'];
        $stmt = $pdo->prepare("UPDATE user SET username = :username, first_name = :first_name, last_name = :last_name, password = :password WHERE idUser = :idUser");
        $stmt->execute([
            'idUser' => $idUser,
            'username' => $admin->getUsername(),
            'first_name' => $admin->getFirstName(),
            'last_name' => $admin->getLastName(),
            'password' => password_hash($admin->getPassword(), PASSWORD_DEFAULT)
        ]);
    } else {
        // Se l'utente non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password) VALUES (:email, :username, :first_name, :last_name, :password)");
        $stmt->execute([
            'email' => $admin->getEmail(),
            'username' => $admin->getUsername(),
            'first_name' => $admin->getFirstName(),
            'last_name' => $admin->getLastName(),
            'password' => password_hash($admin->getPassword(), PASSWORD_DEFAULT)
        ]);

        // Recupera l'idUser appena inserito
        $idUser = $pdo->lastInsertId();
    }

    // Verifica se l'utente è stato inserito correttamente
    assert(isset($idUser) && !empty($idUser), "User insertion failed");
    echo "User inserted/updated with idUser: $idUser\n";

    // Preparazione di un'istruzione SELECT per verificare se l'admin esiste già
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE idUser = :idUser");
    $stmt->execute(['idUser' => $idUser]);

    // Se l'admin esiste già, non fare nulla
    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        // Se l'admin non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO admin (idUser) VALUES (:idUser)");
        $stmt->execute(['idUser' => $idUser]);
    }

    // Verifica che i dati siano stati inseriti correttamente nel database
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE idUser = :idUser");
    $stmt->execute(['idUser' => $idUser]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    assert($result['idUser'] == $idUser, "Admin insertion failed");
    echo "Admin record exists for idUser: $idUser\n";

    // Test per il metodo getObj
    $admin = FAdmin::getObj($idUser);
    assert($admin !== null, "getObj failed to retrieve the admin");
    echo "Admin retrieved: " . print_r($admin, true) . "\n"; // Debug output
    assert($admin->getEmail() === 'testFAdmin@example.com', "Emails do not match");

    echo "Get Obj, Bind, Create and Delete test have passed.\n";

    // Test per il metodo deleteAdminObj
    $deleteResult = FAdmin::deleteAdminObj($idUser);
    assert($deleteResult === true, "deleteAdminObj failed");

    // Verifica che l'admin sia stato effettivamente eliminato
    $admin = FAdmin::getObj($idUser);
    assert($admin === null, "Admin was not deleted");

    echo "Delete Admin Obj test have passed.\n";
}


/////////////////////////////////////////////////////////////////////////////////
function testFAdminSaveObj($pdo) {
    // Creazione della classe di test FAdminTest
    class FAdminTest {

        // Variabile per connettersi al database
        private $db;

        // Costruttore per inizializzare la connessione al database
        public function __construct($db) {
            $this->db = $db;
        }

        // Metodo per eseguire il test dell'inserimento di un nuovo oggetto
        public function testSaveNewObj() {
            // Creazione di un nuovo oggetto da salvare
            $newAdmin = new EAdmin('test@example.com', 'testuser', 'Test', 'Admin', 'testpassword');

            // Chiamata al metodo saveObj per salvare il nuovo oggetto
            $result = FAdmin::saveObj($newAdmin);

            // Verifica del risultato
            if ($result !== false) {
                echo "Test inserimento nuovo oggetto passato: ID restituito " . $result . "\n";
            } else {
                echo "Test inserimento nuovo oggetto fallito\n";
            }

            // Pulizia: rimuovere l'oggetto inserito per lasciare il database nello stato originale
            $this->db->query("DELETE FROM admin WHERE email = 'test@example.com'");
            $this->db->query("DELETE FROM user WHERE email = 'test@example.com'");
        }

        // Metodo per eseguire il test dell'aggiornamento di un oggetto esistente
        public function testUpdateExistingObj() {
            // Check if the user already exists
            $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => 'existing@example.com']);
            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userExists) {
                // If the user doesn't exist, insert a new row
                $this->db->query("INSERT INTO user (email, username, password) VALUES ('existing@example.com', 'existinguser', 'existingpassword')");
                $this->db->query("INSERT INTO admin (email) VALUES ('existing@example.com')");
            }

            // Creazione di un oggetto da aggiornare
            $existingAdmin = new EAdmin('existing@example.com', 'existinguser', 'Existing', 'Admin', 'existingpassword');

            // Creazione di un array con i campi da aggiornare
            $fieldArray = [
                ['username', 'updateduser'],
                ['password', 'updatedpassword']
            ];

            // Chiamata al metodo saveObj per aggiornare l'oggetto esistente
            $result = FAdmin::saveObj($existingAdmin, $fieldArray);

            // Verifica del risultato
            if ($result === true) {
                echo "Test aggiornamento oggetto esistente passato\n";
            } else {
                echo "Test aggiornamento oggetto esistente fallito\n";
            }

            // Verifica degli aggiornamenti nel database
            $result = $this->db->query("SELECT username, password FROM user WHERE email = 'existing@example.com'");
            $updatedUser = $result->fetch(PDO::FETCH_ASSOC);

            if ($updatedUser['username'] == 'updateduser' && $updatedUser['password'] == 'updatedpassword') {
                echo "Verifica aggiornamenti nel database passata\n";
            } else {
                echo "Verifica aggiornamenti nel database fallita\n";
            }

            // Pulizia: rimuovere l'oggetto aggiornato per lasciare il database nello stato originale
            $this->db->query("DELETE FROM admin WHERE email = 'existing@example.com'");
            $this->db->query("DELETE FROM user WHERE email = 'existing@example.com'");
        }
    }

    // Creazione di un'istanza della classe di test
    $test = new FAdminTest($pdo);

    // Esecuzione dei test
    $test->testSaveNewObj();
    $test->testUpdateExistingObj();
}







try {
    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");

    // Execute the tests
    testEAdmin($pdo);
    testFAdminGetObjBindCreateDelete($pdo);
    testFAdminSaveObj($pdo);


} catch (PDOException $e) {
    echo "Error during the connection to the database: " . $e->getMessage();
}

