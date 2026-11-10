<?php
/**
 * Plugin Name: Ballermann Crew Registration
 * Description: Registrierungsformular für Crew-Mitglieder
 * Version: 1.1
 */

// Shortcode [crew_registration] für eine Seite im Frontend
add_shortcode('crew_registration', function() {
    if (!is_user_logged_in()) {
        return '<p>Du musst eingeloggt sein, um ein neues Crew-Mitglied zu registrieren.</p>';
    }

    $current_user = wp_get_current_user();
    $signing_key  = md5($current_user->user_login);
    $default_role = 'subscriber';
    
    $message = '';

    if (isset($_POST['crew_register_nonce'])
        && wp_verify_nonce($_POST['crew_register_nonce'], 'crew_register')
    ) {
        $username   = sanitize_user($_POST['username'] ?? '');
        $email      = sanitize_email($_POST['email'] ?? '');
        $password   = $_POST['password'] ?? '';
        $role       = sanitize_text_field($_POST['role'] ?? $default_role);
        $role_token = sanitize_text_field($_POST['role_token'] ?? '');

        $expected_token = hash_hmac('sha256', $role, $signing_key);
        if (!hash_equals($expected_token, $role_token)) {
            $role = $default_role;
        }

        if ($username && $email && $password) {
            $user_id = wp_create_user($username, $password, $email);
            if (is_wp_error($user_id)) {
                $message = '<div class="error"><p>' . esc_html($user_id->get_error_message()) . '</p></div>';
            } else {
                $user = new WP_User($user_id);
                $user->set_role($role);
                $message = '<div class="updated"><p>Crew-Mitglied <strong>' . esc_html($username) . '</strong> wurde erfolgreich als <em>' . esc_html($role) . '</em> registriert.</p></div>';
            }
        } else {
            $message = '<div class="error"><p>Bitte alle Felder ausfüllen.</p></div>';
        }
    }

    $form_token = hash_hmac('sha256', $default_role, $signing_key);

    ob_start();
    ?>
    <?php echo $message; ?>
    <form method="post">
        <?php wp_nonce_field('crew_register', 'crew_register_nonce'); ?>
        <input type="hidden" name="role" value="<?php echo esc_attr($default_role); ?>">
        <input type="hidden" name="role_token" value="<?php echo esc_attr($form_token); ?>">
        <p>
            <label>Benutzername<br>
            <input type="text" name="username" required></label>
        </p>
        <p>
            <label>E-Mail<br>
            <input type="email" name="email" required></label>
        </p>
        <p>
            <label>Passwort<br>
            <input type="password" name="password" required></label>
        </p>
        <p>
            <button type="submit">Registrieren</button>
        </p>
    </form>
    <?php
    return ob_get_clean();
});
