<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ResponseResource;

class AuthController extends Controller
{
   public function registration(Request $request){
      $data = $request->validate([
         'name' => 'required|string|min:3|max:255',
         'email' => 'required|email|unique:users,email',
         'password' => 'required|string|min:3|max:255',
         'password_confirmation' => 'required|string|min:3|max:255|same:password',
      ]);

      $user =  User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => bcrypt($data['password']),
      ]);

      $token = $user->createToken('app_token')->plainTextToken;

      $userResponse = [
         'uuid' => $user->uuid,
         'name' => $user->name,
         'token' => $token
      ];

      return new ResponseResource(true, 'User created', $userResponse, [
         'code' => 201
      ], 201);


   }
}
