@can('admin')
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon icon-settings"></i> {{ __('menu.administration') }}
    </a>
    <ul class="nav-dropdown-items">
        @can('view serviceInstanceDep')
        <li class="nav-item {{ Request::is('serviceInstanceDependencies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('serviceInstanceDependencies.index') }}">
                <i class="nav-icon cil-apps-settings"></i>
                <span>{{ __('menu.service_instances_dep') }}</span>
            </a>
        </li>
        @endcan
        @can('view environnement')
        <li class="nav-item {{ Request::is('environnements*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('environnements.index') }}">
                <i class="nav-icon cib-delicious"></i>
                <span>{{ __('menu.environnements') }}</span>
            </a>
        </li>
        @endcan
        @can('view serviceVersion')
        <li class="nav-item {{ Request::is('serviceVersions*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('serviceVersions.index') }}">
                <i class="nav-icon cib-git"></i>
                <span>{{ __('menu.service_versions') }}</span>
            </a>
        </li>
        @endcan
        @can('view serviceVersionDep')
        <li class="nav-item {{ Request::is('serviceVersionDependencies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('serviceVersionDependencies.index') }}">
                <i class="nav-icon cil-link"></i>
                <span>{{ __('menu.service_versions_dep') }}</span>
            </a>
        </li>
        @endcan
        @can('view hostingType')
        <li class="nav-item {{ Request::is('hostingTypes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hostingTypes.index') }}">
                <i class="nav-icon cib-terraform"></i>
                <span>{{ __('menu.hosting_types') }}</span>
            </a>
        </li>
        @endcan
        @can('view team')
        <li class="nav-item {{ Request::is('teams*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('teams.index') }}">
                <i class="nav-icon fa fa-users"></i>
                <span>{{ __('menu.teams') }}</span>
            </a>
        </li>
        @endcan
        @can('view user')
        <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="nav-icon fa fa-user-plus"></i>
                <span>{{ __('menu.users') }}</span>
            </a>
        </li>
        @endcan
        @role('Admin')
        <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="nav-icon fa fa-tags"></i>
                <span>{{ __('menu.roles') }}</span>
            </a>
        </li>
        @endrole
        @can('view audit')
        <li class="nav-item {{ Request::is('audits*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('audits.index') }}">
                <i class="nav-icon fa fa-history"></i>
                <span>{{ __('menu.audits') }}</span>
            </a>
        </li>
        @endcan
        @if(!App::environment('production'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('io_generator_builder') }}" target="_blank" rel="noopener">
                <i class="nav-icon fa fa-external-link"></i>{{ __('menu.generator') }}
            </a>
        </li>
        @endif
    </ul>
</li>
@endcan
