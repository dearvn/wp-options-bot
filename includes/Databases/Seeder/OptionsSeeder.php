<?php

namespace Wp\OptionsBot\Databases\Seeder;

use Wp\OptionsBot\Abstracts\DBSeeder;
use Wp\OptionsBot\Common\Keys;

/**
 * Options Seeder class.
 *
 * Seed some fresh emails for initial startup.
 */
class OptionsSeeder extends DBSeeder {

    /**
     * Run Options seeder.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function run() {
        global $wpdb;

        // Check if there is already a seeder runs for this plugin.
        $already_seeded = (bool) get_option( Keys::OPTIONS_SEEDER_RAN, false );
        if ( $already_seeded ) {
            return;
        }

        // Generate some options.
        $options = [
            [
                "symbol" => "SPY",
                "slug" => "SPY_20230526_415_20230526",
                "exp_date" => "2023-05-23",
                "trace_date" => "2023-05-23",
                "strike_price" => 415,
                "price" => 419,
                "pct" => 1.1,
                "up90_call_pct" => false,
                "up90_put_pct" => false,

                "contract_symbol_call" => "SPY_052623C415",
                "close_call" => 4.96,
                "open_call" => 1.32,
                "low_call" => 1.53,
                "high_call" => 5.74,
                "pre_close_call" => 1.32,
                "ov_call" => 29433,
                "iv_call" => 11.327,
                "volume_call" => 52313,
                
                "contract_symbol_put" => "SPY_052623P415",
                "close_put" => 0.01,
                "open_put" => 1.75,
                "low_put" => 0.01,
                "high_put" => 1.14,
                "pre_close_put" => 1.75,
                "ov_put" => 23465,
                "iv_put" => 11.327,
                "volume_put" => 205563
                
            ],
        ];

        // Create each of the options.
        foreach ( $options as $item ) {
            $wpdb->insert(
                $wpdb->prefix . 'optionsbot_options',
                $item
            );
        }

        // Update that seeder already runs.
        update_option( Keys::OPTIONS_SEEDER_RAN, true );
    }
}
