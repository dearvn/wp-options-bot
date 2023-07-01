<?php

namespace Wp\OptionsBot\Options;

use Wp\OptionsBot\Abstracts\BaseModel;

/**
 * Options class.
 *
 * @since 0.3.0
 */
class Options extends BaseModel {

    /**
     * Table Name.
     *
     * @var string
     */
    protected $table = 'optionsbot_options';

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
            'exp_date' => '',
            'trace_date' => '',
            'strike_price' => '',
            'price' => '',
            'pct' => '',
            'up90_call_pct' => '',
            'up90_put_pct' => '',

            'contract_symbol_call' => '',
            'close_call' => '',
            'open_call' => '',
            'low_call' => '',
            'high_call' => '',
            'pre_close_call' => '',
            'ov_call' => '',
            'iv_call' => '',
            'volume_call' => '',

            'contract_symbol_put' => '',
            'close_put' => '',
            'open_put' => '',
            'low_put' => '',
            'high_put' => '',
            'pre_close_put' => '',
            'ov_put' => '',
            'iv_put' => '',
            'volume_put' => ''
        ];

        $data = wp_parse_args( $data, $defaults );

        // Sanitize template data
        return [
            'symbol' => $this->sanitize( $data['symbol'], 'text' ),
            'exp_date' => $this->sanitize( $data['exp_date'], 'text' ),
            'trace_date' => $this->sanitize( $data['trace_date'], 'text' ),
            'strike_price' => $this->sanitize( $data['strike_price'], 'number' ),
            'price' => $this->sanitize( $data['price'], 'number' ),
            'pct' => $this->sanitize( $data['pct'], 'number' ),
            'up90_call_pct' => $this->sanitize( $data['up90_call_pct'], 'number' ),
            'up90_put_pct' => $this->sanitize( $data['up90_put_pct'], 'number' ),

            'contract_symbol_call' => $this->sanitize( $data['contract_symbol_call'], 'text' ),
            'close_call' => $this->sanitize( $data['close_call'], 'number' ),
            'open_call' => $this->sanitize( $data['open_call'], 'number' ),
            'low_call' => $this->sanitize( $data['low_call'], 'number' ),
            'high_call' => $this->sanitize( $data['high_call'], 'number' ),
            'pre_close_call' => $this->sanitize( $data['pre_close_call'], 'number' ),
            'ov_call' => $this->sanitize( $data['ov_call'], 'number' ),
            'iv_call' => $this->sanitize( $data['iv_call'], 'number' ),
            'volume_call' => $this->sanitize( $data['volume_call'], 'number' ),

            'contract_symbol_put' => $this->sanitize( $data['contract_symbol_put'], 'text' ),
            'close_put' => $this->sanitize( $data['close_put'], 'number' ),
            'open_put' => $this->sanitize( $data['open_put'], 'number' ),
            'low_put' => $this->sanitize( $data['low_put'], 'number' ),
            'high_put' => $this->sanitize( $data['high_put'], 'number' ),
            'pre_close_put' => $this->sanitize( $data['pre_close_put'], 'number' ),
            'ov_put' => $this->sanitize( $data['ov_put'], 'number' ),
            'iv_put' => $this->sanitize( $data['iv_put'], 'number' ),
            'volume_put' => $this->sanitize( $data['volume_put'], 'number' ),
        ];
    }

    /**
     * Options item to a formatted array.
     *
     * @since 0.3.0
     *
     * @param object $options
     *
     * @return array
     */
    public static function to_array( ?object $options ): array {
        $strike = $options->strike_price;
        
        $data = [
            'id'          => (int) $options->id,
            'symbol' => $options->symbol,
            'type' => $options->type,
            'slug' => $options->slug,
            'exp_date' => date('m/d/Y', strtotime($options->exp_date)),
            'trace_date' => date('m/d/Y', strtotime($options->trace_date)),
            'strike_price' => $strike,
            'interval' => $options->interval,
            'up90_call_pct' => $options->up90_call_pct,
            'up90_put_pct' => $options->up90_put_pct,

            'call_order_id' => $options->call_order_id,
            'call_order_uuid' => $options->call_order_uuid,
            'call_order_status' => $options->call_order_status,
            'num_low_call' => $options->num_low_call ? $options->num_low_call : 0,

            'put_order_id' => $options->put_order_id,
            'put_order_uuid' => $options->put_order_uuid,
            'put_order_status' => $options->put_order_status,
            'num_low_put' => $options->num_low_put ? $options->num_low_put : 0,

            'contract_symbol_call' => $options->contract_symbol_call,
            'pre_close_call' => $options->pre_close_call,
            'open_call' => $options->open_call,
            'low_call' => $options->low_call,
            'high_call' => $options->high_call,
            'avg_call' => ($options->low_call + $options->high_call)/2,
            'last_close_call' => $options->last_close_call,
            'close_call' => $options->close_call,
            'ov_call' => $options->ov_call,
            'iv_call' => $options->iv_call,
            'volume_call' => $options->volume_call,
            'change_call' => $options->close_call ? number_format(100-($options->last_close_call/$options->close_call)*100, 2):0,
            'daily_change_call' => $options->pre_close_call ? number_format(($options->close_call - $options->pre_close_call)/$options->pre_close_call*100, 2):0,
            'pct_open_low_call' => $options->pre_close_call ? number_format(($options->low_call - $options->pre_close_call)/$options->pre_close_call*100, 2):0,

            'pre_close_put' => $options->pre_close_put,

            'contract_symbol_put' => $options->contract_symbol_put,
            'open_put' => $options->open_put,
            'low_put' => $options->low_put,
            'high_put' => $options->high_put,
            'avg_put' => ($options->low_put + $options->high_put)/2,
            'close_put' => $options->close_put,
            'last_close_put' => $options->last_close_put,
            'ov_put' => $options->ov_put,
            'iv_put' => $options->iv_put,
            'volume_put' => $options->volume_put,
            
            'change_put' => $options->close_put ? number_format(100-($options->last_close_put/$options->close_put)*100, 2):0,
            'daily_change_put' => $options->pre_close_put ? number_format(($options->close_put - $options->pre_close_put)/$options->pre_close_put*100, 2):0,
            'pct_open_low_put' => $options->pre_close_put ? number_format(($options->low_put - $options->pre_close_put)/$options->pre_close_put*100, 2):0,
        ];

        return $data;
    }
}
