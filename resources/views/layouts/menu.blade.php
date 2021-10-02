<li class="nav-item {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard.index') }}">
        <i class="nav-icon icon-speedometer"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="nav-item {{ Request::is('applications*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('applications.index') }}">
        <i class="nav-icon fa fa-window-maximize"></i>
        <span>Applications</span>
    </a>
</li>

<li class="nav-item {{ Request::is('appInstances*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('appInstances.index') }}">
        <i class="nav-icon cil-apps"></i>
        <span>App Instances</span>
    </a>
</li>

<li class="nav-item {{ Request::is('services*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('services.index') }}">
         <i class="nav-icon cib-codesandbox"></i>
        <span>Services</span>
    </a>
</li>

<li class="nav-item {{ Request::is('hostings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('hostings.index') }}">
        <i class="nav-icon cib-ghost"></i>
        <span>Hostings</span>
    </a>
</li>

