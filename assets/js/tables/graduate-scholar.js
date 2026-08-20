document.addEventListener("DOMContentLoaded", function () {
    const students = [
    ];

    const graduateTableBody = document.getElementById("graduateTableBody");

    students.forEach((student) => {
      const row = document.createElement("tr");


      const rowInnerHTML = `
                <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
                <td><img src="${student.profil}" width="50"></td>
                <td>${student.tcKimlikNo}</td>
                <td>${student.ad}</td>
                <td>${student.soyad}</td>
                <td>${student.okulAdi}</td>
                <td>${student.bolum}</td>
                <td>${student.mezunTarihi}</td>
            `;

      row.innerHTML = rowInnerHTML;
      graduateTableBody.appendChild(row);
    });

    function getBadgeClass(status) {
      switch (status) {
        case "Kazandı":
          return "status-box-success";
        case "Sonuç Bekliyor":
          return " status-box-warning";
        case "Kazanamadı":
          return "status-box-danger";
        default:
          return "";
      }
    }

  // Satır tıklama olayı


$("#graduateTableBody ").on("click", "td:nth-child(9),td:nth-child(1), input[type='checkbox']", function (e) {
  e.stopPropagation();
});



    // DataTable başlat
    var table = $("#graduateTable").DataTable({
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      lengthChange: true,
      pageLength: 10,
      dom: '<"top"lf>t<"bottom"ip><"clear">',
      buttons: ['csv',
        {
            extend: 'excelHtml5',
            title: 'Mezun Bursiyerler',
            exportOptions: {
                columns: ':visible' // Yalnızca görünür sütunları dahil et
            }
        },{extend: 'pdfHtml5',title: 'Mezun Bursiyerler',exportOptions: {
                columns: ':visible' // Yalnızca görünür sütunları dahil et
            }}
    ],
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
    function toggleColumnVisibility(checkbox) {
        var checkboxId = $(checkbox).attr('id'); // Checkbox ID'sini al
        var columnNumber = checkboxId.replace('vischk', ''); // ID'deki rakamı al
        var column = tables.column(columnNumber); // Sütunu bul
        column.visible($(checkbox).is(':checked')); // Görünürlüğü ayarla
    }
    $('.form-check-input').on('change', function() {
        toggleColumnVisibility(this);
    });
  });



  document.addEventListener("DOMContentLoaded", function () {
    const mezunEtButton = document.getElementById("graduate");
    const mezunEtModal = new bootstrap.Modal(
      document.getElementById("graduateModal")
    );

    mezunEtButton.addEventListener("click", function () {
      mezunEtModal.show();
      setTimeout(function () {
        mezunEtModal.hide();
      }, 3000);
    });
  });
