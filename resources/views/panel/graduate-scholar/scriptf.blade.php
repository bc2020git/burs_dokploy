<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
const candidateId = $(this).find('input[type="checkbox"]:first').data('id');
    const url = "{{ route('panel-mezun-bursiyer-incele', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
</script>
@php
$tableId = 'graduateTable';
$dataurl = route('mezunlar.data');
$tableColumns = '';
$checkboxInitiliazer = <<<'JS'
    return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-id="' + row.form_id + '" value="' + row.form_id + '"  data-firstname="' + row.name + '" data-lastname="' + row.surname + '" data-phone="' + row.tel_no + '" data-email="' + row.email + '">';
JS;
@endphp
@include('panel.includes.scriptf', [
    'tableId' => $tableId,
    'dataurl' => $dataurl,
    'tableColumns' => $tableColumns,
    'checkboxInitiliazer' => $checkboxInitiliazer,
    'mezunServerExcelExport' => true,
])
@include('panel.includes.word-export',
[
    'tableId' => $tableId
])

