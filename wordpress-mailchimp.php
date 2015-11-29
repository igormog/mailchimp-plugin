<?php
/*
Plugin Name: Wordpress mailchimp test
Plugin URI: /wordpress/wp-content/plugins/wordpress-mailchimp/
Description: This plugin adds subscribers through Mailchimp API
Author: Igor Mogilin
Version: 1.0
Author URI: http://igorm.org/
*/

function wordpress_mailchimp_shortcode($atts) {
    extract( shortcode_atts( array(
        'placeholder' => 'Enter email',
        'submit' => 'Submit',
        'success' => 'Success!',
        'error' => 'Error!'
    ), $atts ) );

    require_once('config.php');
    include('templates/form.php');

    # Ajax
    ?>
    <script type="text/javascript">
        $(document).ready(function() {

            // Validation email
            $('input#email').unbind().mouseout( function() {
                var id = $(this).attr('id');
                var val = $(this).val();
                switch(id) {
                    case 'email':
                        var rv_email = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                        if(val != '' && rv_email.test(val)) {
                            $(this).addClass('not_error');
                            $(this).next('.error-box').text('Принято')
                                .css('color','green')
                        } else {
                            $(this).removeClass('not_error').addClass('error');
                            $(this).next('.error-box').html('&bull; поле "Email" обязательно для заполнения<br> &bull; поле должно содержать правильный email-адрес<br> (например: example123@mail.ru)')
                                .css('color','red')
                        }
                        break;
                }
            });

            // Request
            $('form#mailchimp-form').submit(function(e){
                e.preventDefault();
                if($('.not_error').length == 1) {
                    $.ajax({
                        url: '<?=HOMEDIR; ?>/wp-content/plugins/wordpress-mailchimp/response.php',
                        type: 'post',
                        data: $(this).serialize(),
                        beforeSend: function(xhr, textStatus){
                            $('form#mailchimp-form :input').attr('disabled','disabled');
                        },
                        success: function(data){
                            $('.result-mailchimp').html(data);
                        }
                    });
                } else {
                    return false;
                }
            });

        });
    </script>
    <?php

}
add_shortcode('wordpress-mailchimp', 'wordpress_mailchimp_shortcode' );


# Load styles bootstrap
function wordpress_mailchimp_styles() {
    wp_register_style( 'my-plugin', plugins_url( '/wordpress-mailchimp/css/bootstrap.min.css' ) );
    wp_enqueue_style( 'my-plugin' );
}
add_action( 'wp_enqueue_scripts', 'wordpress_mailchimp_styles' );


# Load CDN jQuery 2.1.4
function my_scripts_method() {
    wp_deregister_script( 'jquery-core' );
    wp_register_script( 'jquery-core', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );