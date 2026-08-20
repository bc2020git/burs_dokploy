<?php
/**
 * Usage Example for ApplicationFormModal Component
 *
 * This file shows how to use the ApplicationFormModal component
 * in your Blade templates.
 */
?>

<!-- Basic Usage Example -->
<x-application-form-modal
    :candidate="$aday"
    :siblings="$kardesler"
    :scholarships="$digerBurslar"
/>

<!-- Advanced Usage Example with all parameters -->
<x-application-form-modal
    :candidate="$aday"
    :siblings="$kardesler"
    :scholarships="$digerBurslar"
    :period="$period"
    :cities="$cities"
/>

<!-- Example Controller Code -->
<?php
/*
public function index()
{
    // Prepare candidate data
    $aday = (object) [
        'id' => 1,
        'name' => 'Ahmet',
        'surname' => 'Yılmaz',
        'tc_no' => '12345678901',
        'email' => 'ahmet@example.com',
        'tel_no' => '0532 123 45 67',
        'sube' => 'İstanbul',
        'aday_turu' => 'Dernek',
        'b_dob' => '1995-01-15',
        'born_city' => 'İstanbul',
        'born_district' => 'Kadıköy',
        'registered_city' => 'İstanbul',
        'registered_district' => 'Kadıköy',
        'gender' => 'Erkek',
        'maritality' => 'Bekar',
        'nationality' => 'Türkiye',
        'educationType' => 'lisans',
        'current_university' => 'İstanbul Üniversitesi',
        'grade_departmant' => 'Bilgisayar Mühendisliği',
        'university_class' => '3',
        'agno' => '3.25',
        'mother_salary' => '5000',
        'father_salary' => '7000',
        'other_salary' => '0',
        'other_income' => 'Hayır',
        'residing_city' => 'İstanbul',
        'residing_district' => 'Üsküdar',
        'address_detail' => 'Örnek Mahalle, Örnek Sokak No:5 Daire:3',
        'check_taahhutname' => 'on',
        'check_ailebireyleri' => 'on',
        'check_acikriza' => 'on',
        'check_aydinlatma' => 'on',
        'check_bilgidogrulama' => 'on'
    ];

    // Prepare siblings data
    $kardesler = [
        (object) [
            'name' => 'Mehmet',
            'surname' => 'Yılmaz',
            'age' => 20,
            'educ_status' => 'Lise',
            'maritality' => 'Bekar',
            'job' => 'Öğrenci'
        ],
        (object) [
            'name' => 'Ayşe',
            'surname' => 'Yılmaz',
            'age' => 25,
            'educ_status' => 'Üniversite',
            'maritality' => 'Evli',
            'job' => 'Mühendis'
        ]
    ];

    // Prepare scholarships data
    $digerBurslar = [
        (object) [
            'company_type' => 'Özel',
            'company_name' => 'ABC Vakfı',
            'count' => '1000'
        ],
        (object) [
            'company_type' => 'Devlet',
            'company_name' => 'Kredi Yurtlar Kurumu',
            'count' => '500'
        ]
    ];

    return view('your-view', compact('aday', 'kardesler', 'digerBurslar'));
}
*/
?>

<!--
Component Props:
- candidate (required): Object containing candidate information
- siblings (optional, default []): Array of sibling objects
- scholarships (optional, default []): Array of scholarship objects
- period (optional): Period object for academic year information
- cities (optional, default []): Array of city objects for dropdowns

The component will automatically:
1. Display a "Başvuru Formu" button that opens the modal
2. Show all candidate information in organized sections
3. Include PDF export functionality with proper A4 formatting
4. Handle Turkish character encoding for PDF generation
5. Apply responsive design for both screen and print media
-->
