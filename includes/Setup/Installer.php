<?php

namespace Wp\OptionsBot\Setup;

use Wp\OptionsBot\Common\Keys;

/**
 * Class Installer.
 *
 * Install necessary database tables and options for the plugin.
 */
class Installer {

    /**
     * Run the installer.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function run(): void {
        // Update the installed version.
        $this->add_version();

        // Register and create tables.
        $this->register_table_names();
        $this->create_tables();

        // Run the database seeders.
        $seeder = new \Wp\OptionsBot\Databases\Seeder\Manager();
        $seeder->run();
    }

    /**
     * Register table names.
     *
     * @since 0.3.0
     *
     * @return void
     */
    private function register_table_names(): void {
        global $wpdb;

        // Register the tables to wpdb global.
        $wpdb->optionsbot_options      = $wpdb->prefix . 'optionsbot_options';
        $wpdb->optionsbot_order      = $wpdb->prefix . 'optionsbot_orders';
    }

    /**
     * Add time and version on DB.
     *
     * @since 0.3.0
     * @since 0.4.1 Fixed #11 - Version Naming.
     *
     * @return void
     */
    public function add_version(): void {
        $installed = get_option( Keys::OPTIONS_BOT_INSTALLED );

        if ( ! $installed ) {
            update_option( Keys::OPTIONS_BOT_INSTALLED, time() );
        }

        update_option( Keys::OPTIONS_BOT_VERSION, OPTIONS_BOT_VERSION );
    }

    /**
     * Create necessary database tables.
     *
     * @since OPTIONS_BOT_
     *
     * @return void
     */
    public function create_tables() {
        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        // Run the database table migrations.
        \Wp\OptionsBot\Databases\Migrations\OptionsMigration::migrate();
        \Wp\OptionsBot\Databases\Migrations\OrderMigration::migrate();
    }
}
