<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

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
    protected $redirectTo = '/logout';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['index', 'update', 'email']);
    }
    
    /**
     * Return confirm view.
     *
     * @return void
     */
    public function index()
    {
        return view('auth.passwords.confirm');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update(Request $request, $rut_user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::find($rut_user);

        if (!empty($request->password) && !empty($request->password_confirmation))
        {
            $user->password = Hash::make($request->password);
            $user->save();
            return back()->with('success', 'Contraseña cambiada exitosamente');
        }
    }

    /**
     * Return email view.
     *
     * @return void
     */
    public function email()
    {
        return view('auth.passwords.email');
    }

}
