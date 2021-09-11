<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon icon-settings"></i> Administration
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('io_generator_builder') }}" target="_blank">
                <i class="nav-icon fa fa-external-link"></i>Generateur
            </a>
        </li>
        <li class="nav-item {{ Request::is('environnements*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('environnements.index') }}">
                <i class="nav-icon icon-cursor"></i>
                <span>Environnements</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('hostingTypes*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('hostingTypes.index') }}">
                <i class="nav-icon icon-cursor"></i>
                <span>Hosting Types</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('teams*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('teams.index') }}">
                <i class="nav-icon icon-cursor"></i>
                <span>Teams</span>
            </a>
        </li>
    </ul>
</li>