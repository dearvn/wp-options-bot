<?php

namespace Wp\OptionsBot\Options;

class Manager {

    /**
     * Options class.
     *
     * @var Options
     */
    public $options;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->options = new Options();
    }

    /**
     * Get all options by criteria.
     *
     * @since 0.3.0
     * @since 0.3.1 Fixed counting return type as integer.
     *
     * @param array $args
     * @return array|object|string|int
     */
    public function all( array $args = [] ) {
        $defaults = [
            'page'     => 1,
            'per_page' => 10,
            'orderby'  => 'id',
            'order'    => 'DESC',
            'search'   => '',
            'count'    => false,
            'where'    => [],
        ];

        $args = wp_parse_args( $args, $defaults );

        if ( ! empty( $args['search'] ) ) {
            global $wpdb;
            $like = '%' . $wpdb->esc_like( sanitize_text_field( wp_unslash( $args['search'] ) ) ) . '%';
            $args['where'][] = $wpdb->prepare( ' title LIKE %s OR description LIKE %s ', $like, $like );
        }

        if ( ! empty( $args['where'] ) ) {
            $args['where'] = ' WHERE ' . implode( ' AND ', $args['where'] );
        } else {
            $args['where'] = '';
        }

        $options = $this->options->all( $args );

        if ( $args['count'] ) {
            return (int) $options;
        }

        return $options;
    }

    /**
     * Get single options by id|slug.
     *
     * @since 0.3.0
     *
     * @param array $args
     * @return array|object|null
     */
    public function get( array $args = [] ) {
        $defaults = [
            'key' => 'id',
            'value' => '',
        ];

        $args = wp_parse_args( $args, $defaults );

        if ( empty( $args['value'] ) ) {
            return null;
        }

        return $this->options->get_by( $args['key'], $args['value'] );
    }

    /**
     * Create a new options.
     *
     * @since 0.3.0
     *
     * @param array $data
     *
     * @return int | WP_Error $id
     */
    public function create( $data ) {
        // Prepare options data for database-insertion.
        $options_data = $this->options->prepare_for_database( $data );

        // Create options now.
        $options_id = $this->options->create(
            $options_data,
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            ]
        );

        if ( ! $options_id ) {
            return new \WP_Error( 'optionsbot_options_create_failed', __( 'Failed to create options.', 'optionsbot' ) );
        }

        /**
         * Fires after a options has been created.
         *
         * @since 0.3.0
         *
         * @param int   $options_id
         * @param array $options_data
         */
        do_action( 'optionsbot_options_created', $options_id, $options_data );

        return $options_id;
    }

    /**
     * Update options.
     *
     * @since 0.3.0
     *
     * @param array $data
     * @param int   $options_id
     *
     * @return int | WP_Error $id
     */
    public function update( array $data, int $options_id ) {
        // Prepare options data for database-insertion.
        $options_data = $this->options->prepare_for_database( $data );

        // Update options.
        $updated = $this->options->update(
            $options_data,
            [
                'id' => $options_id,
            ],
            [
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d'
            ],
            [
                '%d',
            ]
        );

        if ( ! $updated ) {
            return new \WP_Error( 'optionsbot_options_update_failed', __( 'Failed to update options.', 'optionsbot' ) );
        }

        if ( $updated >= 0 ) {
            /**
             * Fires after a options is being updated.
             *
             * @since 0.3.0
             *
             * @param int   $options_id
             * @param array $options_data
             */
            do_action( 'optionsbot_options_updated', $options_id, $options_data );

            return $options_id;
        }

        return new \WP_Error( 'optionsbot_options_update_failed', __( 'Failed to update the options.', 'optionsbot' ) );
    }

    /**
     * Delete options data.
     *
     * @since 0.3.0
     *
     * @param array|int $options_ids
     *
     * @return int|WP_Error
     */
    public function delete( $options_ids ) {
        if ( is_array( $options_ids ) ) {
            $options_ids = array_map( 'absint', $options_ids );
        } else {
            $options_ids = [ absint( $options_ids ) ];
        }

        try {
            $this->options->query( 'START TRANSACTION' );

            $total_deleted = 0;
            foreach ( $options_ids as $options_id ) {
                $deleted = $this->options->delete(
                    [
                        'id' => $options_id,
                    ],
                    [
                        '%d',
                    ]
                );

                if ( $deleted ) {
                    $total_deleted += intval( $deleted );
                }

                /**
                 * Fires after a options has been deleted.
                 *
                 * @since 0.3.0
                 *
                 * @param int $options_id
                 */
                do_action( 'optionsbot_options_deleted', $options_id );
            }

            $this->options->query( 'COMMIT' );

            return $total_deleted;
        } catch ( \Exception $e ) {
            $this->options->query( 'ROLLBACK' );

            return new \WP_Error( 'optionsbot-options-delete-error', $e->getMessage() );
        }
    }
}
