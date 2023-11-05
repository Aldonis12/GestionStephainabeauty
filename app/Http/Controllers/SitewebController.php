<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;


class SitewebController extends Controller
{
    public function index()
    {
        $titre = 'Accueil';
        $actualites = DB::table('actualite')
            ->where('types', 1)
            ->orderBy('inserted', 'desc')
            ->take(3)
            ->get();

        $imageRes = DB::table('actualite')
            ->where('types', 2)
            ->first();

        $contacts = DB::table('contact')
            ->join('salonsw', 'contact.idsalon', '=', 'salonsw.id')
            ->select('contact.*', 'salonsw.nom as nomSalon')
            ->get();
        $services = DB::table('servicesw')->orderBy('id', 'asc')->take(7)->get();
        $salons = DB::table('salonsw')->orderBy('id', 'asc')->get();
        return view('siteweb.index', compact('actualites', 'imageRes', 'contacts', 'services', 'salons', 'titre'));
    }

    public function Service()
    {
        $titre = 'Service';
        $imageplan = DB::table('actualite')
            ->where('types', 3)
            ->first();

        $services = DB::table('servicesw')->orderBy('id', 'asc')->get();

        $contacts = DB::table('contact')
            ->join('salonsw', 'contact.idsalon', '=', 'salonsw.id')
            ->select('contact.*', 'salonsw.nom as nomSalon')
            ->get();

        return view('siteweb.index', compact('services', 'contacts', 'titre', 'imageplan'));
    }

    public function PriceService($id)
    {
        $titre = 'PrixService';

        $contacts = DB::table('contact')
            ->join('salonsw', 'contact.idsalon', '=', 'salonsw.id')
            ->select('contact.*', 'salonsw.nom as nomSalon')
            ->get();

        $service = DB::table('servicesw')
            ->where('id', $id)
            ->first();

        $categories = DB::table('servicecategorie')
            ->where('idservice', $id)
            ->get();

        $subcategories = DB::table('servicesouscategorie')
            ->whereIn('idservicecategorie', $categories->pluck('id'))
            ->get();

        return view('siteweb.index', compact('service', 'categories', 'subcategories', 'titre', 'contacts'));
    }



    public function PageAddImageActualite()
    {
        $titre = 'imageactualite';
        $actualites = DB::table('actualite')
            ->where('types', 1)
            ->orderBy('inserted', 'desc')
            ->get();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'actualites'));
    }

    public function AddImageActualite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png|max:2048',
        ], [
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'Le fichier doit être de type JPEG ou PNG.',
            'file.max' => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');

        if ($file) {
            $image = Image::make($file);
            $base64 = $image->encode('data-url')->encoded;

            DB::table('actualite')->insert([
                'image64' => $base64,
                'types' => 1
            ]);

            return redirect()->back();
        } else {
            return redirect()->back()->with('message', 'Erreur d\'ajout.');
        }
    }

    public function DeleteImageActualite($id)
    {
        DB::table('actualite')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function PageUpdateImageActualite($id)
    {
        $titre = 'imageactualite';
        $actualite = DB::table('actualite')->where('id', $id)->first();
        return view('SiteWeb/AdminSite/modification', compact('titre', 'actualite', 'id'));
    }

    public function UpdateImageActualite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,png|max:2048',
            'id' => 'required',
        ], [
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'Le fichier doit être de type JPEG ou PNG.',
            'file.max' => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
            'id.required' => 'Le champ id est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');

        if ($file) {
            $image = Image::make($file);
            $base64 = $image->encode('data-url')->encoded;

            DB::table('actualite')
                ->where('id', $request->id)
                ->update(['image64' => $base64]);

            $types = DB::table('actualite')
                ->where('id', $request->id)
                ->value('types');


            if ($types == 1) {
                return redirect('/AddImageActualite');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('message', 'Erreur d\'ajout.');
        }
    }


    public function PageAddContact()
    {
        $titre = 'Contact';
        $salons = DB::table('salonsw')
            ->whereNotIn('id', function ($query) {
                $query->select('idsalon')->from('contact');
            })
            ->get();
        $contacts = DB::table('contact')
            ->join('salonsw', 'contact.idsalon', '=', 'salonsw.id')
            ->select('contact.*', 'salonsw.nom as nomSalon')
            ->get();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'contacts', 'salons'));
    }

    public function AddContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idsalon' => 'required',
            'contact' => 'required',
        ], [
            'idsalon.required' => 'Le champ id est requis.',
            'contact.required' => 'Le champ contact est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('contact')->insert([
            'idsalon' => $request->idsalon,
            'contact' => $request->contact
        ]);

        return redirect()->back();
    }

    public function UpdateContact(Request $request)
    {
        $contactsData = $request->input('contact');

        foreach ($contactsData as $id => $data) {
            $nom = $data['nom'];
            $contact = $data['contact'];

            $contactModel = DB::table('contact')->where('id', $id)->first();

            if ($contactModel) {
                DB::table('contact')
                    ->where('id', $id)
                    ->update(['contact' => $contact]);
            }
        }

        return redirect()->back();
    }

    public function PageUpdateImageRes()
    {
        $titre = 'imageres';
        $imageres = DB::table('actualite')->where('types', 2)->first();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'imageres'));
    }

    public function PageUpdateImagePlanService()
    {
        $titre = 'imageplanservice';
        $imageplanservice = DB::table('actualite')->where('types', 3)->first();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'imageplanservice'));
    }

    public function PageAddImageService()
    {
        $titre = 'service';
        $services = DB::table('servicesw')->orderBy('id', 'asc')->get();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'services'));
    }

    public function AddImageService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required',
            'file' => 'required|image|mimes:jpeg,png|max:2048',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'description.required' => 'Le champ description est requis.',
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'Le fichier doit être de type JPEG ou PNG.',
            'file.max' => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');

        if ($file) {
            $image = Image::make($file);
            $base64 = $image->encode('data-url')->encoded;

            DB::table('servicesw')->insert([
                'nom' => $request->nom,
                'description' => $request->description,
                'image64' => $base64
            ]);

            return redirect()->back();
        } else {
            return redirect()->back()->with('message', 'Erreur d\'ajout.');
        }
    }

    public function PageUpdateImageService($id)
    {
        $titre = 'service';
        $services = DB::table('servicesw')->where('id', $id)->first();
        return view('SiteWeb/AdminSite/modification', compact('titre', 'services', 'id'));
    }

    public function UpdateImageService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'description' => 'required',
            'file' => 'sometimes|image|mimes:jpeg,png|max:2048',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'description.required' => 'Le champ description est requis.',
            'file.image' => 'Le fichier doit être une image.',
            'file.mimes' => 'Le fichier doit être de type JPEG ou PNG.',
            'file.max' => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');

        $Data = [
            'nom' => $request->nom,
            'description' => $request->description
        ];

        if ($file) {
            $image = Image::make($file);
            $base64 = $image->encode('data-url')->encoded;
            $Data['image64'] = $base64;
        }

        DB::table('servicesw')
            ->where('id', $request->id)
            ->update($Data);

        return redirect('/AddImageService');
    }

    public function DeleteImageService($id)
    {
        DB::table('servicesw')->delete($id);
        return redirect()->back();
    }

    public function PageAddSalonSW()
    {
        $titre = 'Salon';
        $salons = DB::table('salonsw')->get();
        return view('SiteWeb/AdminSite/ajout', compact('titre', 'salons', 'salons'));
    }

    public function AddSalonSW(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'localisation' => 'required',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'localisation.required' => 'Le champ localisation est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('salonsw')->insert([
            'nom' => $request->nom,
            'localisation' => $request->localisation,
        ]);

        return redirect()->back();
    }

    public function UpdateSalonSW(Request $request)
    {
        $salonData = $request->input('salon');

        foreach ($salonData as $id => $data) {
            $nom = $data['nom'];
            $localisation = $data['localisation'];

            DB::table('salonsw')
                ->where('id', $id)
                ->update([
                    'nom' => $nom,
                    'localisation' => $localisation,
                ]);
        }

        return redirect()->back();
    }

    public function DeleteSalonSW($id)
    {
        try {
            DB::beginTransaction();

            DB::table('contact')->where('idsalon', $id)->delete();

            DB::table('salonsw')->where('id', $id)->delete();

            DB::commit();

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function PageAddPrixService($id)
    {
        $titre = 'PrixService';

        $service = DB::table('servicesw')
            ->where('id', $id)
            ->first();

        $categories = DB::table('servicecategorie')
            ->where('idservice', $id)
            ->get();

        $subcategories = DB::table('servicesouscategorie')
            ->whereIn('idservicecategorie', $categories->pluck('id'))
            ->get();

        return view('SiteWeb/AdminSite/ajout', compact('service', 'categories', 'subcategories', 'titre', 'id'));
    }

    public function AddPrixService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('servicecategorie')->insert([
            'idservice' => $request->id,
            'nom' => $request->nom,
            'prix' => $request->prix ?? 0,
            'description' => $request->description ?? null,
        ]);

        return redirect()->back();
    }

    public function PageUpdatePrixService($id)
    {
        $titre = 'prixservice';

        $category = DB::table('servicecategorie')
            ->where('id', $id)
            ->first();

        if ($category) {
            $subcategories = DB::table('servicesouscategorie')
                ->whereIn('idservicecategorie', [$category->id])
                ->get();
        } else {
            $subcategories = collect();
        }

        return view('SiteWeb/AdminSite/modification', compact('category', 'subcategories', 'titre', 'id'));
    }

    public function UpdatePrixService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'id' => 'required',
        ], [
            'id.required' => 'id requis.',
            'nom.required' => 'Le champ nom est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::table('servicecategorie')
                ->where('id', $request->id)
                ->update([
                    'nom' => $request->nom,
                    'prix' => $request->prix,
                    'description' => $request->description,
                ]);

            if ($request->has('nomSub') && $request->has('prixSub') && $request->has('idSub')) {
                $nomSub = $request->input('nomSub');
                $prixSub = $request->input('prixSub');
                $idsSubcategorie = $request->input('idSub');


                $count = count($nomSub);
                for ($i = 0; $i < $count; $i++) {
                    $idSubcategorie = $idsSubcategorie[$i];

                    $updateData = [
                        'nom' => $nomSub[$i],
                        'prix' => $prixSub[$i],
                    ];

                    DB::table('servicesouscategorie')
                        ->where('id', $idSubcategorie)
                        ->update($updateData);
                }
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function AddSousCategorieService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nom' => 'required',
            'prix' => 'required',
        ], [
            'id.required' => 'Le champ id est requis.',
            'nom.required' => 'Le champ nom est requis.',
            'prix.required' => 'Le champ prix est requis.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('servicesouscategorie')->insert([
            'idservicecategorie' => $request->id,
            'nom' => $request->nom,
            'prix' => $request->prix,
        ]);
        return redirect()->back();
    }

    public function DeleteSubcategorie($id)
    {
        DB::table('servicesouscategorie')->where('id', $id)->delete();
        return redirect()->back();
    }

    public function DeleteCategorie($id)
    {
        try {
            DB::beginTransaction();
            $idbe = DB::table('servicecategorie')->where('id', $id)->value('idservice');
            DB::table('servicesouscategorie')->where('idservicecategorie', $id)->delete();

            DB::table('servicecategorie')->where('id', $id)->delete();
            DB::commit();
            return redirect('/AddPrixService/'. $idbe);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
