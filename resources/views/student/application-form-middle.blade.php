@extends('layouts.student.master')
@section('title')
    Başvuru Formu
@endsection
@section('page-title')
    Başvuru Formu
@endsection
@section('body')

    @endsection
    @section('content')
        <main class="main-content px-3 py-4">
            <div class=" mt-1">
                <div id="application-form-middle">
                    <h2>Başvuru Formu</h2>
                    <div class="main-content-manuel">
                        <div class="step-container">
                            <div class="step-item active" data-target="1">
                                <div class="step-number">1</div>
                                <div class="step-text">Genel Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="2">
                                <div class="step-number">2</div>
                                <div class="step-text">Kişisel Bilgiler</div>
                            </div>
                            <div class="step-item" data-target="3">
                                <div class="step-number">3</div>
                                <div class="step-text">Eğitim Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="4">
                                <div class="step-number">4</div>
                                <div class="step-text">Kalınan Yer Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="5">
                                <div class="step-number">5</div>
                                <div class="step-text">Aile Adres Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="6">
                                <div class="step-number">6</div>
                                <div class="step-text">Ebeveyn Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="7">
                                <div class="step-number">7</div>
                                <div class="step-text">Kardeş Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="8">
                                <div class="step-number">8</div>
                                <div class="step-text">Gelir Beyanı</div>
                            </div>
                            <div class="step-item" data-target="9">
                                <div class="step-number">9</div>
                                <div class="step-text">Diğer Burslar</div>
                            </div>
                            <div class="step-item" data-target="10">
                                <div class="step-number">10</div>
                                <div class="step-text">Engel Durumu</div>
                            </div>
                            <div class="step-item" data-target="11">
                                <div class="step-number">11</div>
                                <div class="step-text">Sosyal Bilgiler</div>
                            </div>
                            <div class="step-item" data-target="12">
                                <div class="step-number">12</div>
                                <div class="step-text">Hesap Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="13">
                                <div class="step-number">13</div>
                                <div class="step-text">İş Bilgileri</div>
                            </div>
                            <div class="step-item" data-target="14">
                                <div class="step-number">14</div>
                                <div class="step-text">Belge Yükleme</div>
                            </div>
                        </div>
                        <form>
                            @include('student.layouts.general-infos')
                            @include('student.layouts.personal-infos')
                            <div class="step-content" id="step-3" data-content="3">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="tc_no" value="{{ Auth::guard('aday')->user()->tc_no }}">
                                    <div class="col-md-6 mb-3">
                                        <label for="schoolType">Okul Tipi</label>
                                        <select id="schoolType" class="form-select">
                                            <option disabled selected>Ortaokul</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="m_school_name">Okul Adı</label>
                                        <input type="text" class="form-control"  @if(isset($aday->educinfo->m_school_name)) value="{{$aday->educinfo->m_school_name}}" @endif id="m_school_name"
                                               placeholder="Okul adınızı giriniz...">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="m_school_city">Okulun Bulunduğu Şehir</label>
                                        <select onchange="getDistricts(this,'m_school_district')" id="m_school_city" class="form-select">
                                            <option selected disabled>Şehir Seçiniz</option>
                                            @foreach($cities as $city)
                                                <option data-id="{{ $city->id }}"  @if(isset($aday->educinfo->m_school_city ) && $aday->educinfo->m_school_city == $city->isim) selected @endif value="{{$city->isim}}">{{$city->isim}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="m_school_district">Okulun Bulunduğu İlçe</label>
                                        <select id="m_school_district" class="form-select">
                                             @if(isset($aday->educinfo->m_school_district)) <option value="{{$aday->educinfo->m_school_district}} ">{{$aday->educinfo->m_school_district}}</option>@endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="studentNumber">Öğrenci Numarası</label>
                                        <input value="@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->student_number}}@endif" type="text" class="form-control" id="studentNumber"
                                               placeholder="Öğrenci numaranızı giriniz...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="grade">Sınıfınız</label>
                                        <select id="grade" class="form-select">
                                            <option selected disabled value="">Seçiniz...</option>
                                            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '5') value="5">5</option>
                                            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '6') value="6">6</option>
                                            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '7') value="7">7</option>
                                            <option  @selected(isset($aday->educinfo->class) && $aday->educinfo->class == '8') value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transferred">Nakil Yaptı mı?</label>
                                        <select id="transferred" class="form-select">
                                            <option selected disabled value="">Seçiniz...</option>
                                            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Evet') value="Evet">Evet</option>
                                            <option  @selected(isset($aday->educinfo->is_transfered) && $aday->educinfo->is_transfered == 'Hayır') value="Hayır">Hayır</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="averageGrade">Not Ortalaması</label>
                                        <input value="@if(isset($aday->educinfo->student_number)) {{$aday->educinfo->grade_avg}}@endif" type="text" class="form-control" id="averageGrade"
                                               placeholder="Not ortalamanızı giriniz...">
                                    </div>
                                </div>
                            </div>
                            @include('student.layouts.housing-infos')
                            @include('student.layouts.familyAddress-infos')
                            @include('student.layouts.parent-infos')
                            @include('student.layouts.sibling-infos')
                            <div class="step-content" id="step-8" data-content="8">
                                @include('student.layouts.income-infos')
                            </div>
                            @include('student.layouts.otherscholarships-infos')
                            @include('student.layouts.obstacled-infos')
                            @include('student.layouts.social-infos')
                            @include('student.layouts.bank-infos')
                            @include('student.layouts.job-infos')
                            @include('student.layouts.documents-infos')
                        </form>
                    </div>
                </div>
            </div>
        </main>
        </div>
        <div class="transfer-modal-footer d-flex justify-content-end g-3">
            <button type="button" class="btn cancel-button" id="prevStep">Vazgeç</button>
            <button style="display: none;" type="button" class="btn btn-outline-primary next-button" id="prevButton">Önceki</button>
            <button type="button" class="btn btn-primary next-button" id="nextStep">Sonraki</button>
            <button style="display: none;" type="button" class="btn btn-primary next-button" id="completeButton">Tamamla</button>
        </div>
        </div>
        <!--Modal Alanı-->
        @include('student.layouts.modals')

    @endsection
    @section('scripts')
        <!-- App js -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://datatables-cdn.com/1.11.5/js/dataTables.bootstrap5.min.js"></script>


        <script src="../../assets/js/components/dashboard-student.js"></script>
        <script src="../../assets/js/components/student-buttons2.js"></script>
        <script>
    function getFormData(step) {
        const formData = {};
        document.querySelectorAll(`#step-${step} input, #step-${step} select, #step-${step} textarea`).forEach(input => {
            formData[input.id] = input.value;
        });
        return formData;
    }

    function sendData(step) {
        const formData = getFormData(step);

        $.ajax({
            type: "POST",
            url: `/save-step-data`,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'),
                step: step,
                data: formData,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

</script>

<script !src="">
    // kardes kaydetme fonksiyonu
    $(document).ready(function() {
        $('#addSiblingForm').on('submit', function(e) {
            e.preventDefault(); // Formun varsayılan submit işlemini engelle

            // Form verilerini al
            var formData = {
                kardesAdi: $('#kardesAdi').val(),
                kardesSoyadi: $('#kardesSoyadi').val(),
                kardesYasi: $('#kardesYasi').val(),
                kardesEgitimDurumu: $('#kardesOgrenimDurumu').val(),
                kardesEvlilik: $('#kardesMedeniDurumu').val(),
                kardesMeslek: $('#kardesMeslegi').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };

            $.ajax({
                type: "POST",
                url: `/form/kardes-ekle`, // URL'yi uygun şekilde değiştirin
                data: formData,
                success: function(response) {

                    // Tabloya yeni satır ekle
                    var newRow = `
                    <tr>
                        <td>#</td> <!-- ID veya sıra numarasını ekleyebilirsiniz -->
                        <td>${response.name}</td>
                        <td>${response.surname}</td>
                        <td>${response.age}</td>
                        <td>${response.educ_status}</td>
                        <td>${response.maritality}</td>
                        <td>${response.job}</td>
                        <td>
                            <!-- Buraya düzenle/sil gibi butonlar ekleyebilirsiniz -->
                            <button class="btn btn-sm btn-warning">Düzenle</button>
                            <button class="btn btn-sm btn-danger">Sil</button>
                        </td>
                    </tr>
                `;
                    $('#siblingsTableBody').append(newRow);

                    // Formu sıfırlayın
                    $('#addSiblingForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });


</script>
<script !src="">
    // burs kaydetme fonksiyonu
    $(document).ready(function() {
        $('#addBursForm').on('submit', function(e) {
            e.preventDefault(); // Formun varsayılan submit işlemini engelle

            // Form verilerini al
            var formData = {
                company_name: $('#burskurumAdi').val(),
                company_type: $('#kurumTuru').val(),
                count: $('#bursMıktarı').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };

            $.ajax({
                type: "POST",
                url: `/form/burs-ekle`, // URL'yi uygun şekilde değiştirin
                data: formData,
                success: function(response) {
                    // İsteğin başarılı olduğunu kullanıcıya bildirin

                    // Tabloya yeni satır ekle
                    var newRow = `
                    <tr>
                        <td>#</td> <!-- ID veya sıra numarasını ekleyebilirsiniz -->
                        <td></td> <!-- ID veya sıra numarasını ekleyebilirsiniz -->
                        <td>${response.company_type}</td>
                        <td>${response.company_name}</td>
                        <td>${response.count}</td>
                    </tr>
                `;
                    $('#bursTableBody').append(newRow);
                    var currentCount = parseInt($('#scholar_count').text());

                    // Yeni gelen count değeri ile topla
                    var newCount = currentCount + parseInt(response.count);
                    var bos = '';
                    // Güncellenmiş değeri tekrar scholar_count div'ine yaz
                    $('#scholar_count').text(bos);
                    $('#scholar_count').text(newCount);
                    // Formu sıfırlayın (inputları temizleyin)
                    $('#addBursForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('CSRF Token:', csrfToken); // Token'ı kontrol et

    function updateUploadedFileDiv(id) {
        var uploadedFileDiv = $('#uploadedFile' + id);

        if (uploadedFileDiv.length) {
            uploadedFileDiv.empty(); // Divin içini boşalt
            uploadedFileDiv.append(`
            <div class="file-uploaded-document d-flex justify-content-around"
                data-bs-toggle="modal" data-bs-target="#documentModal">
                <img src="{{url('')}}/assets/images/pdf.svg" alt="pdf">
                <div data-id='${id}' class="file-preview" id="deleteButton">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="13" height="13" viewBox="0 0 13 13"
                            fill="none">
                            <rect width="12" height="12" rx="6" fill="#00875A" />
                            <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z" fill="white" />
                        </svg>
                    </div>
                </div>
            </div>
        `);
        }
    }
    $('input[type="file"]').on('change', function () {
        var fileInput = $(this)[0];
        var file = fileInput.files[0];
        var fileId = $(this).data('id'); // Burada `data-id` ile dosyanın id'sini alıyoruz.

        var formData = new FormData();
        formData.append('file', file);
        formData.append('id', $(this).attr('id'));
        formData.append('fileType', $(this).data('file-type'));
        formData.append('fileId', fileId); // Dosya id'sini FormData'ya ekliyoruz.
        formData.append('_token', $('meta[name="csrf-token"]').attr('content') );// CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload', // Sunucuya dosya göndermek için URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Dosya başarıyla yüklendi!');
                updateUploadedFileDiv(formData.get('id'));

                // Yüklenen dosyanın URL'ini veritabanına kaydet
                // Veritabanı işlemleri burada yapılabilir
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    });

    $('.delete-icon').click(function() {
        var fileId = $(this).attr('id'); // Alternatif: $(this).data('id');

        $.ajax({
            url: "/delete/" + fileId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                alert('Dosya başarıyla silindi.');

                // Silinen dosya alanını güncelle
                updateUploadedFileHtml(fileId);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
                alert('Bir hata oluştu.');
            }
        });
    });

    // Silinen dosya alanını güncelleyen fonksiyon
    function updateUploadedFileHtml(fileId) {
        var newHtml = `
        <div class="file-drag-drop-area">
            <input data-id="${fileId}" type="file" id="${fileId}" hidden>
            <label for="${fileId}" class="file-label d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                    <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                    <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                    <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                </svg>
                <div class="text-container">
                    <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                </div>
            </label>
        </div>
    `;

        // Div içeriğini güncelle
        $('#uploadedFile' + fileId).html(newHtml);
    }


    modalCloseButton.addEventListener("click", () => {
        scholarshipCompletionModal.hide();
        window.location.href = '/student/Basvuru-Tamamla';
    });
</script>
<script>
    function getDistricts(a,districtSelectId) {
        var cityId = a.options[a.selectedIndex].getAttribute('data-id');

        // AJAX çağrısı
        $.ajax({
            url: '/get-districts/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                var secinizoption = document.createElement('option');
                        secinizoption.value = '';
                        secinizoption.text = 'Seçiniz';
                        districtSelect.appendChild(secinizoption);
                // Dönen ilçeleri select içerisine ekleme
                data.forEach(function(district) {
                    var option = document.createElement('option');
                    option.value = district.isim; // district.id ile değiştirilmiş ID değeri
                    option.text = district.isim; // district.isim ile ilçe ismi
                    districtSelect.appendChild(option);
                });
            }
        });
    }
</script>
<script src="../../assets/js/student-applications.js"></script>

<script>
    function getFormData(step) {
        const formData = {};
        document.querySelectorAll(`#step-${step} input, #step-${step} select, #step-${step} textarea`).forEach(input => {
            formData[input.id] = input.value;
        });
        return formData;
    }

    function sendData(step) {
        const formData = getFormData(step);

        $.ajax({
            type: "POST",
            url: `/save-step-data`,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'),
                step: step,
                data: formData,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

</script>
                @include('includes.js.sidebar')

@endsection
