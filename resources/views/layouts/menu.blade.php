

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
<li class="nav-item {{ Request::is('services*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('services.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Services</span>
    </a>
</li>
<li class="nav-item {{ Request::is('serviceVersions*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('serviceVersions.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Service Versions</span>
    </a>
</li>



<li class="nav-item {{ Request::is('serviceVersionDependencies*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('serviceVersionDependencies.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Service Version Dependencies</span>
    </a>
</li>

<li class="nav-item {{ Request::is('appInstances*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('appInstances.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>App Instances</span>
    </a>
</li>
<li class="nav-item {{ Request::is('appInstanceDependencies*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('appInstanceDependencies.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>App Instance Dependencies</span>
    </a>
</li>
