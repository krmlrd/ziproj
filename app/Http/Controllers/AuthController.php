<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  use AuthenticatesUsers;

  public function register(Request $request)
  {
      $v = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password'  => 'required|string|min:3|confirmed',
      ]);

      if ($v->fails())
      {
          return response()->json([
              'status' => 'error',
              'errors' => $v->errors()
          ], 422);
      }

      return User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
      ]);
  }

  public function login(Request $request)
  {
      $v = Validator::make($request->all(), [
          'email' => 'required|string|email',
          'password' => 'required|string',
      ]);

      if ($v->fails())
      {
          return response()->json([
              'status' => 'error',
              'errors' => $v->errors()
          ], 422);
      }

      $credentials = $request->only('email', 'password');
      if (!Auth::guard()->attempt($credentials)) {
        return response()->json(['error' => 'Your credentials are incorrect. Please try again'], 401);
      }

      $http = new \GuzzleHttp\Client;
      try {
          $response = $http->post(config('services.passport.token_endpoint'), [
              'form_params' => [
                  'grant_type' => 'password',
                  'client_id' => config('services.passport.client_id'),
                  'client_secret' => config('services.passport.client_secret'),
                  'username' => $request->email,
                  'password' => $request->password,
              ]
          ]);
          $responseBody = json_decode($response->getBody(), true);
          return response()
              ->json([
                  'token_type' => $responseBody['token_type'],
                  'expires_in' => $responseBody['expires_in'],
                  'access_token' => $responseBody['access_token'],
                  'refresh_token' => $responseBody['refresh_token'],
              ], 200)->header('Authorization', $responseBody['access_token']);
      } catch (\GuzzleHttp\Exception\BadResponseException $e) {
        return response()->json(['message' => $e->getMessage()], $e->getCode());
          if ($e->getCode() === 400) {
              return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
          } else if ($e->getCode() === 401) {
              return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
          }
          return response()->json('Something went wrong on the server.', $e->getCode());
      }
  }

  public function logout()
  {
      Auth::user()->tokens->each(function($token, $key) {
        $token->delete();
        // $token->revoke();
      });

      return response()->json([
          'status' => 'success',
          'msg' => 'Logged out successfully.'
      ], 200);
  }

  public function user(Request $request)
  {
      $user = User::find(Auth::user()->id);
      return response()->json([
          'status' => 'success',
          'data' => $user
      ]);
  }

  public function refresh(Request $request)
  {
    $v = Validator::make($request->all(), [
        'refresh_token' => 'required|string',
    ]);

    if ($v->fails())
    {
        return response()->json([
            'status' => 'error',
            'errors' => $v->errors()
        ], 422);
    }

    $http = new \GuzzleHttp\Client;
    try {
        $response = $http->post(config('services.passport.token_endpoint'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
            ],
        ]);
        $responseBody = json_decode($response->getBody(), true);

        return response()
            ->json([
                'token_type' => $responseBody['token_type'],
                'expires_in' => $responseBody['expires_in'],
                'access_token' => $responseBody['access_token'],
                'refresh_token' => $responseBody['refresh_token'],
            ], 200)->header('Authorization', $responseBody['access_token']);
      } catch (\GuzzleHttp\Exception\BadResponseException $e) {
          return response()->json('Something went wrong on the server.', $e->getCode());
    }

    return response()->json(['error' => 'refresh_token_error'], 401);
  }
}
