<?php

namespace Wp\OptionsBot\Databases\Migrations;

use Wp\OptionsBot\Abstracts\DBMigrator;

/**
 * Orders migration.
 */
class OrderMigration extends DBMigrator {

    /**
     * Migrate the orders table.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public static function migrate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema_orders = "CREATE TABLE IF NOT EXISTS `{$wpdb->optionsbot_orders}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,

            'symbol' varchar(255) NOT NULL,
            'action' varchar(255) NOT NULL,
            'logic' varchar(255) NOT NULL,
            'manually' varchar(255) NULL,
            'market_type' varchar(255) NULL,
            'options_uuid' varchar(255) NULL,
            'exchange' varchar(255) NULL,
            'max_gain_lost' decimal(8,2) NULL,
            'track_gain_lost' decimal(8,2) NULL,

            'entry_order_qty' tinyint(1) NULL,
            'entry_order_status' varchar(255) NULL,
            'entry_order_id' varchar(255) NULL,
            'entry_order_price' decimal(8,2) NULL,
            'entry_order_datetime' datetime NULL,
            'stop_order_id' varchar(255) NULL,

            'exit_order_qty' tinyint(1) NULL,
            'exit_order_status' varchar(255) NULL,
            'exit_order_id' varchar(255) NULL,
            'exit_order_price' decimal(8,2) NULL,
            'exit_order_datetime' datetime NULL,

            'contract_symbol' varchar(255) NULL,
            'options_type' varchar(255) NULL,
            'expiration_date' date NULL,
            'strike_price' decimal(8,2) NULL,
            'stop_loss' decimal(8,2) NULL,
            'order_type' varchar(255) NULL,
            'entry_datetime' datetime NULL,
            'exit_datetime' datetime NULL,
            'status' varchar(255) NULL,

            'gain' decimal(8,2) NULL,
            'max_gain' decimal(8,2) NULL,
            'phones' varchar(255) NULL,
            'sms_message' varchar(255) NULL,

            'gain_loss' decimal(8,2) NULL,
            'track_gain' decimal(8,2) NULL,
            'start_track' decimal(8,2) NULL,
            'number_share' tinyint(1) NULL,
            'entry_price' decimal(8,2) NULL,
            'exit_price' decimal(8,2) NULL,
            'current_price' decimal(8,2) NULL,
            'slug' varchar(255) NULL,

            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,

            PRIMARY KEY (`id`),
            KEY `slug` (`slug`),
            KEY `symbol` (`symbol`),
            KEY `entry_order_id` (`entry_order_id`),
            KEY `exit_order_id` (`exit_order_id`),
            KEY `strike_price` (`strike_price`),
            KEY `expiration_date` (`expiration_date`),
            KEY `contract_symbol` (`contract_symbol`),
            
        ) $charset_collate";

        // Create the tables.
        dbDelta( $schema_orders );
    }
}
