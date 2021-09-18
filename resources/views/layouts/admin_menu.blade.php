<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon icon-settings"></i> Administration
    </a>
    <ul class="nav-dropdown-items">        
        
        <li class="nav-item {{ Request::is('appInstances*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('appInstances.index') }}">
                <i class="nav-icon cil-apps"></i>
                <span>App Instances</span>
            </a>
        </li>        
        
        <li class="nav-item {{ Request::is('appInstanceDependencies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('appInstanceDependencies.index') }}">
                <i class="nav-icon cil-apps-settings"></i>
                <span>App Instance Dependencies</span>
            </a>
        </li>
        
        <li class="nav-item {{ Request::is('environnements*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('environnements.index') }}">
                <i class="nav-icon cib-delicious"></i>
                <span>Environnements</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('serviceVersions*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('serviceVersions.index') }}">
                <i class="nav-icon cib-git"></i>
                <span>Service Versions</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('serviceVersionDependencies*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('serviceVersionDependencies.index') }}">
                <i class="nav-icon cil-link"></i>
                <span>Service Version Dependencies</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('hostingTypes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hostingTypes.index') }}">
                <i class="nav-icon cib-terraform"></i>
                <span>Hosting Types</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('teams*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('teams.index') }}">
                <i class="nav-icon fa fa-users"></i>
                <span>Teams</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="nav-icon fa fa-user-plus"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="nav-icon fa fa-tags"></i>
                <span>Roles</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('audits*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('audits.index') }}">
                <i class="nav-icon fa fa-history"></i>
                <span>Audits</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('io_generator_builder') }}" target="_blank">
                <i class="nav-icon fa fa-external-link"></i>Generateur
            </a>
        </li>
        
    </ul>
</li>