document.addEventListener("DOMContentLoaded", () => {
  function initializeDataTable(tableId) {
      const tableElement = document.getElementById(tableId);
      if (tableElement) {
          const table = $(`#${tableId}`).DataTable({
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
                    </svg>`
                  }
              }
          });

          // DataTables arama kutusu gizle
          document.querySelector('.dataTables_filter').style.display = 'none';

          // Özel buton ile arama 
          document.getElementById('search').addEventListener('click', () => {
              const searchValue = prompt("Aramak istediğiniz kelimeyi girin:");
              table.search(searchValue).draw();
          });

          // Tümünü Seç işlevi
          $('#selectAll').on('click', function () {
              var rows = table.rows({ 'search': 'applied' }).nodes();
              $('input[type="checkbox"]', rows).prop('checked', this.checked);
              if (this.checked) {
                  $(rows).addClass('selected');
              } else {
                  $(rows).removeClass('selected');
              }
          });

          $(`#${tableId} tbody`).on('change', 'input[type="checkbox"]', function () {
              var $row = $(this).closest('tr');
              if (this.checked) {
                  $row.addClass('selected');
              } else {
                  $row.removeClass('selected');
              }

              var allCheckboxes = $(`#${tableId} tbody input[type="checkbox"]`);
              var allChecked = true;
              allCheckboxes.each(function () {
                  if (!this.checked) {
                      allChecked = false;
                  }
              });
              $('#selectAll').prop('checked', allChecked);
          });

          // Satır tıklama olayı
          $(`#${tableId} tbody`).on('click', 'tr', function () {
              var basvuruDurumu = $(this).find("td:nth-child(8) span").text();
              var uyeStatusu = $(this).find("td:nth-child(9) span").text();

              if (basvuruDurumu === "Onay Bekliyor" || uyeStatusu === "Aday") {
                  window.location.href = "memberList-personCard-member.html";
              } else if (basvuruDurumu === "Onaylandı" || uyeStatusu === "Üye") {
                  window.location.href = "memberList-personCard-member-show.html";
              }
          });

          // Düzenle butonu yönlendirme
          $(document).on('click', '.edit-member-info-btn', function (event) {
              event.stopPropagation();
              window.location.href = '/view-admin-members/edit-member-list.html';
          });
      }
  }

  initializeDataTable('memberTable');
  initializeDataTable('scholarTable');
});
