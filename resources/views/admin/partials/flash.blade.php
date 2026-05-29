<div id="flash-data"
    data-type="{{ session('flash.type') }}"
    data-message="{{ session('flash.message') }}">
</div>
@if($errors->any())
    <div id="validation-errors" data-errors='@json($errors->all())'></div>
@endif
