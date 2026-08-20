<script>
    let scholarshipCompletionRedirectStarted = false;
    let scholarshipCompletionModalListenerInitialized = false;

    function completeScholarshipApplication(delay = 0) {
        if (scholarshipCompletionRedirectStarted) {
            return;
        }

        scholarshipCompletionRedirectStarted = true;
        setTimeout(function() {
            window.location.href = '/student/Basvuru-Tamamla';
        }, delay);
    }

    function initializeScholarshipCompletionAutoRedirect() {
        if (scholarshipCompletionModalListenerInitialized) {
            return;
        }

        const scholarshipCompletionModalEl = document.getElementById('scholarshipCompletionModal');
        if (!scholarshipCompletionModalEl) {
            return;
        }

        scholarshipCompletionModalListenerInitialized = true;
        scholarshipCompletionModalEl.addEventListener('shown.bs.modal', function() {
            completeScholarshipApplication(300);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeScholarshipCompletionAutoRedirect);
    } else {
        initializeScholarshipCompletionAutoRedirect();
    }

    $('.formBTNS').on('click', function(e) {
        // Önce validasyon yap
        const currentStep = StudentTabManager.currentStep;
        const currentStepContent = document.querySelector(`.step-content[data-content="${currentStep}"]`);

        if (!currentStepContent) {
            return;
        }

        let isValid = true;
        let missingFiles = [];
        let uncheckedBoxes = [];
        let missingFields = [];

        // Checkbox kontrolü
        const checkboxFields = currentStepContent.querySelectorAll("[type='checkbox']");
        checkboxFields.forEach((field) => {
            if (!field.checked) {
                field.classList.add("is-invalid");
                isValid = false;
                // Checkbox'ın label metnini al
                let label = field.closest('.form-check').querySelector('.form-check-label');
                if (label) {
                    let labelText = label.textContent.replace(/\([^)]*\)/g, '')
                        .trim(); // Parantez içindeki metni kaldır
                    uncheckedBoxes.push(labelText);
                }
            } else {
                field.classList.remove("is-invalid");
            }
        });

        // Diğer required alanların kontrolü
        const requiredFields = currentStepContent.querySelectorAll("[required]");
        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("is-invalid");
                isValid = false;

                if (field.type === 'file') {
                    let fieldLabel = '';
                    const fieldId = field.id;

                    let parentElement = field.closest('.upload-card');
                    if (parentElement) {
                        let titleElement = parentElement.querySelector('.documents-title-drag-drop p');
                        if (titleElement) {
                            let titleText = titleElement.textContent.trim();
                            fieldLabel = titleText.replace(/\s+/g, ' ').replace(/\*/g, '').trim();
                        }
                    }

                    if (!fieldLabel) {
                        fieldLabel = fieldId.replace('doc_', '').replace(/_/g, ' ');
                        fieldLabel = fieldLabel.charAt(0).toUpperCase() + fieldLabel.slice(1);
                    }

                    missingFiles.push(fieldLabel);
                } else {
                    let fieldLabel = '';
                    const fieldId = field.id;

                    // Label discovery logic
                    if (fieldId) {
                        let labelElement = document.querySelector(`label[for="${fieldId}"]`);
                        if (labelElement) {
                            fieldLabel = labelElement.textContent.replace(/\*/g, '').trim();
                        }
                    }

                    if (!fieldLabel) {
                        let parent = field.closest('.form-group, .mb-3, .col-md-6, .col-12');
                        if (parent) {
                            let label = parent.querySelector('label');
                            if (label) {
                                fieldLabel = label.textContent.replace(/\*/g, '').trim();
                            }
                        }
                    }

                    if (!fieldLabel && field.placeholder) {
                        fieldLabel = field.placeholder;
                    }

                    if (!fieldLabel) {
                        fieldLabel = fieldId || field.name || 'Gerekli alan';
                    }

                    missingFields.push(fieldLabel);
                }
            } else {
                field.classList.remove("is-invalid");
            }
        });

        if (missingFiles.length > 0 || uncheckedBoxes.length > 0 || missingFields.length > 0) {
            let message = '';
            let htmlContent = '<div class="text-left">';

            if (missingFields.length > 0) {
                let missingFieldsList = missingFields.map(field => `<li>${field}</li>`).join('');
                htmlContent += `
                    <p>Aşağıdaki alanları doldurmanız gerekmektedir:</p>
                    <ul>${missingFieldsList}</ul>
                `;
            }

            if (missingFiles.length > 0) {
                let missingFilesList = missingFiles.map(file => `<li>${file}</li>`).join('');
                htmlContent += `
                    ${missingFields.length > 0 ? '<hr>' : ''}
                    <p>Aşağıdaki belgeleri yüklemeniz gerekmektedir:</p>
                    <ul>${missingFilesList}</ul>
                `;
            }

            if (uncheckedBoxes.length > 0) {
                let uncheckedList = uncheckedBoxes.map(text => `<li>${text}</li>`).join('');
                htmlContent += `
                    ${(missingFiles.length > 0 || missingFields.length > 0) ? '<hr>' : ''}
                    <p>Aşağıdaki onay kutularını işaretlemeniz gerekmektedir:</p>
                    <ul>${uncheckedList}</ul>
                `;
            }

            htmlContent += '</div>';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Eksik Bilgiler',
                    html: htmlContent,
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            } else {
                if (missingFields.length > 0) {
                    message += 'Lütfen şu alanları doldurun: ' + missingFields.join(', ') + '\n';
                }
                if (missingFiles.length > 0) {
                    message += 'Lütfen tüm gerekli belgeleri yükleyin: ' + missingFiles.join(', ') + '\n';
                }
                if (uncheckedBoxes.length > 0) {
                    message += 'Lütfen tüm onay kutularını işaretleyin: ' + uncheckedBoxes.join(', ');
                }
                alert(message);
            }

            e.preventDefault();
            return false;
        }

        if (!isValid) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Eksik ve Hatalı Alanlar',
                    html: 'Eksik ve Hatalı Alanları Kontrol Ediniz.sss',
                    icon: 'warning',
                    confirmButtonText: 'Tamam'
                });
            } else {
                alert('Lütfen tüm gerekli alanları doldurun!');
            }
            e.preventDefault();
            return false;
        }
    });
</script>
<script>
    // Modal icerigi doldurma
    function doldur() {

        // Form değerlerini al
        var ogrenciAdi = document.getElementById('name') ? document.getElementById('name').value + ' ' + document
            .getElementById('surname').value : '';
        var ogrenciNo = document.getElementById('student_number') ? document.getElementById('student_number').value :
            '';
        var ogrenciUniversite = document.getElementById('current_university') ? document.getElementById(
            'current_university').value : '';
        var ogrenciBolum = document.getElementById('grade_departmant') ? document.getElementById('grade_departmant')
            .value : '';

        // Tüm modalleri seç
        var modals = document.querySelectorAll('.modal');

        // Değiştirilecek değerleri bir diziye ekle
        var degistirilecekler = {
            '__universite': ogrenciUniversite,
            '__bolum': ogrenciBolum,
            '__isim': ogrenciAdi,
            '__ogrenci_no': ogrenciNo
        };

        // Her bir modal için değişim yap
        modals.forEach(function(modal) {
            var modalIcerik = modal.innerHTML;

            // Her bir değiştirilecek kelime için modal içeriğini güncelle
            for (var anahtar in degistirilecekler) {
                if (modalIcerik.includes(anahtar)) {
                    modal.innerHTML = modal.innerHTML.replaceAll(anahtar, degistirilecekler[anahtar]);
                }
            }
        });

    }
</script>
<script>
    function validateEmail(email) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }

    function validatePhone(phone) {
        // Önce tüm boşlukları kaldır
        phone = phone.replace(/\s+/g, '');

        // +90 ile başlıyorsa kaldır
        if (phone.startsWith('+90')) {
            phone = phone.substring(3);
        }
        // 0 ile başlıyorsa kaldır
        if (phone.startsWith('0')) {
            phone = phone.substring(1);
        }

        // Geriye kalan numara 10 haneli ve sadece rakamlardan oluşmalı
        var phoneRegex = /^[5][0-9]{9}$/;
        return phoneRegex.test(phone);
    }

    function validateHomePhone(phone) {
        var phoneRegex = /^[0-9]{11}$/;
        return phoneRegex.test(phone);
    }
    document.addEventListener('DOMContentLoaded', function() {

        var numberInputs = document.querySelectorAll('input[type="number"]');

        // Tüm number inputlar için pozitif değer kontrolü
        numberInputs.forEach(function(input) {
            // Minimum değeri 0 olarak ayarla
            input.setAttribute('min', '0');

            // Negatif değer girilmesini engelle
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });

            // Eksi işareti yazılmasını engelle
            input.addEventListener('keypress', function(e) {
                if (e.key === '-') {
                    e.preventDefault();
                }
            });
        });

        const universityTransferSelect = document.getElementById('university_transfer');
        const universityTransferDesc = document.getElementById('university_transfer_desc');
        const asterisk = universityTransferDesc?.closest('.col-md-6')?.querySelector(
            'span[style="color: red"]');

        if (universityTransferSelect && universityTransferDesc && asterisk) {
            universityTransferSelect.addEventListener('change', function() {
                if (this.value === 'Hayır') {
                    universityTransferDesc.removeAttribute('required');
                    universityTransferDesc.value = '';
                    universityTransferDesc.disabled = true;
                    asterisk.style.display = 'none';
                } else if (this.value === 'Evet') {
                    universityTransferDesc.setAttribute('required', '');
                    universityTransferDesc.disabled = false;
                    asterisk.style.display = 'inline';
                } else {
                    universityTransferDesc.removeAttribute('required');
                    universityTransferDesc.disabled = false;
                    asterisk.style.display = 'none';
                }
            });

            // Sayfa yüklendiğinde mevcut durumu kontrol et
            if (universityTransferSelect.value === 'Hayır') {
                universityTransferDesc.removeAttribute('required');
                universityTransferDesc.value = '';
                universityTransferDesc.disabled = true;
                asterisk.style.display = 'none';
            }
        }
    });
    let isValid = true;
    let missingFiles = [];

    function validateStep(step) {
        const currentStepContent = document.querySelector(`.step-content[data-content="${step}"]`);
        const requiredFields = currentStepContent.querySelectorAll("[required]");
        let isValid = true;
        const emailField = currentStepContent.querySelectorAll("[type='email']");
        emailField.forEach((field) => {
            if (!validateEmail(field.value)) {
                field.classList.add("is-invalid");
                isValid = false;
                alert('Lütfen geçerli bir e-posta adresi giriniz.');
            }
        });
        const phoneField = currentStepContent.querySelectorAll("[type='tel']");
        phoneField.forEach((field) => {
            if (!validatePhone(field.value)) {
                field.classList.add("is-invalid");
                isValid = false;
                alert('Lütfen geçerli bir telefon numarası giriniz1.');
            }
        });
        const homephoneField = currentStepContent.querySelectorAll(
            "input[type='number'][class*='homephone']");
        homephoneField.forEach((field) => {
            if (!validateHomePhone(field.value)) {
                field.classList.add("is-invalid");
                isValid = false;
                alert('Lütfen geçerli bir ev telefonu numarası giriniz.');
            }
        });
        const checkboxField = currentStepContent.querySelectorAll("[type='checkbox']");
        checkboxField.forEach((field) => {
            if (!field.checked) {
                field.classList.add("is-invalid");
                isValid = false;
            }
        });
        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("is-invalid");
                isValid = false;

                // Eğer bu alan bir dosya alanıysa, eksik dosyaların listesine ekle
                if (field.type === 'file') {
                    // Dosya alanının başlığını bulmak için
                    let fieldLabel = '';

                    // Dosya ID'sini al
                    const fieldId = field.id;

                    // Belge başlığını bulmak için DOM'da gezin
                    // Önce input'un parent elementlerini bul ve documents-title-drag-drop içindeki p etiketini ara
                    let parentElement = field.closest('.upload-card');
                    if (parentElement) {
                        let titleElement = parentElement.querySelector(
                            '.documents-title-drag-drop p');
                        if (titleElement) {
                            // SVG ve diğer HTML elementlerini kaldır, sadece metni al
                            let titleText = titleElement.textContent.trim();
                            // Başlıktaki gereksiz boşlukları ve * işaretini temizle
                            fieldLabel = titleText.replace(/\s+/g, ' ').replace(/\*/g, '').trim();
                        }
                    }

                    // Eğer başlık bulunamadıysa, input id'sinden oluştur
                    if (!fieldLabel) {
                        fieldLabel = fieldId.replace('doc_', '').replace(/_/g, ' ');
                        fieldLabel = fieldLabel.charAt(0).toUpperCase() + fieldLabel.slice(1);
                    }

                    missingFiles.push(fieldLabel);
                }
            } else {
                field.classList.remove("is-invalid");
            }
        });
        if (missingFiles.length > 0) {
            let missingFilesList = missingFiles.map(file => `<li>${file}</li>`).join('');

            Swal.fire({
                title: 'Eksik Belgeler',
                html: `
            <div class="text-left">
                <p>Aşağıdaki belgeleri yüklemeniz gerekmektedir:</p>
                <ul>${missingFilesList}</ul>
            </div>
        `,
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });

            return false; // Formu göndermeyi engelle
        }
        return isValid;
    }
    document.addEventListener("DOMContentLoaded", function() {
        // StudentTabManager.js kullanılıyorsa bu adım yönetimini skip et
        if (window.useOnlyStudentTabManager === true) {
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
        initializeScholarshipCompletionAutoRedirect();
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
                    showStep(currentStep);
                }
            });
        });



        modalCloseButton.addEventListener("click", () => {
            scholarshipCompletionModal.hide();
        });

        showStep(currentStep);

        const employmentStatusSelect = document.getElementById('employment-status');
        const employmentDetails = document.getElementById('employment-details');

        employmentStatusSelect.addEventListener('change', function() {
            if (employmentStatusSelect.value === 'full-time' || employmentStatusSelect.value ===
                'part-time' || employmentStatusSelect.value === 'intern') {
                employmentDetails.classList.remove('d-none');
            } else {
                employmentDetails.classList.add('d-none');
            }
        });

        function updateStepView() {
            stepItems.forEach((step, index) => {
                if (index === currentStep - 1) {
                    step.scrollIntoView({
                        behavior: 'smooth',
                        inline: 'center'
                    });
                }
            });
        }

        updateStepView();
    });
</script>

<script>
    function deleteSibling(a) {
        var id = a.getAttribute('data-id');
        $.ajax({
            type: "GET",
            url: `/panel/Aday-Kardes-Sil/` + id,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

    function deletescholarship(a) {
        var id = a.getAttribute('data-id');
        $.ajax({
            type: "GET",
            url: `/panel/Aday-Burs-Sil/` + id,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }

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
            .catch(error => console.error('Error fetching dataset:', error, url, selectElement));
    }
    document.addEventListener("DOMContentLoaded", function() {
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
</script>

<script>
    let totalPoints = 0;

    function getFormData(step) {
        const formData = {};

        document.querySelectorAll(
            `#step-${step} input, #step-${step} select, #step-${step} textarea, #step-${step} checkbox`).forEach(
            input => {
                if (input.type === 'checkbox') {
                    formData[input.id] = input.checked ? 'on' : 'off';
                } else {
                    formData[input.id] = input.value;
                }
            });


        return formData;
    }

    function calculateAGNOScore(agnoValue) {
        if (isNaN(agnoValue) || agnoValue <= 0) {
            return 0;
        }

        let agnoScore = 0;

        if (agnoValue < 5.00) {
            agnoScore = (agnoValue / 5.00) * 25;
        } else {
            agnoScore = (agnoValue / 100) * 20;
        }

        return Math.round(agnoScore * 100) / 100;
    }

    function sendData(step) {
        const formData = getFormData(step);

        // Puanı hesapla
        let totalScore = 0;


        // Numara tipindeki alanları kontrol et
        document.querySelectorAll('.number-input').forEach(function(input) {
            if (input.value) {
                let puan = 0;

                if (input.id === 'agno') {
                    puan = calculateAGNOScore(parseFloat(input.value));
                } else if (input.id === 'grade_avg') {
                    const grade_avg = document.getElementById('grade_avg');
                    if (grade_avg && grade_avg.value) {
                        var grade_avgValue = parseFloat(grade_avg.value);
                        grade_avgValue = Math.round(grade_avgValue * 20) / 100;
                        puan = grade_avgValue;
                    }
                } else if (input.id === 'housing_fee') {
                    if (document.getElementById('housing_type') && (document.getElementById('housing_type')
                            .value == 'Aile Yanı' || document.getElementById('housing_type').value ==
                            'Arkadaş Yanı' || document.getElementById('housing_type').value == 'Ev')) {
                        puan = 0;
                    } else {
                        const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');
                        const value = parseFloat(input.value);

                        for (const [key, range] of Object.entries(scoringRanges)) {
                            if ((!range.min || value >= range.min) && (!range.max || value < range.max)) {
                                puan = parseInt(range.points || 0);
                                break;
                            }
                        }
                    }
                } else {
                    const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');
                    const value = parseFloat(input.value);

                    if (Object.keys(scoringRanges).length > 0) {
                        for (const [key, range] of Object.entries(scoringRanges)) {
                            if ((!range.min || value >= range.min) && (!range.max || value < range.max)) {
                                puan = parseInt(range.points || 0);
                                break;
                            }
                        }
                    }
                }

                totalScore += puan;
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

        $.ajax({
            type: "POST",
            url: `/save-step-data`,
            data: {
                type: 'primary-new',
                _token: $('meta[name="csrf-token"]').attr('content'),
                step: step,
                data: formData,
                total_score: totalScore // Toplam puanı da gönder
            },
            success: function(response) {
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
                    if (response.success === false) {
                        alert('Bu kurum adını daha önce kaydettiniz');
                    } else {
                        // Tabloya yeni satır ekle
                        var newRow = `
                    <tr>
                        <td>${response.company_type}</td>
                        <td>${response.company_name}</td>
                        <td>${response.count}</td>
                        <td>
                            <button onclick="deletescholarship(this)" data-id="${response.id}" class="btn btn-sm btn-danger">Sil</button>
                        </td>
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
                    }

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);
                }
            });
        });
    });
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    function updateUploadedFileDiv(id, type) {
        if (type === 'png') {
            type = 'jpg';
        }
        var uploadedFileDiv = $('#uploadedFile' + id);
        $('input[type="file"]').each(function() {
            // `data-name` ve `id` değerlerini kontrol et
            if ($(this).attr('data-name') === id) {
                $(this).val(''); // Dosya inputunun içeriğini temizle
            }
        });
        uploadedFileDiv.empty(); // Divin içini boşalt
        uploadedFileDiv.append(`
            <div class="file-uploaded-document d-flex justify-content-around"
                data-bs-toggle="modal" data-bs-target="#documentModal">
                <img height='24' width='24' src="{{ url('') }}/assets/images/${type}.svg" alt="pdf">
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
    $('input[type="file"]').on('change', function() {

        var fileInput = $(this)[0];
        var file = fileInput.files[0];

        if (!file) return;
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();

        // (5 MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            alert('Dosya boyutu 5MB\'tan büyük olamaz.');
            $(this).val('');
            return;
        }

        var fileId = $(this).data('id');
        var formData = new FormData();
        formData.append('file', file);
        formData.append('id', $(this).attr('id'));
        formData.append('fileType', $(this).data('file-type'));
        formData.append('fileId', fileId); // Dosya id'sini FormData'ya ekliyoruz.
        formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // CSRF token


        // Dosyayı sunucuya gönderme
        $.ajax({
            url: '/upload', // Sunucuya dosya göndermek için URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Dosya başarıyla yüklendi!');

                updateUploadedFileDiv(formData.get('id'), fileExtension);

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
            type: 'get',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                alert('Dosya başarıyla silindi.');
                location.reload();

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
                                            <input data-name="${fileId}" data-id="${fileId}"  type="file" id="${fileId}" hidden>
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
                                        </div>
    `;

        // Update the HTML content inside the target element
        document.getElementById(`uploadedFile${fileId}`).innerHTML = newHtml;
    }



    document.getElementById("modalCloseButton").addEventListener("click", () => {
        const scholarshipCompletionModalEl = document.getElementById('scholarshipCompletionModal');
        const scholarshipCompletionModalInstance = bootstrap.Modal.getInstance(scholarshipCompletionModalEl);
        if (scholarshipCompletionModalInstance) {
            scholarshipCompletionModalInstance.hide();
        }
        // Manuel kapatma yedek akışı: otomatik yönlendirme başlamadıysa tamamla.
        completeScholarshipApplication();
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

    function loadCities(selectElementId, retryCount = 0) {
        var thisSelected = $('#' + selectElementId).attr('data-selected');
        $.ajax({
            url: '/get-cities', // Laravel'de tanımlı URL
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var $selectElement = $('#' + selectElementId);

                    // Varsayılan bir boş seçenek eklemek isterseniz:

                    $.each(response.data, function(index, city) {
                        var isSelected = (thisSelected && thisSelected === city.name) ? 'selected' :
                            '';
                        $selectElement.append('<option data-id="' + city.id + '" value="' + city
                            .name + '" title="' + city.name + '" ' + isSelected + '>' + city
                            .name + '</option>');
                    });
                } else {
                    console.error('Veri alımında hata oluştu.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 500 && retryCount < 3) {
                    setTimeout(function() {
                        loadCities(selectElementId, retryCount + 1);
                    }, 1000);
                } else {
                    console.error(
                        'Şehirler yüklenirken bir hata oluştu. Maksimum deneme sayısına ulaşıldı veya farklı bir hata oluştu.'
                    );
                }
            }
        });
    }

    function loadCitiesByEducationType(selectElementId, retryCount = 0, educType) {
        var thisSelected = $('#' + selectElementId).attr('data-selected');
        $.ajax({
            url: '/get-cities-by-education-type/' + educType, // Laravel'de tanımlı URL
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var $selectElement = $('#' + selectElementId);

                    // Varsayılan bir boş seçenek eklemek isterseniz:

                    $.each(response.data, function(index, city) {
                        var isSelected = (thisSelected && thisSelected === city.name) ? 'selected' :
                            '';
                        $selectElement.append('<option data-id="' + city.id + '" value="' + city
                            .name + '" title="' + city.name + '" ' + isSelected + '>' + city
                            .name + '</option>');
                    });
                } else {
                    console.error('Veri alımında hata oluştu.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 500 && retryCount < 3) {
                    setTimeout(function() {
                        loadCities(selectElementId, retryCount + 1);
                    }, 1000);
                } else {
                    console.error(
                        'Şehirler yüklenirken bir hata oluştu. Maksimum deneme sayısına ulaşıldı veya farklı bir hata oluştu.'
                    );
                }
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
                if (response.success != true) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    citySelect.selectedIndex = 0;
                }
            },
            error: function(xhr, status, error) {
                // Hata durumunda çalışacak kısım
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
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
                        text: 'Bu ilce ve eğitim tipi için burs mevcut değil.'
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
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu şehir ve eğitim tipi için burs başvurusu yapılamamaktadır.'
                    });
                    a.selectedIndex = 0;
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
                        text: 'Bu fakülte ve eğitim tipi için burs mevcut değil.'
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

    function bolumburskontrol(bolum, bolumSelect) {
        var tip = document.getElementById('educationType').value; // Eğitim tipi seçimini al
        // AJAX isteği
        $.ajax({
            type: "GET",
            url: /burs-kontrol-bolum/ + bolum + '/' + tip,
            data: {},
            success: function(response) {
                // Eğer response false dönerse uyarı göster
                if (response == 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Bu fakülte ve eğitim tipi için burs mevcut değil.'
                    });
                    bolumSelect.selectedIndex = 0;
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
        var faculty = a.options[a.selectedIndex].getAttribute('data-id');
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
                option.text = 'Seçiniz'; // fakülte adı metni
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
        var tip = $('#educationType').val(); // Eğitim tipi seçimini al

        loadCitiesByEducationType('university_city', 3, tip); // Nufusa kayitli oldugu il

        unicity.addEventListener('change', function() {
            loadUnivercities('current_university');
            var selectedOption = unicity.options[unicity.selectedIndex]; // Seçili option
            var dataId = selectedOption.getAttribute('data-id'); // Seçili option'ın data-id'sini al
            sehirburskontrol(dataId, unicity); // Şehir burs kontrol fonksiyonunu çağır

        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        var current_university = document.getElementById('current_university');

        if (current_university !== null) {

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
    var bolum = document.getElementById('grade_departmant');
    if (bolum !== null) {
        bolum.addEventListener('change', function() {
            var selectedOption = bolum.options[bolum.selectedIndex]; // Seçili option
            var dataId = selectedOption.value; // Seçili option'ın data-id'sini al
            bolumburskontrol(dataId, bolum); // Şehir burs kontrol fonksiyonunu çağır
        });
    }
    $('#addButtonkardes').click(function() {
        const modal = new bootstrap.Modal(document.getElementById('kardesEkleModal'));
        modal.show();
    });
    $('#addButtonburs').click(function() {
        const modal = new bootstrap.Modal(document.getElementById('bursEkleModal'));
        modal.show();
    });
</script>

<script src="../../assets/js/student-applications.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Adım değişikliğini izleyen bir MutationObserver oluşturacağız

        // Hedef elementi seçiyoruz (data-target="14" olan adım)
        const targetStepItem = document.querySelector('.step-item[data-target="14"]');

        if (targetStepItem) {
            // MutationObserver oluştur
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        // Eğer active sınıfı eklendiyse doldur fonksiyonunu çağır
                        if (targetStepItem.classList.contains('active')) {
                            doldur();
                        }
                    }
                });
            });

            // Observer'ı başlat ve class değişikliklerini izle
            observer.observe(targetStepItem, {
                attributes: true,
                attributeFilter: ['class']
            });
        }
    });
</script>
