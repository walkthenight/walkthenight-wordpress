<?php
/**
 * Plugin Name: 15Zine - Functionality
 * Plugin URI: http://themeforest.net/user/cubell
 * Description: Adds functionality to 15Zine
 * Version: 2.1
 * Author URI: http://themeforest.net/user/cubell
 */

class Cubell_15zine_Functionality {
    /**
     * Define constants
     *
     * @since 1.0
     *
    */
    protected function cb_constants() {

        /**
         * Plugin Path
         */
        define( 'CB_15ZINE_FUNC_PATH', plugin_dir_path( __FILE__ ) );

    }

    /**
     * Constructor
     *
     * @since 1.0
     *
    */
    public function __construct() {
        $this->cb_constants();
        $this->cb_extra_files();
    }

    /**
     * Extra files
     *
     * @since 1.0
     *
    */
     function cb_extra_files() {

            require_once ( CB_15ZINE_FUNC_PATH . 'extensions/shortcodes/cb-shortcodes.php' );
            require_once ( CB_15ZINE_FUNC_PATH . 'extensions/Tax-meta-class/cb-15-class-config.php' );
    }

}

/**
 * Instantiate the Class
 *
 * @since     1.0
 * @global    object
 */
$Cubell_15zine_Functionality = new Cubell_15zine_Functionality();

?>