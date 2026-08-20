<?php

namespace App\Http\Controllers;
use App\Models\NewAnswer;
use App\Models\RenewForm;
use App\Models\Scholar;
use App\Models\ScholarForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\TanimUnivercity;
use App\Models\TanimFaculty;
use App\Models\TanimDepartmant;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ActiveAnswer;
use App\Models\RenewAnswer;
class IstatistikController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
    }
    public function importExcel()
    {
        $filePath = public_path('uniler.xlsx');  // public klasöründeki dosya yolu

        // Excel dosyasını yükle
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $oldName= '';
        // Satırları oku (1'den başla, çünkü genelde başlıklar 1. satırda olur)
        $rowCount = $sheet->getHighestDataRow(); // Toplam satır sayısını al

        for ($row = 1; $row <= $rowCount; $row++) {
            // A sütunu (Type)
            $type = $sheet->getCell('A' . $row)->getValue();
            // B sütunu (Name)
            $name = $sheet->getCell('B' . $row)->getValue();
            // C sütunu (City)
            $city = $sheet->getCell('C' . $row)->getValue();
            if($oldName != $name){
                $university = new TanimUnivercity();
                $university->type = $type;
                $university->name = $name;
                $university->city = $city;
                $university->save();
                $oldName = $name;
            }


        }

        return response()->json(['success' => 'Üniversite verileri başarıyla yüklendi.']);
    }
    public function importExcel2()
    {
        // Excel dosyasının yolunu belirleyin
        $filePath = public_path('fakulteler.xlsx');

        // Excel dosyasını okuyun
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $codeCounter = 1;

        foreach ($rows as $row) {
            // A sutunundaki veriyi alın ve üniversite adı ile eşleşen ID'yi bulun
            $universityName = $row[0];
            $university = TanimUnivercity::where('name', $universityName)->first();

            if ($university) {
                // Kod oluştur
                $code = sprintf('FAKU%04d', $codeCounter);

                // Fakulteler modeline kaydet
                TanimFaculty::create([
                    'univercity_id' => $university->id,
                    'code' => $code,
                    'name' => $row[1], // Excel'deki diğer sütun verilerini buraya ekleyin
                ]);

                $codeCounter++;
            }
        }

        return response()->json(['message' => 'Faculties imported successfully.']);
    }
    public function importDepartments()
    {
        // Excel dosyasının yolunu belirleyin
        $filePath = public_path('bolumler.xlsx');

        // Excel dosyasını okuyun
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $codeCounter = 1;

        foreach ($rows as $row) {
            // B sutunundaki üniversite adını alın
            $universityName = $row[1];
            $university = TanimUnivercity::where('name', $universityName)->first();

            if ($university) {
                // C sutunundaki fakülte adını alın
                $facultyName = $row[2];
                $faculty = TanimFaculty::where('name', $facultyName)
                    ->where('univercity_id', $university->id)
                    ->first();

                if ($faculty) {
                    // Kod oluştur
                    $code = sprintf('BOLU%05d', $codeCounter);

                    // Bölümler modeline kaydet
                    TanimDepartmant::create([
                        'faculty_id' => $faculty->id,
                        'code' => $code,
                        'osym_code' => $row[0], // A sutunundaki osym_code
                        'name' => $row[3], // D sutunundaki name
                        'grade_type' => $row[4], // E sutunundaki education_type
                    ]);

                    $codeCounter++;
                }
            }
        }

        return response()->json(['message' => 'Departments imported successfully.']);
    }
    function newStatics()
    {
        //Basvuru istatistikleri
        $statusCounts = [
            'bekleyen' => NewAnswer::whereIn('status', [0, 1])->count(),
            'iade'        => NewAnswer::where('status', 2)->count(),
            'red'  => NewAnswer::where('status', 4)->count(),
            'onay'    => NewAnswer::where('status', 3)->count(),
        ];

        return $statusCounts;
    }
    function renewStatics()
    {
        //Basvuru istatistikleri
        $statusCounts = [
            'bekleyen' => RenewAnswer::where('status', 1)->count(),
            'iade'        => RenewAnswer::where('status',2)->count(),
            'red'  => RenewAnswer::where('status', 4)->count(),
            'onay'    => RenewAnswer::where('status', 3)->count(),
        ];
        return $statusCounts;
    }
    function activeStatics()
    {
        //Basvuru istatistikleri
        $statusCounts = [
            'pasif'  => Scholar::where('status', 4)->count(),
            'aktif'    => ScholarForm::join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->join('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
                ->where('scholar_forms.status', '!=', '2')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                        ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'dernek'    => ScholarForm::join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->join('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
                ->where('active_answers.aday_turu', 'Dernek')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                        ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'vakif'    => ScholarForm::join('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->join('active_answers', 'scholar_forms.id', '=', 'active_answers.form_id')
                ->where('active_answers.aday_turu', 'Vakıf')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                        ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),

        ];

        return $statusCounts;
    }
    //  todo  newansweri activeanswer ile degistir.
    function cityStatics(){
        $cities = ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->select([
                'active_answers.p_school_city',
                'active_answers.m_school_city',
                'active_answers.h_school_city',
                'active_answers.university_city',
                'active_answers.educationType',
                'active_answers.id'
            ])
            ->whereNotNull('scholar_forms.id')
            ->where(function($query) {
                $query->where('scholars.status', '1')
                      ->orWhere('scholars.status', '2');
            })
            ->whereNotNull('scholars.id')
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                $item = $group->first();
                switch($item->educationType) {
                    case 'ilkokul':
                        return $item->p_school_city;
                    case 'ortaokul':
                        return $item->m_school_city;
                    case 'lise':
                        return $item->h_school_city;
                    default:
                        return $item->university_city;
                }
            })
            ->filter()
            ->values()
            ->countBy()
            ->sortDesc()
            ->take(6);

        return $cities;
    }
    public function ajaxcityStatics($city,$limit)
    {
        $selectedCity = $city;
        $limit = $limit;

        $query = ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
            ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
            ->select([
                'active_answers.p_school_city',
                'active_answers.m_school_city',
                'active_answers.h_school_city',
                'active_answers.university_city',
                'active_answers.educationType'
            ])
            ->whereNotNull('scholar_forms.id')
            ->where(function($query) {
                $query->where('scholars.status', '1')
                      ->orWhere('scholars.status', '2');
            })
            ->whereNotNull('scholars.id');

        if ($selectedCity && $selectedCity !== 'all') {
            $query->where(function($q) use ($selectedCity) {
                $q->where('p_school_city', $selectedCity)
                  ->orWhere('m_school_city', $selectedCity)
                  ->orWhere('h_school_city', $selectedCity)
                  ->orWhere('university_city', $selectedCity);
            });
        }

        $cities = $query->get()
            ->map(function ($item) {
                // educationType'a göre ilgili şehri seç
                switch($item->educationType) {
                    case 'ilkokul':
                        return $item->p_school_city;
                    case 'ortaokul':
                        return $item->m_school_city;
                    case 'lise':
                        return $item->h_school_city;
                    default:
                        return $item->university_city;
                }
            })
            ->filter()
            ->countBy()
            ->sortDesc()
            ->when($selectedCity === 'all', function ($collection) {
                return $collection;
            }, function ($collection) use ($limit) {
                return $collection->take($limit);
            });

        return response()->json($cities);
    }
    public function getAllCities()
    {
        $cities = ActiveAnswer::select('p_school_city', 'm_school_city', 'h_school_city', 'university_city')
            ->get()
            ->flatMap(function ($item) {
                return [$item->p_school_city, $item->m_school_city, $item->h_school_city, $item->university_city];
            })
            ->filter()
            ->unique()
            ->values()
            ->map(function($city) {
                return ['id' => $city, 'text' => $city];
            });

        $cities->prepend(['id' => 'all', 'text' => 'Tümünü Göster']);

        return $cities;
    }
    function educTypes(){
        $statusCounts = [
            'ilkokul' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'ilkokul')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'ortaokul' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'ortaokul')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'lise' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'lise')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'onlisans' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'onlisans')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'lisans' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'lisans')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'yukseklisans' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'yukseklisans')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
            'doktora' => ActiveAnswer::join('scholar_forms', 'active_answers.form_id', '=', 'scholar_forms.id')
                ->leftJoin('scholars', 'scholar_forms.scholar_id', '=', 'scholars.id')
                ->where('active_answers.educationType', 'doktora')
                ->where(function($query) {
                    $query->where('scholars.status', '1')
                          ->orWhere('scholars.status', '2');
                })
                ->whereNotNull('scholars.id')
                ->count(),
        ];
        $totalCount = array_sum($statusCounts);
        $percentageCounts = [];
        foreach ($statusCounts as $educationType => $count) {
            $percentageCounts[$educationType] = ($totalCount > 0) ? ($count / $totalCount) * 100 : 0;
        }
        $result  = [$statusCounts, $percentageCounts];
        return $result;
    }
}
