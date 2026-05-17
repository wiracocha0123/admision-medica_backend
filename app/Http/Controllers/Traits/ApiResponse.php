<?php

namespace App\Http\Controllers\Traits;

trait ApiResponse
{
    protected function success($data, string $message = 'Éxito', int $code = 200)
    {
        if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return response()->json(array_merge(
                $data->toArray(),
                ['message' => $message]
            ), $code);
        }

        return response()->json(['data' => $data, 'message' => $message], $code);
    }

    protected function error($errors, string $message = 'Error', int $code = 400)
    {
        return response()->json(['errors' => $errors, 'message' => $message], $code);
    }
}
