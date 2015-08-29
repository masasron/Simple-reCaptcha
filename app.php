<?php

// reCaptcha shortcode
$this->shortcode('simple-recaptcha', 'RecaptchaController@getShortcode');

// Settings page
$this->page(array(
    'title' => 'Simple Recaptcha',
    'parent' => 'options-general',
    'request.get' => 'RecaptchaController@settings',
    'request.post' => 'RecaptchaController@saveSettings'
));

// Hook into WordPress login form
$this->action('login_form', 'RecaptchaController@hookLoginForm');

// Inject scripts to the WordPress login page
$this->action('login_enqueue_scripts', 'RecaptchaController@hookLoginScripts');

// Validate captcha on authentication
$this->filter('authenticate', 'RecaptchaController@filterAuthenticate', 20, 3);

