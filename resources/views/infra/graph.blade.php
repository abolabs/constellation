@if (!empty($mainEnvironnement) && isset($mainEnvironnement['environnement']))
<div class="col-sm-12">
    <div class="card">
        <div class="card-header transparent-title">
            <div class="row">
                <div class="col-md-9 col-sm-12 d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">Instances par application</h4>
                        <div class="small text-muted">
                            <p>Utilisez le menu contextuel pour accéder au détail de chaque noeud <br/>(Clic gauche 2s ou clic droit)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 form-group text-right">
                    <label>Environnement</label>
                    <p>
                        <select class="form-select select-primary" id="env" aria-label="Sélectionner un environnement">
                            <option selected value="{{ $mainEnvironnement['environnement']['id'] }}">{{ $mainEnvironnement['environnement']['name'] }}</option>
                        </select>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="cy-container">
                <div id="cy"></div>
            </div>
        </div>
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
            window.Graph.getNodesByApplication(params).then((graphData) => {
                if(typeof graphData?.data == "undefined",  graphData?.data?.length == 0){
                    console.log("no data");
                }
                graph.replaceData(graphData.data);
            }).catch((exception) => {
                console.log(exception);
            });
        });

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
@endif
