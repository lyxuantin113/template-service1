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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_templateservice1' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

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
define( 'AUTH_KEY',         'sh~Rp]ms-RJmLG|M,`>8^<EystWR[{L}w)IPv[IGNKH[Tl!0@PP^Vx>2C$X:C%e=' );
define( 'SECURE_AUTH_KEY',  'U#%931mONk(e?,C=`zi*k:Do-/9dTa7:f)T)!~ZMJkRjdg;N}dN8<FeUtYJe?Jvd' );
define( 'LOGGED_IN_KEY',    'qN_n}=;ru>CQif$ewH#UQz5]ZeJYIqm0+xYjSntLWt4R<5+f_XN9j`-k*&x|$@9Q' );
define( 'NONCE_KEY',        '&bE8`-Z2TE8/e}f@KHR`;!7LPlqW;kv,y6O(PNt|f~uxOCtwZEPR_c76xNbbKDg<' );
define( 'AUTH_SALT',        '}i;QI5><cw:Kw]x,OjP{b#l7!fulivKzIs?i9!>SU!Z m=N6Fgm~hu:X35so3*E(' );
define( 'SECURE_AUTH_SALT', 'V9-L5V~;ngK:Htf(<vgGWA<?~<);k`MlOaZ?~+EoBrhU_XD3+U?c[#j9o)Xu;{ED' );
define( 'LOGGED_IN_SALT',   'Svy]FMUbU{lSZW6=1VfEvcf7AjF}mF+7eQR+;ipM23,6P_c_/+p-Ry[EVm5;b3,B' );
define( 'NONCE_SALT',       '.7{>LCXc]:Sjk*$~&MB{@^uOYG$Q`?!=Q>wu4+K.#ERAW!EaZ3 -@@C0JY%WDn+Y' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'dvt_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
