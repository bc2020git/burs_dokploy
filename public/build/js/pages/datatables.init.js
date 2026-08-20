/*
Template Name: Tocly -  Admin & Dashboard Template
Author: Themesdesign
Contact: themesdesign.in@gmail.com
File: Datatables Js File
*/

$(document).ready(function() {
    $('#datatable').DataTable({
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }

    });

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },
        "info": false,
        "paging": false,
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'colvis',
                text: 'Görünürlük',
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible'
                },
                text: "Excel'e Aktar",
            }, {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: "Pdf'e Aktar",
            },
        ],
        'ordering': true,
        'searching': true,
        "serverSide": false,
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

        $(".dataTables_length select").addClass('form-select form-select-sm');

    // Multi Selection Datatable
    $('#selection-datatable').DataTable({
        select: {
            style: 'multi'
        },
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "İleri": "<i class='mdi mdi-chevron-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Key Datatable
    $('#key-datatable').DataTable({
        keys: true,
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "İleri": "<i class='mdi mdi-chevron-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

            $(".dataTables_length select").addClass('form-select form-select-sm');


    // Alternative Pagination Datatable
    $('#alternative-page-datatable').DataTable({
        "pagingType": "full_numbers",
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $(".dataTables_length select").addClass('form-select form-select-sm');

        }
    });

    // Scroll Vertical Datatable
    $('#scroll-vertical-datatable').DataTable({
        "scrollY":        "350px",
        "scrollCollapse": true,
        "paging":         false,
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "İleri": "<i class='mdi mdi-chevron-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Complex headers with column visibility Datatable
    $('#complex-header-datatable').DataTable({
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "İleri": "<i class='mdi mdi-chevron-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $(".dataTables_length select").addClass('form-select form-select-sm');
        },
        "columnDefs": [ {
            "visible": false,
            "targets": -1
        } ]
    });

    // State Saving Datatable
    $('#state-saving-datatable').DataTable({
        stateSave: true,
        "language": {
            "paginate": {
                "previous": "<i class='mdi mdi-chevron-left'>",
                "İleri": "<i class='mdi mdi-chevron-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $(".dataTables_length select").addClass('form-select form-select-sm');
        }
    });
} );
