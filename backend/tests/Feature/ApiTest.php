<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Test that Servers can be listed.
     *
     * @return void
     */
    public function test_can_get_servers_list()
    {
        $response = $this->get('/api/servers');

        $response->assertStatus(200);
    }

    /**
     * Test that Servers locations can be listed.
     *
     * @return void
     */
    public function test_can_get_servers_locations_list()
    {
        $response = $this->get('/api/servers/filters/location');

        $response->assertStatus(200);
    }

    /**
     * Test that Servers can be filter.
     *
     * @return void
     */
    public function test_can_get_servers_filter_list()
    {
        $form_data = [
            "filters" => [
                "Storage" => [
                    "start" => "57TB",
                    "end" => "72TB"
                ],
                "RAM" => ["4GB,8GB"],
                "HardDisk_Type" => "SATA",
                "Location" => "AmsterdamAMS-01"
            ]
        ];
        $response = $this->post('/api/servers/filters', $form_data);

        $response->assertStatus(200);
    }

    /**
     * Test JSON filter structure.
     *
     * @return void
     */
    public function test_JSON_estructure()
    {
        $form_data = [
            "filters" => [
                "Storage" => [
                    "start" => "57TB"
                ],
                "RAM" => ["4GB,8GB"],
                "HardDisk_Type" => "SATA",
                "Location" => "AmsterdamAMS-01"
            ]
        ];
        $response = $this->post('/api/servers/filters', $form_data);

        $response->assertStatus(400);
    }
}
