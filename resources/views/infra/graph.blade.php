<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="transparent-title">
                    <h4 class="card-title mb-0">Mapping instances par application</h4>
                    <div class="small text-muted">
                        <p>Utilisez le menu contextuel pour accéder au détail de chaque noeud <br/>(Clic gauche 2s ou clic droit)</p>
                    </div>
                </div>
                <div id="cy-container">
                    <div id="cy"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        var graph = new window.Graph();
        graph.load("#cy",window.Graph.getNodesByApplication());
    });
</script>
