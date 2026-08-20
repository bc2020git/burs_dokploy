document.addEventListener("DOMContentLoaded", function () {
  const students = [

  ];

  const graduateTableBody = document.getElementById("graduateTableBody");

  students.forEach((student) => {
    const row = document.createElement("tr");

    const actionButtonHTML =
      student.id === "001" || student.id === "004" || student.id === "006"
        ? `<button class="btn" onclick="location.href='/admin/send-sms.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-student-info-btn" onclick="location.href='/admin/active-scholarship-details.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`
        : `<button class="btn"  onclick="location.href='/admin/send-mail.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-student-info-btn" onclick="location.href='/admin/active-scholarship-details.html'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`;

    const rowInnerHTML = `
              <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
              <td><img src="${student.profil}" width="50"></td>
              <td>${student.id}</td>
              <td>${student.bursBaslangic}</td>
              <td>${student.ad}</td>
              <td>${student.soyad}</td>
              <td>${student.okulAdi}</td>
              <td>${student.sinif}</td>
              <td>${student.bolum}</td>
              <td><span class="${getBadgeClass(student.bursDurumu)}">${student.bursDurumu}</span></td>
              <td>${actionButtonHTML}</td>
          `;

    row.innerHTML = rowInnerHTML;
    graduateTableBody.appendChild(row);
  });

  function getBadgeClass(status) {
    switch (status) {
      case "Aktif Bursiyer":
        return "status-box-success";
      case "Aday Bursiyer":
        return "status-box-warning";
      case "Pasif Bursiyer":
        return "status-box-danger";
      default:
        return "";
    }
  }



// Satır tıklama olayı
$("#graduateTable tbody").on("click", "tr", function () {
});

$("#graduateTable tbody").on("click", "td:nth-child(11),td:nth-child(1), input[type='checkbox']", function (e) {
  e.stopPropagation();
});


let tables;

// Sütun görünürlüğü fonksiyonu
function toggleColumnVisibility(checkbox) {
    var checkboxId = $(checkbox).attr('id');
    var columnNumber = checkboxId.replace('vischk', '');
    var column = tables.column(columnNumber);
    column.visible($(checkbox).is(':checked'));
}
});

document.addEventListener("DOMContentLoaded", function () {
    $('#search').on('click', function() {
        $('#graduateTable_filter label').toggleClass('d-none');
    });

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
