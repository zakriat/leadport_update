<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right <?php echo e($page['list_page_actions_size'] ?? ''); ?> <?php echo e($page['list_page_container_class'] ?? ''); ?>"
    id="list-page-actions-container">
    <div id="list-page-actions">
        <!--SEARCH BOX-->
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search"
                data-url="<?php echo e(url('app-admin/customers/search?action=search')); ?>" data-type="form" data-ajax-type="post"
                data-form-id="header-search" id="search_query" name="search_query"
                placeholder="<?php echo e(cleanLang(__('lang.search'))); ?>">
        </div>

        <!--ADD NEW ITEM-->
        <button type="button"
            class="btn btn-success btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal" data-url="<?php echo e(url('/app-admin/customers/create')); ?>"
            data-loading-target="commonModalBody" data-modal-title="<?php echo app('translator')->get('lang.add_new_customer'); ?>"
            data-action-url="<?php echo e(url('/app-admin/customers')); ?>"
            data-action-method="POST"
            data-modal-size="modal-lg"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
    </div>
</div><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/landlord/customers/actions/page-actions.blade.php ENDPATH**/ ?>