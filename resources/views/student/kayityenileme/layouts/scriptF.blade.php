<script>
    let renewalCompletionRedirectStarted = false;
    let renewalCompletionModalListenerInitialized = false;

    function completeRenewalApplication(delay = 0) {
        if (renewalCompletionRedirectStarted) {
            return;
        }

        renewalCompletionRedirectStarted = true;
        setTimeout(function() {
            window.location.href = '/student/Kayit-Yenileme-Tamamla/{{ $aday->id }}';
        }, delay);
    }

    function initializeRenewalCompletionAutoRedirect() {
        if (renewalCompletionModalListenerInitialized) {
            return;
        }

        const scholarshipCompletionModalEl = document.getElementById('scholarshipCompletionModal');
        if (!scholarshipCompletionModalEl) {
            return;
        }

        renewalCompletionModalListenerInitialized = true;
        scholarshipCompletionModalEl.addEventListener('shown.bs.modal', function() {
            completeRenewalApplication(300);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeRenewalCompletionAutoRedirect);
    } else {
        initializeRenewalCompletionAutoRedirect();
    }

    $('.formBTNS').on('click', function(e) {
        // Önce StudentTabManager'ın built-in validasyonunu kullan
        const currentStep = StudentTabManager.currentStep;
        const isValid = StudentTabManager.validateCurrentStep(currentStep);

        if (!isValid) {
            // Validasyon başarısız olursa event'i durdur ve işlemi sonlandır
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            return false;
        }

        // Form verilerini topla
        let formData = {};
        const form_id = $('#form_id').val();
        formData['form_id'] = form_id;

        // Text inputlar
        $('input[type="text"]').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).val();
            }
        });

        // Number inputlar
        $('input[type="number"]').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).val();
                // Koşul kontrolü
                if (!validateNumberConditions($(this).attr('id'), $(this).val())) {
                    return false; // Koşul sağlanmazsa form gönderimini durdur
                }
            }
        });

        // Date inputlar
        $('input[type="date"]').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).val();
            }
        });

        // Select elementleri
        $('select').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).val();
            }
        });

        // Email inputlar
        $('input[type="email"]').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).val();
            }
        });
        $('input[type="checkbox"]').each(function() {
            if ($(this).attr('id')) {
                formData[$(this).attr('id')] = $(this).is(':checked') ? 'on' : 'off';
            }
        });

        // Puanı hesapla
        let totalScore = 0;

        // Numara tipindeki alanları kontrol et
        document.querySelectorAll('.number-input').forEach(function(input) {
            const value = parseFloat(input.value);
            const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');

            if (!isNaN(value) && Object.keys(scoringRanges).length > 0) {
                // Hangi aralığa düştüğünü bul
                for (const [key, range] of Object.entries(scoringRanges)) {
                    let inRange = true;

                    // Minimum kontrol
                    if (range.min !== null && value < range.min) {
                        inRange = false;
                    }

                    // Maksimum kontrol
                    if (range.max !== null && value >= range.max) {
                        inRange = false;
                    }

                    if (inRange) {
                        totalScore += parseInt(range.points || 0);
                        console.log(`Number input ${input.id}: value=${value}, points=${range.points}`);
                        break;
                    }
                }
            }
        });

        // Select tipindeki alanları kontrol et
        document.querySelectorAll('select[data-dataset]').forEach(function(select) {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.value && selectedOption.getAttribute('data-points')) {
                const points = parseInt(selectedOption.getAttribute('data-points') || 0);
                totalScore += points;
            }
        });

        console.log(`=== KAYIT YENİLEME - TOPLAM PUAN: ${totalScore} ===`);

        // Toplam puanı formData'ya ekle
        formData['total_score'] = totalScore;

        // AJAX isteği gönder
        $.ajax({
            url: '{{ route('update.renew.form') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                formData: formData
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Bilgiler başarıyla güncellendi');
                    console.log(`Kayıt yenileme kaydedildi - Güncel Puan: ${totalScore}`);
                } else {
                    toastr.error('Bir hata oluştu');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Bir hata oluştu: ' + error);
            }
        });
    });
    // Koşul validasyonu fonksiyonu
    function validateNumberConditions(fieldId, value) {
        // Koşulları backend'den al veya burada tanımla
        const questionConditions = {
            @foreach ($kategoriler as $kategori)
                @foreach ($kategori->soru as $soru)
                    @if ($soru->type == 'number' && $soru->has_conditions && $soru->conditions)
                        '{{ $soru->db_key }}': {!! $soru->conditions !!},
                    @endif
                @endforeach
            @endforeach
        };

        if (questionConditions[fieldId] && value) {
            const conditions = questionConditions[fieldId];
            const numValue = parseFloat(value);

            let isValid = true;
            let failedConditions = [];

            conditions.forEach(condition => {
                let conditionMet = false;

                switch (condition.operator) {
                    case '<':
                        conditionMet = numValue < parseFloat(condition.value);
                        break;
                    case '>':
                        conditionMet = numValue > parseFloat(condition.value);
                        break;
                    case '<=':
                        conditionMet = numValue <= parseFloat(condition.value);
                        break;
                    case '>=':
                        conditionMet = numValue >= parseFloat(condition.value);
                        break;
                }
                if (!conditionMet) {
                    isValid = false;
                    failedConditions.push(condition.operator + ' ' + condition.value);
                }
            });

            if (!isValid) {
                if (fieldId == 'agno') {
                    return true;
                }
                // Modal göster
                showConditionModal(fieldId, failedConditions);
                // Input'u temizle
                $(`#${fieldId}`).val('');
                return false;
            }
        }

        return true;
    }

    // Modal gösterme fonksiyonu
    function showConditionModal(fieldId, failedConditions) {
        const fieldLabel = $(`label[for="${fieldId}"]`).text() || fieldId;
        const conditionText = failedConditions.join(', ');

        // Modal içeriğini oluştur
        const modalContent = `
            <div class="modal fade" id="conditionModal" tabindex="-1" aria-labelledby="conditionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="conditionModalLabel">Geçersiz Değer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>${fieldLabel}</strong> alanı için girdiğiniz değer geçerli koşulları sağlamıyor.</p>
                            <p><strong>Geçerli koşullar:</strong> ${conditionText}</p>
                            <p>Lütfen geçerli bir değer giriniz.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Mevcut modalı kaldır
        $('#conditionModal').remove();

        // Yeni modalı ekle ve göster
        $('body').append(modalContent);
        $('#conditionModal').modal('show');
    }

    // Input'tan çıkıldığında koşul kontrolü
    $(document).on('focusout', 'input[type="number"]', function() {
        const fieldId = $(this).attr('id');
        const value = $(this).val();

        if (fieldId && value) {
            validateNumberConditions(fieldId, value);
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        // StudentTabManager.js kullanılıyorsa bu adım yönetimini skip et
        if (window.useOnlyStudentTabManager === true) {
            console.log(
                "Using only StudentTabManager for step management. scriptF step management is disabled.");
            return;
        }
        const stepItems = document.querySelectorAll(".step-item");
        const stepContent = document.querySelectorAll(".step-content");
        let currentStep = 1;

        const prevBtn = document.getElementById("prevButton");
        const nextBtn = document.getElementById("nextStep");
        const formBTNS = document.querySelectorAll(".formBTNS");
        const completeBtn = document.getElementById("completeButton");
        const scholarshipCompletionModalEl = document.getElementById('scholarshipCompletionModal');
        initializeRenewalCompletionAutoRedirect();
        const scholarshipCompletionModal = new bootstrap.Modal(scholarshipCompletionModalEl);
        completeBtn.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                scholarshipCompletionModal.show();
            } else {
                alert('Lütfen eksik alanları doldurunuz.');
            }
        });

        const modalCloseButton = document.getElementById("modalCloseButton");

        function showStep(step) {
            stepItems.forEach((item) => {
                item.classList.remove("active", "completed");
                const itemStep = parseInt(item.getAttribute("data-target"));
                if (itemStep < step) {
                    item.classList.add("completed");
                }
                if (itemStep === step) {
                    item.classList.add("active");

                    // 14. adıma geçildiğinde doldur fonksiyonunu çağır
                    if (itemStep === 14) {
                        console.log("14. adıma geçildi, doldur fonksiyonu çağrılıyor...");
                        doldur();
                    }
                }
            });

            stepContent.forEach((content) => {
                content.classList.remove("show", "active");
                if (parseInt(content.getAttribute("data-content")) === step) {
                    content.classList.add("show", "active");
                }
            });

            if (step === 1) {
                prevBtn.style.display = "none";
            } else {
                prevBtn.style.display = "inline-block";
            }

            if (step === stepItems.length) {
                nextBtn.style.display = "none";
                completeBtn.style.display = "inline-block";
            } else {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }



            updateStepView();
        }




        formBTNS.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                sendData(currentStep);
                if (currentStep < stepItems.length) {
                    currentStep++;
                    showStep(currentStep);
                }
            } else {
                showStep(currentStep);

            }
        });
        prevBtn.addEventListener("click", () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        stepItems.forEach((item) => {
            item.addEventListener("click", function() {
                const targetStep = parseInt(this.getAttribute("data-target"));
                if (validateStep(currentStep)) {
                    currentStep = targetStep;
                    console.log(currentStep + 'currentStep');
                    console.log(targetStep + 'targetStep');
                    showStep(currentStep);
                }
            });
        });



        modalCloseButton.addEventListener("click", () => {
            scholarshipCompletionModal.hide();
        });

        showStep(currentStep);
        // Tüm selectleri tarayalım
        document.querySelectorAll('select').forEach(function(selectElement) {
            // dataset kontrolü yap
            let datasetType = selectElement.getAttribute('data-dataset');

            if (datasetType) {
                if (datasetType === 'Univercities') {
                    fetchDataset('/get-univercities', selectElement);
                } else if (datasetType === 'Cities') {
                    fetchDataset('/get-citiesnew', selectElement);
                } else if (datasetType === 'Seçiniz') {

                }
                // Farklı datasetler için başka koşullar ekleyebilirsiniz
            }
        });
    });

    function fetchDataset(url, selectElement) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Gelen verileri select kutusuna ekle
                data.forEach(item => {
                    let option = document.createElement('option');
                    option.value = item.name; // Değer alanı
                    option.text = item.name; // Görünen text alanı
                    option.dataset.id = item.id; // data-id özelliğini ekleme
                    selectElement.add(option);
                });
            })
            .catch(error => console.error('Error fetching dataset:', error));
    }
</script>
<script>
    function getFormData(step) {
        const formData = {};
        document.querySelectorAll(
            `#step-${step} input, #step-${step} select, #step-${step} textarea, #step-${step} checkbox`).forEach(
            input => {
                formData[input.id] = input.value;
            });
        return formData;
    }

    function sendData(step) {
        const formData = getFormData(step);
        const formId = $('#form_id').val();
        formData.form_id = formId;
        $.ajax({
            type: "POST",
            url: `/save-step-data-renew`,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'),
                step: step,
                data: formData,
            },
            success: function(response) {
                console.log(response);
                // Tamamla sonrası yönlendirme modal gösterilince otomatik başlatılır.
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
    // kardes silme fonksiyonu
    function deleteSibling(button) {
        if (confirm('Bu kardeş kaydını silmek istediğinizden emin misiniz?')) {
            var id = $(button).data('id');

            $.ajax({
                type: "GET",
                url: `/form/ky-kardes-sil/${id}`,
                success: function(response) {
                    if (response.success) {
                        // Silinen satırı tablodan kaldır
                        $(button).closest('tr').remove();
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Kardeş kaydı silinirken bir hata oluştu');
                    console.error("Hata:", error);
                }
            });
        }
    }
    // kardes kaydetme fonksiyonu
    $(document).ready(function() {

        $('#addSiblingForm').on('submit', function(e) {
            e.preventDefault(); // Formun varsayılan submit işlemini engelle

            // Form verilerini al
            var formData = {
                tc_no: $('#tc_no').val(),
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
                url: `/form/ky-kardes-ekle`, // URL'yi uygun şekilde değiştirin
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
                            <button onclick="deleteSibling(this)" data-id="${response.id}" class="btn btn-sm btn-danger">Sil</button>
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
    // burs silme fonksiyonu
    // scriptF.blade.php içine ekleyin
    function deleteBurs(button) {
        if (confirm('Bu burs kaydını silmek istediğinizden emin misiniz?')) {
            var id = $(button).data('id');
            var silinecekTutar = parseInt($(button).data('count'));

            $.ajax({
                type: "GET",
                url: `/form/ky-burs-sil/${id}`,
                success: function(response) {
                    if (response.success) {
                        // Silinen satırı tablodan kaldır
                        $(button).closest('tr').remove();

                        // Toplam tutarı güncelle
                        var mevcutToplam = parseInt($('#scholar_count').text());
                        var yeniToplam = mevcutToplam - silinecekTutar;
                        $('#scholar_count').text(yeniToplam);

                        // Başarılı mesajını göster
                        toastr.success('Burs kaydı başarıyla silindi');

                        // 1 saniye sonra sayfayı yenile
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Burs kaydı silinirken bir hata oluştu');
                    console.error("Hata:", error);
                }
            });
        }
    }
    // burs kaydetme fonksiyonu
    $(document).ready(function() {
        function AllUnivercities() {
            $.ajax({
                url: '/get-univercities', // Laravel'de tanımlı URL
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var $selectElement = $('#grade_university');
                        $selectElement.empty();

                        if (response.data.length === 0) {

                            alert('Bu Şehirde Burs Verilen Üniversite Yok!');
                        }
                        // Varsayılan bir boş seçenek eklemek isterseniz:

                        $.each(response.data, function(index, city) {
                            $selectElement.append('<option data-id="' + city.id +
                                '" value="' + city.name + '" title="' + city.name +
                                '">' + city.name + '</option>');
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
        $('#addBursForm').on('submit', function(e) {
            e.preventDefault(); // Formun varsayılan submit işlemini engelle

            // Form verilerini al
            var formData = {
                tc_no: $('#tc_no').val(),
                company_name: $('#burskurumAdi').val(),
                company_type: $('#kurumTuru').val(),
                count: $('#bursMıktarı').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
            };

            $.ajax({
                type: "POST",
                url: `/form/ky-burs-ekle`, // URL'yi uygun şekilde değiştirin
                data: formData,
                success: function(response) {
                    // İsteğin başarılı olduğunu kullanıcıya bildirin

                    // Tabloya yeni satır ekle
                    var newRow = `
                    <tr>
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


    $('input[type="file"]').on('change', function() {
        var fileInput = $(this)[0];
        var file = fileInput.files[0];
        var fileId = $(this).data('id'); // Burada `data-id` ile dosyanın id'sini alıyoruz.
        let form_id = document.getElementById('form_id').value;

        var formData = new FormData();
        formData.append('file', file);
        formData.append('form_id', form_id);
        formData.append('id', $(this).attr('id'));
        formData.append('fileType', $(this).data('file-type'));
        formData.append('fileId', fileId); // Dosya id'sini FormData'ya ekliyoruz.
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload-renew',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                updateUploadedFileDiv(formData.get('id'));

                alert('Dosya başarıyla yüklendi!');
                // todo Dosya yukleme alani devre disi kalip dosya yuklendi resmi konacak
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    });

    function updateUploadedFileDiv(id) {
        var uploadedFileDiv = $('#uploadedFile' + id);
        if (id == 'doc_fotograf') {
            uploadedFileDiv.empty(); // Divin içini boşalt
            uploadedFileDiv.append(`
            <div class="file-uploaded-document d-flex justify-content-around"
                data-bs-toggle="modal" data-bs-target="#documentModal">
                <img height="24" width="24"    src="{{ url('/assets/images/jpg.svg') }}" alt="jpg">
                <div class="file-preview" id="deleteButton">
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
        } else {
            if (uploadedFileDiv.length) {
                uploadedFileDiv.empty(); // Divin içini boşalt
                uploadedFileDiv.append(`
                    <div class="file-uploaded-document d-flex justify-content-around"
                        data-bs-toggle="modal" data-bs-target="#documentModal">
                        <img src="{{ url('/assets/images/pdf.svg') }}" alt="pdf">
                        <div class="file-preview" id="deleteButton">
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
    }
    $('.delete-icon').click(function() {
        var fileId = $(this).data('id');
        var form_id = $('#form_id').val();

        $.ajax({
            url: "/delete/ky/" + form_id + "/" + fileId,
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                alert('Dosya başarıyla silindi.');
                location.reload();
                // DOM güncellemeleri burada yapılabilir
            },
            error: function(xhr, status, error) {
                console.error("Hata Detayları:", xhr.responseText);
                alert('Bir hata oluştu.');
            }
        });
    });


    document.getElementById("modalCloseButton").addEventListener("click", () => {
        const scholarshipCompletionModalEl = document.getElementById('scholarshipCompletionModal');
        const scholarshipCompletionModalInstance = bootstrap.Modal.getInstance(scholarshipCompletionModalEl);
        if (scholarshipCompletionModalInstance) {
            scholarshipCompletionModalInstance.hide();
        }
        // Manuel kapatma yedek akışı: otomatik yönlendirme başlamadıysa tamamla.
        completeRenewalApplication();
    });
</script>
<script>
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
</script>
<script>
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
                    $selectElement.append('<option value="">Üniversite Seçiniz</option>');

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

    function loadCities(selectElementId) {
        $.ajax({
            url: '/get-cities', // Laravel'de tanımlı URL
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var $selectElement = $('#' + selectElementId);

                    // Varsayılan bir boş seçenek eklemek isterseniz:

                    $.each(response.data, function(index, city) {
                        $selectElement.append('<option data-id="' + city.id + '" value="' + city
                            .name + '" title="' + city.name + '">' + city.name + '</option>');
                    });
                } else {
                    console.error('Veri alımında hata oluştu.');
                }
            },
            error: function() {
                console.error('Şehirler yüklenirken bir hata oluştu.');
            }
        });
    }

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

    $(document).ready(function() {
        loadCities('mother_city'); // Nufusa kayitli oldugu il
        loadCities('registered_city'); // Nufusa kayitli oldugu il
        loadCities('residing_city'); // Nufusa kayitli oldugu il
        loadCities('father_city'); // Nufusa kayitli oldugu il
        loadCities('h_school_city'); // Nufusa kayitli oldugu il
        loadCities('p_school_city'); // Nufusa kayitli oldugu il
        loadCities('born_city'); // Dogdugu sehir
    });
    document.getElementById('registered_city').addEventListener('change', function() {
        var districtSelectId = 'registered_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('residing_city').addEventListener('change', function() {
        var districtSelectId = 'residing_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('born_city').addEventListener('change', function() {
        var districtSelectId = 'born_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    var hschoolCityElement = document.getElementById('h_school_city');

    if (hschoolCityElement !== null) {
        loadCities('m_school_city'); // Nufusa kayitli oldugu il

        hschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'h_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var mschoolCityElement = document.getElementById('m_school_city');

    if (mschoolCityElement !== null) {
        loadCities('m_school_city'); // Nufusa kayitli oldugu il

        mschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'm_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var unicities = document.getElementById('university_city');

    if (unicities !== null) {
        loadCities('university_city'); // Nufusa kayitli oldugu il
    }
    var pschoolCityElement = document.getElementById('p_school_city');

    if (pschoolCityElement !== null) {
        loadCities('p_school_city'); // Nufusa kayitli oldugu il

        pschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'p_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    document.getElementById('residing_city').addEventListener('change', function() {
        var districtSelectId = 'residing_district'; // İlçelerin yükleneceği select elementinin ID'si
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
    document.getElementById('mother_city').addEventListener('change', function() {
        var districtSelectId = 'mother_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });


    function getylunis(a, districtSelectId) {
        var faculty = a.options[a.selectedIndex].value;
        var cityId = $('#university_city').val();


        // AJAX çağrısı
        $.ajax({
            url: '/get-univercities-yl/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Üniversite Seçiniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.universite_adi_yuk; // fakülte adı değeri
                    option.text = faculty.universite_adi_yuk; // fakülte adı metni
                    districtSelect.appendChild(option);
                });
            }
        });
    }

    function sehirburskontrol(sehir, citySelect) {
        var tip = $('#educationType').val(); // Eğitim tipi seçimini al

        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-sehir/` + sehir + '/' + tip,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            },
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    citySelect.selectedIndex = 0;
                } else {
                    if (tip == 'lisans' || tip == 'yukseklisans' || tip == 'doktora') {
                        loadUnivercities('current_university');
                    }
                }

            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function uniburskontrol(a, uniSelect) {
        var tip = document.getElementById('educationType').value; // Eğitim tipi seçimini al
        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-uni/` + a + '/' + tip,
            data: {},
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    uniSelect.selectedIndex = 0;
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function fakulteburskontrol(fak, fakSelect) {
        var tip = document.getElementById('educationType').value; // Eğitim tipi seçimini al
        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-fak/` + fak + '/' + tip,
            data: {},
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    fakSelect.selectedIndex = 0;
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

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
</script>
<script>
    function getCities(a, districtSelectId) {
        var faculty = a.options[a.selectedIndex].value;
        var cityId = $('#university_city').val();
        var thisSelected = a.getAttribute('data-selected');
        $('#faculty').empty();
        $('#departmant').empty();
        // AJAX çağrısı
        $.ajax({
            url: '/get-univercities/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Üniversite Seçiniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.uni_adi; // fakülte adı değeri
                    option.text = faculty.uni_adi; // fakülte adı metni
                    if (thisSelected == option.text) {
                        option.selected = true;
                    }
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


    var unicity = document.getElementById('university_city');

    if (unicity !== null) {
        loadCities('university_city'); // Nufusa kayitli oldugu il


    }
    document.addEventListener('DOMContentLoaded', function() {
        var current_university = document.getElementById('current_university');

        if (current_university !== null) {
            loadCities('university_city'); // Nufusa kayitli oldugu il

            current_university.addEventListener('change', function() {
                var a = current_university.value; // Seçilen şehri al
                var selectedOption = current_university.options[current_university
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.value; // Seçili option'ın data-id'sini al
                uniburskontrol(dataId, current_university); // Şehir burs kontrol fonksiyonunu çağır
                getFaculties(current_university, 'university_faculty');
            });
        }

    });

    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            fakulteburskontrol(dataId, faculty); // Şehir burs kontrol fonksiyonunu çağır
            getDepartmants(faculty, 'grade_departmant');

        });
    }
</script>
<script src="../../assets/js/student-applications.js"></script>


<script>
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
</script>

<script>
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
                    option.setAttribute('data-id', district
                    .id); // Fakülte id'sini data-id olarak ekle

                    districtSelect.appendChild(option);
                });
            }
        });
    }

    $(document).ready(function() {
        loadCities('registered_city'); // Nufusa kayitli oldugu il
        loadCities('mother_city'); // Nufusa kayitli oldugu il
        loadCities('residing_city'); // Nufusa kayitli oldugu il
        loadCities('father_city'); // Nufusa kayitli oldugu il
        loadCities('h_school_city'); // Nufusa kayitli oldugu il
        loadCities('p_school_city'); // Nufusa kayitli oldugu il
        loadCities('born_city'); // Dogdugu sehir
    });
    document.getElementById('registered_city').addEventListener('change', function() {
        var districtSelectId = 'registered_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('residing_city').addEventListener('change', function() {
        var districtSelectId = 'residing_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    document.getElementById('born_city').addEventListener('change', function() {
        var districtSelectId = 'born_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });
    var hschoolCityElement = document.getElementById('h_school_city');

    if (hschoolCityElement !== null) {
        loadCities('m_school_city'); // Nufusa kayitli oldugu il

        hschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'h_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var mschoolCityElement = document.getElementById('m_school_city');

    if (mschoolCityElement !== null) {
        loadCities('m_school_city'); // Nufusa kayitli oldugu il

        mschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'm_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    var unicities = document.getElementById('university_city');

    if (unicities !== null) {
        loadCities('university_city'); // Nufusa kayitli oldugu il
    }
    var pschoolCityElement = document.getElementById('p_school_city');

    if (pschoolCityElement !== null) {
        loadCities('p_school_city'); // Nufusa kayitli oldugu il

        pschoolCityElement.addEventListener('change', function() {
            var districtSelectId = 'p_school_district'; // İlçelerin yükleneceği select elementinin ID'si
            getDistricts(this, districtSelectId);
        });
    }
    document.getElementById('residing_city').addEventListener('change', function() {
        var districtSelectId = 'residing_district'; // İlçelerin yükleneceği select elementinin ID'si
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
    document.getElementById('mother_city').addEventListener('change', function() {
        var districtSelectId = 'mother_district'; // İlçelerin yükleneceği select elementinin ID'si
        getDistricts(this, districtSelectId);
    });


    function getylunis(a, districtSelectId) {
        var faculty = a.options[a.selectedIndex].value;
        var cityId = $('#university_city').val();


        // AJAX çağrısı
        $.ajax({
            url: '/get-univercities-yl/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Üniversite Seçiniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.universite_adi_yuk; // fakülte adı değeri
                    option.text = faculty.universite_adi_yuk; // fakülte adı metni
                    districtSelect.appendChild(option);
                });
            }
        });
    }

    function ilceburskontrol(ilce, ilceSelect) {
        var tip = $('#educationType').val(); // Eğitim tipi seçimini al

        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-ilce/` + ilce + '/' + tip,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            },
            success: function(response) {

                // Eğer response false dönerse uyarı göster
                if (response.success != true) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu ilce ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    ilceSelect.selectedIndex = 0;
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function uniburskontrol(a, uniSelect) {
        var tip = document.getElementById('educationType').value; // Eğitim tipi seçimini al
        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-uni/` + a + '/' + tip,
            data: {},
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response.success != true) {
                    alert('Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.');
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function fakulteburskontrol(fak, fakSelect) {
        var tip = document.getElementById('educationType').value; // Eğitim tipi seçimini al
        // AJAX isteği
        $.ajax({
            type: "GET",
            url: `/burs-kontrol-fak/` + fak + '/' + tip,
            data: {},
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    fakSelect.selectedIndex = 0;
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

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
</script>
<script>
    function getCities(a, districtSelectId) {
        var faculty = a.options[a.selectedIndex].value;
        var cityId = $('#university_city').val();
        $('#faculty').empty();
        $('#departmant').empty();
        // AJAX çağrısı
        $.ajax({
            url: '/get-univercities/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById(districtSelectId);
                districtSelect.innerHTML = ''; // Eski verileri temizle
                // Dönen ilçeleri select içerisine ekleme
                var option = document.createElement('option');
                option.text = 'Üniversite Seçiniz'; // fakülte adı metni
                districtSelect.appendChild(option);

                data.data.forEach(function(faculty) { // data.data olarak erişim sağlanmalı
                    var option = document.createElement('option');
                    option.value = faculty.uni_adi; // fakülte adı değeri
                    option.text = faculty.uni_adi; // fakülte adı metni
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


    var unicity = document.getElementById('university_city');

    if (unicity !== null) {
        loadCities('university_city'); // Nufusa kayitli oldugu il

        unicity.addEventListener('change', function() {
            var selectedOption = unicity.options[unicity.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            var check = sehirburskontrol(dataId, unicity); // Şehir burs kontrol fonksiyonunu çağır
            if (check) {
                loadUnivercities('current_university');
            }

        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        var current_university = document.getElementById('current_university');

        if (current_university !== null) {
            loadCities('university_city'); // Nufusa kayitli oldugu il

            current_university.addEventListener('change', function() {
                var a = current_university.value; // Seçilen şehri al
                var selectedOption = current_university.options[current_university
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.value; // Seçili option'ın data-id'sini al
                uniburskontrol(dataId, current_university); // Şehir burs kontrol fonksiyonunu çağır
                getFaculties(current_university, 'university_faculty');
            });
        }
        var p_school_city = document.getElementById('p_school_city');

        if (p_school_city !== null) {

            p_school_city.addEventListener('change', function() {
                var a = p_school_city.value; // Seçilen şehri al
                var selectedOption = p_school_city.options[p_school_city
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                sehirburskontrol(dataId, p_school_city); // Şehir burs kontrol fonksiyonunu çağır
            });
        }
        var p_school_district = document.getElementById('p_school_district');

        if (p_school_district !== null) {

            p_school_district.addEventListener('change', function() {
                var a = p_school_district.value; // Seçilen şehri al
                var selectedOption = p_school_district.options[p_school_district
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                ilceburskontrol(dataId, p_school_district); // Şehir burs kontrol fonksiyonunu çağır
            });
        }
        var m_school_city = document.getElementById('m_school_city');

        if (m_school_city !== null) {

            m_school_city.addEventListener('change', function() {
                var a = m_school_city.value; // Seçilen şehri al
                var selectedOption = m_school_city.options[m_school_city
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                sehirburskontrol(dataId, m_school_city); // Şehir burs kontrol fonksiyonunu çağır
            });
        }
        var m_school_district = document.getElementById('m_school_district');

        if (m_school_district !== null) {

            m_school_district.addEventListener('change', function() {
                var a = m_school_district.value; // Seçilen şehri al
                var selectedOption = m_school_district.options[m_school_district
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                ilceburskontrol(dataId, m_school_district); // Şehir burs kontrol fonksiyonunu çağır
            });
        }
        var h_school_district = document.getElementById('h_school_district');

        if (h_school_district !== null) {

            h_school_district.addEventListener('change', function() {
                var a = h_school_district.value; // Seçilen şehri al
                var selectedOption = h_school_district.options[h_school_district
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                ilceburskontrol(dataId, h_school_district); // Şehir burs kontrol fonksiyonunu çağır
            });
        }
        var h_school_city = document.getElementById('h_school_city');

        if (h_school_city !== null) {

            h_school_city.addEventListener('change', function() {
                var a = h_school_city.value; // Seçilen şehri al
                var selectedOption = h_school_city.options[h_school_city
                .selectedIndex]; // Seçili option
                var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
                sehirburskontrol(dataId, h_school_city); // Şehir burs kontrol fonksiyonunu çağır
            });
        }

    });

    var faculty = document.getElementById('university_faculty');

    if (faculty !== null) {
        faculty.addEventListener('change', function() {
            var selectedOption = faculty.options[faculty.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            fakulteburskontrol(dataId, faculty); // Şehir burs kontrol fonksiyonunu çağır
            getDepartmants(faculty, 'grade_departmant');

        });



    }
</script>
