@if(Input::get('error') && isset($errors[Input::get('error')]))
    <?php $error = $errors[Input::get('error')]; ?>
    <div class="alert alert-{{ $error['type'] }}">
        {!! $error['text'] !!}
        @if(!empty(Input::get('error_text')))
            &mdash; {{ Input::get('error_text') }}
        @endif
    </div>
@endif
