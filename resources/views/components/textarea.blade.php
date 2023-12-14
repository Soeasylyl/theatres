@php($inputId = uniqid())
@props(['input_required' => false,
        'inputAttributes' => [
            'type' => 'text',
            'name' => 'name',
            ],
            'errorAttribute' => 'name',
            'textContent' => '',
        ])

<div class="input-container">
    <div class="input-wrapper">
        <textarea {{$attributes->merge($inputAttributes)}}
               id="{{$inputId}}">{{$textContent}}</textarea>

        <label {{$attributes->class([
                    ($input_required ? 'input_required': ''),
                ])}}
               for="{{$inputId}}">
            <span>{{ $slot }}</span>
        </label>

        @error($errorAttribute)
        <div class="error-message">
            {{$message}}
        </div>
        @enderror
    </div>
</div>

