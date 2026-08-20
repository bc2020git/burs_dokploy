<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('kayitYenilemeDetayYonlendir', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});

</script>
@php
$tableId = 'registrationRenewalTable';
$dataurl = route('kayityenileme.data');
$tableColumns = '';
$checkboxInitiliazer = <<<'JS'
    return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-export-id="' + row.form_id + '"	 data-id="' + row.id + '" value="' + row.id + '" data-name="' + row.name + '" data-surname="' + row.surname + '" data-phone="' + row.tel_no + '" data-email="' + row.email + '">';
JS;
@endphp
@include('panel.includes.scriptf', [
    'tableId' => $tableId,
    'dataurl' => $dataurl,
    'tableColumns' => $tableColumns,
    'checkboxInitiliazer' => $checkboxInitiliazer,
    'renewServerExcelExport' => true,
])

@include('panel.includes.word-export', [
    'tableId' => $tableId
])
