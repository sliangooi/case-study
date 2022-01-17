<div class="alert alert-{{ $alert ?? 'danger' }} fade show">
    @if(!empty($errors) && isset($errors) && $errors->has($session_name ?? 'messages'))
        <i class="{{ $icon ?? ''}} pr-3"></i>{!! $errors->get($session_name ?? 'messages') !!}
    @endif
    @if(session()->has($session_name ?? 'messages'))
        <i class="{{ $icon ?? '' }} pr-3"></i>{!! session()->get($session_name ?? 'messages') !!}
    @endif

    <button type="button" data-dismiss="alert" class="close" aria-hidden="true">&times;</button>
</div>