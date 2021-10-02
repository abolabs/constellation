<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="transparent-title">
                    <h4 class="card-title mb-0">Mapping</h4>
                    <div class="small text-muted">Affichage des dépendances applicatives</div>
                </div>
                <div id="cy-container">
                    <div id="cy"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/cytoscape/dist/cytoscape.min.js"></script>
<script src="https://unpkg.com/layout-base/layout-base.js"></script>
<script src="https://unpkg.com/cose-base/cose-base.js"></script>
<script src="https://unpkg.com/cytoscape-layout-utilities/cytoscape-layout-utilities.js"></script>

<script src="https://cytoscape.org/cytoscape.js-cxtmenu/cytoscape-cxtmenu.js"></script>
<script src="https://ivis-at-bilkent.github.io/cytoscape.js-fcose/cytoscape-fcose.js"></script>
<script>


    function getNodes()
    {
        let nodes = [];
        $.ajax({
            url: "/dashboard/graphNodes",
            type: "GET",
            async: false, // Mode synchrone
            dataType: "json",
            complete: function(data){
                nodes = data;
            }
        });
        return nodes;
    }

    window.addEventListener('DOMContentLoaded', function()
    {
        var cy = window.cy = cytoscape({
            container: document.getElementById('cy'),

            ready: function(){
                let layoutUtilities = this.layoutUtilities({
                    desiredAspectRatio: this.width()/this.height()
                });
                this.nodes().forEach(function(node){
                    let size = 100;
                    node.css("width", size);
                    node.css("height", size);
                });

                this.layout({
                    name: 'fcose',
                    animationEasing: 'ease-out',
                    nodeRepulsion: 4500,
                    idealEdgeLength: 150,
                    edgeElasticity: 0.45,
                }).run();
            },
            zoom: 0.75,
            minZoom: 0.750,
            maxZoom: 1.25,
            style: [
                {
                    selector: 'node',
                    css: {
                        'content': 'data(name)',
                    },
                },
                {
                    selector: 'node:selected',
                    style: {
                        'background-color': '#343a40',
                        'border-color': '#FDFFFC',
                    }
                },
                {
                    selector: 'node:selected *',
                    style: {
                        'color': 'white'
                    }
                },
                {
                    selector: 'edge',
                    css: {
                        'curve-style': 'bezier',
                        'target-arrow-shape': 'triangle'
                    }
                },
                {
                    selector: '.appInstance',
                    style: {
                        'background-color' : '#177E89'
                    }
                },
                {
                    selector: '#n0',
                    css: {
                        'background-fit': 'contain',
                        'background-image': 'https://live.staticflickr.com/7272/7633179468_3e19e45a0c_b.jpg'
                    }
                }
            ],
            elements: getNodes()
        });

        cy.cxtmenu({
            selector: 'node, edge',
            commands: [
                {
                    content: '<span class="fa fa-flash fa-2x"></span>',
                    select: function(ele){
                        console.log( ele.id() );
                    }
                },
                {
                    content: '<span class="fa fa-star fa-2x"></span>',
                    select: function(ele){
                        console.log( ele.data('name') );
                    },
                    enabled: false
                },
                {
                    content: 'Text',
                    select: function(ele){
                        console.log( ele.position() );
                    }
                }
            ]
        });

        cy.cxtmenu({
            selector: 'core',
            commands: [
                {
                    content: 'bg1',
                    select: function(){
                        console.log( 'bg1' );
                    }
                },
                {
                    content: 'bg2',
                    select: function(){
                        console.log( 'bg2' );
                    }
                }
            ]
        });
    });


</script>
