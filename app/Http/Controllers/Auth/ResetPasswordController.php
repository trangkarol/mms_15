<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * change password.
     *
     * @param  array  $data
     * @return User
     */
    public function index()
    {
        return view('common.change_password');
    }

    /**
     * change password.
     *
     * @param  array  $data
     * @return User
     */
    public function changePassWord(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::logout();
        $request->session()->flash('success', trans('user.msg.change-password-success'));
        return redirect()->action('Auth\LoginController@login');
    }
}
