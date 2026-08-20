document.addEventListener("DOMContentLoaded", function () {
  const interviews = [
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "001",
      ad: "Canan",
      soyad: "Tan",
      basvuruPuani: 90,
      mulakatPuani: 90,
      bursPuani: 95,
      bursSonucu: "Sonuç Bekliyor",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "002",
      ad: "Ernest",
      soyad: "Bradtke",
      basvuruPuani: 90,
      mulakatPuani: 80,
      bursPuani: 95,
      bursSonucu: "Kazandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "003",
      ad: "Diane",
      soyad: "Witting",
      basvuruPuani: 20,
      mulakatPuani: 20,
      bursPuani: 20,
      bursSonucu: "Sonuç Bekliyor",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "004",
      ad: "Reginald",
      soyad: "Hirthe",
      basvuruPuani: 90,
      mulakatPuani: 10,
      bursPuani: 10,
      bursSonucu: "Kazanamadı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "005",
      ad: "Derek",
      soyad: "Mayer",
      basvuruPuani: 70,
      mulakatPuani: 0,
      bursPuani: 0,
      bursSonucu: "Sonuç Bekliyor",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "006",
      ad: "Anita",
      soyad: "Trantow",
      basvuruPuani: 90,
      mulakatPuani: 100,
      bursPuani: 95,
      bursSonucu: "Kazandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "007",
      ad: "Tracy",
      soyad: "Ebert",
      basvuruPuani: 90,
      mulakatPuani: 30,
      bursPuani: 45,
      bursSonucu: "Kazanamadı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "008",
      ad: "Javier",
      soyad: "Connelly",
      basvuruPuani: 100,
      mulakatPuani: 85,
      bursPuani: 85,
      bursSonucu: "Kazandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "009",
      ad: "Johanna",
      soyad: "Osinski",
      basvuruPuani: 80,
      mulakatPuani: 90,
      bursPuani: 89,
      bursSonucu: "Kazandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "010",
      ad: "Wesley",
      soyad: "Daniel",
      basvuruPuani: 15,
      mulakatPuani: 5,
      bursPuani: 12,
      bursSonucu: "Kazanamadı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "011",
      ad: "Chelsea",
      soyad: "Friesen",
      basvuruPuani: 80,
      mulakatPuani: 100,
      bursPuani: 88,
      bursSonucu: "Kazandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      id: "012",
      ad: "Anita",
      soyad: "Trantow",
      basvuruPuani: 90,
      mulakatPuani: 90,
      bursPuani: 90,
      bursSonucu: "Kazandı",
    },
  ];

  const completeInterviewTableBody = document.getElementById("completeInterviewTableBody");

  interviews.forEach((interview) => {
    const row = document.createElement("tr");

    const actionButtonHTML =
      interview.id === "001" || interview.id === "004" || interview.id === "006"
        ? `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
            </svg></button>
            <button class="btn edit-interview-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
            </svg></button>
            <button class="btn add-note-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M21 11H11V21H21V11Z" fill="#636363"/>
            <path d="M21 7C21 6.44772 20.5523 6 20 6H17V3C17 2.44772 16.5523 2 16 2H8C7.44772 2 7 2.44772 7 3V6H4C3.44772 6 3 6.44772 3 7V17C3 17.5523 3.44772 18 4 18H7V21C7 21.5523 7.44772 22 8 22H16C16.5523 22 17 21.5523 17 21V18H20C20.5523 18 21 17.5523 21 17V7ZM8 4H16V6H8V4ZM16 20H8V18H11H13H16V20Z" fill="#636363"/>
            </svg></button>`
        : `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
            </svg></button>
            <button class="btn edit-interview-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
            </svg></button>
            <button class="btn add-note-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M21 11H11V21H21V11Z" fill="#fff"/>
            <path d="M21 7C21 6.44772 20.5523 6 20 6H17V3C17 2.44772 16.5523 2 16 2H8C7.44772 2 7 2.44772 7 3V6H4C3.44772 6 3 6.44772 3 7V17C3 17.5523 3.44772 18 4 18H7V21C7 21.5523 7.44772 22 8 22H16C16.5523 22 17 21.5523 17 21V18H20C20.5523 18 21 17.5523 21 17V7ZM8 4H16V6H8V4ZM16 20H8V18H11H13H16V20Z" fill="#636363"/>
            </svg></button>`;

    const rowInnerHTML = `
            <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
            <td><img src="${interview.profil}" width="50"></td>
            <td>${interview.id}</td>
            <td>${interview.ad}</td>
            <td>${interview.soyad}</td>
            <td>${interview.basvuruPuani}</td>
            <td>${interview.mulakatPuani}</td>
            <td>${interview.bursPuani}</td>
            <td><span class="${getBadgeClass(interview.bursSonucu)}">${
      interview.bursSonucu
    }</span></td>
            <td>${actionButtonHTML}</td>
        `;

    row.innerHTML = rowInnerHTML;
    completeInterviewTableBody.appendChild(row);
  });

  function getBadgeClass(status) {
    switch (status) {
      case "Kazandı":
        return "badge bg-success";
      case "Sonuç Bekliyor":
        return "badge bg-warning";
      case "Kazanamadı":
        return "badge bg-danger";
      default:
        return "";
    }
  }

  // DataTable başlat
  $("#completeInterviewTable").DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: '<"top"t><"bottom"lfi><"bottom"p><"clear">',
    language: {
      lengthMenu: "Göster _MENU_ kayıt",
      zeroRecords: "Kayıt bulunamadı",
      info: "  _END_ öğeden _TOTAL_ 'i",
      infoEmpty: "Gösterilecek kayıt yok",
      infoFiltered: "(_MAX_ kayıt içinde filtrelendi)",
      search: "Ara:",
      paginate: {
        first: "İlk",
        last: "Son",
        next: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"/>
              </svg>`,
        previous: `<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"/>
              </svg>`,
      },
    },
  });
});

// Satır tıklama olayı
// $("#completeInterviewTable tbody").on("click", "tr", function () {
//   window.location.href = "/admin/scholarship-application-list-documents.html";
// });
document.addEventListener("DOMContentLoaded", function () {
    const addNoteButtons = document.querySelectorAll(".add-note-btn");
    const noteModal = new bootstrap.Modal(document.getElementById("noteModal"));
    const saveNoteButton = document.getElementById("saveNoteButton");

    addNoteButtons.forEach(button => {
        button.addEventListener("click", function () {
            noteModal.show();
        });
    });

    saveNoteButton.addEventListener("click", function () {
        noteModal.hide();
        alert("Mülakat notu kaydedildi.");
    });

});
