@extends('landlord.settings.wrapper')
@section('settings_content')

<!--form-->
<div class="card">
    <div class="card-body" id="landlord-settings-form">


        <!--company-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.company_name')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_name"
                    name="settings_company_name" value="{{ $settings->settings_company_name ?? '' }}">
            </div>
        </div>

        <!--address 1-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.address')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_address_line_1"
                    name="settings_company_address_line_1"
                    value="{{ $settings->settings_company_address_line_1 ?? '' }}">
            </div>
        </div>

        <!--city-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.city')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_city"
                    name="settings_company_city" value="{{ $settings->settings_company_city ?? '' }}">
            </div>
        </div>

        <!--state-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.state')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_state"
                    name="settings_company_state" value="{{ $settings->settings_company_state ?? '' }}">
            </div>
        </div>

        <!--form text tem-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.zipcode')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_zipcode"
                    name="settings_company_zipcode" value="{{ $settings->settings_company_zipcode ?? '' }}">
            </div>
        </div>


        <!--form text tem-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.country')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_country"
                    name="settings_company_country" value="{{ $settings->settings_company_country ?? '' }}">
            </div>
        </div>


        <!--form text tem-->
        <div class="form-group row">
            <label class="col-12 control-label col-form-label">{{ cleanLang(__('lang.telephone')) }}</label>
            <div class="col-12">
                <input type="text" class="form-control form-control-sm" id="settings_company_telephone"
                    name="settings_company_telephone" value="{{ $settings->settings_company_telephone ?? '' }}">
            </div>
        </div>

        <!--submit-->
        <div class="text-right">
            <button type="submit" id="commonModalSubmitButton"
                class="btn btn-rounded-x btn-success waves-effect text-left ajax-request"
                data-url="{{ url('app-admin/settings/company') }}" data-form-id="landlord-settings-form"
                data-loading-target="" data-ajax-type="post" data-type="form"
                data-on-start-submit-button="disable">{{ cleanLang(__('lang.save_changes')) }}</button>
        </div>
    </div>
</div>
@endsection