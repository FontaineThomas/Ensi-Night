<?php

session_start();

if (!isset($invisible_button)) {
    $invisible_button = '';
}

$dbhost = 'magicalfubby.com';
$dbuser = 'zarobase';
$dbpass = 'Password123!';
$dbname = 'zarobase';
$tablename = 'nuitinfo_questions';
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);

if(isset($_POST['numberplayer'])){
    for($i=1;$i<=$_POST['numberplayer'];$i++){
        $_SESSION[$i]=0;
    }
    $_SESSION['currentplayer'] = 1;
    $_SESSION['numberplayer'] = $_POST['numberplayer'] ;
}

if(isset($_POST['draw'])){
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'quiz') {
        $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`" . $tablename . " ORDER BY rand() LIMIT 1;");
    }
    $_SESSION['rightanswer'] = $result[6];
}

if(isset($_POST['answered'])){
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'quiz') {
        if($_POST['answered'] == $_SESSION['rightanswer']){
            $_SESSION[$_SESSION['currentplayer']]++;
        }
        if(isset($_SESSION['']))
        if($_SESSION['currentplayer']+1 == $_SESSION['numberplayer']){
            $_SESSION['currentplayer'] = 0;
        }
    }
}

function affichage_response(){
    echo '<table class="response-tab">
    <tr>
        <td>
            <input type="submit" class="btn btn-dark responses" value="Reponse" name="reponse">
        </td>
        <td>
            <input type="submit" class="btn btn-dark responses" value="Reponse" name="reponse">
        </td>
    </tr>
    <tr>
        <td>
            <input type="submit" class="btn btn-dark responses" value="Reponse" name="reponse">
        </td>
        <td>
            <input type="submit" class="btn btn-dark responses" value="Reponse" name="reponse">
        </td>
    </tr>
</table>';
}

?>