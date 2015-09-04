<div class="wrap">
    <h2>Simple Recaptcha</h2>
    <p class="description">Please enter your Google reCAPTCHA secret and site key values.</p>
    <form method="post" action="">
        <table class="form-table">
            <tbody>
                <?php
                foreach ($fields as $field):
                    ?>
                    <tr>
                        <th scope="row"><label for="<?php echo $field['name'] ?>"><?php echo $field['title'] ?></label></th>
                        <td><input name="<?php echo $field['name'] ?>" autocomplete="off" type="<?php echo $field['type'] ?>" id="<?php echo $field['name'] ?>" value="<?php echo $field['value'] ?>" class="regular-text"></td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
        <p class="description">In order to use recaptcha, use the shortcode [simple-recaptcha] on any form you want.<br />You can validate the captcha using the php code below.</p>
        <pre style="background-color: #252b39;color: white;box-sizing: border-box; padding: 18px;border-radius: 3px;overflow-x: scroll;">
if ( <span style="color:#df4b71">!</span><span style="color:#8be9ee;">class_exists</span>(<span style="color:#d5d5c0">'RecaptchaController'</span>) ||
     <span style="color:#df4b71">!</span><span style="color:#d4b076;">RecaptchaController</span>::<span style="color:#a9b3cd">validateRecaptcha(</span><span style="color:#a9b3cd">)</span> ) {

    <span style="color:#707d9c">// Invalid captcha</span>

}
        </pre>
        <p class="submit">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('simpleRecapthaNonce'); ?>" />
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
    </form>
</div>