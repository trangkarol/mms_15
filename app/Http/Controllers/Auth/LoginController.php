<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Activity $activity)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->activity = $activity;
    }

    /**
     * login.
     *
     * @return void
     */
    public function index()
    {
        return view('common.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(LoginRequest $request)
    {
        $user = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($user)) {
            $request->session()->flash('success', trans('user.msg.login-success'));

            if (Auth::user()->isAdmin()) {
                $this->activity->insertActivities(Auth::user(), 'login');
                return redirect()->action('Admin\UserController@index');
            }

            $this->activity->insertActivities(Auth::user(), 'login');
            return redirect()->action('Member\HomeController@index');
        }

        $request->session()->flash('fail', trans('user.msg.login-fail'));
        return redirect()->action('Auth\LoginController@index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $this->activity->insertActivities(Auth::user(), 'logout');
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->action('Auth\LoginController@index');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function changePassword(Request $request)
    {
        $this->activity->insertActivities(Auth::user(), 'logout');
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->action('Auth\LoginController@index');
    }
}
