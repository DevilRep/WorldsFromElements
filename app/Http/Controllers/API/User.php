<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class User extends Controller
{
    public function login(Request $request)
    {
        $http = new Guzzle();
        try {
            $response = $http->post(config('services.passport.endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password
                ]
            ]);
            return $response->getBody();
        } catch(BadResponseException $exception) {
            if ($exception->getCode() === 400) {
                return response()->json(['message' => 'Invalid Request. Please enter a username and a password'], $exception->getCode());
            }
            if ($exception->getCode() === 401) {
                return response()->json(['message' => 'Your credentials are incorrect. Please try again'], 401);
            }
            return response()->json(['message' => 'Something went wrong on the server'], $exception->getCode());
        }
    }

    public function signup(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ])->validate();
        } catch (ValidationException $exception) {
            return response()->json(['message' => $exception->validator->errors()->all()[0]], 422);
        }
        \App\Models\User::create(array_merge($validated, [
            'password' => Hash::make($validated['password']),
        ]));
        return $this->login($request);
    }

    public function info(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json('ok');
    }
}
