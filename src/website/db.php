<?php

session_start();

if (!isset($erreur)) {
    $erreur = '';
}

if (!isset($deconnect)) {
    $deconnect = '';
}

if (!isset($admin_button)) {
    $admin_button = '';
}

if (!isset($isAdmin)) {
    $isAdmin = '';
}
if (!isset($horaire)) {
    $horaire = '';
}
if (!isset($display_horaire)) {
    $display_horaire = '<h3> Aucunes interventions pour cette utilisateur </h3>';
}

$dbhost = 'magicalfubby.com';
$dbuser = 'zarobase';
$dbpass = 'Password123!';
$dbname = 'zarobase';
$tablename = 'nuitinfo_questions';
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);

if(isset($_POST['numberplayer'])){
    for($i=1,$i<=$_POST['numberplayer']),$i++){
        $_SESSION[$i]=0;
    }
    $_SESSION['currentplayer'] = 1;
    $_SESSION['numberplayer'] = $_POST['numberplayer'] ;
}

if(isset($_POST['draw'])){
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'quizz') {
        $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`" . $tablename . " LIMIT 1,(SELECT COUNT(*) FROM `" . $dbname . "`.`" . $tablename . "`);");
    }
    $_SESSION['rightanswer'] = $result[6];
}

if(isset($_POST['answered'])){
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'quizz') {
        if($_POST['answered'] == $_SESSION['rightanswer'])){
            $_SESSION[$_SESSION['currentplayer']]++;
        }
        if(isset($_SESSION['']))
        if($_SESSION['currentplayer']+1 == $_SESSION['numberplayer']){
            $_SESSION['currentplayer'] = 0;
        }
    }
}

if (isset($_SESSION['admin']) and $_SESSION['admin'] == '1') {
    $admin_button = '<li><a href="administration"><i data-feather="database" class="nav-icon"></i>Administration</a></li>
                     <li><a href="export"><i data-feather="log-out" class="nav-icon"></i>Exporter</a></li>';
}

if (isset($_SESSION['user'])) {
    $deconnect = "<img src='img/deconnect.png' style='filter : invert(1); max-width: 35px'>";
}


if (isset($_GET['addUser'])) {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'administration') {
        if (isset($_GET['nom']) && isset($_GET['prenom']) && isset($_GET['email']) && isset($_GET['password']) && $_GET['nom'] != '' && $_GET['prenom'] != '' && $_GET['email'] != '' && $_GET['password'] != '') {
            $admin_create = isset($_GET['Membre']) ? '1' : '0';
            $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`" . $tablename . "` WHERE `mail`='" . htmlspecialchars($_GET['email']) . "';");
            if ($result == false || $result->rowCount() == 0) {
                $pdo->query("INSERT INTO `users` (`nom`, `prenom`, `mail`, `password`, `isAdmin`) VALUES ('" . $_GET['nom'] . "', '" . $_GET['prenom'] . "', '" . $_GET['email'] . "', '" . htmlspecialchars($_GET['password']) . "', '" . $admin_create . "');");
                $erreur = 'Utilisateur ajouté';
            } else {
                $erreur = 'Nom d\'utilisateur déjà utilisé';
            }
        }
    }
}

if (isset($_GET['login'])) {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'login') {
        if (isset($_GET['email'], $_GET['password']) && $_GET['email'] != '') {
            $user = $_GET['email'];
            $mdp = $_GET['password'];
            $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`" . $tablename . "` WHERE `mail`='" . htmlspecialchars($_GET['email']) . "';");
            $db_mdp = $result->fetch();
            if ($mdp == $db_mdp[4]) {
                $_SESSION['user'] = $user;
                $_SESSION['nom'] = $db_mdp[1];
                $_SESSION['prenom'] = $db_mdp[2];
                $_SESSION['admin'] = $db_mdp[5];
                header('Location: index.php');
            } else {
                $erreur = '<p style="text-align: center; color: darkred">Mot de passe incorrect</p>';
            }
            if ($result == false || $result->rowCount() == 0) {
                $erreur = '<p style="text-align: center; color: darkred">Nom d' . "'" . 'utilisateur incorrect</p>';
            }
        } else {
            $erreur = '<p style="text-align: center; color: darkred">Veuillez remplir les champs</p>';
        }
    }
}

if (isset($_GET['submit_form_inter'])) {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'index' || $filename == 'index.php') {
        if (isset($_GET['name'], $_GET['phonenumber'], $_GET['address'], $_GET['city'], $_GET['zipcode'], $_GET['date'], $_GET['time'], $_GET['desc'])) {
            $year = date("Y", strtotime($_GET['date']));
            if ($year == date("Y")) {
                $tablename = "horaires-" . date("Y");
                $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`horaires-$year` WHERE `client`='" . htmlspecialchars($_GET['name']) . "' AND `technicien`='" . htmlspecialchars($_SESSION['user']) . "' AND `date`='" . htmlspecialchars($_GET['date']) . "' AND `time`='" . htmlspecialchars($_GET['time']) . "';");
                if ($result == false || $result->rowCount() == 0) {
                    $request = $pdo->query("INSERT INTO `horaires-" . $year . "` (`client`, `phone`, `address`, `city`, `zipcode`, `date`, `time`, `description`, `technicien`) VALUES ('" . htmlspecialchars($_GET['name']) . "', '" . htmlspecialchars($_GET['phonenumber']) . "', '" . htmlspecialchars($_GET['address']) . "', '" . htmlspecialchars($_GET['city']) . "', '" . htmlspecialchars($_GET['zipcode']) . "', '" . $_GET['date'] . "', '" . htmlspecialchars($_GET['time']) . "', '" . htmlspecialchars($_GET['desc']) . "', '" . htmlspecialchars($_SESSION['user']) . "');");
                    $erreur = '<p style="color: darkgreen ; font-weight: bold;">Intervention ajoutée</p>';
                } else {
                    $erreur = '<p style="color: darkred ; font-weight: bold;">Cette intervention existe deja</p>';
                }
            } else {
                $erreur = '<p style="color: darkred ; font-weight: bold;">L\'intervention doit avoir lieu cette année</p>';
            }
        }
    }
}

if (isset($_GET['delete_inter']) && $_GET['delete_inter'] == 'Supprimer') {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'interventions.php' || $filename == 'interventions' && isset($_GET['id'])) {
        $year = date("Y");
        $query = $pdo->query("DELETE FROM `horaires-$year` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';");
    }
}

if (isset($_GET['edit_inter']) && $_GET['edit_inter'] = 'Modifier') {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'interventions' || $filename == 'interventions.php' && isset($_GET['id'])) {
        $year = date("Y");
        $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`horaires-$year` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';");
        if ($query->rowCount() == 1) {
            $query = $pdo->query("UPDATE `horaires-$year` SET `client`='" . htmlspecialchars($_GET['name']) . "', `phone`='" . htmlspecialchars($_GET['phonenumber']) . "', `address`='" . htmlspecialchars($_GET['address']) . "', `city`='" . htmlspecialchars($_GET['city']) . "', `zipcode`='" . htmlspecialchars($_GET['zipcode']) . "', `date`='" . htmlspecialchars($_GET['date']) . "', `time`='" . htmlspecialchars($_GET['time']) . "', `description`='" . htmlspecialchars($_GET['desc']) . "' WHERE `id`='" . htmlspecialchars($_GET['id']) . "' ");
        }
    }
    header('Location: interventions');
}
if (isset($_GET['editUser']) && $_GET['editUser'] = 'Valider') {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'profil' || $filename == 'profil.php' && isset($_GET['id'])) {
        $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`users` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';");
        if ($query->rowCount() == 1) {
            $password = $pdo->query("SELECT PASSWORD FROM `" . $dbname . "`.`users` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';")->fetch();
            if ($_GET['password'] == $password[0]) {
                $query = $pdo->query("UPDATE `users` SET `nom`='" . htmlspecialchars($_GET['name']) . "', `prenom`='" . htmlspecialchars($_GET['firstname']) . "', `mail`='" . htmlspecialchars($_GET['email']) . "' WHERE `id`='" . htmlspecialchars($_GET['id']) . "'");
                if (isset($_GET['new_password']) && $_GET['new_password'] != '') {
                    $query = $pdo->query("UPDATE `users` SET `password`='" . htmlspecialchars($_GET['new_password']) . "' WHERE `id`='" . htmlspecialchars($_GET['id']) . "'");
                }
            }
        }
        $result = $pdo->query("SELECT * FROM `" . $dbname . "`.`" . $tablename . "` WHERE `mail`='" . htmlspecialchars($_GET['email']) . "';");
        $result = $result->fetch();
        $_SESSION['user'] = $result[3];
        $_SESSION['nom'] = $result[1];
        $_SESSION['prenom'] = $result[2];
        $_SESSION['admin'] = $result[5];
    }
}

if (isset($_GET['reset_password']) && $_GET['reset_password'] = 'Reset MDP') {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'administration' || $filename == 'administration.php' && isset($_GET['id'])) {
        $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`users` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';");
        if ($query->rowCount() == 1) {
            $query = $pdo->query("UPDATE `users` SET `password`='Welcome1' WHERE `id`='" . htmlspecialchars($_GET['id']) . "'");
        }
    }
}

if (isset($_GET['change_admin']) && $_GET['change_admin'] = 'Passer Administrateur' || $_GET['change_admin'] = 'Passer Utilisateur') {
    $filename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    if ($filename == 'administration' || $filename == 'administration.php' && isset($_GET['id'])) {
        $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`users` WHERE `id`='" . htmlspecialchars($_GET['id']) . "';");
        if ($query->rowCount() == 1) {
            $AdminValue = $query->fetch();
            switch ($AdminValue[5]){
                case 1:
                    $query = $pdo->query("UPDATE `users` SET `isAdmin`='0' WHERE `id`='" . htmlspecialchars($_GET['id']) . "'");
                    unset($_SESSION['admin']);
                    header('Location: index');
                    break;
                case 0:
                    $query = $pdo->query("UPDATE `users` SET `isAdmin`='1' WHERE `id`='" . htmlspecialchars($_GET['id']) . "'");
                    $_SESSION['admin'] = '1';
                    header('Location: administration');
                    break;
                default:
                    break;
            }
        }
    }
}

function affichageHoraire()
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'AGP';
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $year = date("Y");
    $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`horaires-$year` WHERE `technicien`='" . htmlspecialchars($_SESSION['user']) . "' ORDER BY `date` ASC;");
    if ($query->rowCount() != 0) {
        while ($row = $query->fetch()) {
            $date = date('d:m:Y', strtotime($row[6]));
            $j7 = date('d:m:Y', strtotime("-7 days"));
            $j2 = date('d:m:Y', strtotime("+2 days"));
            if ($date >= $j7 || $date <= $j2) {
                echo '<div class="card d-inline-flex m-1" style="width: 18rem;">
                      <div class="card-body">
                            <p> Client : ' . $row[1] . '</p>
                            <p> Date : ' . $date . '</p>
                            <p> Durée : ' . $row[7] . '</p>
                            <p> Description : ' . $row[8] . '</p>
                            <form action="edit" class="d-inline-flex">
                                <input type="hidden" name="id" value=' . $row[0] . '>
                                <input class="btn btn-sm btn-success" id="edit_page" type="submit" name="edit_page" value="Modifier">
                            </form>
                            <form action="interventions" class="d-inline-flex">
                                <input type="hidden" name="id" value=' . $row[0] . '>
                                <input class="btn btn-sm btn-danger" id="delete_sql" type="submit" name="delete_inter" value="Supprimer">
                            </form>
                      </div>
                   </div>';
            }
        }
    } else {
        echo '<h5 style="text-align: center"> Aucunes interventions </h5>';
    }
}

function affichageUser()
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'AGP';
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`users`;");
    if ($query->rowCount() != 0) {
        while ($row = $query->fetch()) {
            if($row[1] != "iconcept") {
                switch ($row[5]) {
                    case 1:
                        $user_admin = '<p> Role : <b class="text-danger">Administrateur</b> </p>';
                        $user_admin_button = '<input class="btn btn-sm btn-secondary mt-1 mx-auto" id="change_admin" type="submit" name="change_admin" value="Passer Utilisateur">';
                        break;
                    case 0:
                        $user_admin = '<p> Role : <b>Utilisateur</b> </p>';
                        $user_admin_button = '<input class="btn btn-sm btn-warning mt-1 mx-auto" id="change_admin" type="submit" name="change_admin" value="Passer Administrateur">';
                        break;
                    default:
                        break;
                }
                echo "<div class='card d-inline-flex m-1' style='width: 18rem;'>
                        <div class='card-body'>
                            <p> Nom : " . $row[1] . "</p>
                            <p> Prenom : " . $row[2] . "</p>
                            <p> Email : " . $row[3] . "</p>
                            $user_admin
                            <form action='administration'>
                                <input type='hidden' name='id' value='" . $row[0] . "'>
                                <input class='btn btn-sm btn-primary' id='reset_password' type='submit' name='reset_password' value='Reset MDP'>
                                <input class='btn btn-sm btn-danger' id='delete_user' type='submit' name='delete_user' value='Supprimer'>
                                $user_admin_button
                            </form>
                        </div>
                       </div>";
            }
        }
    } else {
        echo '<h5 style="text-align: center"> Aucuns techniciens </h5>';
    }
}

function editIntervention($id, $technicien)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'AGP';
    $id = htmlspecialchars($id);
    $technicien = htmlspecialchars($technicien);
    $year = date("Y");
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`horaires-$year` WHERE `id`='$id' AND `technicien`='$technicien';");
    if ($query->rowCount() != 0) {
        $row = $query->fetch();
        echo '<form action="interventions">
                <div class="row g-2">
                    <div class="col-sm-9 mb-4">
                        <input type="text" class="form-control" name="name" id="name" value="' . $row[1] . '" required>
                    </div>
                    <div class="col-sm mb-4">
                        <input type="text" class="form-control" name="phonenumber" value="' . $row[2] . '" id="phonenumber" required>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-sm-5 mb-4">
                        <input type="text" class="form-control" name="address" value="' . $row[3] . '" id="address" required>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="city" value="' . $row[4] . '" id="city" required>
                    </div>
                    <div class="col-sm mb-4">
                        <input type="text" class="form-control" name="zipcode" value="' . $row[5] . '" id="zipcode" required>
                    </div>
                </div>
                <div class="row g-6">
                    <div class="col-sm mb-4">
                        <input type="date" id="date" name="date" class="form-control" value="' . $row[6] . '" required>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <input type="time" id="time" name="time" class="form-control" id="kt_timepicker_1"  value="' . $row[7] . '" required>
                    </div>
                </div>
                <div class="form-group mb-4">
                        <input type="text" class="form-control" name="desc" id="desc" value="' . $row[8] . '" required>
                </div>
                <input type="hidden" name="id" value="' . $id . '">
                <input type="submit" name="edit_inter" id="edit_inter" class="btn btn-primary">
                <a href="interventions"><input class="btn btn-primary btn-danger" type="button" value="Annuler"></a>
            </form>';
    } else {
        echo '<p> Cette intervention n\'est pas disponible </p>';
    }
}

function editProfil($user)
{
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'AGP';
    $user = htmlspecialchars($user);
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $query = $pdo->query("SELECT * FROM `" . $dbname . "`.`users` WHERE `mail`='$user';");
    if ($query->rowCount() != 0) {
        $row = $query->fetch();
        echo '<form action="profil">
                        <div class="row g-2">
                            <div class="col-sm-6 mb-4">
                                <input type="text" class="form-control" placeholder="Nom" name="name" id="name" value="' . $row['1'] . '" required>
                            </div>
                            <div class="col-sm mb-4">
                                <input type="text" class="form-control" placeholder="Prenom" name="firstname" id="firstname"  value="' . $row['2'] . '"  required>
                            </div>
                        </div>
                        <div>
                            <input required class="form-control mb-3" type="text" placeholder="Email" name="email"  value="' . $row['3'] . '" >
                        </div>
                        <div>
                            <p class="mb-0">Laisser vide pour ne pas changer de mot de passe</p>
                            <input class="form-control mb-3" type="password" placeholder="Nouveau mot de passe" name="new_password">
                        </div>
                        <div>
                            <p class="mb-0">Entrer le mot de passe pour valider les changements</p>
                            <input required class="form-control mb-3" type="password" placeholder="Mot de passe" name="password">
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit" name="editUser">Valider</button>
                        </div>
                        <input type="hidden" name="id" value="' . $row[0] . '">
                </form>';
    } else {
        echo '<p> Cette intervention n\'est pas disponible </p>';
    }
}

function filterData(&$str){
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

if(isset($_GET['submit_extract']) && $_GET['submit_extract'] == 'Exporter' && isset($_GET['type_export']) && isset($_GET['first_day']) && isset($_GET['last_day']) )
{
    $first_day = DateTime::createFromFormat('Y-m-d', htmlspecialchars($_GET['first_day']));
    $last_day = DateTime::createFromFormat('Y-m-d', htmlspecialchars($_GET['last_day']));

    if($_GET['type_export'] == 'hebdo') {
        $first_day->modify('Last Monday');
        $first_day = $first_day->format('Y-m-d');
        $last_day->modify('Next Sunday');
        $last_day = $last_day->format('Y-m-d');
        $method = 'hedbo';
    }
    else if($_GET['type_export'] == 'mensuel'){
        $first_day = date('Y-m-01', strtotime($_GET['first_day']));
        $last_day = date('Y-m-t', strtotime($_GET['last_day']));
        $method = 'mensuel';
    }
    $year = date("Y");

    //if($first_day == $year && $last_day == $year ){
        $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        $fields = array('Technicien','Client','Telephone','Adresse','Date','Description','Temps');

        $query = $db->query('SELECT users.nom,users.prenom,client,phone,address,city,zipcode,date,description,time
         FROM `horaires-'. $year .'` INNER JOIN `users` on technicien = users.mail WHERE `date`
         BETWEEN "'. $first_day .'" AND "'. $last_day .'" ORDER BY users.nom, users.prenom;');

        if($query->num_rows > 0){
            $delimiter = ";";
            $filename = "export-" . $method . '-' . date('d:m:Y') . ".csv";

            $f = fopen('php://memory', 'w');

            fputcsv($f, $fields, $delimiter);

            while($row = $query->fetch_assoc()){
                $lineData = array($row['nom'] . " " . $row['prenom'],$row['client'],$row['phone'],
                    $row['address'] . "," . $row['zipcode'] . ", " . $row['city'], $row['date'],$row['description'],$row['time']);
                fputcsv($f, $lineData, $delimiter);
            }

            fseek($f, 0);

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            fpassthru($f);
        }
        exit;
    //}
    goToExport();
}

function goToExport(){
    header('Location: export?');
}

?>