<?php

namespace Tests\Feature;

use App\Traits\TestHelperTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PropertyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, TestHelperTrait;

    protected $header;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->header = ['Accept' => 'application/json'];
    }

    /**
     * Api test for properties list
     *
     * @return void
     */
    public function test_list_properties_with_pagination()
    {
        $this->createProperties(10);

        $this->getJson(route('properties.index'), $this->header)
            ->assertStatus(200);
    }

    /**
     * Api test for property create
     *
     * @return void
     */
    public function test_store_property()
    {
        $owners = $this->ownerCreationFactory(3)->create();

        $ownerIds = $owners->pluck('id');
        $mainOwnerId = $ownerIds->random();

        $payload = [
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'owners' => $ownerIds,
            'main_owner' => $mainOwnerId
        ];

        $this->postJson(route('properties.store'), $payload, $this->header)
            ->assertStatus(201);
    }

    /**
     * Api test to show property
     *
     * @return void
     */
    public function test_show_property()
    {
        $property = $this->createProperties();

        $this->getJson(route('properties.show', $property), $this->header)
            ->assertStatus(200);
    }

    /**
     * Api test for property update
     *
     * @return void
     */
    public function test_update_property()
    {
        $property = $this->createProperties();

        $owners = $this->ownerCreationFactory(3)->create();

        $ownerIds = $owners->pluck('id');
        $mainOwnerId = $ownerIds->random();

        $payload = [
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'owners' => $ownerIds,
            'main_owner' => $mainOwnerId
        ];

        $this->putJson(route('properties.update', $property), $payload, $this->header)
            ->assertStatus(201);
    }

    /**
     * Api test for property delete
     *
     * @return void
     */
    public function test_delete_property()
    {
        $property = $this->createProperties();

        $this->deleteJson(route('properties.destroy', $property), $this->header)
            ->assertStatus(204);
    }
}
