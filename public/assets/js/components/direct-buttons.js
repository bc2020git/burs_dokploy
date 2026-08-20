document.addEventListener("DOMContentLoaded", function () {
  const navLink = document.querySelectorAll(".nav-link");
  const tabPane = document.querySelectorAll(".tab-pane");
  let currentStep = 1;

  function showStep(step) {
    navLink.forEach((item) => {
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
  const scholarshipCompletionModal = new bootstrap.Modal(document.getElementById('scholarshipCompletionModal'));
  const modalCloseButton = document.getElementById("modalCloseButton");

  document.getElementById("nextStep").addEventListener("click", () => {
    if (currentStep < navLink.length) {
      currentStep++;
      if (currentStep === navLink.length) {
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
      if (currentStep < navLink.length) {
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
      if (currentStep < navLink.length) {
        nextBtn.style.display = "inline-block";
        completeBtn.style.display = "none";
      }
      showStep(currentStep);
    }
  });

  navLink.forEach((item) => {
    item.addEventListener("click", (e) => {
      const target = parseInt(e.target.getAttribute("data-target"));
      currentStep = target;
      if (currentStep === 1) {
        prevBtn.style.display = "none";
      } else {
        prevBtn.style.display = "inline-block";
      }
      if (currentStep === navLink.length) {
        nextBtn.style.display = "none";
        completeBtn.style.display = "inline-block";
      } else {
        nextBtn.style.display = "inline-block";
        completeBtn.style.display = "none";
      }
      showStep(currentStep);
    });
  });


  modalCloseButton.addEventListener("click", () => {
    window.location.href = "/admin/scholarship-recipient-list.html";
  });

  showStep(currentStep);
});
