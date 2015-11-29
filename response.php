<?php
require_once('config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . HOMEDIR . '/wp-load.php');

$api_url = "https://" . dc . ".api.mailchimp.com/2.0/lists/subscribe.json";
$request = wp_remote_post($api_url, array(
    'body' => json_encode(array(
        'apikey' => api_key,
        'id' => id_list,
        'email' => array('email' => $_POST['email_mailchimp']),
    )),
));

$result = json_decode( wp_remote_retrieve_body($request) );

if ($result->email == true) {
    echo '<h3 style="color:green;">' . $_POST['success'] . '</h3>';
} elseif ($result->status == 'error') {
    echo '<h3 style="color:red;">' . $_POST['error'] . '</h3>';
} else {
    echo '<h3 style="color:red;">Your request could not be delivered</h3>';
}