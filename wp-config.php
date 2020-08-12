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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9L2*3>L%72nPdQZ@ojnDo[!1Xs)QQ,L,#$zzrHB|mNi(ioJXX--C=$jez~[OrOwe' );
define( 'SECURE_AUTH_KEY',  'clbYs#6xX}(Er]RFnHqYdd{-_)$?9 5q+DqX(aW.l^mNh&5J%D0{<2%btMD4V&i{' );
define( 'LOGGED_IN_KEY',    '4gu[rXO_}bqZ2-$I_7/%yhumqvXT;C.}0oejsiMlw%2z?f;3 HPr^/B]-U=;[[Zf' );
define( 'NONCE_KEY',        ':bA<Eelz?vX!5j`QD~Piv`Wg3Db~c>i]8UYi?vzRQ?:JvuGH^FQ4FF?k[9x:~r|0' );
define( 'AUTH_SALT',        '%G10E8m(]C,0P6FoM..}-CPP@J*kIvU@78AR]}{@.i+?<jMsi[6Dw`<7}ZW<-uoV' );
define( 'SECURE_AUTH_SALT', 'aXdfhh-f%#hxHxkT9s(Ctb|FXOAW$=Phh8BeOYa*b`8*0FoOIxQy{X7XXy62fNGn' );
define( 'LOGGED_IN_SALT',   'od19,.o=l`C`(T/~OG^nI:sYzab^dK2fELJH!)/EF^RmB,,+PYVZ&=jhHkXb>8bs' );
define( 'NONCE_SALT',       'QU(Gf) o92v 85{U_TfYn;/evM^E9x_1=;%s(_A9eU`6zTb2<L-sNvbGUqUsj%Z!' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rcwp_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
