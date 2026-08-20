@props(['candidate', 'siblings' => [], 'scholarships' => [], 'period' => null, 'cities' => [], 'foto_url' => null])

<!-- PDF İndir Butonu -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applicationFormModal">
    Burs Başvuru Formu
</button>

<!-- Başvuru Formu Modal -->
<div class="modal fade" id="applicationFormModal" tabindex="-1" aria-labelledby="applicationFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title" id="applicationFormModalLabel">Başvuru Formu</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-danger" id="downloadPdf">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M16.6673 7.5H13.334V2.5H6.66732V7.5H3.33398L10.0007 14.1667L16.6673 7.5ZM3.33398 15.8333V17.5H16.6673V15.8333H3.33398Z" fill="white"/>
                        </svg>
                        PDF İndir
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
            <div class="modal-body w-100" id="applicationFormContent">
                <style>
                    @media screen {
                        .pdf-category {
                            min-height: auto; /* Allow flexible height */
                            width: 100% !important; /* Full width to override Bootstrap */
                            max-width: 210mm; /* A4 width */
                            margin: 0 auto 20mm auto; /* Add bottom margin between categories */
                            padding: 10mm;
                            box-sizing: border-box;
                            page-break-after: always;
                            page-break-inside: avoid;
                            overflow: visible; /* Allow content to be visible */
                            display: block !important;
                            float: none !important;
                            clear: both;
                            border: 1px solid #e0e0e0; /* Add border to see category boundaries */
                            background-color: #fff;
                        }

                        .pdf-category:last-child {
                            page-break-after: auto;
                        }

                        .pdf-category h3 {
                            margin-top: 0;
                            margin-bottom: 15px;
                            font-size: 18px;
                            font-weight: bold;
                            border-bottom: 2px solid #007bff;
                            padding-bottom: 5px;
                        }

                        .pdf-category .form-group {
                            margin-bottom: 8px;
                            page-break-inside: avoid;
                        }

                        .pdf-category .custom-label {
                            font-weight: bold;
                            font-size: 12px;
                            margin-bottom: 3px;
                            display: block;
                        }

                        .pdf-category p {
                            font-size: 11px;
                            margin: 0;
                            padding: 2px 0;
                            line-height: 1.3;
                        }

                        .pdf-category .row {
                            margin-bottom: 5px;
                        }

                        .pdf-category table {
                            font-size: 10px;
                            width: 100%;
                            margin-bottom: 10px;
                        }

                        .pdf-category table th,
                        .pdf-category table td {
                            padding: 4px;
                            font-size: 10px;
                        }

                        .checkbox-display {
                            font-size: 14px;
                            margin-right: 5px;
                        }
                    }

                    @media print {
                        .pdf-category {
                            min-height: auto;
                            width: 100% !important;
                            max-width: 210mm;
                            margin: 0 auto;
                            padding: 10mm;
                            box-sizing: border-box;
                            page-break-after: always;
                            page-break-inside: avoid;
                            display: block !important;
                            float: none !important;
                            clear: both;
                            overflow: visible;
                        }

                        /* Override Bootstrap grid system for PDF */
                        #applicationFormContent .d-flex {
                            display: block !important;
                        }

                        #applicationFormContent .flex-row {
                            flex-direction: column !important;
                        }

                        #applicationFormContent .col-md-12 {
                            width: 100% !important;
                            flex: none !important;
                            max-width: none !important;
                        }
                    }
                </style>
                <div class="container mt-3">
                    <div class="pdf-container">
                        <style>
                            .pdf-container {
                                display: block !important;
                                width: 100%;
                            }

                            .pdf-container .d-flex.flex-row {
                                display: block !important;
                                flex-direction: column !important;
                            }
                        </style>

                        <!-- Genel Bilgiler -->
                        <div class="col-md-12 pdf-category">
                            <div style="border-bottom:2px solid #007bff" class="d-flex justify-content-between position-relative">
                                <h3 style="border:none;">Genel Bilgiler</h3>
                                <img id="foto_url" src="{{ $foto_url ? url($foto_url) : '../../assets/images/default-profile.svg' }}" alt="Fotoğraf" class="img-fluid rounded-circle" style="width: 150px; height: 150px; border:2px solid #007bff; position: absolute; right: 0; top: -25px;">
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Adı</label>
                                    <p>{{ $candidate->name ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Soyadı</label>
                                    <p>{{ $candidate->surname ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">TC Kimlik Numarası</label>
                                    <p>{{ $candidate->tc_no ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">E-Posta</label>
                                    <p>{{ $candidate->email ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Telefon</label>
                                    <p>{{ $candidate->tel_no ?? '' }}</p>
                                </div>
                                <!--<div class="col-md-6 form-group">
                                    <label class="custom-label">Şube</label>
                                    <p>{{ $candidate->sube ?? '' }}</p>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Bursiyer Tipi</label>
                                    <p>{{ $candidate->aday_turu ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Aday No.</label>
                                    <p>{{ $candidate->id ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if(($candidate->check_taahhutname ?? '') == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Taahhütname'yi</u> okudum, kabul ediyorum
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if(($candidate->check_ailebireyleri ?? '') == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Bursiyer Aile Bireyleri Aydınlatma Metni'ni</u> okudum, anladım.
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if(($candidate->check_acikriza ?? '') == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>Bursiyer Açık Rıza Formu'nu okudum, kabul ediyorum.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if(($candidate->check_aydinlatma ?? '') == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        <u>KVKK Kurallarının gereksinimlerini kabul ederim.</u>
                                    </p>
                                </div>
                                <div class="col-md-6 form-check">
                                    <span class="checkbox-display">@if(($candidate->check_bilgidogrulama ?? '') == 'on') ☑ @else ☐ @endif</span>
                                    <p class="form-check-label mt-1">
                                        Başvuru formunda beyan ettiğim bilgilerin doğruluğunu ve
                                        gerektiğinde araştırma yapılmasını kabul ediyorum.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Kişisel Bilgiler -->
                        <div class="col-md-12 pdf-category">
                            <h3>Kişisel Bilgiler</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğum Tarihi</label>
                                    <p>{{ $candidate->b_dob ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu Şehir</label>
                                    <p>{{ $candidate->born_city ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Doğduğu İlçe</label>
                                    <p>{{ $candidate->born_district ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İl</label>
                                    <p>{{ $candidate->registered_city ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Nüfusa Kayıtlı Olduğu İlçe</label>
                                    <p>{{ $candidate->registered_district ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Cinsiyet</label>
                                    <p>{{ $candidate->gender ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Medeni Durumu</label>
                                    <p>{{ $candidate->maritality ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Uyruk</label>
                                    <p>{{ $candidate->nationality ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Eğitim Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Eğitim Bilgileri</h3>
                            <div class="row">
                                <div class="form-group">
                                    <label class="custom-label">Eğitim Tipi</label>
                                    <p>{{ $candidate->educationType ?? '' }}</p>
                                    @switch($candidate->educationType ?? '')

                                    @case('ilkokul')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Tipi</label>
                                                <p>{{ $candidate->primary_educ_type ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Adı</label>
                                                <p>{{ $candidate->p_school_name ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <p>{{ $candidate->p_school_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Sınıf</label>
                                                <p>{{ $candidate->class ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Not Ortalaması</label>
                                                <p>{{ $candidate->grade_avg ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Nakil Yaptı Mı</label>
                                                <p>{{ $candidate->is_transfered ?? '' }}</p>
                                            </div>
                                        </div>
                                        @break

                                    @case('ortaokul')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Tipi</label>
                                                <p>Ortaokul</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Adı</label>
                                                <p>{{ $candidate->m_school_name ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <p>{{ $candidate->m_school_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu İlçe</label>
                                                <p>{{ $candidate->m_school_district ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Sınıfınız</label>
                                                <p>{{ $candidate->class ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Nakil Yaptı mı?</label>
                                                <p>{{ $candidate->is_transfered ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Not Ortalaması</label>
                                                <p>{{ $candidate->grade_avg ?? '' }}</p>
                                            </div>
                                        </div>
                                        @break
                                    @case('lise')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Tipi</label>
                                                <p>Lise</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okul Adı</label>
                                                <p>{{ $candidate->h_school_name ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <p>{{ $candidate->h_school_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu İlçe</label>
                                                <p>{{ $candidate->h_school_district ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Sınıfınız</label>
                                                <p>{{ $candidate->class ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Nakil Yaptı mı?</label>
                                                <p>{{ $candidate->is_transfered ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Not Ortalaması</label>
                                                <p>{{ $candidate->grade_avg ?? '' }}</p>
                                            </div>
                                        </div>
                                        @break
                                    @case('onlisans')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Bitirdiğiniz Lise</label>
                                                <p>{{ $candidate->grade_high_school ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Üniversiteye Giriş Puanınız</label>
                                                <p>{{ $candidate->entry_grade_university ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <p>{{ $candidate->university_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Üniversite</label>
                                                <p>{{ $candidate->current_university ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Fakülte</label>
                                                <p>{{ $candidate->university_faculty ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Bölüm</label>
                                                <p>{{ $candidate->grade_departmant ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Üniversitenin Statüsü</label>
                                                <p>{{ $candidate->university_type ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenim Türü</label>
                                                <p>{{ $candidate->university_types ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">{{ ($period->title ?? 'Öğretim Yılı') }} Öğretim Yılında Kaçıncı Sınıfta Olacaksınız?</label>
                                                <p>{{ $candidate->university_class ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                                <p>{{ $candidate->departmentYear ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO Sisteminiz</label>
                                                <p>{{ $candidate->agno_type ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO</label>
                                                <p>{{ $candidate->agno ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş Yaptı mı?</label>
                                                <p>{{ $candidate->university_transfer ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız</label>
                                                <p>{{ $candidate->university_transfer_desc ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız</label>
                                                <p>{{ $candidate->languages ?? '' }}</p>
                                            </div>
                                        </div>

                                        @break
                                    @case('lisans')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Bitirdiğiniz Lise</label>
                                                <p>{{ $candidate->grade_high_school ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Üniversiteye Giriş Puanınız</label>
                                                <p>{{ $candidate->entry_grade_university ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Okulun Bulunduğu Şehir</label>
                                                <p>{{ $candidate->university_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Üniversite</label>
                                                <p>{{ $candidate->current_university ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Fakülte</label>
                                                <p>{{ $candidate->university_faculty ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenime Devam Ettiğiniz Bölüm</label>
                                                <p>{{ $candidate->grade_departmant ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Üniversitenin Statüsü</label>
                                                <p>{{ $candidate->university_type ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenim Türü</label>
                                                <p>{{ $candidate->university_types ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">{{ ($period->title ?? 'Öğretim Yılı') }} Öğretim Yılında Kaçıncı Sınıfta Olacaksınız?</label>
                                                <p>{{ $candidate->university_class ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                                <p>{{ $candidate->departmentYear ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO Sisteminiz</label>
                                                <p>{{ $candidate->agno_type ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO</label>
                                                <p>{{ $candidate->agno ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş Yaptı mı?</label>
                                                <p>{{ $candidate->university_transfer ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız</label>
                                                <p>{{ $candidate->university_transfer_desc ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız</label>
                                                <p>{{ $candidate->languages ?? '' }}</p>
                                            </div>
                                        </div>
                                        @break
                                    @case('yukseklisans')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Bitirdiğiniz Üniversite</label>
                                                <p>{{ $candidate->grade_university ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Mezun Olduğunuz Bölüm</label>
                                                <p>{{ $candidate->grade_departmant ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Üniversitenin Bulunduğu Şehir</label>
                                                <p>{{ $candidate->university_city ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yüksek Lisans Yaptığınız Üniversite</label>
                                                <p>{{ $candidate->current_university ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yüksek Lisans Yaptığınız Dal</label>
                                                <p>{{ $candidate->master_field ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenci Numarası</label>
                                                <p>{{ $candidate->student_number ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">{{ ($period->title ?? 'Öğretim Yılı') }} Öğretim Yılında Kaçıncı Sınıfta Olacaksınız?</label>
                                                <p>{{ $candidate->university_class ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Öğrenim Gördüğünüz Bölüm Kaç Senelik Eğitim Veriyor? (Hazırlık Dahil)</label>
                                                <p>{{ $candidate->departmentYear ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Mezuniyet AGNO</label>
                                                <p>{{ $candidate->grade_agno ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO Sisteminiz</label>
                                                <p>{{ $candidate->agno_type ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">AGNO</label>
                                                <p>{{ $candidate->agno ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş Yaptı mı?</label>
                                                <p>{{ $candidate->university_transfer ?? '' }}</p>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label class="custom-label">Yatay/Dikey Geçiş yaptıysanız geçiş bilgilerinizi yazınız</label>
                                                <p>{{ $candidate->university_transfer_desc ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label class="custom-label">Bildiğiniz diller nelerdir? Seviyeleri ile birlikte yazınız</label>
                                            <p>{{ $candidate->languages ?? '' }}</p>
                                        </div>

                                        @break
                                @endswitch
                                </div>
                            </div>
                        </div>

                        <!--  Kalan Yer Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Kalan Yer Bilgileri</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Barınma Türü</label>
                                    <p>{{ $candidate->housing_type ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ödenen Ücret</label>
                                    <p>{{ $candidate->housing_fee ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Birlikte Yaşanılan Kişi Sayısı</label>
                                    <p>{{ $candidate->living_with_count ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kaldığı İl</label>
                                    <p>{{ $candidate->residing_city ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kaldığı İlçe</label>
                                    <p>{{ $candidate->residing_district ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Tam Adres</label>
                                    <p>{{ $candidate->address_detail ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <!--  Aile Adres Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Aile Adres Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Yaşadığı İl</label>
                                        <p>{{ $candidate->mother_city ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Yaşadığı İl</label>
                                        <p>{{ $candidate->father_city ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Yaşadığı İlçe</label>
                                        <p>{{ $candidate->mother_district ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Yaşadığı İlçe</label>
                                        <p>{{ $candidate->father_district ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Açık Adres</label>
                                        <p>{{ $candidate->parent_address ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label" for="phone">Aile Cep Telefonu</label>
                                        <p>{{ $candidate->parent_mobile ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aile Ev Telefonu</label>
                                        <p>{{ $candidate->parent_phone ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aile E-posta Adresi</label>
                                        <p>{{ $candidate->parent_email ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="urgent">
                                    <h3>Acil Durum Kişisi</h3>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Ad</label>
                                            <p>{{ $candidate->emergency_person_name ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Soyad</label>
                                            <p>{{ $candidate->emergency_person_surname ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Yakınlık Derecesi</label>
                                            <p>{{ $candidate->emergency_closeness ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">Cep Telefonu</label>
                                            <p>{{ $candidate->emergency_mobile ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="custom-label">E-Posta Adresi</label>
                                            <p>{{ $candidate->emergency_email ?? 'Belirtilmemiş' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ebeveyn Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Ebeveyn Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Baba Birlikte Mi?</label>
                                        <p>{{ $candidate->parent_together ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Sağ Mı?</label>
                                        <p>{{ $candidate->mother_alive ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba Sağ Mı?</label>
                                        <p>{{ $candidate->C9l7SUqOxSvZ ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Ad</label>
                                        <p>{{ $candidate->mother_name ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Anne Soyad</label>
                                        <p>{{ $candidate->mother_surname ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba Ad</label>
                                        <p>{{ $candidate->father_name ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Baba Soyad</label>
                                        <p>{{ $candidate->father_surname ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Mesleği</label>
                                        <p>{{ $candidate->mother_job ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Mesleği</label>
                                        <p>{{ $candidate->father_job ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Tahsil Durumu</label>
                                        <p>{{ $candidate->mother_educ ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Tahsil Durumu</label>
                                        <p>{{ $candidate->father_educ ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Annenin Bağlı Olduğu Sosyal Güvenlik Kurumu</label>
                                        <p>{{ $candidate->mother_company ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Babanın Bağlı Olduğu Sosyal Güvenlik Kurumu</label>
                                        <p>{{ $candidate->father_company ?? '' }}</p>
                                    </div>
                                </div>
                            <div class="col-md-6 form-group">
                                        <label class="custom-label">Kiminle Kalıyorsunuz?</label>
                                        <p>{{ $candidate->WAll7WvDPAjk ?? '' }}</p>
                                    </div>
                            </div>
                        </div>

                        <!-- Kardeş Bilgileri -->

                        <div class="col-md-12 pdf-category">
                            <h3>Kardeş Bilgileri</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kardeş Sayısı</label>
                                    <p>{{ $candidate->count ?? count($siblings) }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
                                    <p>{{ $candidate->educ_count ?? '' }}</p>
                                </div>
                            </div>
                            @if(count($siblings) > 0)
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Adı</th>
                                        <th>Soyadı</th>
                                        <th>Yaşı</th>
                                        <th>Öğrenim Durumu</th>
                                        <th>Medeni Durumu</th>
                                        <th>Mesleği (Çalışıyorsa)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siblings as $sibling)
                                    <tr>
                                        <td>{{ $sibling->name ?? '' }}</td>
                                        <td>{{ $sibling->surname ?? '' }}</td>
                                        <td>{{ $sibling->age ?? '' }}</td>
                                        <td>{{ $sibling->educ_status ?? '' }}</td>
                                        <td>{{ $sibling->maritality ?? '' }}</td>
                                        <td>{{ $sibling->job ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                                     @endif
                        </div>


                        <!-- Gelir Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Gelir Beyanı</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Geçmişini Kim/Kimler Sağlıyor?</label>
                                    <p>{{ $candidate->income_person ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Gelir Sağlayan Kişi/Kişiler Toplam Kaç Kişiye Bakıyor?</label>
                                    <p>{{ $candidate->total_person ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Annenin Aylık Net Geliri (TL)</label>
                                    <p>{{ $candidate->mother_salary ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Babanın Aylık Net Geliri (TL)</label>
                                    <p>{{ $candidate->father_salary ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Diğer Kişilerin Aylık Net Geliri (TL)</label>
                                    <p>{{ $candidate->other_salary ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Başka Geliri Var Mı?</label>
                                    <p>{{ $candidate->other_income ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Ailenin Yaşamakta Olduğu Ev Türü</label>
                                    <p>{{ $candidate->parent_housing_type ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Kira ise Aylık Net Kirası (TL)</label>
                                    <p>{{ $candidate->rent_count ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="custom-label">Diğer</label>
                                    <p>{{ $candidate->other_detail ?? '' }}</p>
                                </div>
                            </div>
                        </div>
  <!-- Diğer Burs Bilgileri -->

                        <div class="col-md-12 pdf-category">
                            <h3>Diğer Burs Bilgileri</h3>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Devlet Bursu Almakta mı ya da Başvurdu mu?</label>
                                    <p>{{ $candidate->government ?? '' }}</p>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="custom-label">Özel Burs Almakta ya da Başvurdu mu?</label>
                                    <p>{{ $candidate->special ?? '' }}</p>
                                </div>
                            </div>
                            @if(count($scholarships) > 0)
                        @php $count= 0; @endphp
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kurum Türü</th>
                                        <th>Kurum Adı</th>
                                        <th>Burs Tutarı</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scholarships as $scholarship)
                                    <tr>
                                        @php $count+=$scholarship->count; @endphp
                                        <td>{{ $scholarship->company_type ?? '' }}</td>
                                        <td>{{ $scholarship->company_name ?? '' }}</td>
                                        <td>{{ $scholarship->count ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2">Toplam</td>
                                        <td>{{ $count ?? '' }} ₺</td>

                                    </tr>
                                </tbody>
                            </table>
                              @endif
                        </div>

                        <!-- Engellilik Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Engel Durumu</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Herhangi Bir Engeliniz Var mı?</label>
                                        <p>{{ $candidate->disabled_status ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Engel Durumunu Açıklayınız (Varsa)</label>
                                        <p>{{ $candidate->disabled_detail ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sosyal Durum Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Sosyal Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Bizden Nasıl Haberdar Oldunuz?</label>
                                        <p>{{ $candidate->platform ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Güçlü Yanlarınızın Ne olduğunu Düşünüyorsunuz?</label>
                                        <p>{{ $candidate->skills ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Katkıda Bulunduğunuz Sosyal Projeler</label>
                                        <p>{{ $candidate->social_projects ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Hobileriniz</label>
                                        <p>{{ $candidate->hobbies ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">İlgilendiğiniz Spor Dalı (Varsa)</label>
                                        <p>{{ $candidate->sports ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Son Okuduğunuz Kitaplar</label>
                                        <p>{{ $candidate->last_books ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Bize Mesajınız</label>
                                        <p>{{ $candidate->message ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hesap Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>Hesap Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Banka</label>
                                        <p>{{ $candidate->bank_name ?? '' }}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="iban" class="form-label">IBAN</label>
                                            <p>{{ $candidate->iban ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label class="custom-label">Hesap Numarası</label>
                                            <p>{{ $candidate->account_number ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- İş Bilgileri -->
                        <div class="col-md-12 pdf-category">
                            <h3>İş Bilgileri</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="custom-label">Düzenli olarak bir kurumda kazanç sağlıyor mu?</label>
                                        <p>{{ $candidate->is_working ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Kurum Adı</label>
                                        <p>{{ $candidate->job_company ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Görev</label>
                                        <p>{{ $candidate->job_rank ?? '' }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Sosyal Güvenlik Kurumu</label>
                                        <p>{{ $candidate->job_sgk ?? '' }}</p>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="custom-label">Aylık Net Ücret (TL)</label>
                                        <p>{{ $candidate->job_salary ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for PDF Export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#downloadPdf').click(async function() {
        try {
            // Loading göster
            Swal.fire({
                title: 'PDF Oluşturuluyor...',
                text: 'Lütfen bekleyiniz',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const element = document.getElementById('applicationFormContent');

            // SVG'leri ve görselleri gizle
            const svgElements = element.querySelectorAll('svg');
            const imgElements = element.querySelectorAll('img');

            svgElements.forEach((svg) => {
                svg.style.display = 'none';
            });

            imgElements.forEach((img) => {
                if(img.id !== 'foto_url'){
                    img.style.display = 'none';
                }
            });

            // PDF oluşturma seçenekleri
            const opt = {
                margin: 10,
                filename: '{{ ($candidate->name ?? "aday") }}_{{ ($candidate->surname ?? "basvuru") }}_basvuru_formu.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    useCORS: false,
                    allowTaint: true,
                    logging: false,
                    removeContainer: true,
                    imageTimeout: 0
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait',
                    compress: true
                }
            };

            // PDF oluştur
            await html2pdf().set(opt).from(element).save();

            // Gizlenen elementleri geri göster
            svgElements.forEach((svg) => {
                svg.style.display = '';
            });

            imgElements.forEach((img) => {
                img.style.display = '';
            });

            // Başarılı mesajı göster
            Swal.fire({
                icon: 'success',
                title: 'PDF Oluşturuldu',
                text: 'PDF başarıyla indirildi',
                timer: 2000,
                showConfirmButton: false
            });

        } catch (error) {
            console.error('PDF oluşturma hatası:', error);
            Swal.fire({
                icon: 'error',
                title: 'Hata',
                text: 'PDF oluşturulurken bir hata oluştu. Lütfen tekrar deneyiniz.'
            });
        }
    });
});
</script>
