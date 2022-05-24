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
define( 'DB_NAME', 'codecraft' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'RXsrg?su]{u~p_tyb&IK5zk7:)Z@UaQzOl|3_BM ;i8hn^`ab!] yn!Le3Y{21%5' );
define( 'SECURE_AUTH_KEY',  '`a7gk;_-p$>/0cM0r/4-il=bPV@CqN6%&!U@m{/`#|SuUW~qUDP*AI[ACy-?$g8^' );
define( 'LOGGED_IN_KEY',    'TM[TeYvbRcS :?Ea1)%gwyYIGt4)9hjLJXyWQ&2^06~Bv5%sVT1kGHDC$E.,n^ol' );
define( 'NONCE_KEY',        ',O;}mGWKK>1|/n{4ddf2f,U6:)}FeJ-=<TyRY?|hIKQ?Y{$M]Ab?J9ylenlKO#9C' );
define( 'AUTH_SALT',        '7tH{9R}r)6J?k}1lc)OZcJ~&WZSvai4!.?3mk=96T;E<R;LT#gj[zy 3D!$SBwi:' );
define( 'SECURE_AUTH_SALT', 'g%e:|`0hJ7!C#>;1`-sw;2LlIEg) kP}A7{ZpXva;+P?m%9ar:<#(OwK[&&)Ljn[' );
define( 'LOGGED_IN_SALT',   'wi{NY$&Y-!=O8esrixYi[Q~6#[]0@?BH1I,P?ap>O|7$(_IO3C~_Fzco$~1%A)7R' );
define( 'NONCE_SALT',       'efmw)K.#YZLo,Uz9)Z1:/<&$RLaFK nma.tl :<!$;|ued-sJmr3bCMf@!E/u1X&' );

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
