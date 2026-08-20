const candidates = [

];

const candidateTableBody = document.getElementById("candidateTableBody");

candidates.forEach((candidate) => {
    const row = document.createElement("tr");



    row.innerHTML = rowInnerHTML;
//seçenekler harici satur tıklama
    row.querySelectorAll("td").forEach((cell, index) => {
        if (index !== 9) {
            cell.addEventListener("click", () => {
                window.location.href = "/admin/candidate-update-details.html";
            });
        }
    });
    candidateTableBody.appendChild(row);
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
var table = $("#candidateTable").DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            title: 'Aday Bursiyerler',
        },{extend: 'pdfHtml5',title: 'Aday Bursiyerler',}
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
    columnDefs: [
        { orderable: false, targets: 1 },
        { orderable: false, targets: '_all' }
    ],
});
$('#excelexportbtn').on('click', function() {
    table.button('.buttons-excel').trigger();
});
$('#pdfButton').on('click', function() {
    table.button('.buttons-pdf').trigger();
});


