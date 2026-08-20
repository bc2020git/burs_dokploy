<script !src="">
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
                    filename: '{{ $aday->infos->name }}_{{ $aday->infos->surname }}_aktif_burs_basvuru_formu.pdf',
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
    // PDF indirme fonksiyonu

    function getFaculties(a, districtSelectId) {

        var selectedOption = a.options[a.selectedIndex];
        var uni = selectedOption.getAttribute('data-id');
        $.ajax({
            url: '/get-faculties/' + uni,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                var option = document.createElement('option');
                option.text = 'Fakulte Seciniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                // Dönen ilçeleri select içerisine ekleme
                data.data.forEach(function(faculty) {
                    var option = document.createElement('option');
                    option.value = faculty.name; // fakülte adı değeri
                    option.text = faculty.name; // fakülte adı metni
                    option.setAttribute('data-id', faculty
                        .id); // Fakülte id'sini data-id olarak ekle

                    districtSelect.appendChild(option);
                });
            }
        });
    }

    function getDepartmants(a, districtSelectId) {
        var faculty = a.options[a.selectedIndex].getAttribute('data-id');
        $.ajax({
            url: '/get-departmants/' + faculty,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                console.log(data);
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Bölüm Seçiniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.name; // fakülte adı değeri
                    option.text = faculty.name; // fakülte adı metni
                    districtSelect.appendChild(option);
                });
            }
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

    function loadUnivercities(selectElementId) {
        var cityId = $('#university_city option:selected').data('id');

        $.ajax({
            url: '/get-univercities/' + cityId, // Laravel'de tanımlı URL
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
                        $selectElement.append('<option data-id="' + city.id + '" value="' + city
                            .name + '" title="' + city.name + '">' + city.name + '</option>');
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

    var unicity = document.getElementById('university_city');

    if (unicity !== null) {
        loadCities('university_city'); // Nufusa kayitli oldugu il

        unicity.addEventListener('change', function() {
            loadUnivercities('current_university');
            var selectedOption = unicity.options[unicity.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            sehirburskontrol(dataId); // Şehir burs kontrol fonksiyonunu çağır

        });
    }
</script>
<script !src="">
    $('input[type="file"]').on('change', function() {
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
        var periodId = $('#termSelect').val();
        formData.append('period', periodId);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload-panel-active', // Sunucuya dosya göndermek için URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
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

    $('.delete-icon').click(function() {
        var fileId = $(this).attr('id');
        var tc = $('#tc_no').val();


        $.ajax({
            url: "/delete-active-doc-panel/" + fileId + '/' + tc,
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

    $('#reload').click(function(e) {
        location.reload();
    });
</script>
<script>
    document.getElementById('confirmButton').addEventListener('click', function() {
        var warningModal = bootstrap.Modal.getInstance(document.getElementById('warningModal'));
        warningModal.hide();

        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>

<script>
    // Basit toggle fonksiyonları - sadece div göster/gizle
    function toggleDocumentsView() {
        document.getElementById('documents').classList.remove('d-none');
        document.getElementById('documentControl').classList.add('d-none');
    }

    function toggleDocumentControlView() {
        document.getElementById('documents').classList.add('d-none');
        document.getElementById('documentControl').classList.remove('d-none');
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('updateInterviewDetails').addEventListener('click', function() {
            $('#updateInterviewModal').modal('hide');
            $('#interviewDetailsModal').modal('show');
        });
        document.getElementById('confirmGraduate').addEventListener('click', function() {
            $('#graduateConfirmModal').modal('hide');
            $('#graduateSuccessModal').modal('show');
        });

        document.getElementById('concludeInterview').addEventListener('click', function() {
            $('#updateInterviewModal').modal('hide');
            $('#concludeInterviewModal').modal('show');
        });

        document.getElementById('interviewDetailsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            alert('Mülakat bilgileri güncellendi!');
            $('#interviewDetailsModal').modal('hide');
        });

        document.getElementById('concludeInterviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            alert('Mülakat sonuçları güncellendi!');
            $('#concludeInterviewModal').modal('hide');
        });
    });






    function submitForm(redirectUrl = null) {
        // Form verilerini al
        let formData = {};
        var form_id = $('#form_id').val();

        // Tüm input, select ve textarea elemanlarını seç
        document.querySelectorAll(`#basvuruForm input, #basvuruForm select, #basvuruForm textarea`).forEach(input => {
            formData[input.id] = input.value;
        });
        document.querySelectorAll(`#basvuruForm input[type="checkbox"]`).forEach(checkbox => {
            formData[checkbox.id] = checkbox.checked ? "on" : "off";
        });
        formData['form_id'] = form_id;
        // AJAX isteği
        $.ajax({
            url: '/panel/Aktif-Bursiyer-Bilgileri-Kaydet',
            type: 'POST',
            data: {
                formData: formData,
                _token: '{{ csrf_token() }}'

            },
            success: function(response) {
                console.log(response);
                iziToast.success({
                    title: 'İşlem Başarılı',
                    message: 'Bilgiler Guncellendi',
                });
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {}
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function submitinterviewform(redirectUrl = null) {
        var form_id = $('#form_id').val();
        var date = $('#stepinterviewDate').val();
        var time = $('#stepinterviewTime').val();
        var platform = $('#stepinterviewType').val();
        var person = $('#stepinterviewer').val();
        var address = $('#stepinterviewLocation').val();


        $.ajax({
            url: '/panel/aktif-mulakat-olustur',
            type: 'POST',
            data: {
                form: '1',
                form_id: form_id,
                date: date,
                time: time,
                platform: platform,
                person: person,
                address: address,
                _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için
            },
            success: function(response) {
                // İşlem başarılıysa yönlendirme veya sayfada kalma
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    // "Kaydet" butonuna tıklanınca
    $('#save').click(function() {
        submitForm();
    });
    $('#saveinterview').click(function() {
        submitinterviewform();
    });

    // "Kaydet ve Kapat" butonuna tıklanınca
    $('#save-close').click(function() {
        submitForm('/panel/Bursiyerler');
    });

    function getDistricts(a, districtSelectId) {
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

    var p_school_city = document.getElementById('p_school_city');

    if (p_school_city !== null) {
        document.getElementById('p_school_city').addEventListener('change', function() {
            var districtSelectId = 'p_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var m_school_city = document.getElementById('m_school_city');

    if (m_school_city !== null) {
        document.getElementById('m_school_city').addEventListener('change', function() {
            var districtSelectId = 'm_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var h_school_city = document.getElementById('h_school_city');

    if (h_school_city !== null) {
        document.getElementById('h_school_city').addEventListener('change', function() {
            var districtSelectId = 'h_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    $('#completeButton').click(function() {
        submitForm('/panel/Bursiyerler');
    });

    function getFaculties(a, districtSelectId) {

        var selectedOption = a.options[a.selectedIndex];
        var uni = selectedOption.getAttribute('data-id');
        $.ajax({
            url: '/get-faculties/' + uni,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                var option = document.createElement('option');
                option.text = 'Fakulte Seciniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                // Dönen ilçeleri select içerisine ekleme
                data.data.forEach(function(faculty) {
                    var option = document.createElement('option');
                    option.value = faculty.name; // fakülte adı değeri
                    option.text = faculty.name; // fakülte adı metni
                    option.setAttribute('data-id', faculty
                        .id); // Fakülte id'sini data-id olarak ekle

                    districtSelect.appendChild(option);
                });
            }
        });
    }

    var master_university = document.getElementById('master_university');

    if (master_university !== null) {

        master_university.addEventListener('change', function() {
            var a = master_university.value; // Seçilen şehri al
            var selectedOption = master_university.options[master_university.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getFaculties(master_university, 'master_departmant');
        });
    }
    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getDepartmants(faculty, 'grade_departmant');

        });
    }
    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            getDepartmants(faculty, 'grade_departmant');

        });
    }
</script>
<script>
    function islemIcinDiziGonderActive(islemid) {
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="doccheckbox"]:checked');
        var tc = $('#tc_no').val();
        var form_id = $('#form_id').val();
        var period = $('#termControlSelect').val() || $('#period_id').val();
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

        if (islemid === 3) {
            $.ajax({
                url: '/panel/aktif-toplu-belge-yonet',
                method: 'POST',
                data: {
                    userIds: selectedUserIds,
                    tc: tc,
                    period: period,
                    islemId: islemid,
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
                        var blob = new Blob([response], {
                            type: 'application/zip'
                        });
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
        }
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
                        alert(
                            'Bu dosya tipi desteklenmiyor. Lütfen desteklenen dosya tiplerinden birini seçin.'
                        );
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
                    const changeEvent = new Event('change', {
                        bubbles: true
                    });
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
<script>
    function fetchPeriodDocuments(periodId, successCallback) {
        var scholarId = $('#scholar_id').val();

        // Show loading state if needed

        $.ajax({
            url: '{{ route('get-period-documents') }}',
            method: 'POST',
            data: {
                scholar_id: scholarId,
                period_id: periodId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (successCallback) successCallback(response);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Belgeler getirilirken bir hata oluştu.');
            }
        });
    }

    function showDocuments() {
        var periodId = $('#termSelect').val();
        fetchPeriodDocuments(periodId, function(response) {
            $('#documentCardsContainer').html(response.cardsHtml);
            document.getElementById('documents').classList.remove('d-none');
            document.getElementById('documentControl').classList.add('d-none');
            rebindDocumentEvents();
        });
    }

    function showDocumentControl() {
        var periodId = $('#termControlSelect').val();
        fetchPeriodDocuments(periodId, function(response) {
            $('#documentList').html(response.tableHtml);
            document.getElementById('documents').classList.add('d-none');
            document.getElementById('documentControl').classList.remove('d-none');
            // Re-bind events if necessary for the table (e.g. if checkboxes had listeners attached in JS)
        });
    }

    function rebindDocumentEvents() {
        // Re-bind Drag & Drop
        if (typeof initializeDragDrop === 'function') {
            initializeDragDrop();
        }

        // Re-bind File Preview
        document.querySelectorAll('.file-uploaded-document').forEach(function(div) {
            div.addEventListener('click', function() {
                const filePath = this.getAttribute('data-path');
                const documentViewer = document.getElementById('documentViewer');
                documentViewer.innerHTML = '';
                documentViewer.removeAttribute('data');
                documentViewer.removeAttribute('type');
                const fileExtension = filePath.split('.').pop().toLowerCase();

                if (fileExtension === 'pdf') {
                    const objectElement = document.createElement('object');
                    objectElement.setAttribute('data', filePath);
                    objectElement.setAttribute('type', 'application/pdf');
                    objectElement.setAttribute('width', '100%');
                    objectElement.setAttribute('height', '500px');
                    documentViewer.appendChild(objectElement);
                    document.getElementById('pdfDownloadLink').setAttribute('href', filePath);
                } else {
                    const iframeElement = document.createElement('iframe');
                    iframeElement.setAttribute('src', filePath);
                    iframeElement.setAttribute('style', 'width: 100%; height: 500px;');
                    iframeElement.setAttribute('frameborder', '0');
                    documentViewer.appendChild(iframeElement);
                }
            });
        });

        // Re-bind Delete
        $('.delete-icon').off('click').on('click', function() {
            var fileId = $(this).attr('id');
            var tc = $('#tc_no').val();
            var periodId = $('#termSelect').val();

            if (!confirm('Belgeyi silmek istediğinize emin misiniz?')) return;

            $.ajax({
                url: "/delete-active-doc-panel/" + fileId + '/' + tc + '/' + periodId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    alert('Dosya başarıyla silindi.');
                    showDocuments();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    alert('Bir hata oluştu.');
                }
            });
        });

        // Re-bind file input change (upload)
        $('input[type="file"]').off('change').on('change', function() {
            var fileInput = $(this)[0];
            var file = fileInput.files[0];
            var fileId = $(this).data('id');
            var tc_no = $('#tc_no').val();
            var formData = new FormData();

            formData.append('tc_no', tc_no);
            formData.append('file', file);
            formData.append('id', $(this).attr('id'));
            formData.append('fileType', $(this).data('file-type'));
            formData.append('fileId', fileId);
            var periodId = $('#termSelect').val();
            formData.append('period', periodId);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: '/upload-panel-active',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Dosya başarıyla yüklendi!');
                    showDocuments(); // Refresh the view
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    }
</script>
