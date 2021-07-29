<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'rut_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    
    /**
     * hasRoles
     * 
     * Busca el nombre del rol del usuario en base a su id
     *
     * @param  array $roles
     *
     * @return bool
     */
    public function hasRoles(array $roles)
    {
        foreach ($roles as $role)
        {
            if ($this->role->name == $role)
            {
                return true;
            }
        }
        return false;
    }
    
    public function validarRut($rut, $dvForm){
        $dv;
        $numero;
        $constante = 2;
        $suma = 0;
        $largo = strlen($rut);

        if(strlen($rut) > 0){
            for($i = $largo -1; $i>=0 ; $i--){
                (int)$numero = (int) substr($rut,(int) $i, 1);
                $suma = $suma + ($numero*$constante);
                $constante +=1;
                if ($constante == 8){
                    $constante = 2;
                }
            }
        }else{
            return false;
        }
            $dv=(11-((int)$suma%11));
            if($dv == 10){
                $dv = "K";
            }
            if($dv == 11){
                $dv = "0";
            }
            if($dv == $dvForm){
                return true;
            }else if(strcasecmp($dv, $dvForm) == 0){
                return true;
            }
            else{
                return false;
            }
        }
    
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
}
