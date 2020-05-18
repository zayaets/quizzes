{{--
@if($errors->has('note'))
    <div class="invalid-feedback d-block">{{ $errors->first('title') }}</div>
@endif--}}

@error($field_name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
