<?php

/*
 * Simple reCaptcha Controller
 */

class RecaptchaController extends Controller
{

    /**
     * Validate reCaptcha request
     * @param array $post
     * @return bool
     */
    public static function validateRecaptcha() {

        $recaptchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response');

        if (!$recaptchaResponse) {
            // captcha was not used
            return false;
        }

        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify?response=' . $recaptchaResponse . '&secret=' . get_option('sr_secret'));
        if (is_wp_error($response)) {
            // some http error
            return false;
        }

        // decode response & return success value
        $json = json_decode($response['body'], true);
        return isset($json['success']) ? $json['success'] : false;
    }

    /**
     * Handle the reCaptcha element view
     * @return string
     */
    public function getShortcode() {
        $sitekey = get_option('sr_sitekey');
        return $this->view('captcha', compact('sitekey'));
    }

    /**
     * Wordpress authenticate filter
     * @param User $user
     * @return mixed
     */
    public function filterAuthenticate($user) {
        if ($this->server['REQUEST_METHOD'] === 'GET') {
            return $user;
        }
        if (!self::validateRecaptcha()) {
            // Invalid captcha!
            return false;
        }
        return $user;
    }

    /**
     * Handle get request to the settings page
     * @return string
     */
    public function settings() {
        /**
         * @ver array
         */
        $fields = array(
            [
                'type' => 'text',
                'name' => 'sr_secret',
                'title' => 'Secret',
                'value' => esc_attr(get_option('sr_secret'))
            ],
            [
                'type' => 'text',
                'name' => 'sr_sitekey',
                'title' => 'Site Key',
                'value' => esc_attr(get_option('sr_sitekey'))
            ]
        );
        return $this->view('settings', compact('fields'));
    }

    /**
     * Handle post request to the settings page
     * @param array $request
     * @return void
     */
    public function saveSettings($request) {
        if (!wp_verify_nonce($request['nonce'], 'simpleRecapthaNonce')) {
            // Missing or invalid nonce
            return $this->shortcut->notice('Oops! invalid nonce value.', 'error');
        }
        $this->shortcut->updateOptions($request, ['sr_secret', 'sr_sitekey'])->notice('Settings were saved.');
    }

    /**
     * Inject recaptcha div into the login form
     * @return void
     */
    public function hookLoginForm() {
        echo '<style>#login{width:352px;}.g-recaptcha{margin-bottom:10px;}</style>' . $this->getShortcode();
    }

    /**
     * Enqueue google recaptcha script on the login page
     * @return void
     */
    public function hookLoginScripts() {
        wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', false);
    }

}
