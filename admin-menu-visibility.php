<?php
/*
Plugin Name: Admin Menu Visibility (No Hide Settings)
Description: Allows administrators to hide or show specific admin menu items — but excludes "Settings" from the list.
Version: 1.1
Author: Ali Raza
*/

// === 1. Register the setting ===
add_action('admin_init', function() {
    register_setting('amv_settings_group', 'amv_hidden_menus', [
        'type' => 'array',
        'default' => [],
        'sanitize_callback' => function($input) {
            // sanitize and ensure 'options-general.php' (Settings) cannot be hidden
            if (!is_array($input)) {
                return [];
            }
            $clean = array_map('sanitize_text_field', $input);
            // Remove Settings slug if present
            $clean = array_filter($clean, function($v) {
                return $v !== 'options-general.php';
            });
            // reindex
            return array_values($clean);
        }
    ]);
});

// === 2. Add a settings page ===
add_action('admin_menu', function() {
    add_options_page(
        'Admin Menu Visibility',
        'Admin Menu Visibility',
        'manage_options',
        'admin-menu-visibility',
        'amv_render_settings_page'
    );
});

// === 3. Render settings page ===
function amv_render_settings_page() {
    $menus = [
        'edit.php'               => 'Posts',
        'upload.php'             => 'Media',
        'edit.php?post_type=page'=> 'Pages',
        'edit-comments.php'      => 'Comments',
        'themes.php'             => 'Appearance',
        'plugins.php'            => 'Plugins',
        'users.php'              => 'Users',
        'tools.php'              => 'Tools',
        // 'options-general.php' => 'Settings', // intentionally excluded
    ];

    $hidden = get_option('amv_hidden_menus', []);
    ?>
    <div class="wrap">
        <h1>Admin Menu Visibility</h1>
        <form method="post" action="options.php">
            <?php settings_fields('amv_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th>Select Menu Items to Hide</th>
                    <td>
                        <?php foreach ($menus as $slug => $label): ?>
                            <label>
                                <input type="checkbox" name="amv_hidden_menus[]" value="<?php echo esc_attr($slug); ?>"
                                    <?php checked(in_array($slug, $hidden)); ?>>
                                <?php echo esc_html($label); ?>
                            </label><br>
                        <?php endforeach; ?>
                        <p class="description">Note: <strong>Settings</strong> is excluded and cannot be hidden.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Changes'); ?>
        </form>
    </div>
    <?php
}

// === 4. Hide selected menus ===
add_action('admin_menu', function() {
    $hidden = get_option('amv_hidden_menus', []);
    if (!empty($hidden) && is_array($hidden)) {
        foreach ($hidden as $slug) {
            remove_menu_page($slug);
        }
    }
}, 999);
