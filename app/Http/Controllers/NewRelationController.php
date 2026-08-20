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
use App\Models\MessageTemplate;
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
use App\Models\TanimBursTipi;
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
use Illuminate\Support\Facades\Cache;
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

    /**
     * Timeline kayıtlarında işlem yapan panel kullanıcısı (ad soyad).
     */
    private function timelineIslemYapan(): string
    {
        $u = Auth::user();

        return $u ? trim($u->name . ' ' . $u->surname) : 'Sistem';
    }

    /**
     * Açıklama metnine işlem yapan bilgisini ekler.
     */
    private function timelineMetin(string $aciklama): string
    {
        return sprintf('%s — İşlem yapan: %s', $aciklama, $this->timelineIslemYapan());
    }

    public function deneme()
    {
    }

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
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
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

                    Log::info('basvuruAdayiReddet.mail_template_request', [
                        'tc_no' => $tc_no,
                        'redSebebi' => $redSebebi,
                        'scenario' => MessageTemplate::SCENARIO_ADAY_RED,
                    ]);

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
                    \Log::error('Aday reddedilme mail gönderim hatası: ' . $e->getMessage());
                }
                aday_timeline_log(
                    $tc_no,
                    'Burs Başvurusu',
                    'Başvuru reddedildi',
                    $this->timelineMetin(($request->input('redAciklamasi') ?? '') . ' açıklaması ile başvuru reddedildi.')
                );
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
            'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
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

                MessageTemplate::sendForSebepReason(
                    $this->mailController,
                    MessageTemplate::SCENARIO_KY_RED,
                    $redSebebi,
                    $user->scholar->email,
                    'Kayıt Yenileme Başvurunuz Reddedilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme reddedilme mail gönderim hatası: ' . $e->getMessage());
            }
            session()->flash('success', 'İşlem Başarılı!');
            aday_timeline_log(
                $user->scholar->tc_no,
                'Kayıt Yenileme',
                'KY başvurusu reddedildi',
                $this->timelineMetin('Gerekçe: ' . $redSebebi . '. Açıklama: ' . $redAciklamasi . '.')
            );

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
            $iadeDigerAciklama = $request->input('iadeAciklama') ?? $request->input('iadeDigerAciklama');
            $result = NewAnswer::where('tc_no', $tc_no)->update([
                'status' => 2,
                'iadeSebebi' => $iadeSebebi,
                'iadeAciklamasi' => $iadeDigerAciklama,
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
            ]);
            if ($result) {
                session()->flash('success', 'İşlem Başarılı!');
                aday_timeline_log(
                    $tc_no,
                    'Burs Başvurusu',
                    'Başvuru iade edildi',
                    $this->timelineMetin(($request->input('iadeAciklama') ?? '') . ' açıklaması ile başvuru iade edildi.')
                );
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
                    \Log::error('Aday iade mail gönderim hatası: ' . $e->getMessage());
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
        $iadeDigerAciklama = $request->input('iadeAciklama') ?? $request->input('iadeDigerAciklama');
        Scholar::where('id', $user->scholar->id)->update([
            'status' => 2,
        ]);
        $result = RenewForm::where('id', $form_id)->update([
            'status' => 3,
            'iadeSebebi' => $iadeSebebi,
            'iadeDigerAciklama' => $iadeDigerAciklama,
            'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
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

                MessageTemplate::sendForSebepReason(
                    $this->mailController,
                    MessageTemplate::SCENARIO_KY_IADE,
                    $iadeSebebi,
                    $user->scholar->email,
                    'Kayıt Yenileme Süreciniz İade Edilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('KY iade mail gönderim hatası: ' . $e->getMessage());
            }
            aday_timeline_log(
                $user->scholar->tc_no,
                'Kayıt Yenileme',
                'KY başvurusu iade edildi',
                $this->timelineMetin(($iadeDigerAciklama ?? '') . ' açıklaması ile kayıt yenileme başvurusu iade edildi.')
            );
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
                            'message' => 'Puan hesaplama hatası: ' . $e->getMessage(),
                        ];
                        \Log::error("Toplu puan hesaplama hatası - Aday ID: {$id}, Hata: " . $e->getMessage());
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
            if (!is_array($userIds)) {
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
                $sheet->setCellValue($column . '1', $header);
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
                    $sheet->setCellValue('A' . $row, $data->id);
                    $sheet->setCellValue('B' . $row, $data->name);
                    $sheet->setCellValue('C' . $row, $data->surname);
                    $sheet->setCellValue('D' . $row, $data->tc_no);
                    $sheet->setCellValue('E' . $row, $data->tel_no);
                    $sheet->setCellValue('F' . $row, $status);
                    $sheet->setCellValue('G' . $row, $data->redSebebi);
                    $sheet->setCellValue('H' . $row, $data->email);
                    $sheet->setCellValue('I' . $row, $data->b_dob);
                    $sheet->setCellValue('J' . $row, $data->registered_city);
                    $sheet->setCellValue('K' . $row, $data->registered_district);
                    $sheet->setCellValue('L' . $row, $data->birth_city);
                    $sheet->setCellValue('M' . $row, $data->birth_district);
                    $sheet->setCellValue('N' . $row, $data->gender);
                    $sheet->setCellValue('O' . $row, $data->maritality);
                    $sheet->setCellValue('P' . $row, $data->nationality);
                    $sheet->setCellValue('Q' . $row, $data->school_type);
                    $sheet->setCellValue('R' . $row, $data->p_school_name);
                    $sheet->setCellValue('S' . $row, $data->p_school_city);
                    $sheet->setCellValue('T' . $row, $data->class);
                    $sheet->setCellValue('U' . $row, $data->student_number);
                    $sheet->setCellValue('V' . $row, $data->grade_avg);
                    $sheet->setCellValue('W' . $row, $data->is_transfered);
                    $sheet->setCellValue('X' . $row, $data->m_school_name);
                    $sheet->setCellValue('Y' . $row, $data->m_school_city);
                    $sheet->setCellValue('Z' . $row, $data->m_school_district);
                    $sheet->setCellValue('AA' . $row, $data->h_school_name);
                    $sheet->setCellValue('AB' . $row, $data->h_school_city);
                    $sheet->setCellValue('AC' . $row, $data->h_school_district);
                    $sheet->setCellValue('AD' . $row, $data->grade_high_school);
                    $sheet->setCellValue('AE' . $row, $data->entry_grade_university);
                    $sheet->setCellValue('AF' . $row, $data->university_city);
                    $sheet->setCellValue('AG' . $row, $data->current_university);
                    $sheet->setCellValue('AH' . $row, $data->university_faculty);
                    $sheet->setCellValue('AI' . $row, $data->grade_departmant);
                    $sheet->setCellValue('AJ' . $row, $data->university_type);
                    $sheet->setCellValue('AK' . $row, $data->university_class);
                    $sheet->setCellValue('AL' . $row, $data->university_educ_time);
                    $sheet->setCellValue('AM' . $row, $data->agnoSystem);
                    $sheet->setCellValue('AN' . $row, $data->agno);
                    $sheet->setCellValue('AO' . $row, $data->university_transfer);
                    $sheet->setCellValue('AP' . $row, $data->university_transfer_desc);
                    $sheet->setCellValue('AQ' . $row, $data->languages);
                    $sheet->setCellValue('AR' . $row, $data->grade_university);
                    $sheet->setCellValue('AS' . $row, $data->grade_departmant);
                    $sheet->setCellValue('AT' . $row, $data->masterUniversity);
                    $sheet->setCellValue('AU' . $row, $data->master_field);
                    $sheet->setCellValue('AV' . $row, $data->grade_agno);
                    $sheet->setCellValue('AW' . $row, $data->housing_type);
                    $sheet->setCellValue('AX' . $row, $data->housing_fee);
                    $sheet->setCellValue('AY' . $row, $data->living_with_count);
                    $sheet->setCellValue('AZ' . $row, $data->residing_city);
                    $sheet->setCellValue('BA' . $row, $data->residing_district);
                    $sheet->setCellValue('BB' . $row, $data->address_detail);
                    $sheet->setCellValue('BC' . $row, $data->mother_city);
                    $sheet->setCellValue('BD' . $row, $data->mother_district);
                    $sheet->setCellValue('BE' . $row, $data->father_city);
                    $sheet->setCellValue('BF' . $row, $data->father_district);
                    $sheet->setCellValue('BG' . $row, $data->parent_address);
                    $sheet->setCellValue('BH' . $row, $data->parent_mobile);
                    $sheet->setCellValue('BI' . $row, $data->parent_phone);
                    $sheet->setCellValue('BJ' . $row, $data->parent_email);
                    $sheet->setCellValue('BK' . $row, $data->emergency_person_name);
                    $sheet->setCellValue('BL' . $row, $data->emergency_person_surname);
                    $sheet->setCellValue('BM' . $row, $data->emergency_person_phone);
                    $sheet->setCellValue('BN' . $row, $data->emergency_closeness);
                    $sheet->setCellValue('BO' . $row, $data->emergency_person_email);
                    $sheet->setCellValue('BP' . $row, $data->parent_together);
                    $sheet->setCellValue('BQ' . $row, $data->mother_alive);
                    $sheet->setCellValue('BR' . $row, $data->mother_name);
                    $sheet->setCellValue('BS' . $row, $data->mother_surname);
                    $sheet->setCellValue('BT' . $row, $data->father_name);
                    $sheet->setCellValue('BU' . $row, $data->father_surname);
                    $sheet->setCellValue('BV' . $row, $data->mother_job);
                    $sheet->setCellValue('BW' . $row, $data->father_job);
                    $sheet->setCellValue('BX' . $row, $data->mother_educ);
                    $sheet->setCellValue('BY' . $row, $data->father_educ);
                    $sheet->setCellValue('BZ' . $row, $data->mother_company);
                    $sheet->setCellValue('CA' . $row, $data->father_company);
                    $sheet->setCellValue('CB' . $row, $data->count);
                    $sheet->setCellValue('CC' . $row, $data->educ_count);
                    $sheet->setCellValue('CD' . $row, $data->income_person);
                    $sheet->setCellValue('CE' . $row, $data->total_person);
                    $sheet->setCellValue('CF' . $row, $data->mother_salary);
                    $sheet->setCellValue('CG' . $row, $data->father_salary);
                    $sheet->setCellValue('CH' . $row, $data->other_salary);
                    $sheet->setCellValue('CI' . $row, $data->other_income);
                    $sheet->setCellValue('CJ' . $row, $data->parent_housing_type);
                    $sheet->setCellValue('CK' . $row, $data->rent_count);
                    $sheet->setCellValue('CL' . $row, $data->other_detail);
                    $sheet->setCellValue('CM' . $row, $data->government);
                    $sheet->setCellValue('CN' . $row, $data->special);
                    $sheet->setCellValue('CO' . $row, $data->disabled_status);
                    $sheet->setCellValue('CP' . $row, $data->disabled_detail);
                    $sheet->setCellValue('CQ' . $row, $data->platform);
                    $sheet->setCellValue('CR' . $row, $data->skills);
                    $sheet->setCellValue('CS' . $row, $data->social_projects);
                    $sheet->setCellValue('CT' . $row, $data->hobbies);
                    $sheet->setCellValue('CU' . $row, $data->sports);
                    $sheet->setCellValue('CV' . $row, $data->last_books);
                    $sheet->setCellValue('CW' . $row, $data->message);
                    $sheet->setCellValue('CX' . $row, $data->bank_name);
                    $sheet->setCellValue('CY' . $row, $data->iban);
                    $sheet->setCellValue('CZ' . $row, $data->account_number);
                    $sheet->setCellValue('DA' . $row, $data->is_working);
                    $sheet->setCellValue('DB' . $row, $data->job_company);
                    $sheet->setCellValue('DC' . $row, $data->job_rank);
                    $sheet->setCellValue('DD' . $row, $data->job_sgk);
                    $sheet->setCellValue('DE' . $row, $data->job_salary);
                    $sheet->setCellValue('DF' . $row, $this->getBelgeDurum($data->doc_ogrenciBelgesi));
                    $sheet->setCellValue('DG' . $row, $this->getBelgeDurum($data->doc_adlisicilkaydi));
                    $sheet->setCellValue('DH' . $row, $this->getBelgeDurum($data->doc_nufuskayitornegi));
                    $sheet->setCellValue('DI' . $row, $this->getBelgeDurum($data->doc_annegelirbelgesi));
                    $sheet->setCellValue('DJ' . $row, $this->getBelgeDurum($data->doc_babagelirbelgesi));
                    $sheet->setCellValue('DK' . $row, $this->getBelgeDurum($data->doc_taahhutname));
                    $sheet->setCellValue('DL' . $row, $this->getBelgeDurum($data->doc_kimlik));
                    $sheet->setCellValue('DM' . $row, $this->getBelgeDurum($data->doc_bankahesap));
                    $sheet->setCellValue('DN' . $row, $this->getBelgeDurum($data->doc_transkript));
                    $sheet->setCellValue('DO' . $row, $this->getBelgeDurum($data->doc_ikametgah));
                    $sheet->setCellValue('DP' . $row, $this->getBelgeDurum($data->doc_karne));
                    $sheet->setCellValue('DQ' . $row, $this->getBelgeDurum($data->doc_diger));
                    $sheet->setCellValue('DR' . $row, $data->totalPoints);
                    $sheet->setCellValue('DS' . $row, $data->mulakat_durumu);
                    $row++;
                }
            }

            // Excel dosyasını oluştur
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Aday_Bursiyerler_' . time() . '.xlsx';
            $filePath = storage_path('app/public/temp/' . $fileName);

            // Temp klasörünü kontrol et
            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            // Dosyayı kaydet
            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: ' . $e->getMessage());
            \Log::error('userIds: ' . print_r($userIds, true)); // Debug için

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

        if (!$period) {
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
                        if ($scholarForm->scholar_id == $activeScholar->id && !is_null($scholarForm->infos)) {
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
                            if (!$item) {
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
                    aday_timeline_log(
                        $bursiyer->tc_no,
                        'Kayıt Yenileme',
                        'KY dönemi başlatıldı',
                        $this->timelineMetin('Kayıt yenileme süreci açıldı; form oluşturuldu ve bilgilendirme süreci başlatıldı.')
                    );
                    // Email kontrolü ekle
                    if ($activeScholar->email) {
                        $email = trim($activeScholar->email);
                        try {
                            Log::info('mail gonderimi basladi');
                            // Yeni template sistemi ile mail gönder
                            try {
                                $parameters = [
                                    'name' => $activeScholar->name,
                                    'surname' => $activeScholar->surname,
                                    'email' => $email,
                                    'password' => $password,
                                ];

                                $this->mailController->sendTemplateEmail(
                                    'kayit-yenileme-donemi-basladi',
                                    $email,
                                    'Kayıt Yenileme Döneminiz Açıldı',
                                    $parameters
                                );
                            } catch (\Exception $e) {
                                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                                \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: ' . $e->getMessage());
                            }
                            Log::info('mail gonderildi');
                        } catch (\Exception $e) {
                            // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                            \Log::error('Mail gönderimi hatası: ' . $e->getMessage(), [
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

    private function resolveFormId($id)
    {
        if (!$id) {
            return null;
        }

        // 1. Önce doğrudan RenewForm id'si mi kontrol et
        $form = RenewForm::find($id);
        if ($form) {
            return $form->id;
        }

        // 2. Değilse, RenewAnswer'ın id'si veya form_id'si mi kontrol et
        $answer = RenewAnswer::where('id', $id)->orWhere('form_id', $id)->first();
        if ($answer && $answer->form_id) {
            return $answer->form_id;
        }

        return $id;
    }

    public function kytopluIslemYonet(Request $request)
    {
        $userIds = $request->input('userIds', []); // Kullanıcı ID'leri
        $islemId = $request->input('islemId'); // İşlem ID'si
        $result = false;

        if (empty($userIds) || !is_array($userIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Seçili kayıt bulunamadı.'
            ], 400);
        }

        switch ($islemId) {
            case 0:
                $redSebebi = $request->input('redSebebi');
                $aciklama = $request->input('digerAciklama');
                foreach ($userIds as $id) {
                    $formId = $this->resolveFormId($id);
                    if ($formId) {
                        $result = $this->ignoreRenew($formId, $aciklama, $redSebebi);
                    }
                }
                break;
            case 1:
                foreach ($userIds as $id) {
                    $formId = $this->resolveFormId($id);
                    if ($formId) {
                        $result = $this->kayitYenilemeSonuclandir($formId, 1);
                    }
                }
                break;
            case 2:
                $iadeSebebi = $request->input('iadeSebebi');
                $aciklama = $request->input('iadeDigerAciklama');
                foreach ($userIds as $id) {
                    $formId = $this->resolveFormId($id);
                    if ($formId) {
                        $result = $this->returnRenew($formId, $aciklama, $iadeSebebi);
                    }
                }
                break;
            case 3:
                foreach ($userIds as $id) {
                    $formId = $this->resolveFormId($id);
                    if ($formId) {
                        $result = $this->deleterenewrelations($formId);
                    }
                }
                break;
            case 5:
                foreach ($userIds as $id) {
                    $formId = $this->resolveFormId($id);
                    if ($formId) {
                        $result = $this->sifreYenileKY($formId);
                    }
                }
                break;
        }

        // İsteğin başarılı olduğunu döndürüyoruz
        return response()->json([
            'data' => $userIds,
            'islemId' => $islemId,
            'result' => $result,
            'message' => 'İşlem Başarıyla Gerçekleştirildi',
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
        // Giriş (StudentAuthController) scholars.email + md5 şifre ile yapılıyor; maildeki adres
        // renew form (infos) ile aynı olmalı — aksi halde kullanıcı maile yazdığı e-posta ile giremez.
        if ($aday->infos && !empty(trim((string) $aday->infos->email))) {
            $scholar->email = trim($aday->infos->email);
        }
        $scholar->password = md5($password);
        $result = $scholar->save();
        // Email kontrolü ekle
        if ($result && $aday->infos && !empty(trim((string) $aday->infos->email))) {
            $email = trim($aday->infos->email);
            try {
                $this->mailController->sendMailWithBlade(
                    $email,
                    'Giriş Şifreniz Güncellenmiştir.',
                    'mailtemplates.sifrekayityenileme',
                    [
                        'ad' => $aday->infos->name,
                        'soyad' => $aday->infos->surname,
                        'email' => $email,
                        'password' => $password,
                    ]
                );
                Log::info('mail gonderildi', [
                    'scholar_id' => $aday->scholar_id,
                    'email' => $email,
                    'password' => $password,
                ]);

                return true;
            } catch (\Exception $e) {
                // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                \Log::error('Mail gönderimi hatası: ' . $e->getMessage(), [
                    'scholar_id' => $aday->scholar_id,
                    'email' => $email,
                ]);
            }
        } else {
            // Email olmayan bursiyerleri loglayabilirsiniz
            \Log::warning('Bursiyerin email adresi yok', [
                'scholar_id' => $aday->scholar_id,
                'name' => $aday->infos?->name,
                'surname' => $aday->infos?->surname,
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
        $scholar->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
        $scholar->save();
        $form = Scholar::find($scholar->scholar_id);
        $form->status = 1;
        $result = $form->save();
        if ($result) {
            aday_timeline_log(
                $form->tc_no,
                'Bursiyer Durumu',
                'Mezundan aktife çekildi',
                $this->timelineMetin('Mezuniyet durumu geri alındı; bursiyer tekrar aktif olarak güncellendi.')
            );
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
        $form->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
        $form->status = 4;
        $form->save();
        $result = $scholar->save();
        if ($result) {
            // Yeni template sistemi ile mail gönder
            try {
                $email = trim($scholar->email);
                $parameters = [
                    'name' => $scholar->name,
                    'surname' => $scholar->surname,
                ];

                $this->mailController->sendTemplateEmail(
                    'bursiyerlik-iptal',
                    $email,
                    'Bursiyerliğiniz İptal Edilmiştir',
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Bursiyerlik iptal mail gönderim hatası: ' . $e->getMessage());
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
            aday_timeline_log(
                $scholar->tc_no,
                'Bursiyer Durumu',
                'Mezuniyet',
                $this->timelineMetin('Bursiyer mezun olarak işaretlendi.')
            );
            session()->flash('success', 'İşlem Başarılı!');
            $email = trim($scholar->email);
            $parameters = [
                'name' => $scholar->name,
                'surname' => $scholar->surname,
            ];
            $this->mailController->sendTemplateEmail(
                'mezun-etme-mesaji',
                $email,
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
            $adayPath = 'bursiyerler/' . $scholar_id;
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
        $bilgiler = $form ? RenewAnswer::where('form_id', $form->id)->first() : RenewAnswer::where('id', $id)->first();
        if (!$form && !$bilgiler) {
            return redirect()->route('kayityenileme');
        }

        $formId = $form ? $form->id : ($bilgiler ? $bilgiler->form_id : $id);
        $scholar_id = $form ? $form->scholar_id : null;

        $pathsToDelete = array_unique(array_filter([
            'uploads/kayitYenilemeler/' . $formId,
            'uploads/kayityenilemeler/' . $formId,
            $scholar_id ? 'uploads/kayitYenilemeler/' . $scholar_id : null,
            $scholar_id ? 'uploads/kayityenilemeler/' . $scholar_id : null,
        ]));

        foreach ($pathsToDelete as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->deleteDirectory($path);
            }
        }

        if ($bilgiler) {
            foreach ($bilgiler->getAttributes() as $key => $value) {
                if (str_starts_with($key, 'doc_') && $value) {
                    $filePath = str_replace('/storage/', '', $value);
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
            $bilgiler->delete();
        }

        if ($form) {
            $form->delete();
        }

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

    private function aktifTopluIndirHeaders(): array
    {
        return [
            'Başvuru No',
            'Toplam Puan',
            'Ad',
            'Soyad',
            'TC No',
            'Öğrenim Tipi',
            'Cep Telefonu',
            'Başvuru Durumu',
            'Bursiyer Durumu',
            'Bursiyer Tipi',
            'Burs Tipi',
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
            'Birlikte Yaşanılan Kişi Sayısı',
            'Kaldığı İl',
            'Kaldığı İlçe',
            'Tam Adres',
            'Annenin Yaşadığı İl',
            'Annenin Yaşadığı İlçe',
            'Babanın Yaşadığı İl',
            'Babanın Yaşadığı İlçe',
            'Açık Adres',
            'Aile Cep Telefonu',
            'Aile Ev Telefonu',
            'Aile E-posta Adresi',
            'Acil Durum Kişisi Ad',
            'Acil Durum Kişisi Soyad',
            'Acil Durum Kişisi Telefonu',
            'Acil Durum Kişisi Yakınlık Derecesi',
            'Anne Baba Birlikte Mi?',
            'Anne Baba Sağ Mı?',
            'Anne Ad',
            'Anne Soyad',
            'Baba Ad',
            'Baba Soyad',
            'Anne Meslek',
            'Baba Meslek',
            'Anne Tahsil Durumu',
            'Baba Tahsil Durumu',
            'Anne Bağlı Olduğu Sosyal Güvenlik Kurumu',
            'Baba Bağlı Olduğu Sosyal Güvenlik Kurumu',
            'Kardeş Sayısı',
            'Kendisi Dahil Okuyan Kardeş Sayısı',
            'Ailenin Geçimini Kim/Kimler Sağlıyor?',
            'Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?',
            'Annenin Aylık Net Geliri (TL)',
            'Babanın Aylık Net Geliri (TL)',
            'Diğer Kişilerin Aylık Net Geliri (TL)',
            'Ailenin Başka Geliri Var Mı?',
            'Ailenin Yaşamakta Olduğu Ev Türü',
            'Kira ise Aylık Net Kirası (TL)',
            'Diğer Gelir Bilgisi',
            'Devlet Bursu Almakta mı ya da Başvurdu mu?',
            'Özel Burs Almakta ya da Başvurdu mu?',
            'Herhangi Bir Engeliniz Var mı?',
            'Engel Durumunu Açıklayınız (Varsa)',
            'Bizden Nasıl Haberdar Oldunuz?',
            'Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz?',
            'Katkıda Bulunduğunuz Sosyal Projeler',
            'Hobileriniz',
            'İlgilendiğiniz Spor Dalı (Varsa)',
            'Son Okuduğunuz Kitaplar',
            'Bize Mesajınız',
            'Banka',
            'IBAN',
            'Hesap Numarası',
            'Düzenli olarak bir kurumda kazanç sağlıyor mu?',
            'Kurum Adı',
            'Görev',
            'Sosyal Güvenlik Kurumu',
            'Aylık Net Ücret (TL)',
            'Öğrenci Belgesi',
            'Adli Sicil Kaydı',
            'Nüfus Kayıt Örneği',
            'Anne Gelir Belgesi',
            'Baba Gelir Belgesi',
            'Taahhütname',
            'Kimlik',
            'Banka Hesap',
            'Transkript',
            'İkametgah',
            'Karne',
            'Diğer',
            'Mülakat Durumu',
        ];
    }

    /**
     * Kayıt yenileme / aday geniş export ile aynı sütun düzeni (aktif bursiyer ActiveAnswer satırı).
     *
     * @param  object  $data  json_decode ile gelen active_answers toArray (+ burs_tipi)
     */
    private function writeWideScholarExportRowFromObject(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $rowNum, object $data): void
    {
        $status = 'Belirsiz';
        switch ((int) ($data->status ?? -1)) {
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

        $bursDurumuRaw = $data->burs_durumu ?? null;
        $bursDurumu = 'Belirsiz';
        if ($bursDurumuRaw == 1 || $bursDurumuRaw == 2) {
            $bursDurumu = 'Aktif Bursiyer';
        } elseif ($bursDurumuRaw == 4) {
            $bursDurumu = 'Pasif Bursiyer';
        } elseif ($bursDurumuRaw == 3) {
            $bursDurumu = 'Mezun';
        }

        $adayTuruRaw = $data->aday_turu ?? '';
        $bursiyerTipi = '';
        if ($adayTuruRaw !== null && $adayTuruRaw !== '') {
            $map = [
                '0' => 'Dernek',
                '1' => 'Vakıf',
                '2' => 'Boş',
                0 => 'Dernek',
                1 => 'Vakıf',
                2 => 'Boş',
            ];
            $bursiyerTipi = $map[$adayTuruRaw] ?? (string) $adayTuruRaw;
        }

        $bursTipiAdi = '';
        if (isset($data->burs_tipi) && is_object($data->burs_tipi)) {
            $bursTipiAdi = $data->burs_tipi->burs_tipi ?? '';
        } elseif (isset($data->burs_tipi) && is_array($data->burs_tipi)) {
            $bursTipiAdi = $data->burs_tipi['burs_tipi'] ?? '';
        }

        $totalPoints = $data->totalPoints ?? $data->total_points ?? '';
        $educationType = $data->educationType ?? $data->education_type ?? null;
        $bornCity = $data->born_city ?? $data->birth_city ?? '';
        $bornDistrict = $data->born_district ?? $data->birth_district ?? '';
        $primaryEduc = $data->primary_educ_type ?? $data->school_type ?? '';
        $agnoType = $data->agno_type ?? $data->agnoSystem ?? '';
        $masterUni = $data->master_university ?? $data->masterUniversity ?? '';
        $emergencyPhone = $data->emergency_mobile ?? $data->emergency_person_phone ?? '';
        $redSebebi = $data->redSebebi ?? $data->red_sebebi ?? '';

        $colIdx = 1;
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->id ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $totalPoints);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->surname ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->tc_no ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, education_type_label($educationType));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->tel_no ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $status);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $bursDurumu);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $bursiyerTipi);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $bursTipiAdi);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $redSebebi);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->email ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->b_dob ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->registered_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->registered_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $bornCity);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $bornDistrict);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->gender ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->maritality ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->nationality ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $primaryEduc);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->p_school_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->p_school_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->class ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->student_number ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_avg ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->is_transfered ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->m_school_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->m_school_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->m_school_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->h_school_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->h_school_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->h_school_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_high_school ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->entry_grade_university ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->current_university ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_faculty ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_departmant ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_type ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_class ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_educ_time ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $agnoType);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->agno ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_transfer ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->university_transfer_desc ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->languages ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_university ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_departmant ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $masterUni);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->master_field ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->grade_agno ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->housing_type ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->housing_fee ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->living_with_count ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->residing_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->residing_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->address_detail ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_city ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_district ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_address ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_mobile ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_phone ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_email ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->emergency_person_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->emergency_person_surname ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $emergencyPhone);
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->emergency_closeness ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_together ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_alive ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_surname ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_surname ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_job ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_job ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_educ ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_educ ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_company ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_company ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->educ_count ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->count ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->income_person ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->total_person ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mother_salary ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->father_salary ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->other_salary ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->other_income ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->parent_housing_type ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->rent_count ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->other_detail ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->government ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->special ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->disabled_status ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->disabled_detail ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->platform ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->skills ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->social_projects ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->hobbies ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->sports ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->last_books ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->message ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->bank_name ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->iban ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->account_number ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->is_working ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->job_company ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->job_rank ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->job_sgk ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->job_salary ?? '');
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_ogrenciBelgesi ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_adlisicilkaydi ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_nufuskayitornegi ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_annegelirbelgesi ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_babagelirbelgesi ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_taahhutname ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_kimlik ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_bankahesap ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_transkript ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_ikametgah ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_Karne ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $this->getBelgeDurum($data->doc_Diger ?? null));
        $sheet->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx++) . $rowNum, $data->mulakat_durumu ?? '');
    }

    private function collectAktifScholarExportRows(array $scholarIds, string $dosyaAdi): array
    {
        if ($scholarIds === []) {
            return [];
        }
        $status = $dosyaAdi === 'Mezunlar' ? 2 : 3;
        $scholars = Scholar::with([
            'form' => function ($query) {
                $query->with(['infos.bursTipi'])->orderBy('created_at', 'desc');
            }
        ])
            ->whereIn('id', $scholarIds)
            ->whereHas('form', function ($query) use ($status) {
                $query->whereNotNull('id')->where('status', $status);
            })
            ->get();

        $rows = [];
        foreach ($scholars as $scholar) {
            $form = $scholar->form->first();
            if (!$form || !$form->infos) {
                continue;
            }
            $form->infos->loadMissing('bursTipi');
            $rowArray = $form->infos->toArray();
            $rowArray['burs_durumu'] = $scholar->status;
            $rows[] = $rowArray;
        }

        return $rows;
    }

    public function AktifTopluIndir($userIds, $dosyaAdi)
    {
        try {
            // userIds'in dizi olduğundan emin ol
            if (!is_array($userIds)) {
                $userIds = explode(',', $userIds);
            }
            // Excel dosyası oluştur
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
            $sheet = $spreadsheet->getActiveSheet();

            $headers = $this->aktifTopluIndirHeaders();
            // Başlıkları yaz
            foreach ($headers as $key => $header) {
                $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
                $sheet->setCellValue($column . '1', $header);
            }
            $row = 2; // Data başlangıç satırı

            $status = $dosyaAdi === 'Mezunlar' ? 2 : 3;

            $scholars = Scholar::with([
                'form' => function ($query) {
                    $query->with(['infos.bursTipi'])
                        ->orderBy('created_at', 'desc');
                }
            ])
                ->whereIn('id', $userIds)
                ->whereHas('form', function ($query) use ($status) {
                    $query->whereNotNull('id')
                        ->where('status', $status);
                })
                ->get();
            foreach ($scholars as $scholar) {
                $form = $scholar->form->first();

                if ($form && $form->infos) {
                    \Log::info('Processing Scholar ID: ' . $scholar->id . ' Form ID: ' . $form->id);

                    $form->infos->loadMissing('bursTipi');
                    $rowArray = $form->infos->toArray();
                    $rowArray['burs_durumu'] = $scholar->status;
                    $data = json_decode(json_encode($rowArray));
                    $this->writeWideScholarExportRowFromObject($sheet, $row, $data);
                    $row++;
                } else {
                    \Log::warning('Form veya form bilgileri bulunamadı - Scholar ID: ' . $scholar->id);
                }
            }

            // Excel dosyasını oluştur ve kaydet
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = $dosyaAdi . '_' . time() . '.xlsx';
            $filePath = storage_path('app/public/temp/' . $fileName);

            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json(['error' => 'Excel dosyası oluşturulamadı: ' . $e->getMessage()], 500);
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
            if (!is_array($userIds)) {
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
                $sheet->setCellValue($column . '1', $header);
            }

            $row = 2; // Data başlangıç satırı
            // Her bir kullanıcı için verileri ekle
            foreach ($userIds as $id) {
                $scholar = NewAnswer::where('id', $id)->first();
                if ($scholar) {
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
                    \Log::info('KY FORM ID: ' . $id);

                    // Excel hücrelerini doldur
                    $sheet->setCellValue('A' . $row, $scholar->aday_id);
                    $sheet->setCellValue('B' . $row, $scholar->name);
                    $sheet->setCellValue('C' . $row, $scholar->surname);
                    $sheet->setCellValue('D' . $row, $scholar->tc_no);
                    $sheet->setCellValue('E' . $row, $scholar->tel_no);
                    $sheet->setCellValue('F' . $row, $status);
                    $sheet->setCellValue('G' . $row, $scholar->redSebebi);
                    $sheet->setCellValue('H' . $row, $scholar->email);
                    $sheet->setCellValue('I' . $row, $scholar->b_dob);
                    $sheet->setCellValue('J' . $row, $scholar->registered_city);
                    $sheet->setCellValue('K' . $row, $scholar->registered_district);
                    $sheet->setCellValue('L' . $row, $scholar->birth_city);
                    $sheet->setCellValue('M' . $row, $scholar->birth_district);
                    $sheet->setCellValue('N' . $row, $scholar->gender);
                    $sheet->setCellValue('O' . $row, $scholar->maritality);
                    $sheet->setCellValue('P' . $row, $scholar->nationality);
                    $sheet->setCellValue('Q' . $row, $scholar->school_type);
                    $sheet->setCellValue('R' . $row, $scholar->p_school_name);
                    $sheet->setCellValue('S' . $row, $scholar->p_school_city);
                    $sheet->setCellValue('T' . $row, $scholar->class);
                    $sheet->setCellValue('U' . $row, $scholar->student_number);
                    $sheet->setCellValue('V' . $row, $scholar->grade_avg);
                    $sheet->setCellValue('W' . $row, $scholar->is_transfered);
                    $sheet->setCellValue('X' . $row, $scholar->m_school_name);
                    $sheet->setCellValue('Y' . $row, $scholar->m_school_city);
                    $sheet->setCellValue('Z' . $row, $scholar->m_school_district);
                    $sheet->setCellValue('AA' . $row, $scholar->h_school_name);
                    $sheet->setCellValue('AB' . $row, $scholar->h_school_city);
                    $sheet->setCellValue('AC' . $row, $scholar->h_school_district);
                    $sheet->setCellValue('AD' . $row, $scholar->grade_high_school);
                    $sheet->setCellValue('AE' . $row, $scholar->entry_grade_university);
                    $sheet->setCellValue('AF' . $row, $scholar->university_city);
                    $sheet->setCellValue('AG' . $row, $scholar->current_university);
                    $sheet->setCellValue('AH' . $row, $scholar->university_faculty);
                    $sheet->setCellValue('AI' . $row, $scholar->grade_departmant);
                    $sheet->setCellValue('AJ' . $row, $scholar->university_type);
                    $sheet->setCellValue('AK' . $row, $scholar->university_class);
                    $sheet->setCellValue('AL' . $row, $scholar->university_educ_time);
                    $sheet->setCellValue('AM' . $row, $scholar->agnoSystem);
                    $sheet->setCellValue('AN' . $row, $scholar->agno);
                    $sheet->setCellValue('AO' . $row, $scholar->university_transfer);
                    $sheet->setCellValue('AP' . $row, $scholar->university_transfer_desc);
                    $sheet->setCellValue('AQ' . $row, $scholar->languages);
                    $sheet->setCellValue('AR' . $row, $scholar->grade_university);
                    $sheet->setCellValue('AS' . $row, $scholar->grade_departmant);
                    $sheet->setCellValue('AT' . $row, $scholar->masterUniversity);
                    $sheet->setCellValue('AU' . $row, $scholar->master_field);
                    $sheet->setCellValue('AV' . $row, $scholar->grade_agno);
                    $sheet->setCellValue('AW' . $row, $scholar->housing_type);
                    $sheet->setCellValue('AX' . $row, $scholar->housing_fee);
                    $sheet->setCellValue('AY' . $row, $scholar->living_with_count);
                    $sheet->setCellValue('AZ' . $row, $scholar->residing_city);
                    $sheet->setCellValue('BA' . $row, $scholar->residing_district);
                    $sheet->setCellValue('BB' . $row, $scholar->address_detail);
                    $sheet->setCellValue('BC' . $row, $scholar->mother_city);
                    $sheet->setCellValue('BD' . $row, $scholar->mother_district);
                    $sheet->setCellValue('BE' . $row, $scholar->father_city);
                    $sheet->setCellValue('BF' . $row, $scholar->father_district);
                    $sheet->setCellValue('BG' . $row, $scholar->parent_address);
                    $sheet->setCellValue('BH' . $row, $scholar->parent_mobile);
                    $sheet->setCellValue('BI' . $row, $scholar->parent_phone);
                    $sheet->setCellValue('BJ' . $row, $scholar->parent_email);
                    $sheet->setCellValue('BK' . $row, $scholar->emergency_person_name);
                    $sheet->setCellValue('BL' . $row, $scholar->emergency_person_surname);
                    $sheet->setCellValue('BM' . $row, $scholar->emergency_person_phone);
                    $sheet->setCellValue('BN' . $row, $scholar->emergency_closeness);
                    $sheet->setCellValue('BO' . $row, $scholar->emergency_person_email);
                    $sheet->setCellValue('BP' . $row, $scholar->parent_together);
                    $sheet->setCellValue('BQ' . $row, $scholar->mother_alive);
                    $sheet->setCellValue('BR' . $row, $scholar->mother_name);
                    $sheet->setCellValue('BS' . $row, $scholar->mother_surname);
                    $sheet->setCellValue('BT' . $row, $scholar->father_name);
                    $sheet->setCellValue('BU' . $row, $scholar->father_surname);
                    $sheet->setCellValue('BV' . $row, $scholar->mother_job);
                    $sheet->setCellValue('BW' . $row, $scholar->father_job);
                    $sheet->setCellValue('BX' . $row, $scholar->mother_educ);
                    $sheet->setCellValue('BY' . $row, $scholar->father_educ);
                    $sheet->setCellValue('BZ' . $row, $scholar->mother_company);
                    $sheet->setCellValue('CA' . $row, $scholar->father_company);
                    $sheet->setCellValue('CB' . $row, $scholar->count);
                    $sheet->setCellValue('CC' . $row, $scholar->educ_count);
                    $sheet->setCellValue('CD' . $row, $scholar->income_person);
                    $sheet->setCellValue('CE' . $row, $scholar->total_person);
                    $sheet->setCellValue('CF' . $row, $scholar->mother_salary);
                    $sheet->setCellValue('CG' . $row, $scholar->father_salary);
                    $sheet->setCellValue('CH' . $row, $scholar->other_salary);
                    $sheet->setCellValue('CI' . $row, $scholar->other_income);
                    $sheet->setCellValue('CJ' . $row, $scholar->parent_housing_type);
                    $sheet->setCellValue('CK' . $row, $scholar->rent_count);
                    $sheet->setCellValue('CL' . $row, $scholar->other_detail);
                    $sheet->setCellValue('CM' . $row, $scholar->government);
                    $sheet->setCellValue('CN' . $row, $scholar->special);
                    $sheet->setCellValue('CO' . $row, $scholar->disabled_status);
                    $sheet->setCellValue('CP' . $row, $scholar->disabled_detail);
                    $sheet->setCellValue('CQ' . $row, $scholar->platform);
                    $sheet->setCellValue('CR' . $row, $scholar->skills);
                    $sheet->setCellValue('CS' . $row, $scholar->social_projects);
                    $sheet->setCellValue('CT' . $row, $scholar->hobbies);
                    $sheet->setCellValue('CU' . $row, $scholar->sports);
                    $sheet->setCellValue('CV' . $row, $scholar->last_books);
                    $sheet->setCellValue('CW' . $row, $scholar->message);
                    $sheet->setCellValue('CX' . $row, $scholar->bank_name);
                    $sheet->setCellValue('CY' . $row, $scholar->iban);
                    $sheet->setCellValue('CZ' . $row, $scholar->account_number);
                    $sheet->setCellValue('DA' . $row, $scholar->is_working);
                    $sheet->setCellValue('DB' . $row, $scholar->job_company);
                    $sheet->setCellValue('DC' . $row, $scholar->job_rank);
                    $sheet->setCellValue('DD' . $row, $scholar->job_sgk);
                    $sheet->setCellValue('DE' . $row, $scholar->job_salary);
                    $sheet->setCellValue('DF' . $row, $this->getBelgeDurum($scholar->doc_ogrenciBelgesi));
                    $sheet->setCellValue('DG' . $row, $this->getBelgeDurum($scholar->doc_adlisicilkaydi));
                    $sheet->setCellValue('DH' . $row, $this->getBelgeDurum($scholar->doc_nufuskayitornegi));
                    $sheet->setCellValue('DI' . $row, $this->getBelgeDurum($scholar->doc_annegelirbelgesi));
                    $sheet->setCellValue('DJ' . $row, $this->getBelgeDurum($scholar->doc_babagelirbelgesi));
                    $sheet->setCellValue('DK' . $row, $this->getBelgeDurum($scholar->doc_taahhutname));
                    $sheet->setCellValue('DL' . $row, $this->getBelgeDurum($scholar->doc_kimlik));
                    $sheet->setCellValue('DM' . $row, $this->getBelgeDurum($scholar->doc_bankahesap));
                    $sheet->setCellValue('DN' . $row, $this->getBelgeDurum($scholar->doc_transkript));
                    $sheet->setCellValue('DO' . $row, $this->getBelgeDurum($scholar->doc_ikametgah));
                    $sheet->setCellValue('DP' . $row, $this->getBelgeDurum($scholar->doc_karne));
                    $sheet->setCellValue('DQ' . $row, $this->getBelgeDurum($scholar->doc_diger));
                    $row++; // Bir sonraki satıra geç
                }
            }

            // Excel dosyasını oluştur ve kaydet
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $fileName = 'Kayit_Yenileme_Bursiyerler_' . time() . '.xlsx';
            $filePath = storage_path('app/public/temp/' . $fileName);

            if (!file_exists(storage_path('app/public/temp'))) {
                mkdir(storage_path('app/public/temp'), 0777, true);
            }

            $writer->save($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Excel oluşturma hatası: ' . $e->getMessage());

            return response()->json(['error' => 'Excel dosyası oluşturulurken bir hata oluştu'], 500);
        }
    }

    public function kyConfirm($id)
    {
        $ky = RenewForm::where('scholar_id', $id)->first();
        $ky->status = 1;
        $ky->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
        $ky->save();
        $kyanswers = RenewAnswer::where('form_id', $ky->id)->get();
        foreach ($kyanswers as $kyanswer) {
            $kyanswer->status = 1;
            $kyanswer->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
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
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
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
                    \Log::error('Aday onaylanma mail gönderim hatası: ' . $e->getMessage());
                }

                aday_timeline_log(
                    $user->tc_no,
                    'Kayıt Yenileme',
                    'KY formu onaylandı',
                    $this->timelineMetin('Kayıt yenileme formu yönetici tarafından onaylandı.')
                );

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
            $adayPath = 'uploads/basvurular/' . $user->id;
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
        $answer = RenewAnswer::where('form_id', $id)->orWhere('id', $id)->first();

        if (!$user && $answer) {
            $user = RenewForm::where('id', $answer->form_id)->first();
        }

        if (!$user && !$answer) {
            return false;
        }

        $formId = $user ? $user->id : ($answer ? $answer->form_id : $id);
        $scholar_id = $user ? $user->scholar_id : null;
        $form_status = $user ? $user->status : null;

        $pathsToDelete = array_unique(array_filter([
            'uploads/kayitYenilemeler/' . $formId,
            'uploads/kayityenilemeler/' . $formId,
            $scholar_id ? 'uploads/kayitYenilemeler/' . $scholar_id : null,
            $scholar_id ? 'uploads/kayityenilemeler/' . $scholar_id : null,
        ]));

        foreach ($pathsToDelete as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->deleteDirectory($path);
            }
        }

        if ($answer) {
            foreach ($answer->getAttributes() as $key => $value) {
                if (str_starts_with($key, 'doc_') && $value) {
                    $filePath = str_replace('/storage/', '', $value);
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        RenewAnswer::where('form_id', $formId)->delete();
        RenewSiblingDetails::where('form_id', $formId)->delete();
        RenewOtherScholarshipDetails::where('form_id', $formId)->delete();
        RenewDocuments::where('form_id', $formId)->delete();

        if ($user) {
            $user->delete();
        }

        if ($scholar_id) {
            $scholar = Scholar::where('id', $scholar_id)->first();
            if ($scholar) {
                switch ($form_status) {
                    case '2':
                        $scholar->status = 4;
                        break;
                    default:
                        $scholar->status = 1;
                        break;
                }
                $scholar->save();
            }
        }

        return true;
    }

    public function deletenewrelation($id)
    {

        $user = NewAnswer::find($id);
        $adayPath = 'uploads/basvurular/' . $user->id;
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
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu iade edilmistir. <div> </div> <h4> Gerekce : </h4>' . $iadeSebebi . '<div></div> <h4> Aciklama : </h4>' . $aciklama;
        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 2;
            $user->iadeSebebi = $iadeSebebi;
            $user->iadeAciklamasi = $aciklama;
            $user->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
            $result = $user->save();

            if ($result) {
                // Yeni template sistemi ile mail gönder (sebep başlığına göre slug: Aday - Burs İade - {sebep})
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
                    \Log::error('Aday iade mail gönderim hatası: ' . $e->getMessage());
                }

                aday_timeline_log(
                    $user->tc_no,
                    'Burs Başvurusu',
                    'Başvuru iade edildi (toplu)',
                    $this->timelineMetin('Gerekçe: ' . $iadeSebebi . '. Açıklama: ' . $aciklama . '.')
                );

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
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu iade edilmistir. <div> </div> <h4> Gerekce : </h4>' . $iadeSebebi . '<div></div> <h4> Aciklama : </h4>' . $aciklama;
        $user = RenewForm::find($id);
        $scholar = Scholar::find($user->scholar_id);
        if ($user) {
            $result = RenewForm::where('id', $id)->update([
                'status' => 3,
                'iadeSebebi' => $iadeSebebi,
                'iadeDigerAciklama' => $aciklama,
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
            ]);
            $kyanswer = RenewAnswer::where('form_id', $id)->first();
            $kyanswer->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
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

                MessageTemplate::sendForSebepReason(
                    $this->mailController,
                    MessageTemplate::SCENARIO_KY_IADE,
                    $iadeSebebi,
                    $scholar->email,
                    $konu,
                    $parameters
                );
            } catch (\Exception $e) {
                // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                \Log::error('Kayıt yenileme iade mail gönderim hatası: ' . $e->getMessage());
            }

            aday_timeline_log(
                $scholar->tc_no,
                'Kayıt Yenileme',
                'KY başvurusu iade edildi (toplu)',
                $this->timelineMetin('Gerekçe: ' . $iadeSebebi . '. Açıklama: ' . $aciklama . '.')
            );

            return true;
        }

        return false;
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
        Log::info('[transferNewToActive] Fonksiyon başlatıldı. Form ID: ' . $form_id . ', TC: ' . $tc_no);

        try {
            Log::info('[transferNewToActive] NewAnswer sorgusu yapılıyor. TC: ' . $tc_no);
            $newAnswer = NewAnswer::where('tc_no', $tc_no)->first();

            if ($newAnswer) {
                Log::info('[transferNewToActive] NewAnswer bulundu. ID: ' . $newAnswer->id);

                Log::info('[transferNewToActive] ActiveAnswer oluşturuluyor...');
                $activeAnswer = new ActiveAnswer;

                Log::info('[transferNewToActive] NewAnswer verisi diziye çevriliyor...');
                $newAnswerData = $newAnswer->toArray();
                Log::info('[transferNewToActive] NewAnswer verisi alındı. Toplam alan sayısı: ' . count($newAnswerData));

                Log::info('[transferNewToActive] active_answers tablosu sütunları alınıyor...');
                $activeAnswerColumns = \Schema::getColumnListing('active_answers');
                Log::info('[transferNewToActive] active_answers sütunları alındı. Toplam sütun sayısı: ' . count($activeAnswerColumns));

                Log::info('[transferNewToActive] Veri filtreleniyor...');
                $filteredData = array_intersect_key($newAnswerData, array_flip($activeAnswerColumns));
                Log::info('[transferNewToActive] Veri filtrelendi. Filtrelenmiş alan sayısı: ' . count($filteredData));

                unset($filteredData['id']);
                Log::info('[transferNewToActive] ID alanı filtrelenmiş veriden çıkarıldı');

                Log::info('[transferNewToActive] ActiveAnswer fill işlemi yapılıyor...');
                $activeAnswer->fill($filteredData);
                $activeAnswer->form_id = $form_id;
                $activeAnswer->aday_id = $newAnswer->id;
                $this->transferNewDocsToActiveMainFunction($activeAnswer, $tc_no);

                Log::info('[transferNewToActive] ActiveAnswer dolduruldu. Form ID: ' . $form_id . ', Aday ID: ' . $newAnswer->id);

                Log::info('[transferNewToActive] ActiveAnswer kaydediliyor...');
                $activeAnswer->save();
                Log::info('[transferNewToActive] ActiveAnswer kaydedildi. ActiveAnswer ID: ' . $activeAnswer->id);

                Log::info('[transferNewToActive] Timeline ekleniyor...');
                aday_timeline_log(
                    $tc_no,
                    'Burs Başvurusu',
                    'Başvuru onaylandı — aktif bursiyer',
                    $this->timelineMetin('Başvuru onaylandı; aktif bursiyer kaydı ve bilgiler aktarıldı.')
                );
                Log::info('[transferNewToActive] Timeline eklendi');

            } else {
                Log::warning('[transferNewToActive] NewAnswer bulunamadı! TC: ' . $tc_no);
            }
        } catch (QueryException $e) {
            Log::error('[transferNewToActive] QueryException hatası: ' . $e->getMessage() . ' | Code: ' . $e->getCode() . ' | Trace: ' . $e->getTraceAsString());
            if ($e->getCode() == 23000) {  // 23000 MySQL'de Duplicate Entry hatası için kullanılır
                Log::error('[transferNewToActive] Duplicate Entry hatası! TC: ' . $tc_no);
                session()->flash('error', 'Bu TC kimlik numarasına ait kayıt zaten mevcut!');
            } else {
                Log::error('[transferNewToActive] Beklenmeyen QueryException hatası, yeniden fırlatılıyor');
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('[transferNewToActive] Genel Exception hatası: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            throw $e;
        }

        Log::info('[transferNewToActive] Fonksiyon tamamlandı.');

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

    private function transferNewDocsToActiveMainFunction($activeAnswer, $tc_no)
    {
        $scholarId = $this->findScholarIdByFormId($activeAnswer->form_id);
        $docSorus = $this->getDocSorus();
        foreach ($docSorus as $docSorum) {
            $path = $this->findNewDocPath($docSorum->db_key, $tc_no);
            if ($path) {
                $this->transferNewDocsToActive($path, $docSorum->db_key, $scholarId, $activeAnswer);
            }
        }
    }

    private function getDocSorus()
    {
        $docSorus = Soru::where('type', 'file')->get();

        return $docSorus;
    }

    private function findNewDocPath($name, $tc_no)
    {
        $newAnswer = NewAnswer::where('tc_no', $tc_no)->first();
        if (!$newAnswer) {
            Log::error($name . '[transferNewDocsToActive] NewAnswer bulunamadı. TC: ' . $tc_no);

            return null;
        }

        return $newAnswer->$name ?? null;
    }

    private function transferNewDocsToActive($path, $dbKey, $scholarId, $activeAnswer)
    {
        // Eğer path boş veya null ise işlem yapma
        if (empty($path)) {
            Log::error($dbKey . '[transferNewDocsToActive] Dosya yolu boş. Dosya yolu: ' . $path);

            return;
        }

        // Dosya yolunu relative hale getir ve mutlak dosya yolunu oluştur
        $relativePath = str_replace('/storage', '', $path); // /storage'ı kaldır
        $absoluteFilePath = base_path('storage' . $relativePath); // Mutlak dosya yolu

        if (File::exists($absoluteFilePath)) {
            // Hedef dizin: storage/bursiyerler/{scholarId}
            $destinationPath = base_path('storage/bursiyerler/' . $scholarId);

            // Hedef dizini oluştur
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true); // Recursive olarak dizin oluştur
            }

            // Dosya adı ve yeni yol
            $fileName = basename($absoluteFilePath);
            $newPath = $destinationPath . '/' . $fileName;

            // Dosyayı kopyala
            File::copy($absoluteFilePath, $newPath);

            // Yeni dosya yolunu ActiveAnswer modelinde ilgili sütuna kaydet
            $newFilePath = '/storage/bursiyerler/' . $scholarId . '/' . $fileName;
            $activeAnswer->$dbKey = $newFilePath;
            $result = $activeAnswer->save();
            if ($result) {
                Log::info($dbKey . '[transferNewDocsToActive] Dosya kopyalandı. Dosya yolu: ' . $newFilePath);
            } else {
                Log::error($dbKey . '[transferNewDocsToActive] Dosya kopyalama hatası. Dosya yolu: ' . $newFilePath);
            }
        }
    }

    private function findScholarIdByFormId($form_id)
    {
        $scholar = ScholarForm::where('id', $form_id)->first();

        return $scholar->scholar_id;
    }

    public function moveOldModelToNewModel($oldModel, $newModel, $form_id, $tc)
    {
        // Eski modelden veriyi al
        $record = $oldModel::where('tc_no', $tc)->first();
        // Eğer kayıt bulunmazsa, işlem yapılmaz
        if (!$record) {
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
        if (!$check) {
            return $newModel::create($data);
        }
        // Yeni modele kaydı oluştur
    }

    public function moveRenewModelToNewModel($oldModel, $newModel, $old_form_id, $form_id)
    {
        $record = $oldModel::where('form_id', $old_form_id)->first();
        if (!$record) {
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

        if (!$period) {
            session()->flash('error', 'Kayıt Yenileme Dönemi Bulunamadı!');

            return redirect()->route('panel');
        }
        $activeScholars = Scholar::where('status', 1)->with('form.infos')->get();
        foreach ($activeScholars as $activeScholar) {
            $password = Str::random(8);
            $hashpassword = md5($password);
            $bursiyer = Scholar::find($activeScholar->id);
            $bursiyer->password = $hashpassword;
            $bursiyer->status = 2;
            $bursiyer->save();

            $existingForm = RenewForm::where([['period_id', $period->id], ['scholar_id', $activeScholar->id]])->first();

            if (!$existingForm) {
                $form = new RenewForm;
                $form->period_id = $period->id;
                $form->scholar_id = $activeScholar->id;
                $form->save();
            } else {
                $form = $existingForm;
            }

            // Öğrencinin birden fazla ScholarForm kaydı varsa sadece en güncel olanını al
            $scholarForm = ScholarForm::with('infos')
                ->where('scholar_id', $activeScholar->id)
                ->whereNotNull('form_id')
                ->latest('id')
                ->first();

            if (!$scholarForm) {
                $scholarForm = ScholarForm::with('infos')
                    ->where('scholar_id', $activeScholar->id)
                    ->latest('id')
                    ->first();
            }

            if ($scholarForm && !is_null($scholarForm->infos)) {
                $oldForm = $scholarForm->id;

                // Create or get RenewDocuments entry
                $itemdoc = RenewDocuments::where('form_id', $oldForm)->first();
                if (!$itemdoc) {
                    $itemdoc = new RenewDocuments;
                    $itemdoc->form_id = $oldForm;
                    $itemdoc->save();
                }

                // RenewAnswer mükerrer kaydını önlemek için kontrol et
                $item = RenewAnswer::where('form_id', $form->id)->first();
                if (!$item) {
                    $item = new RenewAnswer;
                }

                $item->tc_no = $scholarForm->infos->tc_no;
                $item->form_id = $form->id;
                $item->tel_no = $scholarForm->infos->tel_no;
                $item->save();

                $this->moveActiveModelToRenewModel(ActiveSiblingDetails::class, RenewSiblingDetails::class, $form->id, $oldForm);
                $this->moveActiveModelToRenewModel(ActiveOtherScholarshipDetails::class, RenewOtherScholarshipDetails::class, $form->id, $oldForm);

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

                RenewForm::where('id', $form->id)->update(['status' => 0]);
            }

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
                        \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: ' . $e->getMessage());
                    }
                } catch (\Exception $e) {
                    // Mail gönderimi sırasında oluşan hatayı loglayabilirsiniz
                    \Log::error('Mail gönderimi hatası: ' . $e->getMessage(), [
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
                \Log::error('Kayıt yenileme dönemi başladı mail gönderim hatası: ' . $e->getMessage());
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
        if (!$record) {
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
        if (!$check) {
            $newModel::create($data);
        }

        return 0;
        // Yeni modele kaydı oluştur
    }

    public function moveNewModelToActiveModel($oldModel, $newModel, $tc_no, $form_id)
    {
        $record = $oldModel::where('tc_no', $tc_no)->get();
        if (!$record) {
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
        Log::info('[NewSiblingsToActiveSiblings] Fonksiyon başlatıldı. TC: ' . $tc_no . ', Form ID: ' . $form_id);

        try {
            Log::info('[NewSiblingsToActiveSiblings] NewSiblingDetails sorgusu yapılıyor. TC: ' . $tc_no);
            $record = NewSiblingDetails::where('tc_no', $tc_no)->get();
            Log::info('[NewSiblingsToActiveSiblings] NewSiblingDetails sorgusu tamamlandı. Bulunan kayıt sayısı: ' . $record->count());

            if (!$record || $record->count() == 0) {
                Log::info('[NewSiblingsToActiveSiblings] Kayıt bulunamadı, fonksiyon sonlandırılıyor.');

                return null;
            }

            $counter = 0;
            foreach ($record as $item) {
                $counter++;
                Log::info('[NewSiblingsToActiveSiblings] Kayıt ' . $counter . ' işleniyor. NewSiblingDetails ID: ' . $item->id);

                $data = $item->toArray();
                Log::info('[NewSiblingsToActiveSiblings] Veri diziye çevrildi. Alan sayısı: ' . count($data));

                unset($data['id']);
                $data['form_id'] = $form_id;
                unset($data['tc_no']);
                Log::info('[NewSiblingsToActiveSiblings] Veri hazırlandı. Form ID: ' . $form_id);

                Log::info('[NewSiblingsToActiveSiblings] ActiveSiblingDetails kaydı oluşturuluyor...');
                $activeSibling = ActiveSiblingDetails::create($data);
                Log::info('[NewSiblingsToActiveSiblings] ActiveSiblingDetails kaydı oluşturuldu. ID: ' . $activeSibling->id);
            }

            Log::info('[NewSiblingsToActiveSiblings] Tüm kayıtlar işlendi. Toplam işlenen kayıt: ' . $counter);
        } catch (\Exception $e) {
            Log::error('[NewSiblingsToActiveSiblings] Hata oluştu: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            throw $e;
        }

        Log::info('[NewSiblingsToActiveSiblings] Fonksiyon tamamlandı.');
    }

    public function NewOtherScholarshipToActiveOtherScholarship($tc_no, $form_id)
    {
        Log::info('[NewOtherScholarshipToActiveOtherScholarship] Fonksiyon başlatıldı. TC: ' . $tc_no . ', Form ID: ' . $form_id);

        try {
            Log::info('[NewOtherScholarshipToActiveOtherScholarship] NewOtherScholarshipDetails sorgusu yapılıyor. TC: ' . $tc_no);
            $record = NewOtherScholarshipDetails::where('tc_no', $tc_no)->get();
            Log::info('[NewOtherScholarshipToActiveOtherScholarship] NewOtherScholarshipDetails sorgusu tamamlandı. Bulunan kayıt sayısı: ' . $record->count());

            if (!$record || $record->count() == 0) {
                Log::info('[NewOtherScholarshipToActiveOtherScholarship] Kayıt bulunamadı, fonksiyon sonlandırılıyor.');

                return null;
            }

            $counter = 0;
            foreach ($record as $item) {
                $counter++;
                Log::info('[NewOtherScholarshipToActiveOtherScholarship] Kayıt ' . $counter . ' işleniyor. NewOtherScholarshipDetails ID: ' . $item->id);

                $data = $item->toArray();
                Log::info('[NewOtherScholarshipToActiveOtherScholarship] Veri diziye çevrildi. Alan sayısı: ' . count($data));

                unset($data['id']);
                $data['form_id'] = $form_id;
                unset($data['tc_no']);
                Log::info('[NewOtherScholarshipToActiveOtherScholarship] Veri hazırlandı. Form ID: ' . $form_id);

                Log::info('[NewOtherScholarshipToActiveOtherScholarship] ActiveOtherScholarshipDetails kaydı oluşturuluyor...');
                $activeOtherScholarship = ActiveOtherScholarshipDetails::create($data);
                Log::info('[NewOtherScholarshipToActiveOtherScholarship] ActiveOtherScholarshipDetails kaydı oluşturuldu. ID: ' . $activeOtherScholarship->id);
            }

            Log::info('[NewOtherScholarshipToActiveOtherScholarship] Tüm kayıtlar işlendi. Toplam işlenen kayıt: ' . $counter);
        } catch (\Exception $e) {
            Log::error('[NewOtherScholarshipToActiveOtherScholarship] Hata oluştu: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            throw $e;
        }

        Log::info('[NewOtherScholarshipToActiveOtherScholarship] Fonksiyon tamamlandı.');
    }

    public function addConfirmedScholar($id)
    {
        Log::info('[addConfirmedScholar] Fonksiyon başlatıldı. ID: ' . $id);

        try {
            Log::info('[addConfirmedScholar] Tablo adı alınıyor...');
            $table = (new NewAnswer)->getTable();
            Log::info('[addConfirmedScholar] Tablo adı alındı: ' . $table);

            Log::info('[addConfirmedScholar] Sütunlar alınıyor...');
            $columns = Schema::getColumnListing($table);
            Log::info('[addConfirmedScholar] Sütunlar alındı. Toplam sütun sayısı: ' . count($columns));

            Log::info('[addConfirmedScholar] Doc sütunları filtreleniyor...');
            $docColumns = array_filter($columns, function ($column) {
                return strpos($column, 'doc_') === 0;
            });
            Log::info('[addConfirmedScholar] Doc sütunları filtrelendi. Bulunan doc sütun sayısı: ' . count($docColumns));

            Log::info('[addConfirmedScholar] Dokümanlar sorgulanıyor. ID: ' . $id);
            $documents = NewAnswer::select($docColumns)->where('id', $id)->get();
            Log::info('[addConfirmedScholar] Dokümanlar alındı. Kayıt sayısı: ' . $documents->count());

            Log::info('[addConfirmedScholar] Aday sorgulanıyor. ID: ' . $id);
            $aday = NewAnswer::where('id', $id)->first();
            if (!$aday) {
                Log::error('[addConfirmedScholar] Aday bulunamadı! ID: ' . $id);
                session()->flash('error', 'Aday bulunamadı!');

                return redirect()->back();
            }
            Log::info('[addConfirmedScholar] Aday bulundu. TC: ' . $aday->tc_no . ', Ad: ' . $aday->name . ' ' . $aday->surname . ', Status: ' . $aday->status);

            Log::info('[addConfirmedScholar] Period sorgulanıyor. Period ID: ' . $aday->period_id);
            $period = Period::where('id', $aday->period_id)->first();
            if (!$period) {
                Log::warning('[addConfirmedScholar] Adayın period_id ile period bulunamadı. ID: ' . $aday->period_id . '. Alternatif aranıyor...');
                $period = Period::where('type', 0)->where('status', 1)->first();
            }
            if (!$period) {
                Log::warning('[addConfirmedScholar] Aktif period bulunamadı. Son period aranıyor...');
                $period = Period::where('type', 0)->orderBy('id', 'DESC')->first();
            }
            if (!$period) {
                Log::error('[addConfirmedScholar] Hiçbir period bulunamadı!');
                session()->flash('error', 'Period bulunamadı!');

                return redirect()->back();
            }
            Log::info('[addConfirmedScholar] Period bulundu. ID: ' . $period->id . ', Path: ' . $period->path);

            if ($aday->status != 3) {
                Log::info('[addConfirmedScholar] Aday durumu kontrol edildi. Status: ' . $aday->status . ' (3 değil, işlem devam ediyor)');

                Log::info('[addConfirmedScholar] Mevcut Scholar kontrolü yapılıyor. Aday ID: ' . $aday->id);
                $check = Scholar::where('aday_id', $aday->id)->with('form.infos')->first();
                Log::info('[addConfirmedScholar] Mevcut Scholar kontrolü tamamlandı. Bulundu: ' . ($check ? 'Evet (ID: ' . $check->id . ')' : 'Hayır'));

                if ($check) {
                    Log::info('[addConfirmedScholar] Mevcut Scholar bulundu, temizlik işlemi başlatılıyor...');
                    if ($check->form->first()) {
                        Log::info('[addConfirmedScholar] Form kayıtları bulundu. Form sayısı: ' . $check->form->count());
                        $formCounter = 0;
                        foreach ($check->form as $form) {
                            $formCounter++;
                            Log::info('[addConfirmedScholar] Form ' . $formCounter . ' işleniyor. Form ID: ' . $form->id);
                            if ($form->infos) {
                                Log::info('[addConfirmedScholar] Form infos bulundu, siliniyor. Form ID: ' . $form->id);
                                $form->infos->delete();
                                Log::info('[addConfirmedScholar] Form infos silindi. Form ID: ' . $form->id);
                            } else {
                                Log::info('[addConfirmedScholar] Form infos yok, atlandı. Form ID: ' . $form->id);
                            }
                            Log::info('[addConfirmedScholar] Form siliniyor. Form ID: ' . $form->id);
                            $form->delete();
                            Log::info('[addConfirmedScholar] Form silindi. Form ID: ' . $form->id);
                        }
                        Log::info('[addConfirmedScholar] Tüm formlar silindi. Toplam silinen form: ' . $formCounter);
                    } else {
                        Log::info('[addConfirmedScholar] Form kaydı bulunamadı, atlandı');
                    }
                    Log::info('[addConfirmedScholar] Scholar siliniyor. Scholar ID: ' . $check->id);
                    $check->delete();
                    Log::info('[addConfirmedScholar] Scholar silindi. Scholar ID: ' . $check->id);
                } else {
                    Log::info('[addConfirmedScholar] Mevcut Scholar bulunamadı, temizlik gerekmiyor');
                }

                Log::info('[addConfirmedScholar] Scholar tekrar kontrol ediliyor...');
                $check = Scholar::where('aday_id', $aday->id)->first();
                Log::info('[addConfirmedScholar] Scholar tekrar kontrol edildi. Bulundu: ' . ($check ? 'Evet (ID: ' . $check->id . ')' : 'Hayır'));

                Log::info('[addConfirmedScholar] Şifre oluşturuluyor...');
                $password = Str::random(8);
                $hashpassword = md5($password);
                Log::info('[addConfirmedScholar] Şifre oluşturuldu. Hash: ' . substr($hashpassword, 0, 10) . '...');

                if (!$check) {
                    Log::info('[addConfirmedScholar] Yeni Scholar oluşturuluyor...');

                    $bursiyer = new Scholar;
                    $bursiyer->name = $aday->name;
                    $bursiyer->surname = $aday->surname;
                    $bursiyer->email = $aday->email;
                    $bursiyer->password = $hashpassword;
                    $bursiyer->tc_no = $aday->tc_no;
                    $bursiyer->aday_id = $aday->id;
                    Log::info('[addConfirmedScholar] Scholar kaydediliyor...');
                    $bursiyer->save();
                    Log::info('[addConfirmedScholar] Scholar kaydedildi. Scholar ID: ' . $bursiyer->id . ', TC: ' . $bursiyer->tc_no);

                    $form = new ScholarForm;
                    $form->period_id = $period->id;
                    $form->aday_id = $aday->id;
                    $form->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
                    $form->scholar_id = $bursiyer->id;
                    $form->status = 3;
                    Log::info('[addConfirmedScholar] ScholarForm kaydediliyor...');
                    $result = $form->save();
                    Log::info('[addConfirmedScholar] ScholarForm kaydedildi. Form ID: ' . $form->id . ', Period ID: ' . $form->period_id . ', Kayıt sonucu: ' . ($result ? 'Başarılı' : 'Başarısız'));

                    Log::info('[addConfirmedScholar] transferNewToActive fonksiyonu çağrılıyor. Form ID: ' . $form->id . ', TC: ' . $bursiyer->tc_no);
                    try {
                        $this->transferNewToActive($form->id, $bursiyer->tc_no);
                        Log::info('[addConfirmedScholar] transferNewToActive başarıyla tamamlandı');
                    } catch (\Exception $e) {
                        Log::error('[addConfirmedScholar] transferNewToActive hatası: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                        throw $e;
                    }

                    Log::info('[addConfirmedScholar] NewSiblingsToActiveSiblings fonksiyonu çağrılıyor. TC: ' . $aday->tc_no . ', Form ID: ' . $form->id);
                    try {
                        $this->NewSiblingsToActiveSiblings($aday->tc_no, $form->id);
                        Log::info('[addConfirmedScholar] NewSiblingsToActiveSiblings başarıyla tamamlandı');
                    } catch (\Exception $e) {
                        Log::error('[addConfirmedScholar] NewSiblingsToActiveSiblings hatası: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                        throw $e;
                    }

                    Log::info('[addConfirmedScholar] NewOtherScholarshipToActiveOtherScholarship fonksiyonu çağrılıyor. TC: ' . $aday->tc_no . ', Form ID: ' . $form->id);
                    try {
                        $this->NewOtherScholarshipToActiveOtherScholarship($aday->tc_no, $form->id);
                        Log::info('[addConfirmedScholar] NewOtherScholarshipToActiveOtherScholarship başarıyla tamamlandı');
                    } catch (\Exception $e) {
                        Log::error('[addConfirmedScholar] NewOtherScholarshipToActiveOtherScholarship hatası: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                        throw $e;
                    }

                    // Yeni template sistemi ile mail gönder
                    Log::info('[addConfirmedScholar] Mail gönderimi başlatılıyor...');
                    try {
                        $parameters = [
                            'name' => $aday->name,
                            'surname' => $aday->surname,
                        ];
                        Log::info('[addConfirmedScholar] Mail parametreleri hazırlandı. Email: ' . $aday->email . ', Name: ' . $aday->name . ', Surname: ' . $aday->surname);

                        $this->mailController->sendTemplateEmail(
                            'aday-onaylandi',
                            $aday->email,
                            'Burs Başvurunuz Onaylanmıştır',
                            $parameters
                        );
                        Log::info('[addConfirmedScholar] Mail başarıyla gönderildi');

                        Log::info('[addConfirmedScholar] Aday durumu güncelleniyor...');
                        $aday->status = 3;
                        $aday->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
                        $aday->save();
                        Log::info('[addConfirmedScholar] Aday durumu güncellendi. Status: 3, İşlemi yapan: ' . $aday->islemi_yapan);
                    } catch (\Exception $e) {
                        // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                        Log::error('[addConfirmedScholar] Aday onaylanma mail gönderim hatası: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
                    }

                    session()->flash('success', 'Aday bursiyer onaylandi');
                    Log::info('[addConfirmedScholar] İşlem başarıyla tamamlandı. Yönlendirme yapılıyor...');

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

                } else {
                    Log::warning('[addConfirmedScholar] Scholar zaten mevcut, işlem atlandı. Scholar ID: ' . ($check ? $check->id : 'Bilinmiyor'));
                }
            } else {
                Log::warning('[addConfirmedScholar] Aday durumu zaten 3. İşlem atlandı.');
                session()->flash('error', 'Bursiyer Durumu Zaten Değiştirildi!');
            }
        } catch (\Exception $e) {
            Log::error('[addConfirmedScholar] Genel hata: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            throw $e;
        }

        Log::info('[addConfirmedScholar] Fonksiyon sonlandı.');
    }

    public function confirmRelation($id)
    {
        $konu = 'Burs Başvuru Onayınız Kabul Edilmiştir';
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu kabul edilmistir.';

        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 3;
            $user->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
            $result = $user->save();
            if ($result) {
                $this->kullaniciBilgilendir($user->email, $icerik, $konu);

                aday_timeline_log(
                    $user->tc_no,
                    'Burs Başvurusu',
                    'Başvuru onaylandı',
                    $this->timelineMetin('Başvuru durumu onaylandı (confirmRelation).')
                );

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
        $icerik = 'icerik metni buraya gelecek. deneme amacli burs basvurusu reddedilmistir. <div> </div> <h4> Gerekce : </h4>' . $redsebebi . '<div></div> <h4> Aciklama : </h4>' . $aciklama;
        $user = NewAnswer::find($id);
        if ($user) {
            $user->status = 4;
            $user->redSebebi = $redsebebi;
            $user->redDigerAciklama = $aciklama;
            $user->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
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
                    \Log::error('Aday reddedilme mail gönderim hatası: ' . $e->getMessage());
                }

                aday_timeline_log(
                    $user->tc_no,
                    'Burs Başvurusu',
                    'Başvuru reddedildi (toplu)',
                    $this->timelineMetin('Gerekçe: ' . $redsebebi . '. Açıklama: ' . $aciklama . '.')
                );

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
        $icerik = 'icerik metni buraya gelecek. deneme amacli kayit yenileme basvurusu reddedilmistir. <div> </div> <h4> Gerekce : </h4>' . $redsebebi . '<div></div> <h4> Aciklama : </h4>' . $aciklama;
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
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
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

                    MessageTemplate::sendForSebepReason(
                        $this->mailController,
                        MessageTemplate::SCENARIO_KY_RED,
                        $redsebebi,
                        $scholar->email,
                        'Kayıt Yenileme Başvurunuz Reddedilmiştir',
                        $parameters
                    );
                } catch (\Exception $e) {
                    // Mail gönderim hatası durumunda log'a yaz ama işlemi durdurma
                    \Log::error('Kayıt yenileme reddedilme mail gönderim hatası: ' . $e->getMessage());
                }

                aday_timeline_log(
                    $scholar->tc_no,
                    'Kayıt Yenileme',
                    'KY başvurusu reddedildi (toplu)',
                    $this->timelineMetin('Gerekçe: ' . $redsebebi . '. Açıklama: ' . $aciklama . '.')
                );

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
                'islemi_yapan' => Auth::user()->name . ' ' . Auth::user()->surname,
            ]);
            if ($result) {
                $this->kullaniciBilgilendir($user->email, $icerik, $konu);

                aday_timeline_log(
                    $user->tc_no,
                    'Kayıt Yenileme',
                    'KY formu onaylandı',
                    $this->timelineMetin('Kayıt yenileme formu onaylandı (confirmRenew).')
                );

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
            $scholar->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
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
                \Log::error('Kayıt yenileme onayı mail gönderim hatası: ' . $e->getMessage());
            }
            aday_timeline_log(
                $email->tc_no,
                'Kayıt Yenileme',
                'KY sonuçlandı — onaylandı',
                $this->timelineMetin('Kayıt yenileme süreci onaylandı; güncel veriler aktif kayda aktarıldı.')
            );

            session()->flash('success', 'Kayıt Yenileme Onaylandı!');

        }

        return redirect()->back();
    }

    public function transferRenewToActive($renewModelClass, $activeModelClass, $scholar_id)
    {
        // İlgili scholar'ı bul
        $scholar = Scholar::find($scholar_id);
        if (!$scholar) {
            return 'Ogrenci bulunamadi.';
        }

        // Scholar'a ait RenewForm'u bul
        $renewForm = RenewForm::where('scholar_id', $scholar_id)->first();
        if (!$renewForm) {
            return 'No matching RenewForm found for the given Scholar.';
        }

        // RenewForm'a bağlı RenewAnswer'ı bul
        $renewAnswer = $renewModelClass::where('form_id', $renewForm->id)->first();
        if (!$renewAnswer) {
            return 'No matching RenewAnswer found for the given RenewForm.';
        }
        $bursiyer = Scholar::find($scholar_id);
        $bursiyer->status = 1;
        $bursiyer->save();

        $item = new ScholarForm;
        $item->scholar_id = $scholar_id;
        $item->status = 3;
        $item->islemi_yapan = Auth::user()->name . ' ' . Auth::user()->surname;
        $item->period_id = Period::where('type', 1)->latest()->first()->id;
        $item->save();
        $activeForm = $item;
        // Yeni bir active_answers kaydı oluştur
        $activeInfo = new $activeModelClass;
        $renewAnswer = $renewAnswer->toArray();
        unset($renewAnswer['id']);
        // Tüm alanları yenile
        $activeInfo->fill($renewAnswer);
        $activeInfo->form_id = $activeForm->id; // Güncellenen form_id'yi ayarla

        DB::transaction(function () use ($activeInfo) {
            $activeInfo->save();
        });
        $this->doctransferRenewToActive($scholar_id, $activeInfo);

        return 'Information transferred successfully.';
    }

    public function doctransferRenewToActive($scholar_id, $activeInfo)
    {
        $documentQuestios = $this->getDocSorus();

        $lastRenewForm = RenewForm::where('scholar_id', $scholar_id)->with('infos')->latest()->first();
        if (!$lastRenewForm) {
            return 'yenileme formu yok';
        }
        $documentData = [];
        if ($lastRenewForm && $lastRenewForm->infos) {
            foreach ($documentQuestios as $question) {
                $dbKey = $question->db_key;
                if (!empty($lastRenewForm->infos->$dbKey)) {
                    $documentData[$dbKey] = $lastRenewForm->infos->$dbKey;
                }
            }
        }

        $destinationBase = base_path('storage/bursiyerler/' . $scholar_id);

        if (!File::exists($destinationBase)) {
            File::makeDirectory($destinationBase, 0755, true);
        }

        $results = [];
        foreach ($documentData as $dbKey => $filePath) {
            $relativePath = str_replace('/storage', '', $filePath);
            $sourcePath = base_path('storage' . $relativePath);

            if (File::exists($sourcePath)) {
                $fileName = basename($sourcePath);
                $newPath = $destinationBase . '/' . $fileName;
                File::copy($sourcePath, $newPath);

                $newStoragePath = '/storage/bursiyerler/' . $scholar_id . '/' . $fileName;
                $results[$dbKey] = [
                    'old' => $filePath,
                    'new' => $newStoragePath,
                ];

                // ActiveAnswer kaydındaki ilgili sütunu yeni yol ile güncelle
                $activeInfo->$dbKey = $newStoragePath;
            } else {
                $results[$dbKey] = [
                    'status' => 'Source file not found',
                    'path' => $sourcePath,
                ];
            }
        }

        // Güncellenmiş dosya yollarını kaydet
        $activeInfo->save();

        return 'Bilgiler basariyla aktarildi.';
    }

    public function transferRenewToActiveDatas($scholar_id)
    {
        return $this->transferRenewToActive(RenewAnswer::class, ActiveAnswer::class, $scholar_id);
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
        $periods = Period::orderBy('title', 'desc')->get()->unique('title')->values();
        $result = [
            'bankNames' => $bankNames,
            'belgeler' => $belgeler,
            'formType' => 'aday',
            'unis' => $unis,
            'title' => 'Yeni Aday Bursiyer Ekle',
            'period' => Period::with('documents')->where('type', 0)->latest()->first(),
            'periods' => $periods,
            'cities' => Il::all(),
            'documents' => $this->studentController->belgeadlarigetir(),
            'bursTipleriAll' => TanimBursTipi::orderBy('burs_tipi')->get(['id', 'burs_tipi', 'ogrenim_tipi']),
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
            'bursTipleriAll' => TanimBursTipi::orderBy('burs_tipi')->get(['id', 'burs_tipi', 'ogrenim_tipi']),
        ];

        return view('panel.add-activescholarship-manuel', $result);
    }

    public function checkResult($result)
    {
        if ($result) {
            session()->flash('success', 'İşlem Başarılı!');
        } else {
            session()->flash('error', 'İşlem Başarısız!');
        }
    }

    public function startAdayExport(Request $request)
    {
        $userIds = $request->input('userIds');
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }

        // Filtreleri al
        $filters = $request->input('filters');
        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        // Görünür sütunları al
        $visibleColumns = $request->input('visibleColumns');
        if (is_string($visibleColumns)) {
            $visibleColumns = json_decode($visibleColumns, true);
        }

        if (empty($userIds)) {
            // Filtreleri uygulayarak ID'leri al
            $query = NewAnswer::query();
            if (!empty($filters)) {
                $adayController = app(AdayBursiyerController::class);
                foreach ($filters as $column => $filter) {
                    $adayController->applyColumnFilterPublic($query, $column, $filter);
                }
            }
            $userIds = $query->pluck('id')->toArray();
        }

        $exportId = uniqid('export_');
        // Görünür sütunları da cache'e kaydet
        $cacheData = [
            'userIds' => $userIds,
            'visibleColumns' => $visibleColumns,
        ];
        Cache::put($exportId, $cacheData, 1800); // 30 dakika sakla

        return response()->json([
            'exportId' => $exportId,
            'total' => count($userIds),
            'batchSize' => 50,
        ]);
    }

    public function processAdayExportChunk(Request $request)
    {
        $exportId = $request->input('exportId');
        $index = $request->input('index');
        $batchSize = $request->input('batchSize', 50);

        $cacheData = Cache::get($exportId);
        if (!$cacheData) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        // Yeni format (object) ve eski format (array) uyumluluğu
        $userIds = is_array($cacheData) && isset($cacheData['userIds']) ? $cacheData['userIds'] : $cacheData;

        $offset = $index * $batchSize;
        $chunkIds = array_slice($userIds, $offset, $batchSize);

        $records = NewAnswer::with(['documents', 'bursTipi'])->whereIn('id', $chunkIds)->get();
        $data = [];
        foreach ($records as $record) {
            $data[] = $record->toArray();
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        File::put($tempDir . '/chunk_' . $index . '.json', json_encode($data));

        return response()->json(['success' => true]);
    }

    public function finalizeAdayExport(Request $request)
    {
        $exportId = $request->input('exportId');
        $totalChunks = $request->input('totalChunks');

        // Cache'den görünür sütun bilgisini al
        $cacheData = Cache::get($exportId);
        $visibleColumns = null;
        if (is_array($cacheData) && !empty($cacheData['visibleColumns'])) {
            $visibleColumns = $cacheData['visibleColumns'];
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Tüm sütun tanımları: db_key => Türkçe başlık
        $allColumnMap = [
            'id' => 'Başvuru No',
            'name' => 'Ad',
            'surname' => 'Soyad',
            'tc_no' => 'TC No',
            'educationType' => 'Öğrenim Tipi',
            'tel_no' => 'Cep Telefonu',
            'status' => 'Başvuru Durumu',
            'redSebebi' => 'Ret Sebebi',
            'email' => 'E-Posta',
            'totalPoints' => 'Toplam Puan',
            'mulakat_durumu' => 'Mülakat Durumu',
            'islemi_yapan' => 'İşlem Yapan',
            'doc_ogrenciBelgesi' => 'Öğrenci Belgesi',
            'doc_adlisicilkaydi' => 'Adli Sicil Kaydı',
            'doc_nufuskayitornegi' => 'Nüfus Kayıt Örneği',
            'doc_annegelirbelgesi' => 'Anne Gelir Belgesi',
            'doc_babagelirbelgesi' => 'Baba Gelir Belgesi',
            'doc_taahhutname' => 'Taahhütname',
            'doc_kimlik' => 'Kimlik',
            'doc_bankahesap' => 'Banka Hesap',
            'doc_transkript' => 'Transkript',
            'doc_ikametgah' => 'İkametgah',
            'doc_Karne' => 'Karne',
            'doc_Diger' => 'Diğer',
        ];

        // Eğer visibleColumns belirtilmişse sadece o sütunları kullan, yoksa tüm sütunları kullan
        $useVisibleColumnsFilter = !empty($visibleColumns) && is_array($visibleColumns);

        if ($useVisibleColumnsFilter) {
            // Sadece görünür sütunların başlıklarını oluştur (doc_fotograf hariç)
            $filteredColumns = [];
            foreach ($visibleColumns as $colName) {
                if ($colName === 'doc_fotograf' || $colName === 'checkbox' || $colName === 'action') {
                    continue;
                }
                if (isset($allColumnMap[$colName])) {
                    $filteredColumns[$colName] = $allColumnMap[$colName];
                }
            }
            $headers = array_values($filteredColumns);
            $columnKeys = array_keys($filteredColumns);
        } else {
            // Toplu Aktar modu - tüm detaylı sütunları kullan (mevcut davranış)
            $headers = [
                'Başvuru No',
                'Toplam Puan',
                'Ad',
                'Soyad',
                'TC No',
                'Öğrenim Tipi',
                'Cep Telefonu',
                'Burs Tipi',
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
                'Birlikte Yaşanılan Kişi Sayısı',
                'Kaldığı İl',
                'Kaldığı İlçe',
                'Tam Adres',
                'Annenin Yaşadığı İl',
                'Annenin Yaşadığı İlçe',
                'Babanın Yaşadığı İl',
                'Babanın Yaşadığı İlçe',
                'Açık Adres',
                'Aile Cep Telefonu',
                'Aile Ev Telefonu',
                'Aile E-posta Adresi',
                'Acil Durum Kişisi Ad',
                'Acil Durum Kişisi Soyad',
                'Acil Durum Kişisi Telefonu',
                'Acil Durum Kişisi Yakınlık Derecesi',
                'Anne Baba Birlikte Mi?',
                'Anne Baba Sağ Mı?',
                'Anne Ad',
                'Anne Soyad',
                'Baba Ad',
                'Baba Soyad',
                'Anne Meslek',
                'Baba Meslek',
                'Anne Tahsil Durumu',
                'Baba Tahsil Durumu',
                'Anne Bağlı Olduğu Sosyal Güvenlik Kurumu',
                'Baba Bağlı Olduğu Sosyal Güvenlik Kurumu',
                'Kardeş Sayısı',
                'Kendisi Dahil Okuyan Kardeş Sayısı',
                'Ailenin Geçimini Kim/Kimler Sağlıyor?',
                'Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?',
                'Annenin Aylık Net Geliri (TL)',
                'Babanın Aylık Net Geliri (TL)',
                'Diğer Kişilerin Aylık Net Geliri (TL)',
                'Ailenin Başka Geliri Var Mı?',
                'Ailenin Yaşamakta Olduğu Ev Türü',
                'Kira ise Aylık Net Kirası (TL)',
                'Diğer Gelir Bilgisi',
                'Devlet Bursu Almakta mı ya da Başvurdu mu?',
                'Özel Burs Almakta ya da Başvurdu mu?',
                'Herhangi Bir Engeliniz Var mı?',
                'Engel Durumunu Açıklayınız (Varsa)',
                'Bizden Nasıl Haberdar Oldunuz?',
                'Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz?',
                'Katkıda Bulunduğunuz Sosyal Projeler',
                'Hobileriniz',
                'İlgilendiğiniz Spor Dalı (Varsa)',
                'Son Okuduğunuz Kitaplar',
                'Bize Mesajınız',
                'Banka',
                'IBAN',
                'Hesap Numarası',
                'Düzenli olarak bir kurumda kazanç sağlıyor mu?',
                'Kurum Adı',
                'Görev',
                'Sosyal Güvenlik Kurumu',
                'Aylık Net Ücret (TL)',
                'Öğrenci Belgesi',
                'Adli Sicil Kaydı',
                'Nüfus Kayıt Örneği',
                'Anne Gelir Belgesi',
                'Baba Gelir Belgesi',
                'Taahhütname',
                'Kimlik',
                'Banka Hesap',
                'Transkript',
                'İkametgah',
                'Karne',
                'Diğer',
                'Mülakat Durumu',
            ];
            $columnKeys = null;
        }

        foreach ($headers as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $rowNum = 2;
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $tempDir . '/chunk_' . $i . '.json';
            if (File::exists($chunkFile)) {
                $chunkData = json_decode(File::get($chunkFile));
                foreach ($chunkData as $data) {
                    // Status değerini Türkçe'ye çevir
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
                        default:
                            $status = 'Belirsiz';
                            break;
                    }

                    if ($useVisibleColumnsFilter) {
                        // Sadece görünür sütunları yaz
                        $colIdx = 1;
                        foreach ($columnKeys as $colKey) {
                            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                            $value = '';
                            switch ($colKey) {
                                case 'status':
                                    $value = $status;
                                    break;
                                case 'educationType':
                                    $value = education_type_label($data->educationType ?? null);
                                    break;
                                case 'mulakat_durumu':
                                    $value = $data->mulakat_durumu ?? '';
                                    break;
                                default:
                                    if (str_starts_with($colKey, 'doc_')) {
                                        $value = $this->getBelgeDurum($data->$colKey ?? null);
                                    } else {
                                        $value = $data->$colKey ?? '';
                                    }
                                    break;
                            }
                            $sheet->setCellValue($colLetter . $rowNum, $value);
                            $colIdx++;
                        }
                    } else {
                        // Toplu Aktar modu - mevcut tüm sütunlar
                        $bursTipiAdi = $data->burs_tipi->burs_tipi ?? '';
                        $sheet->setCellValue('A' . $rowNum, $data->id);
                        $sheet->setCellValue('B' . $rowNum, $data->totalPoints ?? '');
                        $sheet->setCellValue('C' . $rowNum, $data->name);
                        $sheet->setCellValue('D' . $rowNum, $data->surname);
                        $sheet->setCellValue('E' . $rowNum, $data->tc_no);
                        $sheet->setCellValue('F' . $rowNum, education_type_label($data->educationType ?? null));
                        $sheet->setCellValue('G' . $rowNum, $data->tel_no);
                        $sheet->setCellValue('H' . $rowNum, $bursTipiAdi);
                        $sheet->setCellValue('I' . $rowNum, $status);
                        $sheet->setCellValue('J' . $rowNum, $data->redSebebi);
                        $sheet->setCellValue('K' . $rowNum, $data->email);
                        $sheet->setCellValue('L' . $rowNum, $data->b_dob);
                        $sheet->setCellValue('M' . $rowNum, $data->registered_city);
                        $sheet->setCellValue('N' . $rowNum, $data->registered_district);
                        $sheet->setCellValue('O' . $rowNum, $data->born_city);
                        $sheet->setCellValue('P' . $rowNum, $data->born_district);
                        $sheet->setCellValue('Q' . $rowNum, $data->gender);
                        $sheet->setCellValue('R' . $rowNum, $data->maritality);
                        $sheet->setCellValue('S' . $rowNum, $data->nationality);
                        $sheet->setCellValue('T' . $rowNum, $data->primary_educ_type ?? '');
                        $sheet->setCellValue('U' . $rowNum, $data->p_school_name);
                        $sheet->setCellValue('V' . $rowNum, $data->p_school_city);
                        $sheet->setCellValue('W' . $rowNum, $data->class);
                        $sheet->setCellValue('X' . $rowNum, $data->student_number);
                        $sheet->setCellValue('Y' . $rowNum, $data->grade_avg);
                        $sheet->setCellValue('Z' . $rowNum, $data->is_transfered);
                        $sheet->setCellValue('AA' . $rowNum, $data->m_school_name);
                        $sheet->setCellValue('AB' . $rowNum, $data->m_school_city);
                        $sheet->setCellValue('AC' . $rowNum, $data->m_school_district);
                        $sheet->setCellValue('AD' . $rowNum, $data->h_school_name);
                        $sheet->setCellValue('AE' . $rowNum, $data->h_school_city);
                        $sheet->setCellValue('AF' . $rowNum, $data->h_school_district);
                        $sheet->setCellValue('AG' . $rowNum, $data->grade_high_school);
                        $sheet->setCellValue('AH' . $rowNum, $data->entry_grade_university);
                        $sheet->setCellValue('AI' . $rowNum, $data->university_city);
                        $sheet->setCellValue('AJ' . $rowNum, $data->current_university);
                        $sheet->setCellValue('AK' . $rowNum, $data->university_faculty);
                        $sheet->setCellValue('AL' . $rowNum, $data->grade_departmant);
                        $sheet->setCellValue('AM' . $rowNum, $data->university_type);
                        $sheet->setCellValue('AN' . $rowNum, $data->university_class);
                        $sheet->setCellValue('AO' . $rowNum, $data->university_educ_time);
                        $sheet->setCellValue('AP' . $rowNum, $data->agno_type);
                        $sheet->setCellValue('AQ' . $rowNum, $data->agno);
                        $sheet->setCellValue('AR' . $rowNum, $data->university_transfer);
                        $sheet->setCellValue('AS' . $rowNum, $data->university_transfer_desc);
                        $sheet->setCellValue('AT' . $rowNum, $data->languages);
                        $sheet->setCellValue('AU' . $rowNum, $data->grade_university ?? '');
                        $sheet->setCellValue('AV' . $rowNum, $data->grade_departmant);
                        $sheet->setCellValue('AW' . $rowNum, $data->master_university);
                        $sheet->setCellValue('AX' . $rowNum, $data->master_field);
                        $sheet->setCellValue('AY' . $rowNum, $data->grade_agno);
                        $sheet->setCellValue('AZ' . $rowNum, $data->housing_type);
                        $sheet->setCellValue('BA' . $rowNum, $data->housing_fee);
                        $sheet->setCellValue('BB' . $rowNum, $data->living_with_count);
                        $sheet->setCellValue('BC' . $rowNum, $data->residing_city);
                        $sheet->setCellValue('BD' . $rowNum, $data->residing_district);
                        $sheet->setCellValue('BE' . $rowNum, $data->address_detail);
                        $sheet->setCellValue('BF' . $rowNum, $data->mother_city);
                        $sheet->setCellValue('BG' . $rowNum, $data->mother_district);
                        $sheet->setCellValue('BH' . $rowNum, $data->father_city);
                        $sheet->setCellValue('BI' . $rowNum, $data->father_district);
                        $sheet->setCellValue('BJ' . $rowNum, $data->parent_address);
                        $sheet->setCellValue('BK' . $rowNum, $data->parent_mobile);
                        $sheet->setCellValue('BL' . $rowNum, $data->parent_phone);
                        $sheet->setCellValue('BM' . $rowNum, $data->parent_email);
                        $sheet->setCellValue('BN' . $rowNum, $data->emergency_person_name);
                        $sheet->setCellValue('BO' . $rowNum, $data->emergency_person_surname);
                        $sheet->setCellValue('BP' . $rowNum, $data->emergency_mobile);
                        $sheet->setCellValue('BQ' . $rowNum, $data->emergency_closeness);
                        $sheet->setCellValue('BR' . $rowNum, $data->parent_together);
                        $sheet->setCellValue('BS' . $rowNum, $data->mother_alive);
                        $sheet->setCellValue('BT' . $rowNum, $data->mother_name);
                        $sheet->setCellValue('BU' . $rowNum, $data->mother_surname);
                        $sheet->setCellValue('BV' . $rowNum, $data->father_name);
                        $sheet->setCellValue('BW' . $rowNum, $data->father_surname);
                        $sheet->setCellValue('BX' . $rowNum, $data->mother_job);
                        $sheet->setCellValue('BY' . $rowNum, $data->father_job);
                        $sheet->setCellValue('BZ' . $rowNum, $data->mother_educ);
                        $sheet->setCellValue('CA' . $rowNum, $data->father_educ);
                        $sheet->setCellValue('CB' . $rowNum, $data->mother_company);
                        $sheet->setCellValue('CC' . $rowNum, $data->father_company);
                        $sheet->setCellValue('CD' . $rowNum, $data->educ_count);
                        $sheet->setCellValue('CE' . $rowNum, $data->count);
                        $sheet->setCellValue('CF' . $rowNum, $data->income_person);
                        $sheet->setCellValue('CG' . $rowNum, $data->total_person);
                        $sheet->setCellValue('CH' . $rowNum, $data->mother_salary);
                        $sheet->setCellValue('CI' . $rowNum, $data->father_salary);
                        $sheet->setCellValue('CJ' . $rowNum, $data->other_salary);
                        $sheet->setCellValue('CK' . $rowNum, $data->other_income);
                        $sheet->setCellValue('CL' . $rowNum, $data->parent_housing_type);
                        $sheet->setCellValue('CM' . $rowNum, $data->rent_count);
                        $sheet->setCellValue('CN' . $rowNum, $data->other_detail);
                        $sheet->setCellValue('CO' . $rowNum, $data->government);
                        $sheet->setCellValue('CP' . $rowNum, $data->special);
                        $sheet->setCellValue('CQ' . $rowNum, $data->disabled_status);
                        $sheet->setCellValue('CR' . $rowNum, $data->disabled_detail);
                        $sheet->setCellValue('CS' . $rowNum, $data->platform);
                        $sheet->setCellValue('CT' . $rowNum, $data->skills);
                        $sheet->setCellValue('CU' . $rowNum, $data->social_projects);
                        $sheet->setCellValue('CV' . $rowNum, $data->hobbies);
                        $sheet->setCellValue('CW' . $rowNum, $data->sports);
                        $sheet->setCellValue('CX' . $rowNum, $data->last_books);
                        $sheet->setCellValue('CY' . $rowNum, $data->message);
                        $sheet->setCellValue('CZ' . $rowNum, $data->bank_name);
                        $sheet->setCellValue('DA' . $rowNum, $data->iban);
                        $sheet->setCellValue('DB' . $rowNum, $data->account_number);
                        $sheet->setCellValue('DC' . $rowNum, $data->is_working);
                        $sheet->setCellValue('DD' . $rowNum, $data->job_company);
                        $sheet->setCellValue('DE' . $rowNum, $data->job_rank);
                        $sheet->setCellValue('DF' . $rowNum, $data->job_sgk);
                        $sheet->setCellValue('DG' . $rowNum, $data->job_salary);
                        $sheet->setCellValue('DH' . $rowNum, $this->getBelgeDurum($data->doc_ogrenciBelgesi ?? null));
                        $sheet->setCellValue('DI' . $rowNum, $this->getBelgeDurum($data->doc_adlisicilkaydi ?? null));
                        $sheet->setCellValue('DJ' . $rowNum, $this->getBelgeDurum($data->doc_nufuskayitornegi ?? null));
                        $sheet->setCellValue('DK' . $rowNum, $this->getBelgeDurum($data->doc_annegelirbelgesi ?? null));
                        $sheet->setCellValue('DL' . $rowNum, $this->getBelgeDurum($data->doc_babagelirbelgesi ?? null));
                        $sheet->setCellValue('DM' . $rowNum, $this->getBelgeDurum($data->doc_taahhutname ?? null));
                        $sheet->setCellValue('DN' . $rowNum, $this->getBelgeDurum($data->doc_kimlik ?? null));
                        $sheet->setCellValue('DO' . $rowNum, $this->getBelgeDurum($data->doc_bankahesap ?? null));
                        $sheet->setCellValue('DP' . $rowNum, $this->getBelgeDurum($data->doc_transkript ?? null));
                        $sheet->setCellValue('DQ' . $rowNum, $this->getBelgeDurum($data->doc_ikametgah ?? null));
                        $sheet->setCellValue('DR' . $rowNum, $this->getBelgeDurum($data->doc_Karne ?? null));
                        $sheet->setCellValue('DS' . $rowNum, $this->getBelgeDurum($data->doc_Diger ?? null));
                        $sheet->setCellValue('DT' . $rowNum, $data->mulakat_durumu ?? '');
                    }
                    $rowNum++;
                }
            }
        }

        // Cleanup
        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        // Excel dosyasını kaydet
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Aday_Bursiyerler_' . time() . '.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath . '/' . $fileName;

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('aday.export.download', ['fileName' => $fileName]),
        ]);
    }

    public function downloadAdayExport($fileName)
    {
        $filePath = storage_path('app/public/temp/' . $fileName);
        if (File::exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return abort(404);
    }

    public function startActiveBursiyerExport(Request $request)
    {
        $userIds = $request->input('userIds');
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }
        $dosyaAdi = 'Bursiyerler';
        $scholarIds = [];
        if (empty($userIds)) {
            $scholarIds = Scholar::pluck('id')->toArray();
        } else {
            foreach ($userIds as $formId) {
                $form = ScholarForm::where('id', $formId)->first();
                if ($form && $form->scholar_id) {
                    $scholarIds[] = $form->scholar_id;
                }
            }
            $scholarIds = array_values(array_unique($scholarIds));
        }

        $exportId = uniqid('export_aktif_');
        Cache::put($exportId, ['scholarIds' => $scholarIds, 'dosyaAdi' => $dosyaAdi], 1800);

        return response()->json([
            'exportId' => $exportId,
            'total' => count($scholarIds),
            'batchSize' => 50,
        ]);
    }

    public function processActiveBursiyerExportChunk(Request $request)
    {
        $exportId = $request->input('exportId');
        $index = (int) $request->input('index');
        $batchSize = (int) $request->input('batchSize', 50);

        $meta = Cache::get($exportId);
        if (!$meta || !isset($meta['scholarIds'])) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }
        $scholarIds = $meta['scholarIds'];
        $dosyaAdi = $meta['dosyaAdi'] ?? 'Bursiyerler';

        $offset = $index * $batchSize;
        $chunkScholarIds = array_slice($scholarIds, $offset, $batchSize);

        $rows = $this->collectAktifScholarExportRows($chunkScholarIds, $dosyaAdi);

        $tempDir = storage_path('app/public/temp/' . $exportId);
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0777, true);
        }

        File::put($tempDir . '/chunk_' . $index . '.json', json_encode($rows));

        return response()->json(['success' => true]);
    }

    public function finalizeActiveBursiyerExport(Request $request)
    {
        $exportId = $request->input('exportId');
        $totalChunks = (int) $request->input('totalChunks');

        $meta = Cache::get($exportId);
        if (!$meta) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headers = $this->aktifTopluIndirHeaders();
        foreach ($headers as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $rowNum = 2;
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $tempDir . '/chunk_' . $i . '.json';
            if (!File::exists($chunkFile)) {
                continue;
            }
            $chunkData = json_decode(File::get($chunkFile));
            if (!is_array($chunkData)) {
                continue;
            }
            foreach ($chunkData as $data) {
                if (!is_object($data)) {
                    continue;
                }
                $this->writeWideScholarExportRowFromObject($sheet, $rowNum, $data);
                $rowNum++;
            }
        }

        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Bursiyerler_Toplu_' . time() . '.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath . '/' . $fileName;

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('aktif.export.download', ['fileName' => $fileName]),
        ]);
    }

    public function downloadActiveBursiyerExport($fileName)
    {
        $filePath = storage_path('app/public/temp/' . $fileName);
        if (File::exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        return abort(404);
    }

    public function startMezunExport(Request $request)
    {
        $userIds = $request->input('userIds');
        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }
        $dosyaAdi = 'Mezunlar';
        $scholarIds = [];
        if (empty($userIds)) {
            $scholarIds = Scholar::where('status', 3)->pluck('id')->toArray();
        } else {
            foreach ($userIds as $formId) {
                $form = ScholarForm::where('id', $formId)->first();
                if ($form && $form->scholar_id) {
                    $scholarIds[] = $form->scholar_id;
                }
            }
            $scholarIds = array_values(array_unique($scholarIds));
        }

        $exportId = uniqid('export_mezun_');
        Cache::put($exportId, ['scholarIds' => $scholarIds, 'dosyaAdi' => $dosyaAdi], 1800);

        return response()->json([
            'exportId' => $exportId,
            'total' => count($scholarIds),
            'batchSize' => 50,
        ]);
    }

    public function processMezunExportChunk(Request $request)
    {
        return $this->processActiveBursiyerExportChunk($request);
    }

    public function finalizeMezunExport(Request $request)
    {
        $exportId = $request->input('exportId');
        $totalChunks = (int) $request->input('totalChunks');

        $meta = Cache::get($exportId);
        if (!$meta) {
            return response()->json(['error' => 'Geçersiz export ID'], 400);
        }

        $tempDir = storage_path('app/public/temp/' . $exportId);
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headers = $this->aktifTopluIndirHeaders();
        foreach ($headers as $key => $header) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($column . '1', $header);
        }

        $rowNum = 2;
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $tempDir . '/chunk_' . $i . '.json';
            if (!File::exists($chunkFile)) {
                continue;
            }
            $chunkData = json_decode(File::get($chunkFile));
            if (!is_array($chunkData)) {
                continue;
            }
            foreach ($chunkData as $data) {
                if (!is_object($data)) {
                    continue;
                }
                $this->writeWideScholarExportRowFromObject($sheet, $rowNum, $data);
                $rowNum++;
            }
        }

        File::deleteDirectory($tempDir);
        Cache::forget($exportId);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Mezunlar_Toplu_' . time() . '.xlsx';
        $directoryPath = storage_path('app/public/temp');
        $filePath = $directoryPath . '/' . $fileName;

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, 0777, true);
        }

        $writer->save($filePath);

        return response()->json([
            'success' => true,
            'fileName' => $fileName,
            'downloadUrl' => route('mezun.export.download', ['fileName' => $fileName]),
        ]);
    }

    public function downloadMezunExport($fileName)
    {
        return $this->downloadActiveBursiyerExport($fileName);
    }
}
