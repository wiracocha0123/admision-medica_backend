<?php

namespace App\Http\Controllers\Traits;

trait ApiResponse
{
    protected function success($data, string $message = 'Éxito', int $code = 200)
    {
        if ($data instanceof \Illuminate\Contracts\Pagination\Paginator || 
            $data instanceof \Illuminate\Pagination\LengthAwarePaginator ||
            $data instanceof \Illuminate\Pagination\AbstractPaginator) {
            return response()->json($data, $code);
        }

        if (is_array($data) && isset($data['current_page']) && isset($data['data'])) {
            return response()->json($data, $code);
        }

        return response()->json(['data' => $data, 'message' => $message], $code);
    }

    protected function error($errors, string $message = 'Error', int $code = 400)
    {
        return response()->json(['errors' => $errors, 'message' => $message], $code);
    }
}
