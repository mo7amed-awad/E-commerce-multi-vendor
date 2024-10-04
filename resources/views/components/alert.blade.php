{{-- @props([
    $type='defult',$message='defult'
])
it is optional to declare variables and assign defult value to it --}}

{{--
  {{$attributs}}
  is used to recive all varibles that isn't decalre in component    
    
    
--}}
@if (session()->has($type))
    <div class="alert alert-{{$type}}">
        {{session($type)}}
</div>
@endif

