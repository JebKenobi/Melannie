<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jhonatta_wor4');

/** MySQL database username */
define('DB_USER', 'jhonatta_wor4');

/** MySQL database password */
define('DB_PASSWORD', 'UYv5Dz8G');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'DG|gBlJzN0X-L!+/K<6k)G|fD,an-xy.=_Hpkj(,jlNQyraoy|8+kSn#brqk)++-');
define('SECURE_AUTH_KEY',  'bpAEX,$w6cNqfP5_qy-:G%~r.wT+aTU-u8?li~-K7|qPHO!M$-<[kd|3F[A|Zw^]');
define('LOGGED_IN_KEY',    'pWzL,qEoXYjh8r-So|hUq+w&@ueZ+5 :}-yW.O2A>3j>h@?+l^.ka0pA@8!> 99n');
define('NONCE_KEY',        '|D(mOUduj3UuSP@g}&?*+C(ao]&QRyfCun.@a(l4_rDCpNlvn!etf96<M_}gO-.M');
define('AUTH_SALT',        '!3j-eTbW0VnLxZ*!nwZ2J)bR-KK<@yP:HXOduQ2$Go;$nLbtBIcJupba7i (:FqL');
define('SECURE_AUTH_SALT', '{{2f/Q#NDFhY610b.t.s$o04wsA-.J+>stAeez.gm@DY+I@s0=w@fDH+x<4^-,+M');
define('LOGGED_IN_SALT',   '&+M`lx+QsYx<=fL#xK03X ak<O3zQG&uE[$.}>4RM&B6qc3u-$E`o[fHw/J|JQ c');
define('NONCE_SALT',       'k81_<Co1Y3h@bSNV8K5]RoPYHQ(Gl-4BbB+f{dw9b>s-_-%*6G+ma{K`xIeqHCu+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'zor_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
