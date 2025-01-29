<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for projects
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class ProjectRepository {

    /**
     * The projects repository instance.
     */
    protected $projects;

    /**
     * Inject dependecies
     */
    public function __construct(Project $projects) {
        $this->projects = $projects;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object project collection
     */
    public function search($id = '', $data = []) {

        $projects = $this->projects->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        // select all
        $projects->leftJoin('clients', 'clients.client_id', '=', 'projects.project_clientid');
        $projects->leftJoin('categories', 'categories.category_id', '=', 'projects.project_categoryid');
        $projects->leftJoin('users', 'users.id', '=', 'projects.project_creatorid');

        //join: users reminders - do not do this for cronjobs
        if (auth()->check()) {
            $projects->leftJoin('reminders', function ($join) {
                $join->on('reminders.reminderresource_id', '=', 'projects.project_id')
                    ->where('reminders.reminderresource_type', '=', 'project')
                    ->where('reminders.reminder_userid', '=', auth()->id());
            });
        }

        $projects->selectRaw('*');

        //count al tasks
        $projects->selectRaw("(SELECT filefolder_id
                                      FROM file_folders
                                      WHERE filefolder_projectid = projects.project_id
                                      LIMIT 1)
                                      AS default_folder_id");
        //count al tasks
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM tasks
                                      WHERE task_projectid = projects.project_id)
                                      AS count_all_tasks");

        //count completed tasks
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM tasks
                                      WHERE task_projectid = projects.project_id
                                      AND task_status IN('completed', 2))
                                      AS count_completed_tasks");

        //count pending tasks
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM tasks
                                      WHERE task_projectid = projects.project_id
                                      AND task_status NOT IN('completed', 2))
                                      AS count_pending_tasks");

        //project progress - task based
        $projects->selectRaw("(SELECT COALESCE(count_completed_tasks/count_all_tasks*100, 0))
                                               AS task_based_progress");

        //sum invoices: all
        $projects->selectRaw("(SELECT COALESCE(SUM(bill_final_amount), 0.00)
                                      FROM invoices
                                      WHERE bill_projectid = projects.project_id
                                      AND bill_invoice_type = 'onetime')
                                      AS sum_invoices_all");

        //sum payments: all
        $projects->selectRaw("(SELECT COALESCE(SUM(payment_amount), 0.00)
                                      FROM payments
                                      WHERE payment_projectid = projects.project_id
                                      AND payment_type = 'invoice')
                                      AS sum_all_payments");

        //sum invoices: due
        $projects->selectRaw("(SELECT COALESCE(SUM(bill_final_amount), 0.00)
                                      FROM invoices
                                      WHERE bill_projectid = projects.project_id
                                      AND bill_invoice_type = 'onetime'
                                      AND bill_status = 'due')
                                      AS sum_invoices_due");

        //sum invoices: overdue
        $projects->selectRaw("(SELECT COALESCE(SUM(bill_final_amount), 0.00)
                                      FROM invoices
                                      WHERE bill_projectid = projects.project_id
                                      AND bill_invoice_type = 'onetime'
                                      AND bill_status = 'overdue')
                                      AS sum_invoices_overdue");

        //sum invoices: unpaid
        $projects->selectRaw("(SELECT COALESCE(SUM(bill_final_amount), 0.00)
                                      FROM invoices
                                      WHERE bill_projectid = projects.project_id
                                      AND bill_invoice_type = 'onetime'
                                      AND bill_status NOT IN ('paid, draft'))
                                      AS sum_invoices_unpaid");

        //invoice balance
        $projects->selectRaw('(SELECT COALESCE(sum_invoices_all - sum_all_payments, 0.00))
                                      AS sum_outstanding_balance');

        //sum invoices: paid
        $projects->selectRaw("(SELECT COALESCE(SUM(bill_final_amount), 0.00)
                                      FROM invoices
                                      WHERE bill_projectid = projects.project_id
                                      AND bill_invoice_type = 'onetime'
                                      AND bill_status = 'paid')
                                      AS sum_invoices_paid");

        //sum expenses
        $projects->selectRaw("(SELECT COALESCE(SUM(expense_amount), 0.00)
                                      FROM expenses
                                      WHERE expense_projectid = projects.project_id)
                                      AS sum_expenses");

        //count all fiules
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM files
                                      WHERE fileresource_type = 'project'
                                      AND fileresource_id = projects.project_id)
                                      AS count_files");

        //count tickets open
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM tickets
                                      WHERE ticket_status NOT IN (2)
                                      AND ticket_projectid = projects.project_id)
                                      AS count_tickets_open");

        //count tickets closed
        $projects->selectRaw("(SELECT COUNT(*)
                                      FROM tickets
                                      WHERE ticket_status = 2
                                      AND ticket_projectid = projects.project_id)
                                      AS count_tickets_closed");

        //sum_hours
        $projects->selectRaw("COALESCE((SELECT SUM(timer_time)
                                      FROM timers
                                      WHERE timer_status = 'stopped'
                                      AND timer_projectid = projects.project_id), 0)
                                      AS sum_hours");

        //default where
        $projects->whereRaw("1 = 1");

        //[project or templates or spaces etc]
        if (request()->filled('filter_project_type')) {
            $projects->where('project_type', request('filter_project_type'));
        } else {
            $projects->where('project_type', 'project');
        }

        //filter for active or archived (default to active) - do not use this when a project id has been specified
        if (!is_numeric($id)) {
            if (!request()->filled('filter_show_archived_projects') && !request()->filled('filter_project_state')) {
                $projects->where('project_active_state', 'active');
            }
        }

        //params: project id
        if (is_numeric($id)) {
            $projects->where('project_id', $id);
        }

        //[data filter] - clients
        if (isset($data['project_clientid'])) {
            $projects->where('project_clientid', $data['project_clientid']);
        }

        //[data filter] resource_id
        if (isset($data['projectresource_id'])) {
            $projects->where('projectresource_id', $data['projectresource_id']);
        }

        //[data filter] resource_type
        if (isset($data['projectresource_type'])) {
            $projects->where('projectresource_type', $data['projectresource_type']);
        }

        //do not show items that not yet ready (i.e exclude items in the process of being cloned that have status 'invisible')
        $projects->where('project_visibility', 'visible');

        //apply filters
        if ($data['apply_filters']) {

            //filter archived projects
            if (request()->filled('filter_project_state') && (request('filter_project_state') == 'active' || request('filter_project_state') == 'archived')) {
                $projects->where('project_active_state', request('filter_project_state'));
            }

            //filter project id
            if (request()->filled('filter_project_id')) {
                $projects->where('project_id', request('filter_project_id'));
            }

            //filter clients
            if (request()->filled('filter_project_clientid')) {
                $projects->where('project_clientid', request('filter_project_clientid'));
            }

            //filter: start date (start)
            if (request()->filled('filter_start_date_start')) {
                $projects->whereDate('project_date_start', '>=', request('filter_start_date_start'));
            }

            //filter: due date (end)
            if (request()->filled('filter_start_date_end')) {
                $projects->whereDate('project_date_start', '<=', request('filter_start_date_end'));
            }

            //filter: due date (start)
            if (request()->filled('filter_due_date_start')) {
                $projects->where('project_date_due', '>=', request('filter_due_date_start'));
            }

            //filter: start date (end)
            if (request()->filled('filter_due_date_end')) {
                $projects->where('project_date_due', '<=', request('filter_due_date_end'));
            }

            //resource filtering
            if (request()->filled('projectresource_type') && request()->filled('projectresource_id')) {
                switch (request('projectresource_type')) {
                case 'client':
                    $projects->where('project_clientid', '>=', request('projectresource_id'));
                    break;
                }
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-in-progress') {
                $projects->where('project_status', 'in_progress');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-on-hold') {
                $projects->where('project_status', 'on_hold');
            }

            //stats: - counting
            if (isset($data['stats']) && $data['stats'] == 'count-completed') {
                $projects->where('project_status', 'completed');
            }

            //filter category
            if (request()->filled('filter_category')) {
                $projects->where('project_categoryid', request('filter_category'));
            }

            //filter my projects (using the actions button)
            if (request()->filled('filter_my_projects')) {
                //projects assigned to me and those that I manage
                $projects->where(function ($query) {
                    $query->whereHas('assigned', function ($q) {
                        $q->whereIn('projectsassigned_userid', [auth()->id()]);
                    });
                    $query->orWhereHas('managers', function ($q) {
                        $q->whereIn('projectsmanager_userid', [auth()->id()]);
                    });
                });
            }

            //filter category
            if (is_array(request('filter_project_categoryid')) && !empty(array_filter(request('filter_project_categoryid')))) {
                $projects->whereIn('project_categoryid', request('filter_project_categoryid'));
            }

            //filter status
            if (is_array(request('filter_project_status')) && !empty(array_filter(request('filter_project_status')))) {
                $projects->whereIn('project_status', request('filter_project_status'));
            }

            //filter assigned
            if (is_array(request('filter_assigned')) && !empty(array_filter(request('filter_assigned')))) {
                $projects->whereHas('assigned', function ($query) {
                    $query->whereIn('projectsassigned_userid', request('filter_assigned'));
                });
            }

            //filter: tags
            if (is_array(request('filter_tags')) && !empty(array_filter(request('filter_tags')))) {
                $projects->whereHas('tags', function ($query) {
                    $query->whereIn('tag_title', request('filter_tags'));
                });
            }

        }

        //custom fields filtering
        if (request('action') == 'search') {
            if ($fields = \App\Models\CustomField::Where('customfields_type', 'projects')->Where('customfields_show_filter_panel', 'yes')->get()) {
                foreach ($fields as $field) {
                    //field name, as posted by the filter panel (e.g. filter_ticket_custom_field_70)
                    $field_name = 'filter_' . $field->customfields_name;
                    if ($field->customfields_name != '' && request()->filled($field_name)) {
                        if (in_array($field->customfields_datatype, ['number', 'decimal', 'dropdown', 'date', 'checkbox'])) {
                            $projects->Where($field->customfields_name, request($field_name));
                        }
                        if (in_array($field->customfields_datatype, ['text', 'paragraph'])) {
                            $projects->Where($field->customfields_name, 'LIKE', '%' . request($field_name) . '%');
                        }
                    }
                }
            }
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $projects->where(function ($query) {
                $query->Where('project_id', '=', request('search_query'));
                $query->orWhere('project_date_start', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('project_date_due', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                //$query->orWhereRaw("YEAR(project_date_start) = ?", [request('search_query')]); //example binding - buggy
                //$query->orWhereRaw("YEAR(project_date_due) = ?", [request('search_query')]); //example binding - buggy
                $query->orWhere('project_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('project_status', '=', request('search_query'));
                $query->orWhereHas('tags', function ($q) {
                    $q->where('tag_title', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('category', function ($q) {
                    $q->where('category_name', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('client', function ($q) {
                    $q->where('client_company_name', 'LIKE', '%' . request('search_query') . '%');
                });
                $query->orWhereHas('assigned', function ($q) {
                    $q->where('first_name', '=', request('search_query'));
                    $q->where('last_name', '=', request('search_query'));
                });
            });

        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('projects', request('orderby'))) {
                $projects->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'project_client':
                $projects->orderBy('client_company_name', request('sortorder'));
                break;
            case 'category':
                $projects->orderBy('category_name', request('sortorder'));
                break;
            case 'count_pending_tasks':
                $projects->orderBy('count_pending_tasks', request('sortorder'));
                break;
            case 'count_completed_tasks':
                $projects->orderBy('count_completed_tasks', request('sortorder'));
                break;
            case 'sum_invoices_all':
                $projects->orderBy('sum_invoices_all', request('sortorder'));
                break;
            case 'sum_all_payments':
                $projects->orderBy('sum_all_payments', request('sortorder'));
                break;
            case 'sum_outstanding_balance':
                $projects->orderBy('sum_outstanding_balance', request('sortorder'));
                break;
            case 'sum_hours':
                $projects->orderBy('sum_hours', request('sortorder'));
                break;
            case 'sum_expenses':
                $projects->orderBy('sum_expenses', request('sortorder'));
                break;
            case 'count_tickets_open':
                $projects->orderBy('count_tickets_open', request('sortorder'));
                break;
            case 'count_tickets_closed':
                $projects->orderBy('count_tickets_closed', request('sortorder'));
                break;
            case 'count_files':
                $projects->orderBy('count_files', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $projects->orderBy(
                config('settings.ordering_projects.sort_by'),
                config('settings.ordering_projects.sort_order')
            );
        }

        //eager load
        $projects->with([
            'tags',
            'assigned',
            'managers',
        ]);

        //stats - count all
        if (isset($data['stats']) && in_array($data['stats'], [
            'count-all',
            'count-in-progress',
            'count-on-hold',
            'count-completed',
        ])) {
            return $projects->count();
        }

        // Get the results and return them.
        if (isset($data['limit']) && is_numeric($data['limit'])) {
            $limit = $data['limit'];
        } else {
            $limit = config('system.settings_system_pagination_limits');
        }

        //we are not paginating (e.g. when doing exports)
        if (isset($data['no_pagination']) && $data['no_pagination'] === true) {
            return $projects->get();
        }

        return $projects->paginate($limit);
    }

    /**
     * Create a new record
     * @return mixed int|bool project model object or false
     */
    public function create() {

        //save new user
        $project = new $this->projects;

        //data
        $project->project_uniqueid = str_unique();
        $project->project_title = request('project_title');
        $project->project_clientid = request('project_clientid');
        $project->project_creatorid = auth()->id();
        $project->project_description = request('project_description');
        $project->project_categoryid = request('project_categoryid');
        $project->project_date_start = request('project_date_start');
        $project->project_date_due = request('project_date_due');
        $project->project_calendar_timezone = config('system.settings_system_timezone');

        if (auth()->user()->role->role_projects_billing == 2) {
            $project->project_billing_type = (in_array(request('project_billing_type'), ['hourly', 'fixed'])) ? request('project_billing_type') : 'hourly';
            $project->project_billing_rate = (is_numeric(request('project_billing_rate'))) ? request('project_billing_rate') : 0;
            $project->project_billing_estimated_hours = (is_numeric(request('project_billing_estimated_hours'))) ? request('project_billing_estimated_hours') : 0;
            $project->project_billing_costs_estimate = (is_numeric(request('project_billing_costs_estimate'))) ? request('project_billing_costs_estimate') : 0;
        }

        //progress manually
        $project->project_progress_manually = (request('project_progress_manually') == 'on') ? 'yes' : 'no';
        if (request('project_progress_manually') == 'on') {
            $project->project_progress = request('project_progress');
        }

        //default project status
        $project->project_date_start = request('project_date_start');

        //project permissions (make sure same in 'update method')
        $project->clientperm_tasks_view = (request('clientperm_tasks_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_collaborate = (request('clientperm_tasks_collaborate') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_create = (request('clientperm_tasks_create') == 'on') ? 'yes' : 'no';
        $project->clientperm_timesheets_view = (request('clientperm_timesheets_view') == 'on') ? 'yes' : 'no';
        $project->assignedperm_tasks_collaborate = (request('assignedperm_tasks_collaborate') == 'on') ? 'yes' : 'no';

        //save and return id
        if ($project->save()) {
            //apply custom fields data
            $this->applyCustomFields($project->project_id);
            return $project->project_id;
        } else {
            Log::error("record could not be created - database error", ['process' => '[ProjectRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id project id
     * @return mixed int|bool  project id or false
     */
    public function update($id) {

        //get the record
        if (!$project = $this->projects->find($id)) {
            Log::error("record could not be found", ['process' => '[ProjectRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $id ?? '']);
            return false;
        }

        //general
        $project->project_title = request('project_title');
        $project->project_description = request('project_description');
        $project->project_categoryid = request('project_categoryid');
        $project->project_date_start = request('project_date_start');
        $project->project_date_due = request('project_date_due');
        $project->project_billing_rate = request('project_billing_rate');

        //project permissions (make sure same in 'create method')
        $project->clientperm_tasks_view = (request('clientperm_tasks_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_collaborate = (request('clientperm_tasks_collaborate') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_create = (request('clientperm_tasks_create') == 'on') ? 'yes' : 'no';
        $project->clientperm_timesheets_view = (request('clientperm_timesheets_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_expenses_view = (request('clientperm_expenses_view') == 'on') ? 'yes' : 'no';
        $project->assignedperm_tasks_collaborate = (request('assignedperm_tasks_collaborate') == 'on') ? 'yes' : 'no';

        if (auth()->user()->role->role_projects_billing == 2) {
            $project->project_billing_type = (in_array(request('project_billing_type'), ['hourly', 'fixed'])) ? request('project_billing_type') : 'hourly';
            $project->project_billing_rate = (is_numeric(request('project_billing_rate'))) ? request('project_billing_rate') : 0;
            $project->project_billing_estimated_hours = (is_numeric(request('project_billing_estimated_hours'))) ? request('project_billing_estimated_hours') : 0;
            $project->project_billing_costs_estimate = (is_numeric(request('project_billing_costs_estimate'))) ? request('project_billing_costs_estimate') : 0;
        }

        //progress manually
        $project->project_progress_manually = (request('project_progress_manually') == 'on') ? 'yes' : 'no';
        if (request('project_progress_manually') == 'on') {
            $project->project_progress = request('project_progress');
        }

        //save
        if ($project->save()) {
            //apply custom fields data
            $this->applyCustomFields($project->project_id);
            return $project->project_id;
        } else {
            return false;
        }
    }

    /**
     * Create a new record
     * @return mixed int|bool project model object or false
     */
    public function createTemplate() {

        //save new user
        $project = new $this->projects;

        //data
        $project_id = -time();
        $project->project_id = $project_id;
        $project->project_title = request('project_title');
        $project->project_clientid = 0;
        $project->project_creatorid = auth()->id();
        $project->project_uniqueid = str_unique();
        $project->project_description = request('project_description');
        $project->project_categoryid = request('project_categoryid');
        $project->project_date_start = null;
        $project->project_type = 'template';
        $project->project_calendar_timezone = config('system.settings_system_timezone');

        $project->project_billing_type = (in_array(request('project_billing_type'), ['hourly', 'fixed'])) ? request('project_billing_type') : 'hourly';
        $project->project_billing_rate = (is_numeric(request('project_billing_rate'))) ? request('project_billing_rate') : 0;
        $project->project_billing_estimated_hours = (is_numeric(request('project_billing_estimated_hours'))) ? request('project_billing_estimated_hours') : 0;
        $project->project_billing_costs_estimate = (is_numeric(request('project_billing_costs_estimate'))) ? request('project_billing_costs_estimate') : 0;

        //project permissions (make sure same in 'update method')
        $project->clientperm_tasks_view = (request('clientperm_tasks_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_collaborate = (request('clientperm_tasks_collaborate') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_create = (request('clientperm_tasks_create') == 'on') ? 'yes' : 'no';
        $project->clientperm_timesheets_view = (request('clientperm_timesheets_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_expenses_view = (request('clientperm_expenses_view') == 'on') ? 'yes' : 'no';
        $project->assignedperm_tasks_collaborate = (request('assignedperm_tasks_collaborate') == 'on') ? 'yes' : 'no';

        //save and return id
        if ($project->save()) {
            //apply custom fields data
            $this->applyCustomFields($project_id);
            return $project_id;
        } else {
            Log::error("record could not be created - database error", ['process' => '[ProjectRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * update a record
     * @param int $id project id
     * @return mixed int|bool  project id or false
     */
    public function updateTemplate($id) {

        //get the record
        if (!$project = $this->projects->find($id)) {
            Log::error("record could not be found", ['process' => '[ProjectRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $id ?? '']);
            return false;
        }

        //general
        $project->project_title = request('project_title');
        $project->project_description = request('project_description');
        $project->project_categoryid = request('project_categoryid');

        //project permissions (make sure same in 'create method')
        $project->clientperm_tasks_view = (request('clientperm_tasks_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_collaborate = (request('clientperm_tasks_collaborate') == 'on') ? 'yes' : 'no';
        $project->clientperm_tasks_create = (request('clientperm_tasks_create') == 'on') ? 'yes' : 'no';
        $project->clientperm_timesheets_view = (request('clientperm_timesheets_view') == 'on') ? 'yes' : 'no';
        $project->clientperm_expenses_view = (request('clientperm_expenses_view') == 'on') ? 'yes' : 'no';
        $project->assignedperm_tasks_collaborate = (request('assignedperm_tasks_collaborate') == 'on') ? 'yes' : 'no';

        $project->project_billing_type = (in_array(request('project_billing_type'), ['hourly', 'fixed'])) ? request('project_billing_type') : 'hourly';
        $project->project_billing_rate = (is_numeric(request('project_billing_rate'))) ? request('project_billing_rate') : 0;
        $project->project_billing_estimated_hours = (is_numeric(request('project_billing_estimated_hours'))) ? request('project_billing_estimated_hours') : 0;
        $project->project_billing_costs_estimate = (is_numeric(request('project_billing_costs_estimate'))) ? request('project_billing_costs_estimate') : 0;

        //save
        if ($project->save()) {
            //apply custom fields data
            $this->applyCustomFields($project->project_id);

            return $project->project_id;
        } else {
            return false;
        }
    }

    /**
     * feed for projects
     *
     * @param string $status project status
     * @param string $limit assigned|null limit to projects assiged to auth() user
     * @param string $searchterm
     * @return object project model object
     */
    public function autocompleteFeed($status = '', $limit = '', $searchterm = '') {

        //validation
        if ($searchterm == '') {
            return [];
        }

        //start
        $query = $this->projects->newQuery();
        $query->selectRaw("project_title AS value, project_id AS id");

        //[filter] project status
        if ($status != '') {
            if ($status == 'active') {
                $query->where('project_status', '!=', 'completed');
            } else {
                $query->where('project_status', '=', $status);
            }
        }

        //[filter] search term
        $query->where('project_title', 'like', '%' . $searchterm . '%');

        //ignore system client
        $query->where('project_type', 'project');

        //[filter] assigned
        if ($limit == 'assigned') {
            $query->whereHas('assigned', function ($q) {
                $q->whereIn('projectsassigned_userid', [auth()->user()->id]);
            });
        }

        //return
        return $query->get();
    }

    /**
     * feed for projects for a specified client
     *  - client ID is optional. If not specified, then all general projects are returned
     *
     * @param string $status project status
     * @param string $client_id clients id
     * @param string $limit assigned|null limit to projects assiged to auth() user
     * @return object project model object
     */
    public function autocompleteClientsProjectsFeed($status = '', $limit = '', $client_id = '', $searchterm = '') {

        //start
        $query = $this->projects->newQuery();
        $query->selectRaw("project_title AS value, project_id AS id");

        //[filter] project status
        if ($status != '') {
            if ($status == 'active') {
                $query->where('project_status', '!=', 'completed');
            } else {
                $query->where('project_status', '=', $status);
            }
        }

        //[filter] search term (optional)
        if ($searchterm != '') {
            $query->where('project_title', 'like', '%' . $searchterm . '%');
        }

        //ignore project templates
        $query->where('project_type', 'project');

        //[filter] client id
        if (is_numeric($client_id)) {
            $query->where('project_clientid', '=', $client_id);
        }

        //[filter] assigned
        if ($limit == 'assigned') {
            $query->whereHas('assigned', function ($q) {
                $q->whereIn('projectsassigned_userid', [auth()->user()->id]);
            });
        }

        //sort by title
        $query->orderBy('project_title', 'asc');

        //return
        return $query->get();
    }

    /**
     * feed for projects for a specified client
     *  - client ID is optional. If not specified, then all general projects are returned
     *
     * @param string $status project status
     * @param string $client_id clients id
     * @param string $limit assigned|null limit to projects assiged to auth() user
     * @return object project model object
     */
    public function autocompleteAssignedFeed($id = '') {

        //start
        $query = $this->projects->newQuery();
        $query->selectRaw("project_title AS value, project_id AS id");

        //[filter] project status
        if ($status != '') {
            if ($status == 'active') {
                $query->where('project_status', '!=', 'completed');
            } else {
                $query->where('project_status', '=', $status);
            }
        }

        //[filter] search term (optional)
        if ($searchterm != '') {
            $query->where('project_title', 'like', '%' . $searchterm . '%');
        }

        //ignore project templates
        $query->where('project_type', 'project');

        //[filter] client id
        if (is_numeric($client_id)) {
            $query->where('project_clientid', '=', $client_id);
        }

        //[filter] assigned
        if ($limit == 'assigned') {
            $query->whereHas('assigned', function ($q) {
                $q->whereIn('projectsassigned_userid', [auth()->user()->id]);
            });
        }

        //return
        return $query->get();
    }

    /**
     * refresh an project
     * @param mixed $project can be an project id or an project object
     * @return mixed null|bool
     */
    public function refreshProject($project) {

        //get the project
        if (is_numeric($project)) {
            if ($projects = $this->search($project)) {
                $project = $projects->first();
            }
        }

        //validate project
        if (!$project instanceof \App\Models\Project) {
            Log::error("record could not be found", ['process' => '[ProjectRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

        //update task based percentage
        if ($project->project_progress_manually == 'no') {
            //progress
            $project->project_progress = round($project->task_based_progress, 2);
        }
        //update project
        $project->save();
    }

    /**
     * update model wit custom fields data (where enabled)
     */
    public function applyCustomFields($id = '') {

        //custom fields
        $fields = \App\Models\CustomField::Where('customfields_type', 'projects')->get();
        foreach ($fields as $field) {
            if ($field->customfields_standard_form_status == 'enabled') {
                $field_name = $field->customfields_name;
                \App\Models\Project::where('project_id', $id)
                    ->update([
                        "$field_name" => request($field_name),
                    ]);
            }
        }
    }

    /**
     * Get a list or projects which the user is
     * When the $result param is set to 'feed', this can be used in Feed.php
     * @param string $result null | feed | list
     * @return mixed returns collection by default or a feed obj or an array of project id's
     */
    public function usersAssignedProjects($userid = '', $result = '') {

        //sanity
        if (!is_numeric($userid)) {
            $userid = -1;
        }

        //save userid to usein subquery
        request()->merge([
            'temp_query_userid' => $userid,
        ]);

        $projects = $this->projects->newQuery();

        //for feed
        if ($result == 'feed') {
            $projects->selectRaw("project_title AS value, project_id AS id");
        }

        $projects->where('project_type', 'project');

        //search term
        if (request()->filled('term')) {
            $projects->where('project_title', 'like', '%' . request('term') . '%');
        }

        $projects->whereHas('assigned', function ($q) {
            $q->whereIn('projectsassigned_userid', [request('temp_query_userid')]);
        });

        //return
        return $projects->get();
    }

    /**
     * Get a list or projects which the user is a project manager
     * When the $result param is set to 'feed', this can be used in Feed.php
     * @param string $result null | feed | list
     * @return mixed returns collection by default or a feed obj or an array of project id's
     */
    public function usersManagingProjects($userid = '', $result = '') {

        //sanity
        if (!is_numeric($userid)) {
            $userid = -1;
        }

        //save userid to usein subquery
        request()->merge([
            'temp_query_userid' => $userid,
        ]);

        $projects = $this->projects->newQuery();

        //for feed
        if ($result == 'feed') {
            $projects->selectRaw("project_title AS value, project_id AS id");
        }

        $projects->where('project_type', 'project');

        //search term
        if (request()->filled('term')) {
            $projects->where('project_title', 'like', '%' . request('term') . '%');
        }

        $projects->whereHas('managers', function ($q) {
            $q->whereIn('projectsmanager_userid', [request('temp_query_userid')]);
        });

        $collection = $projects->get();

        //array result
        if ($result == 'list') {
            $list = [];
            foreach ($collection as $project) {
                $list[] = $project->project_id;
            }
            return $list;
        }

        //return
        return $collection;

    }

    /**
     * Get a list or projects which the user is
     * When the $result param is set to 'feed', this can be used in Feed.php
     * @param string $result null | feed | list
     * @return mixed returns collection by default or a feed obj or an array of project id's
     */
    public function usersAssignedAndManageProjects($userid = '', $result = '') {

        //sanity
        if (!is_numeric($userid)) {
            $userid = -1;
        }

        //save userid to usein subquery
        request()->merge([
            'temp_query_userid' => $userid,
        ]);

        $projects = $this->projects->newQuery();

        //for feed
        if ($result == 'feed') {
            $projects->selectRaw("project_title AS value, project_id AS id");
        }

        $projects->where('project_type', 'project');

        //search term
        if (request()->filled('term')) {
            $projects->where('project_title', 'like', '%' . request('term') . '%');
        }

        $projects->where(function ($query) {
            $query->whereHas('assigned', function ($q) {
                $q->whereIn('projectsassigned_userid', [request('temp_query_userid')]);
            });
            $query->orWhereHas('managers', function ($q) {
                $q->whereIn('projectsmanager_userid', [request('temp_query_userid')]);
            });
        });

        $collection = $projects->get();

        //array result
        if ($result == 'list') {
            $list = [];
            foreach ($collection as $project) {
                $list[] = $project->project_id;
            }
            return $list;
        }

        //return
        return $collection;
    }

    /**
     * Get a list or projects for the client
     * @param string $result null | feed | list
     * @return mixed returns collection by default or a feed obj or an array of project id's
     */
    public function clientsProjects($clientid = '', $result = '') {

        //sanity
        if (!is_numeric($clientid) || $clientid == 0) {
            $clientid = -1;
        }

        $projects = $this->projects->newQuery();

        //for feed
        if ($result == 'feed') {
            $projects->selectRaw("project_title AS value, project_id AS id");
        }

        $projects->where('project_type', 'project');

        //search term
        if (request()->filled('term')) {
            $projects->where('project_title', 'like', '%' . request('term') . '%');
        }

        $projects->where('project_clientid', $clientid);

        $collection = $projects->get();

        //array result
        if ($result == 'list') {
            $list = [];
            foreach ($collection as $project) {
                $list[] = $project->project_id;
            }
            return $list;
        }

        //return
        return $collection;

    }

    /**
     * switch protocol for all projects and categories
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchPermissionsProtocol($type = '') {

        //delete all assigned users
        if ($type == 'user_roles') {
            Log::info("deleting all assigned users");
            //unset all assigned users
            \App\Models\ProjectAssigned::getQuery()->delete();
        }

        //set assigned users based on category users
        if ($type == 'category_based') {
            //get all categories
            $categories = \App\Models\Category::Where('category_type', 'project')->get();
            //loop through
            foreach ($categories as $category) {
                Log::info("swicthing for category: ($category->category_id)");
                //category projects
                $projects = $category->projects;
                //category users
                $users = $category->users;
                //assign each project afresh
                foreach ($projects as $project) {
                    if ($project->project_type == 'project') {
                        //assign
                        foreach ($users as $user) {
                            Log::info("assigning user: ($user->id) to project: ($project->project_id)");
                            $assigned = new \App\Models\ProjectAssigned();
                            $assigned->projectsassigned_projectid = $project->project_id;
                            $assigned->projectsassigned_userid = $user->id;
                            $assigned->save();
                        }
                    }
                }
            }
            Log::info("done switching");
        }

    }

    /**
     * assign a project to all the users of a given category
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignCategoryUsers($category_id = '', $project_id = '') {

        //validate
        if (!is_numeric($category_id) || !is_numeric($project_id)) {
            return false;
        }

        //delete currently assigned users for this project
        \App\Models\ProjectAssigned::Where('projectsassigned_projectid', $project_id)->delete();

        //get the category
        if ($category = \App\Models\Category::Where('category_type', 'project')->where('category_id', $category_id)->first()) {
            //category users
            $users = $category->users;
            //assign
            foreach ($users as $user) {
                $assigned = new \App\Models\ProjectAssigned();
                $assigned->projectsassigned_projectid = $project_id;
                $assigned->projectsassigned_userid = $user->id;
                $assigned->save();
            }
        }
    }

    /**
     * unassign all users for projects in a give category
     *
     * @param  int  $category_id category id
     * @return \Illuminate\Http\Response
     */
    public function unassignCategoryProjects($category_id = '') {

        //validate
        if (!is_numeric($category_id)) {
            return false;
        }

        //un assign users from old category
        if ($category = \App\Models\Category::Where('category_type', 'project')->where('category_id', $category_id)->first()) {
            $projects = $category->projects;
            foreach ($projects as $project) {
                if ($project->project_type == 'project') {
                    \App\Models\ProjectAssigned::Where('projectsassigned_projectid', $project->project_id)->delete();
                }
            }
        }
    }

    /**
     * assign all users for projects in a give category
     *
     * @param  int  $category_id category id
     * @return \Illuminate\Http\Response
     */
    public function assignCategoryProjects($category_id = '') {

        //validate
        if (!is_numeric($category_id)) {
            return false;
        }

        //assign users to new category
        if ($category = \App\Models\Category::Where('category_type', 'project')->where('category_id', $category_id)->first()) {
            $projects = $category->projects;
            $users = $category->users;
            foreach ($projects as $project) {
                if ($project->project_type == 'project') {
                    foreach ($users as $user) {
                        $assigned = new \App\Models\ProjectAssigned();
                        $assigned->projectsassigned_projectid = $project->project_id;
                        $assigned->projectsassigned_userid = $user->id;
                        $assigned->save();
                    }
                }
            }
        }
    }

    /**
     * Create a space
     * @return mixed int|bool project model object or false
     */
    public function createUserSpace($userid = null) {

        //save new space
        $space = new $this->projects;
        $space->project_uniqueid = str_unique();
        $space->project_id = -time();
        $space->project_type = 'space';
        $space->project_creatorid = 0;
        $space->project_title = config('system.settings2_spaces_team_space_title');
        $space->project_reference = 'default-team-space';

        //save
        if ($space->save()) {
            return $space->project_uniqueid;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[SpaceRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }

    }

    /**
     * all the projects that a user has access/permissions to
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function usersProjects($id) {

        $projects = $this->projects->newQuery();

        $projects->where('project_type', 'project');

        //validation
        if (!is_numeric($id)) {
            $projects->where('project_type', 'foobar'); //just to ensure we atleast return an object
            return $projects->get();
        }

        //get the user
        if (!$user = \App\Models\User::Where('id', $id)->With('role')->first()) {
            $projects->where('project_type', 'foobar'); //just to ensure we atleast return an object
            return $projects->get();
        }

        //[admin] -show all
        if ($user->type == 'team' && $user->role->role_id == 1) {
            return $projects->get();
        }

        //[team] -user user
        if ($user->type == 'team') {
            if ($user->role->role_projects >= 1 && $user->role->role_projects_scope == 'global') {
                return $projects->get();
            }
        }

        //[client]
        if ($user->type == 'client') {
            $projects->where('project_clientid', $user->clientid);
            return $projects->get();
        }

        //[everyone else]
        request()->merge([
            'filter_specified_user_id' => $user->id,
        ]);
        $projects->where(function ($query) {
            $query->whereHas('assigned', function ($q) {
                $q->whereIn('projectsassigned_userid', [request('filter_specified_user_id')]);
            });
            $query->orWhereHas('managers', function ($q) {
                $q->whereIn('projectsmanager_userid', [request('filter_specified_user_id')]);
            });
        });

        return $projects->get();
    }

    /**
     * get the default files folder for a project
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDefaultFilesFolder($id = '') {

        if (is_numeric($id) && $folder = \App\Models\FileFolder::Where('filefolder_projectid', $id)->Where('filefolder_default', 'yes')->first()) {
            return $folder->filefolder_id;
        }

        return null;

    }
}