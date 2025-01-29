@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<!--settings-->
<form class="form">

    <div class="form-group form-group-checkbox row">
        <label class="col-4 col-form-label">{{ cleanLang(__('lang.allow_user_tags')) }}</label>
        <div class="col-8 p-t-5">
            <input type="checkbox" id="settings_tags_allow_users_create" name="settings_tags_allow_users_create"
                class="filled-in chk-col-light-blue"
                {{ runtimePrechecked($settings['settings_tags_allow_users_create'] ?? '') }}>
            <label for="settings_tags_allow_users_create"></label>
        </div>
    </div>

    <div class="text-right">
        <button type="submit" id="commonModalSubmitButton"
            class="btn btn-rounded-x btn-success waves-effect text-left js-ajax-ux-request" data-url="/settings/tags"
            data-loading-target="" data-ajax-type="PUT" data-type="form"
            data-on-start-submit-button="disable">{{ cleanLang(__('lang.save_changes')) }}</button>
    </div>
</form>

@if(config('system.settings_type') == 'standalone')
<!--[standalone] - settings documentation help-->
<a href="https://growcrm.io/documentation" target="_blank" class="btn btn-sm btn-info help-documentation"><i
        class="ti-info-alt"></i>
    {{ cleanLang(__('lang.help_documentation')) }}
</a>
@endif

@endsection