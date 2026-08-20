<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('detail-bank', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
</script>
<script>



    $(document).ready(function() {
        let dtColumns = [
            // Checkbox sütununu güncelle
            {
                data: null,
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<input type="checkbox"
                        class="checkbox"
                        value="${row.id}"
                        data-id="${row.id}"
                        name="userCheckbox"
                        data-firstname="${row.ad}"
                        data-lastname="${row.soyad}"
                        data-phone="${row.tel_no}"
                        data-email="${row.email}">`;
                }
            }
        ];
        function getNestedValue(obj, path) {
            return path.split('.').reduce((current, key) =>
                current ? current[key] : '', obj);
        }
        // Diğer sütunları ekle
        Object.values(columns).forEach(function(column) {
            if (column.visible === false) {
                return;
            }
            let columnDef = {
                data: null,
                name: column.name,
                render: function(data, type, row) {
                    if (type === 'display' && column.visible === true) {
                        switch(column.name) {
                            case 'checkbox':
                                return data;
                            case 'doc_fotograf':
                                if (row['doc_fotograf']) {
                                    return `<img class="rounded-circle" src="{{url('')}}${row['doc_fotograf']}" alt="Profil" style="width:50px; height:50px">`;
                                } else {
                                    return `<img class="rounded-circle" src="{{url('')}}/assets/images/default-profile.svg" alt="Profil" style="width:50px; height:50px">`;
                                }


                            case column.name.match(/^bv_/)?.input:
                                return getBursStatus(row[column.name]);
                            case 'okul_tipi':
                                return getEducationType(row.okul_tipi);
                            case 'form.islemi_yapan':
                                return row.scholar?.form?.[0]?.islemi_yapan || '';
                            case 'odeme_durumu':
                                return getStatus(row.odeme_durumu);
                            case 'educationType':
                                return getEducationType(row.educationType);
                            case 'form.scholar.aday_id':
                                return row.form?.scholar?.aday_id || '';
                            case 'ogrenciye_burs_odeme_tarihi':
                                return row.ogrenciye_burs_odeme_tarihi ? moment(row.ogrenciye_burs_odeme_tarihi).format('DD.MM.YYYY') : '';
                            default:
                                if (column.name.includes('.')) {
                                    return getNestedValue(row, column.name) || '';
                                }
                                return row[column.name] || '';
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });
        function getBursStatus(value) {
            if (value === 1 || value === '1') {
                return '<span class="status-box-success">Evet</span>';
            } else if (value === 0 || value === '0') {
                return '<span class="status-box-danger">Hayır</span>';
            }
            return '';
        }
        function getStatus(status){
            switch(status){
                case 'Odendi': return '<span class="badge bg-success">Ödendi</span>'; break;
                case 'Beklemede': return '<span class="badge bg-warning">Beklemede</span>'; break;


            }
        }
        function getEducationType(type){
            switch(type){
                case 'ilkokul': return 'İlkokul'; break;
                case 'ortaokul': return 'Ortaokul'; break;
                case 'lise': return 'Lise'; break;
                case 'onlisans': return 'Ön Lisans'; break;
                case 'lisans': return 'Lisans'; break;
                case 'yukseklisans': return 'Yüksek Lisans'; break;
                case 'doktora': return 'Doktora'; break;
                default: return type;
            }
        }
        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                var url = "{{ route('detail-bank', ['id' => ':id']) }}".replace(':id', row.id);
                if (type === 'display') {
                    return `

                        <a href="${url}" class="btn btn-sm edit-member">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3L3 13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89L21 19.89V21.89L3 21.89L3 19.89Z" fill="#636363"/>
                            </svg>
                        </a>
                    `;
                }
                return '';
            }
        });


        // DataTable tanımlaması
        table = $('#bankTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('banks.data') }}",
                type: 'GET',
                data: function(d) {
                    d.filters = filters;
                    if (currentSort.column) {
                        d.order = [{
                            column: currentSort.column,
                            dir: currentSort.direction
                        }];
                    }
                    return d;
                },
                error: function (xhr, error, thrown) {
                    // Hata durumunda 3 kez yeniden deneme yap
                    let retryCount = 0;
                    const maxRetries = 3;
                    const retryDelay = 1000; // 1 saniye bekle

                    function retryAjax() {
                        if (retryCount < maxRetries) {
                            retryCount++;
                            setTimeout(function() {
                                table.ajax.reload(null, false); // false parametresi sayfayı aynı konumda tutar
                            }, retryDelay);
                        }
                    }

                    retryAjax();
                }
            },
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('redirect-row cursor-pointer ')
                    .attr('data-id', data.id);
            },
            columns: dtColumns,
            lengthMenu: [[10, 25, 50, 100 , 250 , 500], [10, 25, 50, 100 , 250 ,500]],
            pageLength: 10,
            ordering: true,
            autoWidth: false,
            scrollX: true,
            scrollCollapse: true,
            orderCellsTop: true,
            order: [],
            initComplete: function() {
                // Tablo yüklendikten sonra sütun görünürlüklerini uygula
                loadColumnVisibility();
            },
            columnDefs: [
                {
                    targets: '_all',
                    orderable: false
                }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:not(:first-child)',
                        rows: function(idx, data, node) {
                            const selectedRows = $('.checkbox:checked');
                            if (selectedRows.length > 0) {
                                return $(node).find('.checkbox').prop('checked');
                            }
                            return true;
                        }
                    }
                }
            ],
            language: {
                url: '{{url('')}}/public/build/js/dataTables/tr.json',

                paginate: {
                previous: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                         '<path d="M14.4142 12L19.2071 7.20712L17.7929 5.79291L11.5858 12L17.7929 18.2071L19.2071 16.7929L14.4142 12ZM7.5 18V6.00001H9.5V18H7.5Z" fill="#636363"></path>' +
                         '</svg>',
                next: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">' +
                      '<path d="M10.5858 12L5.79291 16.7929L7.20712 18.2071L13.4142 12L7.20712 5.79291L5.79291 7.20712L10.5858 12ZM17.5 6.00002V18H15.5V6.00002H17.5Z" fill="#636363"></path>' +
                      '</svg>'
            }},
        });


 // Export butonları için event listener'lar
 $(document).ready(function() {
        // Excel export
        $('#excelButton').on('click', function() {
            exportTable('excel');
        });

        // PDF export
        $('#pdfButton').on('click', function() {
            exportTable('pdf');
        });

        // CSV export
        $('#csvButton').on('click', function() {
            exportTable('csv');
        });

        // Export fonksiyonu
        function exportTable(type) {
            // Seçili satırları al
            const selectedRows = $('.checkbox:checked');
            const selectedIndexes = [];

            // Seçili satırların indexlerini topla
            if (selectedRows.length > 0) {
                selectedRows.each(function() {
                    const row = $(this).closest('tr');
                    const rowIdx = table.row(row).index();
                    selectedIndexes.push(rowIdx);
                });
            }

            // Export seçeneklerini ayarla
            const exportOptions = {
                columns: ':visible:not(:first-child)', // Checkbox sütununu hariç tut
                rows: function(idx, data, node) {
                    if (selectedRows.length > 0) {
                        return selectedIndexes.includes(idx);
                    }
                    return true;
                }
            };

            // Export işlemini gerçekleştir
            switch(type) {
                case 'excel':
                    table.button('.buttons-excel').trigger();
                    break;
                case 'pdf':
                    table.button('.buttons-pdf').trigger();
                    break;
                case 'csv':
                    table.button('.buttons-csv').trigger();
                    break;
            }
        }
    });

    });


</script>


<script>
    $(document).ready(function() {
        function submitForm(redirectUrl = null) {
            // Form verilerini al
            let formData = {};
            var bankaAdiValue = document.getElementById('bankaAdi').value;
            var bankaKoduValue = document.getElementById('bankaKodu').value;
            formData['bankaAdi'] = bankaAdiValue;
            formData['bankaKodu'] = bankaKoduValue;

            // AJAX isteği
            $.ajax({
                url: '/panel/Banka-Ekle',
                type: 'POST',
                data: {
                    formData: formData,
                    _token: '{{ csrf_token() }}' // Laravel'de CSRF koruması için
                },
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        // Başarılı mesaj
                        iziToast.success({
                            title: 'İşlem Başarılı',
                            message: 'Banka Eklendi', // Assuming response.success contains the success message
                        });                        // İşlem başarılıysa yönlendirme veya sayfada kalma
                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'İşlem Başarısız',
                        message: 'Ssitemde kayıtlı olan veriyi girdiniz. Yeni Kayıt Deneyiniz!', // Assuming response.success contains the success message
                    });
                    console.error("AJAX Hatası:", status, error);
                    console.error("Hata Detayları:", xhr.responseText);

                    // Hata durumunda toastr ile mesaj göster
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Bir hata oluştu.');
                    }
                }
            });
        }

        // "Kaydet" butonuna tıklanınca
        $('#kaydetBtn').click(function() {
            submitForm();
        });
        // "Kaydet ve Kapat" butonuna tıklanınca
        $('#kaydetVeKapatBtn').click(function() {
            submitForm('/panel/Bankalar');
        });
    });
</script>
