<?php

// ToDo : Vérifier que la connexion est OK
$db = new PDO("pgsql:host=localhost;dbname=X","X","X");

// Pour éviter d'avoir à réutiliser "global" par la suite
function db() { global $db; return $db; }

