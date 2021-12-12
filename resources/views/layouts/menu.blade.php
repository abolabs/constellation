<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard.index') }}">
        <i class="nav-icon icon-speedometer"></i>
        <span>{{ __('menu.dashboard' )}}</span>
    </a>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon icon-settings"></i> {{ __('menu.app_mapping' )}}
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item {{ Request::is('applicationMapping/byApp*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('applicationMapping.byApp') }}">
                <i class="nav-icon  cil-share-alt "></i>
                <span>{{ __('menu.view_by_app' )}}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('applicationMapping/byHosting*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('applicationMapping.byHosting') }}">
                <i class="nav-icon  cil-lan"></i>
                <span>{{ __('menu.view_by_hosting' )}}</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ Request::is('applications*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('applications.index') }}">
        <i class="nav-icon fa fa-window-maximize"></i>
        <span>{{ __('menu.applications' )}}</span>
    </a>
</li>

<li class="nav-item {{ Request::is('serviceInstances*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('serviceInstances.index') }}">
        <i class="nav-icon cil-apps"></i>
        <span>{{ __('menu.service_instances' )}}</span>
    </a>
</li>

<li class="nav-item {{ Request::is('services*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('services.index') }}">
         <i class="nav-icon cib-codesandbox"></i>
        <span>{{ __('menu.services' )}}</span>
    </a>
</li>

<li class="nav-item {{ Request::is('hostings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('hostings.index') }}">
        <i class="nav-icon cib-ghost"></i>
        <span>{{ __('menu.hostings' )}}</span>
    </a>
</li>

