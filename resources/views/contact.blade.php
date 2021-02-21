<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('description', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')" />
    <title>@yield('title', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div id="app">
    <main class="main-container">
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
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
</body>
</html>
