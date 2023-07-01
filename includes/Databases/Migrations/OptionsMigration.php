<?php

namespace Wp\OptionsBot\Databases\Migrations;

use Wp\OptionsBot\Abstracts\DBMigrator;

/**
 * Options migration.
 */
class OptionsMigration extends DBMigrator {

    /**
     * Migrate the options table.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public static function migrate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema_options = "CREATE TABLE IF NOT EXISTS `{$wpdb->optionsbot_options}` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            'symbol' varchar(255) NOT NULL,
            'slug' varchar(255) NOT NULL,
            'exp_date' date NULL,
            'trace_date' date NULL,
            'strike_price' decimal(8,2) NULL,
            'price' decimal(8,2) NULL,
            'pct' decimal(8,2) NULL,
            'up90_call_pct' decimal(8,2) NULL,
            'up90_put_pct' decimal(8,2) NULL,

            'contract_symbol_call' varchar(255) NULL,
            'close_call' decimal(8,2) NULL,
            'open_call' decimal(8,2) NULL,
            'low_call' decimal(8,2) NULL,
            'high_call' decimal(8,2) NULL,
            'pre_close_call' decimal(8,2) NULL,
            'ov_call' decimal(8,2) NULL,
            'iv_call' decimal(8,2) NULL,
            'volume_call' decimal(8,2) NULL,

            'contract_symbol_put' varchar(255) NULL,
            'close_put' decimal(8,2) NULL,
            'open_put' decimal(8,2) NULL,
            'low_put' decimal(8,2) NULL,
            'high_put' decimal(8,2) NULL,
            'pre_close_put' decimal(8,2) NULL,
            'ov_put' decimal(8,2) NULL,
            'iv_put' decimal(8,2) NULL,
            'volume_put' decimal(8,2) NULL

            PRIMARY KEY (`id`),
            KEY `slug` (`slug`),
            KEY `contract_symbol_call` (`contract_symbol_call`),
            KEY `contract_symbol_put` (`contract_symbol_put`),
            KEY `symbol` (`symbol`),
            KEY `exp_date` (`exp_date`),
            KEY `trace_date` (`trace_date`),
            KEY `strike_price` (`strike_price`)
        ) $charset_collate";

        // Create the tables.
        dbDelta( $schema_options );
    }
}
