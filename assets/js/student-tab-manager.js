class StudentTabManager {
    /**
     * @param {string} stepContainerId - ID of the container with the step items
     * @param {string} pageId - ID to use for storing the active step in localStorage
     * @param {boolean} saveToHistory - Whether to save the active step to browser history
     */
    static init(stepContainerId, pageId, saveToHistory = false) {
        this.stepContainerId = stepContainerId;
        this.pageId = pageId;
        this.saveToHistory = saveToHistory;
        this.storageKey = `active_step_${this.pageId}`;
        const savedStep = localStorage.getItem(this.storageKey);
        this.currentStep = savedStep ? parseInt(savedStep) : 1;

        this.initialized = false;

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => this.initialize(), 100);
            });
        } else {
            setTimeout(() => this.initialize(), 100);
        }

        if (this.saveToHistory) {
            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.stepId) {
                    this.activateStep(event.state.stepId, false);
                }
            });
        }

        // Clear other possible competing storage keys to avoid conflicts
        this.cleanupOtherStorageKeys();
    }

    static cleanupOtherStorageKeys() {
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key.startsWith('active_step_') && key !== this.storageKey) {
                localStorage.removeItem(key);
            }
        }
    }

    static initialize() {
        if (this.initialized) return;

        this.setupStepListeners();
        this.setupNavigationButtons();
        this.restoreActiveStep();

        this.initialized = true;
    }

    static setupStepListeners() {
        const stepContainer = document.querySelector('.step-container');
        if (!stepContainer) {
            return;
        }

        const stepItems = stepContainer.querySelectorAll('.step-item');

        stepItems.forEach(stepItem => {
            stepItem.addEventListener('click', (event) => {
                const stepId = stepItem.getAttribute('data-target');
                if (this.validateCurrentStep(this.currentStep)) {
                    this.activateStep(stepId);
                }

            });
        });
    }

    static setupNavigationButtons() {
        const nextButton = document.getElementById('nextStep');
        const prevButton = document.getElementById('prevButton');
        const completeButton = document.getElementById('completeButton');

        if (nextButton) {
            nextButton.addEventListener('click', (event) => {
                if (event.defaultPrevented) return;
                this.goToNextStep();
            });
        }

        if (prevButton) {
            prevButton.addEventListener('click', (event) => {
                if (event.defaultPrevented) return;
                this.goToPreviousStep();
            });
        }

        if (completeButton) {
            completeButton.addEventListener('click', () => {
                if (this.validateCurrentStep(this.currentStep)) {
                    this.completeForm();
                }
            });
        }
    }

    static validateCurrentStep(step) {
        const currentStepContent = document.querySelector(`.step-content[data-content="${step}"]`);
        if (!currentStepContent) {
            return true;
        }

        const requiredFields = Array.from(currentStepContent.querySelectorAll("[required]")).filter(field => {
            // Elementin veya herhangi bir üst kapsayıcısının gizli olup olmadığını kontrol et
            const style = window.getComputedStyle(field);
            if (style.display === 'none' || style.visibility === 'hidden') {
                // Eğer kendisi gizliyse (dosya inputları gibi), kapsayıcısını kontrol et
                if (field.type === 'file') {
                    const parent = field.closest('.upload-card');
                    return parent && window.getComputedStyle(parent).display !== 'none';
                }
                return false;
            }
            return field.offsetWidth > 0 || field.offsetHeight > 0;
        });

        let isValid = true;
        let missingFiles = [];
        let uncheckedBoxes = [];
        let missingFields = [];

        // Checkbox kontrolü
        const checkboxFields = currentStepContent.querySelectorAll("[type='checkbox'][required]");
        checkboxFields.forEach((field) => {
            if (!field.checked) {
                field.classList.add("is-invalid");
                isValid = false;
                let label = field.closest('.form-check').querySelector('.form-check-label');
                if (label) {
                    let labelText = label.textContent.replace(/\([^)]*\)/g, '').trim();
                    uncheckedBoxes.push(labelText);
                }
            } else {
                field.classList.remove("is-invalid");
            }
        });

        // Diğer zorunlu alanlar
        requiredFields.forEach((field) => {
            let isFieldMissing = false;

            if (field.type === 'file') {
                // Dosya inputu için hem değerini hem de varsa yüklenmiş dosya görünümünü kontrol et
                const hasFileSelected = field.files && field.files.length > 0;
                const hasValue = field.value && field.value.trim() !== "";

                // Blade tarafında yüklenmiş dosyalar için gösterilen kapsayıcıyı kontrol et
                const uploadedView = currentStepContent.querySelector(`#uploadedFile${field.id} .file-uploaded-document`);
                const isAlreadyUploaded = uploadedView !== null;

                if (!hasFileSelected && !hasValue && !isAlreadyUploaded) {
                    isFieldMissing = true;
                }
            } else {
                if (!field.value || !field.value.trim()) {
                    isFieldMissing = true;
                }
            }

            if (isFieldMissing) {
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
                    if (fieldId) {
                        let labelElement = document.querySelector(`label[for="${fieldId}"]`);
                        if (labelElement) fieldLabel = labelElement.textContent.replace(/\*/g, '').trim();
                    }
                    if (!fieldLabel) {
                        let parent = field.closest('.form-group, .mb-3, .col-md-6, .col-12');
                        if (parent) {
                            let label = parent.querySelector('label');
                            if (label) fieldLabel = label.textContent.replace(/\*/g, '').trim();
                        }
                    }
                    if (!fieldLabel && field.placeholder) fieldLabel = field.placeholder;
                    if (!fieldLabel) fieldLabel = fieldId || field.name || 'Gerekli alan';

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
                    title: 'Eksik ve Hatalı Alanlar',
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
            return false;
        }

        if (!isValid) {
            Swal.fire({
                title: 'Eksik ve Hatalı Alanlar',
                html: 'Eksik ve Hatalı Alanları Kontrol Ediniz',
                icon: 'warning',
                confirmButtonText: 'Tamam'
            });
            return false; // Geçersiz alanlar varsa false döndür
        }

        return true; // Tüm kontroller geçildi, true döndür
    }

    static validateEmail(email) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }

    static validatePhone(phone) {
        phone = phone.replace(/\s+/g, '');

        if (phone.startsWith('+90')) {
            phone = phone.substring(3);
        }
        if (phone.startsWith('0')) {
            phone = phone.substring(1);
        }

        var phoneRegex = /^[5][0-9]{9}$/;
        return phoneRegex.test(phone);
    }

    static validateHomePhone(phone) {
        var phoneRegex = /^[0-9]{11}$/;
        return phoneRegex.test(phone);
    }

    static goToNextStep() {
        const totalSteps = document.querySelectorAll('.step-content').length;
        const nextStep = parseInt(this.currentStep) + 1;

        if (this.validateCurrentStep(this.currentStep)) {
            if (nextStep <= totalSteps) {
                this.activateStep(nextStep.toString());
            }
        }
    }

    static goToPreviousStep() {
        const prevStep = parseInt(this.currentStep) - 1;

        if (prevStep >= 1) {
            this.activateStep(prevStep.toString());
        }
    }

    static completeForm() {
        window.sendData(this.currentStep);
        const scholarshipCompletionModal = new bootstrap.Modal(document.getElementById('scholarshipCompletionModal'));
        scholarshipCompletionModal.show();

    }

    /**
     * @param {string} stepId
     */
    static saveActiveStep(stepId) {
        if (!stepId) {
            console.error("Attempting to save null or undefined step");
            return;
        }

        try {
            localStorage.setItem(this.storageKey, stepId);
            const savedValue = localStorage.getItem(this.storageKey);

            this.currentStep = parseInt(stepId);

            if (this.saveToHistory) {
                const url = new URL(window.location);
                url.searchParams.set('step', stepId);
                window.history.pushState({ stepId }, '', url);
            }
        } catch (e) {
            console.error("Error saving step to localStorage:", e);
        }
    }

    static processUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        const stepFromUrl = urlParams.get('step');

        if (stepFromUrl) {
            this.activateStep(stepFromUrl);
            return true;
        }
        return false;
    }

    /**
     * Restore the active step from localStorage
     */
    static restoreActiveStep() {
        if (this.processUrlParameters()) {
            return;
        }

        // Then check localStorage
        const savedStepId = localStorage.getItem(this.storageKey);

        if (savedStepId) {
            // Ensure savedStepId is a valid step number
            const availableSteps = document.querySelectorAll('.step-content').length;
            const stepId = parseInt(savedStepId);

            // Make sure saved step is within valid range (1 to total steps)
            if (!isNaN(stepId) && stepId >= 1 && stepId <= availableSteps) {
                // Use a small timeout to ensure DOM is ready
                setTimeout(() => {
                    this.currentStep = stepId; // Set current step explicitly
                    this.activateStep(stepId.toString(), false, true);
                }, 100);
            } else {
                console.warn(`Invalid saved step: ${savedStepId}, defaulting to step 1`);
                this.currentStep = 1;
                this.activateStep("1", true, true);
            }
        } else {
            this.currentStep = 1;
            this.activateStep("1", true, true);
        }
    }

    /**
     * @param {string} stepId
     * @param {boolean} saveState
     * @param {boolean} bypassValidation - Skip validation (used when restoring from storage)
     */
    static activateStep(stepId, saveState = true, bypassValidation = false) {
        if (!stepId) {
            console.error("Attempting to activate null or undefined step");
            return;
        }


        // First check if the step content exists
        const targetStepContent = document.querySelector(`.step-content[data-content="${stepId}"]`);
        if (!targetStepContent) {
            console.error(`Step content for step ${stepId} does not exist, staying on current step ${this.currentStep}`);
            return;
        }

        // Only validate if not bypassing and moving forward
        if (!bypassValidation && parseInt(stepId) > parseInt(this.currentStep)) {
            if (!this.validateCurrentStep(this.currentStep)) {
                return;
            }

            // Save data from current step if needed
            try {
                if (window.sendData && typeof window.sendData === 'function') {
                    window.sendData(this.currentStep);
                }
            } catch (e) {
                console.error("Error saving step data:", e);
            }
        }

        // Diğer adım anahtarlarını temizle - önemli!
        this.forceClearOtherStorageSteps();

        // Update the current step before manipulating DOM
        this.currentStep = parseInt(stepId);

        // Update the step indicators (circles)
        const stepItems = document.querySelectorAll('.step-item');

        stepItems.forEach(item => {
            const itemStepId = item.getAttribute('data-target');
            if (itemStepId === stepId) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else if (parseInt(itemStepId) < parseInt(stepId)) {

                item.classList.add('completed');
                item.classList.remove('active');
            } else {
                item.classList.remove('active', 'completed');
            }
        });

        // Show the correct step content
        const stepContents = document.querySelectorAll('.step-content');

        stepContents.forEach(content => {
            const contentId = content.getAttribute('data-content');

            if (contentId === stepId) {
                content.classList.add('active', 'show');

                // Scroll to the content
                content.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else {
                content.classList.remove('active', 'show');
            }
        });

        // Update the navigation buttons
        this.updateNavigationButtons(stepId, stepContents.length);

        if (saveState) {
            this.saveActiveStep(stepId);
        }

        // Anında localStorage'ı da güncelle
        localStorage.setItem(this.storageKey, stepId);

        // Bu adımın gerçekten localStorage'a kaydedildiğini doğrula
        const savedValue = localStorage.getItem(this.storageKey);

        // Eğer localStorage değeri bu adımla eşleşmiyorsa tekrar kaydet
        if (savedValue !== stepId.toString()) {
            console.warn(`Storage verification failed, forcibly saving step ${stepId} again`);
            localStorage.setItem(this.storageKey, stepId);
        }
    }

    static updateNavigationButtons(currentStep, totalSteps) {
        const nextButton = document.getElementById('nextStep');
        const prevButton = document.getElementById('prevButton');
        const completeButton = document.getElementById('completeButton');

        // Convert to number to ensure correct comparison
        currentStep = parseInt(currentStep);

        // Show/hide previous button
        if (prevButton) {
            if (currentStep > 1) {
                prevButton.style.display = 'block';
            } else {
                prevButton.style.display = 'none';
            }
        }

        // Show/hide next/complete buttons
        if (nextButton && completeButton) {
            if (currentStep === totalSteps) {
                nextButton.style.display = 'none';

                completeButton.style.display = 'block';
            } else {
                nextButton.style.display = 'block';
                completeButton.style.display = 'none';
            }
        }
    }

    static clearStepState() {
        localStorage.removeItem(this.storageKey);
    }

    static reloadPageKeepingStep() {
        // Ensure current step is saved before reloading
        this.saveActiveStep(this.currentStep.toString());
        setTimeout(() => {
            window.location.reload();
        }, 100);
    }

    static forceClearOtherStorageSteps() {
        try {
            const keysToKeep = [this.storageKey];

            // localStorage'da dolaş
            for (let i = 0; i < localStorage.length; i++) {
                const key = localStorage.key(i);
                if (key && key.startsWith('active_step_') && !keysToKeep.includes(key)) {
                    localStorage.removeItem(key);
                }
            }
        } catch (e) {
            console.error("Error clearing storage steps:", e);
        }
    }
}

window.StudentTabManager = StudentTabManager;
