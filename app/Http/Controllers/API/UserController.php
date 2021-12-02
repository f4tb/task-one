<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->where('role', 'client')->get();
        return response()->json(ApiHelper::std_response_format([
            'success' => true,
            'error' => array('message' => 'User(s) List'),
            'errors' => [],
            'data' => [
                'users' => $users
            ]
        ]));
    }

    public function show(User $user)
    {
        return response()->json(ApiHelper::std_response_format([
            'success' => true,
            'error' => array('message' => 'User Details'),
            'errors' => [],
            'data' => [
                'user' => $user
            ]
        ]));
    }

    public function store(Request $request)
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

    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
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
            $user->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
            ]);
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'User Updated'),
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

    public function destroy(User $user)
    {
        try{
            $user->delete();
            return response()->json(ApiHelper::std_response_format([
                'success' => true,
                'error' => array('message' => 'User Deleted!'),
                'errors' => [],
                'data' => []
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
}
