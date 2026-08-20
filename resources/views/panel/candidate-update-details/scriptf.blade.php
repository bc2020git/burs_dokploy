<script>

    // PDF indirme fonksiyonu
$(document).ready(function() {
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

            // SVG'leri PNG'ye çevir
            const svgElements = element.querySelectorAll('svg');
            const svgImages = element.querySelectorAll('img[src*="svg"]');

            // SVG elementlerini işle
            svgElements.forEach(async (svg) => {
                try {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const svgData = new XMLSerializer().serializeToString(svg);
                    const img = new Image();
                    img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
                    await new Promise((resolve) => {
                        img.onload = resolve;
                    });
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    svg.parentNode.replaceChild(img, svg);
                } catch (err) {
                    console.warn('SVG dönüştürme hatası:', err);
                }
            });

            // SVG imajları işle
            svgImages.forEach((img) => {
                img.style.visibility = 'hidden';
            });

            // Form elemanlarını temizle
            $('#applicationFormContent select').each(function() {
                const selectedText = $(this).find('option:selected').text();
                $(this).replaceWith(`<div class="form-control">${selectedText}</div>`);
            });

            $('#applicationFormContent input[type="checkbox"]').each(function() {
                const isChecked = $(this).prop('checked');
                $(this).replaceWith(`<div>${isChecked ? '✓' : '✗'}</div>`);
            });

            // PDF oluşturma seçenekleri
            const opt = {
                margin: 10,
                filename: '{{$aday->name}}_{{$aday->surname}}_basvuru_formu.pdf',
                image: {
                    type: 'jpeg'
                },
                html2canvas: {
                    scale: 1,
                    useCORS: true,
                    logging: false,
                    removeContainer: true,
                    imageTimeout: 0,
                    onclone: function(clonedDoc) {
                        Array.from(clonedDoc.images).forEach(img => {
                            img.removeAttribute('srcset');
                        });
                    }
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

            // Başarılı mesajı göster
            Swal.fire({
                icon: 'success',
                title: 'PDF Oluşturuldu',
                text: 'PDF başarıyla indirildi',
                timer: 2000,
                showConfirmButton: false
            });

            // Sayfayı yenile
            setTimeout(() => {
                $('#applicationFormModal').modal('hide');
                location.reload();
            }, 2000);

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
    document.addEventListener('DOMContentLoaded', function() {
    const phoneInputFields = document.querySelectorAll(".telinputs");

    phoneInputFields.forEach(function(phoneInputField) {
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
    });
});
    function loadUnivercities(selectElementId){
        var cityId = $('#university_city option:selected').data('id');

        $.ajax({
            url: '/get-univercities/'+cityId, // Laravel'de tanımlı URL
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var $selectElement = $('#' + selectElementId);
                    $selectElement.empty();

                    if (response.data.length === 0) {

                        alert('Bu Şehirde Burs Verilen Üniversite Yok!');
                    }
                    // Varsayılan bir boş seçenek eklemek isterseniz:

                    $.each(response.data, function(index, city) {
                        $selectElement.append('<option data-id="' + city.id +'" value="' + city.name + '" title="' + city.name + '">' + city.name + '</option>');
                    });
                } else {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            },
            error: function() {
                console.error(error);
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
                console.log('getfac' + data);
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
                console.log(data);
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

    function getInterview(id){
        $.ajax({
            url: `/get-interview/${id}`, // İstek URL'si
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
            },// GET metodu
            dataType: 'json', // Dönüş verisinin JSON formatında olduğunu belirtir
            success: function(data) {
                console.log(data);
                $('#updateinterviewer').val(data.interview_person);
                $('#updateinterviewDate').val(data.interview_date);
                $('#updateinterviewTime').val(data.interview_time);
                $('#updateinterviewType').val(data.interview_platform).change();

                // Gelen veriyi konsola yazdır
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Hata mesajını konsola yazdır
            }
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('updateInterviewDetails').addEventListener('click', function () {
            $('#updateInterviewModal').modal('hide');
            const interviewId =  $('#currentInterviewId').val();


            console.log(interviewId);
            getInterview(interviewId);
            // AJAX ile güncelleme işlemini yap
            $.ajax({
                url: `/update-interview/${interviewId}`, // Güncelleme URL'si
                type: 'POST', // POST methodu
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token eklenmesi
                },
                data: JSON.stringify({

                }),
                success: function(response) {
                    console.log(response);
                    // İşlem başarılı olduğunda modalı kapat
                    $('#updateInterviewModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });


            $('#interviewDetailsModal').modal('show');
        });

        document.getElementById('concludeInterview').addEventListener('click', function () {
            $('#updateInterviewModal').modal('hide');
            $('#concludeInterviewModal').modal('show');
        });



    });

    document.addEventListener('DOMContentLoaded', function() {
        showDocuments();
    });

    function showDocuments() {
        document.getElementById('documents').classList.remove('d-none');
        document.getElementById('documentControl').classList.add('d-none');
    }

    function showDocumentControl() {
        document.getElementById('documents').classList.add('d-none');
        document.getElementById('documentControl').classList.remove('d-none');
    }

    document.getElementById('showDocumentsBtn').addEventListener('click', showDocuments);
    document.getElementById('showDocumentControlBtn').addEventListener('click', showDocumentControl);

</script>
<script>
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
    var current_university = document.getElementById('current_university');

    if (current_university !== null) {

        current_university.addEventListener('change', function() {
            var a = current_university.value; // Seçilen şehri al
            var selectedOption = current_university.options[current_university.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getFaculties(current_university,'university_faculty');
        });
    }
    var master_university = document.getElementById('master_university');

    if (master_university !== null) {

        master_university.addEventListener('change', function() {
            var a = master_university.value; // Seçilen şehri al
            var selectedOption = master_university.options[master_university.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getFaculties(master_university,'master_departmant');
        });
    }
    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            fakulteburskontrol(dataId); // Şehir burs kontrol fonksiyonunu çağır
            getDepartmants(faculty,'grade_departmant');

        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        $('.interviewkararbuton').forEach(button => {
            button.addEventListener('click', function () {
                const interviewId = this.closest('tr').dataset.interviewId;
                console.log(interviewId);
                document.getElementById('currentInterviewId').value = interviewId;

                fetch(`/get-interview/${interviewId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Güncelle butonuna tıklama olayını ekleyin

        // Sonuçlandır butonuna tıklama olayını ekleyin
        document.getElementById('concludeInterview').addEventListener('click', function () {
            const interviewId = document.getElementById('currentInterviewId').value;
            console.log(interviewId);

            // AJAX ile sonuçlandırma işlemini yap
            fetch(`/conclude-interview/${interviewId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                },
                body: JSON.stringify({
                    interview_score: document.getElementById('interviewScore').value,
                    interview_result: document.getElementById('interviewResult').value
                })
            })

                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // İşlem başarılı olduğunda modalı kapat
                    $('#updateInterviewModal').modal('hide');
                })
                .catch(error => console.error('Error:', error));
        });
    });
    $(document).ready(function() {
        $('#createInterviewCreateButton').click(function(e) {
            e.preventDefault();
            // ID değerini al
            var tc_no = $('#tc_no').val();

            // Tarih değişkenini oluştur
            var date = document.getElementById('interviewDate').value;
            var time = document.getElementById('interviewTime').value;

            const platform = document.getElementById('interviewType') ? document.getElementById('interviewType').value : null;
            const address = document.getElementById('meetingLink') ? document.getElementById('meetingLink').value : null;
            const person = document.getElementById('interviewer') ? document.getElementById('interviewer').value : null;

            $.ajax({
                url: '/panel/Mulakat-Olustur',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tc_no: tc_no,
                    date: date,
                    time: time,
                    platform: platform,
                    person: person,
                    address: address
                },
                success: function(response) {
                    console.log('Aday Reddedildi:', response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
        $('#confirmbtn').click(function(e) {
            e.preventDefault();
            // ID değerini al
            var adayid = $('#adayid').val();

            $.ajax({
                url: "{{ route('confirm-scholar', '') }}/" + adayid,
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
console.log(response);
location.reload();
},
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
        new Pikaday({
            field: document.getElementById('editinterviewDate'),
            format: 'DD-MM-YYYY',
            yearRange: [1900, new Date().getFullYear()],
            toString(date, format) {
                const day = (`0${date.getDate()}`).slice(-2);
                const month = (`0${date.getMonth() + 1}`).slice(-2);
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            },
            parse(dateString, format) {
                const parts = dateString.split('-');
                const day = parseInt(parts[2], 10);
                const month = parseInt(parts[1], 10) - 1;
                const year = parseInt(parts[0], 10);
                return new Date(year, month, day);
            },
            i18n: {
                previousMonth: 'Önceki Ay',
                nextMonth: 'Sonraki Ay',
                months: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
                weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
            },
            firstDay: 1,
        });
        document.getElementById('editinterviewDateIcon').addEventListener('click', function() {
            pickerDob.show();
        });
        new Pikaday({
            field: document.getElementById('interviewDate'),
            format: 'DD-MM-YYYY',
            yearRange: [1900, new Date().getFullYear()],
            toString(date, format) {
                const day = (`0${date.getDate()}`).slice(-2);
                const month = (`0${date.getMonth() + 1}`).slice(-2);
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            },
            parse(dateString, format) {
                const parts = dateString.split('-');
                const day = parseInt(parts[2], 10);
                const month = parseInt(parts[1], 10) - 1;
                const year = parseInt(parts[0], 10);
                return new Date(year, month, day);
            },
            i18n: {
                previousMonth: 'Önceki Ay',
                nextMonth: 'Sonraki Ay',
                months: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
                weekdays: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
                weekdaysShort: ['Pz', 'Pt', 'Sa', 'Ça', 'Pe', 'Cu', 'Ct']
            },
            firstDay: 1,
        });
        document.getElementById('interviewDateIcon').addEventListener('click', function() {
            pickerDob.show();
        });
        $('#saveinterview').click(function(e) {
            e.preventDefault();
            // ID değerini al
            var tc_no = $('#tc_no').val();
            var date = document.getElementById('dob').value;

            var time = document.getElementById('stepinterviewTime').value;

            const platform = document.getElementById('stepinterviewType') ? document.getElementById('stepinterviewType').value : null;
            const address = document.getElementById('stepinterviewLocation') ? document.getElementById('stepinterviewLocation').value : null;
            const person = document.getElementById('stepinterviewer') ? document.getElementById('stepinterviewer').value : null;
            const detail = document.getElementById('stepinterviewdetail') ? document.getElementById('stepinterviewdetail').value : null;
            const mulakatform = document.getElementById('mulakatform') ? document.getElementById('mulakatform').value : null;

            $.ajax({
                url: '/panel/Mulakat-Olustur',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    mulakatform: mulakatform,
                    tc_no: tc_no,
                    date: date,
                    time: time,
                    platform: platform,
                    person: person,
                    address: address,
                    detail:detail
                },
                success: function(response) {
                    $('#createInterviewSuccessModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });
    $(document).ready(function() {
        /*$('#confirm').click(function(e) {
            e.preventDefault();

            // ID değerini al
            var adayid = $('#adayid').val();

            // AJAX isteği
            $.ajax({
                url: '/panel/onay/' + adayid,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için
                    },
                    success: function(response) {
                        // Başarılı işlem mesajı
                        alert('İşlem başarılı! Aday Onaylandi');
                        location.reload();
                    },
                    error: function(xhr) {
                        // Hata durumunda mesaj
                        alert('İşlem sırasında bir hata oluştu.');
                    }
                });
            });
        });*/

        $('#deniedmodalbtn').click(function(e) {
            e.preventDefault();
            // ID değerini al
            console.log('Butona tıklandı'); // Bu satırla kontrol edin

            var tc_no = $('#tc_no').val();
            // red durumundaki bilgileri ver
            const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
            const redAciklamasi = document.getElementById('redAciklamasi') ? document.getElementById('redAciklamasi').value : null;
            // iade durumundaki bilgileri ver

            $.ajax({
                url: '/panel/Basvuru-Aday-Reddet',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tc_no: tc_no,
                    redSebebi: redSebebi,
                    redAciklamasi: redAciklamasi,
                },
                success: function(response) {
                    console.log('Aday Reddedildi:', response);
                    location.reload();

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#to-returnbtn').click(function(e) {
            e.preventDefault();

            // ID değerini al
            var tc_no = $('#tc_no').val();
            const iadeSebebi = $('#iadeSebebi').val() || null;
            const iadeAciklama = $('#iadeAciklamasi').val() || null;

            // AJAX isteği
            $.ajax({
                url: '/panel/Basvuru-Aday-Iade',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tc_no: tc_no,
                    iadeSebebi: iadeSebebi,
                    iadeAciklama: iadeAciklama,
                },
                success: function(response) {
                    // Başarılı işlem mesajı
                    location.reload();
                },
                error: function(xhr) {
                    // Hata durumunda mesaj
                    alert('İşlem sırasında bir hata oluştu.');
                    console.error(xhr.responseText); // Hata mesajını konsola yazdır
                }
            });
        });
    });
    $('#reload').click(function(e) {
        location.reload();
    });
</script>
<script>
    $('#confirm').on('click', function() {
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();

    });

    $(document).ready(function() {
        // Restrict input on tc_no to numbers only
        $(document).on('input', '#tc_no', function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);
        });

        function validateTCKN(tc_no) {
            if (!tc_no || tc_no.length !== 11) return false;
            if (tc_no[0] === '0') return false;
            if (!/^\d+$/.test(tc_no)) return false;

            let digits = tc_no.split('').map(Number);
            let oddSum = digits[0] + digits[2] + digits[4] + digits[6] + digits[8];
            let evenSum = digits[1] + digits[3] + digits[5] + digits[7];

            let digit10 = (oddSum * 7 - evenSum) % 10;
            if (digit10 < 0) digit10 += 10;
            if (digits[9] !== digit10) return false;

            let totalSum = digits.slice(0, 10).reduce((a, b) => a + b, 0);
            if (digits[10] !== (totalSum % 10)) return false;

            return true;
        }

        function submitForm(redirectUrl = null) {
            // TC Kimlik No doğrulaması
            let tcNo = $('#tc_no').val();
            if (tcNo !== undefined && !validateTCKN(tcNo)) {
                iziToast.error({
                    title: 'Hata',
                    message: 'Lütfen geçerli bir TC Kimlik Numarası giriniz.',
                });
                return;
            }

            // Form verilerini al
            let formData = {};

            // Tüm input, select ve textarea elemanlarını seç
            document.querySelectorAll(`#basvuruForm input, #basvuruForm select, #basvuruForm textarea`).forEach(input => {
                formData[input.id] = input.value;
            });
            document.querySelectorAll(`#basvuruForm input[type="checkbox"]`).forEach(checkbox => {
                formData[checkbox.id] = checkbox.checked ? "on" : "off";
            });
            // AJAX isteği
            $.ajax({
                url: '/panel/Basvuru-Aday-Bilgileri-Kaydet',
                type: 'POST',
                data: {
                    formData : formData,
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için

                },
                success: function(response) {
                    console.log(response);
                    iziToast.success({
                        title: 'İşlem Başarılı',
                        message: 'Bilgiler Guncellendi', // Assuming response.success contains the success message
                    });
                    // İşlem başarılıysa yönlendirme veya sayfada kalma
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else {
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                    let errorMessage = 'Bir hata oluştu.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    iziToast.error({
                        title: 'Hata',
                        message: errorMessage,
                    });
                }
            });
        }

        // "Kaydet" butonuna tıklanınca
        $('#kaydetBtn').click(function() {
            submitForm();
        });

        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Aday-Bursiyerler');
        });
        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#completeButton').click(function() {
            submitForm('/panel/Aday-Bursiyerler');
        });
    });
    // Tüm edit butonlarına click event listener ekliyoruz
    document.querySelectorAll('.editBursBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-editid');
            const kurumAdi = this.getAttribute('data-kurumadi');
            const kurumTuru = this.getAttribute('data-kurumturu');
            const bursMiktari = this.getAttribute('data-bursmiktari');
            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('editkurumAdi').value = kurumAdi;
            document.getElementById('editkurumTuru').value = kurumTuru;
            document.getElementById('editbursMıktarı').value = bursMiktari;
            document.getElementById('editbursid').value = id;

            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('bursDuzenleModal')).show();
        });
    });
    // Tüm edit butonlarına click event listener ekliyoruz
    document.querySelectorAll('.editSiblingBtn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const surname = this.getAttribute('data-surname');
            const age = this.getAttribute('data-age');
            const educ_status = this.getAttribute('data-educ_status');
            const maritality = this.getAttribute('data-maritality');
            const job = this.getAttribute('data-job');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('editKardesid').value = id;
            document.getElementById('editkardesAdi').value = name;
            document.getElementById('editkardesSoyadi').value = surname;
            document.getElementById('editkardesYasi').value = age;
            const educStatusSelect = document.getElementById('editkardesOgrenimDurumu');
            for (let i = 0; i < educStatusSelect.options.length; i++) {
                if (educStatusSelect.options[i].text === educ_status) {
                    educStatusSelect.selectedIndex = i;
                    break;
                }
            }

            const maritalitySelect = document.getElementById('editkardesMedeniDurumu');
            for (let i = 0; i < maritalitySelect.options.length; i++) {
                if (maritalitySelect.options[i].text === maritality) {
                    maritalitySelect.selectedIndex = i;
                    break;
                }
            }
            document.getElementById('editkardesMeslegi').value = job;

            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('kardesDuzenleModal')).show();
        });
    });
    document.querySelectorAll('.deleteinterviewbtn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('mulakatid').value = id;


            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('deleteInterviewModal')).show();
        });
    });

</script>
<script !src="">

    $(document).ready(function() {


// Gün, Ay ve Yıl için Seçenekleri Doldur
        const daySelect = document.getElementById("interviewDay");
        const monthSelect = document.getElementById("interviewMonth");
        const yearSelect = document.getElementById("interviewYear");
        const hourSelect = document.getElementById("interviewHour");
        const minuteSelect = document.getElementById("interviewMinute");

        for (let day = 1; day <= 31; day++) {
            const option = document.createElement("option");
            option.value = day;
            option.textContent = day;
            daySelect.appendChild(option);
        }


        for (let i = 1; i <= 24; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            hourSelect.appendChild(option);
        }
        for (let i = 0; i <= 55;) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            minuteSelect.appendChild(option);
            i = i + 5;

        }

        const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"];
        months.forEach((month, index) => {
            const option = document.createElement("option");
            option.value = index+1;
            option.textContent = month;
            monthSelect.appendChild(option);
        });

        const currentYear = new Date().getFullYear();
        for (let year = currentYear; year >= 1900; year--) {
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
    });
</script>
<script !src="">
    $('input[type="file"]').on('change', function () {
        var fileInput = $(this)[0];
        var file = fileInput.files[0];
        var fileId = $(this).data('id'); // Burada `data-id` ile dosyanın id'sini alıyoruz.
        var tc_no = $('#tc_no').val();
        var adayId = $('#adayId').val();
        var formData = new FormData();

        formData.append('tc_no', tc_no);
        formData.append('adayId', adayId);
        formData.append('file', file);
        formData.append('id', $(this).attr('id'));
        formData.append('fileType', $(this).data('file-type'));
        formData.append('fileId', fileId); // Dosya id'sini FormData'ya ekliyoruz.
        formData.append('_token', $('meta[name="csrf-token"]').attr('content') );// CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload-panel', // Sunucuya dosya göndermek için URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Dosya başarıyla yüklendi!');
                location.reload();
                // Yüklenen dosyanın URL'ini veritabanına kaydet
                // Veritabanı işlemleri burada yapılabilir
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    });
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
    $('.delete-icon').click(function() {
        var fileId = $(this).attr('id');

        var tc = $('#tc_no').val();

        $.ajax({
            url: "/delete-doc-panel/" + fileId +'/'+tc,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF token
            },
            success: function(response) {
                alert('Dosya başarıyla silindi.');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
                alert('Bir hata oluştu.');
            }
        });
    });
    function belgeDurumDegis(status) {
        // Tüm seçili checkbox'ları seç
        const selectedDocs = [];
        const docsboxes = document.querySelectorAll('input[name="docsCheckbox"]:checked');

        // Her bir işaretli checkbox'ın 'data-id' değerini al
        docsboxes.forEach(checkbox => {
            const docId = checkbox.getAttribute('data-id');
            if (docId) {
                selectedDocs.push(docId);
            }
        });

        // Eğer hiç seçili checkbox yoksa uyarı ver
        if (selectedDocs.length === 0) {
            console.warn("Seçili belge yok!");
            return;
        }

        $.ajax({
            url: '{{ route('file.changestatus.newscholars') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                docsId: selectedDocs,
                status: status
            },
            success: function(response) {
                console.log('Durum Degistirildi:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }
    function checkAllDocsCheckboxes() {
        // Tüm name="docsCheckbox" olan inputları seç
        const checkboxes = document.querySelectorAll('input[name="docsCheckbox"]');

        // İlk checkbox'ın checked durumunu kontrol et
        const isChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        // Eğer tüm checkbox'lar checked ise, tümünü unchecked yap, değilse tümünü checked yap
        checkboxes.forEach(checkbox => {
            checkbox.checked = !isChecked;
        });
    }
    function educationTypeChange() {
                    // Tüm 'educdiv' sınıflı div'lere 'd-none' sınıfını ekleyelim
                    document.querySelectorAll('.educdiv').forEach(function(div) {
                        div.classList.add('d-none');
                    });

                    // Seçilen değeri alalım
                    var selectedValue = this.value;

                    // Eğer seçilen değer 'seçiniz' değilse, ilgili div'den 'd-none' sınıfını kaldır
                    if (selectedValue !== 'seçiniz') {
                        if(selectedValue == 'lisans' || selectedValue == 'onlisans'){
                            var ortakdiv = document.getElementById('lisansdiv');
                            ortakdiv.classList.remove('d-none');
                        }
                        var selectedDiv = document.getElementById(selectedValue + 'div');
                        if (selectedDiv) {
                            selectedDiv.classList.remove('d-none');
                        }
                        if(selectedValue == 'lisans'){
                            var lisansSinif = document.getElementById('university_class');
                            lisansSinif.classList.remove('d-none');
                            var oKN3UeDifPTo = document.getElementById('oKN3UeDifPTo');
                            oKN3UeDifPTo.classList.add('d-none');
                        }
                        if(selectedValue == 'onlisans'){
                            var lisansSinif = document.getElementById('university_class');
                            lisansSinif.classList.add('d-none');
                            var oKN3UeDifPTo = document.getElementById('oKN3UeDifPTo');
                            oKN3UeDifPTo.classList.remove('d-none');
                        }
                    }
                }
    document.querySelectorAll('.file-uploaded-document').forEach(function(div) {
        div.addEventListener('click', function() {
            // Data-path attribute'undan dosya yolunu al
            const filePath = this.getAttribute('data-path');

            // Modal içeriğini temizle
            const documentViewer = document.getElementById('documentViewer');
            documentViewer.innerHTML = ''; // Daha önceki iframe'i temizle
            documentViewer.removeAttribute('data');
            documentViewer.removeAttribute('type');

            // Dosya uzantısını kontrol et
            const fileExtension = filePath.split('.').pop().toLowerCase();

            // Eğer dosya bir PDF ise
            if (fileExtension === 'pdf') {
                const objectElement = document.createElement('object');
                objectElement.setAttribute('data', filePath);
                objectElement.setAttribute('type', 'application/pdf');
                objectElement.setAttribute('width', '100%');
                objectElement.setAttribute('height', '500px');
                documentViewer.appendChild(objectElement);

                // PDF indirme linkini güncelle
                document.getElementById('pdfDownloadLink').setAttribute('href', filePath);
            } else {
                // JPG veya başka bir görüntü dosyası için iframe kullanarak göster
                const iframeElement = document.createElement('iframe');
                iframeElement.setAttribute('src', filePath);
                iframeElement.setAttribute('style', 'width: 100%; height: 500px;');
                iframeElement.setAttribute('frameborder', '0');
                documentViewer.appendChild(iframeElement);
            }
        });
    });


    document.querySelectorAll('.edit-interview-info-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Data attribute'lerinden bilgileri al
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const platform = this.getAttribute('data-platform');
            const person = this.getAttribute('data-person');
            const personId = this.getAttribute('data-person-id');
            const address = this.getAttribute('data-address');

            // Form alanlarını doldur
            document.getElementById('editmulakatid').value = id;
            document.getElementById('editinterviewDate').value = formatDate(date);
            document.getElementById('editinterviewTime').value = time;

            // Mülakat tipi select
            const typeSelect = document.getElementById('editinterviewType');
            Array.from(typeSelect.options).forEach(option => {
                if (option.value === platform) {
                    option.selected = true;
                }
            });

            // Mülakatı yapacak kişi select
            const interviewerSelect = document.getElementById('editinterviewer');
            Array.from(interviewerSelect.options).forEach(option => {
                if (option.value === personId || option.text === person) {
                    option.selected = true;
                }
            });

            // Adres/Link
            document.getElementById('editinterviewadress').value = address;

            // Modalı göster
            $('#interviewDetailsModal').modal('show');
        });
    });

    // Tarih formatı için yardımcı fonksiyon
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    var faculty = document.getElementById('master_departmant');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getDepartmants(faculty,'grade_departmant');

        });
    }
    var unicity = document.getElementById('university_city');

    if (unicity !== null) {

        unicity.addEventListener('change', function() {
            loadUnivercities('current_university');
            var masteruni = document.getElementById('masterUniversity');
            if(masteruni !== null){
                loadUnivercities('masterUniversity');
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
// Puanları yeniden hesapla butonu için AJAX fonksiyonu
    $('#recalculatePointsBtn').click(function() {
        const adayId = $(this).data('aday-id');
        
        // Loading göster
        Swal.fire({
            title: 'Puanlar Hesaplanıyor...',
            text: 'Lütfen bekleyiniz',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/aday-puan-hesapla',
            method: 'POST',
            data: {
                aday_id: adayId,
                _token: $('input[name="_token"]').val() || $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı!',
                        text: 'Puanlar başarıyla yeniden hesaplandı. Toplam puan: ' + response.totalPoints,
                        confirmButtonText: 'Tamam'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Sayfayı yenile veya sadece puan kısmını güncelle
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: response.message || 'Puanlar hesaplanırken bir hata oluştu.',
                        confirmButtonText: 'Tamam'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Hatası:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: 'Puanlar hesaplanırken bir hata oluştu. Lütfen tekrar deneyin.',
                    confirmButtonText: 'Tamam'
                });
            }
        });
    });
</script>

