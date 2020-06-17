<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'id_log';

    public function productLog($rut_user, $action){
        $log = new Log();
        $log->rut_user = $rut_user;
        $log->action = $action;
        $log->save();
    }
}
