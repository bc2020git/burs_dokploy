
@php
$tableId = 'userTable';
$dataurl = route('users.data');
$tableColumns = '';
$checkboxInitiliazer = <<<'JS'
    return '<input type="checkbox" name="userCheckbox" class="form-check-input user-checkbox" data-id="' + row.id + '" value="' + row.id + '"  data-firstname="' + row.name + '" data-lastname="' + row.surname + '" data-phone="' + row.tel_no + '" data-email="' + row.email + '">';
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
