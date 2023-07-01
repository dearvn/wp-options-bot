<?php

namespace Wp\OptionsBot\Tests\Api;

use Wp\OptionsBot\Options\Options;

class OptionsRestApiTest extends \WP_UnitTestCase {

    /**
	 * Test REST Server
	 *
	 * @var WP_REST_Server
	 */
	protected $server;

    /**
     * Namespace.
     *
     * @var string
     */
    protected $namespace = 'options-bot/v1';

    /**
     * Options Instance.
     *
     * @var Wp\OptionsBot\Options\Options
     */
    public Options $options;

    /**
     * Options Manager Instance.
     *
     * @var Wp\OptionsBot\Options\Manager
     */
    public $options_manager;

    /**
     * Setup test environment.
     */
    protected function setUp() : void {
        // Initialize REST Server.
        global $wp_rest_server;

        parent::setUp();

        $this->job = new Options();

        // Truncate options table first before running test-suits.
        $this->job->truncate();

		$this->server = $wp_rest_server = new \WP_REST_Server;
		do_action( 'rest_api_init' );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_options_list_endpoint_exists() {
        $endpoint = '/' . $this->namespace . '/options';

        $request  = new \WP_REST_Request( 'GET', $endpoint );

        $response = $this->server->dispatch( $request );

        $this->assertEquals( 200, $response->get_status() );
	}

    /**
     * @test
     * @group options-rest-api
     */
    public function test_options_list_endpoint_returns_array() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertIsArray( $data );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_options_list_endpoint_can_send_total() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );

        $this->assertEquals( 0, $response->get_headers()['X-WP-Total'] );
        $this->assertEquals( 0, $response->get_headers()['X-WP-TotalPages'] );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_can_get_options_detail() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();

        // Hit job detail api endpoint.
        $endpoint = '/' . $this->namespace . '/options/' . $data['id'];
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );
        $response = $response->get_data();

        // Check if job detail id found.
        $this->assertEquals( $data['title'], $response['title'] );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_options_endpoint_can_create_job() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 1, $data['id'] );

        // Check total count of options.
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 1, count( $data ) );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_options_endpoint_can_not_create_without_title() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );

        $this->assertEquals( 400, $response->get_status() );
        $this->assertSame( 'rest_missing_callback_param', $response->get_data()['code'] );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_can_slug_will_be_auto_generated_if_not_given() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );

        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();

        $this->assertEquals( 'job-title', $data['slug'] );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_can_create_multiple_options_without_slug_same_time() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'job-title', $data['slug'] );

        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'job-title-1', $data['slug'] );

        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'job-title-2', $data['slug'] );

        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'job-title-3', $data['slug'] );
    }

    /**
     * @test
     * @group options-rest-api
     */
    public function test_can_update_job() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'job-title', $data['slug'] );
        $this->assertEquals( 1, $data['id'] );

        // Update job.
        $endpoint = '/' . $this->namespace . '/options/' . $data['id'];
        $request  = new \WP_REST_Request( 'PUT', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title Updated',
            'description' => 'Options Description Updated',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );

        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 'Options Title Updated', $data['title'] );
        $this->assertEquals( 'job-title-updated', $data['slug'] );
    }

    /**
     * @test
     *
     * @return void
     */
    public function test_can_delete_options() {
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'POST', $endpoint );
        $request->set_body_params( [
            'title'       => 'Options Title',
            'description' => 'Options Description',
            'company_id'  => 1,
            'options_type_id' => 2,
            'is_active'   => 1,
        ] );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();

        // Count total options
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 1, count( $data ) );

        // Delete Options
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'DELETE', $endpoint );
        $request->set_param( 'ids', [$data[0]['id']] );
        $response = $this->server->dispatch( $request );
        $this->assertEquals( 200, $response->get_status() );

        // Count total options
        $endpoint = '/' . $this->namespace . '/options';
        $request  = new \WP_REST_Request( 'GET', $endpoint );
        $response = $this->server->dispatch( $request );
        $data     = $response->get_data();
        $this->assertEquals( 0, count( $data ) );
    }
}
