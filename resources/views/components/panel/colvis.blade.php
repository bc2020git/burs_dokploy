<div class="dropdown-columns">
    <button type="button" class="btn btn-primary me-3" id="column" data-bs-toggle="dropdown"
            aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="left" title="Sütunlar">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
             fill="none">
            <path
                d="M9.16667 4.16667H4.16667V15.8333H9.16667V4.16667ZM10.8333 4.16667V15.8333H15.8333V4.16667H10.8333ZM3.33333 2.5H16.6667C17.1269 2.5 17.5 2.8731 17.5 3.33333V16.6667C17.5 17.1269 17.1269 17.5 16.6667 17.5H3.33333C2.8731 17.5 2.5 17.1269 2.5 16.6667V3.33333C2.5 2.8731 2.8731 2.5 3.33333 2.5Z"
                fill="#0065FF" />
        </svg>
    </button>
    <div class="dropdown-menu" aria-labelledby="column">
        @foreach($columns as $column)
        @if($column['visible'] == true)
        <div class="form-check">
            <input class="form-check-input column-visibility"
                   type="checkbox"
                   id="{{ $column['name'] }}Checkbox"
                   data-column="{{ $column['name'] }}"
                   checked>
            <label class="form-check-label" for="{{ $column['name'] }}Checkbox">
                {{ $column['title'] }}
            </label>
        </div>
        @endif
        @endforeach
    </div>
</div>

