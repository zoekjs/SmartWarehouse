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

    public function getLogs(){
        return \DB::table('log as l')
            ->join('users as u', 'u.rut_user', '=', 'l.rut_user')
            ->select('l.rut_user', 'l.action', 'l.created_at', 'u.name', 'u.last_name')
            ->orderBy('l.created_at', 'desc')
            ->paginate(10);
    }
}

