<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300"/>
    <link rel="stylesheet" href="<?php echo asset('css/app.min.css') ?>"/>

    <style>
        html, body {
            background-color: #fff;
            font-size: 16px;
            height: 100vh;
            margin: 0;
        }
        .center {
            position: relative;
            align-items: center;
            display: flex;
            height: 100vh;
            justify-content: center;
            text-align: center;
        }
        .title {
            color: #636b6f;
            font-size: 6em;
            margin-bottom: 100px;
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <?php echo ie_support_field() ?>

    <title>Welcome</title>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="#">
                    App
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!$this->auth->is_authenticated()): ?>
                        <li><a href="<?php echo route('/login') ?>">Login</a></li>
                        <li><a href="#">Register</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo auth_data()->name ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo route('/logout') ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="center">
        <div class="title">Logged In!</div>
    </div>

</div>
</body>
<script src="<?php echo asset('js/jquery.min.js') ?>"></script>
<script src="<?php echo asset('js/bootstrap.min.js') ?>"></script>
</html>
