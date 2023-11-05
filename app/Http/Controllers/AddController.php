<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\EmployeService;
use App\Models\Genre;
use App\Models\Question;
use App\Models\ReponseClient;
use App\Models\Salon;
use App\Models\Service;
use App\Models\Types;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddController extends Controller
{

    public function PageAddSalon()
    {
        $titre = "salon";
        return view('Admin/ajout', compact('titre'));
    }

    public function AddSalon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'adresse' => 'required',

        ], [
            'nom.required' => 'Le champ nom est requis.',
            'adresse.required' => 'Le champ adresse est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $salon = new Salon();
        $salon->nom = strtolower($request->nom);

        $salon->adresse = $request->adresse;
        
        /*if (Str::startsWith($request->adresse, 'Lieu: ')) {
            $salon->adresse = Str::replaceFirst('Lieu: ', '', $request->adresse);
        } else {
            $salon->adresse = $request->adresse;
        }
        $salon->latitude = $request->latitude;
        $salon->longitude = $request->longitude;*/
        $salon->save();

        return redirect('/AddSalon')->with('message', 'Salon ajouté avec succès.');
    }

    public function PageAddService()
    {
        $types = Types::all();
        $titre = "service";
        return view('Admin/ajout', compact('types', 'titre'));
    }

    public function AddService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'idtypes' => 'required',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'idtypes.required' => 'Le champ Type est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = new Service();
        $service->nom = $request->nom;
        $service->idtypes = $request->idtypes;
        $service->save();

        return redirect('/AddService')->with('message', 'Service ajouté avec succès.');
    }

    public function PageAddEmploye()
    {
        $genres = Genre::all();
        $titre = "employe";
        return view('Admin/ajout', compact('genres', 'titre'));
    }

    public function AddEmploye(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'required|integer|min:0',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prenom est requis.',
            'genre.required' => 'Le champ genre est requis.',
            'genre.integer' => 'Le champ genre est requis.',
            'idgenre.min' => 'Le champ genre doit être réel et positif.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employe = new Employe();
        $employe->nom = $request->nom;
        $employe->prenom = $request->prenom;
        $employe->idgenre = $request->genre;
        $employe->save();
        $id = $employe->id;

        return redirect('/AddEmployeService/' . $id . '/new');
    }

    public function PageAddEmployeService($id, $lien)
    {
        $titre = "employeservice";
        $salons = Salon::all();
        $services = DB::select(" SELECT s.id, s.nom FROM Service s WHERE s.id NOT IN (SELECT idservice FROM EmployeService WHERE idemploye = :idemploye); ", ['idemploye' => $id]);
        $empservice = EmployeService::where('idemploye', $id)->get();
        return view('Admin/ajout', compact('id', 'titre', 'salons', 'services', 'lien', 'empservice'));
    }

    public function AddEmployeService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'lien' => 'required',
            'idservice' => 'required',
            'idsalon' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'lien.required' => 'Le champ lien est requis.',
            'idservice.required' => 'Le champ Service est requis.',
            'idsalon.required' => 'Le champ salon est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = new EmployeService();
        $service->idemploye = $request->id;
        $service->idservice = $request->idservice;
        $service->idsalon = $request->idsalon;
        $service->save();

        if ($request->lien == 'new') {
            return redirect('/AddEmploye')->with('message', 'Employé ajouté avec succès.');
        } else {
            return redirect()->back();
        }
    }

    public function PageAddQuestion()
    {
        $titre = "question";
        return view('Admin/ajout', compact('titre'));
    }

    public function AddQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'reponse_1' => 'required',
            'reponse_2' => 'required',
        ], [
            'question.required' => 'Le champ question est requis.',
            'reponse_1.required' => 'Le champ Reponse 1 est requis.',
            'reponse_2.required' => 'Le champ Reponse 2 est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $question = new Question();
            $question->question = $request->question;
            $question->save();
            $id = $question->id;

            for ($i = 1; $i <= 2; $i++) {
                $reponseValue = $request->input("reponse_$i");
                if ($reponseValue !== null) {
                    DB::insert('INSERT INTO Reponse (idquest, valeur, reponse) VALUES (?, ?, ?)', [$id, $i, $reponseValue]);
                }
            }

            if ($request->reponse_3 != null) {
                DB::insert('INSERT INTO Reponse (idquest,valeur,reponse) VALUES (?,?,?)', [$id, 3, $request->reponse_3]);
            }

            DB::commit();

            return redirect('/ListQuestion');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back();
        }
    }

    public function importFile()
    {
        $titre = "import";
        return view('Admin/ajout', compact('titre'));
    }
}
