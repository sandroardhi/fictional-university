<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'wordpress');

/** Database password */
define('DB_PASSWORD', 'sandro31');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`_BjJGGs% hWn3$}wP6_#~7P}h#`LaBn[Qtd+FVIKGK.^uD+18% oAz-q8iZ)o@7');
define('SECURE_AUTH_KEY',  'tfCSI#?7&-K2L)n{w}W|3gd9M|lOZUw3XY2ts%+[{SqsR<0jUT9zCb~i4 :fE^gU');
define('LOGGED_IN_KEY',    'a=)UA~#yvvYs-rM`>1B,Hn((|QM^Yb rB7,oPc:ZgPM,.`c|6]^Q !DPB,Ywgo,q');
define('NONCE_KEY',        '.K%ENgE* cnY+],,oLOCK$C;Nc=BVn8`#6Nyte;4,v#$B(lvhZ)DEdd{zG4O?=&$');
define('AUTH_SALT',        'wb=2(Z0[@?M)DhXyzqZ#eTwxGV#_&^XC%`w&u.y!;g;yk$^T-G.~n3~)3M.e>8,L');
define('SECURE_AUTH_SALT', 'zttT0iy1I/!8w/_=+x afoFfJZM&/OQ ~ya7yA1(G);; )iQtFu`~I$)s8tf)Qw*');
define('LOGGED_IN_SALT',   'NEX{+$Oh>DS50@Ax6@qAxy0x{YE]efeARhgPy}S@#r>:jXr{pTQ 04!.R 0^Sc! ');
define('NONCE_SALT',       'k5f1@F?xY-A,56#$Qox.4fNk=Tu{LD+$TEdh++k6eBkojIdvF(H,,z]D$RpyVJ2[');
/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
