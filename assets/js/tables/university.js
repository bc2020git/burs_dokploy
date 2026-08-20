document.addEventListener("DOMContentLoaded", function () {
  const universities = [

  ];

  const universityTableBody = document.getElementById("universityTableBody");

  universities.forEach((university, index) => {
    const row = document.createElement("tr");


const rowInnerHTML = `
  <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
  <td>${university.universiteKodu}</td>
  <td>${university.universiteAdi}</td>
  <td><span class="${getBadgeClass(university.universiteTuru)}">${university.universiteTuru}</span></td>
  <td>${university.sehir}</td>
  <td class="bursDurumuOnlisans"><span class="${getBadgeClass(university.bursVeriliyorMuOnlisans)}">${university.bursVeriliyorMuOnlisans}</span></td>
  <td class="bursDurumuLisans"><span class="${getBadgeClass(university.bursVeriliyorMuLisans)}">${university.bursVeriliyorMuLisans}</span></td>
  <td class="bursDurumuYlisans"><span class="${getBadgeClass(university.bursVeriliyorMuYlisans)}">${university.bursVeriliyorMuYlisans}</span></td>
  <td class="bursDurumuDoktora"><span class="${getBadgeClass(university.bursVeriliyorMuDoktora)}">${university.bursVeriliyorMuDoktora}</span></td>
  <td>
    <button class="btn edit-university-info-btn" data-index="${index}" onclick="location.href='/admin/university-details.html'">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
        <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
      </svg>
    </button>
  </td>
`;

row.innerHTML = rowInnerHTML;


// Tıklama etkisini durdurma
row.querySelectorAll("td:nth-child(7),td:nth-child(1), input[type='checkbox']").forEach((cell) => {
  cell.addEventListener("click", function (e) {
    e.stopPropagation();
  });
});

universityTableBody.appendChild(row);

$('#confirmBursDurum').on('click', function() {
  var durum = $('#bursVeriliyorMuDurum').val();

  const selectedEducationLevels = [];
  $("input[name='schooltype']:checked").each(function () {
    selectedEducationLevels.push($(this).val());
  });

  const checkboxes = document.querySelectorAll('input.checkbox:checked');

  checkboxes.forEach(checkbox => {
    const row = checkbox.closest('tr');

    if (selectedEducationLevels.includes("onLisans")) {
      const bursDurumuOnlisans = row.querySelector("td.bursDurumuOnlisans");
      if (bursDurumuOnlisans) {
        bursDurumuOnlisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
    }

    if (selectedEducationLevels.includes("lisans")) {
      const bursDurumuLisans = row.querySelector("td.bursDurumuLisans");
      if (bursDurumuLisans) {
        bursDurumuLisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
    }

    if (selectedEducationLevels.includes("yuksekLisans")) {
      const bursDurumuYlisans = row.querySelector("td.bursDurumuYlisans");
      if (bursDurumuYlisans) {
        bursDurumuYlisans.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
    }

    if (selectedEducationLevels.includes("doktora")) {
      const bursDurumuDoktora = row.querySelector("td.bursDurumuDoktora");
      if (bursDurumuDoktora) {
        bursDurumuDoktora.innerHTML = `<span class="status-box-${durum == 'Evet' ? 'success' : 'danger'}">${durum}</span>`;
      }
    }
  });
});
  });



  function getBadgeClass(status) {
    switch (status) {
      case "SAY":
        return "status-box-warning";
      case "EA":
        return "status-box-danger";
      case "SÖZ":
        return "status-box-purple";
      case "TYT":
        return "status-box-cyan";
        case "DİL":
        return "status-box-pink";
      case "Örgün":
        return "status-box-success";
        case "UZaktan":
        return "status-box-purple";
      case "İkinci":
        return "status-box-cyan";
        case "Açık Öğretim":
        return "status-box-pink";
      case "Devlet":
        return "status-box-devlet";
      case "Vakıf":
        return "status-box-vakif";
      case "Hayır":
        return "status-box-danger";
      case "Evet":
        return "status-box-success";
        case "2 Yıl":
          return "status-box-warning";
        case "4 Yıl":
          return "status-box-success";
        case "6 Yıl":
          return "status-box-pink";
      default:
        return "status-box-danger";
    }
  }

  // Düzenleme butonuna tıklama
  $(document).on("click", ".edit-university-info-btn", function () {
    const index = $(this).data("index");
    const selectedUniversity = universities[index];
    localStorage.setItem(
      "selectedUniversity",
      JSON.stringify(selectedUniversity)
    );
    window.location.href = "/admin/university-details.html";
  });

  // DataTable başlat
  $("#universityTable").DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]], // Kayıt gösterme seçenekleri
    dom: '<"top"<"left"l><"right"f>>rt<"bottom"ip><"clear">B', // DOM yapısını düzenle
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
