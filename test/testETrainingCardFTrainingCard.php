<?php

require_once 'C:\\xampp\\htdocs\\BetaTestGymBuddy\\app\\config\\autoloader.php';

function testETrainingCard() {
    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');

    assert($trainingCard->getEmailRegisteredUser() === 'user@example.com');
    assert($trainingCard->getExercises() === 'squat, push-up');
    assert($trainingCard->getRepetition() === 3);
    assert($trainingCard->getRecovery() === '1 min');

    $trainingCard->setEmailRegisteredUser('newuser@example.com');
    assert($trainingCard->getEmailRegisteredUser() === 'newuser@example.com');

    $trainingCard->setExercises('pull-up, plank');
    assert($trainingCard->getExercises() === 'pull-up, plank');

    $trainingCard->setRepetition(4);
    assert($trainingCard->getRepetition() === 4);

    $trainingCard->setRecovery('2 min');
    assert($trainingCard->getRecovery() === '2 min');

    assert(ETrainingCard::getEntity() === ETrainingCard::class);

    echo "All tests for ETrainingCard have passed.\n";
}

function testFTrainingCard($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => 'user@example.com',
            'type' => 'registereduser'
        ]);
    }

    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');
    $creation_time = $trainingCard->getTimeStr(); // Get the creation_time from the trainingCard object

    $stmt = $pdo->prepare("SELECT * FROM trainingcard WHERE idTrainingCard = :id");
    $stmt->execute(['id' => $trainingCard->getId()]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE trainingcard SET emailRegisteredUser = :email, exercises = :exercises, repetition = :repetition, recovery = :recovery, creation_time = :creation_time WHERE idTrainingCard = :id");
        $stmt->execute([
            'id' => $trainingCard->getId(),
            'email' => $trainingCard->getEmailRegisteredUser(),
            'exercises' => $trainingCard->getExercises(),
            'repetition' => $trainingCard->getRepetition(),
            'recovery' => $trainingCard->getRecovery(),
            'creation_time' => $creation_time // Update the creation_time
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO trainingcard (emailRegisteredUser, exercises, repetition, recovery, creation_time) VALUES (:email, :exercises, :repetition, :recovery, :creation_time)");
        $stmt->execute([
            'email' => $trainingCard->getEmailRegisteredUser(),
            'exercises' => $trainingCard->getExercises(),
            'repetition' => $trainingCard->getRepetition(),
            'recovery' => $trainingCard->getRecovery(),
            'creation_time' => $creation_time // Insert the creation_time
        ]);
        $trainingCard->setId($pdo->lastInsertId());
    }






    $stmt = $pdo->prepare("SELECT * FROM trainingcard WHERE idTrainingCard = :id");
    $stmt->execute(['id' => $trainingCard->getId()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    // Assert on the retrieved object
    assert($result !== false);
    assert($result['emailRegisteredUser'] === 'user@example.com');
    assert($result['exercises'] === 'squat, push-up');
    assert((int)$result['repetition'] === 3); // Cast the repetition value to an integer before comparing
    assert($result['recovery'] === '1 min');


    // Assert sull'oggetto recuperato tramite FTrainingCard::getObj()
    $retrievedCard = FTrainingCard::getObj($trainingCard->getId());
    assert($retrievedCard !== null);
    assert($retrievedCard->getEmailRegisteredUser() === 'user@example.com');
    assert($retrievedCard->getExercises() === 'squat, push-up');
    assert((int)$retrievedCard->getRepetition() === 3);

    assert($retrievedCard->getRecovery() === '1 min');
    echo "Test passato per il metodo getObj.\n";


    // Elimina la training card
    $result = FTrainingCard::deleteTrainingCardInDb($trainingCard->getId());
    assert($result);
    echo "Test passato per il metodo deleteTrainingCardInDb.\n";

    // Verifica che la training card sia stata eliminata
    $stmt = $pdo->prepare("SELECT * FROM trainingcard WHERE idTrainingCard = :id");
    $stmt->execute(['id' => $trainingCard->getId()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    assert($result === false);
    echo "Test passato per la verifica dell'eliminazione della training card.\n";


    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    echo "All tests for FTrainingCard have passed.\n";
}


function testCreateTrainingCardObj() {
    // Creare un array di risultati di query simulati
    $queryResult = [
        [
            'emailRegisteredUser' => 'user@example.com',
            'exercises' => 'squat, push-up',
            'repetition' => '3',
            'recovery' => '1 min',
            'idTrainingCard' => '1',
            'creation_time' => '2024-06-21 19:30:57',
            'emailPersonalTrainer' => 'trainer@example.com'
        ]
    ];

    // Chiamare il metodo da testare
    $trainingCard = FTrainingCard::createTrainingCardObj($queryResult);

    // Assert sull'oggetto restituito
    assert($trainingCard !== null);
    assert($trainingCard->getEmailRegisteredUser() === 'user@example.com');
    assert($trainingCard->getExercises() === 'squat, push-up');
    assert((int)$trainingCard->getRepetition() === 3);
    assert($trainingCard->getRecovery() === '1 min');
    assert($trainingCard->getId() == '1');
    assert($trainingCard->getTime()->format('Y-m-d H:i:s') === '2024-06-21 19:30:57');
    assert($trainingCard->getEmailPersonalTrainer() === 'trainer@example.com');

    echo "Test passato per il metodo createTrainingCardObj.\n";
}


function testBind($pdo) {

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => 'user@example.com',
            'type' => 'registereduser'
        ]);
    }

    // Creare un oggetto ETrainingCard simulato
    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');

    // Creare un'istruzione SQL simulata
    $sql = "INSERT INTO trainingcard (emailRegisteredUser, creation_time, exercises, repetition, recovery, emailPersonalTrainer) VALUES (:emailRegisteredUser, :creation_time, :exercises, :repetition, :recovery, :emailPersonalTrainer)";
    $stmt = $pdo->prepare($sql);

    // Chiamare il metodo da testare
    FTrainingCard::bind($stmt, $trainingCard);

    // Eseguire l'istruzione SQL
    $stmt->execute();

    // Verificare che i valori siano stati inseriti correttamente nel database
    $stmt = $pdo->prepare("SELECT * FROM trainingcard WHERE emailRegisteredUser = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assert sui risultati recuperati
    assert($result !== false);
    assert($result['emailRegisteredUser'] === 'user@example.com');
    assert($result['exercises'] === 'squat, push-up');
    assert((int)$result['repetition'] === 3); // Cast the repetition value to an integer before comparing
    assert($result['recovery'] === '1 min');

    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    echo "Test passato per il metodo bind.\n";
}

/*
function testSaveObj($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => 'user@example.com',
            'type' => 'registereduser'
        ]);
    }

    // Creare un oggetto ETrainingCard simulato
    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');

    // Chiamare il metodo da testare
    $result = FTrainingCard::saveObj($trainingCard);

    // Verificare che l'operazione di salvataggio sia stata eseguita correttamente
    assert($result !== false);

    // Verificare che i valori siano stati inseriti correttamente nel database
    $stmt = $pdo->prepare("SELECT * FROM trainingcard WHERE emailRegisteredUser = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $dbResult = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assert sui risultati recuperati
    assert($dbResult !== false);
    assert($dbResult['emailRegisteredUser'] === 'user@example.com');
    assert($dbResult['exercises'] === 'squat, push-up');
    assert((int)$dbResult['repetition'] === 3); // Cast the repetition value to an integer before comparing
    assert($dbResult['recovery'] === '1 min');

    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    echo "Test passato per il metodo saveObj.\n";
}
*/

function testGetTrainingCardsByEmail($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => 'user@example.com',
            'type' => 'registereduser'
        ]);
    }

    // Creare un oggetto ETrainingCard simulato
    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');

    // Salvare l'oggetto ETrainingCard nel database
    FTrainingCard::saveObj($trainingCard);

    // Chiamare il metodo da testare
    $dbResult = FTrainingCard::getTrainingCardsByEmail('user@example.com');



    // Assert sui risultati recuperati
    assert($dbResult !== false);
    assert($dbResult->getEmailRegisteredUser() === 'user@example.com');
    assert($dbResult->getExercises() === 'squat, push-up');
    assert((int)$dbResult->getRepetition() === 3);
    assert($dbResult->getRecovery() === '1 min');

    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);


    echo "Test passato per il metodo getTrainingCardsByEmail.\n";
}




function testFTrainingCardSaveObj($pdo) {
    // Creazione della classe di test FTrainingCardTest
    class FTrainingCardTest
    {

        // Variabile per connettersi al database
        private $db;

        // Costruttore per inizializzare la connessione al database
        public function __construct($db)
        {
            $this->db = $db;
        }

        // Metodo per eseguire il test dell'inserimento di un nuovo oggetto
        public function testSaveNewObj($pdo)
        {

            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->execute(['email' => 'test@example.com']);
            $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userExists) {
                // Insert user into 'user' table
                $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
                $stmt->execute([
                    'email' => 'test@example.com',
                    'username' => 'testuser',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'password' => password_hash('password123', PASSWORD_DEFAULT),
                    'role' => 'registereduser'
                ]);

                // Insert user into 'registereduser' table
                $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
                $stmt->execute([
                    'email' => 'test@example.com',
                    'type' => 'registereduser'
                ]);
            }


            // Creazione di un nuovo oggetto da salvare
            $newTrainingCard = new ETrainingCard('test@example.com', 'squat, push-up', 3, '1 min');
            echo "New Training Card Object: ";
            var_dump($newTrainingCard);

            // Chiamata al metodo saveObj per salvare il nuovo oggetto
            $result = FTrainingCard::saveObj($newTrainingCard);

            // Verifica del risultato
            if ($result !== false) {
                echo "Test inserimento nuovo oggetto passato: ID restituito " . $result . "\n";
            } else {
                echo "Test inserimento nuovo oggetto fallito\n";
            }

            // Pulizia: rimuovere l'oggetto inserito per lasciare il database nello stato originale
            $this->db->query("DELETE FROM trainingcard WHERE emailRegisteredUser = 'test@example.com'");
            $this->db->query("DELETE FROM user WHERE email = 'test@example.com'");
        }

        // Metodo per eseguire il test dell'aggiornamento di un oggetto esistente
        // Metodo per eseguire il test dell'aggiornamento di un oggetto esistente
        public function testUpdateExistingObj()
        {
            try {
                $this->db->beginTransaction();

                // Check if the user already exists
                $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
                $stmt->execute(['email' => 'existing@example.com']);
                $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$userExists) {
                    // If the user doesn't exist, insert a new row
                    $this->db->query("INSERT INTO user (email, username, first_name, last_name, password, role) VALUES ('existing@example.com', 'existinguser', 'Existing', 'User', 'existingpassword', 'registereduser')");
                    $this->db->query("INSERT INTO registereduser (email, type) VALUES ('existing@example.com', 'registereduser')");
                    $this->db->query("INSERT INTO trainingcard (emailRegisteredUser, exercises, repetition,recovery) VALUES ('existing@example.com', 'initial exercises', 3, '1 min')");
                }

                // Get the ID of the existing training card
                $stmt = $this->db->prepare("SELECT idTrainingCard FROM trainingcard WHERE emailRegisteredUser = 'existing@example.com'");
                $stmt->execute();
                $idTrainingCard = $stmt->fetch(PDO::FETCH_ASSOC)['idTrainingCard'];

                // Creazione di un oggetto da aggiornare
                $existingTrainingCard = new ETrainingCard('existing@example.com', 'initial exercises', 3, '1 min');
                echo "Existing Training Card Object: ";
                var_dump($existingTrainingCard);

                // Creazione di un array con i campi da aggiornare
                $fieldArray = [
                    ['exercises', 'updated squat, updated push-up'],
                    ['repetition', 4],
                    ['recovery', '2 min']
                ];
                echo "Field Array: ";
                var_dump($fieldArray);

                // Chiamata al metodo saveObj per aggiornare l'oggetto esistente
                $result = FTrainingCard::saveObj($existingTrainingCard, $fieldArray);

                // Verifica del risultato
                if ($result === true) {
                    echo "Test aggiornamento oggetto esistente passato\n";
                } else {
                    echo "Test aggiornamento oggetto esistente fallito\n";
                }


                // Verifica degli aggiornamenti nel database
                $stmt = $this->db->prepare("SELECT exercises, repetition, recovery FROM trainingcard WHERE idTrainingCard = :idTrainingCard");
                $stmt->execute(['idTrainingCard' => $idTrainingCard]);
                $updatedTrainingCard = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "Updated Training Card from Database: ";
                var_dump($updatedTrainingCard);

                if ($updatedTrainingCard['exercises'] == 'updated squat, updated push-up' && $updatedTrainingCard['repetition'] == 4 && $updatedTrainingCard['recovery'] == '2 min') {
                    echo "Verifica aggiornamenti nel database passata\n";
                } else {
                    echo "Verifica aggiornamenti nel database fallita\n";
                }

                $this->db->commit();
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Error during the connection to the database: " . $e->getMessage() . "\n";
            } finally {
                // Pulizia: rimuovere l'oggetto aggiornato per lasciare il database nello stato originale
                // Pulizia: rimuovere l'oggetto aggiornato per lasciare il database nello stato originale
                $stmt = $this->db->prepare("DELETE FROM trainingcard WHERE idTrainingCard = :idTrainingCard");
                $stmt->execute(['idTrainingCard' => $idTrainingCard]);
                $stmt = $this->db->prepare("DELETE FROM registereduser WHERE email = :email");
                $stmt->execute(['email' => 'existing@example.com']);
                $stmt = $this->db->prepare("DELETE FROM user WHERE email = :email");
                $stmt->execute(['email' => 'existing@example.com']);

            }
        }
    }

    // Creazione di un'istanza della classe di test
    $test = new FTrainingCardTest($pdo);

    // Esecuzione dei test
    $test->testSaveNewObj($pdo);
    $test->testUpdateExistingObj();
}



function createAndSaveTrainingCard($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => 'user@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => 'user@example.com',
            'type' => 'registereduser'
        ]);
    }


    // Creare un oggetto ETrainingCard simulato
    $trainingCard = new ETrainingCard('user@example.com', 'squat, push-up', 3, '1 min');

    // Salvare l'oggetto ETrainingCard nel database
    $save_result = FTrainingCard::saveObj($trainingCard);

    // Verificare se l'oggetto è stato salvato correttamente
    if ($save_result) {
        echo "L'oggetto ETrainingCard è stato salvato con successo.\n";
    } else {
        echo "Salvataggio dell'oggetto ETrainingCard non riuscito.\n";
    }
}






try {
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");

    testETrainingCard();
    testFTrainingCard($pdo);
    testCreateTrainingCardObj();
    testBind($pdo);
    testGetTrainingCardsByEmail($pdo);
    testFTrainingCardSaveObj($pdo);
    createAndSaveTrainingCard($pdo);

} catch (PDOException $e) {
    echo "Error during the connection to the database: " . $e->getMessage();
}

?>
