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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '&{=B&c|dg.Y^c@Km-_P,JE.xfl&Gx/_V^x.td mizRpQEc2T}1dwTbx,5zTG*.p ' );
define( 'SECURE_AUTH_KEY',   'i$b1Wat, 0n:k; lXo7Eul?G?vSS4o&z.RRwK,BO} +xM+q2vfL{Ch>!UFO5XVP:' );
define( 'LOGGED_IN_KEY',     'T!:3<^+F4n8BlVZ#s~oOK4.!d]YrSI/Zo)okG=(Pu%24ms1tx6evd$k-o[#fk#1|' );
define( 'NONCE_KEY',         'S*9F/qh~uJ*4@wg^-LgYQ_r{UR`V6aF%p5{OG)`a{9RSi2ytpZAjkDMp*ZZt54O,' );
define( 'AUTH_SALT',         'l.7TzP{e{K-!1@khwvaXe^Z>$?hq~95aa]&sYd{G2v[GkDI*sD=m/AtBpzOQm6Pi' );
define( 'SECURE_AUTH_SALT',  ';Rr<,D_JIL(4%QHPNfK~#Byt!T9XggDS?_AiC!4!rn!lmY&hk1?vctKps=S-.~iw' );
define( 'LOGGED_IN_SALT',    'GhjHE?qE3iFtA<<l60&xT!z,Z82*OQE:;>:62z?/%=9)IvC1A_t?-y;N:[xx`Ypk' );
define( 'NONCE_SALT',        'M urZ[P$)@5iix`bN=0UBxCe IwrU.]^A 8(l&T,LDFDrK5-B:.=u?mv)San@#h+' );
define( 'WP_CACHE_KEY_SALT', 'O#llMzgacH2>%A4M%HB!.&8W.Y%Y]4I*FWxisH}j*~w<O+$7Hx8NV{%Aj|*H}ali' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
