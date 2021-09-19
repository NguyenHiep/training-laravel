@extends('layouts.app')

@section('title', 'Liên hệ với review công ty - Giải đáp thắc mắc - Yêu cầu xóa review')
@section('description', 'Liên hệ với review công ty - Review công ty - Giải đáp thắc mắc - Yêu cầu xóa review')

@section('content')
    <section class="container main-content">
        <div class="row">
            <div class="col-12 col-lg-12">
                <article class="message is-info">
                    <div class="message-header mb-3">
                        <h1 class="title is-size-4 has-text-white">{{ __('common.contact.title') }}</h1>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (!empty(session('message')))
                        <div class="alert alert-success">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="message-body is-size-4 help-section mt-3">
                        <form action="{{ route('contact.store') }}" method="post" id="frm-contact">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('common.contact.name') }}</label>
                                    <input name="name" type="text" class="form-control" value="{{ old('name') }}" id="name" placeholder="{{ __('common.contact.placeholder_name') }}" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('common.contact.email') }}</label>
                                    <input name="email" type="email" class="form-control" value="{{ old('email') }}" id="email" placeholder="{{ __('common.contact.placeholder_email') }}" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="content">{{ __('common.contact.content') }}</label>
                                <textarea name="content" class="form-control" id="content" rows="3" minlength="20" maxlength="300" placeholder="{{ __('common.contact.placeholder_content') }}" required>{{ old('content') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('common.contact.send') }}</button>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('site.site_key_google') }}"></script>
    <script>
        function submitContactForm() {
            window.grecaptcha.ready(function () {
                var $formContact = $('form[id="frm-contact"]');
                if ($formContact.length) {
                    $formContact.submit(function (e) {
                        e.preventDefault();
                        var action = 'contact/submit';
                        window.grecaptcha.execute("{{ config('site.site_key_google') }}", {action: action}).then(function (token) {
                            var $recaptchaAction = $('#recaptcha_action');
                            var $recaptchaToken = $('#recaptcha_token');
                            if ($recaptchaAction.length) {
                                $recaptchaAction.val(action);
                            } else {
                                $formContact.append('<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />');
                            }
                            if ($recaptchaToken.length) {
                                $recaptchaToken.val(token);
                            } else {
                                $formContact.append('<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />');
                            }
                            $formContact.unbind('submit').submit();
                        });
                    });
                } // End if
            })
        }
        $(document).ready(function () {
            submitContactForm();
        });
    </script>
@endpush
