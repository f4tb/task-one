<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Invalid Parameters'),
                'errors' => $validator->errors(),
                'data' => []
            ]), 400);
        }
        try {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'role' => 'client',
            ]);
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'User Added'),
                'errors' => [],
                'data' => [
                    'user' => $user
                ]
            ]));
        } catch (\Exception $e){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Error Occurred!'),
                'errors' => [],
                'data' => []
            ]));
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Invalid Parameters'),
                'errors' => $validator->errors(),
                'data' => []
            ]), 400);
        }
        try {
            if (!auth()->attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                return response()->json(ApiHelper::std_response_format([
                    'success' => false,
                    'error' => array('message' => 'Invalid Credentials'),
                    'errors' => [],
                    'data' => []
                ]), 400);
            }
            $user = auth()->user();
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'Logged In'),
                'errors' => [],
                'data' => [
                    'user' => $user,
                    'access_token' => $accessToken,
                ]
            ]));
        } catch (\Exception $e){
            return response()->json(ApiHelper::std_response_format([
                'success' => false,
                'error' => array('message' => 'Error Occurred!'),
                'errors' => [],
                'data' => []
            ]));
        }
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json(ApiHelper::std_response_format([
            'success' => true,
            'error' => array('message' => 'User Details'),
            'errors' => [],
            'data' => ['user' => $user]
        ]));
    }

}
