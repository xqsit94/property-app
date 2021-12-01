<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Phone;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait TestHelperTrait
{
    /**
     * @param null $count
     * @return Factory
     */
    protected function ownerCreationFactory($count = null) : Factory
    {
        return User::factory($count)
            ->has(
                Phone::factory()
                    ->count(3)
                    ->state(new Sequence(
                        ['type' => Phone::PHONE_TYPE['MOBILE']],
                        ['type' => Phone::PHONE_TYPE['WORK']],
                        ['type' => Phone::PHONE_TYPE['HOME']],
                    ))
            );
    }

    /**
     * @param null $count
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    protected function createProperties($count = null)
    {
        return Property::factory($count)
            ->has(
                Address::factory()
            )
            ->has($this->ownerCreationFactory(3), 'owners')
            ->hasAttached($this->ownerCreationFactory(), ['main_owner' => true], 'owners')
            ->create();
    }
}
