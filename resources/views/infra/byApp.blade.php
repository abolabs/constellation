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
            <div class="col-lg-2 mapping-legend">
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
                        <label>Environnement</label>
                        <p>
                            <select class="form-select select-primary" id="env" aria-label="Sélectionner un environnement">
                                <option selected value="{{ $mainEnvironnement['environnement']['id'] }}">{{ $mainEnvironnement['environnement']['name'] }}</option>
                            </select>
                        </p>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>Tag</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tagRadio" id="tagRadio1" value="version" checked>
                            <label class="form-check-label" for="tagRadio1">
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

                    $('#env').change((e) => {
                        const params = {
                            environnement_id: $('#env').val()
                        }
                        refreshGraph(params);
                    });

                    $('input[name=tagRadio]').change((e) => {
                        if($(e.currentTarget).val() === "hide"){
                            return window.Graph.hideAllTag();
                        }
                        const params = {
                            environnement_id: $('#env').val(),
                            tag: $(e.currentTarget).val(),
                        }
                        refreshGraph(params);

                    });

                    function refreshGraph(params)
                    {
                        window.Graph.getNodesByApplication(params).then((graphData) => {
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
                            environnement_id: env_id
                        }
                        window.Graph.getNodesByApplication(params).then((graphData) => {
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
