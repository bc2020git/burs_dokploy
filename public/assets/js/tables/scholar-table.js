document.addEventListener("DOMContentLoaded", function () {
  const members = [
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2017-2018",
      ad: "Canan",
      soyad: "Tan",
      okulAdi: "Amasya İlkokulu",
      sinif: "5. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onaylandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2017-2018",
      ad: "Ernest",
      soyad: "Bradtke",
      okulAdi: "B Okulu",
      sinif: "1. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Red Edildi",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2016-2017",
      ad: "Diane",
      soyad: "Witting",
      okulAdi: "C Okulu",
      sinif: "6. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onay Bekliyor",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2016-2017",
      ad: "Reginald",
      soyad: "Hirthe",
      okulAdi: "F Okulu",
      sinif: " 6. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "İade Edildi",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2015-2016",
      ad: "Derek",
      soyad: "Mayer",
      okulAdi: "H Okulu",
      sinif: "6. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onaylandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2020-2021",
      ad: "Anita",
      soyad: "Trantow",
      okulAdi: "T Okulu",
      sinif: "6. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onay Bekliyor",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2023-2024",
      ad: "Tracy",
      soyad: "Ebert",
      okulAdi: "V Okulu",
      sinif: "4. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Red Edildi",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2009-2010",
      ad: "Javier",
      soyad: "Connelly",
      okulAdi: "H Okulu",
      sinif: "3. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onaylandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2017-2018",
      ad: "Johanna",
      soyad: "Osinski",
      okulAdi: "D Okulu",
      sinif: "3. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Onaylandı",
    },
    {
      profil: "/assets/images/avatar-correct.svg",
      bursBaslangic: "2023-2024",
      ad: "Wesley",
      soyad: "Daniel",
      okulAdi: "E Okulu",
      sinif: "6. Sınıf",
      bolum:"Mühendislik",
      kayitYenileme: "Red Edildi",

    },
  ];

  const registrationRenewalTableBody = document.getElementById("registrationRenewalTableBody");

  members.forEach((member) => {
    const row = document.createElement("tr");

    const actionButtonHTML =
      member.ad === "Canan" || member.ad === "Anita"
        ? `<button class="btn" onclick="location.href='/admin/send-sms.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
            </svg></button>
            <button class="btn edit-member-info-btn" onclick="location.href='/admin/registration-renewal-confirmation.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
            </svg></button>`
        : `<button class="btn" onclick="location.href='/admin/send-mail.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
            </svg></button>
            <button class="btn edit-member-info-btn" onclick="location.href='/admin/registration-renewal-confirmation.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
            </svg></button>`
            ;

    const rowInnerHTML = `
            <td><input type="checkbox" class="checkbox"></td>
            <td><img src="${member.profil}" width="50"></td>
            <td>${member.bursBaslangic}</td>
            <td>${member.ad}</td>
            <td>${member.soyad}</td>
            <td>${member.okulAdi}</td>
            <td>${member.sinif}</td>
            <td>${member.bolum}</td>
            <td><span class="${getBadgeClass(member.kayitYenileme)}">${
      member.kayitYenileme
    }</span></td>
            <td>${actionButtonHTML}</td>
        `;

    row.innerHTML = rowInnerHTML;
    registrationRenewalTableBody.appendChild(row);
  });

  function getBadgeClass(status) {
    switch (status) {
      case "Onaylandı":
        return "status-box-success";
      case "Onay Bekliyor":
        return "status-box-warning";
      case "Red Edildi":
        return "status-box-danger";
      case "İade Edildi":
        return "status-box-secondary";
      default:
        return "";
    }
  }



  // DataTable başlat
  $("#registrationRenewalTable").DataTable({
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
    columnDefs: [
      { orderable: false, targets: 1 },
      { orderable: false, targets: '_all' } 
    ],
  });
});

// Satır tıklama olayı
$("#registrationRenewalTable tbody").on("click", "tr", function () {
    window.location.href = "/admin/registration-renewal-details.html";
  });

  $("#registrationRenewalTable tbody").on("click", "td:nth-child(10), input[type='checkbox']", function (e) {
    e.stopPropagation();
  });

document.addEventListener("DOMContentLoaded", function () {
  const confirmButton = document.getElementById("confirm");
  const confirmModal = new bootstrap.Modal(
    document.getElementById("confirmModal")
  );
  const toReturnButton = document.getElementById("to-return");
  const toReturnModal = new bootstrap.Modal(
    document.getElementById("missingDocumentModal")
  );
  const rejectedButton = document.getElementById("denied");
  const rejectedModal = new bootstrap.Modal(
    document.getElementById("rejectModal")
  );

  confirmButton.addEventListener("click", function () {
    confirmModal.show();
    setTimeout(function () {
      window.location.href = "/admin/graduate-scholar.html";
    }, 5000);
  });

  toReturnButton.addEventListener("click", function () {
    toReturnModal.show();
    setTimeout(function () {
      window.location.href = "/admin/graduate-scholar.html";
    }, 5000);
  });

  rejectedButton.addEventListener("click", function () {
    rejectedModal.show();
    setTimeout(function () {
      window.location.href = "/admin/graduate-scholar.html";
    }, 5000);
  });
});
