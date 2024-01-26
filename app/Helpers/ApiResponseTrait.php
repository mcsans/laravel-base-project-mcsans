<?php

namespace App\Helpers;

trait ApiResponseTrait
{
    /**
     * Render Response in \Illuminate\Http\JsonResponse format
     *
     * @param  mixed  $status
     * @param  mixed  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginatedApiResponse(string $status, string $message, int $code, $data = null)
    {
        $result = [
            'status' => $status,
            'meta' => [
                'message' => $message,
            ],
        ];

        if ($data) {

            $result['meta'] = array_merge($result['meta'], [
                'pagination' => [
                    'total_data' => $data->total(),
                    'count' => count($data->items()),
                    'per_page' => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                ],
            ]);

            $result = array_merge($result, [
                'data' => $data->items(),
            ]);
        }

        return response()->json($result, $code);
    }

    public function specificApiResponse(string $status, string $message, int $code, $data = null)
    {
        $result = [
            'status' => $status,
            'meta' => [
                'message' => $message,
            ],
        ];

        if ($data) {

            $result = array_merge($result, [
                'data' => $data,
            ]);
        }

        return response()->json($result, $code);
    }
}
