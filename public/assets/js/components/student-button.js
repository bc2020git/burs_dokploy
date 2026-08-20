/*Yönlendirme Butonları */
document.addEventListener("DOMContentLoaded", function () {
    // İleri geri butonları ve tab geçişleri
    const stepItems = document.querySelectorAll(".step-item");
    const stepContent = document.querySelectorAll(".step-content");
    let currentStep = 1;
  
    function showStep(step) {
      stepItems.forEach((item) => {
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
      stepContent.forEach((content) => {
        content.classList.remove("show", "active");
        if (parseInt(content.getAttribute("data-content")) === step) {
          content.classList.add("show", "active");
        }
      });
    }
  
    var prevBtn = document.getElementById("prevButton");
  
    document.getElementById("nextStep").addEventListener("click", () => {
      if (currentStep < stepItems.length) {
        currentStep++;
        if (currentStep == 1) {
          prevBtn.style.display = "none";
        } else {
          prevBtn.style.display = "inline-block";
        }
        showStep(currentStep);
      }
    });
  
    document.getElementById("prevButton").addEventListener("click", () => {
      if (currentStep > 1) {
        currentStep--;
        if (currentStep == 1) {
          prevBtn.style.display = "none";
        }
        showStep(currentStep);
      }
    });
  
    document.getElementById("prevStep").addEventListener("click", () => {
      if (currentStep > 1) {
        currentStep--;
        if (currentStep == 1) {
          prevBtn.style.display = "none";
        }
        showStep(currentStep);
      }
    });
  
    stepItems.forEach((item) => {
      item.addEventListener("click", (e) => {
        const target = parseInt(e.target.getAttribute("data-target"));
        currentStep = target;
        if (currentStep == 1) {
          prevBtn.style.display = "none";
        } else {
          prevBtn.style.display = "inline-block";
        }
        showStep(currentStep);
      });
    });
  
    showStep(currentStep);
  });
  document.addEventListener("DOMContentLoaded", function () {
    const stepItem = document.querySelectorAll(".step-item");
    const stepContent = document.querySelectorAll(".step-content");
    let currentStep = 1;
  
    function showStep(step) {
        stepItem.forEach((item) => {
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
        stepContent.forEach((content) => {
            content.classList.remove("show", "active");
            if (parseInt(content.getAttribute("data-content")) === step) {
                content.classList.add("show", "active");
            }
        });
    }
  
    const prevBtn = document.getElementById("prevButton");
    const nextBtn = document.getElementById("nextStep");
    const completeBtn = document.getElementById("completeButton");
    const scholarshipCompletionModal = new bootstrap.Modal(document.getElementById('scholarshipCompletionModal'));
    const modalCloseButton = document.getElementById("modalCloseButton");
  
    document.getElementById("nextStep").addEventListener("click", () => {
        if (currentStep < stepItem.length) {
            currentStep++;
            if (currentStep === stepItem.length) {
                nextBtn.style.display = "none";
                completeBtn.style.display = "inline-block";
            } else {
                prevBtn.style.display = "inline-block";
            }
            showStep(currentStep);
        }
    });
  
    document.getElementById("prevButton").addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            if (currentStep === 1) {
                prevBtn.style.display = "none";
            }
            if (currentStep < stepItem.length) {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }
            showStep(currentStep);
        }
    });
  
    document.getElementById("prevStep").addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            if (currentStep === 1) {
                prevBtn.style.display = "none";
            }
            if (currentStep < stepItem.length) {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }
            showStep(currentStep);
        }
    });
  
    stepItem.forEach((item) => {
        item.addEventListener("click", (e) => {
            const target = parseInt(e.target.getAttribute("data-target"));
            currentStep = target;
            if (currentStep === 1) {
                prevBtn.style.display = "none";
            } else {
                prevBtn.style.display = "inline-block";
            }
            if (currentStep === stepItem.length) {
                nextBtn.style.display = "none";
                completeBtn.style.display = "inline-block";
            } else {
                nextBtn.style.display = "inline-block";
                completeBtn.style.display = "none";
            }
            showStep(currentStep);
        });
    });
  
    document.getElementById("completeButton").addEventListener("click", () => {
      scholarshipCompletionModal.show();
  });

  modalCloseButton.addEventListener("click", () => {
      scholarshipCompletionModal.hide();
      window.location.href = '/student/student-application-list.html';
  });
  
    showStep(currentStep);
    const employmentStatusSelect = document.getElementById('employment-status');
    const employmentDetails = document.getElementById('employment-details');

    if (employmentStatusSelect && employmentDetails) {
        employmentStatusSelect.addEventListener('change', function () {
            if (employmentStatusSelect.value === 'full-time' || employmentStatusSelect.value === 'part-time' || employmentStatusSelect.value === 'intern') {
                employmentDetails.classList.remove('d-none');
            } else {
                employmentDetails.classList.add('d-none');
            }
        });
    }

  });


  
