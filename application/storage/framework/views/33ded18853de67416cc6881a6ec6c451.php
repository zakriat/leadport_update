<!-- right-sidebar -->
<div class="right-sidebar" id="table-config-clients">
    <form id="table-config-form">
        <div class="slimscrollright">
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i><?php echo e(cleanLang(__('lang.table_settings'))); ?>

                <span>
                    <i class="ti-close js-close-side-panels" data-target="table-config-clients"></i>
                </span>
            </div>

            <!--set ajax url on parent container-->
            <div class="r-panel-body table-config-ajax" data-url="<?php echo e(url('preferences/tables')); ?>" data-type="form"
                data-form-id="table-config-form" data-ajax-type="post" data-progress-bar="hidden">

                <!--tableconfig_column_1 [client_id]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_1" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_1'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.id'); ?></span>
                    </label>
                </div>

                <!--tableconfig_column_2 [client_company_name]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_2" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_2'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.company_name'); ?></span>
                    </label>
                </div>

                <!--tableconfig_column_3 [account_owner]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_3" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_3'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.account_owner'); ?></span>
                    </label>
                </div>

                <!--tableconfig_column_4 [count_pending_projects]-->
                <?php if(config('visibility.modules.projects')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_4" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_4'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.pending_projects'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_5 [count_completed_projects]-->
                <?php if(config('visibility.modules.projects')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_5" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_5'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.completed_projects'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_6 [count_pending_tasks]-->
                <?php if(config('visibility.modules.tasks')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_6" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_6'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.pending_tasks'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_7 [count_completed_tasks]-->
                <?php if(config('visibility.modules.tasks')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_7" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_7'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.completed_tasks'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_8 [count_tickets_open]-->
                <?php if(config('visibility.modules.tickets')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_8" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_8'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.open_tickets'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_9 [count_tickets_closed]-->
                <?php if(config('visibility.modules.tickets')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_9" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_9'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.closed_tickets'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_10 [sum_estimates_accepted]-->
                <?php if(config('visibility.modules.estimates')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_10" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_10'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.accepted_estimates'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_11 [sum_estimates_declined]-->
                <?php if(config('visibility.modules.estimates')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_11" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_11'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.declined_estimates'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_12 [sum_invoices_all]-->
                <?php if(config('visibility.modules.invoices')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_12" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_12'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.invoices'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_13 [sum_all_payments]-->
                <?php if(config('visibility.modules.payments')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_13" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_13'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.payments'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_14 [sum_outstanding_balance]-->
                <?php if(config('visibility.modules.invoices')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_14" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_14'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.unpaid_invoices'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_15 [sum_subscriptions_active]-->
                <?php if(config('visibility.modules.subscriptions')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_15" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_15'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.subscriptions'); ?></span>
                    </label>
                </div>
                <?php endif; ?>


                <!--tableconfig_column_16 [sum_proposals_accepted]-->
                <?php if(config('visibility.modules.proposals')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_16" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_16'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.accepted_proposals'); ?></span>
                    </label>
                </div>
                <?php endif; ?>


                <!--tableconfig_column_17 [sum_proposals_declined]-->
                <?php if(config('visibility.modules.proposals')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_17" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_17'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.declined_proposals'); ?></span>
                    </label>
                </div>
                <?php endif; ?>


                <!--tableconfig_column_18 [sum_contracts]-->
                <?php if(config('visibility.modules.contracts')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_18" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_18'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.contracts'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_19 [count_hours_worked]-->
                <?php if(config('visibility.modules.timesheets')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_19" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_19'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.hours_worked'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_20 [count_tickets_open]-->
                <?php if(config('visibility.modules.tickets')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_20" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_20'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.open_tickets'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_21 [count_tickets_closed]-->
                <?php if(config('visibility.modules.tickets')): ?>
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_21" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_21'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.closed_tickets'); ?></span>
                    </label>
                </div>
                <?php endif; ?>

                <!--tableconfig_column_22 [count_users]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_22" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_22'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.count_users'); ?></span>
                    </label>
                </div>

                <!--tableconfig_column_23 [tags]-->
                <div class="p-b-5">
                    <label class="custom-control custom-checkbox table-config-checkbox-container">
                        <input name="tableconfig_column_23" type="checkbox"
                            class="custom-control-input table-config-checkbox cursor-pointer"
                            <?php echo e(runtimePrechecked(config('table.tableconfig_column_23'))); ?>>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description"><?php echo app('translator')->get('lang.tags'); ?></span>
                    </label>
                </div>

            </div>

            <!--tableconfig_column_24 [category]-->
            <div class="p-b-5">
                <label class="custom-control custom-checkbox table-config-checkbox-container">
                    <input name="tableconfig_column_24" type="checkbox"
                        class="custom-control-input table-config-checkbox cursor-pointer"
                        <?php echo e(runtimePrechecked(config('table.tableconfig_column_24'))); ?>>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description"><?php echo app('translator')->get('lang.category'); ?></span>
                </label>
            </div>

        </div>

        <!--tableconfig_column_25 [status]-->
        <div class="p-b-5">
            <label class="custom-control custom-checkbox table-config-checkbox-container">
                <input name="tableconfig_column_25" type="checkbox"
                    class="custom-control-input table-config-checkbox cursor-pointer"
                    <?php echo e(runtimePrechecked(config('table.tableconfig_column_25'))); ?>>
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description"><?php echo app('translator')->get('lang.status'); ?></span>
            </label>
        </div>


        <!--table name-->
        <input type="hidden" name="tableconfig_table_name" value="clients">

        <!--buttons-->
        <div class="buttons-block">
            <button type="button" name="foo1" class="btn btn-rounded-x btn-secondary js-close-side-panels"
                data-target="table-config-clients"><?php echo e(cleanLang(__('lang.close'))); ?></button>
            <input type="hidden" name="action" value="search">
        </div>
</div>
<!--body-->
</div>
</form>
</div>
<!--sidebar--><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/pages/clients/components/misc/table-config.blade.php ENDPATH**/ ?>