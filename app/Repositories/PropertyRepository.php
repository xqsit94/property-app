<?php

namespace App\Repositories;

use App\Interfaces\PropertyRepositoryInterface;
use App\Models\Property;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyRepositoryInterface
{
    /**
     * Return property with pagination
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return Property::with(["address", "owners"])->paginate();
    }

    /**
     * Creates new property
     *
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $property = Property::create();

            $property->address()->create($this->addressRequests());

            $this->propertyOwnerSync($request, $property);

            DB::commit();

            return $property;
        } catch (\Exception $exception) {
            DB::rollBack();

            return $exception;
        }
    }

    /**
     * returns single property
     *
     * @param $property
     * @return Property
     */
    public function show($property): Property
    {
        return $property->load(["address", "owners"]);
    }

    /**
     * Updates the property
     *
     * @param $request
     * @param $property
     * @return mixed
     */
    public function update($request, $property)
    {
        DB::beginTransaction();
        try {
            $property->address()->update($this->addressRequests());

            $property->owners()->detach($request->owners);

            $this->propertyOwnerSync($request, $property);

            DB::commit();

            return $property;
        } catch (\Exception $exception) {
            DB::rollBack();

            return $exception;
        }
    }

    /**
     * Deletes the property
     *
     * @param $property
     * @return mixed
     */
    public function delete($property)
    {
        return $property->delete();
    }

    /**
     * Syncs owners with property
     *
     * @param $request
     * @param $property
     * @return void
     */
    private function propertyOwnerSync($request, $property): void
    {
        $property
            ->owners()
            ->sync([
                ...$request->owners,
                $request->main_owner => ["main_owner" => true],
            ]);
    }

    /**
     * Address request
     *
     * @return array
     */
    private function addressRequests(): array
    {
        return [
            "house_name_number" => request()->address,
            "postcode" => request()->postcode,
        ];
    }
}
