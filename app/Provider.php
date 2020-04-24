<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'provider';
    protected $primaryKey = 'rut_provider';

    public function exist($rut_provider) {
        $count = Provider::where('rut_provider', $rut_provider)->count();
        if($count == 1){
            return true;
        }else{
            return false;
        }
    }

    public function createProvider($rut_provider, $id_pais, $name, $telephone, $address, $email) {
        $provider = new Provider;

        $provider->rut_provider = $rut_provider;
        $provider->id_country   = $id_pais;
        $provider->name         = $name;
        $provider->telephone    = $telephone;
        $provider->address      = $address;
        $provider->email        = $email;

        $provider->save();
    }
}
