<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
 
        <?= js('jquery.min') ?>

        <!-- Bootstrap js -->
        <?= plugin('bootstrap/js/bootstrap.bundle.min', 'js'); ?>

        <?php $this->_CI->load_js_plugin() ?>

        <?php $this->_CI->load_js() ?>

        <?= $custom_js; ?>

    </body>

</html>