<?php

namespace App\Interfaces;

interface PropertyRepositoryInterface
{
    public function list();

    public function store($request);

    public function show($property);

    public function update($request, $property);

    public function delete($property);
}
