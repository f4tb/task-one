<?php

namespace App\Helpers;

class ApiHelper
{
    public static function std_response_format($data)
    {
        return [
            'success' => $data['success'],
            'data' => ($data['data']) ? $data['data'] : [],
            'error' => ($data['error']) ? $data['error'] : '',
            'errors' => ($data['errors']) ? $data['errors'] : [],
        ];
    }

}
