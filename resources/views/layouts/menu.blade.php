

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


<li class="nav-item {{ Request::is('hostings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('hostings.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Hostings</span>
    </a>
</li>
<li class="nav-item {{ Request::is('teams*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('teams.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Teams</span>
    </a>
</li>

<li class="nav-item {{ Request::is('applications*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('applications.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Applications</span>
    </a>
</li>
