<?php
// Include le classi necessarie
/*require_once __DIR__ . '/app/models/EPersonalTrainer.php';
require_once __DIR__ . '/app/models/EPhysicalData.php';
require_once __DIR__ . '/app/controllers/CPersonalTrainer.php';
require_once __DIR__ . '/app/services/TechnicalServiceLayer/utility/UCookie.php';
require_once __DIR__ . '/app/services/TechnicalServiceLayer/utility/USession.php'; */
require_once __DIR__ . '/app/config/autoloader.php';



// Crea un'istanza delle classi che vuoi testare
$personalTrainer = new EPersonalTrainer('nome', 'cognome', 'email@example.com', 'password', 'username');
$physicalData = new EPhysicalData(
    'email@example.com', // email dell'utente registrato
    'Esercizio 1, Esercizio 2, Esercizio 3', // esercizi
    10, // conteggio delle ripetizioni
    '5 minuti', // tempo di recupero
    'trainer@example.com', // email del personal trainer
    1, // ID della scheda di allenamento
    $personalTrainer, // istanza di EPersonalTrainer
    'parametro aggiuntivo' // parametro aggiuntivo
);

// Invoca i metodi che vuoi testare
try {
    CPersonalTrainer::showPhysicalDataForm();
    CPersonalTrainer::createPhysicalData();
    CPersonalTrainer::viewPhysicalData('email@example.com');
    CPersonalTrainer::deletePhysicalData('email@example.com');
    // ...e così via per tutti i metodi che vuoi testare
} catch (Exception $e) {
    echo 'Errore: ' . $e->getMessage();
}
