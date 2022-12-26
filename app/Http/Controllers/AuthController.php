<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
  use HttpResponses;

  public function login(LoginUserRequest $request)
  {

    $request->validated($request->all());

    if (!Auth::attempt($request->only(['email', 'password']))) {
      return $this->error('', 'Credentials do not match', 401);
    }

    $user = User::where('email', $request->email)->first();

    return $this->success([
      'user' => $user,
      'token' => $user->createToken('Api Token of ' . $user->name)->plainTextToken
    ]);
  }

  public function register(StoreUserRequest $request)
  {
    $request->validated($request->all());

    $user = User::create([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return $this->success([
      'user' => $user,
      'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
    ]);
  }

  public function logout()
  {
    Auth::user()->currentAccessToken()->delete();
    return response()->json('You have succesfully been logged out and your token has been removed');
  }

  public function ForgotPassword(Request $request)
  {
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();

    if ($user) {
      $response = Password::sendResetLink(['email' => $request->email]);

      if ($response == Password::RESET_LINK_SENT) {
        return $this->success('Reset link sent successfully. Check your email inbox');
      } else {
        return  $this->error('', 'something went wrongzaaa', 500);
      }
    } else {
      return $this->error('', 'user not found', 404);
    }
  }

  public function resetPassword(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required|min:6|confirmed',
      'token' => 'required',
    ]);
    // get the user based on the email address
    $user = User::where('email', $request->email)->first();

    if ($user) {
      // reset the user's password
      $user->password = Hash::make($request->password);
      $user->save();

      return $this->success($user, 'Password updated successfully', 200);
    } else {
      $this->error('', 'email is not registered', '404');
    }
  }

  public function resendVerification(Request $request)
  {
    if ($request->user()->sendEmailVerificationNotification()) {
      return $this->success('Verification link sent');
    } else {
      return $this->error('', 'unable to send verification link', 500);
    }
  }
}
