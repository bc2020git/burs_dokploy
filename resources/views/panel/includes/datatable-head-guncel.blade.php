<thead class="custom-thead">
    <tr>
        <th class="text-center" style="width: 40px;">
            <input type="checkbox" class="form-check-input" id="select-all">
        </th>
        @if(isset($docColumns))
            @php
                // docColumns'ı checkboxColumns'a ekle
                $checkboxColumns = array_merge($checkboxColumns, $docColumns);

                // Tekrarlayan değerleri kaldır
                $checkboxColumns = array_unique($checkboxColumns);
            @endphp
        @endif

        @foreach($columns as $key => $column)

            @if($column['is_visible'])
            <th data-column="{{ $column['name'] }}" data-type="{{ $column['type'] }}">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-nowrap filter-column-title">{{ $column['title'] }}</span>
                    @if($column['filterable'])
                    <div class="dropdown" data-column="{{ $column['name'] }}">
                        <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                        <svg
                            title="Filtreyi Temizle"
                            style="display: none; scale: 1.8;"
                            data-column="{{ $column['name'] }}"
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M11.6673 11.6667V16.6667L8.33398 18.3333V11.6667L3.33398 4.16667V2.5H16.6673V4.16667L11.6673 11.6667ZM5.33707 4.16667L10.0007 11.162L14.6642 4.16667H5.33707Z" fill="#4069E5"/>
                        </svg>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="d-flex flex-column  mb-3 sort-options">
                                @if($column['type'] === 'text')
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="asc">
                                    <i class="fas fa-sort-alpha-down"></i> A'dan Z'ye
                                </div>
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="desc">
                                    <i class="fas fa-sort-alpha-down-alt"></i> Z'den A'ya
                                </div>
                                @elseif($column['type'] === 'number' || $column['type'] === 'int')
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="asc">
                                    <i class="fas fa-sort-numeric-down"></i> Küçükten Büyüğe
                                </div>
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="desc">
                                    <i class="fas fa-sort-numeric-down-alt"></i> Büyükten Küçüğe
                                </div>
                                @elseif($column['type'] === 'date')
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="asc">
                                    <i class="fas fa-sort-date-down"></i> Eskiden Yeniye
                                </div>
                                <div class="sort-option" data-column="{{ $column['name'] }}" data-order="desc">
                                    <i class="fas fa-sort-date-down-alt"></i> Yeniden Eskise
                                </div>
                                @endif
                            </div>

                                @if(in_array($column['name'], $checkboxColumns) || in_array($column['name'], $docColumns))
                                    <div class="checkbox-group">
                                        <div class="checkbox-item">
                                            <input class="form-check-input"
                                                type="checkbox"
                                                id="select_all_{{ $column['name'] }}">
                                            <label class="form-check-label"
                                                for="select_all_{{ $column['name'] }}">
                                                <strong>Tümünü Seç/Kaldır</strong>
                                            </label>
                                        </div>
                                        @foreach($column['filterOptions'] as $key => $option)

                                        <div class="checkbox-item">
                                            <input class="form-check-input {{ $column['name'] }}-check"
                                                type="checkbox"
                                                value="{{ $column['filterValue'] ? $column['filterValue'][$key] : $option }}"
                                                id="{{ $column['name'] }}_{{ Str::slug($option) }}"
                                                data-column="{{ $column['name'] }}"
                                                name="{{ $column['name'] }}[]">
                                            <label class="form-check-label"
                                                for="{{ $column['name'] }}_{{ Str::slug($option) }}">
                                                {{ $option }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <select class="form-select d-none filter-condition" data-column="{{ $column['name'] }}">

                                            <option value="in"></option>
                                    </select>
                                @else
                                <div class="mb-1">
                                    <select class="form-select filter-condition" data-column="{{ $column['name'] }}">
                                        @foreach($column['conditions'] as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    @if($column['type'] === 'date')
                                        <input type="date" class="form-control filter-value" data-column="{{ $column['name'] }}">
                                    @elseif($column['type'] === 'number')
                                        <input type="text" placeholder="Ara"  class="form-control filter-value" data-column="{{ $column['name'] }}">
                                    @elseif($column['type'] === 'select' && isset($column['filterOptions']))
                                        <select class="form-control filter-value" data-column="{{ $column['name'] }}">
                                            <option value="">Seçiniz</option>
                                            @foreach($column['filterOptions'] as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control  w-100 filter-value" placeholder="Ara" data-column="{{ $column['name'] }}">
                                    @endif
                                </div>


                            @endif
                            <div class="dropdown-divider"></div>
                            <div class="d-grid gap-2 mt-2">
                                <span class="btn btn-outline-primary btn-sm apply-filter" data-column="{{ $column['name'] }}">
                                    Filtreyi Uygula
                                </span>
                                <span class="btn btn-outline-danger btn-sm d-none"
                                id="{{ $column['name'] }}_clear_filter"
                                onclick="clearColumnFilter('{{ $column['name'] }}', event)">
                                Filtreyi Temizle
                            </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </th>
            @endif
        @endforeach
        <th>İşlemler</th>
    </tr>
</thead>
