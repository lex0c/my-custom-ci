<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="app">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo route('/welcome') ?>">
                    Welcome
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <?php if($this->auth->can()): ?>
                        <a href="<?php echo route('/home') ?>" class="btn btn-default navbar-btn" role="button">Home</a>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(!$this->auth->can()): ?>
                        <a class="btn btn-primary navbar-btn" href="<?php echo route('/login') ?>">Sign in</a>
                        <a class="btn btn-default navbar-btn" href="<?php echo route('/register') ?>">Sign up</a>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="<?php echo route('/home') ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo auth_data()->name ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?php echo route('/user/logout') ?>">Logout</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>