<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait AnswerResponseTrait
{
    /**
     * @var string
     */
    protected $errors = "errors";

    /**
     * @param $resource
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSuccess($resource, $code = 200)
    {
        return $this->_response($resource, $code);
    }

    /**
     * @param $resource
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiCreated($resource, $code = 201)
    {
        return $this->_response($resource, $code);
    }

    /**
     * @param $resource
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdated($resource, $code = 201)
    {
        return $this->_response($resource, $code);
    }

    /**
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDeleted($code = 204)
    {
        return $this->_response(null, $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiError($message, $code = 500)
    {
        $error = ["message" => [$message]];

        return response()->json(
            [
                $this->errors => $error,
            ],
            $code
        );
    }

    /**
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    private function dataValidationException($exception)
    {
        $errors = $exception->errors();
        return response()->json(
            [
                $this->errors => $errors,
            ],
            422
        );
    }

    /**
     * @param $resource
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function _response($resource, $code)
    {
        return response()->json($resource, $code);
    }

    /**
     * Handles most of laravel exception
     *
     * @param $request
     * @param $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handleException($request, $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->dataValidationException($exception);
        }
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->apiError(
                "Does not exists any {$modelName} with the specified id",
                404
            );
        }
        if ($exception instanceof AuthenticationException) {
            return $this->apiError("Unauthenticated", 401);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->apiError($exception->getMessage(), 403);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->apiError(
                "The specified method for the request is invalid",
                405
            );
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->apiError("The specified URL cannot be found", 404);
        }
        if ($exception instanceof HttpException) {
            return $this->apiError(
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1451) {
                return $this->apiError(
                    "Cannot remove this resource permanently. It is related with any other resource",
                    409
                );
            }
        }
        if ($exception instanceof TokenMismatchException) {
            return redirect()
                ->back()
                ->withInput($request->input());
        }

        return $this->apiError($exception->getMessage(), 500);
    }
}
