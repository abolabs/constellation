<?php

namespace App\Http\Utils;

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse(string $message, $data, ?int $total=null)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
        if(!is_null($total)){
            $response['total'] = $total;
        }
        return $response;
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
