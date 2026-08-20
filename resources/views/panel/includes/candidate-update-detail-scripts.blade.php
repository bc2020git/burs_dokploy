<script>
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
    const selectedPeriodId = document.getElementById('termControlSelect').value;
    document.getElementById('documents').classList.add('d-none');
    document.getElementById('documentControl').classList.remove('d-none');

    // Tüm belge satırlarını kontrol et
    const documentRows = document.querySelectorAll('#documentList tr');
    documentRows.forEach(row => {
        let showRow = false;
        const docName = row.querySelector('input[name="doccheckbox"]').dataset.docname;

        // Seçili dönem için belge doğrulama kontrolü
        @php
            $docverify = [];
            if (!is_null($aday->scholar)) {
                $docverify = $aday->scholar->docverify;
            }
        @endphp

        @foreach($docverify as $verify)
            if ("{{ $verify->doc_name }}" === docName && "{{ $verify->period_id }}" === selectedPeriodId) {
                showRow = true;
            }
        @endforeach

        // Eğer belge bu dönemde yoksa veya başka döneme aitse satırı gizle
        row.style.display = showRow ? '' : 'none';
    });

    // Toplu işlem butonlarının görünürlüğünü kontrol et
    const visibleRows = document.querySelectorAll('#documentList tr[style="display: "]');
    const bulkButtons = document.querySelectorAll('.button-container-doc button, .button-container-doc a');

    if (visibleRows.length === 0) {
        bulkButtons.forEach(btn => btn.style.display = 'none');
    } else {
        bulkButtons.forEach(btn => btn.style.display = '');
    }
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

            const platform = document.getElementById('modalinterviewType') ? document.getElementById('modalinterviewType').value : null;
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
            var date = document.getElementById('stepinterviewDate').value;

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
        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};

            // Tüm input, select ve textarea elemanlarını seç
            document.querySelectorAll(`#basvuruForm input, #basvuruForm select, #basvuruForm textarea`).forEach(input => {
                formData[input.id] = input.value;
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
                    console.error("Hata Detayları:", xhr.responseText);                        }
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
        var fileId = $(this).attr('id');


        $.ajax({
            url: "/delete-doc-panel/" + fileId,
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
            console.warn("Seçili belge yok!");
            return;
        }

        $.ajax({
            url: '/change-status-new-panel',
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


    document.querySelectorAll('.edit-interview-info-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Butonun data attribute'lerinden bilgileri alıyoruz
            const id = this.getAttribute('data-id');
            const date = this.getAttribute('data-date');
            const time = this.getAttribute('data-time');
            const platform = this.getAttribute('data-platform');
            const person = this.getAttribute('data-person');
            const score = this.getAttribute('data-score');
            const result = this.getAttribute('data-result');
            const address = this.getAttribute('data-address');

            // Modal içindeki form alanlarını güncelliyoruz
            document.getElementById('editmulakatid').value = id;
            document.getElementById('concludeInterviewId').value = id;
            document.getElementById('editinterviewDate').value = date;
            document.getElementById('editinterviewTime').value = time;
            document.getElementById('editinterviewType').value = platform;
            document.getElementById('editinterviewer').value = person;
            document.getElementById('editinterviewScore').value = score;
            document.getElementById('editinterviewResult').value = result;
            document.getElementById('editinterview_address').value = address;

            // Modalı açıyoruz
            new bootstrap.Modal(document.getElementById('updateInterviewModal')).show();
        });
    });


</script>
