# === Admin Menu Visibility ===

Contributors: Amr Shah
Tags: admin menu, visibility, hide menu, dashboard cleanup
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple plugin that lets administrators hide or show specific WordPress admin menu items — excluding "Settings" for safety.

## == Description ==

**Admin Menu Visibility (No Hide Settings)** allows site administrators to simplify the WordPress dashboard by hiding selected top-level admin menu items such as **Posts**, **Pages**, **Media**, **Plugins**, **Tools**, etc.

This is especially useful for:
- Client sites where only certain features should be accessible.
- Custom dashboards where you want to remove clutter.
- Non-technical users who need a minimal admin interface.

The **Settings** menu is excluded by design so it cannot be accidentally hidden — ensuring you always have access to plugin settings and global site options.

### Features
- Choose which menu items to hide from the admin sidebar.
- Changes apply instantly to all users.
- Safe — cannot hide “Settings”.
- Lightweight and does not modify core files.
- 100% native WordPress API.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/admin-menu-visibility-no-hide-settings/`.
2. Activate the plugin from the **Plugins** page in WordPress.
3. Go to **Settings → Admin Menu Visibility**.
4. Select which menu items you want to hide and click **Save Changes**.
5. Reload your dashboard to see the effect.

== Frequently Asked Questions ==

= Can I re-show a hidden menu item? =
Yes! Just uncheck the item in **Settings → Admin Menu Visibility** and save changes. The menu will reappear instantly.

= Why can’t I hide “Settings”? =
To prevent locking yourself out of the plugin controls or key WordPress settings, “Settings” is intentionally excluded.

= Does this affect user roles differently? =
In this version, it applies globally to all users. A future update will allow per-role visibility control.

#### == Changelog ==

= 1.1 =
* Added protection to exclude "Settings" menu from hiding.
* Improved sanitization for hidden menu list.

= 1.0 =
* Initial release — hide or show any top-level admin menu item.

#### == Upgrade Notice ==
Upgrading to version 1.1 ensures the “Settings” menu cannot be accidentally hidden, preventing admin lockout.

#### == License ==
This plugin is licensed under the GPLv2 or later. You are free to modify and redistribute it.



## Credits

Developed by the **AmrShah**

For support, improvements, or contributions, please open an issue or submit a pull request on GitHub.

## Developer Contact

For professional WordPress development, performance optimization, or custom plugin work,  
contact **Amr Shah** - creator of this plugin and lead developer at [AlamiaSoft](https://amrshah.github.io).

- **Website:** [https://amrshah.github.io](https://amrshah.github.io)  
- **GitHub:** [https://github.com/amrshah](https://github.com/amrshah)  
- **Email:** amr.shah@gmail.com  


We build scalable tools, custom dashboards, and performance-focused WordPress/custom solutions for businesses worldwide.


