<div class="card count-<?php echo e(@count($contracts ?? [])); ?>" id="contracts-table-wrapper">
    <div class="card-body">
        <div class="table-responsive list-table-wrapper">
            <?php if(@count($contracts ?? []) > 0): ?>
            <table id="contracts-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contract-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <?php if(config('visibility.contracts_col_checkboxes')): ?>
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-contracts" name="listcheckbox-contracts"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="contracts-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-contracts">
                                <label for="listcheckbox-contracts"></label>
                            </span>
                        </th>
                        <?php endif; ?>

                        <!--doc_id-->
                        <th class="col_doc_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_doc_id"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_id&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.id'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>



                        <!--doc_title-->
                        <th class="col_doc_title"><a class="js-ajax-ux-request js-list-sorting" id="sort_doc_title"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_title&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.title'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--client-->
                        <?php if(config('visibility.col_client')): ?>
                        <th class="col_client"><a class="js-ajax-ux-request js-list-sorting" id="sort_client"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=client&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.client'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <?php endif; ?>



                        <!--doc_date_start-->
                        <?php if(config('visibility.doc_date_start')): ?>
                        <th class="col_doc_date_start"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_doc_date_start" href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_date_start&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.date'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <?php endif; ?>


                        <!--doc_value-->
                        <th class="col_doc_valuet"><a class="js-ajax-ux-request js-list-sorting" id="sort_doc_value"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_value&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.value'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--client_signature-->
                        <?php if(config('visibility.col_doc_signed_status')): ?>
                        <th class="col_doc_signed_status"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_doc_signed_status" href="javascript:void(0)" data-toggle="tooltip"
                                title="<?php echo app('translator')->get('lang.client_signature'); ?>"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_signed_status&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.client'); ?>
                                <i class="sl-icon-note"></i></a></th>
                        <?php endif; ?>

                        <!--doc_provider_signed_status-->
                        <?php if(config('visibility.doc_provider_signed_status')): ?>
                        <th class="col_doc_provider_signed_status"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_doc_provider_signed_status" href="javascript:void(0)" data-toggle="tooltip"
                                title="<?php echo app('translator')->get('lang.provider_signature'); ?>"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_provider_signed_status&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.provider'); ?>
                                <i class="sl-icon-note"></i></a></th>
                        <?php endif; ?>

                        <!--status-->
                        <th class="col_doc_status"><a class="js-ajax-ux-request js-list-sorting" id="sort_doc_status"
                                href="javascript:void(0)"
                                data-url="<?php echo e(urlResource('/contracts?action=sort&orderby=doc_status&sortorder=asc')); ?>"><?php echo app('translator')->get('lang.status'); ?><span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--actions-->
                        <?php if(config('visibility.contracts_col_action')): ?>
                        <th class="contracts_col_action"><a href="javascript:void(0)"><?php echo app('translator')->get('lang.action'); ?></a></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="contracts-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('pages.contracts.components.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?> <?php if(@count($contracts ?? []) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/pages/contracts/components/table/table.blade.php ENDPATH**/ ?>