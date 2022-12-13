<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
 
        <?= js('jquery.min') ?>

        <!-- Bootstrap js -->
        <?= plugin('bootstrap/js/bootstrap.bundle.min', 'js'); ?>

        <script src="https://code.responsivevoice.org/responsivevoice.js?key=1Du9zUQu"></script>

        <?php $this->_CI->load_js_plugin() ?>

        <?php $this->_CI->load_js() ?>

        <?php // js('main') ?>

        <?= $custom_js; ?>
        
        <script>
        if(responsiveVoice.voiceSupport()) { 
          responsiveVoice.speak("The browser supports this"); 
        }
        </script>
    </body>

</html>