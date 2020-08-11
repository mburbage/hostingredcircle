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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9GQlJE6r8D7IOsV4UowQHwFEkjOyM50z0EUIHGMSGnc+8aZd8zwJ78s53sGae2oFFHYbEjjwGTvfGrGfC94Vhw==');
define('SECURE_AUTH_KEY',  'MT0fyb0UuqBOiuiAsTN0Vxsws1trPwiDrI4KnDFUo2+uFW8UEajGIpuqxgBIkJAniEhTE3z/0A25aNI7VtRMDw==');
define('LOGGED_IN_KEY',    'RoMPTkk1jCoo2ORc6TtV+dAmTA1Hn/3QpHbilgBit3ffsLpHDEvkNxH1cloRx8UKVUgDlafP822AsxsUiJy4Kg==');
define('NONCE_KEY',        '6CXab3tNi2U5h8xmYvxrrYQk5u/8tQqSd/aOHwsUbdQw0NZRSIIde7XNTjy8MDSYszqccCuaJOv31Y2CyQEZbg==');
define('AUTH_SALT',        '808tZQxGV2ppfabN8nn69Qepzmchc06cJOo1az6MGwUalOSGhOlAIa/Hwoi34KWBon6kceK8d64aaCEmpJqshQ==');
define('SECURE_AUTH_SALT', 'qwMzAOoRBh2/bGLtDQqtE5i+lFjVoEGdfq6iZVKCinYw4N3/Gmkic3ecCyK5DT3WBYBCf8pMtZ+aRxPFAFT9jQ==');
define('LOGGED_IN_SALT',   'tr4Z5HJvGpufIqr8k5pH3atwIuF1K7tdPCHfqNJ6jQKxonLYCOFqb+ehuL6FH/LeSN4AZI0AgJ26CbVhnZqYtA==');
define('NONCE_SALT',       '78/Re3jX8miyV86d+PV4RJe6IsULTexQoO370vW3dhz9YrKVImBQY4e4ZrITxvtosHBFBd+VslD3GdVSFLK8+Q==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * Github Test Edit 2
 */
$table_prefix = 'rcwp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
