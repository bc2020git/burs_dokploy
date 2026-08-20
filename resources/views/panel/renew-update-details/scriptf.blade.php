<script>
        document.getElementById('kyBelgeIndirBtn').addEventListener('click', function () {
            const selectedUserIds = [];
            const checkboxes = document.querySelectorAll('input[name="doccheckbox"]:checked');
            var tc = $('#tc_no').val();
            var form_id = $('#form_id').val();
            var period = $('#period_id').val();
            var name = $('#name').val();
            var surname = $('#surname').val();

        checkboxes.forEach(function(checkbox) {
            const docname = checkbox.getAttribute('data-docname');
            if (docname) {
                selectedUserIds.push(docname);
            }
        });

        if (selectedUserIds.length === 0) {
            alert('Lütfen en az bir belge seçiniz.');
            return;
        }

            $.ajax({
                url: '/panel/ky-toplu-belge-yonet',
                method: 'POST',
                data: {
                    userIds: selectedUserIds,
                    tc: tc,
                    period: period,
                    islemId: 3,
                    form_id: form_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    if (response.type === "application/json") {
                        // Hata durumunda
                        var reader = new FileReader();
                        reader.onload = function() {
                            var error = JSON.parse(this.result);
                            alert(error.error);
                        };
                        reader.readAsText(response);
                    } else {
                        // Başarılı durumda
                        var blob = new Blob([response], { type: 'application/zip' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = `${tc}_${name}_${surname}_belgeler.zip`;
                        link.click();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                    alert('Dosya indirme işlemi başarısız oldu.');
                }
            });
        });


</script>
<script>
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
                filename: '{{$aday->infos->name}}_{{$aday->infos->surname}}_Kayit_Yenileme_Bursiyer_Basvuru_Formu.pdf',
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
            getDepartmants(faculty,'grade_departmant');

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

        document.getElementById('interviewDetailsForm').addEventListener('submit', function (e) {
            e.preventDefault();
            $('#interviewDetailsModal').modal('hide');
        });

        document.getElementById('concludeInterviewForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Mülakat sonuçları güncellendi!');
            $('#concludeInterviewModal').modal('hide');
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
    // mulakat alani
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
    // mulakat alani bitti
    $(document).ready(function() {
        $('#createInterviewCreateButton').click(function(e) {
            e.preventDefault();
            // ID değerini al
            var tc_no = $('#tc_no').val();
            var day = document.getElementById('interviewDay').value;
            var month = document.getElementById('interviewMonth').value;
            var year = document.getElementById('interviewYear').value;

            // Tarih değişkenini oluştur
            var date = year + '-' + month + '-' + day;

            var hour = document.getElementById('interviewHour').value;
            var minute = document.getElementById('interviewMinute').value;
            var time = hour + ':' + minute;

            const platform = document.getElementById('interviewLocation') ? document.getElementById('interviewLocation').value : null;
            const address = document.getElementById('createinterviewmodaladdress') ? document.getElementById('createinterviewmodaladdress').value : null;
            const person = document.getElementById('createinterviewer') ? document.getElementById('createinterviewer').value : null;

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
        $('#forminterviewcreatebtn').click(function(e) {
            e.preventDefault();
            // ID değerini al
            var tc_no = $('#tc_no').val();
            var date = document.getElementById('forminterviewDate').value;

            var time = document.getElementById('forminterviewTime').value;

            const platform = document.getElementById('forminterviewType') ? document.getElementById('forminterviewType').value : null;
            const address = document.getElementById('forminterviewaddress') ? document.getElementById('forminterviewaddress').value : null;
            const person = document.getElementById('forminterviewer') ? document.getElementById('forminterviewer').value : null;
            const detail = document.getElementById('forminterviewdetail') ? document.getElementById('forminterviewdetail').value : null;

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
                    address: address,
                    detail:detail
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

        $('#kyDeniedbtn').off('click').on('click', function(e) {
            e.preventDefault();
            console.log('Butona tıklandı'); // Bu satırla kontrol edin

            var form_id = $('#adayid').val();
            console.log(form_id);
            const redSebebi = document.getElementById('redSebebi') ? document.getElementById('redSebebi').value : null;
            const redAciklamasi = document.getElementById('redAciklamasi') ? document.getElementById('redAciklamasi').value : null;

            $.ajax({
                url: '/panel/KY-Aday-Reddet',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    form_id: form_id,
                    redSebebi: redSebebi,
                    redAciklamasi: redAciklamasi,
                },
                success: function(response) {
                    console.log('Aday Reddedildi:', response);
                    location.reload(); // Bu satırı geçici olarak devre dışı bırakın ve sonucu kontrol edin
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#toReturnbtn').click(function(e) {
            e.preventDefault();

            // ID değerini al
            var form_id = $('#adayid').val();
            const iadeSebebi = $('#iadeSebebi').val() || null;
            const iadeAciklama = $('#iadeAciklamasi').val() || null;

            // AJAX isteği
            $.ajax({
                url: '/panel/KY-Aday-Iade',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    form_id: form_id,
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

</script>
<script>
    $(document).ready(function() {

        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};

            // Önce tüm checkbox'ları kontrol et ve varsayılan olarak "off" değerini ata
            document.querySelectorAll('#basvuruForm input[type="checkbox"]').forEach(checkbox => {
                formData[checkbox.id] = checkbox.checked ? "on" : "off";
            });

            // Diğer form elemanlarını seç (checkbox'lar hariç)
            document.querySelectorAll('#basvuruForm input:not([type="checkbox"]), #basvuruForm select, #basvuruForm textarea').forEach(input => {
                formData[input.id] = input.value;
            });
            document.querySelectorAll(`#basvuruForm input[type="checkbox"]`).forEach(checkbox => {
                formData[checkbox.id] = checkbox.checked ? "on" : "off";
            });
            // AJAX isteği
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/panel/KY-Bilgileri-Kaydet',
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
                    console.error("Hata Detayları:", xhr.responseText);                        }
            });
        }

        // "Kaydet" butonuna tıklanınca
        $('#kaydetBtn').click(function() {
            submitForm();
        });
        $('#reload').click(function() {
            location.reload();
        });

        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Kayit-Yenileme');
        });
        // tamamla butonuna tıklanınca "Kaydet ve Kapat" butonu tetikle
        $('#completeButton').click(function() {
            submitForm('/panel/Kayit-Yenileme');
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
            document.getElementById('editkardesOgrenimDurumu').value = educ_status;
            document.getElementById('editkardesMedeniDurumu').value = maritality;
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
        var period_id = $('#period_id').val();
        var rnid = $('#adayid').val();
        var scholar_id = $('#scholar_id').val();
        var formData = new FormData();

        formData.append('tc_no', tc_no);
        formData.append('adayId', adayId);
        formData.append('file', file);
        formData.append('period_id', period_id);
        formData.append('rnid', rnid);
        formData.append('id', $(this).attr('id'));
        formData.append('fileType', $(this).data('file-type'));
        formData.append('fileId', fileId); // Dosya id'sini FormData'ya ekliyoruz.
        formData.append('_token', $('meta[name="csrf-token"]').attr('content') );// CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload-panel-ky', // Sunucuya dosya göndermek için URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Dosya başarıyla yüklendi!');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    });

    $('.delete-icon').click(function() {
        var fileId = $(this).attr('id');
        var form_id = $('#adayid').val();


        $.ajax({
            url: "/delete-renew-doc-panel/" + fileId+'/'+form_id,
            type: 'DELETE',
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
            alert("Seçili belge yok!");
            return;
        }

        $.ajax({
            url: '/change-status-renew-panel',
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

    // Drag & Drop İşlevselliği
    document.addEventListener('DOMContentLoaded', function() {
        initializeDragDrop();
    });

    // Drag & Drop fonksiyonlarını başlat
    function initializeDragDrop() {
        // Tüm file-drag-drop-area alanlarını seç
        const dropAreas = document.querySelectorAll('.file-drag-drop-area');

        dropAreas.forEach(dropArea => {
            const fileInput = dropArea.querySelector('input[type="file"]');
            const label = dropArea.querySelector('.file-label');

            if (!fileInput || !label) return;

            // Drag olayları için stil değişiklikleri
            function addHighlight() {
                label.style.backgroundColor = '#f0f8ff';
                label.style.borderColor = '#4069E5';
                label.style.borderStyle = 'dashed';
            }

            function removeHighlight() {
                label.style.backgroundColor = '';
                label.style.borderColor = '';
                label.style.borderStyle = '';
            }

            // Drag enter - dosya sürüklenmeye başlandığında
            dropArea.addEventListener('dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                addHighlight();
            });

            // Drag over - dosya üzerinde sürüklenirken
            dropArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                addHighlight();
            });

            // Drag leave - dosya alan dışına çıktığında
            dropArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeHighlight();
            });

            // Drop - dosya bırakıldığında
            dropArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeHighlight();

                const files = e.dataTransfer.files;

                if (files.length > 0) {
                    const file = files[0];

                    // Dosya tipini kontrol et
                    const acceptedTypes = fileInput.getAttribute('accept');
                    if (acceptedTypes && !isFileTypeAccepted(file, acceptedTypes)) {
                        alert('Bu dosya tipi desteklenmiyor. Lütfen desteklenen dosya tiplerinden birini seçin.');
                        return;
                    }

                    // Dosya boyutunu kontrol et (5MB = 5 * 1024 * 1024 bytes)
                    const maxSize = 5 * 1024 * 1024;
                    if (file.size > maxSize) {
                        alert('Dosya boyutu 5MB\'dan büyük olamaz.');
                        return;
                    }

                    // Dosyayı input alanına ata
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Dosya seçildiğinde change event'ini tetikle
                    const changeEvent = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(changeEvent);

                    console.log('Dosya başarıyla yüklendi:', file.name);
                }
            });

            // Label'a tıklandığında da aynı işlevi sağla (mevcut işlevsellik korunur)
            label.addEventListener('click', function(e) {
                // Varsayılan davranış zaten input'u tetikler
            });
        });
    }

    // Dosya tipini kontrol eden yardımcı fonksiyon
    function isFileTypeAccepted(file, acceptedTypes) {
        const fileType = file.type;
        const fileName = file.name.toLowerCase();

        // Accept string'ini parçala
        const types = acceptedTypes.split(',').map(type => type.trim());

        for (let type of types) {
            // MIME type kontrolü
            if (type.startsWith('.')) {
                // Dosya uzantısı kontrolü
                if (fileName.endsWith(type.toLowerCase())) {
                    return true;
                }
            } else {
                // MIME type kontrolü
                if (fileType === type || fileType.startsWith(type.replace('*', ''))) {
                    return true;
                }
            }
        }

        return false;
    }
</script>
