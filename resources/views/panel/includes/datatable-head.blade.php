<thead>
    <tr>
        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 25px;">
            <input type="checkbox" class="checkbox" id="masterCheckbox">
        </th>
        @foreach($columns as $column)
                @if($column['visible'])
                <th data-column="{{ $column['name'] }}">
                <div class="dropdown">
                        <div class="column-header d-flex align-items-center"
                             role="button"
                             data-bs-toggle="dropdown"
                             data-bs-auto-close="outside"
                             aria-expanded="false"
                             data-column="{{ $column['name'] }}">
                            {{ $column['title'] }}
                            @if($column['filterable'])
                                <i class="fas fa-chevron-down ms-1"></i>

                                <svg
                                     title="Filtreyi Temizle"
                                     style="display: none;"
                                     data-column="{{ $column['name'] }}"
                                     xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M11.6673 11.6667V16.6667L8.33398 18.3333V11.6667L3.33398 4.16667V2.5H16.6673V4.16667L11.6673 11.6667ZM5.33707 4.16667L10.0007 11.162L14.6642 4.16667H5.33707Z" fill="#4069E5"/>
                                </svg>
                            @endif
                        </div>
                        @if($column['filterable'])
                        <div class="dropdown-menu p-3" style="min-width: 200px;">
                            <div class="sort-options">
                                <div class="sort-option" onclick="sortColumn('{{ $column['name'] }}', 'asc')">
                                    <i class="fas fa-sort-alpha-down"></i> A'dan Z'ye
                                </div>
                                <div class="sort-option" onclick="sortColumn('{{ $column['name'] }}', 'desc')">
                                    <i class="fas fa-sort-alpha-down-alt"></i> Z'den A'ya
                                </div>
                            </div>

                            <div class="filter-container">
                                <div class="filter-header">
                                    <div id="{{ str_replace('.', '_', $column['name']) }}_selected_filters" class="selected-filters"></div>
                                </div>

                                @if(in_array($column['name'], $checkboxColumns))
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
                                @else
                                    @if($column['filterable'])
                                        @if(is_array($column['filterOptions']))
                                            <select class="form-select form-select-sm" id="{{ $column['name'] }}_condition">
                                                @foreach($column['filterOptions'] as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <div class="input-group">
                                            <input
                                                type="{{ $column['filterType'] }}"
                                                class="form-control form-control-sm filter-input"
                                                id="{{ str_replace('.', '_', $column['name']) }}_value"
                                                data-column="{{ $column['name'] }}"
                                                placeholder="Filtre girin..."
                                            >
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="d-grid gap-2 mt-2">
                                <span class="btn btn-outline-primary btn-sm" onclick="applyColumnFilter('{{ $column['name'] }}')">
                                    Filtreyi Uygula
                                </span>
                                <span class="btn btn-outline-danger btn-sm d-none"
                                    id="{{ str_replace('.', '_', $column['name']) }}_clear_filter"
                                    onclick="clearColumnFilter('{{ $column['name'] }}', event)">
                                    Filtreyi Temizle
                                </span>
                            </div>
                        </div>
                        @endif

                    </div>

                </th>
                @endif

        @endforeach
        <th> İşlemler </th>
    </tr>
</thead>
