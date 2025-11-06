<?php
/*
Plugin Name: Admin Menu Visibility Pro
Description: Control visibility of admin menu and submenu items per user role, with preview mode.
Version: 2.0
Author: Your Name
*/

// === 1. Register settings ===
add_action('admin_init', function() {
    register_setting('amv_settings_group', 'amv_hidden_menus', [
        'type' => 'array',
        'default' => [],
        'sanitize_callback' => function($input) {
            return is_array($input) ? array_map('sanitize_text_field', $input) : [];
        }
    ]);
    register_setting('amv_settings_group', 'amv_preview_mode', ['type' => 'boolean', 'default' => false]);
});

// === 2. Add settings page ===
add_action('admin_menu', function() {
    add_options_page(
        'Admin Menu Visibility',
        'Admin Menu Visibility',
        'manage_options',
        'admin-menu-visibility',
        'amv_render_settings_page'
    );
});

// === 3. Get roles ===
function amv_get_editable_roles() {
    global $wp_roles;
    return $wp_roles->roles;
}

// === 4. Render settings page ===
function amv_render_settings_page() {
    global $submenu;
    $roles  = amv_get_editable_roles();
    $hidden = get_option('amv_hidden_menus', []);
    $preview_mode = get_option('amv_preview_mode', false);

    // Build main menus
    global $menu;
    $menus = [];
    foreach ($menu as $m) {
        if (empty($m[2]) || $m[2] === 'separator1') continue;
        $slug = $m[2];
        $label = wp_strip_all_tags($m[0]);
        $menus[$slug] = ['label' => $label, 'subs' => []];

        // Add submenus
        if (!empty($submenu[$slug])) {
            foreach ($submenu[$slug] as $sub) {
                $sub_slug = $sub[2];
                $menus[$slug]['subs'][$sub_slug] = wp_strip_all_tags($sub[0]);
            }
        }
    }
    ?>
    <div class="wrap">
        <h1>Admin Menu Visibility</h1>
        <p>Select which menu items to hide for each user role. Uncheck to show again.</p>
        <form method="post" action="options.php">
            <?php settings_fields('amv_settings_group'); ?>

            <h2>Preview Mode</h2>
            <label>
                <input type="checkbox" name="amv_preview_mode" value="1" <?php checked($preview_mode); ?>>
                Enable preview mode (temporarily show all menus)
            </label>
            <hr>

            <?php foreach ($roles as $role_key => $role_data): ?>
                <h2><?php echo esc_html($role_data['name']); ?></h2>
                <table class="form-table">
                    <tbody>
                        <?php foreach ($menus as $slug => $menu_item): ?>
                            <tr>
                                <th>
                                    <label>
                                        <input type="checkbox" name="amv_hidden_menus[<?php echo esc_attr($role_key); ?>][]" value="<?php echo esc_attr($slug); ?>"
                                            <?php checked(!empty($hidden[$role_key]) && in_array($slug, $hidden[$role_key])); ?>>
                                        <?php echo esc_html($menu_item['label']); ?>
                                    </label>
                                </th>
                                <td>
                                    <?php if (!empty($menu_item['subs'])): ?>
                                        <?php foreach ($menu_item['subs'] as $sub_slug => $sub_label): ?>
                                            <label style="margin-right:15px;">
                                                <input type="checkbox" name="amv_hidden_menus[<?php echo esc_attr($role_key); ?>][]" value="<?php echo esc_attr($sub_slug); ?>"
                                                    <?php checked(!empty($hidden[$role_key]) && in_array($sub_slug, $hidden[$role_key])); ?>>
                                                <?php echo esc_html($sub_label); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <hr>
            <?php endforeach; ?>

            <?php submit_button('Save Changes'); ?>
        </form>
    </div>
    <?php
}

// === 5. Apply visibility rules ===
add_action('admin_menu', function() {
    if (get_option('amv_preview_mode')) return; // Skip hiding in preview mode

    $user = wp_get_current_user();
    if (empty($user->roles)) return;
    $role = $user->roles[0];
    $hidden = get_option('amv_hidden_menus', []);

    if (!empty($hidden[$role])) {
        foreach ($hidden[$role] as $slug) {
            remove_menu_page($slug);
            remove_submenu_page(null, $slug);
        }
    }
}, 999);
