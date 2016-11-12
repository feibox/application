@if($errors->has($attributeName))
    <div class="has-error">
        <div class="form-group">
            <label for="{{ class_case($attributeName) }}"
                   class="text-uppercase text-danger">{{ human_readable($attributeName) }}</label>
            <input {!! $password or 'type="text"' !!}  class="form-control" name="{{ $attributeName }}" id="{{ class_case($attributeName) }}"
                   {!! $required or '' !!} value="{{ isset($attributeValue) ? old($attributeName, $attributeValue) : '' }}">
        </div>
        @foreach($errors->get($attributeName) as $error)
            <p class="help-block">{{ $error }}</p>
        @endforeach
    </div>
@else
    <div class="form-group">
        <label for="{{ class_case($attributeName) }}"
               class="text-uppercase">{{ human_readable($attributeName) }}</label>
        <input {!! $password or 'type="text"' !!} class="form-control" name="{{ $attributeName }}" id="{{ class_case($attributeName) }}"
               {!! $required or '' !!} value="{{ isset($attributeValue) ? old($attributeName, $attributeValue) : '' }}">
        @if(isset($helpBlock))
            <p class="help-block">{!! $helpBlock !!}</p>
        @endif
    </div>
@endif