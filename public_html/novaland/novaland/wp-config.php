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
define('DB_NAME', 'novaland');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_7cgflaGvAu[0y>GfDc[5~LB{ HotQDS,3>bS}$Hv+vrWbULMN@d07<IQoI7 !5b');
define('SECURE_AUTH_KEY',  '(XWt%z^lDkR{ S9Sx3DK)S95g~v;3G2`,33vh?E49hpIx2IvvC/&$ mkb>!wlai ');
define('LOGGED_IN_KEY',    'P),Y~}S.[~`AM@QoL}bL)KRO3#>Z7-r4<U)t#2rm868Dx5Vyn]s]^$te/9UQj5W_');
define('NONCE_KEY',        'tA^P;|9!)2STXXfs&{fzLKyMj;Gzj[F<LD}{iwL$)O9E%gH?7|}g^zqA.S+Z?bv^');
define('AUTH_SALT',        'Lo)?vqDh,hxULkG6He_,I8mP;:vr.:rLV8,nk;nq8~cQ:2!<2R6G/?D<,|HyXX3$');
define('SECURE_AUTH_SALT', '}TUs[{-L8Clg.hDK[Se:^rT6w69rHAXWhazv7q,d=CeE<TjOA/*a|$.I[|SKm$L6');
define('LOGGED_IN_SALT',   'z3y+<oDOBRs3vJeHq9V7-,3Hlcn~kc)cpe+rDi~FuX1NW&r;/8]rLE4w1mIesDe|');
define('NONCE_SALT',       'P68|s<?el_*pUS1/_^4>;VhRP{zR,.y<aw/xrm;R#zZ7P$7>XZP[Y.(5reX{zvsQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
