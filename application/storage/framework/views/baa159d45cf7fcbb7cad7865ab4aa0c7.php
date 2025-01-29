<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right <?php echo e($page['list_page_actions_size'] ?? ''); ?> <?php echo e($page['list_page_container_class'] ?? ''); ?>"
    id="list-page-actions-container">
    <div id="list-page-actions">
        <!--SEARCH BOX-->
        <?php if( config('visibility.list_page_actions_search')): ?>
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search"
                data-url="<?php echo e($page['dynamic_search_url'] ?? ''); ?>" data-type="form" data-ajax-type="post"
                data-form-id="header-search" id="search_query" name="search_query"
                placeholder="<?php echo e(cleanLang(__('lang.search'))); ?>">
        </div>
        <?php endif; ?>

        <!--ARCHIVED PROJECTS-->
        <?php if(config('visibility.archived_projects_toggle_button')): ?>
        <button type="button" data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.show_archive_projects'))); ?>"
            id="pref_filter_show_archived_projects"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-ajax-ux-request <?php echo e(runtimeActive(auth()->user()->pref_filter_show_archived_projects)); ?>"
            data-url="<?php echo e(url('/projects/search?action=search&toggle=pref_filter_show_archived_projects&filter_category='.request('filter_category'))); ?>">
            <i class="ti-archive"></i>
        </button>
        <?php endif; ?>

        <!--SHOW OWN PROJECTS-->
        <?php if(config('visibility.own_projects_toggle_button')): ?>
        <button type="button" data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.my_projects'))); ?>"
            id="pref_filter_own_projects"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-ajax-ux-request <?php echo e(runtimeActive(auth()->user()->pref_filter_own_projects)); ?>"
            data-url="<?php echo e(url('/projects/search?action=search&toggle=pref_filter_own_projects&filter_category='.request('filter_category'))); ?>">
            <i class="sl-icon-user"></i>
        </button>
        <?php endif; ?>


        <!--layout toggle-->
        <span class="dropdown">
            <button type="button" data-toggle="dropdown" title="<?php echo app('translator')->get('lang.view_layout'); ?>" aria-haspopup="true"
                aria-expanded="false"
                class="data-toggle-tooltip  list-actions-button btn btn-page-actions waves-effect waves-dark">
                <i class="sl-icon-grid"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="listTableAction">
                <!--list view-->
                <a class="dropdown-item display-block ajax-request" href="javascript:void(0)"
                    data-url="<?php echo e(url('/projects/search?action=search&toggle_project_view=list&filter_category='.request('filter_category'))); ?>"
                    id="invoice-action-stop-recurring"> <i class="ti-view-list-alt display-inline-block m-t-3"></i>
                    <span class="display-inline-block vm m-t--3 p-l-3"><?php echo app('translator')->get('lang.list_view'); ?></span>
                </a>
                <!--card view-->
                <a class="dropdown-item display-block ajax-request" href="javascript:void(0)"
                    data-url="<?php echo e(url('/projects/search?action=search&toggle_project_view=card&filter_category='.request('filter_category'))); ?>"
                    id="invoice-action-stop-recurring"> <i class="ti-layout-cta-left display-inline-block m-t-3"></i>
                    <span class="display-inline-block vm m-t--3 p-l-3"><?php echo app('translator')->get('lang.card_view'); ?></span>
                </a>
            </div>
        </span>

        <!--TOGGLE STATS-->
        <?php if( config('visibility.stats_toggle_button')): ?>
        <button type="button" data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.quick_stats'))); ?>"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-stats-widget update-user-ux-preferences"
            data-type="statspanel" data-progress-bar="hidden"
            data-url-temp="<?php echo e(url('/')); ?>/<?php echo e(auth()->user()->team_or_contact); ?>/updatepreferences" data-url=""
            data-target="list-pages-stats-widget">
            <i class="ti-stats-up"></i>
        </button>
        <?php endif; ?>


        <!--EXPORT-->
        <?php if(config('visibility.list_page_actions_exporting')): ?>
        <button type="button" data-toggle="tooltip" title="<?php echo app('translator')->get('lang.export_projects'); ?>"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-side-panel"
            data-target="sidepanel-export-projects">
            <i class="ti-export"></i>
        </button>
        <?php endif; ?>

        <!--FILTERING-->
        <?php if(config('visibility.list_page_actions_filter_button')): ?>
        <button type="button" data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.filter'))); ?>"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-side-panel"
            data-target="<?php echo e($page['sidepanel_id'] ?? ''); ?>">
            <i class="mdi mdi-filter-outline"></i>
        </button>
        <?php endif; ?>

        <!--ADD NEW ITEM-->
        <?php if(config('visibility.list_page_actions_add_button')): ?>
        <button type="button"
            class="btn btn-success btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form <?php echo e($page['add_button_classes'] ?? ''); ?>"
            data-toggle="modal" data-target="#commonModal" data-url="<?php echo e($page['add_modal_create_url'] ?? ''); ?>"
            data-loading-target="commonModalBody" data-modal-title="<?php echo e($page['add_modal_title'] ?? ''); ?>"
            data-action-url="<?php echo e($page['add_modal_action_url'] ?? ''); ?>"
            data-action-method="<?php echo e($page['add_modal_action_method'] ?? ''); ?>"
            data-action-ajax-class="<?php echo e($page['add_modal_action_ajax_class'] ?? ''); ?>"
            data-modal-size="<?php echo e($page['add_modal_size'] ?? ''); ?>"
            data-action-ajax-loading-target="<?php echo e($page['add_modal_action_ajax_loading_target'] ?? ''); ?>"
            data-save-button-class="<?php echo e($page['add_modal_save_button_class'] ?? ''); ?>" data-project-progress="0">
            <i class="ti-plus"></i>
        </button>
        <?php endif; ?>

        <!--add new button (link)-->
        <?php if( config('visibility.list_page_actions_add_button_link')): ?>
        <a id="fx-page-actions-add-button" type="button" class="btn btn-success btn-add-circle edit-add-modal-button"
            href="<?php echo e($page['add_button_link_url'] ?? ''); ?>">
            <i class="ti-plus"></i>
        </a>
        <?php endif; ?>
    </div>
</div><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/pages/projects/components/misc/list-page-actions.blade.php ENDPATH**/ ?>