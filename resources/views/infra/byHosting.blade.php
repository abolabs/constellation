@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        Cartographie Applicative
     </li>
    <li class="breadcrumb-item">Visualisation par application</li>
</ol>
<div class="container-fluid" id="mappingByApp">
    <div class="animated fadeIn">
        @include('flash::message')
        <!--/.row-->
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-2 mapping-legend">
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">Instances par hébergement</h4>
                            <div class="small text-muted">
                                <p>Utilisez le menu contextuel pour accéder au détail de chaque noeud <br/>(Clic gauche 2s ou clic droit)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>Environnement</label>
                        <p>
                            <select class="form-select ol-sm-12 select-primary" id="env" aria-label="Sélectionner un environnement">
                                <option selected value="{{ $mainEnvironnement['environnement']['id'] }}">{{ $mainEnvironnement['environnement']['name'] }}</option>
                            </select>
                        </p>
                    </div>
                    <!-- Application Id Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('application_id', 'Application ') !!}
                        <select name="application_id" id="application_id" class="form-control">
                        @if (isset($appInstance->application->id))
                            <option value="{{$appInstance->application->id}}">[{{$appInstance->application->id}}] {{$appInstance->application->name}}</option>
                        @endif
                        </select>
                        <script>
                            window.selector.make("#application_id", "/api/applications", "id", "name")
                        </script>
                    </div>
                    <!-- Hosting Id Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('hosting_id', 'Hosting ') !!}
                        <select name="hosting_id" id="hosting_id" class="form-control">
                        @if (isset($appInstance->hosting->id))
                            <option value="{{$appInstance->hosting->id}}">[{{$appInstance->hosting->id}}] {{$appInstance->hosting->name}}</option>
                        @endif
                        </select>
                        <script>
                            window.selector.make("#hosting_id", "/api/hostings", "id", "name")
                        </script>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>Tag</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tagRadio" id="tagRadio1" value="application" checked>
                            <label class="form-check-label" for="tagRadio1">
                                Application
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
                </div>
            </div>
            <div class="col-lg-12">
                <div id="cy-container-byApp">
                    <div id="cy"></div>
                </div>
            </div>

            <script>
                $(document).ready(() => {

                    const defaultEnv = {
                        id: {{ $mainEnvironnement['environnement']['id'] }},
                        label: "{{ $mainEnvironnement['environnement']['name'] }}"
                    }
                    const graph = new window.Graph();

                    window.Environnement.getAll().then((result) => {
                        const envData = result.data.data;
                        for(const envIndex in envData ){
                            if(envData[envIndex].id != defaultEnv.id){
                                $('#env').append($('<option value="'+envData[envIndex].id+'">'+envData[envIndex].name+'</option>'));
                            }
                        }
                        drawGraph(defaultEnv.id);

                    }).catch((exception) => {
                        console.log(exception);
                    });

                    $('#env,#application_id,#hosting_id').change((e) => {
                        refreshGraph();
                    });

                    $('input[name=tagRadio]').change((e) => {
                        if($(e.currentTarget).val() === "hide"){
                            return window.Graph.hideAllTag();
                        }
                        refreshGraph();
                    });

                    function refreshGraph()
                    {
                        const params = {
                            environnement_id: $('#env').val(),
                            tag: $('input[name=tagRadio]:checked').val(),
                            application_id: $('#application_id').val(),
                            hosting_id: $('#hosting_id').val(),
                        };

                        window.Graph.getNodesByHosting(params).then((graphData) => {
                            if(typeof graphData?.data == "undefined",  graphData?.data?.length == 0){
                                console.log("no data");
                            }
                            graph.replaceData(graphData.data);
                        }).catch((exception) => {
                            console.log(exception);
                        });
                    }

                    function drawGraph(env_id)
                    {
                        const params = {
                            environnement_id: env_id,
                            tag: $('input[name=tagRadio]').val(),
                            application_id: $('#application_id').val()
                        }
                        window.Graph.getNodesByHosting(params).then((graphData) => {
                            if(typeof graphData?.data == "undefined",  graphData?.data?.length == 0){
                                console.log("no data");
                            }
                            graph.load("cy",graphData.data);
                        }).catch((exception) => {
                            console.log(exception);
                        });
                    }

                });
            </script>

        </div>
        <!--/.row-->
    </div>
</div>
@endsection
