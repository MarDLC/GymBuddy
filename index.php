<?php
// Abilita il reporting degli errori (utile per debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includi autoloader e altri file di configurazione
require_once __DIR__ . "/app/config/autoloader.php";
require_once __DIR__ . "/app/install/StartSmarty.php";
require_once __DIR__ . "/app/install/Installation.php";

// Esegui eventuali installazioni o setup necessari
Installation::install();

// Crea un'istanza del Front Controller e esegui l'applicazione
$fc = new CFrontController();
$fc->run($_SERVER['REQUEST_URI']);
