<?php

namespace App\Http\Controllers\Api\v1\PasswordReset;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    public function __invoke(ForgetPasswordRequest $request)
    {

        $data = $request->all();
        ResetCodePassword::where('email', $request->email)->delete();

        $data['code'] = mt_rand(100000, 999999);

        $codeData = ResetCodePassword::create($data);

        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

        return response(['message' => trans('passwords.sent')], 200);
    }
}
