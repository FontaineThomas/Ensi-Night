<?php

include 'db.php';

if ($_GET['name'] == null || $_GET['score'] == null) {
    return;
}

$pdo->query(`INSERT INTO nuitinfo_scores VALUES("{$_GET['name']}",{$_GET['score']}`);

?>