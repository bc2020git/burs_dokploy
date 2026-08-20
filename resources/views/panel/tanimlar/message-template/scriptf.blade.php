<script>
    // Quill.js editörleri
    let quill, quillEdit;

    // Parametre yönetimi
    function addParameter(containerId, inputName) {
        const container = document.getElementById(containerId);
        const div = document.createElement('div');
        div.className = 'mb-2 parameter-item';
        div.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control parameter-input" placeholder="Parametre adı">
                <button type="button" class="btn btn-outline-danger btn-sm remove-parameter">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        `;
        container.appendChild(div);

        // Silme butonuna event listener ekle
        div.querySelector('.remove-parameter').addEventListener('click', function() {
            div.remove();
            updateParametersInput(containerId, inputName);
        });
    }

    function updateParametersInput(containerId, inputName) {
        const container = document.getElementById(containerId);
        const inputs = container.querySelectorAll('.parameter-input');
        const parameters = [];

        inputs.forEach(input => {
            if (input.value.trim()) {
                parameters.push(input.value.trim());
            }
        });

        document.getElementById(inputName).value = JSON.stringify(parameters);
    }

    // Slug otomatik oluşturma
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/ğ/g, 'g')
            .replace(/ü/g, 'u')
            .replace(/ş/g, 's')
            .replace(/ı/g, 'i')
            .replace(/ö/g, 'o')
            .replace(/ç/g, 'c')
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
    }

    $(document).ready(function() {
        // Quill.js editörlerini başlat
        quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        quillEdit = new Quill('#quill-editor-edit', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        // Başlık değiştiğinde slug otomatik oluştur
        $('#title').on('input', function() {
            const title = $(this).val();
            const slug = generateSlug(title);
            $('#slug').val(slug);
        });

        $('#edit_title').on('input', function() {
            const title = $(this).val();
            const slug = generateSlug(title);
            $('#edit_slug').val(slug);
        });

        // Parametre ekleme butonları
        $('#add-parameter').click(function() {
            addParameter('parameters-container', 'parameters');
        });

        $('#edit-add-parameter').click(function() {
            addParameter('edit-parameters-container', 'edit_parameters');
        });

        // Parametre inputlarına event listener
        $(document).on('input', '.parameter-input', function() {
            const containerId = $(this).closest('[id$="-container"]').attr('id');
            const inputName = containerId.includes('edit') ? 'edit_parameters' : 'parameters';
            updateParametersInput(containerId, inputName);
        });

        // Form submit işlemleri
        $('#createMessageTemplateForm').on('submit', function(e) {
            e.preventDefault();

            // Quill içeriğini hidden input'a aktar
            const content = quill.root.innerHTML;
            $('#content').val(content);

            // Parametreleri güncelle
            updateParametersInput('parameters-container', 'parameters');

            this.submit();
        });

        $('#editMessageTemplateForm').on('submit', function(e) {
            e.preventDefault();

            // Quill içeriğini hidden input'a aktar
            const content = quillEdit.root.innerHTML;
            $('#edit_content').val(content);

            // Parametreleri güncelle
            updateParametersInput('edit-parameters-container', 'edit_parameters');

            const formData = new FormData(this);
            const id = $('#edit_id').val();

            $.ajax({
                url: `/panel/message-template/${id}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editMessageTemplateModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Hata:', xhr.responseText);
                }
            });
        });

        // DataTable sütun tanımları
        let dtColumns = [
            {
                data: null,
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<input type="checkbox" class="checkbox" value="${row.id}" data-id="${row.id}" name="userCheckbox">`;
                }
            }
        ];

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
                            case 'parameters':
                                if (row[column.name]) {
                                    const params = JSON.parse(row[column.name]);
                                    return params.length > 0 ? params.join(', ') : 'Yok';
                                }
                                return 'Yok';
                            default:
                                return row[column.name] || '';
                        }
                    }
                    return data;
                }
            };
            dtColumns.push(columnDef);
        });

        // İşlemler sütununu ekle
        dtColumns.push({
            data: null,
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                if (type === 'display') {
                    return `
                        <button class="btn btn-sm btn-primary edit-template" data-id="${row.id}">
                            <i class="ri-edit-line"></i> Düzenle
                        </button>
                        <button class="btn btn-sm btn-danger delete-template" data-id="${row.id}">
                            <i class="ri-delete-bin-line"></i> Sil
                        </button>
                    `;
                }
                return data;
            }
        });

        // DataTable başlat
        let table = $('#candidateTable').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: '{{ route("message-template.data") }}',
                type: 'GET'
            },
            columns: dtColumns,
            pageLength: 25,
            language: {
                url: '//datatables-cdn.com/plug-ins/1.13.7/i18n/tr.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        // Düzenleme butonu
        $(document).on('click', '.edit-template', function() {
            const id = $(this).data('id');

            $.ajax({
                url: `/panel/message-template/${id}/edit`,
                method: 'GET',
                success: function(response) {
                    // Form alanlarını doldur
                    $('#edit_id').val(response.item.id);
                    $('#edit_title').val(response.item.title);
                    $('#edit_slug').val(response.item.slug);

                    // Quill editörüne içeriği yükle
                    quillEdit.root.innerHTML = response.item.content || '';

                    // Parametreleri yükle
                    const parametersContainer = document.getElementById('edit-parameters-container');
                    parametersContainer.innerHTML = '';

                    if (response.item.parameters && response.item.parameters.length > 0) {
                        response.item.parameters.forEach(param => {
                            const div = document.createElement('div');
                            div.className = 'mb-2 parameter-item';
                            div.innerHTML = `
                                <div class="input-group">
                                    <input type="text" class="form-control parameter-input" value="${param}" placeholder="Parametre adı">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-parameter">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            `;
                            parametersContainer.appendChild(div);

                            div.querySelector('.remove-parameter').addEventListener('click', function() {
                                div.remove();
                                updateParametersInput('edit-parameters-container', 'edit_parameters');
                            });
                        });
                    }

                    // Form action'ını ayarla
                    $('#editMessageTemplateForm').attr('action', `/panel/message-template/${id}`);

                    // Modal'ı aç
                    $('#editMessageTemplateModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Hata:', xhr.responseText);
                }
            });
        });

        // Silme butonu
        $(document).on('click', '.delete-template', function() {
            const id = $(this).data('id');

            if (confirm('Bu mesaj şablonunu silmek istediğinizden emin misiniz?')) {
                $.ajax({
                    url: `/panel/message-template/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        console.error('Hata:', xhr.responseText);
                    }
                });
            }
        });

        // Toplu silme
        $('#waste5').click(function(e) {
            e.preventDefault();
            if (checkleng()) {
                islemIcinDiziGonder(3);
            } else {
                alert('Lütfen en az bir kayıt seçin.');
            }
        });

        // Yenile butonu
        $('#reload').click(function(e) {
            location.reload();
        });

        // Export butonları
        $('#pdfButton').on('click', function() {
            table.button('.buttons-pdf').trigger();
        });

        $('#excelexportbtn').on('click', function() {
            table.button('.buttons-excel').trigger();
        });
    });

    // Yardımcı fonksiyonlar
    function checkleng() {
        const selectedCheckboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');
        return selectedCheckboxes.length > 0;
    }

    function selectAll(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]');
        checkboxes.forEach(function(cb) {
            cb.checked = checkbox.checked;
        });
    }

    function islemIcinDiziGonder(islemid) {
        const selectedUserIds = [];
        const checkboxes = document.querySelectorAll('input[name="userCheckbox"]:checked');

        checkboxes.forEach(checkbox => {
            const userId = checkbox.getAttribute('data-id');
            if (userId) {
                selectedUserIds.push(userId);
            }
        });

        const islemId = islemid;

        $.ajax({
            url: '{{ route("message-template.bulk-action") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ids: selectedUserIds,
                islemId: islemId,
            },
            success: function(response) {
                console.log('Veriler gönderildi:', response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", status, error);
                console.error("Hata Detayları:", xhr.responseText);
            }
        });
    }
</script>
