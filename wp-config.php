<?php
# Database Configuration
define( 'DB_NAME', 'wp_walkthenight' );
define( 'DB_USER', 'walkthenight' );
define( 'DB_PASSWORD', 'QpPMQ7VbhGoFTxm6' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '|guWpbL)MkqorX/~.bx,?vSjxF?+T,|n(9.1>kh8Wn),3,BuSE|3WaT*GZQX~zCW');
define('SECURE_AUTH_KEY',  'znmW52Y.AAMQ0c+<2McM%ModB&Q.rcc,b*l-7SY[k6dm>:!,-wr;4,rfqG0qR+@#');
define('LOGGED_IN_KEY',    '(</a|M72Mr2)~d~@P$py:8@@%9N}qxDX?rwa7M5jINMu|SJEi-TT!K]>M*83x9rn');
define('NONCE_KEY',        '|?{)6~sxY8dmy,M}wu;+nH|G^f:>kKF-|@mg}=)+89f0%2K%zIz(?&MvfKV)cX:A');
define('AUTH_SALT',        'F80MrVM R)e*on*MV|t;P+c;qy1LC]Y]}aa3;Zey8r!7]L{Og9d0AcqBj;MT;r64');
define('SECURE_AUTH_SALT', 'Rx)P`n0D%}8R*XO8Vu$n]D"~8h-poy^m*Cc.e>Ex3@.jmugl6BQLZ4|4BubS$3w(');
define('LOGGED_IN_SALT',   'U:3YK@ZY^"w;HiZ)B<w}Vi;SCa|U0K;)<1qT4I:itWzygXRDF7.0[q%d^dALCx]n');
define('NONCE_SALT',       'N1}0UFBA3R}bcEN33/inH6i~NaCUpy~zC2yGra4oM U69>Ync2=o8Ys%DJ5?YV!N');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'walkthenight' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', 'ca305ffadd8615eac9c0f6ca56ffaaa9f2d1a4bf' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '40187' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '45.56.120.25' );

define( 'WPE_CDN_DISABLE_ALLOWED', false );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', true );

define( 'FORCE_SSL_LOGIN', true );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'walkthenight.com', 1 => 'walkthenight.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-40187', );

$wpe_special_ips=array ( 0 => '45.56.120.25', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( 0 =>  array ( 'match' => 'walkthenight.wpengine.com', 'secure' => true, 'dns_check' => '0', 'zone' => '2cxnuy2ha4se2jwkq015ofa7', ), );

$wpe_netdna_domains_secure=array ( 0 =>  array ( 'match' => 'walkthenight.wpengine.com', 'secure' => true, 'dns_check' => '0', 'zone' => '2cxnuy2ha4se2jwkq015ofa7', ), );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );

//define( 'WP_SITEURL', 'http://walkthenight.com' );

//define( 'WP_HOME', 'http://walkthenight.com' );

define( 'DOMAIN_CURRENT_SITE', 'walkthenight.com' );
define('WPLANG','');

# WP Engine ID


define('PWP_DOMAIN_CONFIG', 'wtnall.wpengine.com' );

# WP Engine Settings






define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );

define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
