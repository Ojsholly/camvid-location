<?php

namespace App\Traits;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

/**
 *
 */
trait VerificationTrait
{

    protected function twilio()
    {
        $twilio_token = env('TWILIO_AUTH_TOKEN');
        $twilio_sid = env('TWILIO_SID');

        return new Client($twilio_sid, $twilio_token);
    }

    protected function verify_sid()
    {
        return env('TWILIO_VERIFY_SID');
    }

    protected function send_otp($phone)
    {
        try {

            $this->twilio()->verify->v2->services($this->verify_sid())
                ->verifications
                ->create($phone, "sms");
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            return null;
        }

        return true;
    }

    protected function verify_otp(array $data)
    {

        try {
            //code...

            $verification = $this->twilio()->verify->v2->services($this->verify_sid())
                ->verificationChecks
                ->create($data['token'], ['to' => $data['phone']]);
        } catch (\Throwable $th) {
            //throw $th;

            Log::error($th);

            return null;
        }

        return $verification->valid;
    }
}