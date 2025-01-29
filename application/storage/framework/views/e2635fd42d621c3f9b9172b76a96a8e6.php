<!--modal-->
<div class="modal card-modal" role="dialog" aria-labelledby="cardModal" id="cardModal" <?php echo clean(runtimeAllowCloseModalOptions()); ?>>
    <div class="modal-dialog" id="cardModalContainer">
        <div class="modal-content hidden" id="cardModalContent">
            <div id="cardModalTabMenu">
                <!--dynamic tabs menu-->
            </div>
            <!--cover image-->
            <div class="card-cover-image-wrapper hidden" id="card-cover-image-wrapper">
                <div class="card-cover-image-container fancybox" id="card-cover-image-container" data-src="">
                    <span class="cover-image-remove-button hidden">
                        <button type="button" id="remove-cover-image-button" data-progress-bar="hidden" data-url=""
                            data-id=""
                            class="btn btn-outline-secondary btn-sm js-remove-cover-image remove-cover-image-button"><?php echo app('translator')->get('lang.remove_cover'); ?></button>
                    </span>
                </div>
            </div>
            <div class="modal-body row min-h-200" id="cardModalBody">
                <!--close button-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="card-modal-close">
                    <i class="ti-close"></i>
                </button>

                <!--left panel-->
                <div class="col-sm-12 col-lg-8 card-left-panel" id="card-leads-left-panel">
                </div>

                <!--right panel-->
                <div class="col-sm-12 col-lg-4 card-right-panel" id="card--leads-right-panel">
                </div>
            </div>
            <!--convert to customer-->
            <form id="convertLeadForm">
                <div class="modal-body row hidden min-h-200 overlay" id="leadConvertToCustomer">
                    <!--close button-->
                    <button type="button" class="close js-lead-convert-to-customer-close" aria-hidden="true"
                        id="js-close-convert-lead-form">
                        <i class="ti-close"></i>
                    </button>
                    <?php echo $__env->make('pages.lead.convert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="modal-footer text-right hidden" id="leadConvertToCustomerFooter">
                </div>
            </form>
        </div>
    </div>
</div>

<!--js dom elements-->
<?php echo $__env->make('pages.lead.components.js-elements', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="public/js/core/card.js?v=<?php echo e(config('system.versioning')); ?>"></script><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/pages/lead/modal.blade.php ENDPATH**/ ?>