<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>

    <link rel="stylesheet" href="<?php echo asset('css/app.min.css') ?>"/>

    <style>
        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: .9em;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        p.footer {
            text-align: right;
            font-size: .8em;
            margin: 5px 0 0 0;
        }
    </style>

    <?php echo ie_support_field() ?>

    <title>Welcome to CI</title>
</head>
<body>
    <?php require_once ('layouts/includes/navbar.php'); ?>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">This is a Custom Version of CodeIgniter!</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info" role="alert">
                    <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>
                </div>

                <p>If you would like to edit this page you'll find it located at:</p>
                <code>template/views/welcome.php</code>

                <p>The corresponding controller for this page is found at:</p>
                <code>application/controllers/Welcome.php</code>

                <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="https://codeigniter.com/docs">User Guide</a>.</p>
            </div>
            <div class="panel-footer">
                <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
            </div>
        </div>
    </div>
</body>
    <script src="<?php echo asset('js/jquery.min.js') ?>"></script>
    <script src="<?php echo asset('js/bootstrap.min.js') ?>"></script>
</html>