document.addEventListener("DOMContentLoaded", function () {
    const stepItems = document.querySelectorAll(".step-item");
    const stepContent = document.querySelectorAll(".step-content");
    let currentStep = 1;

    const prevBtn = document.getElementById("prevButton");
    const nextBtn = document.getElementById("nextStep");
    const completeBtn = document.getElementById("completeButton");
    const scholarshipCompletionModal = new bootstrap.Modal(document.getElementById('scholarshipCompletionModal'));
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

    function validateStep(step) {
        const currentStepContent = document.querySelector(`.step-content[data-content="${step}"]`);
        const requiredFields = currentStepContent.querySelectorAll("[required]");
        let isValid = true;

        requiredFields.forEach((field) => {
            if (!field.value.trim()) {
                field.classList.add("is-invalid");  
                isValid = false;
            } else {
                field.classList.remove("is-invalid");  
            }
        });

        return isValid;
    }

    nextBtn.addEventListener("click", () => {
        if (validateStep(currentStep)) {  
            if (currentStep < stepItems.length) {
                currentStep++;
                showStep(currentStep);
            }
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    stepItems.forEach((item) => {
        item.addEventListener("click", function () {
            const targetStep = parseInt(this.getAttribute("data-target"));
            if (validateStep(currentStep)) { 
                currentStep = targetStep;
                showStep(currentStep);
            }
        });
    });

    completeBtn.addEventListener("click", () => {
        if (validateStep(currentStep)) {  
            scholarshipCompletionModal.show();
        }
    });

    modalCloseButton.addEventListener("click", () => {
        scholarshipCompletionModal.hide();
        window.location.href = '/studentRegistrationRenewal/student-registration-list.html';
    });

    showStep(currentStep);

    const employmentStatusSelect = document.getElementById('employment-status');
    const employmentDetails = document.getElementById('employment-details');

    employmentStatusSelect.addEventListener('change', function () {
        if (employmentStatusSelect.value === 'full-time' || employmentStatusSelect.value === 'part-time' || employmentStatusSelect.value === 'intern') {
            employmentDetails.classList.remove('d-none');
        } else {
            employmentDetails.classList.add('d-none');
        }
    });

    function updateStepView() {
        stepItems.forEach((step, index) => {
            if (index === currentStep - 1) {
                step.scrollIntoView({ behavior: 'smooth', inline: 'center' });
            }
        });
    }

    updateStepView();
});
