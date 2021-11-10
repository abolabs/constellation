<div class="col-sm-3">
    <div class="card card-inverse card-primary text-white bg-primary">
        <div class="card-block p-3">
            <div class="h4 text-muted text-right mb-2">
                <i class="fa fa-window-maximize"></i>
            </div>
            <div class="h4 mb-0">{{$nbApp}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Applications</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('applications.index') }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-info text-white bg-danger">
        <div class="card-block p-3">
            <div class="h4 text-muted text-right mb-2">
                <i class="cil-apps"></i>
            </div>
            <div class="h4 mb-0">{{$nbInstances}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Instances Applicatives</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('appInstances.index') }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-success bg-warning">
        <div class="card-block p-3">
            <div class="h4 text-muted text-right mb-2">
                <i class="cib-codesandbox"></i>
            </div>
            <div class="h4 mb-0 text-muted">{{$nbServices}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Services</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('services.index') }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-warning text-white bg-info">
        <div class="card-block p-3">
            <div class="h4 text-muted text-right mb-2">
                <i class="cib-ghost"></i>
            </div>
            <div class="h4 mb-0">{{$nbHostings}}</div>
            <small class="text-muted text-uppercase font-weight-bold">Hébergements</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('hostings.index') }}">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></a>
        </div>
    </div>
</div>
<!--/.col-->
