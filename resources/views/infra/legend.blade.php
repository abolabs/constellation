<div class="row">
    <div class="col-lg-12 d-flex justify-content-between">
        <div>
            <h4 class="card-title mb-0">Instances par application</h4>
            <div class="small text-muted">
                <p>Utilisez le menu contextuel pour accéder au détail de chaque noeud <br/>(Clic gauche 2s ou clic droit)</p>
            </div>
        </div>
    </div>

    <div class="col-lg-12 form-group">
        <h5>Environnement</h5>
        <p>
            <select class="form-select select-primary" id="env" aria-label="Sélectionner un environnement">
                <option selected value="{{ $mainEnvironnement['environnement']['id'] }}">{{ $mainEnvironnement['environnement']['name'] }}</option>
            </select>
        </p>
    </div>
        <!-- Application Id Field -->
        <div class="form-group col-sm-12">
        <h5>Application</h5>
        <select name="application_id" id="application_id" class="form-control">
        @if (isset($serviceInstance->application->id))
            <option value="{{$serviceInstance->application->id}}">[{{$serviceInstance->application->id}}] {{$serviceInstance->application->name}}</option>
        @endif
        </select>
        <script>
            window.selector.make("#application_id", "/api/applications", "id", "name", {}, true)
        </script>
    </div>
    <!-- Hosting Id Field -->
    <div class="form-group col-sm-12">
        <h5>Hosting</h5>
        <select name="hosting_id" id="hosting_id" class="form-control">
        @if (isset($serviceInstance->hosting->id))
            <option value="{{$serviceInstance->hosting->id}}">[{{$serviceInstance->hosting->id}}] {{$serviceInstance->hosting->name}}</option>
        @endif
        </select>
        <script>
            window.selector.make("#hosting_id", "/api/hostings", "id", "name", {}, true)
        </script>
    </div>
    <div class="col-lg-12 form-group">
        <h5>Tag</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tagRadio" id="tagRadio1" value="hosting" checked>
            <label class="form-check-label" for="tagRadio1">
                Hosting
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tagRadio" id="tagRadio2" value="version">
            <label class="form-check-label" for="tagRadio2">
                Version
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="tagRadio" id="tagRadio3" value="hide">
            <label class="form-check-label" for="tagRadio3">
                Aucun
            </label>
        </div>
    </div>
    <div class="col-lg-12 form-group">
        <h5>Niveau de dépendance</h5>
        <div class="form-group">
            @foreach ( \App\Models\ServiceInstanceDependencies::$levelsList as $level)
            <span class="badge badge-{{ __('service_instance_dependencies.level_bg.'.$level) }}"
                data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top"
                data-content="{{ __('service_instance_dependencies.level_description.'.$level) }}">
                {{ __('service_instance_dependencies.level.'.$level) }}
            </span>
            @endforeach
        </div>
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover()
            })
        </script>
    </div>
</div>
