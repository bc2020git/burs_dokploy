document.addEventListener("DOMContentLoaded", function () {
  const districts = [
    {
      plakaNo: "01",
      ilAd: "Adana",
      ilceAd: "Seyhan",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "01",
      ilAd: "Adana",
      ilceAd: "Çukurova",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "01",
      ilAd: "Adana",
      ilceAd: "Yüreğir",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "01",
      ilAd: "Adana",
      ilceAd: "Ceyhan",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "06",
      ilAd: "Ankara",
      ilceAd: "Çankaya",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "06",
      ilAd: "Ankara",
      ilceAd: "Keçiören",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "06",
      ilAd: "Ankara",
      ilceAd: "Yenimahalle",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "06",
      ilAd: "Ankara",
      ilceAd: "Altındağ",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "07",
      ilAd: "Antalya",
      ilceAd: "Alanya",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "07",
      ilAd: "Antalya",
      ilceAd: "Muratpaşa",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "07",
      ilAd: "Antalya",
      ilceAd: "Konyaaltı",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "07",
      ilAd: "Antalya",
      ilceAd: "Manavgat",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "09",
      ilAd: "Aydın",
      ilceAd: "Efeler",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "09",
      ilAd: "Aydın",
      ilceAd: "Nazilli",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "09",
      ilAd: "Aydın",
      ilceAd: "Söke",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "09",
      ilAd: "Aydın",
      ilceAd: "Kuşadası",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "16",
      ilAd: "Bursa",
      ilceAd: "Osmangazi",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "16",
      ilAd: "Bursa",
      ilceAd: "Yıldırım",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "16",
      ilAd: "Bursa",
      ilceAd: "Nilüfer",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "16",
      ilAd: "Bursa",
      ilceAd: "İnegöl",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "34",
      ilAd: "İstanbul",
      ilceAd: "Kadıköy",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "34",
      ilAd: "İstanbul",
      ilceAd: "Beşiktaş",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "34",
      ilAd: "İstanbul",
      ilceAd: "Sarıyer",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
    },
    {
      plakaNo: "34",
      ilAd: "İstanbul",
      ilceAd: "Üsküdar",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "35",
      ilAd: "İzmir",
      ilceAd: "Konak",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "35",
      ilAd: "İzmir",
      ilceAd: "Karşıyaka",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "35",
      ilAd: "İzmir",
      ilceAd: "Bornova",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "35",
      ilAd: "İzmir",
      ilceAd: "Buca",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "61",
      ilAd: "Trabzon",
      ilceAd: "Ortahisar",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "61",
      ilAd: "Trabzon",
      ilceAd: "Akçaabat",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "61",
      ilAd: "Trabzon",
      ilceAd: "Vakfıkebir",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
    {
      plakaNo: "61",
      ilAd: "Trabzon",
      ilceAd: "Of",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
    },
  ];

  const districtTableBody = document.getElementById("districtTableBody");

  districts.forEach((district, index) => {
    const row = document.createElement("tr");

    const actionButtonHTML =
      district.plakaNo === "01" ||
      district.plakaNo === "04" ||
      district.plakaNo === "06"
        ? `
              <button class="btn edit-district-info-btn" data-index="${index}" onclick="location.href='/admin/district-details.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`
        : `
              <button class="btn edit-district-info-btn" data-index="${index}" onclick="location.href='/admin/district-details.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`;


    const rowInnerHTML = `
  <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
  <td>${district.plakaNo}</td>
  <td>${district.ilAd}</td>
  <td>${district.ilceAd}</td>
  <td class="bursVeriliyorMuIlkokul"><span class="${getBadgeClass(
    district.bursVeriliyorMuIlkokul
  )}">${district.bursVeriliyorMuIlkokul}</span></td>
  <td class="bursVeriliyorMuOrtaokul"><span class="${getBadgeClass(
    district.bursVeriliyorMuOrtaokul
  )}">${district.bursVeriliyorMuOrtaokul}</span></td>
  <td class="bursVeriliyorMuLise"><span class="${getBadgeClass(
    district.bursVeriliyorMuLise
  )}">${district.bursVeriliyorMuLise}</span></td>
  <td>${actionButtonHTML}</td>
`;

    row.innerHTML = rowInnerHTML;

    row.addEventListener("click", function () {
      window.location.href = "/admin/district-details.html";
    });

    row
      .querySelectorAll(
        "td:nth-child(6),td:nth-child(1), input[type='checkbox']"
      )
      .forEach((cell) => {
        cell.addEventListener("click", function (e) {
          e.stopPropagation();
        });
      });

    districtTableBody.appendChild(row);

    $("#confirmBursDurum").on("click", function () {
      var durum = $("#bursVeriliyorMuDurum").val();

      const selectedEducationLevels = [];
      $("input[name='schooltype']:checked").each(function () {
        selectedEducationLevels.push($(this).val());
      });

      const checkboxes = document.querySelectorAll("input.checkbox:checked");

      checkboxes.forEach((checkbox) => {
        const row = checkbox.closest("tr");

        if (selectedEducationLevels.includes("ilkokul")) {
          const bursDurumuIlkokul = row.querySelector(
            "td.bursVeriliyorMuIlkokul"
          );
          if (bursDurumuIlkokul) {
            bursDurumuIlkokul.innerHTML = `<span class="status-box-${
              durum == "Evet" ? "success" : "danger"
            }">${durum}</span>`;
          }
        }

        if (selectedEducationLevels.includes("ortaokul")) {
          const bursDurumuOrtaokul = row.querySelector(
            "td.bursVeriliyorMuOrtaokul"
          );
          if (bursDurumuOrtaokul) {
            bursDurumuOrtaokul.innerHTML = `<span class="status-box-${
              durum == "Evet" ? "success" : "danger"
            }">${durum}</span>`;
          }
        }

        if (selectedEducationLevels.includes("lise")) {
          const bursDurumuLise = row.querySelector("td.bursVeriliyorMuLise");
          if (bursDurumuLise) {
            bursDurumuLise.innerHTML = `<span class="status-box-${
              durum == "Evet" ? "success" : "danger"
            }">${durum}</span>`;
          }
        }
      });
    });
  });

  function getBadgeClass(status) {
    switch (status) {
      case "Evet":
        return "status-box-success";

      default:
        return "status-box-danger";
    }
  }
  // Düzenleme butonuna tıklama
  $(document).on("click", ".edit-district-info-btn", function () {
    const index = $(this).data("index");
    const selecteddistrict = districts[index];
    localStorage.setItem("selecteddistrict", JSON.stringify(selecteddistrict));
    window.location.href = "/admin/district-details.html";
  });

  // DataTable başlat
  $("#districtTable").DataTable({
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
      { orderable: false, targets: 0 }, // İlk sütunun sıralama özelliği kapatıldı
      { orderable: false, targets: 1 },
      { orderable: false, targets: "_all" },
    ],
  });
});
