<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/15/2024
 * @time: 10:50 PM
 */

namespace App\Traits;

use App\Http\Resources\Api\V1\EmptyResource;
use App\Http\Resources\Api\V1\EmptyResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

trait ApiHttpResponse
{
    /**
     * @param string|null $message
     * @param mixed|null $result
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function respondSuccess(string $message = null, mixed $result = null, int $statusCode = 200): JsonResponse
    {
        return $this->apiResponse([
            'success' => true,
            'message' => $message,
            'result' => ['data' => $result]
        ], $statusCode);
    }

    /**
     * @param JsonResource $resource
     * @return JsonResponse
     */
    protected function respondCreated(JsonResource $resource): JsonResponse
    {
        return $this->respondWithResource($resource,'Created successfully.' ,201);
    }

    /**
     * @param JsonResource $resource
     * @param string|null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithResource(JsonResource $resource, string $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse([
            'success' => true,
            'result' => ['data' => $resource],
            'message' => $message
        ], $statusCode, $headers);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondNoContentResource(string $message = 'No Content Found'): JsonResponse
    {
        return $this->respondWithResource(new EmptyResource([]), $message);
    }

    /**
     * @param ResourceCollection $resourceCollection
     * @param string|null $message
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithResourceCollection(ResourceCollection $resourceCollection, string $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse([
            'success' => true,
            'result' => $resourceCollection->response()->getData(),
            'message' => $message
        ], $statusCode, $headers);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondNoContentResourceCollection(string $message = 'No Content Found'): JsonResponse
    {
        return $this->respondWithResourceCollection(new EmptyResourceCollection([]), $message);
    }

    /**
     * @param string|null $message
     * @param int $statusCode
     * @param \Throwable|null $exception
     * @param string $errorCode
     * @return JsonResponse
     */
    protected function respondError(string $message = null, int $statusCode = 400, \Throwable $exception = null, string $errorCode = '1'): JsonResponse
    {
        return $this->apiResponse([
            'success' => false,
            'message' => $message ?? 'An error occurred. Please try again.',
            'exception' => $exception,
            'errorCode' => $errorCode
        ], $statusCode);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondNoContent(string $message = 'No Content Found'): JsonResponse
    {
        return $this->apiResponse(['success' => false, 'message' => $message]);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->respondError($message, 403);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondUnAuthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->respondError($message, 401);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->respondError($message, 404);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function respondInternalError(string $message = 'Internal Error'): JsonResponse
    {
        return $this->respondError($message, 500);
    }

    /**
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function respondValidationErrors(ValidationException $exception): JsonResponse
    {
        return $this->apiResponse([
            'success' => false,
            'message' => $exception->getMessage(),
            'errors' => $exception->errors()
        ], 422);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
    private function apiResponse(array $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        $result = $this->parseData($data, $statusCode, $headers);

        return response()->json(
            $result['content'],
            $result['statusCode'],
            $result['headers']
        );
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return array
     */
    private function parseData(array $data = [], int $statusCode = 200, array $headers = []): array
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null
        ];

        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }

        if (isset($data['status'])) {
            $responseStructure['statusCode'] = $data['status'];
        }

        if (isset($data['exception']) && ($data['exception'] instanceof \Error || $data['exception'] instanceof \Exception)) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }

        if ($data['success'] === false) {
            if (isset($data['errorCode'])) {
                $responseStructure['errorCode'] = $data['errorCode'];
            } else {
                $responseStructure['errorCode'] = '1';
            }
        }

        return [
            'content' => $responseStructure,
            'statusCode' => $statusCode,
            'headers' => $headers
        ];
    }
}
