
<div class="tab-pane fade" id="sibling-info" role="tabpanel"
     aria-labelledby="sibling-info-tab" data-content="7">
    <div class="tab-section">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="custom-label">Kendisi Dahil Okuyan Kardeş Sayısı</label>
                <select id="count" class="form-select">
                    <option @if($aday->count == 1) selected @endif value="1">1</option>
                    <option @if($aday->count == 2) selected @endif value="2">2</option>
                    <option @if($aday->count == 3) selected @endif value="3">3</option>
                    <option @if($aday->count == 4) selected @endif value="4">4</option>
                    <option @if($aday->count == '5 ve üzeri') selected @endif value="5 ve üzeri">5 ve üzeri</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label class="custom-label">Kendisi Dahil Kardeş Sayısı</label>
                <input id="educ_count" type="number" class="form-control" value="{{$aday->educ_count}}">
            </div>
        </div>
        <button id="addButtonSibling" type="button" class="btn btn-primary mb-3"
                data-bs-toggle="modal" data-bs-target="#kardesEkleModal"><svg
                xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                viewBox="0 0 20 20" fill="none">
                <path
                    d="M9.16797 9.16663V4.16663H10.8346V9.16663H15.8346V10.8333H10.8346V15.8333H9.16797V10.8333H4.16797V9.16663H9.16797Z"
                    fill="#0065FF" />
            </svg> Kardeş Ekle</button>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Adı</th>
                <th>Soyadı</th>
                <th>Yaşı</th>
                <th>Öğrenim Durumu</th>
                <th>Medeni Durumu</th>
                <th>Mesleği (Çalışıyorsa)</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            @foreach($aday->kardesler as $kardes)
                <tr>
                    <td>{{$kardes->name}}</td>
                    <td>{{$kardes->surname}}</td>
                    <td>{{$kardes->age}}</td>
                    <td>{{$kardes->educ_status}}</td>
                    <td>{{$kardes->maritality}}</td>
                    <td>{{$kardes->job}}</td>
                    <td>
                        <button data-id="{{$kardes->id}}" data-name="{{$kardes->name}}" data-surname="{{$kardes->surname}}"  data-age="{{$kardes->age}}" data-educ_statust="{{$kardes->educ_statust}} data-maritality="{{$kardes->maritality}} data-job="{{$kardes->job}}" class="btn edit-member-info-btn editSiblingBtn" type="button"
                                class="btn btn-primary mb-3 editSiblingBtn" data-bs-toggle="modal"
                                data-bs-target="#kardesDuzenleModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M6.41421 15.89L16.5563 5.74786L15.1421 4.33364L5 14.4758V15.89H6.41421ZM7.24264 17.89H3V13.6473L14.435 2.21232C14.8256 1.8218 15.4587 1.8218 15.8492 2.21232L18.6777 5.04075C19.0682 5.43127 19.0682 6.06444 18.6777 6.45496L7.24264 17.89ZM3 19.89H21V21.89H3V19.89Z" fill="#4069E5"/>
                            </svg></button>
                        <a href="{{route('deleteNewScholarSibling',['id'=>$kardes->id])}}"><button class="btn" type="button" class="btn btn-primary mb-3"
                                                                                                   data-bs-toggle="modal" data-bs-target="#kardesSilModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM9 11V17H11V11H9ZM13 11V17H15V11H13ZM9 4V6H15V4H9Z" fill="#F03000"/>
                                </svg></button></a>
                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
</div>
