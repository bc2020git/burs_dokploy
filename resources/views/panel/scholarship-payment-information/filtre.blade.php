<script>
    // sutun cift tiklama ile yonlendirmme
    $(document).on('dblclick', '.redirect-row', function() {
    const candidateId = $(this).data('id');
    const url = "{{ route('burs-odeme-duzenle', ['id' => ':id']) }}".replace(':id', candidateId);
    window.location.href = url;
});
</script>
@php
$tableId = 'paymentInfoTable';
$dataurl = route('paymentlist.data');
$tableColumns = '';
$checkboxInitiliazer = <<<'JS'
    return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-id="' + row.id + '" value="' + row.id + '"  data-firstname="' + (row.ad || '') + '" data-lastname="' + (row.soyad || '') + '" data-phone="' + (row.tel_no || '') + '" data-email="' + (row.email || '') + '">';
JS;
@endphp
@include('panel.includes.scriptf',
[
    'tableId' => $tableId,
    'dataurl' => $dataurl,
    'tableColumns' => $tableColumns,
    'checkboxInitiliazer' => $checkboxInitiliazer
]
)
@include('panel.includes.word-export',
[
    'tableId' => $tableId
])
