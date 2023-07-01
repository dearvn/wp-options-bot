<?php

namespace Wp\OptionsBot\Tests;

use Wp\OptionsBot\Options\Options;

class OptionsManagerTest extends \WP_UnitTestCase {

    /**
     * Options Instance.
     *
     * @var Options
     */
    public Options $options;

    /**
     * Options Manager Instance.
     *
     * @var \Wp\OptionsBot\Options\Manager
     */
    public $options_manager;

    /**
     * Setup test environment.
     */
    protected function setUp() : void {
        parent::setUp();

        $this->job = new Options();
        $this->options_manager = wp_options_bot()->options;

        // Truncate options table first before running tests.
        $this->job->truncate();
    }

    /**
     * @test
     * @group options
     */
    public function test_if_options_count_is_int() {
        $options_count = $this->options_manager->all( [ 'count' => true ] );

        // Check if options_count is an integer.
        $this->assertIsInt( $options_count );
    }

    /**
     * @test
     * @group options
     */
    public function test_if_options_lists_is_array() {
        $options = $this->options_manager->all();
        $this->assertIsArray( $options );
    }

    /**
     * @test
     * @group options
     */
    public function test_can_create_a_job() {
        // Get total options before creating job.
        $options_count = $this->options_manager->all( [ 'count' => true ] );
        $this->assertEquals( 0, $options_count );

        $options_id = $this->options_manager->create( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );

        // Check again the total options = 1
        $options_count = $this->options_manager->all( [ 'count' => true ] );
        $this->assertEquals( 1, $options_count );

        // Check if options_id is an integer also.
        $this->assertIsInt( $options_id );
    }

    /**
     * @test
     * @group options
     */
    public function test_can_find_a_job() {
        $options_id = $this->options_manager->create( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $this->assertIsInt( $options_id );

        // Find the job
        $options = $this->options_manager->get( [ 'key' => 'id', 'value' => $options_id ] );

        // Check if job is an object
        $this->assertIsObject( $options );

        // Check if job id is found on $options->id
        $this->assertEquals( $options_id, $options->id );
    }

    /**
     * @test
     * @group options
     */
    public function test_can_update_a_job() {
        $options_id = $this->options_manager->create( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $this->assertIsInt( $options_id );
        $this->assertGreaterThan( 0, $options_id );
        $this->assertEquals( 1, $this->options_manager->update([
            'title'       => 'Options Title Updated',
            'description' => 'Options Description Updated',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ], $options_id));
    }

    /**
     * @test
     * @group options
     */
    public function test_can_delete_a_job() {
        $options_id = $this->options_manager->create( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );

        // Check total options = 1
        $options_count = $this->options_manager->all( [ 'count' => true ] );
        $this->assertEquals( 1, $options_count );

        // Delete the job
        $this->options_manager->delete( $options_id );

        // Check total options = 0
        $options_count = $this->options_manager->all( [ 'count' => true ] );
        $this->assertEquals( 0, $options_count );
    }
}
