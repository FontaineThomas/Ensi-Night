<?php

#include 'db.php'
if (!isset($invisible_button)) {
    $invisible_button = '';
}

?>

<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Face aux MST</title>
    <link rel="icon" href="VIH.png">
    <!-- Css -->
    <link href="assets/css/plugins/bootstrap.min.css" rel="stylesheet">
    <link href="assets/fonts/font-awesome.min.css" rel="stylesheet">
    <link href="assets/fonts/bs-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/plugins/slick.css" rel="stylesheet">
    <link href="assets/css/plugins/magnific-popup.css" rel="stylesheet">
    <link href="assets/css/plugins/animate.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="assets/css/game.css" rel="stylesheet">
</head>

<body>
<div class="center_div draw_card">
    <form method="post">
        <input type="submit" class="btn btn-dark center_button" <?php $invisible_button ?> value="Tirer une carte" name="draw">
    </form>
</div>
<section class="section_game section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="game_card deck">
                <div class="content">
                    <div class="front"></div>
                    <div class="back">
                        Front
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container2">
        <div class="row justify-content-center">
            <div class="game_card2 deck2">
                <div class="content2">
                    <div class="front2"></div>
                    <div class="back2">
                        Front
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="score">
    <div class="top-left player_score">
        <div>
            <h6>JOUEUR 1</h6>
            <h6>00</h6>
        </div>
    </div>
    <div class="top-right player_score">
        <div>
            <h6>JOUEUR 2</h6>
            <h6>00</h6>
        </div>
    </div>
    <div class="bottom-left player_score">
        <div>
            <h6>JOUEUR 3</h6>
            <h6>00</h6>
        </div>
    </div>
    <div class="bottom-right player_score">
        <div>
            <h6>JOUEUR 4</h6>
            <h6>00</h6>
        </div>
    </div>
</div>

</body>

</html>