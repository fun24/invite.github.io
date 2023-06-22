<?php
define( 'WP_CACHE', true );
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_github' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         ';sZpG3tsss0N<Q9ZouH;_n[{~DB}{<g~fkb #Ai^`^B)Ri,rih|cqj2aLlF(as5d' );
define( 'SECURE_AUTH_KEY',  ';d>}))yG.9]UZ@`46s:z<@Hhi$d*G)7$~bSxtE5TTBN*SB>0<}?c?$88PgYG/?W)' );
define( 'LOGGED_IN_KEY',    '}kFOvwEzG>$JT;}SSjah(g+Kw:fZx_GM_|{bdx:9haN#E)2+x*[OS~zUmMcTg&W9' );
define( 'NONCE_KEY',        'CL?xw@X8~:;N]LrpG^] ]Lcmy7sm*Iq;0 YLGY<;fc%V<5PDcyHmL_RZ&HQU/5<0' );
define( 'AUTH_SALT',        '&[}1bpSwn;]howb&Fjml_|1S=Vw-tL=YRNmI`TIw+3~w-m(1uBJG)Nj, IMk]=~6' );
define( 'SECURE_AUTH_SALT', 'jaiKM{LFk4Z &@*U4%fs<$E#a-SSHHDne%e-OZQ16JdA]ksk_s!w>N% /.a*j)<Q' );
define( 'LOGGED_IN_SALT',   ']I~lnha.U0(^kmxrg@k[{d[3Xq2lKMeP)~EWOK^QLcLTY%R]]$PLdp71<7z:D=V.' );
define( 'NONCE_SALT',       '+[W[/4eLu#$<C#dziJ<a;N[7i!{n{tzb+<vB2d*Ht7Jah@LgRxiU&;Mj+-@fv=% ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgit_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
