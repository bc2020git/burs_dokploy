document.addEventListener("DOMContentLoaded", function () {
    // İleri geri butonları ve tab geçişleri
    const navLinks = document.querySelectorAll(".nav-link");
    const tabPane = document.querySelectorAll(".tab-pane");
    let currentStep = 1;

    function showStep(step) {
        navLinks.forEach((item) => {
            item.classList.remove("active");
            if (parseInt(item.getAttribute("data-target")) < step) {
                item.classList.add("completed");
            } else {
                item.classList.remove("completed");
            }
            if (parseInt(item.getAttribute("data-target")) === step) {
                item.classList.add("active");
            }
        });
        tabPane.forEach((content) => {
            content.classList.remove("show", "active");
            if (parseInt(content.getAttribute("data-content")) === step) {
                content.classList.add("show", "active");
            }
        });
    }

    const prevBtn = document.getElementById("prevButton");

    const nextBtn = document.getElementById("nextStep");
    const completeBtn = document.getElementById("completeButton");

    nextBtn.addEventListener("click", () => {
        if (currentStep < navLinks.length) {
            currentStep++;
            if (currentStep > 1) {
                prevBtn.style.display = "inline-block";
            }
            if (currentStep === navLinks.length) {
                nextBtn.style.display = "none";
                completeBtn.style.display = "inline-block";
            }
            showStep(currentStep);
        }
    });

    prevBtn.addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            if (currentStep === 1) {
                prevBtn.style.display = "none";
            }
            if (currentStep < navLinks.length) {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }
            showStep(currentStep);
        }










    });

    navLinks.forEach((item) => {
        item.addEventListener("click", (e) => {
            const target = parseInt(e.target.getAttribute("data-target"));
            currentStep = target;
            if (currentStep === 1) {
                prevBtn.style.display = "none";
            } else {
                prevBtn.style.display = "inline-block";
            }
            if (currentStep === navLinks.length) {
                nextBtn.style.display = "none";
                completeBtn.style.display = "inline-block";
            } else {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }
            showStep(currentStep);
        });



    });




























































































    completeBtn.addEventListener("click", () => {
        scholarshipCompletionModal.show();
    });

    document.getElementById("completeButton").addEventListener("click", () => {

    });
});


