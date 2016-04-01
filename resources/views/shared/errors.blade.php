@if(Input::get('error') && isset($errors[Input::get('error')]))
    <?php $error = $errors[Input::get('error')]; ?>
    <div class="alert alert-{{ $error['type'] }}">
        {!! $error['text'] !!}
    </div>
@endif
