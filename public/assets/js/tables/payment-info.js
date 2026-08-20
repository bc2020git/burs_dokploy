document.addEventListener("DOMContentLoaded", function () {
    const data = [
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        },
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        },
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        },
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        },
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        },
        {
            tcKimlikNo: "12345678900",
            depremOdemesi: "---",
            barinmaBursu: "Evet",
            sosyalDestekBursu: "---",
            okulTipi: "Ortaokul",
            ad: "Canan",
            soyad: "Tan",
            donem: "2018-2019",
            iban: "TR01001021...",
            bursveren: "Umut Yeşil",
            bursAyi: "Mayıs",
            odemePeriyodu: "1.Taksit",
            odemeTutari: "750 TL",
            odemeTarihi: "19.07.2019",
            ogrenciyeBursOdemeTarihi: "19.07.2019"
        }
        

    ];

    const tableBody = document.getElementById("paymentInfoTableBody");

    data.forEach(item => {
        const row = document.createElement("tr");
        
        for (let key in item) {
            const cell = document.createElement("td");
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
