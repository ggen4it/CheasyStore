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
define( 'DB_NAME', 'cheasyst_wp_4zads' );

/** Database username */
define( 'DB_USER', 'cheasyst_wp_kvk6s' );

/** Database password */
define( 'DB_PASSWORD', 'JK79po9oX#$W6M_*' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

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
define('AUTH_KEY', ']H4vo6k|S/_0/(0-y0+X1(oSz3)P]qo)!Q5nZo_Hpu!X2OE01l:9X)H37l37x9xW');
define('SECURE_AUTH_KEY', 'ya|OqhL2OlIjUZ7@3DN[8ji:&S1W79*/WzZ~x/fW83j:1/E70LL*9Zdhh+O0IdUr');
define('LOGGED_IN_KEY', 'KpSBzao59S4sjGzj93on-Of|5e1hN!M8L(#9Q@6@394IqUW201[#WB(vy3~wVi!0');
define('NONCE_KEY', 'ApOaVOovXU50+5[uhg!qp(-604Wa_K;5eG19XO!|-y5f/YxVOKv2ec5~5gW|Mmk-');
define('AUTH_SALT', 'z~%L[@sbt]99220:3*|J[Zm;SU&heda1cX8iz(!zJ3O00SQg7c)L3kG%7ygxi|z8');
define('SECURE_AUTH_SALT', '4_43Eg-j88-K!wT_#0%94pm@;56UaX80~_G#03r2/5sQ(Po@6&x4wQ+Nr-78dLs9');
define('LOGGED_IN_SALT', '+CTPE:)u26z[@+ilezd;&MZNo09q_!L)x|-%e6X_I#Kk[Ywc#7~7|!2#3%&E4U-z');
define('NONCE_SALT', 'Z9q9/a81(4T&0x!JC1w8E8t~CKAw4)FqX&D57A65uV&e-~h9PWo/cw9(_R5Z1q5X');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'v33ek4m_';


/* Add any custom values between this line and the "stop editing" line. */

define('WP_ALLOW_MULTISITE', true);
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
