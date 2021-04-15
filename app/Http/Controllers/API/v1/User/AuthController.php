<?php

namespace App\Http\Controllers\API\V1\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\VerificationTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResendOtpRequest;
use App\Http\Requests\User\VerifyOtpRequest;
use App\Http\Requests\User\UserRegistrationRequest;

class AuthController extends Controller
{
    use VerificationTrait;
    //
    public function register(UserRegistrationRequest $request)
    {
        $verify = $this->send_otp($request->phone);

        if ($verify == null) {
            # code...

            $response = [
                'status' => 'error',
                'message' => 'Unable to handle OTP Generation request'
            ];

            return response()->json($response, 400);
        }

        $user = User::create($request->validated());

        if ($user == false) {
            # code...

            $response = [
                'status' => 'Error',
                'message' => 'Error creating user account. Please try again.'
            ];

            return response()->json($response, 400);
        }

        $token = $user->createToken('user')->plainTextToken;

        $response = [
            'status' => 'success',
            'message' => 'User account successfully created',
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function verify(VerifyOtpRequest $request)
    {
        $verify = $this->verify_otp($request->validated());

        if ($verify == null) {
            # code...

            $response = [
                'status' => 'error',
                'message' => 'Unable to verify OTP'
            ];

            return response()->json($response, 400);
        }

        if ($verify == false) {
            # code...

            $response = [
                'status' => 'error',
                'message' => 'OTP is incorrect'
            ];

            return response()->json($response, 400);
        }

        $user = User::where('phone', $request->phone);

        $response = [
            'status' => 'success',
            'message' => 'OTP successfully confirmed',
            'user' => $user->first()
        ];

        $verify_user = $user
            ->update(['verified_at' => now()->toDateTimeString()]);

        return response()->json($response, 200);
    }

    public function resend(ResendOtpRequest $request)
    {
        $verify = $this->send_otp($request->phone);

        if ($verify == null) {
            # code...

            $response = [
                'status' => 'error',
                'message' => 'Unable to handle OTP Generation request'
            ];

            return response()->json($response, 400);
        }

        $response = [
            'status' => 'success',
            'message' => 'OTP successfully resent'
        ];

        return response()->json($response, 200);
    }
}