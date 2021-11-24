<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Interfaces\PropertyRepositoryInterface;
use App\Models\Property;
use App\Traits\AnswerResponseTrait;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    use AnswerResponseTrait;

    /**
     * @var PropertyRepositoryInterface
     */
    private $propertyRepository;

    /**
     * @param PropertyRepositoryInterface $propertyRepository
     */
    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $property = $this->propertyRepository->list();
        return $this->apiSuccess($property);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PropertyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PropertyRequest $request): JsonResponse
    {
        $property = $this->propertyRepository->store($request);

        return $property instanceof \Exception
            ? $this->apiError($property->getMessage())
            : $this->apiCreated($property);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Property $property): JsonResponse
    {
        return $this->apiSuccess($this->propertyRepository->show($property));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PropertyRequest  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        PropertyRequest $request,
        Property $property
    ): JsonResponse {
        $property = $this->propertyRepository->update($request, $property);

        return $property instanceof \Exception
            ? $this->apiError($property->getMessage())
            : $this->apiUpdated($property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Property $property): JsonResponse
    {
        $this->propertyRepository->delete($property);
        return $this->apiDeleted();
    }
}
