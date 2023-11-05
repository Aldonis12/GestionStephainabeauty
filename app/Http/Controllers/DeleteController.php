<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDetails;
use App\Models\EmployeService;
use App\Models\InfluenceurPrestataire;
use App\Models\Question;
use App\Models\ReponseClient;
use App\Models\Salon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    public function DeleteClient($i){
        try {
            DB::beginTransaction();
            
            DB::delete('DELETE FROM reponseclient WHERE idclient =?', [$i]);
            DB::delete('DELETE FROM clientdetails WHERE idclient =?', [$i]);

            $Client = Client::find($i);
            $Client->delete();

            DB::commit();

            return redirect('/ListClient');
    
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function DeleteQuestion($i){
        try {
            DB::beginTransaction();
            
            DB::delete('DELETE FROM reponseclient WHERE idquestion =?', [$i]);
            DB::delete('DELETE FROM reponse WHERE idquest =?', [$i]);

            $question = Question::find($i);
            $question->delete();

    
            DB::commit();
    
            return redirect('/ListQuestion');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }

    public function DeleteEmployeService($id){
            DB::delete('DELETE FROM employeservice WHERE id =?', [$id]);
            return redirect()->back();
    }

    public function DeleteSalon($id){
        try {
            DB::beginTransaction();
            
            EmployeService::where('idsalon',$id)->delete();
            ClientDetails::where('idsalon',$id)->delete();
            ReponseClient::where('idsalon',$id)->delete();
            InfluenceurPrestataire::where('idsalon',$id)->delete();
            Salon::where('id',$id)->delete();

            DB::commit();
    
            return redirect('/ListSalon');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }

    public function DeleteService($id){
        try {
            DB::beginTransaction();
            
            EmployeService::where('idservice',$id)->delete();
            ClientDetails::where('idservice',$id)->delete();
            InfluenceurPrestataire::where('idservice',$id)->delete();
            Service::where('id',$id)->delete();

            DB::commit();
    
            return redirect('/ListService');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }
}
