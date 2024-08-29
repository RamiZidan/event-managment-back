<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCodes;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordByLinkRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController 
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = User::where('email', $request->email)->first();    
            if($user->type != 'admin' && $user->email_verified_at == NULL ){
                return response()->json(['message' => 'please verify your email first'], 403 );
            }
            $token = $user->createToken('my-app-token')->plainTextToken;
 
            return response()->json(['user' => $user, 'token' => $token ], 200);
        } else {
            return response()->json(['message' => 'Invalid email or password'], 400);
        }
    }
    public function reset_password(ResetPasswordByLinkRequest $request ){
        $code = UserCodes::where('code' , $request->code )->orderBy('created_at','DESC')->first();
        $user = User::where('id', $code->user_id )->update([
            'password'=> bcrypt($request->password)
        ]);

        $user = User::where('id', $code->user_id)->first();
        
        $codes = UserCodes::where('user_id' , $user->id)->where('type' , 'forget_password')->delete();
  
        return response()->json(['message'=>'Password has been updated you can log into your account']);
    }
    public function forget_password(ForgetPasswordRequest $request){
        $user = User::where('email' , $request->email )->first();
        $user->verfication_code = Str::uuid();
        $expiration_date = (new Carbon())->addMinutes(30);
        try{
            // Mail::to($user->email)->send(new forgetPasswordMail($user));
        }
        catch(Exception $e){
            return response()->json(['message'=> 'failed to send email check your email address'] , 422 ) ;
        }
        $code = UserCodes::create([
            'user_id' => $user->id,
            'code' => $user->verfication_code,
            'type' => 'forget_password',
            'expiration_date' => $expiration_date
        ]);
        // delete all previous codes
        $codes = UserCodes::where('code' , '!=' , $user->verfication_code)->where('user_id' , $user->id)->where('type' , 'forget_password')->delete();

        return response()->json(['message' => 'Verfication link was sent to your email']);
    }
    
}