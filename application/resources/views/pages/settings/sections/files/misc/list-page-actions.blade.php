<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-12 align-self-center text-right"
    id="list-page-actions-container">
    <div id="list-page-actions">
        <!--ADD NEW ITEM-->
        <button type="button"
            class="btn btn-success btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal" data-url="{{ url('settings/files/defaultfolders/create') }}"
            data-loading-target="commonModalBody" data-modal-title="@lang('lang.create_a_folder')"
            data-action-url="{{ url('settings/files/defaultfolders/create') }}"
            data-action-method="POST"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
    </div>
</div>