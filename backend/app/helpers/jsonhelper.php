<?php    
/**
 * jsonのレスポンスを返す際に使うヘルパー関数群
 */

if(! function_exists('getJsonResponse')) {
    function getJsonResponse(?array $data = [], ?int $status_code = 200)
    {
        $data = [
            'data'   => $data,
            'errors' => null,
            'messages' => null,
        ];
        return response()->json($data, $status_code, [], JSON_UNESCAPED_UNICODE);
    }
}

if(! function_exists('getErrorJsonResponse')) {
    function getErrorJsonResponse(int $status_code, string $error_messages = null, ?array $errors = [])
    {
        $data = [
            'data'   => [],
            'errors' => null,
            'messages' => $error_messages,
        ];
        return response()->json($data, $status_code, [], JSON_UNESCAPED_UNICODE);
    }
}

if(! function_exists('getJsonMessageOnlyResponse')) {
    function getJsonMessageResponse(?string $messages = '', ?int $status_code = 200)
    {
        $data = [
            'messages' => $messages,
            'errors' => null,
        ];
        return response()->json($data, $status_code, [], JSON_UNESCAPED_UNICODE);
    }
}