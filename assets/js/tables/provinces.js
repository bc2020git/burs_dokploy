document.addEventListener("DOMContentLoaded", function () {
  const provinces = [
    {
      plakaNo: "01",
      ilAd: "Adana",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "02",
      ilAd: "Adıyaman",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "03",
      ilAd: "Afyonkarahisar",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "04",
      ilAd: "Ağrı",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Hayır",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "05",
      ilAd: "Amasya",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Hayır",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "06",
      ilAd: "Ankara",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Hayır",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Hayır",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "07",
      ilAd: "Antalya",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
      bursVeriliyorMuOnlisans: "Hayır",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Hayır",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "08",
      ilAd: "Artvin",
      bursVeriliyorMuIlkokul: "Evet",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Evet",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Hayır",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "09",
      ilAd: "Aydın",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Hayır",
      bursVeriliyorMuLise: "Hayır",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
    {
      plakaNo: "10",
      ilAd: "Balıkesir",
      bursVeriliyorMuIlkokul: "Hayır",
      bursVeriliyorMuOrtaokul: "Evet",
      bursVeriliyorMuLise: "Hayır",
      bursVeriliyorMuOnlisans: "Evet",
      bursVeriliyorMuLisans: "Hayır",
      bursVeriliyorMuYlisans: "Evet",
      bursVeriliyorMuDoktora: "Hayır",
    },
  ];

  const provinceTableBody = document.getElementById("provinceTableBody");

  provinces.forEach((province, index) => {
    const row = document.createElement("tr");
    row.setAttribute("data-id", `${province.plakaNo}`);


    const actionButtonHTML =
      province.plakaNo === "01" ||
      province.plakaNo === "04" ||
      province.plakaNo === "06"
        ? `
              <button class="btn edit-province-info-btn" data-index="${index}" onclick="location.href='/admin/provinces-details.html'" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`
        : `
              <button class="btn edit-province-info-btn" data-index="${index}" onclick="location.href='/admin/provinces-details.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`;

    const rowInnerHTML = `
          <td><input type="checkbox" data-id="${province.plakaNo}" class="checkbox" id="masterCheckbox"></td>
          <td>${province.plakaNo}</td>
          <td>${province.ilAd}</td>
          <td class="bursVeriliyorMuIlkokul"><span class="${getBadgeClass(
            province.bursVeriliyorMuIlkokul
          )}">${province.bursVeriliyorMuIlkokul}</span></td>
          <td class="bursVeriliyorMuOrtaokul"><span class="${getBadgeClass(
            province.bursVeriliyorMuOrtaokul
          )}">${province.bursVeriliyorMuOrtaokul}</span></td>
          <td class="bursVeriliyorMuLise"><span class="${getBadgeClass(
            province.bursVeriliyorMuLise
          )}">${province.bursVeriliyorMuLise}</span></td>
          <td class="bursVeriliyorMuOnlisans"><span class="${getBadgeClass(
            province.bursVeriliyorMuOnlisans
          )}">${province.bursVeriliyorMuOnlisans}</span></td>
          <td class="bursVeriliyorMuLisans"><span class="${getBadgeClass(
            province.bursVeriliyorMuLisans
          )}">${province.bursVeriliyorMuLisans}</span></td>
          <td class="bursVeriliyorMuYlisans"><span class="${getBadgeClass(
            province.bursVeriliyorMuYlisans
          )}">${province.bursVeriliyorMuYlisans}</span></td>
          <td class="bursVeriliyorMuDoktora"><span class="${getBadgeClass(
            province.bursVeriliyorMuDoktora
          )}">${province.bursVeriliyorMuDoktora}</span></td>
          <td>${actionButtonHTML}</td>
      `;

    row.innerHTML = rowInnerHTML;
    // Satır tıklama olayı
    row.addEventListener("click", function () {
      window.location.href = "/admin/provinces-details.html";
    });

    row
      .querySelectorAll(
        "td:nth-child(5),td:nth-child(1), input[type='checkbox']"
      )
      .forEach((cell) => {
        cell.addEventListener("click", function (e) {
          e.stopPropagation();
        });
      });
    provinceTableBody.appendChild(row);
  });

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
        const bursDurumuIlkokul = row.querySelector("td.bursVeriliyorMuIlkokul");
        if (bursDurumuIlkokul) bursDurumuIlkokul.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("ortaokul")) {
        const bursDurumuOrtaokul = row.querySelector("td.bursVeriliyorMuOrtaokul");
        if (bursDurumuOrtaokul) bursDurumuOrtaokul.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("lise")) {
        const bursDurumuLise = row.querySelector("td.bursVeriliyorMuLise");
        if (bursDurumuLise) bursDurumuLise.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("onLisans")) {
        const bursDurumuOnlisans = row.querySelector("td.bursVeriliyorMuOnlisans");
        if (bursDurumuOnlisans) bursDurumuOnlisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("lisans")) {
        const bursDurumuLisans = row.querySelector("td.bursVeriliyorMuLisans");
        if (bursDurumuLisans) bursDurumuLisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("yuksekLisans")) {
        const bursDurumuYlisans = row.querySelector("td.bursVeriliyorMuYlisans");
        if (bursDurumuYlisans) bursDurumuYlisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
  
      if (selectedEducationLevels.includes("doktora")) {
        const bursDurumuDoktora = row.querySelector("td.bursVeriliyorMuDoktora");
        if (bursDurumuDoktora) bursDurumuDoktora.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
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

  // Düzenleme butonuna tıklama olayı
  $(document).on("click", ".edit-province-info-btn", function () {
    const index = $(this).data("index");
    const selectedProvince = provinces[index];
    localStorage.setItem("selectedProvince", JSON.stringify(selectedProvince));
    window.location.href = "/admin/provinces-details.html";
  });

  // DataTable başlat
  $("#provinceTable").DataTable({
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
      { orderable: false, targets: 0 },
      { orderable: false, targets: 1 },
      { orderable: false, targets: "_all" },
    ],
  });
});
