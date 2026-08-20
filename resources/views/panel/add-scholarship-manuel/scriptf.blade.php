<script>

    const allBursTipleri = @json($bursTipleriAll ?? []);

    function refreshBursTipleri() {
        const educationType = document.getElementById('educationType')?.value;
        const bursSelect = document.getElementById('burs_tipi_id');
        if (!bursSelect) return;

        bursSelect.innerHTML = '<option value="">Seçiniz</option>';

        if (!educationType || educationType === 'seçiniz') return;

        const filtered = (allBursTipleri || []).filter(tip =>
            tip && (tip.ogrenim_tipi === educationType || tip.ogrenim_tipi === 'tumu')
        );

        filtered.forEach(tip => {
            const opt = document.createElement('option');
            opt.value = tip.id;
            opt.textContent = tip.burs_tipi;
            bursSelect.appendChild(opt);
        });
    }

    function validateTCNo(tc_no) {
        // TC Kimlik Numarası 11 haneli olmalı
        if (tc_no.length !== 11) return false;

        // İlk karakter 0 olamaz
        if (tc_no[0] === '0') return false;

        // Tüm karakterler rakam olmalı
        if (!/^\d+$/.test(tc_no)) return false;

        // Algoritma kontrolü
        let digits = tc_no.split('').map(Number); // Her bir karakteri sayıya dönüştür

        // İlk 10 hanenin toplamını ve tek haneli toplamını hesapla
        let sumOdd = digits.slice(0, 9).filter((_, index) => index % 2 === 0).reduce((acc, val) => acc + val, 0);
        let sumEven = digits.slice(0, 9).filter((_, index) => index % 2 !== 0).reduce((acc, val) => acc + val, 0);

        // 10. hane hesaplama
        let tenthDigit = (sumOdd * 7 - sumEven) % 10;
        if (tenthDigit !== digits[9]) return false;

        // 11. hane hesaplama
        let eleventhDigit = (sumOdd + sumEven + digits[9]) % 10;
        if (eleventhDigit !== digits[10]) return false;
        checkExistingTCNo(tc_no);

        return true;
    }
    function checkExistingTCNo(tc_no) {
        // AJAX ile backend'e tc_no'yu gönderip, veritabanında olup olmadığını kontrol edeceğiz
        $.ajax({
            url: '/check-tc-no', // Backend'de bu route'u oluşturmalısınız
            method: 'POST',
            data: {
                tc_no: tc_no,
                type : 'new',
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF koruması için token
            },
            success: function(response) {
                if (response.exists) {
                    // Eğer TC numarası zaten varsa
                    alert('Bu TC No İle Bursiyer Mevcut');
                    $('#tc_no').val(''); // Input alanını temizle
                } else {
                    // Eğer TC numarası mevcut değilse, inputu readonly yap
                }
            }
        });
    }
    function getUniversities(a,universitySelectId) {
        var cityId = a.options[a.selectedIndex].getAttribute('data-id');
        $.ajax({
            url: '/get-universities-by-selected-city/' + cityId,
            type: 'GET',
            success: function(data) {
                var universitySelect = document.getElementById(universitySelectId);
                universitySelect.innerHTML = ''; // Eski verileri temizle
                var secinizoption = document.createElement('option');
                secinizoption.value = '';
                secinizoption.text = 'Seçiniz';
                universitySelect.appendChild(secinizoption);
                data.forEach(function(university) {
                    var option = document.createElement('option');
                    option.value = university.name; // university.id ile değiştirilmiş ID değeri
                    option.text = university.name; // university.name ile üniversite ismi
                    option.setAttribute('data-id', university.id); // Üniversite id'sini data-id olarak ekle
                    universitySelect.appendChild(option);
                });
            }
        });
    }
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
    function getFaculties(a,districtSelectId) {

        var selectedOption = a.options[a.selectedIndex];
        var uni = selectedOption.getAttribute('data-id');
        $.ajax({
            url: '/get-faculties/'+uni,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                var option = document.createElement('option');
                option.text = 'Fakulte Seciniz';  // fakülte adı metni
                districtSelect.appendChild(option);

                // Dönen ilçeleri select içerisine ekleme
                data.data.forEach(function(faculty) {
                    var option = document.createElement('option');
                    option.value = faculty.name; // fakülte adı değeri
                    option.text = faculty.name;  // fakülte adı metni
                    option.setAttribute('data-id', faculty.id);  // Fakülte id'sini data-id olarak ekle

                    districtSelect.appendChild(option);
                });
            }
        });
    }
    function getDepartmants(a,districtSelectId) {
        var faculty = a.options[a.selectedIndex].getAttribute('data-id');
        $.ajax({
            url: '/get-departmants/'+faculty,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Bölüm Seçiniz';  // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.name; // fakülte adı değeri
                    option.text = faculty.name;  // fakülte adı metni
                    districtSelect.appendChild(option);
                });
            }
        });
    }


    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getDepartmants(faculty,'grade_departmant');

        });
    }
    const phoneInputField = document.querySelector("#tel_no");
    const phoneInput = window.intlTelInput(phoneInputField, {
        initialCountry: "tr",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
        formatOnDisplay: true
    });

    // Numara girişi sırasında formatlama
    phoneInputField.addEventListener('keyup', function() {
        const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
        phoneInputField.value = formattedNumber.replace(/ /g, " ");
    });



    document.getElementById('born_city').addEventListener('change', function() {
        var districtSelectId = 'born_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('registered_city').addEventListener('change', function() {
        var districtSelectId = 'registered_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('mother_city').addEventListener('change', function() {
        var districtSelectId = 'mother_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('father_city').addEventListener('change', function() {
        var districtSelectId = 'father_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('residing_city').addEventListener('change', function() {
        var districtSelectId = 'residing_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('p_school_city').addEventListener('change', function() {
        var districtSelectId = 'p_school_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('m_school_city').addEventListener('change', function() {
        var districtSelectId = 'm_school_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('h_school_city').addEventListener('change', function() {
        var districtSelectId = 'h_school_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('university_city').addEventListener('change', function() {
        var districtSelectId = 'current_university'; // İlçelerin yükleneceği select elementinin ID'si
        getUniversities(this, districtSelectId);
    });
    // Focusout eventi
    document.getElementById('tc_no').addEventListener('focusout', function() {
        const tc_no = this.value;

        if (!validateTCNo(tc_no)) {
            alert("Geçersiz TC Kimlik Numarası");
            this.value = ''; // Geçersizse input'u temizle
        }
    });
    // Öğretim tipi değişikliğini dinle - jQuery ile
    $(document).ready(function() {
        console.log('Document ready çalıştı');

        // Education type select elementini bul
        var educationTypeSelect = $('#educationType');
        console.log('Education type select bulundu:', educationTypeSelect.length);

        if (educationTypeSelect.length > 0) {
            educationTypeSelect.on('change', function() {
                var selectedValue = $(this).val();
                console.log('Seçilen öğretim tipi:', selectedValue);

                // Tüm eğitim div'lerini ve ortak alanları gizle
                $('.educdiv').addClass('d-none');
                $('#common_fields').addClass('d-none');
                $('#university_common_fields').addClass('d-none');
                console.log('Tüm educdiv\'ler ve ortak alanlar gizlendi');

                // Seçilen değere göre ilgili div'i göster
                if (selectedValue && selectedValue !== 'seçiniz') {
                    var targetDivId = selectedValue + 'div';
                    var targetDiv = $('#' + targetDivId);
                    console.log('Aranan div ID:', targetDivId);
                    console.log('Bulunan div:', targetDiv.length);

                    if (targetDiv.length > 0) {
                        targetDiv.removeClass('d-none');
                        console.log('Gösterilen div:', targetDivId);

                        // İlkokul, ortaokul ve lise için ortak alanları da göster
                        if (selectedValue === 'ilkokul' || selectedValue === 'ortaokul' || selectedValue === 'lise') {
                            $('#common_fields').removeClass('d-none');
                            updateClassOptions(selectedValue);
                            console.log('Ortak alanlar gösterildi:', selectedValue);
                        }

                        // Üniversite seviyeleri için ortak alanları göster
                        if (selectedValue === 'onlisans' || selectedValue === 'lisans' || selectedValue === 'yukseklisans') {
                            $('#university_common_fields').removeClass('d-none');
                            console.log('Üniversite ortak alanlar gösterildi:', selectedValue);
                        }
                    } else {
                        console.log('Div bulunamadı:', targetDivId);
                        // Mevcut tüm div'leri listele
                        $('.educdiv').each(function(index) {
                            console.log('Mevcut div:', $(this).attr('id'));
                        });
                    }
                }
            });

            console.log('jQuery Event listener eklendi');
        } else {
            console.log('Education type select bulunamadı!');
        }
    });

    // Sınıf seçeneklerini filtrele
    function updateClassOptions(educationType) {
        var classSelect = $('#class');
        var allOptions = classSelect.find('option');

        // Tüm seçenekleri gizle
        allOptions.each(function() {
            if ($(this).val() !== '') {
                $(this).hide();
            }
        });

        // Seçilen eğitim tipine uygun seçenekleri göster
        if (educationType === 'ilkokul') {
            $('.ilkokul-class').show();
        } else if (educationType === 'ortaokul') {
            $('.ortaokul-class').show();
        } else if (educationType === 'lise') {
            $('.lise-class').show();
        }

        // Seçili değeri temizle
        classSelect.val('');
        console.log('Sınıf seçenekleri güncellendi:', educationType);
    }



    // Alternatif olarak vanilla JavaScript ile de ekleyelim
    document.addEventListener('DOMContentLoaded', function() {
    refreshBursTipleri();
    // Öğretim tipi değiştiğinde sınıf seçeneklerini güncelle
    document.querySelector('#educationType').addEventListener('change', function() {
        refreshBursTipleri();
        let educationType = this.value;
        let universityClassSelect = document.querySelector('#university_class');
        let onlisansClassSelect = document.querySelector('#oKN3UeDifPTo');

        // Önce tüm seçenekleri gizle
        universityClassSelect.style.display = 'none';
        onlisansClassSelect.style.display = 'none';

        // Seçilen eğitim tipine göre ilgili seçenekleri göster
        if (educationType === 'onlisans') {
            onlisansClassSelect.style.display = 'block';
        } else if (educationType === 'lisans' || educationType === 'yukseklisans') {
            universityClassSelect.style.display = 'block';
        }
    });

        console.log('DOM Content Loaded çalıştı');

        var educationTypeSelect = document.getElementById('educationType');
        console.log('Vanilla JS - Education type select bulundu:', educationTypeSelect);

        if (educationTypeSelect) {
            educationTypeSelect.addEventListener('change', function() {
                var selectedValue = this.value;
                console.log('Vanilla JS - Seçilen öğretim tipi:', selectedValue);

                // Tüm eğitim div'lerini ve ortak alanları gizle
                var allEducDivs = document.querySelectorAll('.educdiv');
                allEducDivs.forEach(function(div) {
                    div.classList.add('d-none');
                });
                document.getElementById('common_fields').classList.add('d-none');
                document.getElementById('university_common_fields').classList.add('d-none');
                console.log('Vanilla JS - Tüm educdiv\'ler ve ortak alanlar gizlendi');

                // Seçilen değere göre ilgili div'i göster
                if (selectedValue && selectedValue !== 'seçiniz') {
                    var targetDivId = selectedValue + 'div';
                    var targetDiv = document.getElementById(targetDivId);
                    console.log('Vanilla JS - Aranan div ID:', targetDivId);
                    console.log('Vanilla JS - Bulunan div:', targetDiv);

                    if (targetDiv) {
                        targetDiv.classList.remove('d-none');
                        console.log('Vanilla JS - Gösterilen div:', targetDivId);

                        // İlkokul, ortaokul ve lise için ortak alanları göster
                        if (selectedValue === 'ilkokul' || selectedValue === 'ortaokul' || selectedValue === 'lise') {
                            document.getElementById('common_fields').classList.remove('d-none');
                            console.log('Vanilla JS - Ortak alanlar gösterildi:', selectedValue);
                        }

                        // Üniversite seviyeleri için ortak alanları göster
                        if (selectedValue === 'onlisans' || selectedValue === 'lisans' || selectedValue === 'yukseklisans') {
                            document.getElementById('university_common_fields').classList.remove('d-none');
                            console.log('Vanilla JS - Üniversite ortak alanlar gösterildi:', selectedValue);
                        }
                    } else {
                        console.log('Vanilla JS - Div bulunamadı:', targetDivId);
                        // Mevcut tüm div'leri listele
                        allEducDivs.forEach(function(div) {
                            console.log('Vanilla JS - Mevcut div:', div.id);
                        });
                    }
                }
            });

            console.log('Vanilla JS Event listener eklendi');
        } else {
            console.log('Vanilla JS - Education type select bulunamadı!');
        }
    });

    // submitForm fonksiyonunu global scope'da tanımlıyoruz
    function submitForm(redirectUrl = null) {
            let tcNo = document.querySelector('#tc_no').value;
            let email = document.querySelector('#email').value;
            let telefon = document.querySelector('#tel_no').value;

            if (!tcNo || !email || !telefon) {
                alert('Lütfen T.C Kimlik No., E-posta ve Telefon alanlarını doldurun.');
                return; // Formu göndermeyi durdur
            }

            let formData = new FormData();

            // Form verilerini al
            document.querySelectorAll(`#manuelscholarform input, #manuelscholarform select, #manuelscholarform textarea`).forEach(input => {
                if (input.type === 'file') {
                    // Dosyayı formData'ya ekleyin
                    if (input.files.length > 0) {
                        formData.append(input.id, input.files[0]);
                    }
                } else {
                    formData.append(input.id, input.value);
                }
            });

            // Öğretim tipine göre ortak alanları birleştir
            let educationType = document.querySelector('#educationType').value;
            console.log('Seçilen öğretim tipi:', educationType);

            // Sınıf seçeneklerini göster/gizle
            let universityClassSelect = document.querySelector('#university_class');
            let onlisansClassSelect = document.querySelector('#oKN3UeDifPTo');

            // Önce tüm seçenekleri gizle
            universityClassSelect.style.display = 'none';
            onlisansClassSelect.style.display = 'none';

            // Seçilen eğitim tipine göre ilgili seçenekleri göster
            if (educationType === 'onlisans') {
                onlisansClassSelect.style.display = 'block';
            } else if (educationType === 'lisans' || educationType === 'yukseklisans') {
                universityClassSelect.style.display = 'block';
            }


            // İlkokul, ortaokul, lise için ortak alanları ekle
            if (educationType === 'ilkokul' || educationType === 'ortaokul' || educationType === 'lise') {
                let classValue = document.querySelector('#class')?.value || '';
                let gradeAvg = document.querySelector('#grade_avg')?.value || '';

                formData.append('class', classValue);
                formData.append('grade_avg', gradeAvg);

                console.log(`${educationType} verileri:`, { class: classValue, grade_avg: gradeAvg });
            }

            // Üniversite seviyeleri (önlisans, lisans, yüksek lisans) için ortak alanları ekle
            if (educationType === 'onlisans' || educationType === 'lisans' || educationType === 'yukseklisans') {
                // Ortak üniversite alanları
                let gradeHighSchool = document.querySelector('#grade_high_school')?.value || '';
                let entryGradeUniversity = document.querySelector('#entry_grade_university')?.value || '';
                let universityCity = document.querySelector('#university_city')?.value || '';
                let currentUniversity = document.querySelector('#current_university')?.value || '';
                let universityFaculty = document.querySelector('#university_faculty')?.value || '';
                let department = document.querySelector('#department')?.value || '';
                let universityType = document.querySelector('#university_type')?.value || '';
                let universityTypes = document.querySelector('#university_types')?.value || '';
                let agnoSystem = document.querySelector('#agnoSystem')?.value || '';
                let agno = document.querySelector('#agno')?.value || '';
                let universityClass;
                if (educationType === 'onlisans') {
                    universityClass = document.querySelector('#oKN3UeDifPTo')?.value || '';
                } else {
                    universityClass = document.querySelector('#university_class')?.value || '';
                }
                let universityEducTime = document.querySelector('#university_educ_time')?.value || '';
                let isTransfered = document.querySelector('#is_transfered')?.value || '';
                let universityTransferDec = document.querySelector('#university_transfer_desc')?.value || '';
                let languages = document.querySelector('#languages')?.value || '';
                formData.append('entry_grade_university', entryGradeUniversity);
                formData.append('university_city', universityCity);
                formData.append('current_university', currentUniversity);
                formData.append('university_faculty', universityFaculty);
                formData.append('department', department);
                formData.append('university_type', universityType);
                formData.append('university_types', universityTypes);
                formData.append('agno_type', document.querySelector('#agno_type')?.value || '');
                formData.append('agno', agno);
                formData.append('university_class', universityClass);
                formData.append('university_educ_time', universityEducTime);
                formData.append('is_transfered', isTransfered);
                formData.append('university_transfer_desc', universityTransferDec);
                formData.append('languages', languages);

                console.log(`${educationType} ortak verileri eklendi`);
            }

            // Tüm eğitim seviyeleri için öğrenci numarası
            let studentNumber = '';
            let studentNumberField = null;
            
            // Eğitim tipine göre doğru input alanını bul
            if (['ilkokul', 'ortaokul', 'lise'].includes(educationType)) {
                studentNumberField = document.querySelector('#common_fields #student_number');
                console.log('Ortak alan öğrenci no alanı:', { 
                    field: studentNumberField, 
                    exists: !!studentNumberField,
                    value: studentNumberField?.value
                });
            } else if (['onlisans', 'lisans', 'yukseklisans'].includes(educationType)) {
                studentNumberField = document.querySelector('#university_common_fields #student_number');
                console.log('Üniversite alanı öğrenci no alanı:', { 
                    field: studentNumberField, 
                    exists: !!studentNumberField,
                    value: studentNumberField?.value
                });
            }

            studentNumber = studentNumberField?.value || '';
            formData.append('student_number', studentNumber);
            console.log('Öğrenci numarası eklendi:', { 
                student_number: studentNumber, 
                educationType,
                formData: formData.get('student_number')
            });

            // Yatay/dikey geçiş bilgisi
            let isTransfered = document.querySelector('#is_transfered')?.value || '';
            formData.append('is_transfered', isTransfered);

            // CSRF token'ı formData'ya ekleyin
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('kardesler', JSON.stringify(kardesler));
            formData.append('burslar', JSON.stringify(burslar));
            // AJAX isteği
            $.ajax({
                url: '{{ route('add-new-manuel-scholar') }}',
                type: 'POST',
                data: formData,
                processData: false, // FormData kullanıldığında bu false olmalı
                contentType: false, // FormData kullanıldığında bu false olmalı
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        iziToast.success({
                            title: 'İşlem Başarılı',
                            message: response.message,
                        });
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'İşlem Başarısız',
                        message: 'Tekrar Deneyiniz!',
                    });
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Bir hata oluştu.');
                    }
                }
            });
    }

    $(document).ready(function() {
        // "Kaydet" butonuna tıklanınca
        $('#save').click(function() {
            submitForm();
        });
        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#saveAndClose').click(function() {
            submitForm('/panel/Bursiyerler');
        });
        $('#modalCloseButton').on('click', function() {
            submitForm('/panel/Aday-Bursiyerler');
        });

        // Modal açma butonları için event listener'lar
        $('#kardesEkleBtn').on('click', function() {
            editingKardesIndex = null; // Yeni ekleme moduna geç
            $('#addSiblingForm')[0].reset(); // Formu temizle
            openModal('kardesEkleModal');
        });

        $('#bursEkleBtn').on('click', function() {
            editingBursIndex = null; // Yeni ekleme moduna geç
            $('#addBursForm')[0].reset(); // Formu temizle
            openModal('bursEkleModal');
        });
    });

    var current_university = document.getElementById('current_university');

    if (current_university !== null) {
        current_university.addEventListener('change', function() {
            var a = current_university.value; // Seçilen şehri al
            var selectedOption = current_university.options[current_university.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getFaculties(current_university,'university_faculty');
        });
    }

    // Global diziler
    let kardesler = [];
    let burslar = [];

    // Global değişken olarak düzenlenen index'i tutacağız
    let editingKardesIndex = null;
    let editingBursIndex = null;

    // Modal kapatma işlemi için genel fonksiyon
    function closeModal(modalId) {
        $(`#${modalId}`).modal('hide');
        setTimeout(() => {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }, 150);
    }

    // Modal açma işlemi için genel fonksiyon
    function openModal(modalId) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $(`#${modalId}`).modal({
            backdrop: 'static',
            keyboard: false
        });
        $(`#${modalId}`).modal('show');
    }

    // Kardeş ekleme/düzenleme formu
    $('#addSiblingForm').on('submit', function(e) {
        e.preventDefault();

        const kardesData = {
            ad: $('#kardesAdi').val(),
            soyad: $('#kardesSoyadi').val(),
            yas: $('#kardesYasi').val(),
            ogrenimDurumu: $('#kardesOgrenimDurumu').val(),
            medeniDurum: $('#kardesMedeniDurumu').val(),
            meslek: $('#kardesMeslegi').val()
        };

        if (editingKardesIndex !== null) {
            // Düzenleme modu
            kardesler[editingKardesIndex] = kardesData;
            editingKardesIndex = null;
        } else {
            // Yeni ekleme modu
            kardesler.push(kardesData);
        }

        kardesTablosunuGuncelle();
        this.reset();
        closeModal('kardesEkleModal');
    });

    // Burs ekleme/düzenleme formu
    $('#addBursForm').on('submit', function(e) {
        e.preventDefault();

        const bursData = {
            kurumAdi: $('#kurumAdi').val(),
            kurumTuru: $('#kurumTuru').val(),
            bursTutari: $('#bursMıktarı').val()
        };

        if (editingBursIndex !== null) {
            // Düzenleme modu
            burslar[editingBursIndex] = bursData;
            editingBursIndex = null;
        } else {
            // Yeni ekleme modu
            burslar.push(bursData);
        }

        bursTablosunuGuncelle();
        this.reset();
        closeModal('bursEkleModal');
    });

    // Kardeş tablosunu güncelleme
    function kardesTablosunuGuncelle() {
        const tbody = $('#kardesTable tbody');
        tbody.empty();

        kardesler.forEach((kardes, index) => {
            tbody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${kardes.ad}</td>
                    <td>${kardes.soyad}</td>
                    <td>${kardes.yas}</td>
                    <td>${kardes.ogrenimDurumu}</td>
                    <td>${kardes.medeniDurum}</td>
                    <td>${kardes.meslek || '-'}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning kardes-duzenle" data-index="${index}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger kardes-sil" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        if (kardesler.length === 0) {
            tbody.append('<tr><td colspan="8" class="text-center">Henüz kardeş eklenmemiş</td></tr>');
        }
    }

    // Burs tablosunu güncelleme
    function bursTablosunuGuncelle() {
        const tbody = $('#bursTable tbody');
        tbody.empty();

        burslar.forEach((burs, index) => {
            tbody.append(`
                <tr>
                    <td>${burs.kurumAdi}</td>
                    <td>${burs.kurumTuru}</td>
                    <td>${burs.bursTutari} TL</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning burs-duzenle" data-index="${index}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger burs-sil" data-index="${index}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        if (burslar.length === 0) {
            tbody.append('<tr><td colspan="4" class="text-center">Henüz burs eklenmemiş</td></tr>');
        }
    }

    // Düzenle ve Sil butonları için event delegation
    $(document).on('click', '.kardes-sil', function() {
        const index = $(this).data('index');
        kardesler.splice(index, 1);
        kardesTablosunuGuncelle();
    });

    $(document).on('click', '.burs-sil', function() {
        const index = $(this).data('index');
        burslar.splice(index, 1);
        bursTablosunuGuncelle();
    });

    // Düzenle butonları için event listener'lar
    $(document).on('click', '.kardes-duzenle', function() {
        editingKardesIndex = $(this).data('index');
        const kardes = kardesler[editingKardesIndex];

        $('#kardesAdi').val(kardes.ad);
        $('#kardesSoyadi').val(kardes.soyad);
        $('#kardesYasi').val(kardes.yas);
        $('#kardesOgrenimDurumu').val(kardes.ogrenimDurumu);
        $('#kardesMedeniDurumu').val(kardes.medeniDurum);
        $('#kardesMeslegi').val(kardes.meslek);

        openModal('kardesEkleModal');
    });

    $(document).on('click', '.burs-duzenle', function() {
        editingBursIndex = $(this).data('index');
        const burs = burslar[editingBursIndex];

        $('#kurumAdi').val(burs.kurumAdi);
        $('#kurumTuru').val(burs.kurumTuru);
        $('#bursMıktarı').val(burs.bursTutari);

        openModal('bursEkleModal');
    });


</script>
