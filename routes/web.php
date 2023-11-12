<?php

use App\Http\Controllers\AddController;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitewebController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/NotFound');
});

Route::get('/loginPage/{pass}', [AuthentificationController::class, 'PageLogin']);

Route::post('/login', [AuthentificationController::class, 'Login']);
Route::get('/logout', [AuthentificationController::class, 'Logout']);

Route::get('/forgetpassword', [AuthentificationController::class, 'Forgetpassword']);
Route::get('/check-email', [AuthentificationController::class, 'checkEmail']);
Route::post('/updatepassword', [AuthentificationController::class, 'Updatepassword']);


Route::middleware(['checkAdmin'])->group(function () {
    
    Route::get('/AddService', [AddController::class, 'PageAddService']);
    Route::post('/AddServiceValid', [AddController::class, 'AddService']);
    Route::get('/DeleteService/{id}', [DeleteController::class, 'DeleteService']);

    Route::get('/AddSalon', [AddController::class, 'PageAddSalon']);
    Route::post('/AddSalonValid', [AddController::class, 'AddSalon']);
    Route::get('/DeleteSalon/{id}', [DeleteController::class, 'DeleteSalon']);

    Route::get('/AddEmploye', [AddController::class, 'PageAddEmploye']);
    Route::post('/AddEmployeValid', [AddController::class, 'AddEmploye']);

    Route::get('/AddEmployeService/{id}/{lien}', [AddController::class, 'PageAddEmployeService']);
    Route::post('/AddEmployeServiceValid', [AddController::class, 'AddEmployeService']);
    Route::get('/DeleteEmployeService/{id}', [DeleteController::class, 'DeleteEmployeService']);
    
    Route::get('/AddQuestion', [AddController::class, 'PageAddQuestion']);
    Route::post('/AddQuestionValid', [AddController::class, 'AddQuestion']);

    Route::get('/ListSalon', [ListController::class, 'ListSalon']);
    Route::get('/ListService', [ListController::class, 'ListService']);
    Route::get('/ListEmploye', [ListController::class, 'ListEmploye']);
    Route::get('/ListClient', [ListController::class, 'ListClient']);
    Route::get('/ListClientCode', [ListController::class, 'ListClientCode']);
    Route::get('/ListClientByCode/{id}', [ListController::class, 'ListClientByCode']);
    Route::get('/ListClientFidele', [ListController::class, 'ListClientFidele']);
    Route::get('/listClientBySalon', [ListController::class, 'listClientBySalon']);
    Route::get('/ListQuestion', [ListController::class, 'ListQuestion']);
    Route::get('/ListInfluenceur', [ListController::class, 'ListInfluenceur']);
    Route::get('/ListInfluenceurReseaux', [ListController::class, 'ListInfluenceurReseaux']);

    Route::get('/RechercheEmploye', [SearchController::class, 'RechercheEmploye']);
    Route::get('/RechercheClient', [SearchController::class, 'RechercheClient']);
    Route::get('/RechercheInfluenceur', [SearchController::class, 'RechercheInfluenceur']);

    Route::get('/ExportEmploye', [ListController::class, 'exportCSV']);
    Route::get('/ExportClient', [ListController::class, 'exportCSVclient']);
    Route::get('/ExportInfluenceur', [ListController::class, 'exportCSVInfluenceur']);

    Route::get('/DetailSalon/{id}', [DetailController::class, 'detailSalon']);
    Route::get('/DetailSalonService/{id}', [DetailController::class, 'ListSalonService']);
    Route::get('/DetailSalonEmploye/{id}', [DetailController::class, 'ListSalonEmploye']);
    Route::get('/DetailSalonClient/{id}', [DetailController::class, 'ListSalonClient']);

    Route::get('/UpdateSalon/{id}', [UpdateController::class, 'PageUpdateSalon']);
    Route::post('/UpdateSalonValid', [UpdateController::class, 'UpdateSalon']);

    Route::get('/DetailService/{id}', [DetailController::class, 'detailService']);

    Route::get('/UpdateService/{id}', [UpdateController::class, 'PageUpdateService']);
    Route::post('/UpdateServiceValid', [UpdateController::class, 'UpdateService']);

    Route::get('/DetailServiceSalon/{id}', [DetailController::class, 'ListServiceSalon']);

    Route::get('/DetailEmploye/{id}', [DetailController::class, 'detailEmploye']);

    Route::get('/UpdateEmploye/{id}', [UpdateController::class, 'PageUpdateEmploye']);
    Route::post('/UpdateEmployeValid', [UpdateController::class, 'UpdateEmploye']);

    Route::get('/DetailInfluenceur/{id}', [DetailController::class, 'detailInfluenceur']);
    Route::get('/FireInfluenceur/{id}/{motif}', [DetailController::class, 'FireInfluenceur']);

    Route::get('/UpdateInfluenceur/{id}', [UpdateController::class, 'PageUpdateInfluenceur']);
    Route::post('/UpdateInfluenceurValid', [UpdateController::class, 'UpdateInfluenceur']);

    Route::get('/DetailServiceEmploye/{id}', [DetailController::class, 'ListServiceEmploye']);
    Route::get('/FireEmploye/{id}/{motif}', [DetailController::class, 'FireEmploye']);

    Route::get('/DetailClient/{id}', [DetailController::class, 'detailClient']);

    Route::get('/DetailActionClient/{id}', [DetailController::class, 'ListActionClient']);
    Route::get('/DetailActionInfluenceur/{id}', [DetailController::class, 'ListActionInfluenceur']);

    Route::get('/UpdateClient/{id}', [UpdateController::class, 'PageUpdateClient']);
    Route::post('/UpdateClientValid', [UpdateController::class, 'UpdateClient']);

    Route::get('/UpdateQuestion/{id}', [UpdateController::class, 'PageUpdateQuestion']);
    Route::post('/UpdateQuestionValid', [UpdateController::class, 'UpdateQuestion']);

    Route::get('/DeleteClient/{id}', [DeleteController::class, 'DeleteClient']);
    Route::get('/DeleteQuestion/{id}', [DeleteController::class, 'DeleteQuestion']);

    Route::get('/StatistiqueSalonClient', [StatistiqueController::class, 'StatistiqueSalonClient']);
    Route::get('/StatistiqueCodeClient', [StatistiqueController::class, 'StatistiqueCodeClient']);
    //Route::get('/StatistiqueSalonService', [StatistiqueController::class, 'StatistiqueSalonService']);
    Route::get('/StatistiqueDashboard', [StatistiqueController::class, 'StatistiqueDashboard']);

    Route::get('/export-chart',  [StatistiqueController::class, 'exportChart']);

    Route::post('/sendEmailClientFidele', [AuthentificationController::class, 'sendEmailClientFidele']);
});


//User Client
Route::middleware(['checkSalon'])->group(function () {
    Route::get('/AddClient', [UserController::class, 'PageAddClient']);
    Route::post('/AddClientValid', [UserController::class, 'AddClient']);

    Route::get('/AddActionClient', [UserController::class, 'PageActionClient']);
    Route::post('/AddActionClientValid', [UserController::class, 'AddActionClient']);

    Route::get('/AddActionInfluenceur', [UserController::class, 'PageActionInfluenceur']);
    Route::post('/AddActionInfluenceurValid', [UserController::class, 'AddActionInfluenceur']);

    Route::get('/ScannerCode', [UserController::class, 'ScannerCodeClient']);

    Route::get('/CheckClientCode', [UserController::class, 'CheckClientCode']);

    Route::get('/UpdateClientCode', [UserController::class, 'UpdateClientCode']);
    Route::post('/UpdateClientCodeValid', [UserController::class, 'UpdateClientCodeValid']);

    Route::get('/autocomplete', [UserController::class, 'autocomplete']);
    Route::get('/autocompleteService', [UserController::class, 'autocompleteService']);
    Route::get('/autocompleteEmploye', [UserController::class, 'autocompleteEmploye']);
    Route::get('/autocompleteInfluenceur', [UserController::class, 'autocompleteInfluenceur']);

    Route::get('/clearSession', [UserController::class, 'clearSession']);


});

Route::get('/GenerateCodeQR' , function () {
    return view('User/generate');
});

//User INFLUENCEUR
Route::middleware(['checkInfluenceur'])->group(function () {
    Route::get('/UserListInfluenceur', [UserController::class, 'ListInfluenceur']);
    Route::get('/InfluenceurDetails/{id}', [UserController::class, 'DetailsInfluenceur']);

    Route::get('/AddInfluenceur', [UserController::class, 'PageAddInfluenceur']);
    Route::post('/AddInfluenceurValid', [UserController::class, 'AddInfluenceur']);

    Route::get('/UpdateDetailinfluenceur/{id}', [UserController::class, 'UpdateDetailinfluenceur']);
    Route::post('/UpdateDetailinfluenceurValid', [UserController::class, 'UpdateDetailinfluenceurValid']);

    Route::get('/DeleteDetailinfluenceur/{id}', [UserController::class, 'DeleteDetailinfluenceur']);


    Route::get('/AddPublication/{id}', [UserController::class, 'PageAddPublication']);
    Route::post('/AddPublicationValid', [UserController::class, 'AddPublication']);

    Route::get('/UpdateReseauxInfluenceur/{id}', [UserController::class, 'UpdateReseauxInfluenceur']);
    Route::post('/UpdateReseauxInfluenceurValid', [UserController::class, 'UpdateReseauxInfluenceurValid']);
});


//NOT FOUND
Route::get('/NotFound/{text?}/{url?}', [AuthentificationController::class, 'PageNotFound']);



//SITE WEB
Route::get('/test-database', function () {
    try {
        DB::connection('mysql')->select('SELECT 1');
        return "La base de données fonctionne correctement!";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});


Route::get('/Home', [SitewebController::class, 'index']);
Route::get('/Service', [SitewebController::class, 'Service']);
Route::get('/PriceService/{id}', [SitewebController::class, 'PriceService']);



//Admin SITE WEB
Route::get('/AddImageActualite', [SitewebController::class, 'PageAddImageActualite']);
Route::post('/AddImageActualiteValid', [SitewebController::class, 'AddImageActualite']);

Route::get('/UpdateImageActualite/{id}', [SitewebController::class, 'PageUpdateImageActualite']);
Route::post('/UpdateImageActualiteValid', [SitewebController::class, 'UpdateImageActualite']);

Route::get('/DeleteImageActualite/{id}', [SitewebController::class, 'DeleteImageActualite']);

Route::get('/AddContact', [SitewebController::class, 'PageAddContact']);
Route::post('/AddContactValid', [SitewebController::class, 'AddContact']);

Route::post('/UpdateContactValid', [SitewebController::class, 'UpdateContact']);

Route::get('/UpdateImageRes', [SitewebController::class, 'PageUpdateImageRes']);

Route::get('/AddImageService', [SitewebController::class, 'PageAddImageService']);
Route::post('/AddImageServiceValid', [SitewebController::class, 'AddImageService']);

Route::get('/UpdateImageService/{id}', [SitewebController::class, 'PageUpdateImageService']);
Route::post('/UpdateImageServiceValid', [SitewebController::class, 'UpdateImageService']);

Route::get('/DeleteImageService/{id}', [SitewebController::class, 'DeleteImageService']);


Route::get('/AddSalonSW', [SitewebController::class, 'PageAddSalonSW']);
Route::post('/AddSalonSWValid', [SitewebController::class, 'AddSalonSW']);

Route::post('/UpdateSalonSWValid', [SitewebController::class, 'UpdateSalonSW']);
Route::get('/DeleteSalonSW/{id}', [SitewebController::class, 'DeleteSalonSW']);

Route::get('/UpdateImagePlanService', [SitewebController::class, 'PageUpdateImagePlanService']);

Route::get('/AddPrixService/{id}', [SitewebController::class, 'PageAddPrixService']);
Route::post('/AddPrixServiceValid', [SitewebController::class, 'AddPrixService']);

Route::get('/UpdatePrixService/{id}', [SitewebController::class, 'PageUpdatePrixService']);
Route::post('/UpdatePrixServiceValid', [SitewebController::class, 'UpdatePrixService']);

Route::post('/AddSousCategorieServiceValid', [SitewebController::class, 'AddSousCategorieService']);

Route::get('/DeleteSubcategorie/{id}', [SitewebController::class, 'DeleteSubcategorie']);
Route::get('/DeleteCategorie/{id}', [SitewebController::class, 'DeleteCategorie']);


//Admin SITE WEB //