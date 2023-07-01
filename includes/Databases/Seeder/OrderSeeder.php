<?php

namespace Wp\OptionsBot\Databases\Seeder;

use Wp\OptionsBot\Abstracts\DBSeeder;
use Wp\OptionsBot\Common\Keys;

/**
 * Orders Seeder class.
 *
 * Seed some fresh emails for initial startup.
 */
class OrderSeeder extends DBSeeder {

    /**
     * Run orders seeder.
     *
     * @since 0.3.0
     *
     * @return void
     */
    public function run() {
        global $wpdb;

        // Check if there is already a seeder runs for this plugin.
        $already_seeded = (bool) get_option( Keys::ORDER_SEEDER_RAN, false );
        if ( $already_seeded ) {
            return;
        }

        // Generate some orders.
        $orders = [
            [
                'symbol' => 'SPY',
                'action' => 'buy',
                'logic' => 'Logic 1',
                'manually' => null,
                'market_type' => 'LIMIT',
                'options_uuid' => '1',
                'exchange' => null,
                'max_gain_lost' => null,
                'track_gain_lost' => null,

                'entry_order_qty' => 1,
                'entry_order_status' => 'SIMULATE',
                'entry_order_id' => null,
                'entry_order_price' => 0.22,
                'entry_order_datetime' => current_datetime()->format( 'Y-m-d H:i:s' ),
                'stop_order_id' => null,

                'exit_order_qty' => null,
                'exit_order_status' => null,
                'exit_order_id' => null,
                'exit_order_price' => null,
                'exit_order_datetime' => null,

                'contract_symbol' => 'SPY_052623C415',
                'options_type' => 'CALL',
                'expiration_date' => '2023-05-23',
                'strike_price' => 515,
                'stop_loss' => 0.14,
                'order_type' => 'buy',
                'entry_datetime' => current_datetime()->format( 'Y-m-d H:i:s' ),
                'exit_datetime' => null,
                'status' => 'open',
                'gain' => null,
                'max_gain' => null,
                'phones' => null,
                'sms_message' => null,

                'gain_loss' => null,
                'track_gain' => null,
                'start_track' => null,
                'number_share' => 1,
                'entry_price' => 0.22,
                'exit_price' => null,
                'current_price' => 0.25,
                'slug' => 'entry_call_SPY_052623C415_open',
                    
                'created_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
                'updated_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
            ],
        ];

        // Create each of the orders.
        foreach ( $orders as $order) {
            $wpdb->insert(
                $wpdb->prefix . 'optionsbot_orders',
                $order
            );
        }

        // Update that seeder already runs.
        update_option( Keys::ORDER_SEEDER_RAN, true );
    }
}
