<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingress extends Model
{
    protected $table = 'ingress';
    protected $primaryKey = 'id_ingress';

    public function storeIngress($rut_user, $id_type_document, $document_number, $observation, $rut_provider){
        $ingress = new Ingress();
        $ingress->rut_user              = $rut_user;
        $ingress->id_type_document      = $id_type_document;
        $ingress->document_number       = $document_number;
        $ingress->observation           = $observation;
        $ingress->rut_provider          = $rut_provider;
        $ingress->id_status             = 1;
        $ingress->save();
    }

    public function getAllIngresses(){
        return \DB::table('ingress as i')
            ->join('provider as p', 'p.rut_provider', '=', 'i.rut_provider')
            ->join('status as s', 's.id_status', '=', 'i.id_status')
            ->join('type_document as td', 'td.id_type_document', '=', 'i.id_type_document')
            ->select('i.id_ingress', 'td.name as type_document', 'p.rut_provider', 'p.name as provider_name', 's.name as status_name', 'i.created_at')
            ->paginate(10);
    }

    public function updateStatus($id_ingress){
        $ingress = Ingress::where('id_ingress', $id_ingress)->firstOrFail();
        if($ingress->id_status == 1){
            $ingress->id_status = 5;
            $ingress->save();
        }
    }
    
}
