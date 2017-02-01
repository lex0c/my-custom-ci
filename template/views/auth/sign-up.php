<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>

    <link rel="stylesheet" href="<?php echo asset('css/app.min.css') ?>"/>

    <?php echo ie_support_field() ?>

    <title>Sign up</title>
</head>
<body>
    <?php require_once (dirname(__DIR__) . '/layouts/includes/navbar.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Sign up to access the authenticated area</div>
                    <div class="panel-body">
                        <?php require_once (dirname(__DIR__) . '/layouts/includes/show-errors.php'); ?>
                        <form class="form-horizontal" method="post" action="<?php echo route('register/auth') ?>" accept-charset="utf-8">
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Your Name</label>
                                <div class="col-md-6">
                                    <input id="name" name="name" type="text" class="form-control" value="<?php echo old('name') ?>" placeholder="Example: John, Lia, Ana, Roberto, etc..." autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lastname" class="col-md-4 control-label">Last Name</label>
                                <div class="col-md-6">
                                    <input id="lastname" name="lastname" type="text" class="form-control" value="<?php echo old('lastname') ?>" placeholder="Example: Silva, Abreu, Lincon, Haper, etc..." autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" name="email" type="email" class="form-control" value="<?php echo old('email') ?>" placeholder="Example: example@gmail.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Strong password, please!">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password_confirm" name="password_confirm" type="password" class="form-control" placeholder="Repeat password from above">
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo csrf_field() ?>
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="<?php echo asset('js/bootstrap.min.js') ?>"></script>
</html>