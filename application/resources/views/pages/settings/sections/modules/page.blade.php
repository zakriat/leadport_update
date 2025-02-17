@extends('pages.settings.ajaxwrapper')
@section('settings-page')
<!--settings-->
<div class="table-responsive">
    <form>
        <table id="demo-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap app-modules" data-page-size="10">
            <thead>
                <tr>
                    <th class="">@lang('lang.module')</th>
                    <th class="w-px-100">@lang('lang.enabled')</th>
                </tr>
            </thead>
            <tbody>

                <!--projects-->
                <tr>
                    <td>@lang('lang.projects')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_projects" name="settings_modules_projects"
                                    {{ runtimePrechecked($settings->settings_modules_projects) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_projects"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--tasks-->
                <tr>
                    <td>@lang('lang.tasks') - <small>(@lang('lang.linked_to_projects'))</small></td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_tasks" name="settings_modules_tasks"
                                    {{ runtimePrechecked($settings->settings_modules_tasks) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_tasks"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--invoices-->
                <tr>
                    <td>@lang('lang.invoices')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_invoices" name="settings_modules_invoices"
                                    {{ runtimePrechecked($settings->settings_modules_invoices) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_invoices"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--payments-->
                <tr>
                    <td>@lang('lang.payments')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_payments" name="settings_modules_payments"
                                    {{ runtimePrechecked($settings->settings_modules_payments) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_payments"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--leads-->
                <tr>
                    <td>@lang('lang.leads')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_leads" name="settings_modules_leads"
                                    {{ runtimePrechecked($settings->settings_modules_leads) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_leads"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--knowledgebase-->
                <tr>
                    <td>@lang('lang.knowledgebase')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_knowledgebase"
                                    name="settings_modules_knowledgebase"
                                    {{ runtimePrechecked($settings->settings_modules_knowledgebase) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_knowledgebase"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--estimates-->
                <tr>
                    <td>@lang('lang.estimates')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_estimates" name="settings_modules_estimates"
                                    {{ runtimePrechecked($settings->settings_modules_estimates) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_estimates"></label>
                            </div>
                        </div>
                    </td>
                </tr>


                <!--proposals-->
                <tr>
                    <td>@lang('lang.proposals')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_proposals" name="settings_modules_proposals"
                                    {{ runtimePrechecked($settings->settings_modules_proposals) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_proposals"></label>
                            </div>
                        </div>
                    </td>
                </tr>


                <!--contracts-->
                <tr>
                    <td>@lang('lang.contracts')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_contracts" name="settings_modules_contracts"
                                    {{ runtimePrechecked($settings->settings_modules_contracts) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_contracts"></label>
                            </div>
                        </div>
                    </td>
                </tr>



                <!--expenses-->
                <tr>
                    <td>@lang('lang.expenses')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_expenses" name="settings_modules_expenses"
                                    {{ runtimePrechecked($settings->settings_modules_expenses) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_expenses"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--subscriptions-->
                <tr>
                    <td>@lang('lang.subscriptions')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_subscriptions"
                                    name="settings_modules_subscriptions"
                                    {{ runtimePrechecked($settings->settings_modules_subscriptions) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_subscriptions"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--tickets-->
                <tr>
                    <td>@lang('lang.tickets')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_tickets" name="settings_modules_tickets"
                                    {{ runtimePrechecked($settings->settings_modules_tickets) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_tickets"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--messages-->
                <tr>
                    <td>@lang('lang.messages') (@lang('lang.instant_messaging'))</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_messages" name="settings_modules_messages"
                                    {{ runtimePrechecked($settings->settings_modules_messages) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_messages"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--time_tracking-->
                <tr>
                    <td>@lang('lang.time_tracking') - <small>(@lang('lang.linked_to_tasks'))</small></td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_timetracking"
                                    name="settings_modules_timetracking"
                                    {{ runtimePrechecked($settings->settings_modules_timetracking) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_timetracking"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--spaces-- [FUTURE] also enable in SettingsRepository
                <tr>
                    <td>@lang('lang.spaces')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_spaces" name="settings_modules_spaces"
                                    {{ runtimePrechecked($settings->settings_modules_spaces) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_spaces"></label>
                            </div>
                        </div>
                    </td>
                </tr>
            -->

                <!--reminders-->
                <tr>
                    <td>@lang('lang.reminders')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_reminders" name="settings_modules_reminders"
                                    {{ runtimePrechecked($settings->settings_modules_reminders) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_reminders"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--calendar-->
                <tr>
                    <td>@lang('lang.calendar')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_calendar" name="settings_modules_calendar"
                                    {{ runtimePrechecked($settings->settings_modules_calendar) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_calendar"></label>
                            </div>
                        </div>
                    </td>
                </tr>

                <!--reports-->
                <tr>
                    <td>@lang('lang.reports')</td>
                    <td>
                        <div class="form-group form-group-checkbox m-0 p-0">
                            <div class="col-2 text-right m-0 p-0">
                                <input type="checkbox" id="settings_modules_reports" name="settings_modules_reports"
                                    {{ runtimePrechecked($settings->settings_modules_reports) }}
                                    class="filled-in chk-col-light-blue">
                                <label class="m-0 p-0" for="settings_modules_reports"></label>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>

        @if(config('system.settings_type') == 'standalone')
        <!--[standalone] - settings documentation help-->
        <div>
            <a href="https://growcrm.io/documentation" target="_blank" class="btn btn-sm btn-info help-documentation"><i
                    class="ti-info-alt"></i>
                {{ cleanLang(__('lang.help_documentation')) }}
            </a>
        </div>
        @endif

        <div class="text-right">
            <button type="submit" id="commonModalSubmitButton"
                class="btn btn-rounded-x btn-success waves-effect text-left ajax-request"
                data-url="{{url('/settings/modules') }}" data-loading-target="" data-ajax-type="PUT" data-type="form"
                data-on-start-submit-button="disable">@lang('lang.save_changes')</button>
        </div>
    </form>
</div>
@endsection