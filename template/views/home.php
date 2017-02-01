<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index, follow"/>

    <link rel="stylesheet" href="<?php echo asset('css/app.min.css') ?>"/>

    <?php echo ie_support_field() ?>

    <title>Logged In</title>
</head>
<body>
    <?php require_once ('layouts/includes/navbar.php'); ?>

    <div class="container">
        <div class="jumbotron">
            <div class="container">
                <h1>Logged In!</h1>
                <p>You are logged in with CodeIgniter secure authentication system. For more information on how to use it, go to <a href="#">documentation</a>.</p>
                <p><a class="btn btn-primary btn-lg" href="https://github.com/lleocastro/my-custom-ci" role="button">View on Github</a></p>
            </div>
        </div>
    </div>

</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="<?php echo asset('js/bootstrap.min.js') ?>"></script>
</html>