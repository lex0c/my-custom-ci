<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(isset($errors) && $errors !== null): ?>
    <?php foreach($errors as $error): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?php echo $this->lang->line('title_wrong_data'); ?></strong> <?php echo $error ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
