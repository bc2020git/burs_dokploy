document.addEventListener("DOMContentLoaded", function () {
    const banks = [

      ];

  const bankTableBody = document.getElementById("bankTableBody");

  banks.forEach((bank, index) => {
      const row = document.createElement("tr");

      const actionButtonHTML =
          bank.plakaNo === "01" || bank.plakaNo === "04" || bank.plakaNo === "06"
              ? `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M5.76282 17L20 17L20 5L4 5L4 18.3851L5.76282 17ZM6.45455 19L2 22.5L2 4C2 3.44772 2.44772 3 3 3L21 3C21.5523 3 22 3.44772 22 4L22 18C22 18.5523 21.5523 19 21 19L6.45455 19Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-bank-info-btn" data-index="${index}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`
              : `<button class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M3 3L21 3C21.5523 3 22 3.44772 22 4L22 20C22 20.5523 21.5523 21 21 21L3 21C2.44772 21 2 20.5523 2 20L2 4C2 3.44772 3 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594L4 19L20 19L20 7.23792ZM4.51146 5L12.0619 11.662L19.501 5L4.51146 5Z" fill="#636363"/>
              </svg></button>
              <button class="btn edit-bank-info-btn" data-index="${index}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                  <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
              </svg></button>`;

      const rowInnerHTML = `
          <td><input type="checkbox" class="checkbox" id="masterCheckbox"></td>
          <td>${bank.bankaAd}</td>
          <td>${bank.bankaKod}</td>
          <td>${actionButtonHTML}</td>
      `;

      row.innerHTML = rowInnerHTML;

          // Satır tıklama olayı
    row.addEventListener("click", function () {
      window.location.href = "/admin/bank-details.html";
    });

    row
      .querySelectorAll(
        "td:nth-child(4),td:nth-child(1), input[type='checkbox']"
      )
      .forEach((cell) => {
        cell.addEventListener("click", function (e) {
          e.stopPropagation();
        });
      });
      bankTableBody.appendChild(row);
  });

  // Düzenleme butonuna tıklama
  $(document).on('click', '.edit-bank-info-btn', function () {
      const index = $(this).data('index');
      const selectedBank = banks[index];
      localStorage.setItem('selectedBank', JSON.stringify(selectedBank));
      window.location.href = '/admin/bank-details.html';
  });


});
