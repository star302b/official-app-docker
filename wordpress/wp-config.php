<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp' );

/** Database username */
define( 'DB_USER', 'wp' );

/** Database password */
define( 'DB_PASSWORD', 'secret' );

/** Database hostname */
define( 'DB_HOST', 'mysql' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '@Op:?^6qa%tC@p/C3S+P({O;*ey>s+ref,wX$r:+&2Un+`~3UJ~Tvv`QBdIsC>~K' );
define( 'SECURE_AUTH_KEY',  '/dx4{`=u~oCKv/]U,4fesYbfZ6.)_s5nog_|J8&C}6IO2 hK77<V203|e,B.=!XB' );
define( 'LOGGED_IN_KEY',    '?@t^:^:a!Yy<~sOD]II0le^Ee{|qx07eJSC[TW,/$I/oFJ67MsG)GhPrUuw;<gL,' );
define( 'NONCE_KEY',        '0///3`LEDUjwv*%xxo+o.+t9bxfSpw-D}ch)5>LbV3aDTkrfTt:3Cbzg>Udgn_sP' );
define( 'AUTH_SALT',        'dSXk3e5>XaZYp0#Ixm0TC#14N{%Jlv|c|(?LMrM!T#C1~0a1;=n4aQV(~ U}7J@X' );
define( 'SECURE_AUTH_SALT', 'go).dqsFr&[o0!sXM^yARj+vRs{czjDObYtou*!QIp|gVRtHwh!GC}FZm%PpAw:)' );
define( 'LOGGED_IN_SALT',   'CTEt+@ZVOWG?F~HC0Hh/vcOnW@v@hkL?Jdmzj9c3bgr(Ug2B6O}-_U+<bHHua6oO' );
define( 'NONCE_SALT',       '/hM@D&~#-d5C9ME`_fNHljzZISD|@T^],`n)O@2bp}DkDOIx;.d6@`n[-OFpei[q' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
define('WP_HOME', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/s' );


/* That's all, stop editing! Happy publishing. */



/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
