<header class="topbar">

    <nav class="navbar top-navbar navbar-expand-md navbar-light">

        <div class="navbar-header" id="topnav-logo-container">


            <?php if(request('dashboard_section') == 'settings'): ?>
            <!--exist-->
            <div class="sidenav-menu-item exit-panel m-b-17">
                <a class="waves-effect waves-dark text-info" href="<?php echo e(url('app-admin/home')); ?>" id="settings-exit-button"
                    aria-expanded="false" target="_self">
                    <i class="sl-icon-logout text-info"></i>
                    <span id="settings-exit-text"><?php echo e(cleanLang(__('lang.exit_settings'))); ?></span>
                </a>
            </div>
            <?php else: ?>
            <!--logo-->
            <div class="sidenav-menu-item logo m-t-0">
                <a class="navbar-brand" href="<?php echo e(url('app-admin/home')); ?>">
                    <img src="<?php echo e(runtimeLogoSmall()); ?>" alt="homepage" class="logo-small" />
                    <img src="<?php echo e(runtimeLogoLarge()); ?>" alt="homepage" class="logo-large" />
                </a>
            </div>
            <?php endif; ?>
        </div>


        <div class="navbar-collapse header-overlay" id="main-top-nav-bar">

            <div class="page-wrapper-overlay js-close-side-panels hidden" data-target=""></div>

            <ul class="navbar-nav mr-auto">

                <li class="nav-item main-hamburger-menu">
                    <a class="nav-link sidebartoggler waves-effect waves-dark update-user-ux-preferences"
                        data-type="leftmenu" data-progress-bar="hidden" data-url=""
                        data-url-temp="<?php echo e(url('app-admin/users/preferences/leftmenu')); ?>"
                        data-preference-type="leftmenu" href="javascript:void(0)">
                        <i class="sl-icon-menu"></i>
                    </a>
                </li>

            </ul>


            <!--RIGHT SIDE-->
            <ul class="navbar-nav navbar-top-right my-lg-0" id="right-topnav-navbar">



                <!-- language -->
                <?php if(config('system.settings_system_language_allow_users_to_change') == 'yes'): ?>
                <li class="nav-item dropdown" id="topnav-language-icon">
                    <a class="nav-link dropdown-toggle p-t-10 waves-effect waves-dark" href="javascript:void(0)"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="sl-icon-globe"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated bounceInDown language">
                        <div class="row">
                            <?php $__currentLoopData = request('system_languages'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6">
                                <a class="dropdown-item js-ajax-request text-capitalize" href="javascript:void(0)"
                                    data-url="<?php echo e(url('/app-admin/user/updatelanguage')); ?>" data-type="form" data-ajax-type="post"
                                    data-form-id="topNavLangauage<?php echo e($key); ?>"><?php echo e($language); ?>

                                </a>
                                <span id="topNavLangauage<?php echo e($key); ?>">
                                    <input type="hidden" name="language" value="<?php echo e($language); ?>">
                                    <input type="hidden" name="current_url" value="<?php echo e(url()->full()); ?>">
                                </span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </li>
                <?php endif; ?>
                <!--language -->


                <!-- profile -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle p-l-20 p-r-20 waves-dark profile-pic" href="javascript:void(0)"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo e(auth()->user()->avatar); ?>" id="topnav_avatar" alt="user" class="" />
                        <span class="hidden-md-down" id="topnav_username"><?php echo e(auth()->user()->first_name); ?>

                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo e(auth()->user()->avatar); ?>"
                                            id="topnav_dropdown_avatar" alt="user"></div>
                                    <div class="u-text">
                                        <h4 id="topnav_dropdown_full_name"><?php echo e(auth()->user()->first_name); ?>

                                            <?php echo e(auth()->user()->last_name); ?></h4>
                                        <p class="text-muted" id="topnav_dropdown_email"><?php echo e(auth()->user()->email); ?></p>
                                        <a href="javascript:void(0)"
                                            class="btn btn-rounded btn-success btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                            data-toggle="modal" data-target="#commonModal"
                                            data-url="<?php echo e(url('/app-admin/users/avatar')); ?>" data-loading-target="commonModalBody"
                                            data-modal-size="modal-sm"
                                            data-modal-title="<?php echo e(cleanLang(__('lang.update_avatar'))); ?>"
                                            data-header-visibility="hidden" data-header-extra-close-icon="visible"
                                            data-action-url="<?php echo e(url('/app-admin/users/avatar')); ?>"
                                            data-action-method="PUT"><?php echo e(cleanLang(__('lang.update_avatar'))); ?></a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <!--my profile-->
                            <li>
                                <a href="javascript:void(0)"
                                    class="edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                                    data-toggle="modal" data-target="#commonModal"
                                    data-url="<?php echo e(url('app-admin/users/profile')); ?>"
                                    data-loading-target="commonModalBody"
                                    data-modal-title="<?php echo e(cleanLang(__('lang.update_my_profile'))); ?>"
                                    data-action-url="<?php echo e(url('app-admin/users/profile')); ?>" data-action-method="PUT"
                                    data-action-ajax-class="" data-modal-size="modal-lg"
                                    data-action-ajax-loading-target="team-td-container">
                                    <i class="ti-user p-r-4"></i>
                                    <?php echo e(cleanLang(__('lang.update_my_profile'))); ?></a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="<?php echo e(url('app-admin/logout')); ?>">
                                    <i class="fa fa-power-off p-r-4"></i> <?php echo e(cleanLang(__('lang.logout'))); ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- /#profile -->
            </ul>
        </div>
    </nav>


</header><?php /**PATH C:\xampp\htdocs\leadport\application\resources\views/landlord/layout/topnav.blade.php ENDPATH**/ ?>