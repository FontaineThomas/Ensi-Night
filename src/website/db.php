<?php

session_start();

if (!isset($invisible_button)) {
    $invisible_button = '
    <div class="center_div draw_card">
    <form method="post">
        <input type="submit" class="btn btn-dark center_button" visibility="" value="Tirer une carte" name="draw">
    </form>
    </div>
    ';
}

if (!isset($class_card)) {
    $class_card = ' ';
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
    $cards = $result->fetch();
    $_SESSION['awnser1'] = $cards[2];
    $_SESSION['awnser2'] = $cards[3];
    $_SESSION['awnser3'] = $cards[4];
    $_SESSION['awnser4'] = $cards[5];
    $_SESSION['rightanswer'] = $cards[6];
    $invisible_button = '';
    affichage_response();
}

if(isset($_POST['answered'])){
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'quiz') {
        if($_POST['reponse'] == $_SESSION['rightanswer']){
            $_SESSION[$_SESSION['currentplayer']]++;
        }
        if(isset($_SESSION['']))
        if($_SESSION['currentplayer']+1 == $_SESSION['numberplayer']){
            $_SESSION['currentplayer'] = 0;
        }
        $invisible_button = '
<div class="center_div draw_card">
    <form method="post">
        <input type="submit" class="btn btn-dark center_button" value="Tirer une carte" name="draw">
    </form>
</div>';
        $class_card ="anim";
    }
}

function affichage_response(){
    echo '<table class="response-tab">
    <tr>
        <td>
            <form>
                <input type="submit" class="btn btn-dark responses" value="' . $_SESSION['awnser1'] . '" name="answered">
                <input type="disabled" hidden class="btn btn-dark responses" value="1" name="reponse">
            </form>
        </td>
        <td>
            <form>
                <input type="submit" class="btn btn-dark responses" value="' . $_SESSION['awnser2'] . '" name="answered">
                <input type="disabled" hidden class="btn btn-dark responses" value="2" name="reponse">
            </form>
        </td>
    </tr>
    <tr>
        <td>
            <form>
                <input type="submit" class="btn btn-dark responses" value="' . $_SESSION['awnser3'] . '" name="answered">
                <input type="disabled" hidden class="btn btn-dark responses" value="3" name="reponse">
            </form>
        </td>
        <td>
            <form>
                <input type="submit" class="btn btn-dark responses" value="' . $_SESSION['awnser4'] . '" name="answered">
                <input type="disabled" hidden class="btn btn-dark responses" value="4" name="reponse">
            </form>
        </td>
    </tr>
</table>';
}

?>