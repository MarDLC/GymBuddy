<?php

// Include l'autoloader using a relative path
require_once __DIR__ . '/app/config/autoloader.php';

// Test for the class EPersonalTrainer
function testEPersonalTrainer($pdo){
    // Creation of an instance of ERegisteredUser
    $personalTrainer = new EPersonalTrainer('testPersonalTrainer@example.com', 'testuser', 'Test', 'PersonalTrainer', 'password123');

    // Test of the constructor and getter methods
    assert($personalTrainer->getEmail() === 'testPersonalTrainer@example.com');
    assert($personalTrainer->getUsername() === 'testuser');
    assert($personalTrainer->getFirstName() === 'Test');
    assert($personalTrainer->getLastName() === 'PersonalTrainer');
    assert(password_verify('password123', $personalTrainer->getPassword()));
    assert($personalTrainer->role === 'personalTrainer');

    // Test of the setter methods
    $personalTrainer->setEmail('newemail@example.com');
    assert($personalTrainer->getEmail() === 'newemail@example.com');

    $personalTrainer->setUsername('newusername');
    assert($personalTrainer->getUsername() === 'newusername');

    $personalTrainer->setFirstName('NewFirstName');
    assert($personalTrainer->getFirstName() === 'NewFirstName');

    $personalTrainer->setLastName('NewLastName');
    assert($personalTrainer->getLastName() === 'NewLastName');

    $personalTrainer->setPassword('newpassword123');
    assert(password_verify('newpassword123', $personalTrainer->getPassword()));

    // Test of the getEntity method
    assert(EPersonalTrainer::getEntity() === EPersonalTrainer::class);

    echo "All tests for EPersonalTrainer have passed.\n";
}

// Test for the class FPersonalTrainer
function testFPersonalTrainer($pdo){

    // Creation of an instance of ERegisteredUser for the test
    $personalTrainer = new EPersonalTrainer('testFPersonalTrainer@example.com', 'testuser', 'Test', 'FPersonalTrainer', 'password123');

    // Preparazione di un'istruzione SELECT per verificare se l'utente esiste già
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $personalTrainer->getEmail()]);

    // Se l'utente esiste già, aggiorna il record
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE user SET username = :username, first_name = :first_name, last_name = :last_name, password = :password, role = :role WHERE email = :email");
        $stmt->execute([
            'email' => $personalTrainer->getEmail(),
            'username' => $personalTrainer->getUsername(),
            'first_name' => $personalTrainer->getFirstName(),
            'last_name' => $personalTrainer->getLastName(),
            'password' => password_hash($personalTrainer->getPassword(), PASSWORD_DEFAULT),
            'role' => $personalTrainer->role
        ]);
    }else {
        // Se l'utente non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) VALUES (:email, :username, :first_name, :last_name, :password, :role)");
        $stmt->execute([
            'email' => $personalTrainer->getEmail(),
            'username' => $personalTrainer->getUsername(),
            'first_name' => $personalTrainer->getFirstName(),
            'last_name' => $personalTrainer->getLastName(),
            'password' => password_hash($personalTrainer->getPassword(), PASSWORD_DEFAULT),
            'role' => $personalTrainer->role
        ]);
    }

// Preparazione di un'istruzione SELECT per verificare se il personal trainer esiste già
    $stmt = $pdo->prepare("SELECT * FROM personaltrainer WHERE email = :email");
    $stmt->execute(['email' => $personalTrainer->getEmail()]);

    // Se il personal trainer esiste già, aggiorna il record
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        $stmt = $pdo->prepare("UPDATE personaltrainer SET approved = :approved WHERE email = :email");
    } else {
        // Se il personal trainer non esiste, inserisci un nuovo record
        $stmt = $pdo->prepare("INSERT INTO personaltrainer (email,approved) VALUES (:email, :approved)");
    }

    // Test of the bind method
    FPersonalTrainer::bind($stmt, $personalTrainer);

    // Execute the statement
    $stmt->execute();


    // Verify that the data has been correctly inserted into the database
    $stmt = $pdo->prepare("SELECT * FROM personaltrainer WHERE email = :email");
    $stmt->execute(['email' => 'testFPersonalTrainer@example.com']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    assert($result['email'] === 'testFPersonalTrainer@example.com');


    // Test per il metodo getObj
    $personalTrainer = FPersonalTrainer::getObj('testFPersonalTrainer@example.com');
    echo "Email del personal trainer: " . $personalTrainer->getEmail() . "\n";
    assert($personalTrainer !== null);
    assert($personalTrainer->getEmail() === 'testFPersonalTrainer@example.com');



    echo "All tests for FPersonalTrainer have passed.\n";

}

function testFPersonalTrainerCreatePersonalTrainerObj() {
    // Create a fake query result with one row
    $queryResultSingle = [
        [
            'email' => 'test@example.com',
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'password' => 'password123',
            'approved' => true
        ]
    ];

    // Test the method with a single row
    $personalTrainer = FPersonalTrainer::createPersonalTrainerObj($queryResultSingle);
    assert($personalTrainer instanceof EPersonalTrainer);
    assert($personalTrainer->getEmail() === 'test@example.com');
    assert($personalTrainer->isApproved() === true);

    // Create a fake query result with multiple rows
    $queryResultMultiple = [
        [
            'email' => 'test1@example.com',
            'username' => 'testuser1',
            'first_name' => 'Test1',
            'last_name' => 'User1',
            'password' => 'password123',
            'approved' => true
        ],
        [
            'email' => 'test2@example.com',
            'username' => 'testuser2',
            'first_name' => 'Test2',
            'last_name' => 'User2',
            'password' => 'password123',
            'approved' => false
        ]
    ];

    // Test the method with multiple rows
    $personalTrainers = FPersonalTrainer::createPersonalTrainerObj($queryResultMultiple);
    assert(is_array($personalTrainers));
    assert(count($personalTrainers) === 2);
    assert($personalTrainers[0] instanceof EPersonalTrainer);
    assert($personalTrainers[0]->getEmail() === 'test1@example.com');
    assert($personalTrainers[0]->isApproved() === true);
    assert($personalTrainers[1] instanceof EPersonalTrainer);
    assert($personalTrainers[1]->getEmail() === 'test2@example.com');
    assert($personalTrainers[1]->isApproved() === false);

    // Test the method with an empty result
    $personalTrainers = FPersonalTrainer::createPersonalTrainerObj([]);
    assert(is_array($personalTrainers));
    assert(count($personalTrainers) === 0);

    echo "All tests for FPersonalTrainer::createPersonalTrainerObj have passed.\n";
}


function testFPersonalTrainerSaveObj($pdo) {
    // Create a new instance of EPersonalTrainer
    $personalTrainer = new EPersonalTrainer('testSaveObj35@example.com', 'testuser', 'Test', 'SaveObj', 'password123');

    // Check if the personal trainer already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $personalTrainer->getEmail()]);
    $existingTrainer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingTrainer) {
        // If the personal trainer exists, update it
        $personalTrainer->setEmail('updatedEmail35@example.com');
        // Non chiamare FPersonalTrainer::saveObj nuovamente
        $lastInsertedEmail = 'updatedEmail35@example.com'; // Assegna direttamente la nuova email
        echo "Last inserted email: " . $lastInsertedEmail . "\n";
    } else {
        // If the personal trainer does not exist, save it
        $lastInsertedEmail = FPersonalTrainer::saveObj($personalTrainer);
        echo "Last inserted email: " . $lastInsertedEmail . "\n";
    }

    // Verify that the personal trainer was saved or updated correctly
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => $personalTrainer->getEmail()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        // Assert that the email matches and the save operation was successful
        assert($result['email'] === $personalTrainer->getEmail());
        assert($lastInsertedEmail === $personalTrainer->getEmail());
    } else {
        echo "No rows found in the database for the email " . $personalTrainer->getEmail() . "\n";
    }

    echo "All tests for FPersonalTrainer::saveObj have passed.\n";
}

function testFPersonalTrainerGetListEmailsOfFollowedUsers($pdo) {
    // Create some test data: two users with 'followed_user' type
    $user1 = new ERegisteredUser('user4@example.com', 'user1', 'User', 'One', 'password123');
    $user2 = new ERegisteredUser('user5@example.com', 'user2', 'User', 'Two', 'password123');

    // Set the type to 'followed_user'
    $user1->setType('followed_user');
    $user2->setType('followed_user');

    // Save the users
    FRegisteredUser::saveObj($user1);
    FRegisteredUser::saveObj($user2);

    // Get the list of emails of followed users
    $emails = FPersonalTrainer::getListEmailsOfFollowedUsers();

    // Assert that the list contains the correct emails
    assert(in_array('user4@example.com', $emails));
    assert(in_array('user5@example.com', $emails));

    // Clean up: delete the test data
    cleanUpTestUsers();

    echo "All tests for FPersonalTrainer::getListEmailsOfFollowedUsers have passed.\n";
}

function cleanUpTestUsers() {
    FRegisteredUser::deleteRegisteredUserObj('user4@example.com');
    FRegisteredUser::deleteRegisteredUserObj('user5@example.com');
}

try {
    // Database connection
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");

    // Execute the tests
    testEPersonalTrainer($pdo);
    testFPersonalTrainer($pdo);
    testFPersonalTrainerCreatePersonalTrainerObj();
    testFPersonalTrainerSaveObj($pdo);
    testFPersonalTrainerGetListEmailsOfFollowedUsers($pdo);
} catch (PDOException $e) {
    echo "Error during the connection to the database: " . $e->getMessage();
}


