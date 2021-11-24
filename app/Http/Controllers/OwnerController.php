<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AnswerResponseTrait;
use Illuminate\Http\JsonResponse;

class OwnerController extends Controller
{
    use AnswerResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $owners = User::all();
        return $this->apiSuccess($owners);
    }
}
