<div class="col-sm-3">
    <div class="card card-inverse card-primary text-white bg-primary">
        <div class="card-block p-3">
            <div class="h4 mb-0">{{$nbApp}} <i class="fa fa-window-maximize pull-right"></i></div>
            <small class="text-muted text-uppercase font-weight-bold">Applications</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('applications.index') }}"><small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-info text-white bg-danger">
        <div class="card-block p-3">
            <div class="h4 mb-0">{{$nbInstances}} <i class="cil-apps pull-right"></i></div>
            <small class="text-muted text-uppercase font-weight-bold">Instances Applicatives</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('serviceInstances.index') }}"><small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-success bg-warning">
        <div class="card-block p-3">
            <div class="h4 mb-0 text-muted">{{$nbServices}} <i class="cib-codesandbox pull-right"></i></div>
            <small class="text-muted text-uppercase font-weight-bold">Services</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('services.index') }}"><small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small></a>
        </div>
    </div>
</div>
<!--/.col-->
<div class="col-sm-3">
    <div class="card card-inverse card-warning text-white bg-info">
        <div class="card-block p-3">
            <div class="h4 mb-0">{{$nbHostings}} <i class="cib-ghost pull-right"></i></div>
            <small class="text-muted text-uppercase font-weight-bold">Hébergements</small>
        </div>
        <div class="card-footer p-x-1 py-h">
            <a class="font-weight-bold font-xs btn-block text-muted" href="{{ route('hostings.index') }}"><small class="text-muted">Voir plus <i class="fa fa-angle-right float-right font-lg"></i></small></a>
        </div>
    </div>
</div>
<!--/.col-->
