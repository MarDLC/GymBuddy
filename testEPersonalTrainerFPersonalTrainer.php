<?php
// Include l'autoloader usando un percorso relativo
require_once __DIR__ . '/app/config/autoloader.php';

// Test per la classe EPersonalTrainer
function testEPersonalTrainer() {
    // Creazione di un'istanza di EPersonalTrainer
    $personalTrainer = new EPersonalTrainer('trainer@example.com', 'traineruser', 'Trainer', 'User', 'password123');

    // Test del costruttore e dei metodi getter
    assert($personalTrainer->getEmail() === 'trainer@example.com');
    assert($personalTrainer->getUsername() === 'traineruser');
    assert($personalTrainer->getFirstName() === 'Trainer');
    assert($personalTrainer->getLastName() === 'User');
    assert(password_verify('password123', $personalTrainer->getPassword()));
    assert($personalTrainer->isApproved() === false);

    // Test del metodo getEntity
    assert(EPersonalTrainer::getEntity() === EPersonalTrainer::class);

    // Test del metodo setApproved
    $personalTrainer->setApproved(true);
    assert($personalTrainer->isApproved() === true);

    echo "Tutti i test per EPersonalTrainer sono passati.\n";
}

// Test per la classe FPersonalTrainer
function testFPersonalTrainer() {
    // Creazione di un'istanza di EPersonalTrainer per il test
    $personalTrainer = new EPersonalTrainer('trainer@example.com', 'traineruser', 'Trainer', 'User', 'password123');
    $personalTrainer->setApproved(true);

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

    // Test del metodo bind
    FPersonalTrainer::bind($mockStmt, $personalTrainer);
    $params = $mockStmt->getParams();
    assert($params[':email'] === 'trainer@example.com');
    assert($params[':approved'] === true);

    echo "Tutti i test per FPersonalTrainer sono passati.\n";
}

// Esegui i test
testEPersonalTrainer();
testFPersonalTrainer();
