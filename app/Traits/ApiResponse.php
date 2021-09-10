<?php


namespace App\Traits;

trait ApiResponse
{
    protected function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    protected function error($message, $code = 404)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showOne($instance, $code = 200)
    {
        return $this->success(['data' => $instance], $code);
    }

    protected function showAll($collection, $code = 200)
    {
        return $this->success(['data' => $collection], $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->success(['data' => $message], $code);
    }
}
