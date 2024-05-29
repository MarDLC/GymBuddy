<?php
// Include l'autoloader usando un percorso relativo
require_once __DIR__ . '/app/config/autoloader.php';




// Test per la classe EUser
function testEUser() {
    // Creazione di un'istanza di EUser
    $user = new EUser('test@example.com', 'testuser', 'Test', 'User', 'password123');

    // Test del costruttore e dei metodi getter
    assert($user->getEmail() === 'test@example.com');
    assert($user->getUsername() === 'testuser');
    assert($user->getFirstName() === 'Test');
    assert($user->getLastName() === 'User');
    assert(password_verify('password123', $user->getPassword()));

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
function testFUser() {
    // Test dei metodi statici
    assert(FUser::getTable() === 'user');
    assert(FUser::getValue() === '(:email,:username,:first_name,:last_name,:password,:role)');
    assert(FUser::getClass() === 'FUser');
    assert(FUser::getKey() === 'email');

    // Mock di PDOStatement
    $mockStmt = new class {
        private $params = [];
        public function bindValue($param, $value, $type) {
            $this->params[$param] = $value;
        }
        public function getParams() {
            return $this->params;
        }
    };

    // Creazione di un'istanza di EUser per il test
    $user = new EUser('test@example.com', 'testuser', 'Test', 'User', 'password123');

    // Test del metodo bind
    FUser::bind($mockStmt, $user);
    $params = $mockStmt->getParams();
    assert($params[':email'] === 'test@example.com');
    assert($params[':username'] === 'testuser');
    assert($params[':first_name'] === 'Test');
    assert($params[':last_name'] === 'User');
    assert(password_verify('password123', $params[':password']));
    assert($params[':role'] === $user->role);

    echo "Tutti i test per FUser sono passati.\n";
}

// Esegui i test
testEUser();
testFUser();


