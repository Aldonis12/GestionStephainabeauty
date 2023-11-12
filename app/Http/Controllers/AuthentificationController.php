<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\clientfidele;
use Carbon\Carbon;

class AuthentificationController extends Controller
{

    public function PageLogin($pass){
        if ($pass=='salon'||$pass=='admin'||$pass=='influenceur') {
            session()->put('pass', $pass);
           return view('Authentification/login');
        }
    }

    public function Login(Request $request)
    {
        $mail = $request->input('mail');
        $mdp = $request->input('mdp');

        $idadmin = DB::select('SELECT id FROM Authentification WHERE email = ? and mdp = ?', [$mail, $mdp]);


        if ($idadmin) {
            session()->put('idadmin', $idadmin[0]->id);
            return redirect('StatistiqueDashboard');
        }else if($mail=='influenceur'){
            session()->put('influenceur', 'influenceur');
            return redirect('UserListInfluenceur');
        } else {
            $salon = DB::table('salon')->where('nom', $mail)->first();
    
            if ($salon) {
                session()->put('idsalon', $salon->id);
                return redirect('AddClient');
            } else {
                return redirect()->back()->with('error','error');
            }
        }
    }

    public function Logout()
    {
        session()->flush();
        return redirect('/loginPage/admin');
    }

    public function Forgetpassword() {
        return view('Authentification/mdpoublie');
    }

    public function checkEmail(Request $request) {
        $email = $request->get('mail');
        $user = DB::table('authentification')->where('email', $email)->first();
        return response()->json(['exists' => $user !== null]);
    }

    public function checkEmailForUpdate(Request $request) {
        $email = $request->get('mail');
        $user = DB::table('authentification')->where('email', $email)->first();
        if($user) {
            return 0;
        } else {
            return 1;
        }
    }

    public function Updatepassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'mail' => 'required',
            'mdp' => 'required|min:6',
            'confmdp' => 'required|same:mdp|min:6',
        ], [
            'mdp.required' => 'Le champ mot de passe est requis.',
            'mdp.min' => 'Le champ mot de passe doit avoir au moins 6 caractères.',
            'confmdp.min' => 'Le champ mot de passe doit avoir au moins 6 caractères.',
            'id.required' => 'ID requis.',
            'mail.required' => 'Le champ mail est requis.',
            'confmdp.required' => 'Le champ confirmation du mot de passe est requis.',
            'confmdp.same' => 'Le champ confirmation du mot de passe doit être identique au mot de passe.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($this->checkEmailForUpdate($request)==0) {
        DB::table('authentification')
        ->where('email', $request->mail)
        ->update(['mdp' => $request->mdp]);
        return redirect('/loginPage/admin')->with('success', 'Mot de passe mis à jour avec succès.');
        } else {
            return redirect()->back()->withErrors(['email' => 'Cet email n\'est pas associé à l\'actuel.']);
        }
    }

    public function PageNotFound($text = null, $url = null) {
        return view('contenu/404',compact('text','url'));
    }

    public function sendEmailClientFidele(Request $request)
    {
        $subject = $request->objet;
        $message = $request->message;
        $name = "Mick";
        $email = "micklewis.aldonis@gmail.com";

        $clients = clientfidele::where('annee', Carbon::now()->year)
        ->where('mois', Carbon::now()->month)
        ->where('visite', '>', 1)
        ->get();

        foreach ($clients as $client) {
            $receiver = $client->Client->email;
            $receiver_name = $client->Client->nom.' '.$client->Client->prenom;
            Mail::to($receiver)->send(new SendEmail($name, $email, $subject, $message,$receiver_name));
        }
        return redirect()->back()->with('message', 'Email envoyé avec succès.');
    }
}
