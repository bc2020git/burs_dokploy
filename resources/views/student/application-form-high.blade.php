@extends('layouts.student.master')
@section('title')
    Başvuru Formu
@endsection
@section('page-title')
    Başvuru Formu
@endsection
@section('local-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


@endsection
@section('body')
@endsection
@section('content')
    <main class="main-content px-3 py-4">
        <div class=" mt-1">
            <div id="application-form-high">
                <h2>Başvuru Formu</h2>
                <div class="main-content-manuel">
                    <div class="step-container">
                        @foreach($kategoriler as $index => $kategori)
                            <div class="step-item @if($index + 1 == 1) active @endif" data-target="{{ $index + 1 }}">
                                <div class="step-number">{{ $index + 1 }}</div> <!-- Dizideki index + 1 olarak gösterilir -->
                                <div class="step-text">{{ $kategori->title }}</div>
                            </div>
                        @endforeach



                    </div>
                    <form>
                        @if(isset( $aday->educationType)) <input type="hidden" id="educationType" value="{{$aday->educationType}}"> @endif
                        @foreach($kategoriler as $index => $kategori)
                        @php
                        switch ($aday->educationType) {
                            case 'ilkokul':
                            case 'ortaokul':
                            case 'lise':
                                $taahutnameModalCheck = true;
                                break;
                            default:
                                $taahutnameModalCheck = false;
                                break;
                        }
                        @endphp
                        <div class="step-content @if($index + 1 == 1) active @endif" id="step-{{ $index + 1 }}" data-content="{{ $index + 1 }}">
                                <div class="row">
                                    <input type="hidden" name="db_table" id="db_table" value="{{$kategori->db_table}}" >
                                    @foreach($kategori->soru as $soru)
                                        @php
                                            $annelokasyon = ['mother_city','mother_district','mother_salary','mother_name','mother_surname','mother_job','mother_company','mother_educ'] ;
                                            $babalokasyon = ['father_city','father_district','father_salary','father_job','father_name','father_surname','father_company','father_educ'] ;
                                        @endphp
                                        @if(in_array($soru->db_key, $annelokasyon) && $aday->{'mother_alive'} == 'Hayır')
                                            @continue
                                        @endif
                                        @if(in_array($soru->db_key, $babalokasyon) && $aday->{'C9l7SUqOxSvZ'} == 'Hayır')
                                            @continue
                                        @endif
                                        @if($soru->type=='text')
                                            <div class="col-md-6 mb-3 ">
                                                <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label>@if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <input @if($soru->required=='Zorunlu') required @endif type="text" @if($soru->disabled=='disabled') disabled @endif value="{{ $aday->{$soru->db_key} }}"   class="form-control" id="{{$soru->db_key}}">
                                            </div>
                                        @endif
                                        @if($soru->type=='number')
                                            <div class="col-md-6 mb-3 @if($soru->disabled == 'disabled') d-none @endif @if($soru->db_key == 'kaSQQWBD3IH2') d-none @endif ">
                                                <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label> @if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <input type="number"
                                                       @if($soru->required=='Zorunlu') required @endif
                                                       @if($soru->disabled=='disabled') disabled @endif
                                                       value="{{ $aday->{$soru->db_key} }}"
                                                       class="form-control number-input"
                                                       id="{{$soru->db_key}}"
                                                       data-scoring-ranges="{{ $soru->scoring_ranges ?? '[]' }}">

                                            </div>
                                        @endif
                                        @if($soru->type=='email')
                                            <div class="col-md-6 mb-3 ">
                                                <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label> @if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <input @if($soru->required=='Zorunlu') required @endif type="email" @if($soru->disabled=='disabled') disabled @endif value="{{ $aday->{$soru->db_key} }}"   class="form-control" id="{{$soru->db_key}}">
                                            </div>
                                        @endif
                                        @if($soru->type=='homephone')
                                            <div class="col-md-6 mb-3 ">
                                                <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label> @if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <input @if($soru->required=='Zorunlu') required @endif type="number" @if($soru->disabled=='disabled') disabled @endif value="{{ $aday->{$soru->db_key} }}"   class="form-control homephone" id="{{$soru->db_key}}">
                                            </div>
                                        @endif
                                        @if($soru->type=='tel')
                                            <div class="col-md-6 mb-3 ">
                                                <label for="{{$soru->db_key}}" class="form-label">{{$soru->title}}</label>@if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <br>
                                                <input @if($soru->required=='Zorunlu') required @endif name="{{$soru->db_key}}" type="tel" style="margin-left: 55px !important;" placeholder="Örn: 5XX XXX XX XX" value="{{ $aday->{$soru->db_key} }}" class="form-control telinputs" id="{{$soru->db_key}}">
                                            </div>
                                            @if($index ==  0)
                                            <div class="col-md-6 mb-3 "></div>
                                            @endif
                                        @endif
                                        @if($soru->type=='date')
                                                <div class="col-md-6 mb-3">
                                                    <div class="date-input-container">
                                                        <label for="{{$soru->db_key}}">{{$soru->title}} @if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif</label>
                                                    @php
                                                        $date = $aday->{$soru->db_key};
                                                        if($date) {
                                                            try {
                                                                // Gelen tarihi Y-m-d formatına çeviriyoruz
                                                                if (preg_match('/^\d{2}[-.]\d{2}[-.]\d{4}$/', $date)) {
                                                                    // DD.MM.YYYY veya DD-MM-YYYY formatını Y-m-d'ye çevir
                                                                    $date = \Carbon\Carbon::createFromFormat('d.m.Y', str_replace('-', '.', $date))->format('Y-m-d');
                                                                } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                                                                    // Diğer formatları parse et
                                                                    $date = \Carbon\Carbon::parse($date)->format('Y-m-d');
                                                                }
                                                            } catch (\Exception $e) {
                                                                $date = $aday->{$soru->db_key};
                                                            }
                                                        }
                                                    @endphp
                                                    <input
                                                        type="text"
                                                        name="{{$soru->db_key}}"
                                                        id="{{$soru->db_key}}"
                                                        class="form-control date-input"
                                                        value="{{ $date }}"
                                                        placeholder="Tarih Seçiniz"
                                                        data-input
                                                        @if($soru->required=='Zorunlu') required @endif
                                                    />
                                                    </div>
                                                </div>
                                        @endif

                                        @if($soru->type=='file' && in_array($soru->db_key, $documents))
                                            <div class="col-md-3 py-1 col-sm-6">
                                                <div class="upload-card">
                                                    <div class="documents-title-drag-drop">
                                                        <p>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"></path>
                                                            </svg> {{$soru->title}}@if($soru->required=='Zorunlu')  <span style="color: red; margin-left: 3px" > *</span> @endif
                                                        </p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"></path>
                                                        </svg>
                                                    </div>
                                                    <div id="uploadedFile{{$soru->db_key}}">
                                                        @if( strlen( $aday->{$soru->db_key})>0 )
                                                            <div class="file-uploaded-document d-flex justify-content-around"
                                                                 data-bs-toggle="modal" data-bs-target="#documentModal">
                                                                <img src="{{url('')}}/assets/images/pdf.svg" alt="pdf">
                                                                <div data-id='{{$soru->db_key}}' class="file-preview" id="deleteButton">
                                                                    <div class="icon-container">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             width="13" height="13" viewBox="0 0 13 13"
                                                                             fill="none">
                                                                            <rect width="12" height="12" rx="6" fill="#00875A" />
                                                                            <path d="M4.56484 5.90345C4.2359 5.57452 3.70259 5.57452 3.37365 5.90345C3.04472 6.23239 3.04472 6.7657 3.37365 7.09463L5.05824 8.77922C5.38717 9.10815 5.92048 9.10815 6.24942 8.77922L9.61858 5.41005C9.94752 5.08111 9.94752 4.5478 9.61858 4.21887C9.28965 3.88993 8.75634 3.88993 8.4274 4.21887L5.65383 6.99245L4.56484 5.90345Z" fill="white" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="file-drag-drop-area">
                                                                <input data-name="{{$soru->db_key}}" @if($soru->required=='Zorunlu') required @endif data-id="{{$soru->db_key}}" @if($soru->db_key != 'doc_fotograf')  accept="application/pdf,.doc,.docx,application/mswo ....................................................................................................................................................... rd,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  @else accept="image/png, image/jpeg" @endif type="file" id="{{$soru->db_key}}" hidden="">
                                                                <label for="{{$soru->db_key}}" class="file-label d-flex align-items-center justify-content-center">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"></path>
                                                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"></path>
                                                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"></path>
                                                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"></path>
                                                                    </svg>
                                                                    <div class="text-container">
                                                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="file-info mt-2">
                                                        <p>Desteklenen Belgeler: jpg, jpeg, png, PDF , Docx</p>
                                                        <p>Max Size: 5 MB, 1 Dosya</p>
                                                    </div>
                                                    <div id="{{$soru->db_key}}" data-id="{{$soru->db_key}}" class="delete-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                                            <path d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V1.875C4.375 1.52983 4.65482 1.25 5 1.25H10C10.3452 1.25 10.625 1.52983 10.625 1.875V3.75ZM5.625 6.875V10.625H6.875V6.875H5.625ZM8.125 6.875V10.625H9.375V6.875H8.125ZM5.625 2.5V3.75H9.375V2.5H5.625Z" fill="#F03000"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($soru->type=='select')
                                            <div class="col-md-6 mb-3">
                                                <label for="{{ $soru->db_key }}">{{ $soru->title }}</label>
                                                @if($soru->required == 'Zorunlu')
                                                    <span style="color: red"> *</span>
                                                @endif
                                                <select data-selected="{{ $aday->{$soru->db_key} }}"  data-dataset="{{ $soru->dataset }}" class="form-select" name="{{ $soru->db_key }}" @if($soru->required == 'Zorunlu') required @endif id="{{ $soru->db_key }}">
                                                    <option value="">Seçiniz</option>
                                                    @php
                                                        $options = json_decode($soru->options, true); // options JSON'u çözüldü
                                                        $points = json_decode($soru->points, true); // points JSON'u çözüldü
                                                        $contradictory = json_decode($soru->is_contradictory, true); // aykırı veriler JSON'u çözüldü
                                                        $selectedValue = isset($aday->{$soru->db_key}) ? $aday->{$soru->db_key} : null;
                                                        $citiesAndDistricts = ['registered_city',
                                                        'registered_city',
                                                        'registered_district',
                                                        'born_city',
                                                        'born_district',
                                                        'mother_city',
                                                        'father_city',
                                                        'h_school_city',
                                                        'p_school_city',
                                                        'm_school_city',
                                                        'm_school_district',
                                                        'p_school_district',
                                                        'h_school_district',
                                                        'p_school_district',
                                                        'm_school_district',

                                                    	];
                                                    @endphp

                                                    @if($options)
                                                        @foreach($options as $index => $option)
                                                            @php
                                                                $pointValue = isset($points[$index]) ? $points[$index] : 0;
                                                                $isContradictory = isset($contradictory[$index]) && $contradictory[$index] == 1;
                                                                $optionValue = is_array($option) ? implode(',', $option) : $option;
                                                                $isSelected = ($selectedValue && $optionValue == $selectedValue);
                                                            @endphp

                                                            <option value="{{ $optionValue }}"
                                                                    data-contradictory="{{ $isContradictory ? '1' : '0' }}"
                                                                    data-points="{{ $pointValue }}"
                                                                    @if($isSelected) selected @endif>{{ $optionValue }}</option>
                                                        @endforeach
                                                        @elseif(isset($aday->{$soru->db_key}) && $aday->{$soru->db_key} != null)
                                                        <option value="{{ $selectedValue }}" @if($selectedValue) selected @endif> {{ $selectedValue }} </option>
                                                        @elseif(in_array($soru->db_key, $citiesAndDistricts))
                                                        @if(isset($aday->infos) && $aday->infos !== null)
                                                            <option value="{{ $aday->{$soru->db_key} }}" @if($aday->{$soru->db_key}) selected @endif> {{ $aday->{$soru->db_key} }} </option>
                                                        @endif
                                                    @endif
                                                </select>

                                            </div>

                                        @endif

                                        @if($soru->type=='checkbox')

                                            @php $options = json_decode($soru->options,true) @endphp
                                            <div class='col-md-6'>
                                                <div class="form-check">
                                                    <input
                                                        @if(isset($aday->{$soru->db_key}) && $aday->{$soru->db_key} == 'on') checked @endif
                                                    class="form-check-input"  name="{{$soru->db_key}}"
                                                        @if($soru->required=='Zorunlu') required @endif
                                                        type="checkbox" id="{{$soru->db_key}}"
                                                    >
                                                    <p class="form-check-label mt-1 " for="confirmation1" @if($options[1]=='modal') data-bs-toggle="modal" data-bs-target="#{{$soru->db_key}}Modal" @endif ">@if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                    <u>@if($options[1]=='link')
                                                            <a target="_blank" href="{{ $options[2] }}">{{ $soru->title }}</a> @else {{ $soru->title }} @endif</u>
                                                            <span class="text-danger"> (Onaylamadan önce okuyunuz)</span>
                                                        </p>

                                                </div>
                                            </div>
                                            @if($options[1]=='modal')

                                                <div class="modal modal-lg fade" id="{{$soru->db_key}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$soru->db_key}}modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="text-center">
                                                                <h5 class="modal-title p-3" id="{{$soru->db_key}}Label">
                                                                    <div class=" text-center wp-block-group__inner-container">
                                                                        {{$options[3]}}
                                                                    </div>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body w-100 text-center p-5">
                                                                <?php echo $options[4]; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                                <button type="button" class="btn btn-primary pdf-download-btn" data-modal-id="{{$soru->db_key}}Modal">PDF İndir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        @if($soru->type=='modal')

                                            @if($soru->db_key == 'yvjgXYEnjkAH')
                                                @php $modaltext= $soru->modal_content;
                                                continue;
                                                @endphp
                                            @endif

                                            @if($taahutnameModalCheck && $soru->db_key == 'check_taahhutname')
                                                @php
                                                    $soru->modal_content = $modaltext;
                                                @endphp
                                            @endif
                                                <div class='col-md-6'>
                                                    <div class="form-check">
                                                        <input
                                                            @if(isset($aday->{$soru->db_key}) && $aday->{$soru->db_key} == 'on') checked @endif
                                                        class="form-check-input"  name="{{$soru->db_key}}"
                                                            @if($soru->required=='Zorunlu') required @endif
                                                            type="checkbox" id="{{$soru->db_key}}"
                                                        >
                                                        <p class="form-check-label mt-1 " for="confirmation1"
                                                        data-bs-toggle="modal" data-bs-target="#{{$soru->db_key}}Modal" >
                                                        @if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                        <u>{{ $soru->title }}</u>
                                                                <span class="text-danger"> (Onaylamadan önce okuyunuz)</span>
                                                            </p>

                                                    </div>
                                                </div>
                                            @if($soru->type=='modal')
                                                <div class="modal modal-lg fade" id="{{$soru->db_key}}Modal" tabindex="-1" role="dialog" aria-labelledby="{{$soru->db_key}}modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="text-center">
                                                                <h5 class="modal-title" id="{{$soru->db_key}}Label">
                                                                    <div class=" p-3 text-center wp-block-group__inner-container">
                                                                        <?php echo $soru->modal_title; ?>
                                                                    </div>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body w-100 text-center p-5">

                                                                <?php echo $soru->modal_content; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                                <button type="button" class="btn btn-primary pdf-download-btn" data-modal-id="{{$soru->db_key}}Modal">PDF İndir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        @if($soru->type=='redirect')
                                        <div class='col-md-6'>
                                            <div class="form-check">
                                                <input
                                                        @if(isset($aday->{$soru->db_key}) && $aday->{$soru->db_key} == 'on') checked @endif
                                                class="form-check-input"  name="{{$soru->db_key}}"
                                                    @if($soru->required=='Zorunlu') required @endif
                                                    type="checkbox" id="{{$soru->db_key}}"
                                                >
                                                <p class="form-check-label mt-1 " for="confirmation1">@if($soru->required=='Zorunlu') <span style="color: red" > *</span> @endif
                                                <u><a target="_blank" href="{{ $soru->redirect_url }}">{{ $soru->title }}</a></u>
                                                        <span class="text-danger"> (Onaylamadan önce okuyunuz)</span>
                                                    </p>

                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if($kategori->id == 13 )
                                    <div class="d-flex justify-content-end">
                                        <button id="addButtonburs" type="button" class="btn btn-primary mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
                                            </svg> Burs Ekle</button>
                                    </div>
                                    <table class="table table-striped">
                                        <thead>

                                        <tr>
                                            <th>Kurum Türü</th>
                                            <th>Kurum Adı</th>
                                            <th> Burs Tutarı</th>
                                            <th> İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bursTableBody">
                                        @php $sayac = 0; @endphp
                                        @if($aday->scholars)
                                            @foreach($aday->scholars as $scholar)
                                                @php $sayac += $scholar->count; @endphp

                                                <tr>
                                                    <td>{{$scholar->company_type}}</td>
                                                    <td>{{$scholar->company_name}}</td>
                                                    <td>{{$scholar->count}}</td>
                                                    <td>
                                                        <button onclick="deletescholarship(this)" data-id="{{$scholar->id}}" class="btn btn-sm btn-danger">Sil</button>
                                                    </td>                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">Toplam (₺)</td>
                                            <td><span id="scholar_count">{{$sayac}}</span></td>
                                            <td ></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                @endif
                                @if($kategori->id == 11 )
                                    <div class="d-flex justify-content-end">
                                        <button id="addButtonkardes" type="button" class="btn btn-primary mb-3" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path d="M9.16797 9.1665V4.1665H10.8346V9.1665H15.8346V10.8332H10.8346V15.8332H9.16797V10.8332H4.16797V9.1665H9.16797Z" fill="#4069E5"/>
                                            </svg> Kardeş Ekle</button>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Adı</th>
                                            <th>Soyadı</th>
                                            <th>Yaşı</th>
                                            <th>Öğrenim Durumu</th>
                                            <th>Medeni Durumu</th>
                                            <th>Mesleği (Çalışıyorsa)</th>
                                            <th>İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody id="siblingsTableBody">
                                        @if($aday->kardesler)
                                            @foreach($aday->kardesler as $sibling)
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{$sibling->name}}</td>
                                                    <td>{{$sibling->surname}}</td>
                                                    <td>{{$sibling->age}}</td>
                                                    <td>{{$sibling->educ_status}}</td>
                                                    <td>{{$sibling->maritality}}</td>
                                                    <td>{{$sibling->job}}</td>
                                                    <td>
                                                        <button onclick="deleteSibling(this)" data-id="{{$sibling->id}}" class="btn btn-sm btn-danger">Sil</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endforeach



                    </form>
                </div>
            </div>
        </div>
    </main>

    <div class="transfer-modal-footer d-flex justify-content-end g-3">
        <a href="{{route('findmy_relations_forms')}}" class="btn cancel-button" id="prevStep">Vazgeç</a>
        <button style="display: none;" type="button" class="btn btn-outline-primary next-button formBTNS "
                id="prevButton">Önceki</button>
        <button type="button" class="btn btn-primary next-button formBTNS" id="nextStep">Sonraki</button>
        <button style="display: none;" type="button" class="btn btn-primary next-button formBTNS"
                id="completeButton">Tamamla</button>
    </div>


    <!--Aykırı Seçenek Uyarı Modalı-->
    <div class="modal fade" id="contradictoryWarningModal" tabindex="-1" role="dialog" aria-labelledby="contradictoryWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contradictoryWarningModalLabel">Uyarı</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body w-100 text-center">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <h4>Başvuru Yapmaya Uygun Değilsiniz</h4>
                        <p>Seçtiğiniz seçenek nedeniyle başvuru yapmaya uygun olmadığınız tespit edilmiştir.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tamam</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal Alanı-->
    @include('student.layouts.modals')
@endsection
@section('scripts')
    <!-- App js -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/tr.min.js"></script>

    @include('student.soru-secicileri')
    <script>
        function initializeDateInputs() {
            // Flatpickr Türkçe dil ayarı
            flatpickr.localize(flatpickr.l10ns.tr);

            // Tüm date inputlarını Flatpickr ile initialize et
            document.querySelectorAll('.date-input').forEach(function(element) {
                if (element._flatpickr) {
                    return;
                }

                flatpickr(element, {
                    locale: "tr",
                    dateFormat: "Y-m-d",
                    altFormat: "d.m.Y",
                    altInput: true,
                    altInputClass: "form-control",
                    allowInput: true,
                    disableMobile: true,
                    monthSelectorType: 'static',
                    yearSelectorType: 'static'
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initializeDateInputs);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="{{ url('assets/js/student-tab-manager.js') }}"></script>
    @include('student.ortakSelectFonksiyonlar')

    <script>
        // Sayfa tam yüklendiğinde StudentTabManager'ı başlat
        document.addEventListener('DOMContentLoaded', function() {

                   // Anne Sag mi sorusu
                   $('#mother_alive').change(function() {

                        if ($(this).val() == 'Hayır') {
                            $('#mother_name').parent().addClass('d-none');
                            $('#mother_name').removeAttr('required');
                            $('#mother_surname').parent().addClass('d-none');
                            $('#mother_surname').removeAttr('required');
                            $('#mother_job').parent().addClass('d-none');
                            $('#mother_job').removeAttr('required');
                            $('#mother_company').parent().addClass('d-none');
                            $('#mother_company').removeAttr('required');
                            $('#mother_educ').parent().addClass('d-none');
                            $('#mother_educ').removeAttr('required');
                            $('#mother_city').parent().addClass('d-none');
                            $('#mother_city').removeAttr('required');
                            $('#mother_district').parent().addClass('d-none');
                            $('#mother_district').removeAttr('required');
                            $('#mother_salary').parent().addClass('d-none');
                            $('#mother_salary').removeAttr('required');
                            $('#doc_annegelirbelgesi').closest('.col-md-3').addClass('d-none');
                            $('#doc_annegelirbelgesi').removeAttr('required');

                        }
                        else{
                            $('#mother_name').parent().removeClass('d-none');
                            $('#mother_surname').parent().removeClass('d-none');
                            $('#mother_job').parent().removeClass('d-none');
                            $('#mother_company').parent().removeClass('d-none');
                            $('#mother_name').attr('required', 'required');
                            $('#mother_surname').attr('required', 'required');
                            $('#mother_job').attr('required', 'required');
                            $('#mother_company').attr('required', 'required');
                            $('#mother_educ').parent().removeClass('d-none');
                            $('#mother_educ').attr('required', 'required');
                            $('#mother_city').parent().removeClass('d-none');
                            $('#mother_city').attr('required', 'required');
                            $('#mother_district').parent().removeClass('d-none');
                            $('#mother_district').attr('required', 'required');
                            $('#mother_salary').parent().removeClass('d-none');
                            $('#mother_salary').attr('required', 'required');
                            $('#doc_annegelirbelgesi').closest('.col-md-3').removeClass('d-none');
                            $('#doc_annegelirbelgesi').attr('required', 'required');
                        }
                        });
                        // Baba Sag mi sorusu
                        $('#C9l7SUqOxSvZ').change(function() {
                        if ($(this).val() == 'Hayır') {
                            $('#father_name').parent().addClass('d-none');
                            $('#father_surname').parent().addClass('d-none');
                            $('#father_name').removeAttr('required');
                            $('#father_surname').removeAttr('required');
                            $('#father_job').removeAttr('required');
                            $('#father_job').parent().addClass('d-none');
                            $('#father_company').removeAttr('required');
                            $('#father_company').parent().addClass('d-none');
                            $('#father_educ').parent().addClass('d-none');
                            $('#father_educ').removeAttr('required');
                            $('#father_city').parent().addClass('d-none');
                            $('#father_city').removeAttr('required');
                            $('#father_district').parent().addClass('d-none');
                            $('#father_district').removeAttr('required');
                            $('#father_salary').parent().addClass('d-none');
                            $('#father_salary').removeAttr('required');
                            $('#doc_babagelirbelgesi').closest('.col-md-3').addClass('d-none');
                            $('#doc_babagelirbelgesi').removeAttr('required');
                        }
                        else{
                            $('#father_name').parent().removeClass('d-none');
                            $('#father_surname').parent().removeClass('d-none');
                            $('#father_name').attr('required', 'required');
                            $('#father_surname').attr('required', 'required');
                            $('#father_job').attr('required', 'required');
                            $('#father_company').attr('required', 'required');
                            $('#father_company').parent().removeClass('d-none');
                            $('#father_job').parent().removeClass('d-none');
                            $('#father_educ').parent().removeClass('d-none');
                            $('#father_educ').attr('required', 'required');
                            $('#father_city').parent().removeClass('d-none');
                            $('#father_city').attr('required', 'required');
                            $('#father_district').parent().removeClass('d-none');
                            $('#father_district').attr('required', 'required');
                            $('#father_salary').parent().removeClass('d-none');
                            $('#father_salary').attr('required', 'required');
                            $('#doc_babagelirbelgesi').closest('.col-md-3').removeClass('d-none');
                            $('#doc_babagelirbelgesi').attr('required', 'required');
                        }
                    });


            // Önce mevcut adımı yükle
            const currentKey = 'active_step_adayBasvuru';
            const savedStep = localStorage.getItem(currentKey);
            const pageName= 'adayBasvuru'+{{$aday_id}};
            // StudentTabManager'ı başlat
            StudentTabManager.init('application-form-high', pageName);

            // Aktif adımdaki date inputlarını initialize et


            // Önceki/Sonraki butonlarına tıklandığında da initialize et
            ['prevButton', 'nextStep'].forEach(buttonId => {
                const button = document.getElementById(buttonId);
                if (button) {
                    button.addEventListener('click', () => {
                        setTimeout(initializeDateInputs, 100);
                    });
                }
            });

            // Koşul kontrolü için yardımcı fonksiyonlar
            function checkCondition(value, operator, targetValue) {
                value = parseFloat(value);
                targetValue = parseFloat(targetValue);

                switch(operator) {
                    case '<': return value < targetValue;
                    case '>': return value > targetValue;
                    case '<=': return value <= targetValue;
                    case '>=': return value >= targetValue;
                    default: return true;
                }
            }

            function validateInput(input, conditions) {
                const value = input.value;
                let isValid = true;
                let errorMessage = '';

                if (!value || !value.trim()) {
                    input.setCustomValidity('');
                    hideError(input);
                    return true;
                }

                                // AGNO için özel kontrol
                if (input.id === 'agno') {
                    const agnoTypeSelect = document.getElementById('agno_type');
                    const agnoType = agnoTypeSelect ? agnoTypeSelect.value : '';
                    const agnoValue = parseFloat(value);

                    if (!isNaN(agnoValue)) {
                        // Önce tip bazlı kontrol
                        if (agnoType === "4'lük") {
                            if (agnoValue < 0 || agnoValue > 4) {
                                isValid = false;
                                errorMessage = "4'lük sistemde AGNO 0-4 arasında olmalıdır";
                                document.getElementById('agno').value = '';
                            }
                        } else if (agnoType === "100'lük") {
                            if (agnoValue < 0 || agnoValue > 100) {
                                isValid = false;
                                errorMessage = "100'lük sistemde AGNO 0-100 arasında olmalıdır";
                                document.getElementById('agno').value = '';
                            }
                        }

                        // Eğer tip kontrolü geçildiyse, dinamik koşulları tip bazlı filtreleyerek kontrol et
                        if (isValid && conditions && conditions.length > 0) {
                            // AGNO type'a göre koşulları filtrele
                            const filteredConditions = conditions.filter(condition => {
                                const conditionValue = parseFloat(condition.value);
                                if (agnoType === "4'lük") {
                                    // 4'lük sistem için 5'ten küçük koşulları kontrol et
                                    return conditionValue < 5;
                                } else if (agnoType === "100'lük") {
                                    // 100'lük sistem için 5'ten büyük/eşit koşulları kontrol et
                                    return conditionValue >= 5;
                                }
                                return true;
                            });


                            // Filtrelenmiş koşulları kontrol et
                            filteredConditions.forEach(condition => {
                                if (!checkCondition(agnoValue, condition.operator, condition.value)) {
                                    isValid = false;
                                    switch(condition.operator) {
                                        case '<':
                                            errorMessage = `AGNO değeri ${condition.value}'den küçük olmalıdır`;
                                            break;
                                        case '>':
                                            errorMessage = `AGNO değeri ${condition.value}'den büyük olmalıdır`;
                                            break;
                                        case '<=':
                                            errorMessage = `AGNO değeri ${condition.value}'ye eşit veya küçük olmalıdır`;
                                            break;
                                        case '>=':
                                            errorMessage = `AGNO değeri ${condition.value}'ye eşit veya büyük olmalıdır`;
                                            break;
                                    }
                                }
                            });
                        }
                    }
                } else {
                    // Diğer inputlar için normal koşul kontrolü
                    conditions.forEach(condition => {
                        if (!checkCondition(value, condition.operator, condition.value)) {
                            isValid = false;
                            switch(condition.operator) {
                                case '<':
                                    errorMessage = `Değer ${condition.value}'den küçük olmalıdır`;
                                    break;
                                case '>':
                                    errorMessage = `Değer ${condition.value}'den büyük olmalıdır`;
                                    break;
                                case '<=':
                                    errorMessage = `Değer ${condition.value}'ye eşit veya küçük olmalıdır`;
                                    break;
                                case '>=':
                                    errorMessage = `Değer ${condition.value}'ye eşit veya büyük olmalıdır`;
                                    break;
                            }
                        }
                    });
                }

                if (!isValid) {
                    input.setCustomValidity(errorMessage);
                    showError(input, errorMessage);
                } else {
                    input.setCustomValidity('');
                    hideError(input);
                }

                return isValid;
            }

            function showError(input, message) {
                // Mevcut hata mesajını kaldır
                hideError(input);

                // Yeni hata mesajı oluştur
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                errorDiv.style.color = 'red';
                errorDiv.textContent = message;

                // Hata mesajını input'un altına ekle
                input.parentNode.appendChild(errorDiv);
                input.classList.add('is-invalid');
            }

            function hideError(input) {
                const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.remove();
                }
                input.classList.remove('is-invalid');
            }

            // Sayfa yüklendiğinde koşullu alanları işaretle ve event listener'ları ekle
                            @foreach($kategoriler as $kategori)
                    @foreach($kategori->soru as $soru)
                        @if($soru->has_conditions)
                            const conditions{{$soru->id}} = @json(json_decode($soru->conditions, true) ?? []);
                            const input{{$soru->id}} = document.getElementById('{{$soru->db_key}}');

                            if (input{{$soru->id}}) {
                                @if($soru->db_key === 'agno')
                                    // AGNO için sadece focusout kontrolü
                                    input{{$soru->id}}.addEventListener('focusout', function() {
                                        validateInput(this, conditions{{$soru->id}});
                                    });
                                @else
                                    // Diğer inputlar için input ve blur kontrolü
                                    input{{$soru->id}}.addEventListener('input', function() {
                                        validateInput(this, conditions{{$soru->id}});
                                    });

                                    input{{$soru->id}}.addEventListener('blur', function() {
                                        validateInput(this, conditions{{$soru->id}});
                                    });
                                @endif
                            }
                        @endif
                    @endforeach
                @endforeach

                                            // Sonraki butonuna tıklandığında aktif adımdaki koşullu alanları kontrol et
                document.getElementById('nextStep').addEventListener('click', function(e) {
                    let allValid = true;
                    const activeStepContent = document.querySelector('.step-content.active, .step-content.show');

                    @foreach($kategoriler as $kategori)
                        @foreach($kategori->soru as $soru)
                            @if($soru->has_conditions)
                                const input{{$soru->id}} = document.getElementById('{{$soru->db_key}}');
                                if (
                                    input{{$soru->id}} &&
                                    activeStepContent &&
                                    activeStepContent.contains(input{{$soru->id}}) &&
                                    !validateInput(input{{$soru->id}}, conditions{{$soru->id}})
                                ) {
                                    allValid = false;
                                }
                            @endif
                        @endforeach
                    @endforeach

                    if (!allValid) {
                        e.preventDefault();
                        return false;
                    }
                });

            // Sayfanın tamamen yüklenmesini garanti etmek için timeout kullan
            setTimeout(function() {
                if (savedStep) {
                    const step = parseInt(savedStep);
                    if (!isNaN(step) && step >= 1) {
                        // Form içindeki adım içeriğinin görünürlüğünü kontrol et
                        const stepContent = document.querySelector(`.step-content[data-content="${step}"]`);
                        if (stepContent) {
                            // Tüm adımları gizle
                            document.querySelectorAll('.step-content').forEach(content => {
                                content.classList.remove('active', 'show');
                            });

                            // Aktif adımı göster
                            stepContent.classList.add('active', 'show');

                            // Adım göstergelerini güncelle
                            document.querySelectorAll('.step-item').forEach(item => {
                                const itemStep = parseInt(item.getAttribute('data-target'));
                                item.classList.remove('active', 'completed');

                                if (itemStep === step) {
                                    item.classList.add('active');
                                } else if (itemStep < step) {
                                    item.classList.add('completed');
                                }
                            });

                            // İçeriğe git
                            stepContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                }
            }, 200);
        });
    </script>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            // Toplam gelir hesaplama
            var toplamGelir = 0;
            var babaMaas = document.getElementById('father_salary');
            var anneMaas = document.getElementById('mother_salary');
            var digerGelir = document.getElementById('other_salary');
            var baskaGelir = document.getElementById('other_income');
            var gelirTipleri = ['father_salary','mother_salary','other_salary','other_income'];

            function updateToplamGelir() {
                toplamGelir = getNumberValue(babaMaas) + getNumberValue(anneMaas) + getNumberValue(digerGelir) + getNumberValue(baskaGelir);
                var toplamElement = document.getElementById('kaSQQWBD3IH2');
                if (toplamElement) {
                    toplamElement.value = toplamGelir;
                }
            }

            gelirTipleri.forEach(function(gelirTipi) {
                var element = document.getElementById(gelirTipi);
                if(element != null){
                    element.addEventListener('input', updateToplamGelir);
                }
            });

            function getNumberValue(input) {
                if (!input || !input.value) {
                    return 0;
                }
                var val = parseInt(input.value);
                return isNaN(val) ? 0 : val;
            }


            // Anne ve Baba birlikte mi yaşıyor sorusu
                    var parentTogether  = $('#parent_together').val();
                    if(parentTogether == 'Hayır'){
                        $('#WAll7WvDPAjk').parent().removeClass('d-none');
                        $('#WAll7WvDPAjk').removeClass('d-none');
                        $('#WAll7WvDPAjk').attr('required', 'required');
                        if (!$('#WAll7WvDPAjk').parent().find('label').find('span.text-danger').length) {
                            $('#WAll7WvDPAjk').parent().find('label').append('<span class="text-danger">*</span>');
                        }
                    }else{
                        $('#WAll7WvDPAjk').parent().addClass('d-none');
                        $('#WAll7WvDPAjk').addClass('d-none');
                        $('#WAll7WvDPAjk').addClass('d-none');
                        $('#WAll7WvDPAjk').parent().find('label span.text-danger').remove();
                        $('#WAll7WvDPAjk').val('');
                    }
                    $('#parent_together').change(function() {
                        if ($(this).val() == 'Hayır') {
                            $('#WAll7WvDPAjk').parent().removeClass('d-none');
                            $('#WAll7WvDPAjk').removeClass('d-none');
                            $('#WAll7WvDPAjk').attr('required', 'required');
                            if (!$('#WAll7WvDPAjk').parent().find('label').find('span.text-danger').length) {
                            $('#WAll7WvDPAjk').parent().find('label').append('<span class="text-danger">*</span>');
                        }
                        } else {
                            $('#WAll7WvDPAjk').parent().addClass('d-none');
                            $('#WAll7WvDPAjk').addClass('d-none');
                            $('#WAll7WvDPAjk').removeAttr('required');
                            $('#WAll7WvDPAjk').val('');

                        }
                    })

            // Çalışıyor mu sırusu için seçenekleri göster gizle
            if($('#is_working')){
                    var calisiyorMu = $('#is_working').val();
                    if(calisiyorMu == 'Hayır'){
                    $('#job_company').parent().addClass('d-none');
                    $('#job_company').removeAttr('required');
                    $('#job_rank').parent().addClass('d-none');
                    $('#job_rank').removeAttr('required');
                    $('#job_sgk').parent().addClass('d-none');
                    $('#job_sgk').removeAttr('required');
                    $('#job_salary').parent().addClass('d-none');
                    $('#job_salary').removeAttr('required');
                }
                else{
                    $('#job_company').parent().removeClass('d-none');
                    $('#job_company').attr('required', 'required');
                    $('#job_rank').parent().removeClass('d-none');
                    $('#job_rank').attr('required', 'required');
                    $('#job_sgk').parent().removeClass('d-none');
                    $('#job_sgk').attr('required', 'required');
                    $('#job_salary').parent().removeClass('d-none');
                    $('#job_salary').attr('required', 'required');
                }
                $('#is_working').change(function() {
                    if ($(this).val() == 'Hayır') {
                        $('#job_company').parent().addClass('d-none');
                        $('#job_company').removeAttr('required');
                        $('#job_rank').parent().addClass('d-none');
                        $('#job_rank').removeAttr('required');
                        $('#job_sgk').parent().addClass('d-none');
                        $('#job_sgk').removeAttr('required');
                        $('#job_salary').parent().addClass('d-none');
                        $('#job_salary').removeAttr('required');

                    }
                    else{
                        $('#job_company').parent().removeClass('d-none');
                        $('#job_company').attr('required', 'required');
                        $('#job_rank').parent().removeClass('d-none');
                        $('#job_rank').attr('required', 'required');
                        $('#job_sgk').parent().removeClass('d-none');
                        $('#job_sgk').attr('required', 'required');
                        $('#job_salary').parent().removeClass('d-none');
                        $('#job_salary').attr('required', 'required');
                    }
                });
            }



            const phoneInputField = document.querySelector("#tel_no");
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "tr",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
                formatOnDisplay: true
            });


            // Numara girişi sırasında formatlama
            phoneInputField.addEventListener('keyup', function() {
                const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.INTERNATIONAL);
                phoneInputField.value = formattedNumber.replace(/ /g, " ");
            });
            const phoneInputField2 = document.querySelector("#emergency_mobile");
            const phoneInput2 = window.intlTelInput(phoneInputField2, {
                initialCountry: "tr",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
                formatOnDisplay: true
            });
            const phoneInputField3 = document.querySelector("#parent_mobile");
            const phoneInput3 = window.intlTelInput(phoneInputField3, {
                initialCountry: "tr",
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
                formatOnDisplay: true
            });
            function validateTcKimlikNo(tc) {
                if (tc.length !== 11 || isNaN(tc) || tc[0] === '0') {
                    return false;
                }

                const digits = tc.split('').map(Number);
                const sumOdd = digits[0] + digits[2] + digits[4] + digits[6] + digits[8];
                const sumEven = digits[1] + digits[3] + digits[5] + digits[7];
                const total = digits.slice(0, 10).reduce((acc, val) => acc + val, 0);

                return (
                    (sumOdd * 7 - sumEven) % 10 === digits[9] &&
                    total % 10 === digits[10]
                );
            }

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
        });



    </script>
    <script src="{{url('')}}/assets/js/components/dashboard-student.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // scriptF.blade.php içindeki çakışan adım yönetimi kodunu devre dışı bırakıp
        // sadece StudentTabManager kullanacağımızı belirtiyoruz
        window.useOnlyStudentTabManager = true;
    </script>
    @include('student.layouts.scriptF')
    @include('includes.js.sidebar')

    <script>
        // Aykırı seçenek kontrolü
        document.addEventListener('DOMContentLoaded', function() {
            // Tüm select alanlarını dinle
            const selectElements = document.querySelectorAll('select[data-dataset]');

            selectElements.forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && selectedOption.getAttribute('data-contradictory') === '1') {
                        // Aykırı seçenek seçildi, modalı göster
                        const contradictoryModal = new bootstrap.Modal(document.getElementById('contradictoryWarningModal'));
                        contradictoryModal.show();

                        // Seçimi temizle
                        this.value = '';
                    }
                });
                         });
         });

                  // AGNO puanlama hesaplama fonksiyonu
         function calculateAGNOScore(agnoValue) {
             if (isNaN(agnoValue) || agnoValue <= 0) {
                 return 0;
             }

             let agnoScore = 0;

             if (agnoValue < 5.00) {
                 agnoScore = (agnoValue / 5.00) * 25;
             }
             else {
                 agnoScore = (agnoValue / 100) * 20;
             }

             return Math.round(agnoScore * 100) / 100;
         }

         // Puanlama sistemi
         function calculateTotalScore() {
             let totalScore = 0;

             // AGNO özel hesaplama
             const agnoInput = document.getElementById('agno');
             if (agnoInput && agnoInput.value) {
                 const agnoValue = parseFloat(agnoInput.value);
                 const agnoScore = calculateAGNOScore(agnoValue);
                 totalScore += agnoScore;
             }

             // Diğer numara tipindeki alanları kontrol et (AGNO hariç)
             document.querySelectorAll('.number-input').forEach(function(input) {
                 // AGNO'yu atla çünkü özel hesaplama yaptık
                 if (input.id === 'agno') {
                     return;
                 }

                 if(input.id === 'grade_avg'){
                        const grade_avg = document.getElementById('grade_avg');
                        if(grade_avg && grade_avg.value){
                            var grade_avgValue = parseFloat(grade_avg.value);
                            grade_avgValue = Math.round(grade_avgValue * 20) / 100;
                            totalScore+=grade_avgValue;
                        }
                    }
                 const value = parseFloat(input.value);
                 const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');

                 if (!isNaN(value) && Object.keys(scoringRanges).length > 0) {
                     // Hangi aralığa düştüğünü bul
                     for (const [key, range] of Object.entries(scoringRanges)) {
                         let inRange = true;

                         // Minimum kontrol
                         if (range.min !== null && value < range.min) {
                             inRange = false;
                         }

                         // Maksimum kontrol
                         if (range.max !== null && value >= range.max) {
                             inRange = false;
                         }

                         if (inRange) {
                             totalScore += parseInt(range.points || 0);
                             break;
                         }
                     }
                 }
             });

             // Select tipindeki alanları kontrol et
             document.querySelectorAll('select[data-dataset]').forEach(function(select) {
                 const selectedOption = select.options[select.selectedIndex];
                 if (selectedOption && selectedOption.value && selectedOption.getAttribute('data-points')) {
                     const points = parseInt(selectedOption.getAttribute('data-points') || 0);
                     totalScore += points;
                 }
             });
            // Puanı ve cevabı kaydet
            const tcNo = document.querySelector('input[id="tc_no"]').value;
            const selectedValues = {};

            // Select değerlerini topla
            document.querySelectorAll('select[data-dataset]').forEach(function(select) {
                if (select.value) {
                    const puan = parseInt(select.options[select.selectedIndex].getAttribute('data-points') || 0);
                    // Puan 0 ise kaydetme
                    if (puan > 0) {
                        // Label metnini al (soru adı olarak kullan)
                        const label = select.closest('.col-md-6').querySelector('label');
                        const soruAdi = label ? label.textContent.trim().replace(/\s*\*$/, '') : select.getAttribute('data-dataset');

                        selectedValues[soruAdi] = {
                            puan: puan,
                            cevap: select.value
                        };
                    }
                }
            });

            // Numara tipindeki değerleri topla
            document.querySelectorAll('.number-input').forEach(function(input) {
                if (input.value) {
                    let puan = 0;
                    if (input.id === 'agno') {
                        puan = calculateAGNOScore(parseFloat(input.value));
                    }
                    else if(input.id === 'grade_avg'){
                        const grade_avg = document.getElementById('grade_avg');
                        if(grade_avg && grade_avg.value){
                            var grade_avgValue = parseFloat(grade_avg.value);
                            grade_avgValue = Math.round(grade_avgValue * 20) / 100;
                            puan = grade_avgValue;
                        }

                    }


                     else {
                        // Barınma türüne bağlı olarak ödenen tutar ücretinin hesaplanması
                        if(input.id === 'housing_fee'){
                            if(document.getElementById('housing_type').value == 'Aile Yanı' ||
                             document.getElementById('housing_type').value == 'Arkadaş Yanı' ||
                              document.getElementById('housing_type').value == 'Ev'){
                                puan = parseInt(0);
                            } else {
                                const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');
                                const value = parseFloat(input.value);

                                for (const [key, range] of Object.entries(scoringRanges)) {
                                    if ((!range.min || value >= range.min) && (!range.max || value < range.max)) {
                                        puan = parseInt(range.points || 0);
                                        break;
                                    }
                                }
                            }
                        } else {
                            const scoringRanges = JSON.parse(input.getAttribute('data-scoring-ranges') || '[]');
                            const value = parseFloat(input.value);

                            for (const [key, range] of Object.entries(scoringRanges)) {
                                if ((!range.min || value >= range.min) && (!range.max || value < range.max)) {
                                    puan = parseInt(range.points || 0);
                                    break;
                                }
                            }
                        }
                    }

                    // Puan 0 ise kaydetme
                    if (puan > 0) {
                        // Label metnini al (soru adı olarak kullan)
                        const label = input.closest('.col-md-6').querySelector('label');
                        const soruAdi = label ? label.textContent.trim().replace(/\s*\*$/, '') : input.getAttribute('data-dataset');

                        selectedValues[soruAdi] = {
                            puan: puan,
                            cevap: input.value
                        };
                    }
                }
            });

            // Her bir soru için AJAX isteği gönder
            for (const [soru, data] of Object.entries(selectedValues)) {
                fetch('/aday-points', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        tc_no: tcNo,
                        soru: soru,
                        puan: data.puan,
                        cevap: data.cevap
                    })
                })
                .then(response => response.json())
                .catch(error => console.error('Hata:', error));
            }

            return totalScore;
         }

                  // Sayfa yüklendiğinde ve input değiştiğinde hesapla
         document.addEventListener('DOMContentLoaded', function() {
             // İlk sayfa yüklendiğinde puanı hesapla
             setTimeout(function() {
                 const initialScore = calculateTotalScore();
             }, 500);

             // AGNO type değiştiğinde AGNO input'unu güncelle
             const agnoTypeSelect = document.getElementById('agno_type');
             const agnoInput = document.getElementById('agno');

             if (agnoTypeSelect && agnoInput) {
                 agnoTypeSelect.addEventListener('change', function() {
                     const selectedValue = this.value;

                     if (selectedValue === "4'lük") {
                         agnoInput.setAttribute('step', '0.01');
                         agnoInput.setAttribute('max', '4');
                         agnoInput.setAttribute('min', '0');
                         agnoInput.setAttribute('placeholder', 'Örn: 3.50');
                     } else if (selectedValue === "100'lük") {
                         agnoInput.setAttribute('step', '1');
                         agnoInput.setAttribute('max', '100');
                         agnoInput.setAttribute('min', '0');
                         agnoInput.setAttribute('placeholder', 'Örn: 85');
                     }



                     // Puanı yeniden hesapla
                     calculateTotalScore();
                 });

                 // Sayfa yüklendiğinde de kontrol et
                 if (agnoTypeSelect.value) {
                     agnoTypeSelect.dispatchEvent(new Event('change'));
                 }
             }
             const grade_avg = document.getElementById('grade_avg');
             if(grade_avg){
                grade_avg.setAttribute('step', '0.01');
                grade_avg.setAttribute('max', '100');
                grade_avg.setAttribute('min', '0');
                grade_avg.setAttribute('placeholder', 'Örn: 83.50');
             }
             // Numara alanları değiştiğinde puanı güncelle
             document.querySelectorAll('.number-input').forEach(function(input) {
                 input.addEventListener('input', calculateTotalScore);
                 input.addEventListener('change', calculateTotalScore);
             });

             // Select alanları değiştiğinde puanı güncelle
             document.querySelectorAll('select[data-dataset]').forEach(function(select) {
                 select.addEventListener('change', calculateTotalScore);
             });
         });
     </script>

    <script>
        // PDF indirme fonksiyonları - tüm modaller için çalışan versiyon
        document.addEventListener('DOMContentLoaded', function() {

            // Tüm modalleri bul ve debug bilgisini logla
            const allModals = document.querySelectorAll('.modal');

            // Sayfa yüklendikten sonra ve ileride eklenecek PDF butonları için event listener
            function setupPdfButtons() {

                // Tüm PDF indirme butonlarını bul
                const pdfButtons = document.querySelectorAll('.pdf-download-btn');

                // Her buton için click olayını ayarla
                pdfButtons.forEach(button => {
                    // Önceki event listener'ları temizle
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);

                    // Yeni event listener ekle
                    newButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Modal ID'sini al
                        const modalId = this.getAttribute('data-modal-id');

                        // Önce doğrudan ID ile modal'ı bulmaya çalış
                        let modal = document.getElementById(modalId);

                        // Eğer doğrudan bulunamazsa, açık olan modalı bul
                        if (!modal || !modal.classList.contains('show')) {
                            document.querySelectorAll('.modal.show').forEach(m => {
                                modal = m;
                            });
                        }

                        if (!modal) {
                            alert('İçerik bulunamadı. Lütfen sayfayı yenileyip tekrar deneyin.');
                            return;
                        }

                        try {
                            // Modal içeriğini al
                            const titleElement = modal.querySelector('.modal-title');
                            const bodyElement = modal.querySelector('.modal-body');

                            if (!titleElement || !bodyElement) {
                                console.error('Modal başlık veya içerik bulunamadı');
                                alert('İçerik bulunamadı. Lütfen sayfayı yenileyip tekrar deneyin.');
                                return;
                            }

                            const title = titleElement.textContent.trim() || 'Doküman';
                            const content = bodyElement.innerHTML || '';

                            // Yeni pencere aç ve içeriği kopyala
                            const printWindow = window.open('', '_blank');
                            if (!printWindow) {
                                alert('Pop-up penceresi açılamadı. Lütfen tarayıcı ayarlarınızı kontrol edin.');
                                return;
                            }

                            // Basit HTML ve CSS ile içeriği göster
                            printWindow.document.write(`
                                <!DOCTYPE html>
                                <html>
                                <head>
                                    <meta charset="utf-8">
                                    <title>${title}</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            margin: 40px;
                                            line-height: 1.6;
                                            font-size: 14px;
                                            color: #333;
                                        }
                                        h1 {
                                            text-align: center;
                                            margin-bottom: 30px;
                                            font-size: 20px;
                                        }
                                        .content {
                                            margin-bottom: 40px;
                                        }
                                        .btn {
                                            padding: 10px 20px;
                                            background: #4069E5;
                                            color: white;
                                            border: none;
                                            border-radius: 5px;
                                            cursor: pointer;
                                            font-size: 14px;
                                            margin: 0 10px;
                                        }
                                        .btn-secondary {
                                            background: #6c757d;
                                        }
                                        .text-center {
                                            text-align: center;
                                        }
                                        @media print {
                                            body {
                                                margin: 20mm;
                                            }
                                            .no-print {
                                                display: none;
                                            }
                                        }
                                    </style>
                                </head>
                                <body>
                                    <h1>${title}</h1>
                                    <div class="content">${content}</div>
                                    <div class="no-print text-center" style="margin-top: 40px;">
                                        <button onclick="window.print();" class="btn">Yazdır / PDF Olarak Kaydet</button>
                                        <button onclick="window.close();" class="btn btn-secondary">Kapat</button>
                                    </div>
                                </body>
                                </html>
                            `);

                            printWindow.document.close();

                        } catch (error) {
                            console.error('İşlem sırasında hata:', error);
                            alert('İşlem sırasında bir hata oluştu: ' + error.message);
                        }
                    });
                });
            }

            // Sayfa yüklendiğinde butonları ayarla
            setupPdfButtons();

            // Modal gösterildiğinde butonları yeniden ayarla ve içeriği güncelle
            document.addEventListener('shown.bs.modal', function(event) {
                setTimeout(setupPdfButtons, 100);

                // Modal ID'sini al
                const modalElement = event.target;
                const modalId = modalElement.id;

                // Eğer açılan modal check_taahhutnameModal ise içeriğini dinamik olarak güncelle
                if (modalId === 'check_taahhutnameModal') {
                    updateTaahhutnameContent(modalElement);
                }
            });

            // Taahhütname içeriğini dinamik olarak güncelleme fonksiyonu
            function updateTaahhutnameContent(modal) {
                const ortaogrenimOkuladi = document.getElementById('p_school_name') ? document.getElementById('p_school_name').value :
                                          document.getElementById('m_school_name') ? document.getElementById('m_school_name').value :
                                          document.getElementById('h_school_name') ? document.getElementById('h_school_name').value : '';
                // Form alanlarından değerleri al
                const educationType = document.getElementById('educationType') ? document.getElementById('educationType').value : '';

                const universiteSelect = document.getElementById('current_university');
                const bolumSelect = document.getElementById('grade_departmant');
                var ogrenciNoInput = document.getElementById('student_number');

                const nameInput = document.getElementById('name');
                const surnameInput = document.getElementById('surname');

                // Seçili değerleri al
                const universite = universiteSelect ? universiteSelect.options[universiteSelect.selectedIndex]?.text || '' : '';
                const bolum = bolumSelect ? bolumSelect.options[bolumSelect.selectedIndex]?.text || '' : '';
                const ogrenciNo = ogrenciNoInput ? ogrenciNoInput.value || '' : '';
                const isim = (nameInput ? nameInput.value || '' : '') + ' ' + (surnameInput ? surnameInput.value || '' : '');

                // Modal içeriğini bul
                const modalBody = modal.querySelector('.modal-body');
                if (!modalBody) return;

                // Mevcut içeriği al
                let content = modalBody.innerHTML;

                // Placeholder'ları değiştir
                content = content.replace(/\{\{universite\}\}/g, universite);
                content = content.replace(/\{\{bolum\}\}/g, bolum);
                content = content.replace(/\{\{ogrenci_no\}\}/g, ogrenciNo);
                content = content.replace(/\{\{isim\}\}/g, isim);
                content = content.replace(/\{\{okul_adi\}\}/g, ortaogrenimOkuladi);

                // Güncellenmiş içeriği ayarla
                modalBody.innerHTML = content;
            }

            // Drag & Drop İşlevselliği
            initializeDragDrop();
        });

        // Drag & Drop fonksiyonlarını başlat
        function initializeDragDrop() {
            // Tüm file-drag-drop-area alanlarını seç
            const dropAreas = document.querySelectorAll('.file-drag-drop-area');

            dropAreas.forEach(dropArea => {
                const fileInput = dropArea.querySelector('input[type="file"]');
                const label = dropArea.querySelector('.file-label');

                if (!fileInput || !label) return;

                // Drag olayları için stil değişiklikleri
                function addHighlight() {
                    label.style.backgroundColor = '#f0f8ff';
                    label.style.borderColor = '#4069E5';
                    label.style.borderStyle = 'dashed';
                }

                function removeHighlight() {
                    label.style.backgroundColor = '';
                    label.style.borderColor = '';
                    label.style.borderStyle = '';
                }

                // Drag enter - dosya sürüklenmeye başlandığında
                dropArea.addEventListener('dragenter', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    addHighlight();
                });

                // Drag over - dosya üzerinde sürüklenirken
                dropArea.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    addHighlight();
                });

                // Drag leave - dosya alan dışına çıktığında
                dropArea.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    removeHighlight();
                });

                // Drop - dosya bırakıldığında
                dropArea.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    removeHighlight();

                    const files = e.dataTransfer.files;

                    if (files.length > 0) {
                        const file = files[0];

                        // Dosya tipini kontrol et
                        const acceptedTypes = fileInput.getAttribute('accept');
                        if (acceptedTypes && !isFileTypeAccepted(file, acceptedTypes)) {
                            alert('Bu dosya tipi desteklenmiyor. Lütfen desteklenen dosya tiplerinden birini seçin.');
                            return;
                        }

                        // Dosya boyutunu kontrol et (5MB = 5 * 1024 * 1024 bytes)
                        const maxSize = 5 * 1024 * 1024;
                        if (file.size > maxSize) {
                            alert('Dosya boyutu 5MB\'dan büyük olamaz.');
                            return;
                        }

                        // Dosyayı input alanına ata
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;

                        // Dosya seçildiğinde change event'ini tetikle
                        const changeEvent = new Event('change', { bubbles: true });
                        fileInput.dispatchEvent(changeEvent);
                    }
                });

                // Label'a tıklandığında da aynı işlevi sağla (mevcut işlevsellik korunur)
                label.addEventListener('click', function(e) {
                    // Varsayılan davranış zaten input'u tetikler
                });
            });
        }

        // Dosya tipini kontrol eden yardımcı fonksiyon
        function isFileTypeAccepted(file, acceptedTypes) {
            const fileType = file.type;
            const fileName = file.name.toLowerCase();

            // Accept string'ini parçala
            const types = acceptedTypes.split(',').map(type => type.trim());

            for (let type of types) {
                // MIME type kontrolü
                if (type.startsWith('.')) {
                    // Dosya uzantısı kontrolü
                    if (fileName.endsWith(type.toLowerCase())) {
                        return true;
                    }
                } else {
                    // MIME type kontrolü
                    if (fileType === type || fileType.startsWith(type.replace('*', ''))) {
                        return true;
                    }
                }
            }

            return false;
        }
    </script>
@endsection
