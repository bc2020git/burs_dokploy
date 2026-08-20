<?php

use App\Http\Controllers\AdayBursiyerController;
use App\Http\Controllers\AdayPointController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankaController;
use App\Http\Controllers\BolumController;
use App\Http\Controllers\BursiyerController;
use App\Http\Controllers\BursOdemeController;
use App\Http\Controllers\BursVerenController;
use App\Http\Controllers\DataImportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FakulteController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\IlceController;
use App\Http\Controllers\IlController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\InterviewGroupController;
use App\Http\Controllers\IstatistikController;
use App\Http\Controllers\KayitYenilemeController;
use App\Http\Controllers\KydonemduzeltController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\MezunController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MulakatController;
use App\Http\Controllers\NewRelationController;
use App\Http\Controllers\OrtakController;
use App\Http\Controllers\OtpSettingController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PermissionCategoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\AdminOtpController;
use App\Http\Controllers\RenewStudentAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SebepController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SoruController;
use App\Http\Controllers\SoruKategoriController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TanimBursTipiController;
use App\Http\Controllers\BursTaksitiController;
use App\Http\Controllers\UniversiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\InterviewResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/deneme/{db}/{tablo}/{tc}', [FormController::class, 'tabloKayitKontrol']);
Route::post('/Yonetici-Girisi', [PanelController::class, 'adminLogin'])->name('adminlogin');
Route::get('/belgekopyala/{id}', [NewRelationController::class, 'addEmptyFileRecordRenew'])->name('asdasdasdasdasd');
Route::get('/notif', [StudentController::class, 'sendNotificationNotCompleteds']);
Route::get('/n', [\App\Http\Controllers\IstatistikController::class, 'importDepartments']);
Route::get('/hash/{id}', [StudentController::class, 'hashpass']);
Route::get('/cron/dogum-gunu-mail', [MailController::class, 'sendBirthdayMessages']);
Route::post('/panel/KY-Bilgileri-Kaydet', [PanelController::class, 'saveRenewRelationInfos'])->name('renew-relation-profile-form');
Route::get('/get-faculties/{uni}', [FormController::class, 'getFaculty']);
Route::get('/get-departmants/{fakulte}', [FormController::class, 'getdepartmant']);
Route::get('/get-univercities/{il}', [FormController::class, 'getunivercity']);
Route::get('/get-univercities-yl/{il}', [FormController::class, 'getyluni']);
Route::get('/sorugoster', [PanelController::class, 'sorugoster']);
Route::get('/get-cities', [FormController::class, 'getcities']);
Route::get('/get-cities-by-education-type/{educType}', [FormController::class, 'getCitiesByEducationType']);
Route::get('/get-citiesnew', [FormController::class, 'getcitiesnew']);
Route::get('/get-univercities', [FormController::class, 'getunivercities']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/otp', [AdminOtpController::class, 'show'])->name('admin.otp.show');
Route::post('/admin/otp-verify', [AdminOtpController::class, 'verify'])->name('admin.otp.verify');
Route::post('/admin/otp-resend', [AdminOtpController::class, 'resend'])->name('admin.otp.resend');
// Her sayfada tabloyu filtrelemek icin
Route::post('/filter-table', [FilterController::class, 'filterTable'])->name('filter.table');

// Public interview participation (no auth)
Route::get('/mulakat-katilim/{uuid}', [InterviewResponseController::class, 'show'])->name('interview.response.show');
Route::post('/mulakat-katilim/{uuid}', [InterviewResponseController::class, 'store'])->name('interview.response.store');

Route::get('/puan/{tc}', [StudentController::class, 'puanhesapla']);
// burs veriliyor mu kontrolleri

Route::get('/burs-kontrol-sehir/{il}/{tip}', [FormController::class, 'burskontrolsehir']);
Route::get('/burs-kontrol-ilce/{il}/{tip}', [FormController::class, 'burskontrolilce']);
Route::get('/burs-kontrol-uni/{uni}/{tip}', [FormController::class, 'burskontroluni']);
Route::get('/burs-kontrol-fak/{fak}/{tip}', [FormController::class, 'burskontrolfak']);
Route::get('/burs-kontrol-bolum/{bolum}/{tip}', [FormController::class, 'burskontrolbolum']);
Route::post('/send-single-sms', [SmsController::class, 'sendSingleSms'])->name('send.single.sms');

// Tablo item siralamasi degistirmek icin ortak fonksiyon
Route::post('/siralamayi-guncelle', [panelController::class, 'siraGuncelle']);
Route::get('/urldenemesms/{id}/{message}', [SmsController::class, 'urldenemesms']);

// 23.09.2024 burs
Route::get('/panel/Aday-Kardes-Sil/{id}', [PanelController::class, 'deleteNewScholarSibling'])->name('deleteNewScholarSibling');
Route::get('/panel/KY-Kardes-Sil/{id}', [PanelController::class, 'deleteRenewScholarSibling'])->name('deleteRenewScholarSibling');
Route::get('/panel/Aday-Burs-Sil/{id}', [PanelController::class, 'deleteNewScholarScholarShip'])->name('deleteNewScholarScholarShip');
Route::get('/panel/KY-Burs-Sil/{id}', [PanelController::class, 'deleteRenewScholarScholarShip'])->name('deleteRenewScholarScholarShip');
// Dynamic Export Routes for tanimlar (kept for future server-side needs)
Route::middleware(['auth'])->group(function () {
    Route::post('/export/{model}/{format}', [ExportController::class, 'export'])->name('dynamic.export');
});

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/puan-test/{id}', [StudentController::class, 'puanHesaplaAgno'])->name('puan-test');
    Route::post('/mail-test', [MailController::class, 'sendTestMail'])->name('mail.test');
    Route::get('/burs-odeme/{id}/duzenle', [BursOdemeController::class, 'duzenle'])->name('burs-odeme-duzenle')->middleware('permission:burs-odeme-guncelle');
    Route::post('/burs-odeme/{id}/guncelle', [BursOdemeController::class, 'guncelle'])->name('burs-odeme-guncelle')->middleware('permission:burs-odeme-guncelle');
    Route::resource('roles', RoleController::class)->middleware('permission:rol-yonet');
    Route::resource('permissions', PermissionController::class)->middleware('permission:yetki-yonet');

    Route::prefix('Yetki-Kategorileri')->group(function () {
        Route::get('/', [PermissionCategoryController::class, 'index'])->name('permission-categories.index');
        Route::post('/store', [PermissionCategoryController::class, 'store'])->name('permission-categories.store');
        Route::put('/{id}', [PermissionCategoryController::class, 'update'])->name('permission-categories.update');
        Route::delete('/{id}', [PermissionCategoryController::class, 'destroy'])->name('permission-categories.destroy');
    });

    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:kullanici-yonet');
    Route::get('/panel/settings/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::resource('users', UserController::class)->middleware('permission:kullanici-yonet');
    Route::post('/users/{user}/change-status', [UserController::class, 'changeStatus'])->name('users.change-status')->middleware('permission:kullanici-yonet');
    Route::resource('bursverenler', BursVerenController::class)->middleware('permission:burs-veren-yonet');
    Route::get('/', [PanelController::class, 'index'])->name('index');
    Route::get('/createPath', [OrtakController::class, 'createPath'])->name('createPath');
    Route::get('/home', [PanelController::class, 'index'])->name('home');
    Route::get('/panel', [PanelController::class, 'index'])->name('panel');
    Route::get('/panel/Hesabim', [PanelController::class, 'myAccount'])->name('myAccount');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
    Route::post('/update-account', [UserController::class, 'updateAccount'])->name('update-account');
    Route::get('/panel/users/get', [UserController::class, 'getData'])->name('users.data')->middleware('permission:kullanici-yonet');

    // Aday Bursiyerler
    Route::get('/panel/Aday-Bursiyerler', [AdayBursiyerController::class, 'index'])->name('adaybursiyerler')->middleware('permission:aday-basvurularini-listele');
    Route::get('/panel/Aday-Bursiyerler/data', [AdayBursiyerController::class, 'getData'])->name('aday.data')->middleware('permission:aday-basvurularini-listele');
    Route::get('/panel/Aday-Bursiyer-Incele/{id}', [PanelController::class, 'newScholarDetils'])->name('panel-basvuru-incele')->middleware('permission:aday-basvurularini-incele');
    Route::post('/panel/Aday-Bursiyer-Ekle-Post', [PanelController::class, 'addManuelNewScholar'])->name('add-new-manuel-scholar')->middleware('permission:aday-bursiyer-ekleme');
    Route::post('/Aday-Toplu-Islem', [NewRelationController::class, 'topluIslemYonet'])->name('panel_aday_toplu_islem')->middleware('permission:aday-toplu-islem');
    Route::post('/Aday-Export-Start', [NewRelationController::class, 'startAdayExport'])->name('aday.export.start')->middleware('permission:aday-toplu-islem');
    Route::post('/Aday-Export-Chunk', [NewRelationController::class, 'processAdayExportChunk'])->name('aday.export.chunk')->middleware('permission:aday-toplu-islem');
    Route::post('/Aday-Export-Finalize', [NewRelationController::class, 'finalizeAdayExport'])->name('aday.export.finalize')->middleware('permission:aday-toplu-islem');
    Route::get('/Aday-Export-Download/{fileName}', [NewRelationController::class, 'downloadAdayExport'])->name('aday.export.download')->middleware('permission:aday-toplu-islem');

    Route::post('/Active-Bursiyer-Export-Start', [NewRelationController::class, 'startActiveBursiyerExport'])->name('aktif.export.start')->middleware('permission:aktif-toplu-islem');
    Route::post('/Active-Bursiyer-Export-Chunk', [NewRelationController::class, 'processActiveBursiyerExportChunk'])->name('aktif.export.chunk')->middleware('permission:aktif-toplu-islem');
    Route::post('/Active-Bursiyer-Export-Finalize', [NewRelationController::class, 'finalizeActiveBursiyerExport'])->name('aktif.export.finalize')->middleware('permission:aktif-toplu-islem');
    Route::get('/Active-Bursiyer-Export-Download/{fileName}', [NewRelationController::class, 'downloadActiveBursiyerExport'])->name('aktif.export.download')->middleware('permission:aktif-toplu-islem');

    Route::post('/Mezun-Export-Start', [NewRelationController::class, 'startMezunExport'])->name('mezun.export.start')->middleware('permission:mezun-toplu-islem');
    Route::post('/Mezun-Export-Chunk', [NewRelationController::class, 'processMezunExportChunk'])->name('mezun.export.chunk')->middleware('permission:mezun-toplu-islem');
    Route::post('/Mezun-Export-Finalize', [NewRelationController::class, 'finalizeMezunExport'])->name('mezun.export.finalize')->middleware('permission:mezun-toplu-islem');
    Route::get('/Mezun-Export-Download/{fileName}', [NewRelationController::class, 'downloadMezunExport'])->name('mezun.export.download')->middleware('permission:mezun-toplu-islem');

    Route::post('/panel/Aday-Ekle', [PanelController::class, 'addManuelScholar'])->name('add-manuel-scholar')->middleware('permission:aday-bursiyer-ekleme');
    Route::post('/panel/Aday-Toplu-Sil', [PanelController::class, 'deleteNewScholars'])->name('deleteNewScholars')->middleware('permission:aday-sil');
    Route::post('/panel/Aday-Kardes-Ekle', [PanelController::class, 'addNewScholarSibling'])->name('addNewScholarSibling')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::get('/panel/Aday-Durum-Guncelle/{tc_no}/{sonuc}', [PanelController::class, 'adayBursiyerSonuclandir'])->name('confirm_new_relationship');

    // Manuel Ekleme

    Route::post('/manuel-bursiyer-ekle', [PanelController::class, 'addManuelScholar'])->name('manuel-bursiyer-ekle-post')->middleware('permission:aktif-bursiyer-ekleme');
    Route::post('/manuel-ky-ekle', [PanelController::class, 'addRenewScholar'])->name('manuel-ky-ekle')->middleware('permission:ky-bursiyer-ekleme');

    // Belge İşlemleri
    Route::get('/panel/belge-durum-degis/{name}/{tc}/{period}/{durum}', [PanelController::class, 'belgedurumdegis'])->name('belge-durum-degis')->middleware('permission:belge-durum-degis');
    Route::post('/Belge-Toplu-Islem', [PanelController::class, 'topluBelgeYonet'])->name('panel_aday_toplu_belge')->middleware('permission:belge-durum-degis');

    // Not İşlemleri
    Route::post('/add-scholar-note', [PanelController::class, 'addScholarNote'])->name('add.scholar.note')->middleware('permission:add-note');
    Route::get('/panel/delete-note/{id}', [PanelController::class, 'deleteNote'])->name('panel.deleteNote')->middleware('permission:add-note');
    Route::post('/add-scholar-note', [PanelController::class, 'addScholarNote'])->name('add.scholar.note')->middleware('permission:add-note');
    Route::get('/get-scholar-notes', [PanelController::class, 'getScholarNotes'])->name('get.scholar.notes');

    // CRM İşlemleri
    Route::post('/check-tc-no', [PanelController::class, 'checkTCNo']);
    Route::get('/city-statics/{city}/{limit}', [IstatistikController::class, 'ajaxcityStatics'])->name('city.statics');
    Route::post('/panel/crm-add-new-scholar-sibling', [PanelController::class, 'crmActiveOtherScholarship'])->name('crmActiveOtherScholarship');
    Route::post('/panel/crm-add-new-scholar-sibling-update', [PanelController::class, 'crmActiveOtherScholarshipUpdate'])->name('crmActiveOtherScholarshipUpdate');

    // Aktif Bursiyer İşlemleri
    Route::get('/panel/Aktif-Bursiyer-Incele/{id}', [PanelController::class, 'activeScholarDetils'])->name('panel-aktif-bursiyer-incele')->middleware('permission:aktif-bursiyer-incele');
    Route::get('/panel/Aktif-Bursiyer-Incele-Liste/{id}', [PanelController::class, 'activeScholarDetilsList'])->name('panel-aktif-bursiyer-incele-liste')->middleware('permission:aktif-bursiyer-incele');
    Route::post('/panel/aktif-toplu-belge-yonet', [PanelController::class, 'activeScholarDocs'])->name('panel-aktif-bursiyer-belge-indir');
    Route::post('/get-period-documents', [PanelController::class, 'getPeriodDocuments'])->name('get-period-documents');
    Route::get('/panel/Bursiyerler', [BursiyerController::class, 'index'])->name('bursiyerler')->middleware('permission:aktif-bursiyer-listele');
    Route::get('/panel/Bursiyerler/data', [BursiyerController::class, 'getData'])->name('bursiyerler.data')->middleware('permission:aktif-bursiyer-listele');
    Route::post('/Bursiyer-Export-Start', [BursiyerController::class, 'startBursiyerListExport'])->name('bursiyer.export.start')->middleware('permission:aktif-bursiyer-listele');
    Route::post('/Bursiyer-Export-Chunk', [BursiyerController::class, 'processBursiyerListExportChunk'])->name('bursiyer.export.chunk')->middleware('permission:aktif-bursiyer-listele');
    Route::post('/Bursiyer-Export-Finalize', [BursiyerController::class, 'finalizeBursiyerListExport'])->name('bursiyer.export.finalize')->middleware('permission:aktif-bursiyer-listele');
    Route::get('/Bursiyer-Export-Download/{fileName}', [BursiyerController::class, 'downloadBursiyerListExport'])->name('bursiyer.export.download')->middleware('permission:aktif-bursiyer-listele');
    Route::get('/panel/Bursiyer-Detay', [PanelController::class, 'bursiyerdetay'])->name('bursiyerdetay')->middleware('permission:aktif-bursiyer-incele');
    Route::get('/panel/active-scholarship-details', [PanelController::class, 'active_scholarship_details'])->name('active-scholarship-details');

    // KY İşlemleri
    Route::post('/panel/ky-toplu-belge-yonet', [PanelController::class, 'kyScholarDocs'])->name('panel-ky-bursiyer-belge-indir');
    Route::get('/panel/Kayit-Yenileme', [KayitYenilemeController::class, 'index'])->name('kayityenileme')->middleware('permission:kayit-yenileme-listele');
    Route::get('/panel/Kayit-Yenileme/sifre-yenile/{id}', [NewRelationController::class, 'sifreYenileKyForm'])->name('kayityenileme.sifre-yenile');
    Route::get('/panel/Kayit-Yenileme/data', [KayitYenilemeController::class, 'getData'])->name('kayityenileme.data')->middleware('permission:kayit-yenileme-listele');
    Route::get('/panel/Kayit-Yenileme-Donemi-Baslat', [NewRelationController::class, 'createRenewForms'])->name('kayityenilemebaslat')->middleware('permission:kayit-yenileme-baslat');
    Route::get('/panel/registration-renewal-details', [PanelController::class, 'registration_renewal_details'])->name('registration-renewal-details');
    Route::get('/panel/kayit-Yenileme-Detay/{id}', [PanelController::class, 'kayitYenilemeDetay'])->name('kayitYenilemeDetay')->middleware('permission:kayit-yenileme-detay');
    Route::get('/panel/kayit-Yenileme-Detay-Yonlendir/{id}', [PanelController::class, 'kayitYenilemeDetayYonlendir'])->name('kayitYenilemeDetayYonlendir')->middleware('permission:kayit-yenileme-detay');
    Route::get('/panel/kayit-Yenileme-Sonuclandir/{id}/{durum}', [NewRelationController::class, 'kayitYenilemeSonuclandir'])->name('kayitYenilemeSonuclandir')->middleware('permission:kayit-yenileme-sonuclandir');
    Route::post('/Renew-Export-Start', [KayitYenilemeController::class, 'startRenewExport'])->name('renew.export.start')->middleware('permission:kayit-yenileme-listele');
    Route::post('/Renew-Export-Chunk', [KayitYenilemeController::class, 'processRenewExportChunk'])->name('renew.export.chunk')->middleware('permission:kayit-yenileme-listele');
    Route::post('/Renew-Export-Finalize', [KayitYenilemeController::class, 'finalizeRenewExport'])->name('renew.export.finalize')->middleware('permission:kayit-yenileme-listele');
    Route::get('/Renew-Export-Download/{fileName}', [KayitYenilemeController::class, 'downloadRenewExport'])->name('renew.export.download')->middleware('permission:kayit-yenileme-listele');
    Route::get('/kydeneme', [NewRelationController::class, 'transferRenewToActiveDatas'])->name('kydeneme');
    Route::get('/kygecmisbelge', [KayitYenilemeController::class, 'kygecmisbelge']);

    // Mulakat İşlemleri
    Route::get('/panel/Mulakatlar/incele/{id}', [MulakatController::class, 'getAdayByMulakatId'])->name('panel-mulakat-incele');
    Route::get('/panel/Mulakatlar/{id}/duzenle', [MulakatController::class, 'edit'])->name('panel-mulakat-duzenle')->middleware('permission:mulakat-duzenle');
    Route::get('/panel/Mulakatlar', [MulakatController::class, 'index'])->name('mulakatlar')->middleware('permission:mulakat-yonet');
    Route::get('/panel/Mulakatlar/data', [MulakatController::class, 'getData'])->name('mulakatlar.data');
    Route::post('/panel/Mulakatlar/gruba-bildir', [MulakatController::class, 'notifyInterviewGroups'])->name('mulakatlar.gruba-bildir')->middleware('permission:mulakat-yonet');
    Route::post('/panel/Aday-Mulakat-Ata', [PanelController::class, 'mulakatAta'])->name('mulakat-ata');
    Route::post('/panel/Aday-Toplu-Mulakat-Ata', [PanelController::class, 'topluMulakatAta'])->name('toplu-mulakat-ata');

    // Bildirim İşlemleri
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/send-interview', [NotificationController::class, 'sendInterviewNotification'])->name('notifications.send-interview');


    // Mezun İşlemleri
    Route::get('/panel/Mezunlar/incele/{id}', [MezunController::class, 'getFormIdByMezunId'])->name('panel-mezun-bursiyer-incele-yonlendir');
    Route::get('/panel/Mezunlar', [MezunController::class, 'index'])->name('mezunlar')->middleware('permission:mezun-listele');
    Route::get('/panel/Mezunlar/data', [MezunController::class, 'getData'])->name('mezunlar.data')->middleware('permission:mezun-listele');
    Route::post('/Mezunlar-List-Export-Start', [MezunController::class, 'startMezunListExport'])->name('mezunlar.export.start')->middleware('permission:mezun-listele');
    Route::post('/Mezunlar-List-Export-Chunk', [MezunController::class, 'processMezunListExportChunk'])->name('mezunlar.export.chunk')->middleware('permission:mezun-listele');
    Route::post('/Mezunlar-List-Export-Finalize', [MezunController::class, 'finalizeMezunListExport'])->name('mezunlar.export.finalize')->middleware('permission:mezun-listele');
    Route::get('/Mezunlar-List-Export-Download/{fileName}', [MezunController::class, 'downloadMezunListExport'])->name('mezunlar.export.download')->middleware('permission:mezun-listele');

    // Burs Odeme İşlemleri
    Route::get('/panel/Burs-Odeme-Bilgileri', [BursOdemeController::class, 'index'])->name('bursodemebilgileri')->middleware('permission:burs-odeme-listele');
    Route::get('/panel/Burs-Odeme-Bilgileri/data', [BursOdemeController::class, 'getData'])->name('paymentlist.data')->middleware('permission:burs-odeme-listele');
    Route::get('/burs-odeme/create', [BursOdemeController::class, 'create'])->name('burs-odeme.create')->middleware('permission:burs-odeme-ekle');
    Route::post('/update-payment-info', [BursOdemeController::class, 'updatePaymentInfo'])->name('update-payment-info')->middleware('permission:burs-odeme-guncelle');
    Route::post('/burs-odeme-bilgi/toplu-sil', [BursOdemeController::class, 'topluSil'])->name('burs-odeme-bilgi.toplu-sil')->middleware('permission:burs-odeme-guncelle');
    Route::post('/burs-odeme', [BursOdemeController::class, 'store'])->name('burs-odeme.store')->middleware('permission:burs-odeme-ekle');
    Route::post('/panel/burs-odeme/aktif-bursiyer-manuel', [BursOdemeController::class, 'storeManualScholarPayment'])->name('burs-odeme.aktif-bursiyer-manuel')->middleware('permission:burs-odeme-ekle');
    Route::get('/get-payment-info', [BursOdemeController::class, 'getPaymentInfo'])->name('get-payment-info');
    Route::get('/panel/Burs-Taksiti-Yarat', [BursOdemeController::class, 'create'])->name('burs-taksiti-yarat')->middleware('permission:burs-taksiti-ekle');
    Route::get('/get-scholar-info', [BursOdemeController::class, 'getScholarInfo'])->name('get-scholar-info');
    Route::get('/panel/add-scholarship-application-manuel', [PanelController::class, 'add_scholarship_application_manuel'])->name('add-scholarship-application-manuel');

    // Iletisim İşlemleri
    Route::get('/panel/send-sms', [PanelController::class, 'send_sms'])->name('send-sms');

    Route::post('/Mezun-Toplu-Islem', [NewRelationController::class, 'mezuntopluIslemYonet'])->name('panel_mezun_toplu_islem')->middleware('permission:mezun-toplu-islem');
    Route::post('/KY-Toplu-Islem', [NewRelationController::class, 'kytopluIslemYonet'])->name('panel_ky_toplu_islem')->middleware('permission:ky-toplu-islem');
    Route::post('/Active-Toplu-Islem', [NewRelationController::class, 'ActivetopluIslemYonet'])->name('active_ky_toplu_islem')->middleware('permission:aktif-toplu-islem');
    Route::post('/panel/Basvuru-Aday-Reddet', [NewRelationController::class, 'basvuruAdayiReddet'])->middleware('permission:aday-durum-degis');
    Route::post('/panel/KY-Aday-Reddet', [NewRelationController::class, 'kyAdayiReddet'])->middleware('permission:ky-reddet');
    Route::post('/panel/Basvuru-Aday-Iade', [NewRelationController::class, 'basvuruAdayiIadeEt'])->middleware('permission:aday-durum-degis');
    Route::post('/panel/KY-Aday-Iade', [NewRelationController::class, 'kyAdayiIadeEt'])->middleware('permission:ky-iade');
    Route::post('/panel/Mulakat-Olustur', [PanelController::class, 'mulakatOlustur'])->name('createInterviewToNew')->middleware('permission:mulakat-olustur');
    Route::post('/delete-interviews', [PanelController::class, 'deleteInterviews'])->name('panel_mulakat_toplu_islem')->middleware('permission:mulakat-sil');
    Route::post('/panel/Liste-Mulakat-Olustur', [PanelController::class, 'listemulakatolustur'])->name('listnewinterview')->middleware('permission:mulakat-olustur');
    Route::post('/panel/aktif-mulakat-olustur', [PanelController::class, 'aktifmulakatolustur'])->name('aktif-mulakat-olustur');
    Route::post('/panel/Basvuru-Aday-Bilgileri-Kaydet', [PanelController::class, 'saveNewRelationInfos'])->name('new-relation-profile-form')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/Aktif-Bursiyer-Bilgileri-Kaydet', [PanelController::class, 'saveActiveRelationInfos'])->name('active-relation-profile-form')->middleware('permission:aktif-bursiyer-bilgileri-kaydet');
    Route::post('/panel/Mezun-Bursiyer-Bilgileri-Kaydet', [PanelController::class, 'saveMezunRelationInfos'])->name('mezun-relation-profile-form')->middleware('permission:aktif-bursiyer-bilgileri-kaydet');

    // Periods
    Route::get('/panel/Donem-Yonetimi', [PeriodController::class, 'getPeriods'])->name('period-management')->middleware('permission:donem-yonetimi-yonet');
    Route::post('/panel/Kayit-Donemi-Olustur', [PeriodController::class, 'addNewPeriod'])->name('add-new-period')->middleware('permission:kayit-donemi-olustur');
    Route::get('/panel/Donem-Duzenle/{id}', [PeriodController::class, 'editPeriod'])->name('edit-period')->middleware('permission:donem-yonetimi-yonet');
    Route::post('/panel/Donem-Guncelle/{id}', [PeriodController::class, 'updatePeriod'])->name('update-period')->middleware('permission:donem-yonetimi-yonet');
    Route::delete('/panel/Donem-Sil/{id}', [PeriodController::class, 'deletePeriod'])->name('delete-period')->middleware('permission:donem-yonetimi-yonet');
    Route::get('/panel/Donem-Yonetimi-Durum-Degis/{id}/{durum}', [PeriodController::class, 'changePeriodStatus'])->name('change-period-status')->middleware('permission:donem-yonetimi-guncelle');
    Route::get('/panel/Donem-Yonetimi-Baslat-Bitir/{id}', [PeriodController::class, 'periodStartStop'])->name('period-start-stop')->middleware('permission:donem-yonetimi-guncelle');
    // Kardes Islemleri

    Route::post('/panel/KY-Kardes-Ekle', [PanelController::class, 'addReNewScholarSibling'])->name('addReNewScholarSibling')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/KY-Burs-Ekle', [PanelController::class, 'addRenewScholarScholarShip'])->name('addRenewScholarScholarShip')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/Aktif-Kardes-Ekle-Crm', [PanelController::class, 'crmAddNewScholarSibling'])->name('kardesEkle.crm')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/Aday-Kardes-Duzenle', [PanelController::class, 'editNewSiblingDetail'])->name('editNewSiblingDetail')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/KY-Kardes-Duzenle', [PanelController::class, 'editRenewSiblingDetail'])->name('editRenewSiblingDetail')->middleware('permission:basvuru-aday-bilgileri-kaydet');

    // Diger Burs Islemleri
    Route::post('/panel/Aday-Burs-Ekle', [PanelController::class, 'addNewScholarScholarShip'])->name('addNewScholarScholarShip')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/Aday-Burs-Duzenle', [PanelController::class, 'editNewScholarsDetail'])->name('editNewScholarsDetail')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::post('/panel/Ky-Burs-Duzenle', [PanelController::class, 'editRenewScholarScholarShip'])->name('editRenewScholarScholarShip')->middleware('permission:basvuru-aday-bilgileri-kaydet');
    Route::get('/panel/Aday-Sil/{id}', [NewRelationController::class, 'deletenewrelation'])->name('deletenewrelation')->middleware('permission:aday-sil');
    Route::get('/panel/Bursiyer-Sil/{id}', [NewRelationController::class, 'deleteactiverelation'])->name('deleteactiverelation')->middleware('permission:bursiyer-sil');
    Route::get('/panel/ky-Sil/{id}', [NewRelationController::class, 'deleterenewrelation'])->name('deleterenewrelation')->middleware('permission:ky-sil');
    Route::post('/panel/Aday-Mulakat-Sil', [PanelController::class, 'deletenewinterview'])->name('deletenewinterview')->middleware('permission:mulakat-duzenle');
    Route::post('/panel/Aday-Mulakat-Guncelle', [PanelController::class, 'updateInterview'])->name('update-interview')->middleware('permission:mulakat-duzenle');
    Route::post('/panel/Aday-Mulakat-Sonuclandir', [PanelController::class, 'endInterview'])->name('end-interview')->middleware('permission:mulakat-duzenle');
    Route::post('/panel/aday-mulakat-olustur', [PanelController::class, 'adaymulakatOlustur'])->name('newcreateInterviewToNew')->middleware('permission:mulakat-olustur');

    Route::get('/panel/logout', [PanelController::class, 'logout'])->name('panel-logout');

    Route::get('/panel/tekliMezunEt/{id}', [NewRelationController::class, 'tekliMezunEt'])->name('tekliMezunEt')->middleware('permission:mezun-et');
    Route::get('/panel/tekliiptalet/{id}', [NewRelationController::class, 'tekliiptalet'])->name('activeIptalEt')->middleware('permission:bursiyer-iptal');

    Route::get('/panel/Mezun-Incele/{id}', [PanelController::class, 'graduateScholarDetails'])->name('panel-mezun-bursiyer-incele')->middleware('permission:mezun-incele');
    Route::get('/panel/Mezun-Geri-Al/{id}', [NewRelationController::class, 'geriAl'])->name('panel-mezun-geri-al')->middleware('permission:mezun-geri-al');
    Route::get('/panel/Mezunu-Geri-Al/{id}', [NewRelationController::class, 'mezunprofildengerial'])->name('panel-mezun-geri-al-profil')->middleware('permission:mezun-geri-al');

    Route::get('/panel/Bursiyer-Ekle/Aday', [NewRelationController::class, 'adayEkle'])->name('add-manuel-new')->middleware('permission:aday-ekle');
    Route::get('/panel/Bursiyer-Ekle/Bursiyer', [NewRelationController::class, 'bursiyerekle'])->name('add-manuel-active')->middleware('permission:bursiyer-ekle');
    Route::get('/panel/Bursiyer-Ekle/Mezun', [NewRelationController::class, 'tekliMezunEt'])->name('add-manuel-mezun')->middleware('permission:mezun-ekle');
    Route::get('/panel/Bursiyer-Ekle/Kayit-Yenileme', [PanelController::class, 'addmanuelrenew'])->name('add-manuel-renew')->middleware('permission:kayit-yenileme-ekle');

    // Belge Islemleri
    Route::post('/upload-panel', [PanelController::class, 'uploadNewScholarDocs'])->name('file.upload.newscholars');
    Route::post('/upload-panel-active', [PanelController::class, 'uploadScholarDocs'])->name('file.upload.scholars');
    Route::post('/upload-panel-ky', [PanelController::class, 'uploadRenewScholarDocs'])->name('file.upload.renewscholars');
    Route::post('/change-status-new-panel', [PanelController::class, 'changeStatusNewScholarships'])->name('file.changestatus.newscholars');
    Route::post('/change-status-renew-panel', [PanelController::class, 'changeStatusRenewScholarships'])->name('file.changestatus.renewscholars');
    Route::get('/delete-doc-panel/{id}/{tc}', [PanelController::class, 'deleteNewScholarDocs'])->name('file.delete.panel.newscholars');

    Route::delete('/delete-renew-doc-panel/{dosya}/{form}', [PanelController::class, 'deleteReNewScholarDocs'])->name('file.delete.panel.renewscholars');
    Route::delete('/delete-active-doc-panel/{key}/{tc}/{period}', [PanelController::class, 'deleteScholarDocs'])->name('file.delete.panel.scholars');

    Route::post('/panel/Mulakat-bilgi', [PanelController::class, 'mulakatdetail'])->name('mulakatdetail');
    Route::post('/get-students-by-school-type', [BursOdemeController::class, 'getStudentsBySchoolType'])->name('get.students.by.school.type');
    Route::post('/get-burs-tipleri-by-school-type', [BursOdemeController::class, 'getBursTipleriBySchoolType'])->name('get.burs.tipleri.by.school.type');
    Route::post('/get-burs-taksitleri-by-burs-tipi', [BursOdemeController::class, 'getBursTaksitleriByBursTipi'])->name('get.burs.taksitleri.by.burs.tipi');
    // Tanimlar
    Route::get('/panel/Iller', [IlController::class, 'index'])->name('get-provinces')->middleware('permission:il-yonet');
    Route::get('/panel/Iller/data', [IlController::class, 'getData'])->name('provinces.data')->middleware('permission:il-yonet');
    Route::get('/panel/Il-Detay/{id}', [PanelController::class, 'ilIncele'])->name('detail-province')->middleware('permission:il-yonet');
    Route::get('/panel/Il-Sil/{id}', [PanelController::class, 'ilSil'])->name('delete-province')->middleware('permission:il-yonet');
    Route::get('/panel/Il-Ekle', [PanelController::class, 'ilekle'])->name('add-province')->middleware('permission:il-yonet');
    Route::post('/panel/Il-Ekle', [PanelController::class, 'ilStore'])->name('store-province')->middleware('permission:il-yonet');
    Route::post('/panel/Il-Duzenle', [PanelController::class, 'ilUpdate'])->name('update-province')->middleware('permission:il-yonet');
    Route::post('/il-Toplu-Sil', [IlController::class, 'ilTopluIslem'])->name('delete_multiple_province')->middleware('permission:il-yonet');

    Route::get('/panel/Ilceler', [IlceController::class, 'index'])->name('get-districts')->middleware('permission:ilce-yonet');
    Route::get('/panel/Ilceler/data', [IlceController::class, 'getData'])->name('districts.data')->middleware('permission:ilce-yonet');
    Route::get('/panel/Ilce-Ekle', [PanelController::class, 'ilceEkle'])->name('add-district')->middleware('permission:ilce-yonet');
    Route::get('/panel/Ilce-Detay/{id}', [PanelController::class, 'ilceIncele'])->name('detail-district')->middleware('permission:ilce-yonet');
    Route::get('/panel/Ilce-Sil/{id}', [PanelController::class, 'ilceSil'])->name('delete-district')->middleware('permission:ilce-yonet');
    Route::post('/panel/Ilce-Ekle', [PanelController::class, 'ilceStore'])->name('store-district')->middleware('permission:ilce-yonet');
    Route::post('/panel/Ilce-Duzenle', [PanelController::class, 'ilceUpdate'])->name('update-district')->middleware('permission:ilce-yonet');
    Route::post('/ilce-Toplu-Sil', [IlceController::class, 'ilceTopluSil'])->name('delete-multiple-district')->middleware('permission:ilce-yonet');

    Route::get('/panel/Bankalar', [BankaController::class, 'index'])->name('get-banks')->middleware('permission:banka-yonet');
    Route::get('/panel/Bankalar/data', [BankaController::class, 'getData'])->name('banks.data')->middleware('permission:banka-yonet');
    Route::get('/panel/Banka-Ekle', [PanelController::class, 'bankaekle'])->name('add-bank')->middleware('permission:banka-yonet');
    Route::get('/panel/Banka-Detay/{id}', [PanelController::class, 'bankaIncele'])->name('detail-bank')->middleware('permission:banka-yonet');
    Route::post('/panel/Banka-Ekle', [PanelController::class, 'bankastore'])->name('store-bank')->middleware('permission:banka-yonet');
    Route::post('/panel/Banka-Duzenle', [PanelController::class, 'bankaupdate'])->name('update-bank')->middleware('permission:banka-yonet');
    Route::get('/panel/Banka-Sil/{id}', [PanelController::class, 'bankaSil'])->name('delete-bank')->middleware('permission:banka-yonet');
    Route::post('/Banka-Toplu-Sil', [PanelController::class, 'bankaTopluSil'])->name('delete_multiple_bank')->middleware('permission:banka-yonet');

    Route::get('/panel/Universiteler', [UniversiteController::class, 'index'])->name('get-univercities')->middleware('permission:universite-yonet');
    Route::get('/panel/Universiteler/data', [UniversiteController::class, 'getData'])->name('get-univercities.data')->middleware('permission:universite-yonet');
    Route::get('/panel/Universite-Ekle', [PanelController::class, 'addUnivercity'])->name('add-univercities')->middleware('permission:universite-yonet');
    Route::get('/panel/Universite-Detay/{id}', [PanelController::class, 'editUnivercity'])->name('edit-univercities')->middleware('permission:universite-yonet');
    Route::post('/panel/Universite-Ekle', [PanelController::class, 'storeUnivercity'])->name('store-univercity')->middleware('permission:universite-yonet');
    Route::post('/Universite-Toplu-Sil', [UniversiteController::class, 'UniversiteTopluSil'])->name('delete_multiple_univercities')->middleware('permission:universite-yonet');
    Route::post('/panel/Universite-Duzenle', [PanelController::class, 'Universiteupdate'])->name('update-univercity')->middleware('permission:universite-yonet');
    Route::get('/panel/Universite-Sil/{id}', [PanelController::class, 'UniversiteSil'])->name('delete-univercity')->middleware('permission:universite-yonet');

    Route::get('/panel/Fakulteler', [FakulteController::class, 'index'])->name('get-faculties')->middleware('permission:fakulte-yonet');
    Route::get('/panel/Fakulteler/data', [FakulteController::class, 'getData'])->name('faculties.data')->middleware('permission:fakulte-yonet');
    Route::get('/panel/Fakulte-Ekle', [PanelController::class, 'addFaculty'])->name('add-faculties')->middleware('permission:fakulte-yonet');
    Route::get('/panel/Fakulte-Detay/{id}', [PanelController::class, 'editFaculty'])->name('edit-faculties')->middleware('permission:fakulte-yonet');
    Route::post('/panel/Fakulte-Ekle', [PanelController::class, 'storeFaculty'])->name('store-faculties')->middleware('permission:fakulte-yonet');
    Route::post('/Fakulte-Toplu-Sil', [FakulteController::class, 'FacultyTopluSil'])->name('delete_multiple_faculties')->middleware('permission:fakulte-yonet');
    Route::post('/panel/Fakulte-Duzenle', [PanelController::class, 'Facultyupdate'])->name('update-faculties')->middleware('permission:fakulte-yonet');
    Route::get('/panel/Fakulte-Sil/{id}', [PanelController::class, 'FaculteSil'])->name('delete-faculties')->middleware('permission:fakulte-yonet');
    Route::post('/get-university-id', [FakulteController::class, 'getUniversityId'])->name('get-university-id');
    Route::get('/get-universities', [FakulteController::class, 'getUniversities'])->name('get.universities');
    Route::post('/bulk-update-faculties', [FakulteController::class, 'bulkUpdate'])->name('bulk.update.faculties');

    Route::get('/panel/Bolumler', [BolumController::class, 'index'])->name('get-departmants')->middleware('permission:bolum-yonet');
    Route::get('/panel/Bolumler/data', [BolumController::class, 'getData'])->name('departmants.data')->middleware('permission:bolum-yonet');
    Route::get('/panel/Bolum-Ekle', [PanelController::class, 'addDepartmant'])->name('add-departmants')->middleware('permission:bolum-yonet');
    Route::get('/panel/Bolum-Detay/{id}', [PanelController::class, 'editDepartmant'])->name('edit-departmants')->middleware('permission:bolum-yonet');
    Route::post('/panel/Bolum-Ekle', [PanelController::class, 'storeDepartmant'])->name('store-departmants')->middleware('permission:bolum-yonet');
    Route::post('/Bolum-Toplu-Sil', [BolumController::class, 'DepartmantTopluSil'])->name('delete_multiple_departmants')->middleware('permission:bolum-yonet');
    Route::post('/panel/Bolum-Duzenle', [PanelController::class, 'Departmantupdate'])->name('update-departmants')->middleware('permission:bolum-yonet');
    Route::get('/panel/Bolum-Sil/{id}', [PanelController::class, 'DepartmantSil'])->name('delete-departmants')->middleware('permission:bolum-yonet');

    // Ayarlar
    Route::get('/mail-settings', [MailController::class, 'index'])->name('mail.settings')->middleware('permission:mail-ayarlari-yonet');
    Route::post('/mail-settings', [MailController::class, 'update'])->name('mail.settings.update');
    Route::get('/panel/Ayarlar/Mail-Ayarlari', [PanelController::class, 'getDepartmants'])->name('mail-settings')->middleware('permission:mail-ayarlari-yonet');

    Route::get('/panel/Ayarlar/Sms-Ayarlari', [SmsController::class, 'getSmsSettings'])->name('sms.settings');
    Route::post('/panel-sms-ayar-ekle', [SmsController::class, 'smsSettingStore'])->name('sms.setting.store');
    Route::get('/panel/Ayarlar/Sms-Ayari-Ekle', [SmsController::class, 'addSmsSetting'])->name('add.sms.setting');

    Route::post('/sms-test', [SmsController::class, 'testSms'])->name('sms.test');
    Route::post('/sms-settings/update', [SmsController::class, 'updateSettings'])->name('sms.settings.update');

    // Data Export (Legacy - kept for compatibility)
    // Route::post('/export/{type}', [App\Http\Controllers\ExportController::class, 'export'])->name('export');
    // Data Import
    Route::prefix('Panel/Data-Import')->group(function () {
        Route::get('/', [DataImportController::class, 'index'])->name('data-import.index')->middleware('permission:data-import');
        Route::get('/data', [DataImportController::class, 'getData'])->name('data-import.data')->middleware('permission:data-import');
        Route::get('/Ekle', [DataImportController::class, 'create'])->name('data-import.create')->middleware('permission:data-import');
        Route::post('/store', [DataImportController::class, 'store'])->name('data-import.store')->middleware('permission:data-import');
        Route::get('/Duzenle/{id}', [DataImportController::class, 'edit'])->name('data-import.edit')->middleware('permission:data-import');
        Route::get('/Sil/{id}', [DataImportController::class, 'delete'])->name('data-import.delete')->middleware('permission:data-import');
        Route::put('/update/{id}', [DataImportController::class, 'update'])->name('data-import.update')->middleware('permission:data-import');
        Route::get('/Detay/{id}', [DataImportController::class, 'details'])->name('data-import.details')->middleware('permission:data-import');
        Route::post('/Sil', [DataImportController::class, 'destroy'])->name('data-import.destroy')->middleware('permission:data-import');
        Route::post('/delete-bulk', [DataImportController::class, 'deleteBulk'])->name('data-import.delete-bulk')->middleware('permission:data-import');
        Route::post('/upload', [DataImportController::class, 'upload'])->name('data-import.upload');
        Route::get('/get-excel-headers', [DataImportController::class, 'getExcelHeaders'])->name('data-import.headers');
        Route::get('/get-db-columns', [DataImportController::class, 'getDbColumns'])->name('data-import.columns');
        Route::post('/process', [DataImportController::class, 'processImport'])->name('data-import.process')->middleware('permission:data-import');
        Route::get('/example-file-download/{type}', [DataImportController::class, 'exampleFileDownload'])->name('data-import.example-file-download');
    });
    // Mulakat Gruplarii
    Route::prefix('Panel/Mulakat-Grup')->group(function () {
        Route::get('/', [InterviewGroupController::class, 'index'])->name('mulakat-grup.index')->middleware('permission:mulakat-grup-yonet');
        Route::get('/Ekle', [InterviewGroupController::class, 'create'])->name('mulakat-grup.create')->middleware('permission:mulakat-grup-yonet');
        Route::post('/Ekle', [InterviewGroupController::class, 'store'])->name('mulakat-grup.store')->middleware('permission:mulakat-grup-yonet');
        Route::get('/Duzenle/{group}', [InterviewGroupController::class, 'edit'])->name('mulakat-grup.edit')->middleware('permission:mulakat-grup-yonet');
        Route::put('/Duzenle/{group}', [InterviewGroupController::class, 'update'])->name('mulakat-grup.update')->middleware('permission:mulakat-grup-yonet');
        Route::delete('/Sil/{group}', [InterviewGroupController::class, 'destroy'])->name('mulakat-grup.destroy')->middleware('permission:mulakat-grup-yonet');
    });
    Route::post('/get-uni-detail', [PanelController::class, 'getUniDetails'])->name('get-uni-details');
    // Web.php
    Route::get('/get-interview/{id}', [InterviewController::class, 'getInterview']);
    Route::post('/update-interview/{id}', [InterviewController::class, 'updateInterview'])->middleware('permission:mulakat-duzenle');
    Route::post('/update-interviews', [InterviewController::class, 'updateInterviews'])->name('updateInterviews')->middleware('permission:mulakat-duzenle');
    Route::post('/update-interviews-toplu', [InterviewController::class, 'mulakatSayfasindanDuzenle'])->name('updateInterviewsMulakatSayfasindan')->middleware('permission:mulakat-duzenle');
    Route::post('/result-interviews', [InterviewController::class, 'resultInterviews'])->name('resultInterviews')->middleware('permission:mulakat-duzenle');
    Route::put('/conclude-interview/{id}', [InterviewController::class, 'concludeInterview'])->middleware('permission:mulakat-duzenle');

    Route::get('/panel/onay/{id}', [NewRelationController::class, 'addConfirmedScholar'])->name('confirm-scholar')->middleware('permission:aday-durum-degis');

    // Mail ve Sms
    Route::post('/panel/send-mail', [PanelController::class, 'send_mail'])->name('send-mail-scholar-list')->middleware('permission:mail-gonder');

    Route::get('/panel/Mail-Gonder/{eposta}', [PanelController::class, 'sendMail'])->name('getScholarMailForm')->middleware('permission:mail-gonder');
    Route::get('/redirectmultiplemail', [PanelController::class, 'multipleSendMailPage'])->name('redirectmultiplemail');
    Route::get('/Coklu-Sms', [PanelController::class, 'multipleSendSmsPage'])->name('Coklu-Sms');
    Route::post('/send-emails', [PanelController::class, 'multipleSendMail'])->name('send-emails')->middleware('permission:mail-gonder');
    Route::post('/send-sms', [PanelController::class, 'multipleSendSms'])->name('send-sms');
    Route::get('/coklu-sms', [PanelController::class, 'multipleSendSmsPage'])->name('Coklu-Sms');
    // Form  Sorulari
    Route::get('/panel/Form-Soru-Kategorileri', [SoruKategoriController::class, 'index'])->name('form-sorulari-kategoriler')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Soru-Kategorileri/data', [SoruKategoriController::class, 'getData'])->name('form-sorulari-kategoriler.data')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Soru-Kategori-Detay/{id}', [PanelController::class, 'formSoruKategoriDetay'])->name('panel-soru-kategori-detay')->middleware('permission:form-soru-yonet');
    Route::post('/panel/Form-Soru-Kategori-Guncelle', [PanelController::class, 'updateFormSoruKategori'])->name('panel-soru-kategori-update')->middleware('permission:form-soru-yonet');
    Route::post('/panel/Form-Soru-Kategori-Ekle', [PanelController::class, 'storeFormSoruKategori'])->name('panel-soru-kategori-ekle')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Soru-Detay/{id}', [PanelController::class, 'formSoruDetay'])->name('panel-soru-detay')->middleware('permission:form-soru-yonet');
    Route::post('/panel/Form-Soru-Ekle', [PanelController::class, 'storeFormSoru'])->name('panel-soru-ekle')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Sorulari', [SoruController::class, 'index'])->name('form-sorulari')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Sorulari/data', [SoruController::class, 'getData'])->name('form-sorulari.data')->middleware('permission:form-soru-yonet');
    Route::post('/soru-Toplu-Islem', [SoruController::class, 'soruTopluIslem'])->name('soru-toplu-islem')->middleware('permission:form-soru-yonet');
    Route::post('/panel/Form-Soru-Guncelle', [PanelController::class, 'updateFormSoru'])->name('panel-soru-update')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Form-Soru-Sil/{id}', [PanelController::class, 'formSoruSil'])->name('panel-soru-sil')->middleware('permission:form-soru-yonet');
    Route::get('/panel/Basvuru-Formlari', [PanelController::class, 'basvuruFormlariGetir'])->name('basvuru-formlari')->middleware('permission:basvuru-form-yonet');
    Route::get('/panel/Basvuru-Form-Detay/{id}', [PanelController::class, 'basvuruFormDetay'])->name('panel-form-detay')->middleware('permission:basvuru-form-yonet');
    Route::post('/panel/Basvuru-Form-Guncelle', [PanelController::class, 'updateBasvuruForm'])->name('panel-form-update')->middleware('permission:basvuru-form-yonet');
    Route::get('/panel/Basvuru-Form-Soru-Cikart/{id}/{form}', [PanelController::class, 'basvuruFormSoruCikart'])->name('panel-form-delete-question')->middleware('permission:basvuru-form-yonet');
    Route::post('/panel/Basvuru-Form-Soru-Ekle', [PanelController::class, 'basvuruFormSoruEkle'])->name('panel-form-soru-ekle')->middleware('permission:basvuru-form-yonet');
    Route::post('/panel/Toplu-BV-Duzenle', [PanelController::class, 'topluBvDuzenle'])->name('toplu-bv-duzenle');

    // AYARLAR - OTP AYARLARI
    Route::prefix('/panel/Otp-Ayarlari')->name('otp-setting.')->group(function () {
        Route::get('/', [OtpSettingController::class, 'index'])->name('index');
        Route::post('/', [OtpSettingController::class, 'update'])->name('update');
    });
    Route::prefix('/panel/Versiyonlar')->name('versions.')->group(function () {
        Route::get('/', [VersionController::class, 'index'])->name('index');
        Route::get('/Ekle', [VersionController::class, 'create'])->name('create');
        Route::get('/data', [VersionController::class, 'getData'])->name('data');
        Route::post('/', [VersionController::class, 'store'])->name('store');
        Route::get('/{id}/Duzenle', [VersionController::class, 'edit'])->name('edit');
        Route::put('/guncelle/{version}', [VersionController::class, 'update'])->name('update');
        Route::post('/Sil', [VersionController::class, 'destroy'])->name('destroy');
        Route::get('/Sil/{id}', [VersionController::class, 'delete'])->name('delete');
    });
    Route::prefix('/panel/Burs-Tipleri')->name('burs-tipleri.')->group(function () {
        Route::get('/', [TanimBursTipiController::class, 'index'])->name('index');
        Route::get('/Ekle', [TanimBursTipiController::class, 'create'])->name('create');
        Route::get('/data', [TanimBursTipiController::class, 'getData'])->name('data');
        Route::post('/', [TanimBursTipiController::class, 'store'])->name('store');
        Route::get('/{id}/Duzenle', [TanimBursTipiController::class, 'edit'])->name('edit');
        Route::post('/guncelle', [TanimBursTipiController::class, 'update'])->name('update');
        Route::get('/Sil/{id}', [TanimBursTipiController::class, 'delete'])->name('delete');
        Route::post('/Toplu-Sil', [TanimBursTipiController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/panel/Burs-Taksitleri')->name('burs-taksitleri.')->group(function () {
        Route::get('/', [BursTaksitiController::class, 'index'])->name('index');
        Route::get('/Ekle', [BursTaksitiController::class, 'create'])->name('create');
        Route::get('/data', [BursTaksitiController::class, 'getData'])->name('data');
        Route::post('/', [BursTaksitiController::class, 'store'])->name('store');
        Route::get('/{id}/Duzenle', [BursTaksitiController::class, 'edit'])->name('edit');
        Route::post('/guncelle', [BursTaksitiController::class, 'update'])->name('update');
        Route::get('/Sil/{id}', [BursTaksitiController::class, 'delete'])->name('delete');
        Route::post('/Toplu-Sil', [BursTaksitiController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('/Panel/Sebep')->name('sebep.')->group(function () {
        Route::get('/', [SebepController::class, 'index'])->name('index');
        Route::get('/Ekle', [SebepController::class, 'create'])->name('create');
        Route::post('/', [SebepController::class, 'store'])->name('store');
        Route::get('/data', [SebepController::class, 'getData'])->name('data');
        Route::get('/{id}/Duzenle', [SebepController::class, 'edit'])->name('edit');
        Route::post('/guncelle', [SebepController::class, 'update'])->name('update');
        Route::get('/Sil/{id}', [SebepController::class, 'delete'])->name('delete');
        Route::post('/Toplu-Islem', [SebepController::class, 'bulkAction'])->name('bulk-action');
    });

});
Route::get('/delete/{id}', [FormController::class, 'delete'])->name('file.delete');
Route::get('/delete/ky/{id}/{file}', [PanelController::class, 'deleteRenewScholarDocsPortal'])->name('file.delete.portal.renewscholars.ky');
Route::get('/Student/application_form_associate', [StudentController::class, 'application_form_associate'])->name('application_form_associate');
Route::post('/Burs-Basvuru-Cevaplari-Isle', [FormController::class, 'formSorulariAl'])->name('get-form-answers');
Route::post('/save-step-data', [FormController::class, 'saveStepData']);
Route::post('/aday-points', [AdayPointController::class, 'store']);
Route::get('/delete-point/{id}', [AdayPointController::class, 'destroy'])->name('panel.deletePoint');
Route::post('/save-step-data-renew', [FormController::class, 'renewsaveStepData']);

Route::get('/Yeni-Burs-Basvurusu', [StudentAuthController::class, 'adayLoginForm'])->name('aday.login.view');
Route::get('/Giris-Kodu-Onayla', [StudentAuthController::class, 'adayOtpFormuAc'])->name('aday.otp.verify');
Route::get('/Giris-Kodu-Onayla', [StudentAuthController::class, 'adayTekrarGirisOtpFormuAc'])->name('aday.otp2.verify');
Route::get('/otptekrargonder', [StudentAuthController::class, 'otptekrargonder'])->name('otptekrargonder');
Route::post('/otp-verify', [StudentAuthController::class, 'verifyOtp'])->name('otp.verify.post');
Route::post('/new-login-control', [StudentAuthController::class, 'loginChechAfterNew'])->name('student.active.login.post');
Route::post('/otp-verify2', [StudentAuthController::class, 'verifyOtp2'])->name('otp.verify.post2');

Route::post('/aday-login', [StudentAuthController::class, 'adayLogin'])->name('aday.login');
Route::post('/upload', [FormController::class, 'upload'])->name('file.upload');
Route::post('/upload-renew', [FormController::class, 'renewupload'])->name('file.upload.renew');
Route::post('/aktif-login', [StudentAuthController::class, 'aktifLogin']);
Route::post('/mezun-login', [StudentAuthController::class, 'mezunLogin']);
Route::post('/form/kardes-ekle', [FormController::class, 'kardesEkle']);
Route::post('/form/ky-kardes-ekle', [FormController::class, 'kyKardesEkle']);
Route::get('/form/ky-kardes-sil/{id}', [FormController::class, 'kyKardesSil']);
Route::post('/form/burs-ekle', [FormController::class, 'bursEkle']);
Route::post('/form/ky-burs-ekle', [FormController::class, 'kyBursEkle']);
Route::get('/form/ky-burs-sil/{id}', [FormController::class, 'kyBursSil']);
Route::post('/Sifre-Yenileme-Maili', [StudentAuthController::class, 'sifirlamaMailiGonder'])->name('student-password-link-reset');
Route::get('/get-districts/{id}', [OrtakController::class, 'getDistrictByCityId']);
// formlar icin tiklayinca gelen fonksiyonlar

Route::get('/get-district-by-selected-city-id/{id}', [OrtakController::class, 'getDistrictBySelectedCityId']);
Route::get('/get-universities-by-selected-city/{city}', [OrtakController::class, 'getUniversitiesBySelectedCity']);
Route::get('/get-faculties-by-selected-university/{university}', [OrtakController::class, 'getFacultiesBySelectedUniversity']);
Route::get('/get-departments-by-selected-faculty/{faculty}', [OrtakController::class, 'getDepartmentsBySelectedFaculty']);
Route::get('/student/Sifremi-Unuttum', [StudentAuthController::class, 'sifremiUnuttum'])->name('student-forgot-password');

Route::get('/Link-Kontrol/{code}', [StudentAuthController::class, 'checkResetCode']);
Route::prefix('student')->group(function () {
    Route::get('', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::get('login', [RenewStudentAuthController::class, 'showLoginForm'])->name('student.active.login');
    Route::get('Logout', [StudentAuthController::class, 'logoutall'])->name('student-logout');

    // Aday Islemleri
    Route::get('Aday-Girisi', [StudentAuthController::class, 'showLoginForm'])->name('student.new.login');
    Route::post('/Bursiyer-Girisi', [StudentAuthController::class, 'newLogin'])->name('newLoginPost');

    Route::post('login', [StudentAuthController::class, 'login'])->name('student.new.login.check');

    Route::middleware(['auth.students'])->group(function () {
        Route::get('/Basvuru-Tipi', [StudentController::class, 'formTipiSec'])->name('student_select_type');

        Route::get('/aday/Basvurularim', [StudentController::class, 'adayBasvurularim'])->name('findmy_relations_forms');
        Route::post('/student/change-password', [StudentController::class, 'changePassword'])->name('student.changePassword');
        Route::get('/Profilim', [StudentController::class, 'studentProfile'])->name('student-profile');
        Route::get('/Basvuru-Tipi/{tip}', [StudentController::class, 'ogretimListesiGetir'])->name('get_education_type');
        Route::get('/Burs-Basvuru-Formu/{tip}', [StudentController::class, 'formTipiGetir'])->name('get_scholarship_form');
        Route::get('/Burs-Basvuru-Formu/', [StudentController::class, 'formTipiGetirdinamik'])->name('get_scholarship_form_dynamic');
        Route::get('/Kayit-Yenileme-Formu/{id}', [StudentController::class, 'kayitYenilemeFormuGetir'])->name('get_renewscholarship_form');
        Route::get('/Kayit-Yenileme-Formu/', [StudentController::class, 'kayitYenilemeFormuGetirdinamik'])->name('get_renewscholarship_form');
        Route::get('/Kayit-Yenileme-Tamamla/{id}', [StudentController::class, 'kayitYenilemeFormuGonder'])->name('send_renew_form');
        Route::get('/Basvuru-Tamamla', [StudentController::class, 'basvuruTamamla'])->name('confirm-scholarshop-form');

    });

    Route::get('/active/forgot-password', [StudentAuthController::class, 'newStudentForgotPassword'])->name('student.active.forgot-password');
    Route::post('logout', [StudentAuthController::class, 'logout'])->name('student.logout');

    Route::middleware(['auth:student'])->group(function () {
        Route::get('/Burs-Basvur', [StudentController::class, 'formTipiSec'])->name('burs-basvur-tipi-sec');
        // Route::get('/Panelim', [StudentController::class, 'formTipiSec'])->name('application_form_associate');

    });
});

Route::get('/burs-odeme/create', [BursOdemeController::class, 'create'])->name('burs-odeme.create');
Route::post('/burs-odeme', [BursOdemeController::class, 'store'])->name('burs-odeme.store');
Route::get('/check-auth', function () {
    if (auth('aday')->check()) {
        $user = auth('aday')->user();

        return $user;

        return "Oturum açık\n".
               "Kullanıcı: {$user->ad} {$user->soyad}\n".
               "E-posta: {$user->eposta_adresi}\n".
               "Telefon: {$user->cep_telefonu}";
    }

    return 'Oturum açık değil';
})->name('check.auth');

Route::get('/Active-Toplu-Islem-Download', [NewRelationController::class, 'ActiveTopluIslemDownload']);
Route::get('/Mezun-Toplu-Islem-Download', [NewRelationController::class, 'MezunTopluIslemDownload']);

Route::get('/KY-Toplu-Islem-Download', [NewRelationController::class, 'KYTopluIslemDownload'])->name('ky_toplu_islem_download')->middleware('permission:ky-toplu-islem');

// SMS Routes
Route::get('/send-sms', [App\Http\Controllers\SmsController::class, 'index'])->name('send.sms');
Route::post('/send-bulk-sms', [SmsController::class, 'sendBulkSmsToSelected'])->name('send.bulk.sms');

Route::get('/check-sms-status/{bulkId}', [SmsController::class, 'checkSmsStatus'])->name('check.sms.status');

// Yeni route ekleyelim
Route::post('/prepare-sms-session', [PanelController::class, 'prepareSmsSession'])->name('prepare.sms.session');
Route::get('/sms-gonder', [PanelController::class, 'smsPage'])->name('sms.page');

Route::get('/bursiyer-aday-sutun-ekle', [AdayBursiyerController::class, 'bursiyerAdaySutunEkle'])->name('bursiyer-aday-sutun-ekle');

Route::get('/ornek-veri-ekle', [PanelController::class, 'ornekVeriEkle']);

Route::post('/panel/settings/users/{id}/change-status', [App\Http\Controllers\UserController::class, 'changeStatus'])->name('users.change-status');
Route::get('/check-db-columns', [PanelController::class, 'checkDbColumns']);
Route::get('/soru-icerik-kontrol', [SoruController::class, 'soruIcerikKontrol']);

// MessageTemplate Routes
Route::get('/panel/tanimlar/message-template', [MessageTemplateController::class, 'index'])->name('message-template.index');
Route::get('/panel/tanimlar/message-template/create', [MessageTemplateController::class, 'create'])->name('message-template.create');
Route::post('/panel/tanimlar/message-template', [MessageTemplateController::class, 'store'])->name('message-template.store');
Route::get('/panel/tanimlar/message-template/{id}/edit', [MessageTemplateController::class, 'edit'])->name('message-template.edit');
Route::put('/panel/tanimlar/message-template/{id}', [MessageTemplateController::class, 'update'])->name('message-template.update');
Route::delete('/panel/tanimlar/message-template/{id}', [MessageTemplateController::class, 'destroy'])->name('message-template.destroy');

// KY Form Portal
Route::post('/update-renew-form', [StudentController::class, 'updateRenewForm'])->name('update.renew.form');
Route::post('/aday-puan-hesapla', [SoruController::class, 'adayPuanHesapla'])->name('aday-puan-hesapla');

Route::get('/update-emails-to-yopmail', function () {
    $models = [\App\Models\Scholar::class, \App\Models\RenewAnswer::class, \App\Models\ActiveAnswer::class];
    foreach ($models as $model) {
        $model::where('email', 'like', '%@%')->each(function ($item) {
            $item->update(['email' => explode('@', $item->email)[0].'@yopmail.com']);
        });
    }

    return 'Emails updated successfully.';
});
Route::get('/kydonemduzelt/{type}/{educ}', [KydonemduzeltController::class, 'start'])->name('kydonemduzelt');

Route::get('/migration-view', [KydonemduzeltController::class, 'showMigrationView']);
Route::get('/migration-scholars', [KydonemduzeltController::class, 'getMigrationScholars']);
Route::post('/migration-batch', [KydonemduzeltController::class, 'migrateBatch']);

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/dosya-kontrol', [KydonemduzeltController::class, 'showActiveAnswerFileRepair'])->name('active-answer-file-repair.index');
    Route::post('/panel/active-answer-file-repair/scholars', [KydonemduzeltController::class, 'getActiveAnswerFileRepairScholars'])->name('active-answer-file-repair.scholars');
    Route::post('/panel/active-answer-file-repair/process', [KydonemduzeltController::class, 'processActiveAnswerFileRepair'])->name('active-answer-file-repair.process');
    Route::post('/panel/active-answer-file-repair/export-results', [KydonemduzeltController::class, 'exportActiveAnswerFileRepairResults'])->name('active-answer-file-repair.export-results');
    Route::post('/panel/active-answer-file-repair/folder-files', [KydonemduzeltController::class, 'getScholarFolderFiles'])->name('active-answer-file-repair.folder-files');
    Route::post('/panel/active-answer-file-repair/export-folder-files', [KydonemduzeltController::class, 'exportScholarFolderFiles'])->name('active-answer-file-repair.export-folder-files');
    Route::post('/panel/active-answer-file-repair/reset-test-data', [KydonemduzeltController::class, 'resetFileRepairTestData'])->name('active-answer-file-repair.reset-test-data');
});
