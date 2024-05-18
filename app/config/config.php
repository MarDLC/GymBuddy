<?php

//Database Connection
define('DB_HOST', 'localhost');
define('DB_NAME', 'gymbuddy');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SQL_FILE_PATH', 'gymbuddy.sql');

//Web APP parameter for custom app
// Parametri personalizzati per l'applicazione web
define('MAX_NEWS_TITLE_LENGTH', 255);
define('MAX_SUBSCRIPTION_DURATION', 12); // max 1 year
define('MAX_CREDIT_CARD_NUMBER', 1); // max credit card per user
define('MAX_PHYSICAL_DATA_ENTRIES', 100); // max physical data per user
define('MAX_RESERVATIONS', 1); // max reservation number per user
define('MAX_TRAINING_CARD_ENTRIES', 50); // max training cards per user
define('MAX_USERNAME_LENGTH', 255);
define('MAX_FIRST_NAME_LENGTH', 255);
define('MAX_LAST_NAME_LENGTH', 255);

//session coockie expiration
define('COOKIE_EXP_TIME', 2592000); // 30 days in seconds