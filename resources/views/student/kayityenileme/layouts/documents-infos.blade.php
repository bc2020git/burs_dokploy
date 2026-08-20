<div class="step-content" id="step-14" data-content="14">
    <input type="hidden" id="form_id" name="form_id" value="{{$aday->id}}">

    <div class="row mt-3">
        <div id="uploadContainer" class="row">
            @foreach($documents as $doc)
                <div class="col-md-3 mt-2">
                    <div class="upload-card">
                        <div class="documents-title-drag-drop">
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 4C2 3.44772 2.44772 3 3 3H10.4142L12.4142 5H21C21.5523 5 22 5.44772 22 6V20C22 20.5523 21.5523 21 21 21H3C2.45 21 2 20.55 2 20V4ZM10.5858 6L9.58579 5H4V7H9.58579L10.5858 6ZM4 9V19H20V7H12.4142L10.4142 9H4Z" fill="#1A1A1A"/>
                                </svg> {{ $doc['title'] }}
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z" fill="#1A1A1A"/>
                            </svg>
                        </div>
                        <div id="uploadedFile{{ $doc['id'] }}">
                            <div class="file-drag-drop-area">
                                <input data-id="{{ $doc['id'] }}" type="file" id="{{ $doc['id'] }}" hidden @if($doc['id'] == 'doc_fotograf' || $doc['id'] == 'fotograf') accept="image/jpeg, image/png, image/jpg" @endif>
                                <label for="{{ $doc['id'] }}" class="file-label d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M4.16406 1.66675C3.50102 1.66675 2.86514 1.93014 2.3963 2.39898C1.92745 2.86782 1.66406 3.50371 1.66406 4.16675V6.66675C1.66406 7.12698 2.03716 7.50008 2.4974 7.50008C2.95763 7.50008 3.33073 7.12698 3.33073 6.66675V4.16675C3.33073 3.94573 3.41853 3.73377 3.57481 3.57749C3.73109 3.42121 3.94305 3.33341 4.16406 3.33341H6.66406C7.1243 3.33341 7.4974 2.96032 7.4974 2.50008C7.4974 2.03984 7.1243 1.66675 6.66406 1.66675H4.16406Z" fill="#2D3648"/>
                                        <path d="M13.3307 1.66675C12.8705 1.66675 12.4974 2.03984 12.4974 2.50008C12.4974 2.96032 12.8705 3.33341 13.3307 3.33341H15.8307C16.0517 3.33341 16.2637 3.42121 16.42 3.57749C16.5763 3.73377 16.6641 3.94573 16.6641 4.16675V6.66675C16.6641 7.12698 17.0372 7.50008 17.4974 7.50008C17.9576 7.50008 18.3307 7.12698 18.3307 6.66675V4.16675C18.3307 3.50371 18.0673 2.86782 17.5985 2.39898C17.1297 1.93014 16.4938 1.66675 15.8307 1.66675H13.3307Z" fill="#2D3648"/>
                                        <path d="M3.33073 13.3334C3.33073 12.8732 2.95763 12.5001 2.4974 12.5001C2.03716 12.5001 1.66406 12.8732 1.66406 13.3334V15.8334C1.66406 16.4965 1.92745 17.1323 2.3963 17.6012C2.86514 18.07 3.50102 18.3334 4.16406 18.3334H6.66406C7.1243 18.3334 7.4974 17.9603 7.4974 17.5001C7.4974 17.0398 7.1243 16.6667 6.66406 16.6667H4.16406C3.94305 16.6667 3.73109 16.5789 3.57481 16.4227C3.41853 16.2664 3.33073 16.0544 3.33073 15.8334V13.3334Z" fill="#2D3648"/>
                                        <path d="M18.3307 13.3334C18.3307 12.8732 17.9576 12.5001 17.4974 12.5001C17.0372 12.5001 16.6641 12.8732 16.6641 13.3334V15.8334C16.6641 16.0544 16.5763 16.2664 16.42 16.4227C16.2637 16.5789 16.0517 16.6667 15.8307 16.6667H13.3307C12.8705 16.6667 12.4974 17.0398 12.4974 17.5001C12.4974 17.9603 12.8705 18.3334 13.3307 18.3334H15.8307C16.4938 18.3334 17.1297 18.07 17.5985 17.6012C18.0673 17.1323 18.3307 16.4965 18.3307 15.8334V13.3334Z" fill="#2D3648"/>
                                    </svg>
                                    <div class="text-container">
                                        <p class="mb-0 text-center">Sürükle ve Bırak<br>veya <u>Dosya Seç</u></p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="file-info mt-2">
                            <p>Desteklenen Belgeler: @if($doc['id'] == 'doc_fotograf' || $doc['id'] == 'fotograf') jpeg, png, jpg @else jpg, jpeg, png, PDF @endif</p>
                            <p>Max Size: 25 MB, 1 Dosya</p>
                        </div>
                        <div data-id="{{$doc['id']}}" id="{{$doc['id']}}" class="delete-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                <path d="M10.625 3.75H13.75V5H12.5V13.125C12.5 13.4702 12.2202 13.75 11.875 13.75H3.125C2.77982 13.75 2.5 13.4702 2.5 13.125V5H1.25V3.75H4.375V2.5C4.375 2.15482 4.65482 1.875 5 1.875H10C10.3452 1.875 10.625 2.15482 10.625 2.5V3.75ZM5.625 3.75H9.375V2.5H5.625V3.75ZM3.75 12.5H11.25V5H3.75V12.5Z" fill="black"/>
                                <path d="M5 6.875H6.25V11.875H5V6.875Z" fill="black"/>
                                <path d="M8.75 6.875H10V11.875H8.75V6.875Z" fill="black"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
