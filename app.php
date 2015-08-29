<?php

// reCaptcha shortcode
$plugin->shortcode('simple-recaptcha', 'RecaptchaController@getShortcode');

// Settings page
$plugin->page(array(
    'title' => 'Simple Recaptcha',
    'parent' => 'options-general',
    'request.get' => 'RecaptchaController@settings',
    'request.post' => 'RecaptchaController@saveSettings'
));

// Hook into WordPress login form
$plugin->action('login_form', 'RecaptchaController@hookLoginForm');

// Inject scripts to the WordPress login page
$plugin->action('login_enqueue_scripts', 'RecaptchaController@hookLoginScripts');

// Validate captcha on authentication
$plugin->filter('authenticate', 'RecaptchaController@filterAuthenticate', 20, 3);
