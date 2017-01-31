<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if(isset($errors) && $errors != null):
    foreach($errors as $error): ?>
        <script>
            toastr.warning("<?= trim($error) ?>", 'Dados incorretos!');
        </script>
    <?php endforeach;
endif; ?>
