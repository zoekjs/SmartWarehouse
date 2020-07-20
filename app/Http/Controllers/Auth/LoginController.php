<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Log;

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
    protected function authenticated(Request $request, $user)
    {
        $log = new Log();
        $rut_user = Auth::User()->rut_user;
        $action = 'Inicio sesión en el sistema';

        $log->productLog($rut_user, $action);
         $rol = Auth::User()->role->name;
        
         switch ($rol)
        {
            case 'Administrador':
                return redirect()->route('admin');
                break;
            case 'Supervisor':
                return redirect()->route('admin');
                break;
            case 'Bodeguero':
                return redirect()->route('menu');
                break;
            default:
                return redirect()->route('menu');
        }

    }

    public function logout(Request $request){
        $log = new Log();
        $rut_user = Auth::User()->rut_user;
        $action = 'Cerró sesión en el sistema';

        $log->productLog($rut_user, $action);
        
        Auth::logout();

        return redirect('login')
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
