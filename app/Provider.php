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

    public function searchProvider($rut_provider) {
        return \DB::table('provider as p')
                ->join('country as c', 'p.id_country', '=', 'c.id_country')
                ->select('p.rut_provider', 'p.name', 'p.telephone', 'p.address', 'p.email', 'p.id_country', 'c.name as country_name')
                ->where('p.rut_provider', $rut_provider)
                ->get();
    }

    public function updateProvider($rut_provider, $id_country, $name, $telephone, $address, $email) {
        $provider = Provider::where('rut_provider', $rut_provider)->firstOrFail();
        $provider->id_country   = $id_country;
        $provider->name         = $name;
        $provider->telephone    = $telephone;
        $provider->address      = $address;
        $provider->email        = $email;
        
        $provider->save();
    }

    public function deleteProvider($rut_provider) {
        $provider = Provider::where('rut_provider', $rut_provider)->firstOrFail();
        $provider->delete();
    }

}
