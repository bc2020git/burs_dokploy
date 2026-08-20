document.addEventListener("DOMContentLoaded", function () {
    const candidates = [
      {
        profil: "/assets/images/avatar-correct.svg",
        id: "001",
        ad: "Canan",
        soyad: "Tan",
        kyDurumu: "Onaylandı",
        kydonemi: "2021-2020",
  
  
      },
      {
        profil: "/assets/images/avatar-correct.svg",
        id: "002",
        ad: "Canan",
        soyad: "Tan",
        kyDurumu: "Red Edildi",
        kydonemi: "2021-2022",
  
  
      },
      {
        profil: "/assets/images/avatar-correct.svg",
        id: "003",
        ad: "Canan",
        soyad: "Tan",
        telefonNo: "111 111 1111",
        kyDurumu: "Mülakat Bekliyor",
        kydonemi: "2022-2023"
      },
    ];
  
    const studentRegistrationTableBody = document.getElementById("studentRegistrationTableBody");
  
    candidates.forEach((candidate) => {
      const row = document.createElement("tr");
  
      const actionButtonHTML =
        candidate.id === "001" || candidate.id === "004" || candidate.id === "006"
          ? `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
                  </svg></button>
                  <button class="btn edit-candidate-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                  </svg></button>`
          : `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
                  </svg></button>
                  <button class="btn edit-candidate-info-btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                  </svg></button>`;
  
      const rowInnerHTML = `
                  <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
                  <td><img src="${candidate.profil}" width="50"></td>
                  <td>${candidate.id}</td>
                  <td>${candidate.ad}</td>
                  <td>${candidate.soyad}</td>
                  <td><span class="${getBadgeClass(candidate.kyDurumu)}">${candidate.kyDurumu}</span></td>
                  <td>${candidate.kydonemi}</td>
                  <td>${actionButtonHTML}</td>
              `;
  
      row.innerHTML = rowInnerHTML;

    // Satır tıklama olayı
    row.addEventListener("click", function () {
      window.location.href = "/studentRegistrationRenewal/registration-renewal-middle.html";
    });

    row.querySelectorAll("td:nth-child(9),td:nth-child(1), input[type='checkbox']").forEach(cell => {
      cell.addEventListener("click", function (e) {
        e.stopPropagation();
      });
    });

    studentRegistrationTableBody.appendChild(row);
  });
  
    function getBadgeClass(status) {
      switch (status) {
        case "Onaylandı":
          return "status-box-success";
        case "Mülakat Bekliyor":
          return "status-box-warning";
        case "Red Edildi":
          return "status-box-danger";
        default:
          return "status-box-secondary";
      }
    }
  
    // DataTable başlat
    $("#studentRegistrationTable").DataTable({
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
  
  