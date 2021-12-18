@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        {{ __('infra.applicative_map') }}
     </li>
</ol>
<div class="container-fluid" id="mappingByApp">
    <div class="animated fadeIn">
        @include('flash::message')
        <!--/.row-->
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-2 mapping-legend">
                @include('infra.legend', [
                    'mainEnvironnement' => $mainEnvironnement,
                    'serviceInstance' => $serviceInstance ?? null,
                    'appMapOnly' => true
                ])
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

                    setTimeout(function() {
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

                        var timeout;
                        $('#env,#application_id').change((e) => {
                            clearTimeout(timeout);
                            timeout = setTimeout(function(){
                                refreshGraph();
                            },250);
                        });

                        function refreshGraph()
                        {
                            const params = {
                                environnement_id: $('#env').val(),
                                application_id: $('#application_id').val(),
                            };
                            window.Graph.getNodesAppMap(params).then((graphData) => {
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
                            }
                            window.Graph.getNodesAppMap(params).then((graphData) => {
                                if(typeof graphData?.data == "undefined",  graphData?.data?.length == 0){
                                    console.log("no data");
                                }
                                graph.load("cy",graphData.data, false);
                            }).catch((exception) => {
                                console.log(exception);
                            });
                        }
                    }, 500);

                });
            </script>

        </div>
        <!--/.row-->
    </div>
</div>
@endsection
