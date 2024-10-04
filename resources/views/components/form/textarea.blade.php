@props([
    'name',
    'value'=>'',
    'label'=>false
    ])

@if($label)
<label for="">{{$label}}</label>
@endif

<textarea 
    name="{{$name}}"
    {{ $attributes->class([
    'form-control',
    'is-invalid'=>$errors->has('$name')
    ]) }}
>{{ old($name,$value)}}</textarea>
@error($name)
    <div class="invalid-feedback">
        {{$message}} {{-- this variable is special for this directive to print the first error and if you use it in another location in same page will print different value--}}
    </div>
@enderror