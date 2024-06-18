<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function sendOtp(string $email) {
        $otp = random_int(100000, 999999);
        Redis::setex('otp:' . $email, 300, $otp);

        Mail::to($email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully.'], 200);
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);


        $role = Role::where('wording', 'default')->first();
        if ($role) {
            $user->roles()->attach($role);
        }
        if($user){

            $this->sendOtp($user->email);
        }

        return response()->json(['message' => 'User registered successfully. Please check your email for OTP.'], 201);
    }

    public function verifyOtp(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|integer'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $otp = Redis::get('otp:' . $user->id);


        if (!$otp || $otp != $request->otp) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        
        $user->email_verified_at = now();
        $user->save();
        Redis::del('otp:' . $user->id);

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('email', 'password');

   
        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }

}
