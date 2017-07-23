<?php
/**
 * Plugin Name: ThaiHoa Customize Admin
 * Plugin URI: https://github.com
 * Description: Tùy biến lại trang quản trị của admin.
 * Version: 1.0
 * Author: Anonymous
 * Author URI: https://github.com
 */

function fa_custom_logo()
{
    ?>
    <style type="text/css">
        body {
            background: #ffd700 !important;
        }

        .login #nav a, .login #backtoblog a, .login label {
            /*color: #f3f3f3 !important;*/
        }

        #wp-submit {
            background-color: #0366d6 !important;
        }

        .wp-core-ui .button-primary {
            background: #31b36b !important;
            border: none !important;
            text-shadow: none !important;
            box-shadow: none !important;

        }

        .login form {
            box-shadow: none !important;
            background: transparent !important;
        }

        #login h1 a {
            background-image: url(<?php echo plugins_url('images/logo.png', __FILE__); ?>);
            /*background-size: 280px 80px;*/
            /*width: 280px;*/
            /*height: 80px;*/
        }
    </style>
    <?php
}

add_action('login_enqueue_scripts', 'fa_custom_logo');

function fa_rememberme_check()
{
    add_filter('login_footer', 'fa_rememberme_checked');
}

add_action('init', 'fa_rememberme_check');

function fa_rememberme_checked()
{
    ?>
    <script type="text/javascript">
        document.getElementById("rememberme").checked = true;
    </script>
    <?php
}

/**
 * them logo
 */
function fa_admin_logo()
{
    echo '<br/> <img src="' . plugins_url('images/logo.png', __FILE__) . '"/>';
}

//add_action('admin_notices', 'fa_admin_logo');

/**
 * sua footer
 */
function fa_admin_footer_credits($text)
{
    $text = '<p>Chào mừng đến với quản trị website <a href="/">thaihoamuineresort.com</a></p>';
    return $text;
}

add_filter('admin_footer_text', 'fa_admin_footer_credits');

/**
 * xoa widget
 */
function fa_remove_default_admin_widget()
{
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
    remove_meta_box('wpglobus_dashboard_news', 'dashboard', 'side', 'high');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
}

add_action('wp_dashboard_setup', 'fa_remove_default_admin_widget');
remove_action( 'welcome_panel', 'wp_welcome_panel' );
