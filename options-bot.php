<?php

/**
 * Plugin Name:       WP Options Bot
 * Description:       A simple starter kit to work in WordPress plugin development using WordPress Rest API, WP-script and many more...
 * Requires at least: 5.8
 * Requires PHP:      7.3
 * Version:           0.8.0
 * Tested upto:       6.2.2
 * Author:            Donaldit<donald.nguyen.it@gmail.com>
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       optionsbot
 */

defined( 'ABSPATH' ) || exit;

/**
 * Wp_Options_Bot class.
 *
 * @class Wp_Options_Bot The class that holds the entire Wp_Options_Bot plugin
 */
final class Wp_Options_Bot {
    /**
     * Plugin version.
     *
     * @var string
     */
    const VERSION = '0.8.0';

    /**
     * Plugin slug.
     *
     * @var string
     *
     * @since 0.2.0
     */
    const SLUG = 'optionsbot';

    /**
     * Holds various class instances.
     *
     * @var array
     *
     * @since 0.2.0
     */
    private $container = [];

    /**
     * Constructor for the OptionsBot class.
     *
     * Sets up all the appropriate hooks and actions within our plugin.
     *
     * @since 0.2.0
     */
    private function __construct() {
        require_once __DIR__ . '/vendor/autoload.php';

        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );

        add_action( 'wp_loaded', [ $this, 'flush_rewrite_rules' ] );
        $this->init_plugin();
    }

    /**
     * Initializes the Wp_Options_Bot() class.
     *
     * Checks for an existing Wp_Options_Bot() instance
     * and if it doesn't find one, creates it.
     *
     * @since 0.2.0
     *
     * @return Wp_Options_Bot|bool
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Wp_Options_Bot();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @since 0.2.0
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @since 0.2.0
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function define_constants() {
        define( 'OPTIONS_BOT_VERSION', self::VERSION );
        define( 'OPTIONS_BOT_SLUG', self::SLUG );
        define( 'OPTIONS_BOT_FILE', __FILE__ );
        define( 'OPTIONS_BOT_DIR', __DIR__ );
        define( 'OPTIONS_BOT_PATH', dirname( OPTIONS_BOT_FILE ) );
        define( 'OPTIONS_BOT_INCLUDES', OPTIONS_BOT_PATH . '/includes' );
        define( 'OPTIONS_BOT_TEMPLATE_PATH', OPTIONS_BOT_PATH . '/templates' );
        define( 'OPTIONS_BOT_URL', plugins_url( '', OPTIONS_BOT_FILE ) );
        define( 'OPTIONS_BOT_BUILD', OPTIONS_BOT_URL . '/build' );
        define( 'OPTIONS_BOT_ASSETS', OPTIONS_BOT_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();

        /**
         * Fires after the plugin is loaded.
         *
         * @since 0.2.0
         */
        do_action( 'options_bot_loaded' );
    }

    /**
     * Activating the plugin.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function activate() {
        // Run the installer to create necessary migrations and seeders.
        $this->install();
    }

    /**
     * Placeholder for deactivation function.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function deactivate() {
        //
    }

    /**
     * Flush rewrite rules after plugin is activated.
     *
     * Nothing being added here yet.
     *
     * @since 0.2.0
     */
    public function flush_rewrite_rules() {
        // fix rewrite rules
    }

    /**
     * Run the installer to create necessary migrations and seeders.
     *
     * @since 0.3.0
     *
     * @return void
     */
    private function install() {
        $installer = new \Wp\OptionsBot\Setup\Installer();
        $installer->run();
    }

    /**
     * Include the required files.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function includes() {
        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin_menu'] = new Wp\OptionsBot\Admin\Menu();
        }

        // Common classes
        $this->container['assets']   = new Wp\OptionsBot\Assets\Manager();
        $this->container['blocks']   = new Wp\OptionsBot\Blocks\Manager();
        $this->container['rest_api'] = new Wp\OptionsBot\REST\Api();
        $this->container['options']     = new Wp\OptionsBot\Options\Manager();
        $this->container['order']     = new Wp\OptionsBot\Order\Manager();
    }

    /**
     * Initialize the hooks.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function init_hooks() {
        // Init classes
        add_action( 'init', [ $this, 'init_classes' ] );

        // Localize our plugin
        add_action( 'init', [ $this, 'localization_setup' ] );

        // Add the plugin page links
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );
    }

    /**
     * Instantiate the required classes.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function init_classes() {
        // Init necessary hooks
        new Wp\OptionsBot\User\Hooks();
    }

    /**
     * Initialize plugin for localization.
     *
     * @uses load_plugin_textdomain()
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function localization_setup() {
        load_plugin_textdomain( 'optionsbot', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

        // Load the React-pages translations.
        if ( is_admin() ) {
            // Load wp-script translation for options-bot-app
            wp_set_script_translations( 'options-bot-app', 'optionsbot', plugin_dir_path( __FILE__ ) . 'languages/' );
        }
    }

    /**
     * What type of request is this.
     *
     * @since 0.2.0
     *
     * @param string $type admin, ajax, cron or frontend
     *
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined( 'DOING_AJAX' );

            case 'rest':
                return defined( 'REST_REQUEST' );

            case 'cron':
                return defined( 'DOING_CRON' );

            case 'frontend':
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    /**
     * Plugin action links
     *
     * @param array $links
     *
     * @since 0.2.0
     *
     * @return array
     */
    public function plugin_action_links( $links ) {
        $links[] = '<a href="' . admin_url( 'admin.php?page=optionsbot#/settings' ) . '">' . __( 'Settings', 'optionsbot' ) . '</a>';
        $links[] = '<a href="https://github.com/dearvn/wp-options-bot#quick-start" target="_blank">' . __( 'Documentation', 'optionsbot' ) . '</a>';

        return $links;
    }
}

/**
 * Initialize the main plugin.
 *
 * @since 0.2.0
 *
 * @return \Wp_Options_Bot|bool
 */
function wp_options_bot() {
    return Wp_Options_Bot::init();
}

/*
 * Kick-off the plugin.
 *
 * @since 0.2.0
 */
wp_options_bot();
