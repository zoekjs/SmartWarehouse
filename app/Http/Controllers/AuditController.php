<?php

namespace App\Http\Controllers;
use App\Log;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(){
        $log = new log();
        $logs = $log->getLogs();

//        return view('admin/auditoria', compact('logs'));
        return $logs->toJson();
    }
    public function create() {
        return view('admin/auditoria');
    }
}
