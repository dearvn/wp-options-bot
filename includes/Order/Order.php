<?php

namespace Wp\OptionsBot\Order;

use Wp\OptionsBot\Abstracts\BaseModel;

/**
 * Order class.
 *
 * @since 0.3.0
 */
class Order extends BaseModel {

    /**
     * Table Name.
     *
     * @var string
     */
    protected $table = 'optionsbot_orders';

    /**
     * Prepare datasets for database operation.
     *
     * @since 0.3.0
     *
     * @param array $request
     * @return array
     */
    public function prepare_for_database( array $data ): array {
        $defaults = [
            'symbol' => '',
            'action' => '',
            'logic' => '',
            'manually' => '',
            'market_type' => '',
            'options_uuid' => '',
            'exchange' => '',
            'max_gain_lost' => '',
            'track_gain_lost' => '',

            'entry_order_qty' => '',
            'entry_order_status' => '',
            'entry_order_id' => '',
            'entry_order_price' => '',
            'entry_order_datetime' => '',
            'stop_order_id' => '',

            'exit_order_qty' => '',
            'exit_order_status' => '',
            'exit_order_id' => '',
            'exit_order_price' => '',
            'exit_order_datetime' => '',

            'contract_symbol' => '',
            'options_type' => '',
            'expiration_date' => '',
            'strike_price' => '',
            'stop_loss' => '',
            'order_type' => '',
            'entry_datetime' => '',
            'exit_datetime' => '',
            'status' => '',
            'gain' => '',
            'max_gain' => '',
            'phones' => '',
            'sms_message' => '',

            'gain_loss' => '',
            'track_gain' => '',
            'start_track' => '',
            'number_share' => '',
            'entry_price' => '',
            'exit_price' => '',
            'current_price' => '',
            'slug' => '',

            'created_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
            'updated_at'  => current_datetime()->format( 'Y-m-d H:i:s' ),
        ];

        $data = wp_parse_args( $data, $defaults );

        // Sanitize template data
        return [
            'symbol' => $this->sanitize( $data['symbol'], 'text' ),
            'action' => $this->sanitize( $data['action'], 'text' ),
            'logic' => $this->sanitize( $data['logic'], 'text' ),
            'manually' => $this->sanitize( $data['manually'], 'text' ),
            'market_type' => $this->sanitize( $data['market_type'], 'text' ),
            'options_uuid' => $this->sanitize( $data['options_uuid'], 'text' ),
            'exchange' => $this->sanitize( $data['exchange'], 'text' ),
            'max_gain_lost' => $this->sanitize( $data['max_gain_lost'], 'number' ),
            'track_gain_lost' => $this->sanitize( $data['track_gain_lost'], 'number' ),

            'entry_order_qty' => $this->sanitize( $data['entry_order_qty'], 'number' ),
            'entry_order_status' => $this->sanitize( $data['entry_order_status'], 'text' ),
            'entry_order_id' => $this->sanitize( $data['entry_order_id'], 'number' ),
            'entry_order_price' => $this->sanitize( $data['entry_order_price'], 'number' ),
            'entry_order_datetime' => $this->sanitize( $data['entry_order_datetime'], 'text' ),
            'stop_order_id' => $this->sanitize( $data['stop_order_id'], 'number' ),

            'exit_order_qty' => $this->sanitize( $data['exit_order_qty'], 'number' ),
            'exit_order_status' => $this->sanitize( $data['exit_order_status'], 'text' ),
            'exit_order_id' => $this->sanitize( $data['exit_order_id'], 'number' ),
            'exit_order_price' => $this->sanitize( $data['exit_order_price'], 'number' ),
            'exit_order_datetime' => $this->sanitize( $data['exit_order_datetime'], 'text' ),

            'contract_symbol' => $this->sanitize( $data['contract_symbol'], 'text' ),
            'options_type' => $this->sanitize( $data['options_type'], 'text' ),
            'expiration_date' => $this->sanitize( $data['expiration_date'], 'text' ),
            'strike_price' => $this->sanitize( $data['strike_price'], 'number' ),
            'stop_loss' => $this->sanitize( $data['stop_loss'], 'number' ),
            'order_type' => $this->sanitize( $data['order_type'], 'text' ),
            'entry_datetime' => $this->sanitize( $data['entry_datetime'], 'text' ),
            'exit_datetime' => $this->sanitize( $data['exit_datetime'], 'text' ),
            'status' => $this->sanitize( $data['status'], 'text' ),
            'gain' => $this->sanitize( $data['gain'], 'number' ),
            'max_gain' => $this->sanitize( $data['max_gain'], 'number' ),
            'phones' => $this->sanitize( $data['phones'], 'text' ),
            'sms_message' => $this->sanitize( $data['sms_message'], 'text' ),

            'gain_loss' => $this->sanitize( $data['gain_loss'], 'number' ),
            'track_gain' => $this->sanitize( $data['track_gain'], 'number' ),
            'start_track' => $this->sanitize( $data['start_track'], 'number' ),
            'number_share' => $this->sanitize( $data['number_share'], 'number' ),
            'entry_price' => $this->sanitize( $data['entry_price'], 'number' ),
            'exit_price' => $this->sanitize( $data['exit_price'], 'number' ),
            'current_price' => $this->sanitize( $data['current_price'], 'number' ),
            'slug' => $this->sanitize( $data['slug'], 'text' ),

            'created_at'  => $this->sanitize( $data['created_at'], 'text' ),
            'updated_at'  => $this->sanitize( $data['updated_at'], 'text' ),
        ];
    }

    /**
     * Options item to a formatted array.
     *
     * @since 0.3.0
     *
     * @param object $oder
     *
     * @return array
     */
    public static function to_array( ?object $oder ): array {

        $strike = $oder->strike_price;

        $data = [
            'id'          => (int) $oder->id,
            'symbol' => $oder->symbol,
            'action' => $oder->action,
            'market_type' => $oder->market_type,
            'contract_symbol' => $oder->contract_symbol,
            'stop_loss' => $oder->stop_loss,
            'expiration_date' => $oder->expiration_date ? date('m/d/Y', strtotime($oder->expiration_date)) : '',
            'strike_price' => $oder->strike_price,
            'options_type' => $oder->options_type,
            'order_type' => $oder->order_type,
            'entry_datetime' => $oder->entry_datetime ? date('m/d/Y H:i:s', strtotime($oder->entry_datetime)) : '',
            'exit_datetime' => $oder->exit_datetime ? date('m/d/Y H:i:s', strtotime($oder->exit_datetime)) : '',
            'gain_loss' => $oder->gain ? $oder->gain : ($oder->exit_price ? $oder->exit_price - $oder->entry_price : 0),
            'status' => $oder->status,
            'number_share' => $oder->number_share,
            'entry_price' => $oder->entry_price ? number_format($oder->entry_price, 2) : $oder->entry_order_price,
            'exit_price' => $oder->exit_price ? number_format($oder->exit_price, 2) : $oder->exit_order_price,
            'total_gain_loss' => $oder->gain_loss * $oder->number_share,
            'current_price' => number_format($oder->current_price, 2),
            'entry_order_id' => $oder->entry_order_id,
            'exit_order_id' => $oder->exit_order_id,
            'entry_order_status' => $oder->entry_order_status,
            'exit_order_status' => $oder->exit_order_status,
            'entry_order_price' => $oder->entry_order_price,
            'exit_order_price' => $oder->exit_order_price,
            'max_gain' => $oder->max_gain ? $oder->max_gain : $oder->max_gain_lost,
            'start_track' => !empty($oder->start_track) ? $oder->start_track : $oder->track_gain_lost,
            'track_gain' => $oder->track_gain ? number_format($oder->track_gain,2) : number_format($oder->track_gain_lost, 2),
            'logic' => $oder->logic,
            'entry_order_datetime' => $oder->entry_order_datetime ? date('m/d/Y H:i:s', strtotime($oder->entry_order_datetime)) : '',
            'exit_order_datetime' => $oder->exit_order_datetime ? date('m/d/Y H:i:s', strtotime($oder->exit_order_datetime)) : '',
        ];

        return $data;
    }
}
