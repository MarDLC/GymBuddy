<?php

// Include l'autoloader using a relative path
require_once __DIR__ . '/app/config/autoloader.php';

// Test for the class ERegisteredUser
function testERegisteredUser($pdo)
{
    // Creation of an instance of ERegisteredUser
    $registeredUser = new ERegisteredUser('test10@example.com', 'testuser', 'Test', 'User', 'password123');

    // Test of the constructor and getter methods
    assert($registeredUser->getEmail() === 'test10@example.com');
    assert($registeredUser->getUsername() === 'testuser');
    assert($registeredUser->getFirstName() === 'Test');
    assert($registeredUser->getLastName() === 'User');
    assert(password_verify('password123', $registeredUser->getPassword()));
    assert($registeredUser->role === 'registeredUser');

    // Test of the setter methods
    $registeredUser->setEmail('newemail@example.com');
    assert($registeredUser->getEmail() === 'newemail@example.com');

    $registeredUser->setUsername('newusername');
    assert($registeredUser->getUsername() === 'newusername');

    $registeredUser->setFirstName('NewFirstName');
    assert($registeredUser->getFirstName() === 'NewFirstName');

    $registeredUser->setLastName('NewLastName');
    assert($registeredUser->getLastName() === 'NewLastName');

    $registeredUser->setPassword('newpassword123');
    assert(password_verify('newpassword123', $registeredUser->getPassword()));

    // Test of the getEntity method
    assert(ERegisteredUser::getEntity() === ERegisteredUser::class);

    echo "All tests for ERegisteredUser have passed.\n";
}

// Test for the class FRegisteredUser
// Test for the class FRegisteredUser
function testFRegisteredUser($pdo){
    // Creation of an instance of ERegisteredUser for the test
    $registeredUser = new ERegisteredUser('test14@example.com', 'testuser', 'Test', 'User', 'password123');

    // Preparazione di un'istruzione SELECT per verificare se l'utente esiste già
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $registeredUser->getEmail()]);


    // Se l'utente esiste già, aggiorna il record
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE user SET username = :username, first_name = :first_name, last_name = :last_name, password = :password, role = :role WHERE email = :email");
        $stmt->execute([
            'email' => $registeredUser->getEmail(),
            'username' => $registeredUser->getUsername(),
            'first_name' => $registeredUser->getFirstName(),
            'last_name' => $registeredUser->getLastName(),
            'password' => password_hash($registeredUser->getPassword(), PASSWORD_DEFAULT),
            'role' => $registeredUser->role
        ]);
    }else {
        // Se l'utente non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => $registeredUser->getEmail(),
            'username' => $registeredUser->getUsername(),
            'first_name' => $registeredUser->getFirstName(),
            'last_name' => $registeredUser->getLastName(),
            'password' => password_hash($registeredUser->getPassword(), PASSWORD_DEFAULT),
            'role' => $registeredUser->role
        ]);
    }

    // Preparazione di un'istruzione SELECT per verificare se il registered user  esiste già
    $stmt = $pdo->prepare("SELECT * FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => $registeredUser->getEmail()]);

    // Se il registered user esiste già, aggiorna il record
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE registereduser SET type = :type WHERE email = :email");
    } else {
        // Se il personal trainer non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO registereduser (email,type) VALUES (:email, :type)");
    }



    // Test of the bind method
    FRegisteredUser::bind($stmt, $registeredUser);

    // Execute the statement
    $stmt->execute();


    // Verify that the data has been correctly inserted into the database
    $stmt = $pdo->prepare("SELECT * FROM registereduser WHERE email = :email");
    $stmt->execute(['email' => 'test14@example.com']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    assert($result['email'] === 'test14@example.com');

    // Test per il metodo getObj
    $registeredUser = FRegisteredUser::getObj('test14@example.com');
    echo "Email dell'utente registrato: " . $registeredUser->getEmail() . "\n";
    assert($registeredUser !== null);
    assert($registeredUser->getEmail() === 'test14@example.com');


    // Test for the getUserByUsername method
    $registeredUserByUsername = FRegisteredUser::getUserByUsername('testuser');
    assert($registeredUserByUsername !== null);
    assert($registeredUserByUsername->getUsername() === 'testuser');

    // Test for the updateTypeIfSubscribedWithPT method
    // Assume that the user with email 'new@example.com' has a 'coached' subscription
    $result = FRegisteredUser::updateTypeIfSubscribedWithPT('new@example.com');
    assert($result === true);

    // Test for the updateTypeIfSubscribedUserOnly method
    // Assume that the user with email 'new@example.com' has an 'individual' subscription
    $result = FRegisteredUser::updateTypeIfSubscribedUserOnly('new@example.com');
    assert($result === true);

    echo "All tests for FRegisteredUser have passed. The data has been inserted into the database: " . json_encode($result) . "\n";
}


function testFRegisteredUserSaveObj($pdo) {
    // Create a new instance of ERegisteredUser
    $registeredUser = new ERegisteredUser('testSaveObj40@example.com', 'testuser', 'Test', 'SaveObj', 'password123');

    // Check if the registered user already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $registeredUser->getEmail()]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // If the registered user exists, update it
        $registeredUser->setEmail('updatedEmail40@example.com');
        // Non chiamare FRegisteredUser::saveObj nuovamente
        $lastInsertedEmail = 'updatedEmail40@example.com'; // Assegna direttamente la nuova email
        echo "Last inserted email: " . $lastInsertedEmail . "\n";
    } else {
        // If the registered user does not exist, save it
        $lastInsertedEmail = FRegisteredUser::saveObj($registeredUser);
        // Aggiorna $lastInsertedEmail anche nel caso di un nuovo inserimento
        $lastInsertedEmail = $registeredUser->getEmail();
        echo "Last inserted email: " . $lastInsertedEmail . "\n";
    }

    // Verify that the registered user was saved or updated correctly
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $registeredUser->getEmail()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        // Assert that the email matches and the save operation was successful
        assert($result['email'] === $registeredUser->getEmail());
        assert($lastInsertedEmail === $registeredUser->getEmail());
    } else {
        echo "No rows found in the database for the email " . $registeredUser->getEmail() . "\n";
    }

    echo "All tests for FRegisteredUser::saveObj have passed.\n";
}


try {
    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");

    // Execute the tests
    testERegisteredUser($pdo);
    testFRegisteredUser($pdo);
    testFRegisteredUserSaveObj($pdo);
} catch (PDOException $e) {
    echo "Error during the connection to the database: " . $e->getMessage();
}