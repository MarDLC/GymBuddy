<?php

require_once 'C:\\xampp\\htdocs\\BetaTestGymBuddy\\app\\config\\autoloader.php';

function testEPhysicalData() {
    $physicalData= new EPhysicalData('user@example.com', 'uomo', 1.75, '80', '70', '10', '25');

    assert($physicalData->getEmailRegisteredUser() === 'user@example.com');
     assert($physicalData->getSex() === 'uomo');
    assert($physicalData->getHeight() === 1.75);
    assert($physicalData->getWeight() === '80');
    assert($physicalData->getLeanMass() === '70');
    assert($physicalData->getFatMass() === '10');


    $physicalData->setEmailRegisteredUser('newuser@example.com');
    assert($physicalData->getEmailRegisteredUser() === 'newuser@example.com');

    $physicalData->setSex('donna');
    assert($physicalData->getSex() === 'donna');

    $physicalData->setHeight(1.80);
    assert($physicalData->getHeight() === 1.80);

    $physicalData->setWeight('75');
    assert($physicalData->getWeight() === '75');

    $physicalData->setLeanMass('65');
    assert($physicalData->getLeanMass() === '65');

    $physicalData->setFatMass('15');
    assert($physicalData->getFatMass() === '15');

    assert(EPhysicalData::getEntity() === EPhysicalData::class);

    echo "All tests for EPhysicalData have passed.\n";


}

function testFPhysicalData($pdo) {
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

    $physicalData= new EPhysicalData('user@example.com', 'uomo', 1.75, '80', '70', '10', '25');
    $creation_time = $physicalData->getTimeStr(); // Get the creation_time from the trainingCard object

    $stmt = $pdo->prepare("SELECT * FROM physicaldata WHERE idPhysicalData = :id");
    $stmt->execute(['id' => $physicalData->getIdPhysicalData()]);

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE physicaldata SET emailRegisteredUser = :email, sex = :sex, height= :height, weight = :weight, leanMass= :leanMass, fatMass= :fatMass, bmi= :bmi, creation_time = :creation_time WHERE idPhysicalData = :id");
        $stmt->execute([
            'id' => $physicalData->getIdPhysicalData(),
            'email' => $physicalData->getEmailRegisteredUser(),
            'sex' => $physicalData->getSex(),
            'height' => $physicalData->getHeight(),
            'weight' => $physicalData->getWeight(),
            'leanMass' => $physicalData->getLeanMass(),
            'fatMass' => $physicalData->getFatMass(),
            'bmi' => $physicalData->getBmi(),
            'creation_time' => $creation_time // Update the creation_time
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO physicaldata (emailRegisteredUser, sex, height, weight, leanMass, fatMass, bmi, creation_time) VALUES (:email, :sex, :height, :weight, :leanMass, :fatMass, :bmi, :creation_time)");
        $stmt->execute([
            'email' => $physicalData->getEmailRegisteredUser(),
            'sex' => $physicalData->getSex(),
            'height' => $physicalData->getHeight(),
            'weight' => $physicalData->getWeight(),
            'leanMass' => $physicalData->getLeanMass(),
            'fatMass' => $physicalData->getFatMass(),
            'bmi' => $physicalData->getBmi(),
            'creation_time' => $creation_time // Insert the creation_time
        ]);
        $physicalData->setIdPhysicalData($pdo->lastInsertId());
    }



    $stmt = $pdo->prepare("SELECT * FROM physicaldata WHERE idPhysicalData = :id");
    $stmt->execute(['id' => $physicalData->getIdPhysicalData()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    // Assert on the retrieved object
    assert($result !== false);
    assert($result['emailRegisteredUser'] === 'user@example.com');
    assert($result['sex'] === 'uomo');
    assert($result['height'] == 1.75);
    assert($result['weight'] == '80');
    assert($result['leanMass'] == '70');
    assert($result['fatMass'] == '10');
    assert($result['bmi'] == '25');



    // Assert sull'oggetto recuperato tramite FPhysicalData::getObj()
    $retrievedData = FPhysicalData::getObj($physicalData->getIdPhysicalData());
    assert($retrievedData !== null);
    assert($retrievedData->getEmailRegisteredUser() === 'user@example.com');
    assert($retrievedData->getSex() === 'uomo');
    assert($retrievedData->getHeight() == 1.75);
    assert($retrievedData->getWeight() == '80');
    assert($retrievedData->getLeanMass() == '70');
    assert($retrievedData->getFatMass() == '10');
    assert($retrievedData->getBmi() == '25');

    echo "Test passato per il metodo getObj.\n";


    // Elimina physicalData dal database
    $result = FPhysicalData::deletePhysicalDataInDb($physicalData->getIdPhysicalData());
    assert($result);
    echo "Test passato per il metodo deletePhysicalDataInDb.\n";

    // Verifica che il physical data sia stato eliminato
    $stmt = $pdo->prepare("SELECT * FROM physicaldata WHERE idPhysicalData= :id");
    $stmt->execute(['id' => $physicalData->getIdPhysicalData()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    assert($result === false);
    echo "Test passato per la verifica dell'eliminazione del physicalData .\n";


    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    echo "All tests for FPhysicalData have passed.\n";
}

function testCreatePhysicalDataObj() {
    // Creare un array di risultati di query simulati
    $queryResult = [
        [
            'emailRegisteredUser' => 'user@example.com',
            'sex' => 'uomo',
            'height' => 1.75,
            'weight' => '80',
            'leanMass' => '70',
            'fatMass' => '10',
            'bmi' => '25',
            'creation_time' => '2024-06-21 19:30:57',
            'idPhysicalData' => '1',
            'emailPersonalTrainer' => 'trainer@example.com'
        ]
    ];

    // Chiamare il metodo da testare
    $physicalData = FPhysicalData::createPhysicalDataObj($queryResult);

    // Assert sull'oggetto restituito
    assert($physicalData !== null);
    assert($physicalData->getEmailRegisteredUser() === 'user@example.com');
    assert($physicalData->getSex() === 'uomo');
    assert($physicalData->getHeight() == 1.75);
    assert($physicalData->getWeight() == '80');
    assert($physicalData->getLeanMass() == '70');
    assert($physicalData->getFatMass() == '10');
    assert($physicalData->getBmi() == '25');
    assert($physicalData->getIdPhysicalData() == 1);
    assert($physicalData->getTime()->format('Y-m-d H:i:s') === '2024-06-21 19:30:57');
    assert($physicalData->getEmailPersonalTrainer() === 'trainer@example.com');

    echo "Test passato per il metodo createPhysicalDataObj.\n";
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

    // Creare un oggetto EPhysicalData simulato
    $physicalData= new EPhysicalData('user@example.com', 'uomo', 1.75, '80', '70', '10', '25');

    // Creare un'istruzione SQL simulata
    $sql = "INSERT INTO physicaldata (emailRegisteredUser, sex, height, weight, leanMass, fatMass, bmi, emailPersonalTrainer, creation_time) VALUES (:emailRegisteredUser, :sex, :height, :weight, :leanMass, :fatMass, :bmi, :emailPersonalTrainer, :creation_time)";
    $stmt = $pdo->prepare($sql);

    // Chiamare il metodo da testare
    FPhysicalData::bind($stmt, $physicalData);

    // Eseguire l'istruzione SQL
    $stmt->execute();

    // Verificare che i valori siano stati inseriti correttamente nel database
    $stmt = $pdo->prepare("SELECT * FROM physicaldata WHERE emailRegisteredUser = :email");
    $stmt->execute(['email' => 'user@example.com']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assert sui risultati recuperati
    assert($result !== false);
    assert($result['emailRegisteredUser'] === 'user@example.com');
    assert($result['sex'] === 'uomo');
    assert($result['height'] == 1.75);
    assert($result['weight'] == '80');
    assert($result['leanMass'] == '70');
    assert($result['fatMass'] == '10');
    assert($result['bmi'] == '25');


    // Pulizia del database
    $stmt = $pdo->prepare("DELETE FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    $stmt = $pdo->prepare("DELETE FROM user WHERE email = :email");
    $stmt->execute(['email' => 'user@example.com']);

    echo "Test passato per il metodo bind.\n";
}

function createAndSavePhysicalData($pdo) {
    $email = 'user@example.com';

    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userExists) {
        // Insert user into 'user' table
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) 
                           VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => $email,
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'registereduser'
        ]);

        // Insert user into 'registereduser' table
        $stmt = $pdo->prepare("INSERT INTO registereduser (email, type) VALUES (:email, :type)");
        $stmt->execute([
            'email' => $email,
            'type' => 'registereduser'
        ]);
    }


        // Creare un oggetto ETrainingCard simulato
        $physicalData = new EPhysicalData($email, 'uomo', 1.75, '80', '70', '10', '25');

        // Salvare l'oggetto ETrainingCard nel database
        $save_result = FPhysicalData::saveObj($physicalData);

        // Verificare se l'oggetto è stato salvato correttamente
        if ($save_result) {
            echo "L'oggetto EPhysicalData è stato salvato con successo.\n";
        } else {
            echo "Salvataggio dell'oggetto EPhysicalData non riuscito.\n";
        }

}






try {
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");


    testEPhysicalData();
    testFPhysicalData($pdo);
    testCreatePhysicalDataObj();
    testBind($pdo);
    createAndSavePhysicalData($pdo);

} catch (PDOException $e) {
    echo "Error during the connection to the database: " . $e->getMessage();
}

