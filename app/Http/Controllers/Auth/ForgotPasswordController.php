<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordPostRequest;
use App\Http\Requests\ResetPostRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Show view.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_email()
    {
       return view('auth.passwords.email');
    }

    /**
     * Post forgot password email.
     *
     * @param  App\Http\Requests\ForgotPasswordPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function post_email(ForgotPasswordPostRequest $request)
    {
        $token = Str::random(30);

        DB::table('password_resets')->insert(
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('auth.mail',['token' => $token, 'email' => $request->email ], function($message) use ($request) {
                    $message->from('admin@igsprotech.com.my');
                    $message->to($request->email);
                    $message->subject('Reset Password Notification');

               });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function reset_page($token)
    {
        return view('auth.passwords.reset', compact('token'));
    }


    /**
     * Reset password.
     *
     * @param  App\Http\Requests\ResetPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(ResetPostRequest $request)
    {
        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        // Redirect the user back to the password reset request form if the token is invalid
        if(!$tokenData) return redirect('forgot-password')->with('error','Invalid token. Request another reset link or try again later.');

        $password = $request->new_password;
        $user = User::where('email', $tokenData->email)->first();

        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found.']);

        $user->password = Hash::make($password);
        $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect('/')->with('success', 'Password successfully reset!');
    }

}
