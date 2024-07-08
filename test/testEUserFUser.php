<?php

// Include l'autoloader usando un percorso relativo
require_once 'C:\\xampp\\htdocs\\BetaTestGymBuddy\\app\\config\\autoloader.php';

// Test per la classe EUser
function testEUser($pdo) {
    // Creazione di un'istanza di EUser
    $user = new EUser('test2@example.com', 'testuser', 'Test', 'User', 'password123', 'user');

    // Test del costruttore e dei metodi getter
    assert($user->getEmail() === 'test2@example.com');
    assert($user->getUsername() === 'testuser');
    assert($user->getFirstName() === 'Test');
    assert($user->getLastName() === 'User');
    assert(password_verify('password123', $user->getPassword()));
    assert($user->role === 'user');

    // Test dei metodi setter
    $user->setEmail('newemail@example.com');
    assert($user->getEmail() === 'newemail@example.com');

    $user->setUsername('newusername');
    assert($user->getUsername() === 'newusername');

    $user->setFirstName('NewFirstName');
    assert($user->getFirstName() === 'NewFirstName');

    $user->setLastName('NewLastName');
    assert($user->getLastName() === 'NewLastName');

    $user->setPassword('newpassword123');
    assert(password_verify('newpassword123', $user->getPassword()));

    // Test del metodo getEntity
    assert(EUser::getEntity() === EUser::class);

    echo "Tutti i test per EUser sono passati.\n";
}

// Test per la classe FUser
function testFUser($pdo) {
    // Test dei metodi statici
    assert(FUser::getTable() === 'user');
    assert(FUser::getValue() === '(:email,:username,:first_name,:last_name,:password,:role)');
    assert(FUser::getClass() === 'FUser');
    assert(FUser::getKey() === 'email');

    // Creazione di un'istanza di EUser per il test
    $user = new EUser('test2@example.com', 'testuser', 'Test', 'User', 'password123', 'user');

    // Prepara un'istruzione
    $stmt = $pdo->prepare("INSERT INTO user (email, username, first_name, last_name, password, role) VALUES (:email, :username, :first_name, :last_name, :password, :role)");

    // Test del metodo bind
    FUser::bind($stmt, $user);

    // Esegui l'istruzione
    $stmt->execute();

    // Verifica che i dati siano stati correttamente inseriti nel database
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->execute(['email' => 'test2@example.com']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    assert($result['email'] === 'test2@example.com');
    assert($result['username'] === 'testuser');
    assert($result['first_name'] === 'Test');
    assert($result['last_name'] === 'User');
    assert(password_verify('password123', $result['password']));
    assert($result['role'] === 'user');

    echo "Tutti i test per FUser sono passati. I dati sono stati inseriti nel database: " . json_encode($result) . "\n";
}

try {
    // Connessione al database
    $pdo = new PDO("mysql:host=localhost;dbname=gymbuddy", "root", "");

    // Esegui i test
    testEUser($pdo);
    testFUser($pdo);
} catch (PDOException $e) {
    echo "Errore durante la connessione al database: " . $e->getMessage();
}