@props([
    'type'=>'text',
    'name',
    'value'=>'',
    'label'=>false
    ])

@if($label)
<label for="">{{$label}}</label>
@endif
<input 
    type="{{$type}}"
    name="{{$name}}"
    {{ $attributes->class([
    'form-control',
    'is-invalid'=>$errors->has('$name')
    ]) }}
    value="{{ old($name,$value)}}" 
>

@error($name)
    <div class="invalid-feedback">
        {{ $message }} {{-- this variable is special for this directive to print the first error and if you use it in another location in same page will print different value--}}
    </div>
@enderror