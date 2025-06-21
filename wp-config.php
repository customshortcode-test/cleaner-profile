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
define( 'DB_HOST', 'localhost:/Users/jumar.juaton/Library/Application Support/Local/run/LSHEC7tLO/mysql/mysqld.sock' );

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
define( 'AUTH_KEY',          'yK9CA?{n.G7|qpu+<$EFm(2Uw7s{&0JDanC07agd^y>ODMc!`{0Q>rQ>mFWPKb4M' );
define( 'SECURE_AUTH_KEY',   'GV4C!g=GU+_D.E$<50}L(Q6M9ImEcl>gpC-Of+,N2HPjOkq77sg**z4f6gb0/?%*' );
define( 'LOGGED_IN_KEY',     's,8@Ym@,DmLR0(I9jRwBPSKGGiaBo32Eqj^k7w`m=Ex9cL0^n[}o.l`hez@t>Vu9' );
define( 'NONCE_KEY',         '{vbADC34wRwu[^JE#?S54`,s.B;tWS:_C^=[5ntmO]#X6a~R|~5TGs`x?g$}a>FG' );
define( 'AUTH_SALT',         '|8]L-[H|m6C=w=M+;lP{RKwnfd*$[HaJz=Saa^S=Z.IAr-S?D0`iCRdQq;>e%>x)' );
define( 'SECURE_AUTH_SALT',  'f~82P^v]q,@gnqfKvV#X^dVkEP-.oCf8;swtnZ!/~H7h`$x99Pd!upSK3TubwZ x' );
define( 'LOGGED_IN_SALT',    '=RG20BDkx,:(Da=JBhx6.#8)83<F~tq>sC[=uX8YZ:&Rf+br!@nz%7rw,+/qWdg(' );
define( 'NONCE_SALT',        'yl$.Sxn|SmKQ7,-0#u5X7R8[qITfm[;LXz zL7vv:WL(#=,8d#8@QtQCiDQ{a{M!' );
define( 'WP_CACHE_KEY_SALT', '}2CQ9[wsKt?EVI%7iJ:!PRMY||wfKw87^)z1(qXl &.m4H{YVw@4s*|1|FPj1i>~' );


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


