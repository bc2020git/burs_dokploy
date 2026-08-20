<?php

// app/Http/Controllers/StudentAuthController.php

namespace App\Http\Controllers;

use App\Models\Il;
use App\Models\Ilce;
use App\Models\ActiveTimeline;
use App\Models\Univercity;
use App\Models\TanimUnivercity;
use App\Models\TanimFaculty;
use App\Models\TanimDepartmant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class OrtakController extends Controller
{
    public function log($Model,$topTitle,$title,$text,$tc){
        $Model::create([
            'tc_no' => $tc,
            'topTitle' => $topTitle,
            'title' => $title,
            'text' => $text,
        ]);

    }
    public function getUnivercities(){
        return Univercity::orderBy('name','asc')->get();
    }
    public function getCities(){
        return Il::orderBy('name','asc')->get();
    }

    // Il ilce fonksiyonlari
    public function getDistrictByCityId($id){
        $sehir = Il::where('id',$id)->first();
        $il_no = $sehir->il_no;
        return Ilce::where('il_no',$il_no)->orderBy('isim','asc')->get();
    }
    public function getDistrictBySelectedCityId($cityData){
        // Eğer gelen veri sayısal ve 1-2 haneli ise ID olarak kabul et
        if (is_numeric($cityData) && strlen($cityData) <= 2) {
            // ID ile şehir bul
            $sehir = Il::where('id', $cityData)->first();
        } else {
            // İsim ile şehir bul
            $sehir = Il::where('name', $cityData)->first();
        }

        if (!$sehir) {
            return response()->json([], 404);
        }

        $il_no = $sehir->il_no;
        $ilce = Ilce::where('il_no', $il_no)->orderBy('isim', 'asc')->get();
        return response()->json($ilce);
    }

    // Universite fonksiyonlari
    public function getUniversitiesBySelectedCity($cityData){
        // Eğer gelen veri sayısal ve 1-2 haneli ise ID olarak kabul et
        if (is_numeric($cityData) && strlen($cityData) <= 2) {
            // ID ile şehir bul
            $il = Il::where('id', $cityData)->first();
        } else {
            // İsim ile şehir bul
            $il = Il::where('name', $cityData)->first();
        }

        if (!$il) {
            return response()->json([], 404);
        }

        $sehiradi = $il->name;
        $universities = TanimUnivercity::where('city', $sehiradi)->orderBy('name', 'asc')->get();
        return response()->json($universities);
    }
    public function getFacultiesBySelectedUniversity($university){
        if(is_numeric($university) && strlen($university) <= 2){
            $univercity = TanimUnivercity::where('id',$university)->first();
        }
        else{
            $univercity = TanimUnivercity::where('name',$university)->first();
        }
        $univercity_no = $univercity->id;
        $faculties = TanimFaculty::where('univercity_id',$univercity_no)->orderBy('name','asc')->get();
        return response()->json($faculties);
    }
    public function getDepartmentsBySelectedFaculty($faculty){
        $faculty = TanimFaculty::where('name',$faculty)->first();
        $faculty_no = $faculty->id;
        $departments = TanimDepartmant::where('faculty_id',$faculty_no)->orderBy('name','asc')->get();
        return response()->json($departments);
    }

    // Tarih fonksiyonlari
    public function tarihBol($tarih){
        if(!is_null($tarih)){
        return explode('-', $tarih);
        }
        else {
            return null;
        }
    }

    public function createPath($text='2021 2022 Dönemi'){
        $metin_aranan = array("ş", "Ş", "ı", "ü", "Ü", "ö", "Ö", "ç", "Ç", "ş", "Ş", "ı", "ğ", "Ğ", "İ", "ö", "Ö", "Ç", "ç", "ü", "Ü");
        $metin_yerine_gelecek = array("s", "S", "i", "u", "U", "o", "O", "c", "C", "s", "S", "i", "g", "G", "I", "o", "O", "C", "c", "u", "U");
        $baslik = str_replace($metin_aranan, $metin_yerine_gelecek, $text);
        $baslik = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i", "-", $baslik);
        $baslik = strtolower($baslik);
        $baslik = preg_replace('/&.+?;/', '', $baslik);
        $baslik = preg_replace('|-+|', '-', $baslik);
        $baslik = preg_replace('/#/', '', $baslik);
        $baslik = str_replace('.', '', $baslik);
        $baslik = trim($baslik, '-');
        return $baslik;
    }

    public function addNewTimeline($tc_no,$anabaslik,$baslik,$icerik){
        aday_timeline_log($tc_no, $anabaslik, $baslik, $icerik);
    }

    public function addActiveTimeline($tc_no,$anabaslik,$baslik,$icerik){
        $item = new ActiveTimeline();
        $item->tc_no = $tc_no;
        $item->topTitle = $anabaslik;
        $item->title = $baslik;
        $item->text = $icerik;
        $item->save();
    }




}
