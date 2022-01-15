<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;

class AuthenticationController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse|ResponseInterface
     */
    public function login(LoginRequest $request)
    {

        // create guzzle client
        $client = new Client();

        try {
            return $client->post(config('oauth.login_url'), [
                'form_params' => [
                    'client_secret' => config('oauth.users.client_secret'),
                    'grant_type' => 'password',
                    'client_id' => config('oauth.users.client_id'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);

        } catch (GuzzleException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
