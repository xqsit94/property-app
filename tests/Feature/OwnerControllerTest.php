<?php

namespace Tests\Feature;

use App\Traits\TestHelperTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerControllerTest extends TestCase
{
    use RefreshDatabase, TestHelperTrait;

    /**
     * An api test for get all owners
     *
     * @return void
     */
    public function test_get_all_owners()
    {
        $this->ownerCreationFactory(10)->create();

        $this->get(route('owners.list'))->assertStatus(200);
    }
}
