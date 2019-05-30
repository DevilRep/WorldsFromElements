<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\BadResponseException;

class Auth extends Controller
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
                    'username' => $request->username,
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
}
