document.addEventListener("DOMContentLoaded", function () {
const data = [
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Barınma",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Ocak",
        odemePeriyodu: "1. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.01.2019",
        ogrenciyeBursOdemeTarihi: "19.01.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Sosyal Destek",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Şubat",
        odemePeriyodu: "2. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.02.2019",
        ogrenciyeBursOdemeTarihi: "19.02.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Deprem",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Mart",
        odemePeriyodu: "3. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.03.2019",
        ogrenciyeBursOdemeTarihi: "19.03.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Barınma",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Nisan",
        odemePeriyodu: "4. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.04.2019",
        ogrenciyeBursOdemeTarihi: "19.04.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Sosyal Destek",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Mayıs",
        odemePeriyodu: "5. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.05.2019",
        ogrenciyeBursOdemeTarihi: "19.05.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Deprem",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Haziran",
        odemePeriyodu: "6. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.06.2019",
        ogrenciyeBursOdemeTarihi: "19.06.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Barınma",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Temmuz",
        odemePeriyodu: "7. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.07.2019",
        ogrenciyeBursOdemeTarihi: "19.07.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Sosyal Destek",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Ağustos",
        odemePeriyodu: "8. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.08.2019",
        ogrenciyeBursOdemeTarihi: "19.08.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Deprem",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Eylül",
        odemePeriyodu: "9. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.09.2019",
        ogrenciyeBursOdemeTarihi: "19.09.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Barınma",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Ekim",
        odemePeriyodu: "10. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.10.2019",
        ogrenciyeBursOdemeTarihi: "19.10.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Sosyal Destek",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Kasım",
        odemePeriyodu: "11. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.11.2019",
        ogrenciyeBursOdemeTarihi: "19.11.2019",
        odemeDurumu: "Ödendi"
    },
    {
        tcKimlikNo: "12345678900",
        bursTipi: "Deprem",
        okulTipi: "Ortaöğretim",
        ad: "Canan",
        soyad: "Tan",
        donem: "2018-2019",
        iban: "TR01001021...",
        bursveren: "Umut Yeşil",
        bursAyi: "Aralık",
        odemePeriyodu: "12. Taksit",
        odemeTutari: "750 TL",
        odemeTarihi: "19.12.2019",
        ogrenciyeBursOdemeTarihi: "19.12.2019",
        odemeDurumu: "Ödendi"
    }
];


    function getBadgeClass(status) {
        switch (status) {
            case "Ödendi":
                return "status-box-success";
            case "Ödenmedi":
                return "status-box-danger";
            default:
                return "status-box-secondary";
        }
    }

    const tableBody = document.getElementById("paymentInfoTableBody");

    data.forEach(item => {
        const row = document.createElement("tr");
        
        const checkboxCell = document.createElement("td");
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "checkbox";
        checkboxCell.appendChild(checkbox);
        row.appendChild(checkboxCell);

        for (let key in item) {
            const cell = document.createElement("td");

            if (key === "odemeDurumu") {
                cell.classList.add(getBadgeClass(item[key]));
            }

            cell.textContent = item[key];
            row.appendChild(cell);
        }

        tableBody.appendChild(row);
    });

    // DataTable başlat
    $("#paymentInfoTable").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        scrollX:true,
        dom: '<"top"t><"bottom"lfi><"bottom"p><"clear">',
        language: {
          lengthMenu: "Göster _MENU_ kayıt",
          zeroRecords: "Kayıt bulunamadı",
          info: "Gösterilen _END_ kayıt, toplam _TOTAL_ kayıt içinden",
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
});
