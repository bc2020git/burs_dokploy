<?php

namespace App\Http\Controllers;

use App\Models\ActiveAnswer;
use App\Models\ActiveBankInfos;
use App\Models\ActiveDocuments;
use App\Models\ActiveEducationalInfo;
use App\Models\ActiveFamilyInfos;
use App\Models\ActiveHousingInformation;
use App\Models\ActiveIncomeInfos;
use App\Models\ActiveJobInfos;
use App\Models\ActiveObstacledInfos;
use App\Models\ActiveOtherScholarshipDetails;
use App\Models\ActiveOtherScholarshipInfos;
use App\Models\ActiveParentInfo;
use App\Models\ActivePersonalnfo;
use App\Models\ActiveSiblingDetails;
use App\Models\ActiveSiblingInfos;
use App\Models\ActiveSocialInfos;
use App\Models\AdayPoint;
use App\Models\Il;
use App\Models\NewAnswer;
use App\Models\NewDocuments;
use App\Models\NewInterview;
use App\Models\NewOtherScholarshipDetails;
use App\Models\NewSiblingDetails;
use App\Models\NewTimeline;
use App\Models\Period;
use App\Models\RenewAnswer;
use App\Models\RenewBankInfos;
use App\Models\RenewDocuments;
use App\Models\RenewEducationalInfo;
use App\Models\RenewFamilyInfos;
use App\Models\RenewForm;
use App\Models\RenewHousingInformation;
use App\Models\RenewIncomeInfos;
use App\Models\RenewJobInfos;
use App\Models\RenewObstacledInfos;
use App\Models\RenewOtherScholarshipDetails;
use App\Models\RenewOtherScholarshipInfos;
use App\Models\RenewParentInfo;
use App\Models\RenewPersonalnfo;
use App\Models\RenewSiblingDetails;
use App\Models\RenewSiblingInfos;
use App\Models\RenewSocialInfos;
use App\Models\Scholar;
use App\Models\ScholarForm;
use App\Models\Soru;
use App\Models\TanimUnivercity;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewRelationController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->mailController = new MailController;
        $this->ortak = new OrtakController;
        $this->messageController = new MessageController;
        $this->formController = new FormController;
        $this->studentController = new StudentController;
        $this->soruController = new SoruController;
    }

    public function deneme() {}

    public function basvuruAdayiReddet(Request $request)
    {
        $tc_no = $request->input('tc_no'); // Kullanıcı ID'leri
        $user = NewAnswer::where('tc_no', $tc_no)->first();
        if ($user->status != '4') {
            $redSebebi = $request->input('redSebebi'); // Kullanıcı ID'leri
            $redAciklamasi = $request->input('redAciklamasi'); // Kullanıcı ID'leri
            $result = NewAnswer::where('tc_no', $tc_no)->update([
                'status' => 4,
                'redSebebi' => $redSebebi,
                'redDigerAciklama' => $redAciklamasi,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            if ($result) {

                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $user->name,
                        'sebep' => $redSebebi,
                        'aciklama' => $redAciklamasi,
                        'surname' => $user->surname,
                    ];

                    $slug = null;
                    if (!empty($redSebebi)) {
                        $proposedSlug = 'aday-burs-ret-' . Str::slug($redSebebi);
                        if (MessageTemplate::where('slug', $proposedSlug)->exists()) {
                            $slug = $proposedSlug;
                        }
                    }

                    if (!$slug) {
                        if (MessageTemplate::where('slug', 'aday-burs-ret-diger')->exists()) {
                            $slug = 'aday-burs-ret-diger';
                        } else {
                            $slug = 'aday-reddedildi';
                        }
                    }

                    $this->mailController->sendTemplateEmail(
                        $slug,
                        $user->email,
                        'Burs Başvurunuz Reddedilmistir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday reddedilme mail gönderim hatası: '.$e->getMessage());
                }
                $this->ortak->addNewTimeline($tc_no, 'Bursiyer Başvurusu Reddedildi', 'Aday basvurusu reddedildi', $request->input('redAciklamasi').' aciklamasi ile basvuru reddedildi');
                session()->flash('success', 'Bursiyer Reddedildi!');

                return response()->json(['result' => $result]);

            }
        } else {
            session()->flash('error', 'Bursiyer Zaten Reddedildi!');

        }

    }

    public function kyAdayiReddet(Request $request)
    {
        $form_id = $request->input('form_id'); // Kullanıcı ID'leri
        $user = RenewForm::with('scholar')->where('id', $form_id)->first();
        $redSebebi = $request->input('redSebebi'); // Kullanıcı ID'leri
        $redAciklamasi = $request->input('redAciklamasi') ?? ' - '; // Kullanıcı ID'leri
        Scholar::where('id', $user->scholar->id)->update([
            'status' => 0,

        ]);
        $result = RenewForm::where('id', $form_id)->update([
            'status' => 2,
            'redSebebi' => $redSebebi,
            'redDigerAciklama' => $redAciklamasi,
            'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
        ]);
        $result = RenewAnswer::where('form_id', $form_id)->update([
            'status' => 4,
        ]);
        if ($result) {
            $scholar = Scholar::where('id', $user->form_id)->first();
            $scholar->status = 4;
            $scholar->save();
            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $user->scholar->name,
                    'sebep' => $redSebebi,
                    'aciklama' => $redAciklamasi,
                    'surname' => $user->scholar->surname,
                ];

                $this->mailController->sendTemplateEmail(
                    'kayit-yenileme-reddedildi',
                    $user->scholar->email,
                    'Kayıt Yenileme Başvurunuz Reddedilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme reddedilme mail gönderim hatası: '.$e->getMessage());
            }
            session()->flash('success', 'İşlem Başarılı!');
            $icerik = 'Kayıt Yenileme Başvurunuz Reddedildi. <div> </div> <h4> Gerekce : </h4>'.$redSebebi.'<div></div> <h4> Aciklama : </h4>'.$redAciklamasi;
            $this->ortak->log(NewTimeline::class, 'Yonetici KY Red islemi gerceklestirdi', 'KY basvurusu reddedildi', $icerik, $user->scholar->tc_no);

            return response()->json([
                'result' => $result,
            ]);
        }
    }

    public function basvuruAdayiIadeEt(Request $request)
    {
        $tc_no = $request->input('tc_no');
        $user = NewAnswer::where('tc_no', $tc_no)->first();
        if ($user->status != '2') {
            $iadeSebebi = $request->input('iadeSebebi');
            $iadeDigerAciklama = $request->input('iadeAciklama');
            $result = NewAnswer::where('tc_no', $tc_no)->update([
                'status' => 2,
                'iadeSebebi' => $iadeSebebi,
                'iadeAciklamasi' => $iadeDigerAciklama,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            if ($result) {
                session()->flash('success', 'İşlem Başarılı!');
                $this->ortak->addNewTimeline($tc_no, 'Bursiyer Başvurusu İade Edildi', 'Aday basvurusu iade edildi', $request->input('iadeAciklama').' aciklamasi ile başvuru iade edildi');
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'sebep' => $iadeSebebi,
                        'aciklama' => $iadeDigerAciklama,
                    ];

                    $slug = null;
                    if (!empty($iadeSebebi)) {
                        $proposedSlug = 'aday-burs-iade-' . Str::slug($iadeSebebi);
                        if (MessageTemplate::where('slug', $proposedSlug)->exists()) {
                            $slug = $proposedSlug;
                        }
                    }

                    if (!$slug) {
                        if (MessageTemplate::where('slug', 'aday-burs-iade-diger')->exists()) {
                            $slug = 'aday-burs-iade-diger';
                        } else {
                            $slug = 'aday-iade-mesaji';
                        }
                    }

                    $this->mailController->sendTemplateEmail(
                        $slug,
                        $user->email,
                        'Burs Başvurunuz Iade Edilmistir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday iade mail gönderim hatası: '.$e->getMessage());
                }
            }
        } else {
            session()->flash('error', 'Bursiyer Zaten Iade Durumunda!');

        }

    }

    public function kyAdayiIadeEt(Request $request)
    {
        $form_id = $request->input('form_id'); // Kullanıcı ID'leri
        $user = RenewForm::with('scholar')->where('id', $form_id)->first();
        $iadeSebebi = $request->input('iadeSebebi');
        $iadeDigerAciklama = $request->input('iadeAciklama');
        Scholar::where('id', $user->scholar->id)->update([
            'status' => 2,
        ]);
        $result = RenewForm::where('id', $form_id)->update([
            'status' => 3,
            'iadeSebebi' => $iadeSebebi,
            'iadeDigerAciklama' => $iadeDigerAciklama,
            'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
        ]);
        $result = RenewAnswer::where('form_id', $form_id)->update([
            'status' => 2,
        ]);
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');

            $konu = 'Kayit Yenileme Süreciniz İade Edilmiştir.';
            try {
                $parameters = [
                    'name' => $user->scholar->name,
                    'surname' => $user->scholar->surname,
                    'sebep' => $iadeSebebi,
                    'aciklama' => $iadeDigerAciklama,
                ];

                $this->mailController->sendTemplateEmail(
                    'kayit-yenileme-iade-edildi',
                    $user->scholar->email,
                    'Kayıt Yenileme Süreciniz İade Edilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('KY iade mail gönderim hatası: '.$e->getMessage());
            }
        }

    }

    public function topluIslemYonet(Request $request)
    {
        $userIds = $request->input('userIds'); // Kullanıcı ID'leri
        $islemId = $request->input('islemId'); // İşlem ID'si
        $mulakatAta = $request->input('mulakatAta'); // Mülakat ID'si

        switch ($islemId) {
            case 0:
                $redSebebi = $request->input('redSebebi');
                $aciklama = $request->input('digerAciklama');
                foreach ($userIds as $id) {
                    $result = $this->ignoreRelation($id, $aciklama, $redSebebi);
                }
                break;
            case 1:
                foreach ($userIds as $id) {
                    $result = $this->addConfirmedScholar($id);
                }
                break;
            case 2:
                $iadeSebebi = $request->input('iadeSebebi');
                $aciklama = $request->input('iadeDigerAciklama');
                foreach ($userIds as $id) {
                    $result = $this->returnRelation($id, $aciklama, $iadeSebebi);
                }
                break;
            case 3:

                foreach ($userIds as $id) {
                    $result = $this->deletenewrelations($id);
                }
                break;
            case 4:
                $userIds = json_decode($userIds, true);

                if (empty($userIds)) {
                    // Eğer userIds boşsa tüm kayıtları al
                    $userIds = NewAnswer::pluck('id')->toArray();
                }

                return $this->AdayTopluIndir($userIds);
                break;
            case 5:
                $result = $this->topluMulakatAta($userIds, $mulakatAta);
                break;
            case 6:
                $results = [];
                $successCount = 0;
                $errorCount = 0;

                foreach ($userIds as $id) {
                    try {
                        $puanRequest = new Request;
                        $puanRequest->merge(['aday_id' => $id]);

                        $puanResult = $this->soruController->adayPuanHesapla($puanRequest);
                        $responseData = $puanResult->getData(true);

                        if ($responseData['success']) {
                            $successCount++;
                            $results[] = [
                                'aday_id' => $id,
                                'success' => true,
                                'totalPoints' => $responseData['totalPoints'],
                                'message' => $responseData['message'],
                            ];
                        } else {
                            $errorCount++;
                            $results[] = [
                                'aday_id' => $id,
                                'success' => false,
                                'message' => $responseData['message'],
                            ];
                        }
                    } catch (\Exception $e) {
                        $errorCount++;
                        $results[] = [
                            'aday_id' => $id,
                            'success' => false,
                            'message' => 'Puan hesaplama hatası: '.$e->getMessage(),
                        ];
                        \Log::error("Toplu puan hesaplama hatası - Aday ID: {$id}, Hata: ".$e->getMessage());
                    }
                }

                $result = [
                    'total_processed' => count($userIds),
                    'success_count' => $successCount,
                    'error_count' => $errorCount,
                    'details' => $results,
                ];
                break;

        }

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result,
        ]);
    }

    public function topluMulakatAta($ids, $grupid)
    {
        $adaylar = NewAnswer::whereIn('id', $ids)->pluck('tc_no')->toArray();

        foreach ($adaylar as $aday) {
            $sonMulakat = NewInterview::where('tc_no', $aday)->orderBy('id', 'desc')->first();
            if ($sonMulakat) {
                $sonMulakat->interview_person = $grupid;
                $sonMulakat->save();
            }
        }
    }

    public function AdayTopluIndir($userIds)
    {
        try {
            // userIds'in dizi olduğundan emin ol
            if (! is_array($userIds)) {
                $userIds = explode(',', $userIds);
            }

            // Excel dosyası oluştur
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            // Başlıkları tanımla
            $headers = [
                'Başvuru No',
                'Ad',
                'Soyad',
                'TC No',
                'Cep Telefonu',
                'Başvuru Durumu',
                'Ret Sebebi',
                'E-Posta',
                'Doğum Tarihi',
                'Nüfus Kayıtlı Olduğu Şehir',
                'Nüfus Kayıtlı Olduğu İlçe',
                'Doğduğu Şehir',
                'Doğduğu İlçe',
                'Cinsiyet',
                'Medeni Durum',
                'Uyruk',
                'Okul Tipi',
                'İlkokul Adı',
                'İlkokul Bulunduğu Şehir',
                'Sınıf',
                'Öğrenci No',
                'Not Ortalaması',
                'Nakil Yaptı Mı',
                'Ortaokul Adı',
                'Ortaokul Bulunduğu Şehir',
                'Ortaokul Bulunduğu İlçe',
                'Lise Adı',
                'Lise Bulunduğu Şehir',
                'Lise Bulunduğu İlçe',
                'Bitirdiğiniz Lise',
                'Üniversiteye Giriş Puanı',
                'Üniversite Şehri',
                'Öğrenime Devam Ettiğiniz Üniversite',
                'Öğrenime Devam Ettiğiniz Fakülte',
                'Öğrenime Devam Ettiğiniz Bölüm',
                'Üniversitenin Statüsü',
                'Kaçıncı Sınıfta Olacaksınız?',
                'Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)',
                'AGNO Sisteminiz',
                'AGNO',
                'Yatay/Dikey Geçiş Yaptı mı?',
                'Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız',
                'Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız',
                'Bitirdiğiniz Üniversite',
                'Mezun Olduğunuz Bölüm',
                'Yüksek Lisans Yaptığınız Üniversite',
                'Yüksek Lisans Yaptığınız Dal',
                'Mezuniyet AGNO',
                'Barınma Türü',
                'Ödenen Ücret',
                ' Birlikte Yaşanılan Kişi Sayısı ',
                ' Kaldığı İl ',
                ' Kaldığı İlçe ',
                ' Tam Adres ',
                '  Annenin Yaşadığı İl  ',
                ' Annenin Yaşadığı İlçe ',
                '  Babanın Yaşadığı İl  ',
                ' Babanın Yaşadığı İlçe ',
                ' Açık Adres ',
                ' Aile Cep Telefonu ',
                ' Aile Ev Telefonu ',
                ' Aile E-posta Adresi ',
                'Acil Durum Kişisi Ad',
                'Acil Durum Kişisi Soyad',
                'Acil Durum Kişisi Telefonu',
                'Acil Durum Kişisi Yakınlık Derecesi',
                'Acil Durum Kişisi Eposta Adresi',
                ' Anne Baba Birlikte Mi? ',
                ' Anne Baba Sağ Mı? ',
                ' Anne Ad ',
                ' Anne Soyad ',
                ' Baba Ad ',
                ' Baba Soyad ',
                ' Anne Meslek ',
                ' Baba Meslek ',
                ' Anne Tahsil Durumu ',
                ' Baba Tahsil Durumu ',
                ' Anne Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Baba Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Kardeş Sayısı ',
                ' Kendisi Dahil Okuyan Kardeş Sayısı ',
                ' Ailenin Geçmişini Kim/Kimler Sağlıyor? ',
                ' Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor? ',
                ' Annenin Aylık Net Geliri (TL) ',
                ' Babanın Aylık Net Geliri (TL) ',
                ' Diğer Kişilerin Aylık Net Geliri (TL) ',
                ' Ailenin Başka Geliri Var Mı? ',
                ' Ailenin Yaşamakta Olduğu Ev Türü ',
                ' Kira ise Aylık Net Kirası (TL) ',
                ' Diğer Gelir Bilgisi',
                ' Devlet Bursu Almakta mı ya da Başvurdu mu? ',
                ' Özel Burs Almakta ya da Başvurdu mu? ',
                ' Herhangi Bir Engeliniz Var mı? ',
                ' Engel Durumunu Açıklayınız (Varsa) ',
                ' Bizden Nasıl Haberdar Oldunuz? ',
                ' Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz? ',
                ' Katkıda Bulunduğunuz Sosyal Projeler ',
                ' Hobileriniz ',
                ' İlgilendiğiniz Spor Dalı (Varsa) ',
                ' Son Okuduğunuz Kitaplar ',
                ' Bize Mesajınız ',
                ' Banka ',
                'IBAN',
                'Hesap Numarası',
                ' Düzenli olarak bir kurumda kazanç sağlıyor mu? ',
                ' Kurum Adı ',
                'Görev',
                ' Sosyal Güvenlik Kurumu ',
                ' Aylık Net Ücret (TL) ',
                'Öğrenci Belgesi',
                'Adli Sicil Kaydı',
                'Nüfus Kayıt Onayı',
                'Annenin Gelir Belgesi',
                'Babanın Gelir Belgesi',
                'Taahhütname',
                'Kimlik',
                'Banka Hesabı',
                'Transkript',
                'İkametgah',
                'Karne',
                'Diger',
                'Başvuru Puanı',
                'Mülakat Durumu',

                // Diğer başlıkları buraya ekleyebilirsiniz
            ];

            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column.'1', $header);
            }

            // Verileri çek ve yaz
            $row = 2;
            foreach ($userIds as $id) {
                $data = NewAnswer::with('documents')->find($id);
                if ($data) {
                    switch ($data->status) {
                        case 0:
                            $status = 'Devam Ediyor';
                            break;
                        case 1:
                            $status = 'Onay Bekliyor';
                            break;
                        case 2:
                            $status = 'İade Edildi';
                            break;
                        case 3:
                            $status = 'Onaylandı';
                            break;
                        case 4:
                            $status = 'Reddedildi';
                            break;
                        case 5:
                            $status = 'İadeden Döndü';
                            break;
                    }
                    $sheet->setCellValue('A'.$row, $data->id);
                    $sheet->setCellValue('B'.$row, $data->name);
                    $sheet->setCellValue('C'.$row, $data->surname);
                    $sheet->setCellValue('D'.$row, $data->tc_no);
                    $sheet->setCellValue('E'.$row, $data->tel_no);
                    $sheet->setCellValue('F'.$row, $status);
                    $sheet->setCellValue('G'.$row, $data->redSebebi);
                    $sheet->setCellValue('H'.$row, $data->email);
                    $sheet->setCellValue('I'.$row, $data->b_dob);
                    $sheet->setCellValue('J'.$row, $data->registered_city);
                    $sheet->setCellValue('K'.$row, $data->registered_district);
                    $sheet->setCellValue('L'.$row, $data->birth_city);
                    $sheet->setCellValue('M'.$row, $data->birth_district);
                    $sheet->setCellValue('N'.$row, $data->gender);
                    $sheet->setCellValue('O'.$row, $data->maritality);
                    $sheet->setCellValue('P'.$row, $data->nationality);
                    $sheet->setCellValue('Q'.$row, $data->school_type);
                    $sheet->setCellValue('R'.$row, $data->p_school_name);
                    $sheet->setCellValue('S'.$row, $data->p_school_city);
                    $sheet->setCellValue('T'.$row, $data->class);
                    $sheet->setCellValue('U'.$row, $data->student_number);
                    $sheet->setCellValue('V'.$row, $data->grade_avg);
                    $sheet->setCellValue('W'.$row, $data->is_transfered);
                    $sheet->setCellValue('X'.$row, $data->m_school_name);
                    $sheet->setCellValue('Y'.$row, $data->m_school_city);
                    $sheet->setCellValue('Z'.$row, $data->m_school_district);
                    $sheet->setCellValue('AA'.$row, $data->h_school_name);
                    $sheet->setCellValue('AB'.$row, $data->h_school_city);
                    $sheet->setCellValue('AC'.$row, $data->h_school_district);
                    $sheet->setCellValue('AD'.$row, $data->grade_high_school);
                    $sheet->setCellValue('AE'.$row, $data->entry_grade_university);
                    $sheet->setCellValue('AF'.$row, $data->university_city);
                    $sheet->setCellValue('AG'.$row, $data->current_university);
                    $sheet->setCellValue('AH'.$row, $data->university_faculty);
                    $sheet->setCellValue('AI'.$row, $data->grade_departmant);
                    $sheet->setCellValue('AJ'.$row, $data->university_type);
                    $sheet->setCellValue('AK'.$row, $data->university_class);
                    $sheet->setCellValue('AL'.$row, $data->university_educ_time);
                    $sheet->setCellValue('AM'.$row, $data->agnoSystem);
                    $sheet->setCellValue('AN'.$row, $data->agno);
                    $sheet->setCellValue('AO'.$row, $data->university_transfer);
                    $sheet->setCellValue('AP'.$row, $data->university_transfer_desc);
                    $sheet->setCellValue('AQ'.$row, $data->languages);
                    $sheet->setCellValue('AR'.$row, $data->grade_university);
                    $sheet->setCellValue('AS'.$row, $data->grade_departmant);
                    $sheet->setCellValue('AT'.$row, $data->masterUniversity);
                    $sheet->setCellValue('AU'.$row, $data->master_field);
                    $sheet->setCellValue('AV'.$row, $data->grade_agno);
                    $sheet->setCellValue('AW'.$row, $data->housing_type);
                    $sheet->setCellValue('AX'.$row, $data->housing_fee);
                    $sheet->setCellValue('AY'.$row, $data->living_with_count);
                    $sheet->setCellValue('AZ'.$row, $data->residing_city);
                    $sheet->setCellValue('BA'.$row, $data->residing_district);
                    $sheet->setCellValue('BB'.$row, $data->address_detail);
                    $sheet->setCellValue('BC'.$row, $data->mother_city);
                    $sheet->setCellValue('BD'.$row, $data->mother_district);
                    $sheet->setCellValue('BE'.$row, $data->father_city);
                    $sheet->setCellValue('BF'.$row, $data->father_district);
                    $sheet->setCellValue('BG'.$row, $data->parent_address);
                    $sheet->setCellValue('BH'.$row, $data->parent_mobile);
                    $sheet->setCellValue('BI'.$row, $data->parent_phone);
                    $sheet->setCellValue('BJ'.$row, $data->parent_email);
                    $sheet->setCellValue('BK'.$row, $data->emergency_person_name);
                    $sheet->setCellValue('BL'.$row, $data->emergency_person_surname);
                    $sheet->setCellValue('BM'.$row, $data->emergency_person_phone);
                    $sheet->setCellValue('BN'.$row, $data->emergency_closeness);
                    $sheet->setCellValue('BO'.$row, $data->emergency_person_email);
                    $sheet->setCellValue('BP'.$row, $data->parent_together);
                    $sheet->setCellValue('BQ'.$row, $data->mother_alive);
                    $sheet->setCellValue('BR'.$row, $data->mother_name);
                    $sheet->setCellValue('BS'.$row, $data->mother_surname);
                    $sheet->setCellValue('BT'.$row, $data->father_name);
                    $sheet->setCellValue('BU'.$row, $data->father_surname);
                    $sheet->setCellValue('BV'.$row, $data->mother_job);
                    $sheet->setCellValue('BW'.$row, $data->father_job);
                    $sheet->setCellValue('BX'.$row, $data->mother_educ);
                    $sheet->setCellValue('BY'.$row, $data->father_educ);
                    $sheet->setCellValue('BZ'.$row, $data->mother_company);
                    $sheet->setCellValue('CA'.$row, $data->father_company);
                    $sheet->setCellValue('CB'.$row, $data->count);
                    $sheet->setCellValue('CC'.$row, $data->educ_count);
                    $sheet->setCellValue('CD'.$row, $data->income_person);
                    $sheet->setCellValue('CE'.$row, $data->total_person);
                    $sheet->setCellValue('CF'.$row, $data->mother_salary);
                    $sheet->setCellValue('CG'.$row, $data->father_salary);
                    $sheet->setCellValue('CH'.$row, $data->other_salary);
                    $sheet->setCellValue('CI'.$row, $data->other_income);
                    $sheet->setCellValue('CJ'.$row, $data->parent_housing_type);
                    $sheet->setCellValue('CK'.$row, $data->rent_count);
                    $sheet->setCellValue('CL'.$row, $data->other_detail);
                    $sheet->setCellValue('CM'.$row, $data->government);
                    $sheet->setCellValue('CN'.$row, $data->special);
                    $sheet->setCellValue('CO'.$row, $data->disabled_status);
                    $sheet->setCellValue('CP'.$row, $data->disabled_detail);
                    $sheet->setCellValue('CQ'.$row, $data->platform);
                    $sheet->setCellValue('CR'.$row, $data->skills);
                    $sheet->setCellValue('CS'.$row, $data->social_projects);
                    $sheet->setCellValue('CT'.$row, $data->hobbies);
                    $sheet->setCellValue('CU'.$row, $data->sports);
                    $sheet->setCellValue('CV'.$row, $data->last_books);
                    $sheet->setCellValue('CW'.$row, $data->message);
                    $sheet->setCellValue('CX'.$row, $data->bank_name);
                    $sheet->setCellValue('CY'.$row, $data->iban);
                    $sheet->setCellValue('CZ'.$row, $data->account_number);
                    $sheet->setCellValue('DA'.$row, $data->is_working);
                    $sheet->setCellValue('DB'.$row, $data->job_company);
                    $sheet->setCellValue('DC'.$row, $data->job_rank);
                    $sheet->setCellValue('DD'.$row, $data->job_sgk);
                    $sheet->setCellValue('DE'.$row, $data->job_salary);
                    $sheet->setCellValue('DF'.$row, $this->getBelgeDurum($data->doc_ogrenciBelgesi));
                    $sheet->setCellValue('DG'.$row, $this->getBelgeDurum($data->doc_adlisicilkaydi));
                    $sheet->setCellValue('DH'.$row, $this->getBelgeDurum($data->doc_nufuskayitornegi));
                    $sheet->setCellValue('DI'.$row, $this->getBelgeDurum($data->doc_annegelirbelgesi));
                    $sheet->setCellValue('DJ'.$row, $this->getBelgeDurum($data->doc_babagelirbelgesi));
                    $sheet->setCellValue('DK'.$row, $this->getBelgeDurum($data->doc_taahhutname));
                    $sheet->setCellValue('DL'.$row, $this->getBelgeDurum($data->doc_kimlik));
                    $sheet->setCellValue('DM'.$row, $this->getBelgeDurum($data->doc_bankahesap));
                    $sheet->setCellValue('DN'.$row, $this->getBelgeDurum($data->doc_transkript));
                    $sheet->setCellValue('DO'.$row, $this->getBelgeDurum($data->doc_ikametgah));
                    $sheet->setCellValue('DP'.$row, $this->getBelgeDurum($data->doc_karne));
                    $sheet->setCellValue('DQ'.$row, $this->getBelgeDurum($data->doc_diger));
                    $sheet->setCellValue('DR'.$row, $data->totalPoints);
                    $sheet->setCellValue('DS'.$row, $data->mulakat_durumu);
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Aday_Bursiyerler_'.time().'.xlsx';
            $filePath = storage_path('app/public/temp/'.$fileName);

            // Temp klasörünü kontrol et
            if (! file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            // Dosyayı kaydet
            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: '.$e->getMessage());
            \Log::error('userIds: '.print_r($userIds, true)); // Debug için

            return response()->json(['error' => 'Excel dosyası oluşturulamadı'], 500);
        }
    }

    public function mezuntopluIslemYonet(Request $request)
    {
        // Gelen deger = scholar_forms id degeri
        $userIds = $request->input('userIds'); // Kullanıcı ID'leri
        $islemId = $request->input('islemId'); // İşlem ID'si
        switch ($islemId) {
            case 1:
                foreach ($userIds as $id) {
                    $result = $this->geriAl($id);
                }
                break;
            case 2:
                foreach ($userIds as $id) {
                    $result = $this->deleteActiveScholar($id);
                    $form = ScholarForm::where('scholar_id', $id)->first();
                    $form->delete();
                }
                break;
            case 5:
                foreach ($userIds as $id) {
                    $this->setAktif($id);
                }
                $result = true;
                break;
        }

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result,
        ]);
    }

    public function setAktif($id)
    {

        // todo sadece yukseklisans lisans icin sinirlandirildi.
        $period = Period::where([
            ['type', 1],
            ['status', 1],
        ])->first();

        if (! $period) {
            session()->flash('error', 'Kayıt Yenileme Dönemi Bulunamadı!');

            return redirect()->route('panel');
        }
        $activeForm = ScholarForm::with('infos')->where('id', $id)->first();
        if ($activeForm->infos->educationType != 'doktora') {
            $activeForm->status = 3;
            $activeForm->save();
            $activeScholar = Scholar::find($activeForm->scholar_id);
            $activeScholar->status = 2;
            $activeScholar->save();
            $password = Str::random(8);
            $hashpassword = md5($password);
            $bursiyer = Scholar::find($activeScholar->id);
            $bursiyer->password = $hashpassword;
            $bursiyer->save();
            $scholarForms = ScholarForm::with('infos')->where('scholar_id', $activeForm->scholar_id)->get();
            $activeScholars = Scholar::where('id', $bursiyer->id)->with('form.infos')->get();
            foreach ($activeScholars as $activeScholar) {
                $password = Str::random(8);
                $hashpassword = md5($password);
                $bursiyer = Scholar::find($activeScholar->id);
                $bursiyer->password = $hashpassword;
                $bursiyer->status = 2;
                $bursiyer->save();
                $check = RenewForm::where([['period_id', $period->id], ['scholar_id', $activeScholar->id]])->get();
                if (count($check) < 1) {
                    $form = new RenewForm;
                    $form->period_id = $period->id;
                    $form->scholar_id = $activeScholar->id;
                    $form->save();
                    foreach ($scholarForms as $scholarForm) {
                        if ($scholarForm->scholar_id == $activeScholar->id && ! is_null($scholarForm->infos)) {
                            $oldForm = $scholarForm->id;

                            // Create RenewDocuments entry
                            $itemdoc = new RenewDocuments;
                            $itemdoc->form_id = $oldForm;
                            $itemdoc->save();
                            Log::info('renewdocuments kaydedildi');
                            $item = new RenewAnswer;
                            Log::info('renewanswer olusturuldu');
                            $item->tc_no = $scholarForm->infos->tc_no;
                            $item->form_id = $form->id;
                            $item->tel_no = $scholarForm->infos->tel_no;
                            $item->save();
                            $this->moveActiveModelToRenewModel(ActiveSiblingDetails::class, RenewSiblingDetails::class, $form->id, $oldForm);
                            $this->moveActiveModelToRenewModel(ActiveOtherScholarshipDetails::class, RenewOtherScholarshipDetails::class, $form->id, $oldForm);
                            // Create or update RenewAnswer entry
                            $item = RenewAnswer::find($item->id);
                            // Eğer kayıt bulunamazsa yeni bir RenewAnswer oluştur
                            if (! $item) {
                                $item = new RenewAnswer;
                                $item->tc_no = $scholarForm->infos->tc_no;
                                $item->form_id = $form->id;
                                $item->tel_no = $scholarForm->infos->tel_no;
                                $item->save();
                            }

                            // ScholarForm'dan gelen verileri al
                            $scholarFormData = $scholarForm->infos->toArray();

                            $filteredData = array_filter($scholarFormData, function ($key) {
                                return $key !== 'form_id' && $key !== 'password' && strpos($key, 'doc_') !== 0;
                            }, ARRAY_FILTER_USE_KEY);

                            // Verileri RenewAnswer modeline güncelle
                            $result = $item->update($filteredData);
                            $item->status = 0;
                            $item->save();
                            switch ($item->educationType) {
                                case 'ilkokul':
                                    $item->educationType = 'ortaokul';
                                    break;
                                case 'ortaokul':
                                    $item->educationType = 'lise';
                                    break;
                                case 'lise':
                                    $item->educationType = 'lisans';
                                    break;
                                case 'lisans':
                                    $item->educationType = 'yukseklisans';
                                    break;
                                case 'yukseklisans':
                                    $item->educationType = 'doktora';
                                    break;

                            }
                            $item->save();
                        }
                    }
                    RenewForm::where('id', $form->id)->update(['status' => 0]);
                    // Email kontrolü ekle
                    if ($activeScholar->email) {
                        try {
                            Log::info('mail gonderimi basladi');
                            // Yeni template sistemi ile mail gönder
                            try {
                                $parameters = [
                                    'name' => $activeScholar->name,
                                    'surname' => $activeScholar->surname,
                                    'email' => $activeScholar->email,
                                    'password' => $password,
                                ];

                                $this->mailController->sendTemplateEmail(
                                    'kayit-yenileme-donemi-basladi',
                                    $activeScholar->email,
                                    'Kayıt Yenileme Döneminiz Açıldı',
                                    $parameters
                                );
                            } catch (\Exception $e) {
                                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                                \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: '.$e->getMessage());
                            }
                            Log::info('mail gonderildi');
                        } catch (\Exception $e) {
                            // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                            \Log::error('Mail gönderimi hatası: '.$e->getMessage(), [
                                'scholar_id' => $activeScholar->id,
                                'email' => $activeScholar->email,
                            ]);
                        }
                    } else {
                        // Email olmayan bursiyerleri loglayabilirsiniz
                        \Log::warning('Bursiyerin email adresi yok', [
                            'scholar_id' => $activeScholar->id,
                            'name' => $activeScholar->name,
                            'surname' => $activeScholar->surname,
                        ]);
                    }
                }
            }
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'Doktora Bursiyerleri Yenileme Dönemi İçin Yapılamaz!');
        }

        return true;
    }

    private function getBelgeDurum($data)
    {
        if ($data) {
            return 'Evet';
        } else {
            return 'Hayır';
        }
    }

    public function kytopluIslemYonet(Request $request)
    {
        $userIds = $request->input('userIds'); // Kullanıcı ID'leri

        $islemId = $request->input('islemId'); // İşlem ID'si
        switch ($islemId) {
            case 0:
                $redSebebi = $request->input('redSebebi');
                $aciklama = $request->input('digerAciklama');
                foreach ($userIds as $id) {
                    $answer = RenewAnswer::where('id', $id)->first();
                    $result = $this->ignoreRenew($answer->form_id, $aciklama, $redSebebi);
                }

                return response()->json([
                    'data' => $userIds,
                    'islemId' => $islemId,
                    'result' => $result,
                ]);
            case 1:
                foreach ($userIds as $id) {
                    $answer = RenewAnswer::where('id', $id)->first();

                    $result = $this->kayitYenilemeSonuclandir($answer->form_id, 1);
                }
                break;
            case 2:
                $iadeSebebi = $request->input('iadeSebebi');
                $aciklama = $request->input('iadeDigerAciklama');
                foreach ($userIds as $id) {
                    $answer = RenewAnswer::where('id', $id)->first();
                    $result = $this->returnRenew($answer->form_id, $aciklama, $iadeSebebi);
                }
                break;
            case 3:

                foreach ($userIds as $id) {
                    $answer = RenewAnswer::where('id', $id)->first();
                    $result = $this->deleterenewrelations($answer->form_id);
                }
                break;
            case 5:
                foreach ($userIds as $id) {
                    $answer = RenewAnswer::where('id', $id)->first();
                    $result = $this->sifreYenileKY($answer->form_id);
                }
                break;
        }

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result,
        ]);
    }

    public function sifreYenileKyForm($id)
    {
        $this->sifreYenileKY($id);

        return redirect()->back()->with('success', 'İşlem Başarılı!');
    }

    public function sifreYenileKY($id)
    {
        $aday = RenewForm::where('id', $id)->first();
        $password = Str::random(8);
        $scholar = Scholar::where('id', $aday->scholar_id)->first();
        $scholar->password = md5($password);
        $result = $scholar->save();
        // Email kontrolü ekle
        if ($aday->infos->email && $result) {
            try {
                $this->mailController->sendMail(
                    $aday->infos->email,
                    'Giriş Şifreniz Güncellenmiştir.',
                    'mailtemplates.sifrekayityenileme',
                    [
                        'ad' => $aday->infos->name,
                        'soyad' => $aday->infos->surname,
                        'email' => $aday->infos->email,
                        'password' => $password,
                    ]
                );
                Log::info('mail gonderildi', [
                    'scholar_id' => $aday->scholar_id,
                    'email' => $aday->infos->email,
                    'password' => $password,
                ]);

                return true;
            } catch (\Exception $e) {
                // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                \Log::error('Mail gönderimi hatası: '.$e->getMessage(), [
                    'scholar_id' => $aday->scholar_id,
                    'email' => $aday->infos->email,
                ]);
            }
        } else {
            // Email olmayan bursiyerleri loglayabilirsiniz
            \Log::warning('Bursiyerin email adresi yok', [
                'scholar_id' => $aday->scholar_id,
                'name' => $aday->infos->name,
                'surname' => $aday->infos->surname,
            ]);
        }
    }

    public function tekliMezunEt($id)
    {
        $this->mezunEt($id);

        return redirect()->route('mezunlar');
    }

    public function mezunprofildengerial($id)
    {

        $this->geriAl($id);

        return redirect()->route('mezunlar');
    }

    public function geriAl($id)
    {

        $scholar = ScholarForm::where('id', $id)->first();
        $scholar->status = 3;
        $scholar->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
        $scholar->save();
        $form = Scholar::find($scholar->scholar_id);
        $form->status = 1;
        $result = $form->save();
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }

        return redirect()->route('bursiyerler');
    }

    public function activeIptalEt($id)
    {
        $form = ScholarForm::where('id', $id)->first();
        $scholar = Scholar::find($form->scholar_id);
        $scholar->status = 4;
        $form->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
        $form->status = 4;
        $form->save();
        $result = $scholar->save();
        if ($result) {
            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $scholar->name,
                    'surname' => $scholar->surname,
                ];

                $this->mailController->sendTemplateEmail(
                    'bursiyerlik-iptal',
                    $scholar->email,
                    'Bursiyerliğiniz İptal Edilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Bursiyerlik iptal mail gönderim hatası: '.$e->getMessage());
            }
        }

    }

    public function tekliiptalet($id)
    {
        $form = ScholarForm::where('scholar_id', $id)->first();
        $this->activeIptalEt($form->id);

        return redirect()->route('bursiyerler');
    }

    public function mezunEt($id)
    {
        $form = ScholarForm::where('id', $id)->first(); // İlk kaydı alın
        $form->status = 2;
        $form->save();
        $scholar = Scholar::find($form->scholar_id);
        $scholar->status = 3;

        $result = $scholar->save();
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
            $parameters = [
                'name' => $scholar->name,
                'surname' => $scholar->surname,
            ];
            $this->mailController->sendTemplateEmail(
                'mezun-etme-mesaji',
                $scholar->email,
                'Mezuniyetinizden Dolayı Bursiyerliğiniz Sona Ermiştir.',
                $parameters
            );
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }

        return redirect()->route('bursiyerler');
    }

    public function deleteActiveScholar($id)
    {
        $scholar = Scholar::find($id);
        $scholar_id = $scholar->id;
        $scholarForm = ScholarForm::where('scholar_id', $scholar_id)->first();
        $renewform = RenewForm::where('scholar_id', $scholar_id)->first();

        if ($scholar) {
            $ActiveAnswer = ActiveAnswer::where('form_id', $scholarForm->id)->first();
            $adayPath = 'bursiyerler/'.$scholar_id;
            if (Storage::disk('public')->exists($adayPath)) {
                Storage::disk('public')->deleteDirectory($adayPath);
            }
            foreach ($ActiveAnswer->getAttributes() as $key => $value) {
                // Eğer özellik doc_ ile başlıyorsa ve değeri varsa
                if (str_starts_with($key, 'doc_') && $value) {
                    // Storage'dan dosya yolunu temizle (başındaki /storage/ kısmını kaldır)
                    $filePath = str_replace('/storage/', '', $value);

                    // Eğer dosya varsa sil
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
            $ActiveAnswer->delete();
            if ($renewform) {
                $renew_id = $renewform->id;
                RenewAnswer::where('form_id', $renew_id)->delete();
            }
            if ($scholarForm) {
                $scholarForm->delete();
            }

            return $scholar->delete();
        }

        return false;
    }

    public function deleteactiverelation($id)
    {
        $this->deleteActiveScholar($id);
        if ($form = ScholarForm::where('scholar_id', $id)->first()) {
            $formid = $form->id;
            $form->delete();
        } else {
            $formid = null;
        }

        $renewForms = RenewForm::where('scholar_id', $id)->get();
        foreach ($renewForms as $renewForm) {
            $renewForm->delete();
        }

        return redirect()->route('bursiyerler');

    }

    public function deleterenewrelation($id)
    {
        $form = RenewForm::where('id', $id)->first();
        $bilgiler = RenewAnswer::where('form_id', $form->id)->first();
        $scholar_id = $form->scholar_id;
        $adayPath = 'uploads/kayityenilemeler/'.$scholar_id;
        if (Storage::disk('public')->exists($adayPath)) {
            Storage::disk('public')->deleteDirectory($adayPath);
        }
        // Bilgiler objesinin tüm özelliklerini döngüye al
        foreach ($bilgiler->getAttributes() as $key => $value) {
            // Eğer özellik doc_ ile başlıyorsa ve değeri varsa
            if (str_starts_with($key, 'doc_') && $value) {
                // Storage'dan dosya yolunu temizle (başındaki /storage/ kısmını kaldır)
                $filePath = str_replace('/storage/', '', $value);

                // Eğer dosya varsa sil
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // Kayıtları sil
        $bilgiler->delete();
        $form->delete();

        return redirect()->route('kayityenileme');
    }

    public function ActivetopluIslemYonet(Request $request)
    {
        $userIds = $request->input('userIds'); // Kullanıcı ID'leri
        $islemId = $request->input('islemId');
        // JSON string'i array'e çevir
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }
        switch ($islemId) {

            case 0:
                foreach ($userIds as $id) {
                    $result = $this->activeIptalEt($id);
                }
                break;
            case 1:
                foreach ($userIds as $id) {
                    $scholarform = ScholarForm::where('id', $id)->first();
                    $result = $this->mezunEt($scholarform->id);
                }
                break;
            case 2:
                $iadeSebebi = $request->input('iadeSebebi');
                $aciklama = $request->input('iadeDigerAciklama');
                foreach ($userIds as $id) {
                    $result = $this->returnRenew($id, $aciklama, $iadeSebebi);
                }
                break;
            case 3:
                foreach ($userIds as $id) {
                    $form = ScholarForm::where('id', $id)->first();

                    $result = $this->deleteActiveScholar($form->scholar_id);
                    $form->delete();
                }
                break;
            case '4':
                if (empty($userIds)) {
                    // Eğer userIds boşsa tüm kayıtları al
                    $userIds = Scholar::pluck('id')->toArray();
                }

                $result = $this->AktifTopluIndir($userIds);

                break;
            case 5:
                foreach ($userIds as $id) {
                    $bursiyerTipi = $request->input('bursiyerTipi');
                    $result = $this->bursiyerTipGuncelle($id, $bursiyerTipi);
                }
                break;
        }
        $result = true;

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result,
            'message' => 'İşlem başarıyla gerçekleştirildi.',
        ]);
    }

    public function bursiyerTipGuncelle($id, $bursiyerTipi)
    {
        $scholar = ActiveAnswer::where('form_id', $id)->first();
        if ($bursiyerTipi == 'Boş') {
            $scholar->aday_turu = null;
        } else {
            $scholar->aday_turu = $bursiyerTipi;
        }
        $scholar->save();
    }

    public function ActiveTopluIslemDownload(Request $request)
    {

        $userIds = json_decode($request->input('userIds'));
        foreach ($userIds as $id) {
            $scholarIds[] = ScholarForm::where('id', $id)->first()->scholar_id;
        }
        $islemId = $request->input('islemId');
        if (empty($userIds)) {
            $scholarIds = Scholar::pluck('id')->toArray();
        }

        return $this->AktifTopluIndir($scholarIds, 'Bursiyerler');
    }

    public function MezunTopluIslemDownload(Request $request)
    {

        $userIds = json_decode($request->input('userIds'));
        foreach ($userIds as $id) {
            $scholarIds[] = ScholarForm::where('id', $id)->first()->scholar_id;
        }
        $islemId = $request->input('islemId');
        if (empty($userIds)) {
            $scholarIds = Scholar::where('status', 3)->pluck('id')->toArray();
        }

        return $this->AktifTopluIndir($scholarIds, 'Mezunlar');
    }

    public function AktifTopluIndir($userIds, $dosyaAdi)
    {
        try {
            // userIds'in dizi olduğundan emin ol
            if (! is_array($userIds)) {
                $userIds = explode(',', $userIds);
            }
            // Excel dosyası oluştur
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            // Başlıkları tanımla ve ekle
            $headers = [
                'Başvuru No',
                'Ad',
                'Soyad',
                'TC No',
                'Cep Telefonu',
                'Başvuru Durumu',
                'E-Posta',
                'Doğum Tarihi',
                'Nüfus Kayıtlı Olduğu Şehir',
                'Nüfus Kayıtlı Olduğu İlçe',
                'Doğduğu Şehir',
                'Doğduğu İlçe',
                'Cinsiyet',
                'Medeni Durum',
                'Uyruk',
                'Okul Tipi',
                'İlkokul Adı',
                'İlkokul Bulunduğu Şehir',
                'Sınıf',
                'Öğrenci No',
                'Not Ortalaması',
                'Nakil Yaptı Mı',
                'Ortaokul Adı',
                'Ortaokul Bulunduğu Şehir',
                'Ortaokul Bulunduğu İlçe',
                'Lise Adı',
                'Lise Bulunduğu Şehir',
                'Lise Bulunduğu İlçe',
                'Bitirdiğiniz Lise',
                'Üniversiteye Giriş Puanı',
                'Üniversite Şehri',
                'Öğrenime Devam Ettiğiniz Üniversite',
                'Öğrenime Devam Ettiğiniz Fakülte',
                'Öğrenime Devam Ettiğiniz Bölüm',
                'Üniversitenin Statüsü',
                'Kaçıncı Sınıfta Olacaksınız?',
                'Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)',
                'AGNO Sisteminiz',
                'AGNO',
                'Yatay/Dikey Geçiş Yaptı mı?',
                'Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız',
                'Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız',
                'Bitirdiğiniz Üniversite',
                'Mezun Olduğunuz Bölüm',
                'Yüksek Lisans Yaptığınız Üniversite',
                'Yüksek Lisans Yaptığınız Dal',
                'Mezuniyet AGNO',
                'Barınma Türü',
                'Ödenen Ücret',
                ' Birlikte Yaşanılan Kişi Sayısı ',
                ' Kaldığı İl ',
                ' Kaldığı İlçe ',
                ' Tam Adres ',
                '  Annenin Yaşadığı İl  ',
                ' Annenin Yaşadığı İlçe ',
                '  Babanın Yaşadığı İl  ',
                ' Babanın Yaşadığı İlçe ',
                ' Açık Adres ',
                ' Aile Cep Telefonu ',
                ' Aile Ev Telefonu ',
                ' Aile E-posta Adresi ',
                'Acil Durum Kişisi Ad',
                'Acil Durum Kişisi Soyad',
                'Acil Durum Kişisi Telefonu',
                'Acil Durum Kişisi Yakınlık Derecesi',
                'Acil Durum Kişisi Eposta Adresi',
                ' Anne Baba Birlikte Mi? ',
                ' Anne Baba Sağ Mı? ',
                ' Anne Ad ',
                ' Anne Soyad ',
                ' Baba Ad ',
                ' Baba Soyad ',
                ' Anne Meslek ',
                ' Baba Meslek ',
                ' Anne Tahsil Durumu ',
                ' Baba Tahsil Durumu ',
                ' Anne Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Baba Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Kardeş Sayısı ',
                ' Kendisi Dahil Okuyan Kardeş Sayısı ',
                ' Ailenin Geçmişini Kim/Kimler Sağlıyor? ',
                ' Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor? ',
                ' Annenin Aylık Net Geliri (TL) ',
                ' Babanın Aylık Net Geliri (TL) ',
                ' Diğer Kişilerin Aylık Net Geliri (TL) ',
                ' Ailenin Başka Geliri Var Mı? ',
                ' Ailenin Yaşamakta Olduğu Ev Türü ',
                ' Kira ise Aylık Net Kirası (TL) ',
                ' Diğer Gelir Bilgisi',
                ' Devlet Bursu Almakta mı ya da Başvurdu mu? ',
                ' Özel Burs Almakta ya da Başvurdu mu? ',
                ' Herhangi Bir Engeliniz Var mı? ',
                ' Engel Durumunu Açıklayınız (Varsa) ',
                ' Bizden Nasıl Haberdar Oldunuz? ',
                ' Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz? ',
                ' Katkıda Bulunduğunuz Sosyal Projeler ',
                ' Hobileriniz ',
                ' İlgilendiğiniz Spor Dalı (Varsa) ',
                ' Son Okuduğunuz Kitaplar ',
                ' Bize Mesajınız ',
                ' Banka ',
                'IBAN',
                'Hesap Numarası',
                ' Düzenli olarak bir kurumda kazanç sağlıyor mu? ',
                ' Kurum Adı ',
                'Görev',
                ' Sosyal Güvenlik Kurumu ',
                ' Aylık Net Ücret (TL) ',

                // Diğer başlıkları buraya ekleyebilirsiniz
            ];
            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column.'1', $header);
            }
            $row = 2; // Data başlangıç satırı

            // Scholar ve ilişkili verileri tek sorguda al
            $scholars = Scholar::with(['form' => function ($query) {
                $query->with('infos')
                    ->orderBy('created_at', 'desc');
            }])
                ->whereIn('id', $userIds)
                ->whereHas('form', function ($query) use ($dosyaAdi) {  // form ilişkisi olan kayıtları filtrele
                    $query->whereNotNull('id')
                        ->where('status', $dosyaAdi === 'Mezunlar' ? 2 : 3);  // Mezunlar için 2, diğerleri için 3
                })
                ->get();

            // Veya alternatif olarak:
            $status = $dosyaAdi === 'Mezunlar' ? 2 : 3;

            $scholars = Scholar::with(['form' => function ($query) {
                $query->with('infos')
                    ->orderBy('created_at', 'desc');
            }])
                ->whereIn('id', $userIds)
                ->whereHas('form', function ($query) use ($status) {
                    $query->whereNotNull('id')
                        ->where('status', $status);
                })
                ->get();
            foreach ($scholars as $scholar) {
                // Her scholar için en son form'u al
                $form = $scholar->form->first(); // En son oluşturulan form (orderBy('created_at', 'desc') sayesinde)

                if ($form && $form->infos) {
                    // Status kontrolü
                    $status = match ($form->infos->status) {
                        0 => 'Tamamlanmadı',
                        1 => 'Tamamlandı',
                        2 => 'İade Edildi',
                        3 => 'Onaylandı',
                        4 => 'Reddedildi',
                        default => 'Belirsiz'
                    };

                    // Debug için log
                    \Log::info('Processing Scholar ID: '.$scholar->id.' Form ID: '.$form->id);

                    // Excel hücrelerini doldur
                    $sheet->setCellValue('A'.$row, $scholar->id);
                    $sheet->setCellValue('B'.$row, $form->infos->name);
                    $sheet->setCellValue('C'.$row, $form->infos->surname);
                    $sheet->setCellValue('D'.$row, $form->infos->tc_no);
                    $sheet->setCellValue('E'.$row, $form->infos->tel_no);
                    $sheet->setCellValue('F'.$row, $status);
                    $sheet->setCellValue('G'.$row, $form->infos->email);
                    $sheet->setCellValue('H'.$row, $form->infos->b_dob);
                    $sheet->setCellValue('I'.$row, $form->infos->registered_city);
                    $sheet->setCellValue('J'.$row, $form->infos->registered_district);
                    $sheet->setCellValue('K'.$row, $form->infos->birth_city);
                    $sheet->setCellValue('L'.$row, $form->infos->birth_district);
                    $sheet->setCellValue('M'.$row, $form->infos->gender);
                    $sheet->setCellValue('N'.$row, $form->infos->maritality);
                    $sheet->setCellValue('O'.$row, $form->infos->nationality);
                    $sheet->setCellValue('P'.$row, $form->infos->school_type);
                    $sheet->setCellValue('Q'.$row, $form->infos->p_school_name);
                    $sheet->setCellValue('R'.$row, $form->infos->p_school_city);
                    $sheet->setCellValue('S'.$row, $form->infos->class);
                    $sheet->setCellValue('T'.$row, $form->infos->student_number);
                    $sheet->setCellValue('U'.$row, $form->infos->grade_avg);
                    $sheet->setCellValue('V'.$row, $form->infos->is_transfered);
                    $sheet->setCellValue('W'.$row, $form->infos->m_school_name);
                    $sheet->setCellValue('X'.$row, $form->infos->m_school_city);
                    $sheet->setCellValue('Y'.$row, $form->infos->m_school_district);
                    $sheet->setCellValue('Z'.$row, $form->infos->h_school_name);
                    $sheet->setCellValue('AA'.$row, $form->infos->h_school_city);
                    $sheet->setCellValue('AB'.$row, $form->infos->h_school_district);
                    $sheet->setCellValue('AC'.$row, $form->infos->grade_high_school);
                    $sheet->setCellValue('AD'.$row, $form->infos->entry_grade_university);
                    $sheet->setCellValue('AE'.$row, $form->infos->university_city);
                    $sheet->setCellValue('AF'.$row, $form->infos->current_university);
                    $sheet->setCellValue('AG'.$row, $form->infos->university_faculty);
                    $sheet->setCellValue('AH'.$row, $form->infos->grade_departmant);
                    $sheet->setCellValue('AI'.$row, $form->infos->university_type);
                    $sheet->setCellValue('AJ'.$row, $form->infos->university_class);
                    $sheet->setCellValue('AK'.$row, $form->infos->university_educ_time);
                    $sheet->setCellValue('AL'.$row, $form->infos->agnoSystem);
                    $sheet->setCellValue('AM'.$row, $form->infos->agno);
                    $sheet->setCellValue('AN'.$row, $form->infos->university_transfer);
                    $sheet->setCellValue('AO'.$row, $form->infos->university_transfer_desc);
                    $sheet->setCellValue('AP'.$row, $form->infos->languages);
                    $sheet->setCellValue('AQ'.$row, $form->infos->grade_university);
                    $sheet->setCellValue('AR'.$row, $form->infos->grade_departmant);
                    $sheet->setCellValue('AS'.$row, $form->infos->masterUniversity);
                    $sheet->setCellValue('AT'.$row, $form->infos->master_field);
                    $sheet->setCellValue('AU'.$row, $form->infos->grade_agno);
                    $sheet->setCellValue('AV'.$row, $form->infos->housing_type);
                    $sheet->setCellValue('AW'.$row, $form->infos->housing_fee);
                    $sheet->setCellValue('AX'.$row, $form->infos->living_with_count);
                    $sheet->setCellValue('AY'.$row, $form->infos->residing_city);
                    $sheet->setCellValue('AZ'.$row, $form->infos->residing_district);
                    $sheet->setCellValue('BA'.$row, $form->infos->address_detail);
                    $sheet->setCellValue('BB'.$row, $form->infos->mother_city);
                    $sheet->setCellValue('BC'.$row, $form->infos->mother_district);
                    $sheet->setCellValue('BD'.$row, $form->infos->father_city);
                    $sheet->setCellValue('BE'.$row, $form->infos->father_district);
                    $sheet->setCellValue('BF'.$row, $form->infos->parent_address);
                    $sheet->setCellValue('BG'.$row, $form->infos->parent_mobile);
                    $sheet->setCellValue('BH'.$row, $form->infos->parent_phone);
                    $sheet->setCellValue('BI'.$row, $form->infos->parent_email);
                    $sheet->setCellValue('BJ'.$row, $form->infos->emergency_person_name);
                    $sheet->setCellValue('BK'.$row, $form->infos->emergency_person_surname);
                    $sheet->setCellValue('BL'.$row, $form->infos->emergency_person_phone);
                    $sheet->setCellValue('BM'.$row, $form->infos->emergency_closeness);
                    $sheet->setCellValue('BN'.$row, $form->infos->emergency_person_email);
                    $sheet->setCellValue('BO'.$row, $form->infos->parent_together);
                    $sheet->setCellValue('BP'.$row, $form->infos->mother_alive);
                    $sheet->setCellValue('BQ'.$row, $form->infos->mother_name);
                    $sheet->setCellValue('BR'.$row, $form->infos->mother_surname);
                    $sheet->setCellValue('BS'.$row, $form->infos->father_name);
                    $sheet->setCellValue('BT'.$row, $form->infos->father_surname);
                    $sheet->setCellValue('BU'.$row, $form->infos->mother_job);
                    $sheet->setCellValue('BV'.$row, $form->infos->father_job);
                    $sheet->setCellValue('BW'.$row, $form->infos->mother_educ);
                    $sheet->setCellValue('BX'.$row, $form->infos->father_educ);
                    $sheet->setCellValue('BY'.$row, $form->infos->mother_company);
                    $sheet->setCellValue('BZ'.$row, $form->infos->father_company);
                    $sheet->setCellValue('CA'.$row, $form->infos->count);
                    $sheet->setCellValue('CB'.$row, $form->infos->educ_count);
                    $sheet->setCellValue('CC'.$row, $form->infos->income_person);
                    $sheet->setCellValue('CD'.$row, $form->infos->total_person);
                    $sheet->setCellValue('CE'.$row, $form->infos->mother_salary);
                    $sheet->setCellValue('CF'.$row, $form->infos->father_salary);
                    $sheet->setCellValue('CG'.$row, $form->infos->other_salary);
                    $sheet->setCellValue('CH'.$row, $form->infos->other_income);
                    $sheet->setCellValue('CI'.$row, $form->infos->parent_housing_type);
                    $sheet->setCellValue('CJ'.$row, $form->infos->rent_count);
                    $sheet->setCellValue('CK'.$row, $form->infos->other_detail);
                    $sheet->setCellValue('CL'.$row, $form->infos->government);
                    $sheet->setCellValue('CM'.$row, $form->infos->special);
                    $sheet->setCellValue('CN'.$row, $form->infos->disabled_status);
                    $sheet->setCellValue('CO'.$row, $form->infos->disabled_detail);
                    $sheet->setCellValue('CP'.$row, $form->infos->platform);
                    $sheet->setCellValue('CQ'.$row, $form->infos->skills);
                    $sheet->setCellValue('CR'.$row, $form->infos->social_projects);
                    $sheet->setCellValue('CS'.$row, $form->infos->hobbies);
                    $sheet->setCellValue('CT'.$row, $form->infos->sports);
                    $sheet->setCellValue('CU'.$row, $form->infos->last_books);
                    $sheet->setCellValue('CV'.$row, $form->infos->message);
                    $sheet->setCellValue('CW'.$row, $form->infos->bank_name);
                    $sheet->setCellValue('CX'.$row, $form->infos->iban);
                    $sheet->setCellValue('CY'.$row, $form->infos->account_number);
                    $sheet->setCellValue('CZ'.$row, $form->infos->is_working);
                    $sheet->setCellValue('DA'.$row, $form->infos->job_company);
                    $sheet->setCellValue('DB'.$row, $form->infos->job_rank);
                    $sheet->setCellValue('DC'.$row, $form->infos->job_sgk);
                    $sheet->setCellValue('DD'.$row, $form->infos->job_salary);
                    $row++;
                } else {
                    \Log::warning('Form veya form bilgileri bulunamadı - Scholar ID: '.$scholar->id);
                }
            }

            // Excel dosyasını oluştur ve kaydet
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = $dosyaAdi.'_'.time().'.xlsx';
            $filePath = storage_path('app/public/temp/'.$fileName);

            if (! file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: '.$e->getMessage());
            \Log::error('Stack trace: '.$e->getTraceAsString());

            return response()->json(['error' => 'Excel dosyası oluşturulamadı: '.$e->getMessage()], 500);
        }
    }

    public function KYTopluIslemDownload(Request $request)
    {
        $userIds = json_decode($request->input('userIds'));
        if (empty($userIds)) {
            $userIds = RenewForm::pluck('id')->toArray();
        }

        $islemId = $request->input('islemId');

        try {
            // userIds'in dizi olduğundan emin ol
            if (! is_array($userIds)) {
                $userIds = explode(',', $userIds);
            }

            // Excel dosyası oluştur
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            // Başlıkları tanımla ve ekle
            $headers = [
                'Başvuru No',
                'Ad',
                'Soyad',
                'TC No',
                'Cep Telefonu',
                'Kayıt Yenileme',
                'Ret Sebebi',
                'E-Posta',
                'Doğum Tarihi',
                'Nüfus Kayıtlı Olduğu Şehir',
                'Nüfus Kayıtlı Olduğu İlçe',
                'Doğduğu Şehir',
                'Doğduğu İlçe',
                'Cinsiyet',
                'Medeni Durum',
                'Uyruk',
                'Okul Tipi',
                'İlkokul Adı',
                'İlkokul Bulunduğu Şehir',
                'Sınıf',
                'Öğrenci No',
                'Not Ortalaması',
                'Nakil Yaptı Mı',
                'Ortaokul Adı',
                'Ortaokul Bulunduğu Şehir',
                'Ortaokul Bulunduğu İlçe',
                'Lise Adı',
                'Lise Bulunduğu Şehir',
                'Lise Bulunduğu İlçe',
                'Bitirdiğiniz Lise',
                'Üniversiteye Giriş Puanı',
                'Üniversite Şehri',
                'Öğrenime Devam Ettiğiniz Üniversite',
                'Öğrenime Devam Ettiğiniz Fakülte',
                'Öğrenime Devam Ettiğiniz Bölüm',
                'Üniversitenin Statüsü',
                'Kaçıncı Sınıfta Olacaksınız?',
                'Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)',
                'AGNO Sisteminiz',
                'AGNO',
                'Yatay/Dikey Geçiş Yaptı mı?',
                'Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız',
                'Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız',
                'Bitirdiğiniz Üniversite',
                'Mezun Olduğunuz Bölüm',
                'Yüksek Lisans Yaptığınız Üniversite',
                'Yüksek Lisans Yaptığınız Dal',
                'Mezuniyet AGNO',
                'Barınma Türü',
                'Ödenen Ücret',
                ' Birlikte Yaşanılan Kişi Sayısı ',
                ' Kaldığı İl ',
                ' Kaldığı İlçe ',
                ' Tam Adres ',
                '  Annenin Yaşadığı İl  ',
                ' Annenin Yaşadığı İlçe ',
                '  Babanın Yaşadığı İl  ',
                ' Babanın Yaşadığı İlçe ',
                ' Açık Adres ',
                ' Aile Cep Telefonu ',
                ' Aile Ev Telefonu ',
                ' Aile E-posta Adresi ',
                'Acil Durum Kişisi Ad',
                'Acil Durum Kişisi Soyad',
                'Acil Durum Kişisi Telefonu',
                'Acil Durum Kişisi Yakınlık Derecesi',
                'Acil Durum Kişisi Eposta Adresi',
                ' Anne Baba Birlikte Mi? ',
                ' Anne Baba Sağ Mı? ',
                ' Anne Ad ',
                ' Anne Soyad ',
                ' Baba Ad ',
                ' Baba Soyad ',
                ' Anne Meslek ',
                ' Baba Meslek ',
                ' Anne Tahsil Durumu ',
                ' Baba Tahsil Durumu ',
                ' Anne Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Baba Bağlı Olduğu Sosyal Güvenlik Kurumu ',
                ' Kardeş Sayısı ',
                ' Kendisi Dahil Okuyan Kardeş Sayısı ',
                ' Ailenin Geçmişini Kim/Kimler Sağlıyor? ',
                ' Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor? ',
                ' Annenin Aylık Net Geliri (TL) ',
                ' Babanın Aylık Net Geliri (TL) ',
                ' Diğer Kişilerin Aylık Net Geliri (TL) ',
                ' Ailenin Başka Geliri Var Mı? ',
                ' Ailenin Yaşamakta Olduğu Ev Türü ',
                ' Kira ise Aylık Net Kirası (TL) ',
                ' Diğer Gelir Bilgisi',
                ' Devlet Bursu Almakta mı ya da Başvurdu mu? ',
                ' Özel Burs Almakta ya da Başvurdu mu? ',
                ' Herhangi Bir Engeliniz Var mı? ',
                ' Engel Durumunu Açıklayınız (Varsa) ',
                ' Bizden Nasıl Haberdar Oldunuz? ',
                ' Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz? ',
                ' Katkıda Bulunduğunuz Sosyal Projeler ',
                ' Hobileriniz ',
                ' İlgilendiğiniz Spor Dalı (Varsa) ',
                ' Son Okuduğunuz Kitaplar ',
                ' Bize Mesajınız ',
                ' Banka ',
                'IBAN',
                'Hesap Numarası',
                ' Düzenli olarak bir kurumda kazanç sağlıyor mu? ',
                ' Kurum Adı ',
                'Görev',
                ' Sosyal Güvenlik Kurumu ',
                ' Aylık Net Ücret (TL) ',
                'Öğrenci Belgesi',
                'Adli Sicil Kaydı',
                'Nüfus Kayıt Onayı',
                'Annenin Gelir Belgesi',
                'Babanın Gelir Belgesi',
                'Taahhütname',
                'Kimlik',
                'Banka Hesabı',
                'Transkript',
                'İkametgah',
                'Karne',
                'Diger',

                // Diğer başlıkları buraya ekleyebilirsiniz
            ];
            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column.'1', $header);
            }

            $row = 2; // Data başlangıç satırı
            // Her bir kullanıcı için verileri ekle
            foreach ($userIds as $id) {
                $scholar = RenewAnswer::with('form')->where('form_id', $id)->first();
                if ($scholar && $scholar->form) {
                    // Status kontrolü
                    switch ($scholar->status) {
                        case 0:
                            $status = 'Devam Ediyor';
                            break;
                        case 1:
                            $status = 'Onay Bekliyor';
                            break;
                        case 2:
                            $status = 'İade Edildi';
                            break;
                        case 3:
                            $status = 'Onaylandı';
                            break;
                        case 4:
                            $status = 'Reddedildi';
                            break;
                        default:
                            $status = 'İadeden Döndü';
                    }
                    // Debug için log
                    \Log::info('KY FORM ID: '.$id);

                    // Excel hücrelerini doldur
                    $sheet->setCellValue('A'.$row, $scholar->aday_id);
                    $sheet->setCellValue('B'.$row, $scholar->name);
                    $sheet->setCellValue('C'.$row, $scholar->surname);
                    $sheet->setCellValue('D'.$row, $scholar->tc_no);
                    $sheet->setCellValue('E'.$row, $scholar->tel_no);
                    $sheet->setCellValue('F'.$row, $status);
                    $sheet->setCellValue('G'.$row, $scholar->redSebebi);
                    $sheet->setCellValue('H'.$row, $scholar->email);
                    $sheet->setCellValue('I'.$row, $scholar->b_dob);
                    $sheet->setCellValue('J'.$row, $scholar->registered_city);
                    $sheet->setCellValue('K'.$row, $scholar->registered_district);
                    $sheet->setCellValue('L'.$row, $scholar->birth_city);
                    $sheet->setCellValue('M'.$row, $scholar->birth_district);
                    $sheet->setCellValue('N'.$row, $scholar->gender);
                    $sheet->setCellValue('O'.$row, $scholar->maritality);
                    $sheet->setCellValue('P'.$row, $scholar->nationality);
                    $sheet->setCellValue('Q'.$row, $scholar->school_type);
                    $sheet->setCellValue('R'.$row, $scholar->p_school_name);
                    $sheet->setCellValue('S'.$row, $scholar->p_school_city);
                    $sheet->setCellValue('T'.$row, $scholar->class);
                    $sheet->setCellValue('U'.$row, $scholar->student_number);
                    $sheet->setCellValue('V'.$row, $scholar->grade_avg);
                    $sheet->setCellValue('W'.$row, $scholar->is_transfered);
                    $sheet->setCellValue('X'.$row, $scholar->m_school_name);
                    $sheet->setCellValue('Y'.$row, $scholar->m_school_city);
                    $sheet->setCellValue('Z'.$row, $scholar->m_school_district);
                    $sheet->setCellValue('AA'.$row, $scholar->h_school_name);
                    $sheet->setCellValue('AB'.$row, $scholar->h_school_city);
                    $sheet->setCellValue('AC'.$row, $scholar->h_school_district);
                    $sheet->setCellValue('AD'.$row, $scholar->grade_high_school);
                    $sheet->setCellValue('AE'.$row, $scholar->entry_grade_university);
                    $sheet->setCellValue('AF'.$row, $scholar->university_city);
                    $sheet->setCellValue('AG'.$row, $scholar->current_university);
                    $sheet->setCellValue('AH'.$row, $scholar->university_faculty);
                    $sheet->setCellValue('AI'.$row, $scholar->grade_departmant);
                    $sheet->setCellValue('AJ'.$row, $scholar->university_type);
                    $sheet->setCellValue('AK'.$row, $scholar->university_class);
                    $sheet->setCellValue('AL'.$row, $scholar->university_educ_time);
                    $sheet->setCellValue('AM'.$row, $scholar->agnoSystem);
                    $sheet->setCellValue('AN'.$row, $scholar->agno);
                    $sheet->setCellValue('AO'.$row, $scholar->university_transfer);
                    $sheet->setCellValue('AP'.$row, $scholar->university_transfer_desc);
                    $sheet->setCellValue('AQ'.$row, $scholar->languages);
                    $sheet->setCellValue('AR'.$row, $scholar->grade_university);
                    $sheet->setCellValue('AS'.$row, $scholar->grade_departmant);
                    $sheet->setCellValue('AT'.$row, $scholar->masterUniversity);
                    $sheet->setCellValue('AU'.$row, $scholar->master_field);
                    $sheet->setCellValue('AV'.$row, $scholar->grade_agno);
                    $sheet->setCellValue('AW'.$row, $scholar->housing_type);
                    $sheet->setCellValue('AX'.$row, $scholar->housing_fee);
                    $sheet->setCellValue('AY'.$row, $scholar->living_with_count);
                    $sheet->setCellValue('AZ'.$row, $scholar->residing_city);
                    $sheet->setCellValue('BA'.$row, $scholar->residing_district);
                    $sheet->setCellValue('BB'.$row, $scholar->address_detail);
                    $sheet->setCellValue('BC'.$row, $scholar->mother_city);
                    $sheet->setCellValue('BD'.$row, $scholar->mother_district);
                    $sheet->setCellValue('BE'.$row, $scholar->father_city);
                    $sheet->setCellValue('BF'.$row, $scholar->father_district);
                    $sheet->setCellValue('BG'.$row, $scholar->parent_address);
                    $sheet->setCellValue('BH'.$row, $scholar->parent_mobile);
                    $sheet->setCellValue('BI'.$row, $scholar->parent_phone);
                    $sheet->setCellValue('BJ'.$row, $scholar->parent_email);
                    $sheet->setCellValue('BK'.$row, $scholar->emergency_person_name);
                    $sheet->setCellValue('BL'.$row, $scholar->emergency_person_surname);
                    $sheet->setCellValue('BM'.$row, $scholar->emergency_person_phone);
                    $sheet->setCellValue('BN'.$row, $scholar->emergency_closeness);
                    $sheet->setCellValue('BO'.$row, $scholar->emergency_person_email);
                    $sheet->setCellValue('BP'.$row, $scholar->parent_together);
                    $sheet->setCellValue('BQ'.$row, $scholar->mother_alive);
                    $sheet->setCellValue('BR'.$row, $scholar->mother_name);
                    $sheet->setCellValue('BS'.$row, $scholar->mother_surname);
                    $sheet->setCellValue('BT'.$row, $scholar->father_name);
                    $sheet->setCellValue('BU'.$row, $scholar->father_surname);
                    $sheet->setCellValue('BV'.$row, $scholar->mother_job);
                    $sheet->setCellValue('BW'.$row, $scholar->father_job);
                    $sheet->setCellValue('BX'.$row, $scholar->mother_educ);
                    $sheet->setCellValue('BY'.$row, $scholar->father_educ);
                    $sheet->setCellValue('BZ'.$row, $scholar->mother_company);
                    $sheet->setCellValue('CA'.$row, $scholar->father_company);
                    $sheet->setCellValue('CB'.$row, $scholar->count);
                    $sheet->setCellValue('CC'.$row, $scholar->educ_count);
                    $sheet->setCellValue('CD'.$row, $scholar->income_person);
                    $sheet->setCellValue('CE'.$row, $scholar->total_person);
                    $sheet->setCellValue('CF'.$row, $scholar->mother_salary);
                    $sheet->setCellValue('CG'.$row, $scholar->father_salary);
                    $sheet->setCellValue('CH'.$row, $scholar->other_salary);
                    $sheet->setCellValue('CI'.$row, $scholar->other_income);
                    $sheet->setCellValue('CJ'.$row, $scholar->parent_housing_type);
                    $sheet->setCellValue('CK'.$row, $scholar->rent_count);
                    $sheet->setCellValue('CL'.$row, $scholar->other_detail);
                    $sheet->setCellValue('CM'.$row, $scholar->government);
                    $sheet->setCellValue('CN'.$row, $scholar->special);
                    $sheet->setCellValue('CO'.$row, $scholar->disabled_status);
                    $sheet->setCellValue('CP'.$row, $scholar->disabled_detail);
                    $sheet->setCellValue('CQ'.$row, $scholar->platform);
                    $sheet->setCellValue('CR'.$row, $scholar->skills);
                    $sheet->setCellValue('CS'.$row, $scholar->social_projects);
                    $sheet->setCellValue('CT'.$row, $scholar->hobbies);
                    $sheet->setCellValue('CU'.$row, $scholar->sports);
                    $sheet->setCellValue('CV'.$row, $scholar->last_books);
                    $sheet->setCellValue('CW'.$row, $scholar->message);
                    $sheet->setCellValue('CX'.$row, $scholar->bank_name);
                    $sheet->setCellValue('CY'.$row, $scholar->iban);
                    $sheet->setCellValue('CZ'.$row, $scholar->account_number);
                    $sheet->setCellValue('DA'.$row, $scholar->is_working);
                    $sheet->setCellValue('DB'.$row, $scholar->job_company);
                    $sheet->setCellValue('DC'.$row, $scholar->job_rank);
                    $sheet->setCellValue('DD'.$row, $scholar->job_sgk);
                    $sheet->setCellValue('DE'.$row, $scholar->job_salary);
                    $sheet->setCellValue('DF'.$row, $this->getBelgeDurum($scholar->doc_ogrenciBelgesi));
                    $sheet->setCellValue('DG'.$row, $this->getBelgeDurum($scholar->doc_adlisicilkaydi));
                    $sheet->setCellValue('DH'.$row, $this->getBelgeDurum($scholar->doc_nufuskayitornegi));
                    $sheet->setCellValue('DI'.$row, $this->getBelgeDurum($scholar->doc_annegelirbelgesi));
                    $sheet->setCellValue('DJ'.$row, $this->getBelgeDurum($scholar->doc_babagelirbelgesi));
                    $sheet->setCellValue('DK'.$row, $this->getBelgeDurum($scholar->doc_taahhutname));
                    $sheet->setCellValue('DL'.$row, $this->getBelgeDurum($scholar->doc_kimlik));
                    $sheet->setCellValue('DM'.$row, $this->getBelgeDurum($scholar->doc_bankahesap));
                    $sheet->setCellValue('DN'.$row, $this->getBelgeDurum($scholar->doc_transkript));
                    $sheet->setCellValue('DO'.$row, $this->getBelgeDurum($scholar->doc_ikametgah));
                    $sheet->setCellValue('DP'.$row, $this->getBelgeDurum($scholar->doc_karne));
                    $sheet->setCellValue('DQ'.$row, $this->getBelgeDurum($scholar->doc_diger));
                    $row++; // Bir sonraki satıra geç
                }
            }

            // Excel dosyasını oluştur ve kaydet
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Kayit_Yenileme_Bursiyerler_'.time().'.xlsx';
            $filePath = storage_path('app/public/temp/'.$fileName);

            if (! file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: '.$e->getMessage());

            return response()->json(['error' => 'Excel dosyası oluşturulurken bir hata oluştu'], 500);
        }
    }

    public function kyConfirm($id)
    {
        $ky = RenewForm::where('scholar_id', $id)->first();
        $ky->status = 1;
        $ky->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
        $ky->save();
        $kyanswers = RenewAnswer::where('form_id', $ky->id)->get();
        foreach ($kyanswers as $kyanswer) {
            $kyanswer->status = 1;
            $kyanswer->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $kyanswer->save();
        }
        $konu = 'KY Formunuz Kabul Edilmiştir';
        $icerik = 'icerik metni buraya gelecek. deneme amacli KY Formunuz kabul edilmistir.';

        $user = Scholar::find($id);
        if ($user) {
            $user->status = 1;
            $result = $user->save();

            RenewForm::where('scholar_id', $id)->update([
                'status' => 1,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            if ($result) {
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ];

                    $this->mailController->sendTemplateEmail(
                        'aday-onaylandi',
                        $user->email,
                        'Burs Başvurunuz Kabul Edilmiştir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday onaylanma mail gönderim hatası: '.$e->getMessage());
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deletenewrelations($id)
    {
        $user = NewAnswer::find($id);
        if ($user) {
            $adayPath = 'uploads/basvurular/'.$user->id;
            if (Storage::disk('public')->exists($adayPath)) {
                Storage::disk('public')->deleteDirectory($adayPath);
            }
            foreach ($user->getAttributes() as $key => $value) {
                // Eğer özellik doc_ ile başlıyorsa ve değeri varsa
                if (str_starts_with($key, 'doc_') && $value) {
                    // Storage'dan dosya yolunu temizle (başındaki /storage/ kısmını kaldır)
                    $filePath = str_replace('/storage/', '', $value);

                    // Eğer dosya varsa sil
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
            $tc_no = $user->tc_no;
            $result = $user->delete();
            if ($result) {
                NewDocuments::where('tc_no', $tc_no)->delete();
                NewSiblingDetails::where('tc_no', $tc_no)->delete();
                NewOtherScholarshipDetails::where('tc_no', $tc_no)->delete();
                NewAnswer::where('tc_no', $tc_no)->delete();
                NewTimeline::where('tc_no', $tc_no)->delete();
                AdayPoint::where('tc_no', $tc_no)->delete();

                return true;
            }
        } else {
            return false;
        }
    }

    public function deleterenewrelations($id)
    {
        $user = RenewForm::where('id', $id)->first();
        $form_status = $user->status;
        $scholar_id = $user->scholar_id;
        $adayPath = 'uploads/kayityenilemeler/'.$scholar_id;
        if (Storage::disk('public')->exists($adayPath)) {
            Storage::disk('public')->deleteDirectory($adayPath);
        }
        foreach ($user->getAttributes() as $key => $value) {
            // Eğer özellik doc_ ile başlıyorsa ve değeri varsa
            if (str_starts_with($key, 'doc_') && $value) {
                // Storage'dan dosya yolunu temizle (başındaki /storage/ kısmını kaldır)
                $filePath = str_replace('/storage/', '', $value);

                // Eğer dosya varsa sil
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
        $user->delete();
        $result = RenewAnswer::where('form_id', $user->id)->delete();
        if ($result) {
            $scholar = Scholar::where('id', $scholar_id)->first();
            switch ($form_status) {
                case '2':
                    $scholar->status = 4;
                    break;
                default:
                    $scholar->status = 1;
                    break;
            }
            $scholar->save();

            return true;
        } else {
            return false;
        }
    }

    public function deletenewrelation($id)
    {

        $user = NewAnswer::find($id);
        $adayPath = 'uploads/basvurular/'.$user->id;
        if (Storage::disk('public')->exists($adayPath)) {
            Storage::disk('public')->deleteDirectory($adayPath);
        }
        foreach ($user->getAttributes() as $key => $value) {
            // Eğer özellik doc_ ile başlıyorsa ve değeri varsa
            if (str_starts_with($key, 'doc_') && $value) {
                // Storage'dan dosya yolunu temizle (başındaki /storage/ kısmını kaldır)
                $filePath = str_replace('/storage/', '', $value);

                // Eğer dosya varsa sil
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
        $tc_no = $user->tc_no;
        $result = $user->delete();
        if ($result) {
            NewDocuments::where('tc_no', $tc_no)->delete();
            NewOtherScholarshipDetails::where('tc_no', $tc_no)->delete();
            NewSiblingDetails::where('tc_no', $tc_no)->delete();
            NewAnswer::where('tc_no', $tc_no)->delete();
            NewTimeline::where('tc_no', $tc_no)->delete();
            AdayPoint::where('tc_no', $tc_no)->delete();
        }

        return redirect()->route('adaybursiyerler');
    }

    public function returnRelation($id, $aciklama, $iadeSebebi)
    {
        $konu = 'Burs Başvuru formunuz Iade edilmistir.';
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu iade edilmistir. <div> </div> <h4> Gerekce : </h4>'.$iadeSebebi.'<div></div> <h4> Aciklama : </h4>'.$aciklama;
        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 2;
            $user->iadeSebebi = $iadeSebebi;
            $user->iadeAciklamasi = $aciklama;
            $user->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $result = $user->save();

            if ($result) {
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $user->name,
                        'surname' => $user->surname,
                        'sebep' => $iadeSebebi,
                        'aciklama' => $aciklama,
                    ];

                    $slug = null;
                    if (!empty($iadeSebebi)) {
                        $proposedSlug = 'aday-burs-iade-' . Str::slug($iadeSebebi);
                        if (MessageTemplate::where('slug', $proposedSlug)->exists()) {
                            $slug = $proposedSlug;
                        }
                    }

                    if (!$slug) {
                        if (MessageTemplate::where('slug', 'aday-burs-iade-diger')->exists()) {
                            $slug = 'aday-burs-iade-diger';
                        } else {
                            $slug = 'aday-iade-mesaji';
                        }
                    }

                    $this->mailController->sendTemplateEmail(
                        $slug,
                        $user->email,
                        'Burs Başvurunuz Iade Edilmistir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday iade mail gönderim hatası: '.$e->getMessage());
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function returnRenew($id, $aciklama, $iadeSebebi)
    {

        $konu = 'Kayit Yenileme Iade edilmistir.';
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu iade edilmistir. <div> </div> <h4> Gerekce : </h4>'.$iadeSebebi.'<div></div> <h4> Aciklama : </h4>'.$aciklama;
        $user = RenewForm::find($id);
        $scholar = Scholar::find($user->scholar_id);
        if ($user) {
            $result = RenewForm::where('id', $id)->update([
                'status' => 3,
                'iadeSebebi' => $iadeSebebi,
                'iadeDigerAciklama' => $aciklama,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            $kyanswer = RenewAnswer::where('form_id', $id)->first();
            $kyanswer->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $kyanswer->save();
            RenewAnswer::where('form_id', $id)->update([
                'status' => 2,
            ]);
        }
        if ($result) {
            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $scholar->name,
                    'surname' => $scholar->surname,
                    'sebep' => $iadeSebebi,
                    'aciklama' => $aciklama,
                ];

                $this->mailController->sendTemplateEmail(
                    'kayit-yenileme-iade-edildi',
                    $scholar->email,
                    $konu,
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme iade mail gönderim hatası: '.$e->getMessage());
            }

            return false;
        }
    }

    public function dokumanlariAktar($form_id, $tc_no)
    {
        $docs = NewDocuments::where('tc_no', $tc_no)->get();
        foreach ($docs as $doc) {
            $item = new ActiveDocuments;
            $item->form_id = $form_id;
            $item->name = $doc->name;
            $item->status = $doc->status;
            $item->save();
        }

    }

    public function addEmptyFileRecordRenew($form_id)
    {
        $titles = ['adlisicilkaydi', 'ogrenciBelgesi', 'nufuskayitornegi', 'annegelirbelgesi', 'babagelirbelgesi', 'taahhutname', 'kimlik', 'bankahesap', 'transkript', 'ikametgah', 'Karne', 'Diger', 'fotograf'];
        foreach ($titles as $title) {
            RenewDocuments::create([
                'name' => $title,
                'form_id' => $form_id,
            ]);
        }

    }

    public function addEmptyFileRecord($form_id)
    {
        $titles = ['adlisicilkaydi', 'fotograf', 'ogrenciBelgesi', 'nufuskayitornegi', 'annegelirbelgesi', 'babagelirbelgesi', 'taahhutname', 'kimlik', 'bankahesap', 'transkript', 'ikametgah', 'Karne', 'Diger'];
        foreach ($titles as $title) {
            ActiveDocuments::create([
                'name' => $title,
                'form_id' => $form_id,
            ]);
        }

    }

    public function transferNewToActive($form_id, $tc_no)
    {

        try {
            $newAnswer = NewAnswer::where('tc_no', $tc_no)->first();
            if ($newAnswer) {
                $activeAnswer = new ActiveAnswer;
                $newAnswerData = $newAnswer->toArray();
                $activeAnswerColumns = \Schema::getColumnListing('active_answers');
                $filteredData = array_intersect_key($newAnswerData, array_flip($activeAnswerColumns));
                $activeAnswer->fill($filteredData);
                $activeAnswer->form_id = $form_id;
                $activeAnswer->aday_id = $newAnswer->id;
                $activeAnswer->save();
                $this->ortak->addNewTimeline($tc_no, 'Aday Bursiyer Onaylandı', 'Adayın başvurusu onaylanarak aktif bursiyer olarak tanımlandı', 'Adayın başvurusu onaylanarak aktif bursiyer olarak tanımlandı');

            }
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {  // 23000 MySQL'de Duplicate Entry hatası için kullanılır
                session()->flash('error', 'Bu TC kimlik numarasına ait kayıt zaten mevcut!');
            } else {
                throw $e;
            }
        }

        // $this->moveOldModelToNewModel(NewParentInfo::class, ActiveParentInfo::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewPersonalnfo::class, ActivePersonalnfo::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewSiblingDetails::class, ActiveSiblingDetails::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewSiblingInfos::class, ActiveSiblingInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewSocialInfos::class, ActiveSocialInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewBankInfos::class, ActiveBankInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewEducationalInfo::class, ActiveEducationalInfo::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewFamilyInfos::class, ActiveFamilyInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewHousingInformation::class, ActiveHousingInformation::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewIncomeInfos::class, ActiveIncomeInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewJobInfos::class, ActiveJobInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewObstacledInfos::class, ActiveObstacledInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewOtherScholarshipInfos::class, ActiveOtherScholarshipInfos::class,$form_id,$tc_no);
        // $this->moveOldModelToNewModel(NewOtherScholarshipDetails::class, ActiveOtherScholarshipDetails::class,$form_id,$tc_no);
    }

    public function moveOldModelToNewModel($oldModel, $newModel, $form_id, $tc)
    {
        // Eski modelden veriyi al
        $record = $oldModel::where('tc_no', $tc)->first();
        // Eğer kayıt bulunmazsa, işlem yapılmaz
        if (! $record) {
            return null;
        }
        // Veriyi diziye çevir
        $data = $record->toArray();
        // Gerekli alanları kaldır
        unset($data['id']);
        unset($data['tc_no']);
        // Yeni form_id'yi ayarla
        $data['form_id'] = $form_id;
        $check = $newModel::where('form_id', $form_id)->first();
        if (! $check) {
            return $newModel::create($data);
        }
        // Yeni modele kaydı oluştur
    }

    public function moveRenewModelToNewModel($oldModel, $newModel, $old_form_id, $form_id)
    {
        $record = $oldModel::where('form_id', $old_form_id)->first();
        if (! $record) {
            return null;
        }
        $data = $record->toArray();
        unset($data['id']);
        unset($data['form_id']);
        $data['form_id'] = $form_id;

        return $newModel::create($data);
    }

    public function moveActiveModelToRenewModel($oldModel, $newModel, $form_id, $old_form_id)
    {
        $record = $oldModel::where('form_id', $old_form_id)->get();
        $data = $record->toArray();
        foreach ($data as $item) {
            unset($item['id']);
            unset($item['form_id']);
            $item['form_id'] = $form_id;
            $item = $newModel::create($item);
        }
    }

    private function kyKardesIsSutunSetNullable()
    {
        DB::statement('ALTER TABLE renew_sibling_details MODIFY job VARCHAR(255) NULL');
    }

    public function createRenewForms()
    {
        $this->kyKardesIsSutunSetNullable();
        $period = Period::where([
            ['type', 1],
            ['status', 1],
        ])->first();

        if (! $period) {
            session()->flash('error', 'Kayıt Yenileme Dönemi Bulunamadı!');

            return redirect()->route('panel');
        }
        $activeScholars = Scholar::where('status', 1)->with('form.infos')->get();
        $scholarForms = ScholarForm::with('infos')->whereIn('scholar_id', $activeScholars->pluck('id'))->get();
        foreach ($activeScholars as $activeScholar) {
            $password = Str::random(8);
            $hashpassword = md5($password);
            $bursiyer = Scholar::find($activeScholar->id);
            $bursiyer->password = $hashpassword;
            $bursiyer->status = 2;
            $bursiyer->save();

            $check = RenewForm::where([['period_id', $period->id], ['scholar_id', $activeScholar->id]])->get();

            if (count($check) < 1) {
                $form = new RenewForm;
                $form->period_id = $period->id;
                $form->scholar_id = $activeScholar->id;
                $form->save();
                foreach ($scholarForms as $scholarForm) {
                    if ($scholarForm->scholar_id == $activeScholar->id && ! is_null($scholarForm->infos)) {
                        $oldForm = $scholarForm->id;

                        // Create RenewDocuments entry
                        $itemdoc = new RenewDocuments;
                        $itemdoc->form_id = $oldForm;
                        $itemdoc->save();
                        $item = new RenewAnswer;

                        $item->tc_no = $scholarForm->infos->tc_no;
                        $item->form_id = $form->id;
                        $item->tel_no = $scholarForm->infos->tel_no;
                        $item->save();
                        $this->moveActiveModelToRenewModel(ActiveSiblingDetails::class, RenewSiblingDetails::class, $form->id, $oldForm);
                        $this->moveActiveModelToRenewModel(ActiveOtherScholarshipDetails::class, RenewOtherScholarshipDetails::class, $form->id, $oldForm);
                        // Create or update RenewAnswer entry
                        $item = RenewAnswer::find($item->id);
                        // Eğer kayıt bulunamazsa yeni bir RenewAnswer oluştur
                        if (! $item) {
                            $item = new RenewAnswer;
                            $item->tc_no = $scholarForm->infos->tc_no;
                            $item->form_id = $form->id;
                            $item->tel_no = $scholarForm->infos->tel_no;
                            $item->save();
                        }
                        if ($item->educationType == 'Lisans' || $item->educationType == 'yukseklisans' || $item->educationType == 'onlisans') {
                            $istenilenBelgeler = ['Öğrenci Belgesi', 'Transkript', 'Adli Sicil Belgesi'];
                        } elseif ($item->educationType == 'ilkokul' || $item->educationType == 'ortaokul' || $item->educationType == 'lise') {
                            $istenilenBelgeler = ['Öğrenci Belgesi', 'Karne'];
                        } else {
                            $istenilenBelgeler = [];
                        }

                        // ScholarForm'dan gelen verileri al
                        $scholarFormData = $scholarForm->infos->toArray();

                        $filteredData = array_filter($scholarFormData, function ($key) {
                            return $key !== 'form_id' && $key !== 'password' && strpos($key, 'doc_') !== 0;
                        }, ARRAY_FILTER_USE_KEY);

                        // Verileri RenewAnswer modeline güncelle
                        $result = $item->update($filteredData);
                        $item->status = 0;
                        $item->save();
                    }
                }

                RenewForm::where('id', $form->id)->update(['status' => 0]);

                // Email kontrolü ekle
                if ($activeScholar->email) {
                    try {
                        // Yeni template sistemi ile mail gönder
                        try {
                            $parameters = [
                                'name' => $activeScholar->name,
                                'surname' => $activeScholar->surname,
                                'email' => $activeScholar->email,
                                'password' => $password,
                            ];

                            $this->mailController->sendTemplateEmail(
                                'kayit-yenileme-donemi-basladi',
                                $activeScholar->email,
                                'Kayıt Yenileme Döneminiz Açıldı',
                                $parameters
                            );
                        } catch (\Exception $e) {
                            // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                            \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: '.$e->getMessage());
                        }
                    } catch (\Exception $e) {
                        // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                        \Log::error('Mail gönderimi hatası: '.$e->getMessage(), [
                            'scholar_id' => $activeScholar->id,
                            'email' => $activeScholar->email,
                        ]);
                    }
                } else {
                    // Email olmayan bursiyerleri loglayabilirsiniz
                    \Log::warning('Bursiyerin email adresi yok', [
                        'scholar_id' => $activeScholar->id,
                        'name' => $activeScholar->name,
                        'surname' => $activeScholar->surname,
                    ]);
                }
            }

        }

        return redirect()->route('panel');

    }

    public function kydenememail()
    {
        $activeScholars = Scholar::where('status', 1)->get();
        foreach ($activeScholars as $activeScholar) {
            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $activeScholar->name,
                    'surname' => $activeScholar->surname,
                ];

                $this->mailController->sendTemplateEmail(
                    'kayit-yenileme-donemi-basladi',
                    $activeScholar->email,
                    'Kayıt Yenileme Döneminiz Açıldı',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: '.$e->getMessage());
            }
        }

    }

    public function transferActiveToRenew($oldForm, $form_id)
    {

        $this->moveNewModelToRenewModel(ActiveParentInfo::class, RenewParentInfo::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActivePersonalnfo::class, RenewPersonalnfo::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveSiblingDetails::class, RenewSiblingDetails::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveSiblingInfos::class, RenewSiblingInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveSocialInfos::class, RenewSocialInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveBankInfos::class, RenewBankInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveEducationalInfo::class, RenewEducationalInfo::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveFamilyInfos::class, RenewFamilyInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveHousingInformation::class, RenewHousingInformation::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveIncomeInfos::class, RenewIncomeInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveJobInfos::class, RenewJobInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveObstacledInfos::class, RenewObstacledInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveOtherScholarshipInfos::class, RenewOtherScholarshipInfos::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveOtherScholarshipDetails::class, RenewOtherScholarshipDetails::class, $oldForm, $form_id);
        $this->moveNewModelToRenewModel(ActiveDocuments::class, RenewDocuments::class, $oldForm, $form_id);

    }

    public function moveNewModelToRenewModel($oldModel, $newModel, $old_form_id, $form_id)
    {
        // Eski modelden veriyi al
        $record = $oldModel::where('form_id', $old_form_id)->first();
        // Eğer kayıt bulunmazsa, işlem yapılmaz
        if (! $record) {
            return null;
        }
        // Veriyi diziye çevir
        $data = $record->toArray();
        // Gerekli alanları kaldır
        unset($data['id']);
        unset($data['tc_no']);
        // Yeni form_id'yi ayarla
        $data['form_id'] = $form_id;
        $check = $newModel::where('form_id', $form_id)->first();
        if (! $check) {
            $newModel::create($data);
        }

        return 0;
        // Yeni modele kaydı oluştur
    }

    public function moveNewModelToActiveModel($oldModel, $newModel, $tc_no, $form_id)
    {
        $record = $oldModel::where('tc_no', $tc_no)->get();
        if (! $record) {
            return null;
        }
        foreach ($record as $item) {
            $data = $item->toArray();
            unset($data['id']);
            $data['form_id'] = $form_id;
            $newModel::create($data);
        }
    }

    public function NewSiblingsToActiveSiblings($tc_no, $form_id)
    {
        $record = NewSiblingDetails::where('tc_no', $tc_no)->get();
        if (! $record) {
            return null;
        }
        foreach ($record as $item) {
            $data = $item->toArray();
            unset($data['id']);
            $data['form_id'] = $form_id;
            unset($data['tc_no']);
            ActiveSiblingDetails::create($data);
        }
    }

    public function NewOtherScholarshipToActiveOtherScholarship($tc_no, $form_id)
    {
        $record = NewOtherScholarshipDetails::where('tc_no', $tc_no)->get();
        if (! $record) {
            return null;
        }
        foreach ($record as $item) {
            $data = $item->toArray();
            unset($data['id']);
            $data['form_id'] = $form_id;
            unset($data['tc_no']);
            ActiveOtherScholarshipDetails::create($data);
        }
    }

    public function addConfirmedScholar($id)
    {

        $table = (new NewAnswer)->getTable();
        $columns = Schema::getColumnListing($table);
        $docColumns = array_filter($columns, function ($column) {
            return strpos($column, 'doc_') === 0;
        });
        $documents = NewAnswer::select($docColumns)->where('id', $id)->get();
        $aday = NewAnswer::where('id', $id)->first();
        $period = Period::where('id', $aday->period_id)->first();
        if (! $period) {
            $period = Period::where('type', 0)->where('status', 1)->first();
        }
        if (! $period) {
            $period = Period::where('type', 0)->orderBy('id', 'DESC')->first();
        }
        if ($aday->status != 3) {
            $aday->status = 3;
            $aday->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $aday->save();
            $check = Scholar::where('aday_id', $aday->id)->first();
            $password = Str::random(8);
            $hashpassword = md5($password);
            if (! $check) {

                $bursiyer = new Scholar;
                $bursiyer->name = $aday->name;
                $bursiyer->surname = $aday->surname;
                $bursiyer->email = $aday->email;
                $bursiyer->password = $hashpassword;
                $bursiyer->tc_no = $aday->tc_no;
                $bursiyer->aday_id = $aday->id;
                $bursiyer->save();

                $form = new ScholarForm;
                $form->period_id = $period->id;
                $form->aday_id = $aday->id;
                $form->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
                $form->scholar_id = $bursiyer->id;
                $form->status = 3;
                $result = $form->save();
                $this->transferNewToActive($form->id, $bursiyer->tc_no);
                $this->NewSiblingsToActiveSiblings($aday->tc_no, $form->id);
                $this->NewOtherScholarshipToActiveOtherScholarship($aday->tc_no, $form->id);
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $aday->name,
                        'surname' => $aday->surname,
                    ];

                    $this->mailController->sendTemplateEmail(
                        'aday-onaylandi',
                        $aday->email,
                        'Burs Başvurunuz Onaylanmıştır',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday onaylanma mail gönderim hatası: '.$e->getMessage());
                }
                session()->flash('success', 'Aday bursiyer onaylandi');

                // $documents = NewDocuments::where('tc_no',$aday->tc_no)->first();

                // .env dosyasından APP_URL'yi al
                $appUrl = env('APP_URL');

                // Her bir dosya yolunu işlemek için döngü
                /*foreach ($documents->toArray() as $column => $filePath) {
                    // Eğer dosya yolu null değilse ve string tipindeyse
                    if (!is_null($filePath) && is_string($filePath)) {
                        // Dosya yolunu relative hale getir ve mutlak dosya yolunu oluştur
                        $relativePath = str_replace('/storage', '', $filePath); // /storage'ı kaldır
                        $absoluteFilePath = base_path('storage' . $relativePath); // Mutlak dosya yolu

                        if (File::exists($absoluteFilePath)) {
                            // Hedef dizin
                            $destinationPath = base_path('storage/bursiyerler/' . $bursiyer->id . '/' . $period->path);

                            // Hedef dizini oluştur
                            if (!File::exists($destinationPath)) {
                                File::makeDirectory($destinationPath, 0755, true); // Recursive olarak dizin oluştur
                            }

                            // Dosya adı ve yeni yol
                            $fileName = basename($absoluteFilePath);
                            $newPath = $destinationPath . '/' . $fileName;

                            // Dosyayı kopyala
                            File::copy($absoluteFilePath, $newPath);

                            // ActiveDocuments modelinde form_id ile eşleşen satırı güncelle
                            $activeDocument = ActiveDocuments::firstOrCreate(
                                ['form_id' => $form->id],
                                ['form_id' => $form->id] // Eğer kayıt yoksa yeni bir kayıt oluştur
                            );

                            // Sütunları güncelle
                            $activeDocument->$column = '/storage/bursiyerler/' . $bursiyer->id . '/' . $period->path . '/' . $fileName;
                            $activeDocument->save();
                        } else {
                            echo "Dosya bulunamadı: " . $absoluteFilePath;
                        }
                    } else {
                        echo "Geçersiz dosya yolu: " . $filePath;
                    }
                }*/
                return redirect()->route('bursiyerler')->with('success', 'Aday bursiyer onaylandi');

            }
        } else {
            session()->flash('error', 'Bursiyer Durumu Zaten Değiştirildi!');

        }

    }

    public function confirmRelation($id)
    {
        $konu = 'Burs Başvuru Onayınız Kabul Edilmiştir';
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu kabul edilmistir.';

        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 3;
            $user->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $result = $user->save();
            if ($result) {
                $this->kullaniciBilgilendir($user->email, $icerik, $konu);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function ignoreRelation($id, $aciklama, $redsebebi)
    {
        $konu = 'Burs Başvuru Onayınız Reddedilmistir.';
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu reddedilmistir. <div> </div> <h4> Gerekce : </h4>'.$redsebebi.'<div></div> <h4> Aciklama : </h4>'.$aciklama;
        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 4;
            $user->redSebebi = $redsebebi;
            $user->redDigerAciklama = $aciklama;
            $user->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $result = $user->save();
            if ($result) {
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $user->name,
                        'sebep' => $redsebebi,
                        'aciklama' => $aciklama,
                        'surname' => $user->surname,
                    ];

                        $slug = null;
                        if (!empty($redsebebi)) {
                            $proposedSlug = 'aday-burs-ret-' . Str::slug($redsebebi);
                            if (MessageTemplate::where('slug', $proposedSlug)->exists()) {
                                $slug = $proposedSlug;
                            }
                        }

                        if (!$slug) {
                            if (MessageTemplate::where('slug', 'aday-burs-ret-diger')->exists()) {
                                    $slug = 'aday-burs-ret-diger';
                            } else {
                                    $slug = 'aday-reddedildi';
                            }
                        }

                        $this->mailController->sendTemplateEmail(
                            $slug,
                            $user->email,
                            'Burs Başvurunuz Reddedilmistir',
                            $parameters
                        );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Aday reddedilme mail gönderim hatası: '.$e->getMessage());
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function ignoreRenew($id, $aciklama, $redsebebi)
    {
        $konu = 'Kayit Yenileme Formunuz Reddedilmistir.';
        $icerik = 'icerik metni buraya gelecek. deneme amacli kayit yenileme basvurusu reddedilmistir. <div> </div> <h4> Gerekce : </h4>'.$redsebebi.'<div></div> <h4> Aciklama : </h4>'.$aciklama;
        $user = RenewForm::find($id);
        $scholar = Scholar::find($user->scholar_id);
        if ($user) {
            RenewForm::where('id', $id)->update([
                'status' => 0,
            ]);
            RenewAnswer::where('form_id', $id)->update([
                'status' => 4,
            ]);
            $result = RenewForm::where('scholar_id', $user->scholar_id)->update([
                'status' => 2,
                'redSebebi' => $redsebebi,
                'redDigerAciklama' => $aciklama,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            if ($result) {
                $scholar->status = 4;
                $scholar->save();
                // Yeni template sistemi ile mail gönder
                try {
                    $parameters = [
                        'name' => $scholar->name,
                        'sebep' => $redsebebi,
                        'aciklama' => $aciklama,
                        'surname' => $scholar->surname,
                    ];

                    $this->mailController->sendTemplateEmail(
                        'kayit-yenileme-reddedildi',
                        $scholar->email,
                        'Kayıt Yenileme Başvurunuz Reddedilmiştir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Kayıt yenileme reddedilme mail gönderim hatası: '.$e->getMessage());
                }

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function confirmRenew($id)
    {
        $konu = 'Kayit Yenileme Formunuz Kabul Edilmiştir';
        $icerik = 'icerik metni buraya gelecek. Kayit Yenileme Formunuz Kabul Edilmiştir.';

        $user = Scholar::find($id);
        if ($user) {
            $user->status = 1;
            $user->save();
            $result = RenewForm::where('scholar_id', $id)->update([
                'status' => 1,
                'islemi_yapan' => Auth::user()->name.' '.Auth::user()->surname,
            ]);
            if ($result) {
                $this->kullaniciBilgilendir($user->email, $icerik, $konu);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function kayitYenilemeSonuclandir($scholarid, $status)
    {
        $result = 0;
        $scholar = RenewForm::find($scholarid);
        $scholar_id = $scholar->scholar_id;
        if ($scholar->status != intval($status)) {
            $scholar->status = intval($status);
            $scholar->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $result = $scholar->save();
            RenewAnswer::where('form_id', $scholar->id)->update([
                'status' => 3,
            ]);
        }
        switch ($status) {
            case '1':
                $this->transferRenewToActiveDatas($scholar_id);
                $konu = 'Kayit Yenileme Onaylanmistir.';
                $icerik = 'icerik metni buraya gelecek. deneme amacli ky basvursu kabul edilmistir.';
                break;
        }
        if ($result) {

            $email = Scholar::find($scholar->scholar_id);

            // Yeni template sistemi ile mail gönder
            try {
                $parameters = [
                    'name' => $email->name,
                    'surname' => $email->surname,
                ];

                $this->mailController->sendTemplateEmail(
                    'kayit-yenileme-onaylandi',
                    $email->email,
                    'Kayit Yenileme Formunuz Kabul Edilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme onayı mail gönderim hatası: '.$e->getMessage());
            }
            $this->ortak->addNewTimeline($email->tc_no, 'Kayıt  Yenileme Onaylandı', 'Kayıt  Yenileme Onaylandı', Auth::user()->name.' '.Auth::user()->surname.' tarafından onaylandı');

            session()->flash('success', 'Kayıt Yenileme Onaylandı!');

        }

        return redirect()->back();
    }

    public function transferRenewToActive($renewModelClass, $activeModelClass, $scholar_id)
    {
        // İlgili scholar'ı bul
        $scholar = Scholar::find($scholar_id);
        if (! $scholar) {
            return 'Scholar not found.';
        }

        // Scholar'a ait RenewForm'u bul
        $renewForm = RenewForm::where('scholar_id', $scholar_id)->first();
        if (! $renewForm) {
            return 'No matching RenewForm found for the given Scholar.';
        }

        // RenewForm'a bağlı RenewAnswer'ı bul
        $renewAnswer = $renewModelClass::where('form_id', $renewForm->id)->first();
        if (! $renewAnswer) {
            return 'No matching RenewAnswer found for the given RenewForm.';
        }
        $bursiyer = Scholar::find($scholar_id);
        $bursiyer->status = 1;
        $bursiyer->save();
        // Active formunu scholar_id üzerinden bul
        $activeForm = ScholarForm::where('scholar_id', $scholar_id)->first();

        if (! $activeForm) {
            $item = new ScholarForm;
            $item->scholar_id = $scholar_id;
            $item->status = 3;
            $item->islemi_yapan = Auth::user()->name.' '.Auth::user()->surname;
            $item->period_id = Period::where('type', 1)->latest()->first()->id;
            $item->save();
            $activeForm = $item;
        }

        // Active formuna bağlı info modelini bul veya oluştur
        $activeInfo = $activeModelClass::where('form_id', $activeForm->id)->first();
        if (! $activeInfo) {
            $activeInfo = new $activeModelClass;
        }
        $renewAnswer = $renewAnswer->toArray();
        unset($renewAnswer['id']);
        // Tüm alanları yenile
        $activeInfo->fill($renewAnswer);
        $activeInfo->form_id = $activeForm->id; // Güncellenen form_id'yi ayarla

        DB::transaction(function () use ($activeInfo) {
            $activeInfo->save();
        });

        return 'Information transferred successfully.';
    }

    public function doctransferRenewToActive($renewModelClass, $activeModelClass, $scholar_id)
    {
        // İlgili scholar'ı bul
        $scholar = Scholar::find($scholar_id);

        if (! $scholar) {
            return 'Scholar not found.';
        }

        // Scholar'a ait tüm RenewForm kayıtlarını bul
        $renewForms = RenewForm::where('scholar_id', $scholar_id)->get();

        if ($renewForms->isEmpty()) {
            return 'No matching RenewForm found for the given Scholar.';
        }

        foreach ($renewForms as $renewForm) {
            // Her bir RenewForm'a bağlı info modelini bul
            $renewInfos = $renewModelClass::where('form_id', $renewForm->id)->get();

            foreach ($renewInfos as $renewInfo) {
                // ActiveForm'u bul
                $activeForm = ScholarForm::where('scholar_id', $scholar_id)->first();

                if (! $activeForm) {
                    continue; // Eğer ActiveForm bulunamazsa bu döngüyü atla
                }

                // İlgili ActiveDocuments kaydını bul veya yeni bir kayıt oluştur
                $activeInfo = $activeModelClass::firstOrNew(['form_id' => $activeForm->id, 'name' => $renewInfo->name]);

                // 'id' alanını hariç tutarak diğer alanları yenile
                $data = $renewInfo->toArray();
                unset($data['id']);
                $activeInfo->fill($data);

                $activeInfo->form_id = $activeForm->id; // Güncellenen form_id'yi ayarla

                DB::transaction(function () use ($activeInfo) {
                    $activeInfo->save();
                });
            }

        }

        return 'Information transferred successfully.';
    }

    public function transferRenewToActiveDatas($scholar_id)
    {

        return $this->transferRenewToActive(RenewAnswer::class, ActiveAnswer::class, $scholar_id);
        /*$this->transferRenewToActive(RenewParentInfo::class, ActiveParentInfo::class,$scholar_id);
        $this->transferRenewToActive(RenewPersonalnfo::class, ActivePersonalnfo::class,$scholar_id);
        $this->transferRenewToActive(RenewSiblingDetails::class, ActiveSiblingDetails::class,$scholar_id);
        $this->transferRenewToActive(RenewSiblingInfos::class, ActiveSiblingInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewSocialInfos::class, ActiveSocialInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewBankInfos::class, ActiveBankInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewEducationalInfo::class, ActiveEducationalInfo::class,$scholar_id);
        $this->transferRenewToActive(RenewFamilyInfos::class, ActiveFamilyInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewHousingInformation::class, ActiveHousingInformation::class,$scholar_id);
        $this->transferRenewToActive(RenewIncomeInfos::class, ActiveIncomeInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewJobInfos::class, ActiveJobInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewObstacledInfos::class, ActiveObstacledInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewOtherScholarshipInfos::class, ActiveOtherScholarshipInfos::class,$scholar_id);
        $this->transferRenewToActive(RenewOtherScholarshipDetails::class, ActiveOtherScholarshipDetails::class,$scholar_id);
        $this->doctransferRenewToActive(RenewDocuments::class, ActiveDocuments::class,$scholar_id);*/
    }

    public function kullaniciBilgilendir($email, $icerik, $konu)
    {
        $this->mailController->sendMail($email, $konu, 'mailtemplates.generic', ['content' => $icerik]);
    }

    public function adayEkle()
    {
        $bankNames = Soru::getBankNames();
        $belgeler = Soru::where('type', 'file')
            ->get();
        $unis = TanimUnivercity::all();
        $result = [
            'bankNames' => $bankNames,
            'belgeler' => $belgeler,
            'formType' => 'aday',
            'unis' => $unis,
            'title' => 'Yeni Aday Bursiyer Ekle',
            'period' => Period::with('documents')->where('type', 0)->latest()->first(),
            'cities' => Il::all(),
            'documents' => $this->studentController->belgeadlarigetir(),
        ];

        return view('panel.add-scholarship-manuel.index', $result);
    }

    public function bursiyerekle()
    {
        $belgeler = Soru::where('type', 'file')->get();
        $bankNames = Soru::getBankNames();
        $unis = TanimUnivercity::all();
        $result = [
            'belgeler' => $belgeler,
            'formType' => 'aktif',
            'title' => 'Bursiyer Ekle',
            'period' => Period::where('type', 0)->latest()->first(),
            'bankNames' => $bankNames,
            'cities' => Il::all(),
            'documents' => $this->studentController->belgeadlarigetir(),
            'unis' => $unis,
        ];

        return view('panel.add-activescholarship-manuel',$result);
    }

    public function checkResult($result)
    {
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }
    }
}
