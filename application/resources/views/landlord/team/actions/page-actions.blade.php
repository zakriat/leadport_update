<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}"
    id="list-page-actions-container">
    <div id="list-page-actions">

        <!--ADD NEW ITEM-->
        @if(auth()->user()->primary_admin == 'yes')
        <button type="button"
            class="btn btn-success btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal" data-url="{{ url('/app-admin/team/create') }}"
            data-loading-target="commonModalBody" data-modal-title="@lang('lang.add_user')"
            data-action-url="{{ url('/app-admin/team') }}" data-action-method="POST"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
        @endif

    </div>
</div>