<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="index, follow"/>

    <link rel="stylesheet" href="<?php echo asset('css/app.min.css') ?>"/>
    <link rel="stylesheet" href="<?php echo asset('css/toastr.min.css') ?>"/>

    <script src="<?php echo asset('js/jquery.min.js') ?>"></script>
    <script src="<?php echo asset('js/toastr.min.js') ?>"></script>

    <?php echo ie_support_field() ?>

    <!-- JSON LD -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org"
        }
    </script>

    <title>Login</title>
</head>
<body>
    <?php if(isset($errors) && $errors != null):
        foreach($errors as $error): ?>
            <script>
                toastr.warning("<?= trim($error) ?>", 'Dados incorretos!');
            </script>
        <?php endforeach;
    endif; ?>

    <?php require_once (dirname(__DIR__) . '/layouts/includes/navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Sign in to access the authenticated area</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo route('login/auth') ?>">
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" name="email" type="email" class="form-control" placeholder="example@gmail.com" value="<?php echo old('email') ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Strong password, please!">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" value="" checked/> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo csrf_field() ?>
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                    <a class="btn btn-link" href="#">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="<?php echo asset('js/app.min.js') ?>"></script>
</html>