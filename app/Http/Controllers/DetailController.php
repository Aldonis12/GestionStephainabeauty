<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDetails;
use App\Models\Employe;
use App\Models\EmployeService;
use App\Models\Influenceur;
use App\Models\InfluenceurPrestataire;
use App\Models\Salon;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function detailSalon($id) {
        $titre = "detailSalon";
        $salon = Salon::find($id);
        $services = DB::table('v_dashcarousel')->where('salon_id', $id)->get();
        
        $empdisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.iscanceled', 0)
            ->count();
    
        $empindisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.iscanceled', 1)
            ->count();
    
        $hommedisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.idgenre', 1)
            ->where('employe.iscanceled', 0)
            ->count();
    
        $femmedisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.idgenre', 2)
            ->where('employe.iscanceled', 0)
            ->count();
    
        $hommeindisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.idgenre', 1)
            ->where('employe.iscanceled', 1)
            ->count();
    
        $femmeindisp = DB::table('employeservice')
            ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
            ->where('employeservice.idsalon', $id)
            ->where('employe.idgenre', 2)
            ->where('employe.iscanceled', 1)
            ->count();
    
        $nbclient = ClientDetails::where('idsalon', $id)
            ->whereMonth('inserted', now()->month)
            ->whereYear('inserted', now()->year)
            ->count();
    
        return view('Admin/detail', compact('titre', 'salon', 'services', 'empdisp', 'empindisp', 'hommedisp', 'femmedisp', 'hommeindisp', 'femmeindisp', 'nbclient'));
    }
    
    
    public function ListSalonService($id){
        $titre = "detailSalonService";
        $EmployeServices = EmployeService::where('idsalon',$id)->paginate(10);
        return view('Admin/liste',compact('titre','EmployeServices','id'));
    }

    public function ListSalonEmploye($id){
        $titre = "detailSalonEmploye";
        $employes = EmployeService::where('idsalon',$id)->paginate(10);
        $Homme = EmployeService::where('idsalon',$id)->paginate(10);

        return view('Admin/liste',compact('titre','employes','id'));
    }

    public function ListSalonClient($id){
        $titre = "detailSalonClient";
        $clients = ClientDetails::where('idsalon',$id)->paginate(10);
        return view('Admin/liste',compact('titre','clients','id'));
    }

    public function detailService($id){
        $titre = "detailService";
        $service = Service::find($id);
        $SalonEmp = DB::table('v_servsalon')
            ->where('idservice', '=', $id)
            ->get();
        $hommeClient = DB::table('clientdetails')
        ->join('client', 'clientdetails.idclient', '=', 'client.id')
        ->where('clientdetails.idservice', $id)
        ->where('client.idgenre', 1)
        ->whereMonth('clientdetails.inserted', now()->month)
        ->whereYear('clientdetails.inserted', now()->year)
        ->count();

        $femmeClient = DB::table('clientdetails')
        ->join('client', 'clientdetails.idclient', '=', 'client.id')
        ->where('clientdetails.idservice', $id)
        ->where('client.idgenre', 2)
        ->whereMonth('clientdetails.inserted', now()->month)
        ->whereYear('clientdetails.inserted', now()->year)
        ->count();
        return view('Admin/detail',compact('titre','service','SalonEmp','hommeClient','femmeClient'));
    }

    public function ListServiceSalon($id){
        $titre = "detailServiceSalon";
        $empserv = EmployeService::where('idservice', $id)
        ->join('employe', 'employeservice.idemploye', '=', 'employe.id')
        ->where('employe.iscanceled', '=', 0)
        ->paginate(10);
        return view('Admin/liste',compact('titre','empserv','id'));
    }

    public function detailEmploye($id){
        $titre = "detailEmploye";
        $employe = Employe::find($id);
        $serv = EmployeService::select('idservice')
        ->where('idemploye', $id)
        ->distinct()
        ->get();
        return view('Admin/detail',compact('titre','employe','serv'));
    }

    public function detailInfluenceur($id){
        $titre = "detailInfluenceur";
        $influenceur = Influenceur::find($id);
        $publications = DB::select('SELECT * FROM v_influenceur WHERE id = '.$id);
        return view('Admin/detail',compact('titre','influenceur','publications'));
    }

    public function FireEmploye($id,$motif){
        $employe = Employe::find($id);
        if($motif == "quit"){
        $employe->iscanceled = 1;
        } else {
        $employe->iscanceled = 0;
        }
        $employe->update();

        DB::select("insert into employequit (idemploye,motif) values (".$id.",'".$motif."')");

        return redirect()->back();
    }

    public function FireInfluenceur($id,$motif){
        $influenceur = Influenceur::find($id);
        if($motif == "quit"){
        $influenceur->iscanceled = 1;
        } else {
        $influenceur->iscanceled = 0;
        }
        $influenceur->update();

        DB::select("insert into influenceurquit (idinfluenceur,motif) values (".$id.",'".$motif."')");

        return redirect()->back();
    }

    public function ListServiceEmploye($id){
        $titre = "detailServiceEmploye";
        $employes = ClientDetails::where('idemploye',$id)->orderBy('inserted','desc')->paginate(10);
        return view('Admin/liste',compact('titre','employes','id'));
    }

    public function detailClient($id){
        $titre = "detailClient";
        $client = Client::find($id);
        return view('Admin/detail',compact('titre','client'));
    }

    public function ListActionClient($id){
        $titre = "detailActionClient";
        $clients = ClientDetails::where('idclient',$id)->orderBy('inserted','desc')->paginate(10);
        return view('Admin/liste',compact('titre','clients','id'));
    }

    public function ListActionInfluenceur($id){
        $titre = "detailActionInfluenceur";
        $influenceurs = InfluenceurPrestataire::where('idinfluenceur',$id)->orderBy('inserted','desc')->paginate(10);
        return view('Admin/liste',compact('titre','influenceurs','id'));
    }
}
