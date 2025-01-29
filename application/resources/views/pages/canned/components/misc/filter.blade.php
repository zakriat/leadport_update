<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-canned">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>@lang('lang.filter_canned')
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-canned"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--single filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.company_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <!--select2 basic search-->
                                <select name="filter_company_name" id="filter_company_name"
                                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-ajax--url="{{ url('/feed/company_names') }}"></select>
                                <!--select2 basic search-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--single filter fooo-->

                <!--single filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.project_title')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_project" id="filter_project"
                                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-ajax--url="{{ url('/feed/projects?ref=general') }}"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--single filter fooo-->

                <!--filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.fooo_amount')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_fooo_amount_min" id="filter_fooo_amount_min"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.min')) }}">
                            </div>
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_fooo_amount_max" id="filter_fooo_amount_max"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.max')) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter fooo-->

                <!--filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.payments')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_payments_amount_min" id="filter_payments_amount_min"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.minimum')) }}">
                            </div>
                            <div class="col-md-6 input-group input-group-sm">
                                <span class="input-group-addon">{{ config('system.settings_system_currency_symbol') }}</span>
                                <input type="number" name="filter_payments_amount_max" id="filter_payments_amount_max"
                                    class="form-control form-control-sm" placeholder="{{ cleanLang(__('lang.maximum')) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter fooo-->

                <!--filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.date_created')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_date_created_start" 
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start">
                                <input class="mysql-date" type="hidden" name="filter_date_created_start" id="filter_date_created_start"value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_date_created_end" 
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="End">
                                <input class="mysql-date" type="hidden" name="filter_date_created_end"
                                    id="filter_date_created_end" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter fooo-->


                <!--filter fooo-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.due_date')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_date_due_start" 
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}">
                                <input class="mysql-date" type="hidden" name="filter_date_due_start" id="filter_date_due_start"value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_date_due_end" 
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="{{ cleanLang(__('lang.end')) }}">
                                <input class="mysql-date" type="hidden" name="filter_date_due_end" id="filter_date_due_end"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter fooo-->
                <!--buttons-->
                <div class="buttons-block">
                    <button type="button" name="fooo1"
                        class="btn btn-rounded-x btn-secondary js-reset-filter-side-panel">{{ cleanLang(__('lang.reset')) }}</button>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-success js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/canned/search?') }}"
                        data-type="form" data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->