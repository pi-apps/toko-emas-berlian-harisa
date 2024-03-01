<?
    define('PARENT_DIR', dirname(__FILE__));

    define('TOP_DIR', PARENT_DIR);

    define('GLOBAL_ASSET', dirname(dirname(dirname(__FILE__))). PHP_DS."global_assets"  );
    define('ROOT_SYSTEM',  dirname(dirname(dirname(__FILE__))). PHP_DS."global_assets". PHP_DS."system6" );
    define('LOKAL_DIR', dirname(__FILE__). PHP_DS. "src" );

    require GLOBAL_ASSET. PHP_DS . "include". PHP_DS ."init.php";

    define('TEMPLATE', 'gdh_simple');

    define('HAVE_LANG', 'en');

    define('DEFAULT_COLOR', 'feeacb');
    define('SYSTEM_COLOR', 'FF9378');

    define('APP_DATABASE', 'gdh');
    define('DB_ADMIN', 'gdh');

    define('APP_SYSTEM', 'PT. GOLDEN DIAMOND HARISA' );
    define('APP_NAME', 'PT. GOLDEN DIAMOND HARISA' );
    define('APP_DESC', 'PT. GOLDEN DIAMOND HARISA: Toko Emas Berlian Harisa.' );

    require PARENT_DIR. PHP_DS . "include". PHP_DS ."app.php";
