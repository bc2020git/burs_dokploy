<div class="container">
    <h2>Sorular</h2>

    @foreach($sorular as $soru)
        <div class="mb-4">

            @if($soru->type === 'select')
                <label for="soru_{{ $soru->id }}">{{ $soru->title }}</label>
                <select name="{{$soru->db_key}}" id="soru_{{ $soru->id }}" class="form-control">
                    @if(json_decode($soru->options))
                    @foreach(json_decode($soru->options) as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                    @endif
                </select>
            @else
                <label for="soru_{{ $soru->id }}">{{ $soru->title }}</label>
                <input name="{{$soru->db_key}}" id="soru_{{ $soru->id }}" type="{{$soru->type}}">
            @endif
        </div>
    @endforeach
</div>
