<?php

//Is this the production server or not?
if(isset($_ENV['PRODUCTION'])){
    define('PRODUCTION', true);
} else{
    define('PRODUCTION', false);
}

if (PRODUCTION) {
    define('DB_SERVER', $_ENV['DB_SERVER']);
    define('DB_USERNAME', $_ENV['DB_USERNAME']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);
}
else {
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'votesystem');
}