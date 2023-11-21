<?php ob_start(); ?>
<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$host = $_ENV["HOST"];
$user = $_ENV["USER"];
$pass = $_ENV["PASSWORD"];
$name = $_ENV["NAME"];

$connection = mysqli_connect($host, $user, $pass, $name);
// if ($connection) {
//     echo "We are connected!"; 
// }

?>