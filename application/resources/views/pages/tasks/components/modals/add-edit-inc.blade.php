<div class="row">
    <div class="col-lg-12">

      <!--title-->
      <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.task_type')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="task_type" name="task_type"
                    placeholder="Call"> 
                    <input type="hidden" name="transport_type" id="transport_type">
                    <ul class="nav nav-tabs mt-2" role="tablist">
                        <li class="nav-item"> <a class="nav-link active ajax-request" id="call" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="sl-icon-call-in"></i></a></li>
                        <li class="nav-item"> <a class="nav-link ajax-request" id="meeting" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="sl-icon-people"></i></a></li>
                        <li class="nav-item"> <a class="nav-link ajax-request" id="task" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="ti-timer"></i></a></li>
                        <li class="nav-item"> <a class="nav-link ajax-request" id="deadline" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="sl-icon-flag"></i></a></li>
                        <li class="nav-item"> <a class="nav-link ajax-request" id="email" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="sl-icon-envelope"></i></a></li>
                        <li class="nav-item"> <a class="nav-link ajax-request" id="lunch" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="ti-receipt"></i></a></li>
                       <li class="nav-item"> <a class="nav-link ajax-request" id="transport" data-toggle="tab" href="javascript:void(0);"
                        role="tab" data-loading-class="loading-before-centre" data-loading-target="card-tasks-left-panel">
                        <i class="sl-icon-layers"></i></a></li>
                </ul> 
                <span><input type="text" class="form-control pickadate task-extra" id="from_date"  name="from_date" placeholder="from"></span>
                <span><input type="time" class="task-extra"  name="from_time"></span>
                --
                <span><input type="time" class="task-extra"  name="to_time"></span>
                <span><input type="text" class="form-control pickadate task-extra" id="to_date" name="to_date" placeholder="to"></span>
            </div>

        </div>

        <!--title-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.title')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm" id="task_title" name="task_title"
                    placeholder="">
            </div>
        </div>

        @if(config('visibility.task_modal_milestone_option'))
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.milestone')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <select name="task_milestoneid" id="task_milestoneid"
                    class="select2-basic form-control form-control-sm">
                    @if(isset($milestones))
                    @foreach($milestones as $milestone)
                    <option value="{{ $milestone->milestone_id }}">
                        {{ runtimeLang($milestone->milestone_title, 'task_milestone') }}</option>
                    @endforeach
                    @endif
                    <!--/#users list-->
                </select>
            </div>
        </div>
        @endif

        <!--task status-->
        @if(request('status') != '')
        <input type="hidden" name="task_status" value="{{ request('status') }}">
        @else
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.status')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="task_status" name="task_status">
                    @foreach($statuses as $status)
                    <option value="{{ $status->taskstatus_id }}">{{ runtimeLang($status->taskstatus_title) }}
                    </option>
                    @endforeach

                </select>
            </div>
        </div>
        @endif


        <!--task priority-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.priority')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <select class="select2-basic form-control form-control-sm" id="task_priority" name="task_priority">
                    <option value="normal">{{ cleanLang(__('lang.normal')) }}</option>
                    <option value="high">{{ cleanLang(__('lang.high')) }}</option>
                    <option value="urgent">{{ cleanLang(__('lang.urgent')) }}</option>
                    <option value="low">{{ cleanLang(__('lang.low')) }}</option>
                </select>
            </div>
        </div>

        <!--assigned [team users]-->
        @if(auth()->user()->role->role_assign_tasks == 'yes' && config('visibility.tasks_standard_features'))
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.assign_users')) }}
                <a class="align-middle font-16 toggle-collapse" href="#assigning_info" role="button"><i
                        class="ti-info-alt text-themecontrast"></i></a></label>
            <div class="col-sm-12 col-lg-9">
                @if(config('visibility.projects_assigned_users'))
                <select name="assigned" id="assigned"
                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true">
                    @foreach(config('project.assigned') as $user)
                    @if($user->type =='team')
                    <option value="{{ $user->id}}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endif
                    @endforeach
                </select>
                @else
                <select name="assigned" id="assigned"
                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true">
                       @if(auth()->user()->role_id  == 15)
                       @foreach(config('project.users') as $user)
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $assigned ?? []) }}>{{
                            $user->full_name }}</option>
                        @endforeach
                       @else
                       @foreach(config('system.team_members') as $user)
                        <option value="{{ $user->id }}"
                            {{ runtimePreselectedInArray($user->id ?? '', $assigned ?? []) }}>{{
                            $user->full_name }}</option>
                        @endforeach
                       @endif
                </select>
                @endif
            </div>
        </div>
        <div class="collapse" id="assigning_info">
            <div class="alert alert-info">
                {{ cleanLang(__('lang.assigning_users_to_a_task_info')) }}
            </div>
        </div>
        @endif



        <!--assigned [client users]-->
        @if(auth()->user()->role->role_assign_tasks == 'yes' && config('visibility.tasks_standard_features') && auth()->user()->role_id != 15)
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">@lang('lang.assign_client')
                <a class="align-middle font-16 toggle-collapse" href="#assigning_client_info" role="button"><i
                        class="ti-info-alt text-themecontrast"></i></a></label>
            <div class="col-sm-12 col-lg-9">
                @if(config('visibility.projects_assigned_users'))
                <select name="assigned-client" id="assigned-client"
                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true">
                    @foreach(config('project.client_users') as $user)
                    <option value="{{ $user->id}}">{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
                @else
                <select name="assigned-client" id="assigned-client"
                    class="form-control form-control-sm select2-basic select2-multiple select2-tags select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true" disabled>
                </select>
                @endif
            </div>
        </div>
        <div class="collapse" id="assigning_client_info">
            <div class="alert alert-info">
                @lang('lang.assign_client_info')
            </div>
        </div>
        @endif

        <!--spacer-->
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title">{{ cleanLang(__('lang.select_project')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="show_project_field" id="show_project_field"
                            class="js-switch-toggle-hidden-content" data-target="show_project">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--spacer-->  
        
        @if(config('visibility.task_modal_project_option'))
        <!--project-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.project')) }}*</label>
            <div class="col-sm-12 col-lg-9 hidden" id="show_project">
                <select name="task_projectid" id="task_projectid"
                    class="projects_assigned_toggle projects_assigned_client_toggle form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                    data-assigned-dropdown="assigned" data-client-assigned-dropdown="assigned-client"
                    data-ajax--url="{{ url('/') }}/feed/projects?ref=general"></select>
            </div>
        </div>
        @endif


        <!--CUSTOMER FIELDS [expanded]-->
        @if(config('system.settings_customfields_display_tasks') == 'expanded')
        @include('misc.customfields')
        @endif
        <!--/#CUSTOMER FIELDS [expanded]-->

        <div class="line"></div>
        <!--spacer-->
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title">{{ cleanLang(__('lang.description')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="show_more_settings_tasks" id="show_more_settings_tasks"
                            class="js-switch-toggle-hidden-content" data-target="task_description_section">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--spacer-->

        <!--description-->
        <div class="hidden" id="task_description_section">
            <div class="form-group row">
                <div class="col-sm-12">
                    <textarea id="project_description" name="task_description"
                        class="tinymce-textarea">{{ $task->task_description ?? '' }}</textarea>
                </div>
            </div>
        </div>



        <!--CUSTOMER FIELDS [collapsed]-->
        @if(config('system.settings_customfields_display_tasks') == 'toggled')
        <!--<div class="spacer row">-->
        <!--    <div class="col-sm-12 col-lg-8">-->
        <!--        <span class="title">{{ cleanLang(__('lang.more_information')) }}</span class="title">-->
        <!--    </div>-->
        <!--    <div class="col-sm-12 col-lg-4">-->
        <!--        <div class="switch  text-right">-->
        <!--            <label>-->
        <!--                <input type="checkbox" name="add_client_option_other" id="add_client_option_other"-->
        <!--                    class="js-switch-toggle-hidden-content" data-target="leads_custom_fields_collaped">-->
        <!--                <span class="lever switch-col-light-blue"></span>-->
        <!--            </label>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <div id="leads_custom_fields_collaped" class="hidden">
            @if(config('app.application_demo_mode'))
            <!--DEMO INFO-->
            <div class="alert alert-info">
                <h5 class="text-info"><i class="sl-icon-info"></i> Demo Info</h5>
                These are custom fields. You can change them or <a
                    href="{{ url('app/settings/customfields/projects') }}">create your own.</a>
            </div>
            @endif

            @include('misc.customfields')
        </div>
        @endif
        <!--/#CUSTOMER FIELDS [collapsed]-->

        @if(config('visibility.task_modal_additional_options'))
        <!--spacer-->
        <div class="spacer row">
            <div class="col-sm-12 col-lg-8">
                <span class="title">{{ cleanLang(__('lang.options')) }}</span class="title">
            </div>
            <div class="col-sm-12 col-lg-4">
                <div class="switch  text-right">
                    <label>
                        <input type="checkbox" name="show_more_settings_tasks2" id="show_more_settings_tasks2"
                            class="js-switch-toggle-hidden-content" data-target="additional_information_section">
                        <span class="lever switch-col-light-blue"></span>
                    </label>
                </div>
            </div>
        </div>
        <!--spacer-->
        <!--option toggle-->
        <div class="hidden" id="additional_information_section">

            <!--due date-->
            @if(config('visibility.tasks_standard_features'))
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.target_date')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" class="form-control form-control-sm pickadate" name="task_date_due"
                        autocomplete="off" placeholder="">
                    <input class="mysql-date" type="hidden" name="task_date_due" id="task_date_due">
                </div>
            </div>
            @endif


            <!--tags-->
            <div class="form-group row">
                <label
                    class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.tags')) }}</label>
                <div class="col-sm-12 col-lg-9">
                    <select name="tags" id="tags"
                        class="form-control form-control-sm select2-multiple {{ runtimeAllowUserTags() }} select2-hidden-accessible"
                        multiple="multiple" tabindex="-1" aria-hidden="true">
                        <!--array of selected tags-->
                        @if(isset($page['section']) && $page['section'] == 'edit')
                        @foreach($lead->tags as $tag)
                        @php $selected_tags[] = $tag->tag_title ; @endphp
                        @endforeach
                        @endif
                        <!--/#array of selected tags-->
                        @foreach($tags as $tag)
                        <option value="{{ $tag->tag_title }}"
                            {{ runtimePreselectedInArray($tag->tag_title ?? '', $selected_tags  ?? []) }}>
                            {{ $tag->tag_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <!--[toggled] project options-->
            <div class="toggle_task_type add_task_toggle_container_project">
                <div class="form-group form-group-checkbox row">
                    <div class="col-12 p-t-5">
                        <div class="pull-left min-w-200">
                            <label>{{ cleanLang(__('lang.visible_to_client')) }}</label>
                        </div>
                        <div class="pull-left p-l-10">
                            @if(isset($page['section']) && $page['section'] == 'create')
                            <input type="checkbox" id="task_client_visibility" name="task_client_visibility"
                                {{ runtimeTasksDefaults('task_client_visibility') }}
                                class="filled-in chk-col-light-blue">
                            @endif
                            @if(isset($page['section']) && $page['section'] == 'edit')
                            <input type="checkbox" id="task_client_visibility" name="task_client_visibility"
                                class="filled-in chk-col-light-blue">
                            @endif
                            <label for="task_client_visibility"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-checkbox row">
                    <div class="col-12 p-t-5">
                        <div class="pull-left min-w-200">
                            <label>{{ cleanLang(__('lang.billable')) }}</label>
                        </div>
                        <div class="pull-left p-l-10">
                            @if(isset($page['section']) && $page['section'] == 'create')
                            <input type="checkbox" id="task_billable" name="task_billable"
                                {{ runtimeTasksDefaults('task_billable') }} class="filled-in chk-col-light-blue">
                            @endif
                            @if(isset($page['section']) && $page['section'] == 'edit')
                            <input type="checkbox" id="task_billable" name="task_billable"
                                class="filled-in chk-col-light-blue">
                            @endif
                            <label for="task_billable"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--option toggle-->
        @endif


        <!--redirect to project-->
        @if(config('visibility.task_show_task_option'))
        <div class="line"></div>
        <div class="form-group form-group-checkbox row">
            <div class="col-12 text-left p-t-5">
                <input type="checkbox" id="show_after_adding" name="show_after_adding"
                    class="filled-in chk-col-light-blue" checked="checked">
                <label for="show_after_adding">{{ cleanLang(__('lang.show_task_after_adding')) }}</label>
            </div>
        </div>
        @endif

        <!--pass source-->
        <input type="hidden" name="source" value="{{ request('source') }}">
        <input type="hidden" name="ref" value="{{ request('ref') }}">

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        
        var currentDate = new Date();
        var formattedDate = `${currentDate.getDate().toString().padStart(2, '0')}-${(currentDate.getMonth() + 1).toString().padStart(2, '0')}-${currentDate.getFullYear()}`;
        $('input[name="from_date"]').val(formattedDate);
        $('input[name="to_date"]').val(formattedDate);
        $('#from_date').val(formattedDate);
        $('#to_date').val(formattedDate);
    });    
    $(document).on('click','.nav-item',function(){
        var tab = $(this).find('a').attr('id')
        $("#transport_type").val(tab);
        tab = tab.toUpperCase();
        $("#task_type").attr('placeholder',tab);
        
    })
</script>