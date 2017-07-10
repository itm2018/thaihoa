<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'thaihoaresort');

/** MySQL database username */
define('DB_USER', 'thaihoaresortmysqladmin');

/** MySQL database password */
define('DB_PASSWORD', '4a3ea1beb6e0aa4d024958e1f59a2caffe0c0f1b09ed6b330c3de6272be7d42ddca974a2fed7228348c');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'P<V;o@^;~}6kxTKaY[ip.dJ)Zv^Su~kFO~()D ^jhAW!qpnff6g0o`|>12_NsIgs');
define('SECURE_AUTH_KEY',  '0TOMv!GT@VU}/:Q1CYIpcO8kt+=W1_#v2:cK[67tkyq-A@dPWS_)]q{G[<~1<6a@');
define('LOGGED_IN_KEY',    '|>5Rei7M[r6KwON6H/j+iB4P83 8U@g5!uH!Q O#b]N!}-2k/Y_296>*BgM$ti[z');
define('NONCE_KEY',        '.3.AJ8%]Qr.BmOt=(8[bB_p?vtCyyPN5GA@:;0zIaYz$HKv+?o&D5[4It71/X,?9');
define('AUTH_SALT',        '}PyjN;nl?f/*]//QNAwg+11BB]vJB_Lc<6Z2+6tVi;*E/I[iR-xIuM 1OcFZXUU,');
define('SECURE_AUTH_SALT', '$r$Us;Bg:aGM[*!- :ya`_S7oB{`wRt?mo895Bb`E+86)7!fsMC*v<~~3$ #7qo!');
define('LOGGED_IN_SALT',   'tY`,87Z;vE=Zye,BmS/krOM//k>O2}luIGsuIDh8{&=[5c)+YrY<=Ld.1`3S&Ge0');
define('NONCE_SALT',       '-faGjGomF,A!OG+8McS]ow?$kY/$v)Y]M]f_*NOp@mue^9:s7FlEFO-.c[`C.?3@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
