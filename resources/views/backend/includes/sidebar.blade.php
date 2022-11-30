<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    <div class="c-sidebar-brand d-lg-down-none">
        <svg class="c-sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('img/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        @if($logged_in_user->can('admin.access.dashboard'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.dashboard')"
                :active="activeClass(Route::is('admin.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Dashboard')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.list'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.transactions.list')"
                :active="activeClass(Route::is('admin.transactions.list'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('List of RCNs')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.create'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.transactions.create')"
                :active="activeClass(Route::is('admin.transactions.create'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Create RCN')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.upload_rcn'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.transactions.upload')"
                :active="activeClass(Route::is('admin.transactions.upload'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Upload RCNs')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.attach_invoice'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.transactions.attach-invoice')"
                :active="activeClass(Route::is('admin.transactions.attach-invoice'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Add Invoice')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.invoices'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.transactions.invoices')"
                :active="activeClass(Route::is('admin.transactions.invoices'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Invoices')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rcns.recovery_invoices'))
        <li class="c-sidebar-nav-item">
            <x-utils.link class="c-sidebar-nav-link" :href="route('admin.rcns.recovery-invoices')"
                :active="activeClass(Route::is('admin.rcns.recovery-invoices'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer" :text="__('Pending Invoices')" />
        </li>
        @endif

        @if($logged_in_user->can('admin.access.rejected.invoices'))
            <li class="c-sidebar-nav-item">
                <x-utils.link class="c-sidebar-nav-link"
                    :href="route('admin.rcns.recovery-invoices', ['status' => 'rejected', 'rejected' => 1])"
                    :active="activeClass(Route::is('admin.rcns.recovery-invoices', ['status' => 'rejected', 'rejected' => 1]), 'c-active')"
                    icon="c-sidebar-nav-icon cil-speedometer" :text="__('Rejected Invoices')" />
            </li>
        @endif

        @if($logged_in_user->hasAllAccess() || $logged_in_user->can('admin.access.rcns.reports'))
                <li class="c-sidebar-nav-title">@lang('Reports')</li>
                <li
            class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.transactions.report') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-chart" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Invoice Reports')" />
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <x-utils.link :href="route('admin.transactions.report')" class="c-sidebar-nav-link"
                            :text="__('Valid Invoices')"
                            icon="c-sidebar-nav-icon cil-speedometer"
                            :active="activeClass(Route::is('admin.transactions.report'), 'c-active')" />
                    </li>
                    <li class="c-sidebar-nav-item">
                        <x-utils.link :href="route('admin.transactions.invalid-report')" class="c-sidebar-nav-link"
                            :text="__('Invalid Invoices')"
                            icon="c-sidebar-nav-icon cil-speedometer"
                            :active="activeClass(Route::is('admin.transactions.invalid-report'), 'c-active')" />
                    </li>
                    
                </ul>
            </li>
        @endif

        @if ($logged_in_user->hasAllAccess() ||
        (
        $logged_in_user->can('admin.access.user.list') ||
        $logged_in_user->can('admin.access.user.deactivate') ||
        $logged_in_user->can('admin.access.user.reactivate') ||
        $logged_in_user->can('admin.access.user.clear-session') ||
        $logged_in_user->can('admin.access.user.impersonate') ||
        $logged_in_user->can('admin.access.user.change-password')
        )
        )
        <li class="c-sidebar-nav-title">@lang('System')</li>

        <li
            class="c-sidebar-nav-dropdown {{ activeClass(Route::is('admin.auth.user.*') || Route::is('admin.auth.role.*'), 'c-open c-show') }}">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-user" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Access')" />

            <ul class="c-sidebar-nav-dropdown-items">
                @if (
                $logged_in_user->hasAllAccess() ||
                (
                $logged_in_user->can('admin.access.user.list') ||
                $logged_in_user->can('admin.access.user.deactivate') ||
                $logged_in_user->can('admin.access.user.reactivate') ||
                $logged_in_user->can('admin.access.user.clear-session') ||
                $logged_in_user->can('admin.access.user.impersonate') ||
                $logged_in_user->can('admin.access.user.change-password')
                )
                )
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.auth.user.index')" class="c-sidebar-nav-link"
                        :text="__('User Management')"
                        :active="activeClass(Route::is('admin.auth.user.*'), 'c-active')" />
                </li>
                @endif

                @if ($logged_in_user->hasAllAccess())
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.auth.role.index')" class="c-sidebar-nav-link"
                        :text="__('Role Management')"
                        :active="activeClass(Route::is('admin.auth.role.*'), 'c-active')" />
                </li>
                @endif

                @if ($logged_in_user->hasAllAccess())
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.approval-levels.index')" class="c-sidebar-nav-link"
                        :text="__('Approval Levels')"
                        :active="activeClass(Route::is('admin.approval-levels.*'), 'c-active')" />
                </li>
                @endif
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Settings')" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.consignee.index')" class="c-sidebar-nav-link"
                        :text="__('Consignees')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.agents.index')" class="c-sidebar-nav-link"
                        :text="__('Agents')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.cargo-types.index')" class="c-sidebar-nav-link"
                        :text="__('Cargo Types')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.carriers.index')" class="c-sidebar-nav-link"
                        :text="__('Carriers')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.destinations.index')" class="c-sidebar-nav-link"
                        :text="__('Destinations')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.shippers.index')" class="c-sidebar-nav-link"
                        :text="__('Shippers')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.vehicles.index')" class="c-sidebar-nav-link"
                        :text="__('Vehicles')" />
                </li>

                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('admin.settings.departments.index')" class="c-sidebar-nav-link"
                        :text="__('Departments')" />
                </li>
            </ul>
        </li>
        @endif

        {{-- <li class="c-sidebar-nav-title">@lang('Settings')</li>

        @if ($logged_in_user->hasAllAccess())
        <li class="c-sidebar-nav-dropdown">
            <x-utils.link href="#" icon="c-sidebar-nav-icon cil-list" class="c-sidebar-nav-dropdown-toggle"
                :text="__('Drivers')" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('log-viewer::dashboard')" class="c-sidebar-nav-link" :text="__('')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link :href="route('log-viewer::logs.list')" class="c-sidebar-nav-link"
                        :text="__('Logs')" />
                </li>
            </ul>
        </li>
        @endif --}}
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
        data-class="c-sidebar-minimized"></button>
</div>
<!--sidebar-->