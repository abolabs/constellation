class Graph {

    constructor(cy){
        this.cy = cy;
    }

    replaceData(newEleJsons){
        this.cy.json({
            elements: newEleJsons,
            zoom: 0.75
        });
        this.refreshLayout();
    }

    refreshLayout(){
        this.cy.nodes().forEach(function (node) {
            let size = 25;
            node.css("width", size);
            node.css("height", size);
        });

        this.cy.layout({
            name: 'fcose',
            animationEasing: 'ease-out',
            nodeRepulsion: 4500,
            idealEdgeLength: 200,
            edgeElasticity: 0.45,
        }).run();
    }

    load(selector, loadNodesCallback) {

        const currentGraph = this;

        this.cy = window.cy = window.cytoscape({
            container: document.getElementById(selector),

            ready: function () {
                let layoutUtilities = this.layoutUtilities({
                    desiredAspectRatio: this.width() / this.height()
                });
                this.nodes().forEach(function (node) {
                    let size = 25;
                    node.css("width", size);
                    node.css("height", size);
                });

                this.layout({
                    name: 'fcose',
                    animationEasing: 'ease-out',
                    nodeRepulsion: 4500,
                    idealEdgeLength: 200,
                    edgeElasticity: 0.45,
                }).run();
            },
            zoom: 0.75,
            minZoom: 0.750,
            maxZoom: 1.25,
            wheelSensitivity: 0.25,
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
                        'target-arrow-shape': 'triangle',
                        'line-color': '#177E89',
                        'target-arrow-color': '#DB3A34',
                        'source-arrow-color': '#177E89',
                    }
                },
                {
                    selector: '.appInstance',
                    style: {
                        'background-color': '#084C61',
                        'border-width': '2',
                        'border-color': '#177E89',
                    }
                },
                {
                    selector: '#n0',
                    css: {
                        'background-fit': 'contain',
                        'background-image': 'https://live.staticflickr.com/7272/7633179468_3e19e45a0c_b.jpg',
                    }
                }
            ],
            elements: loadNodesCallback
        });

        cy.cxtmenu({
            selector: 'node, edge',
            commands: [
                {
                    content: '<span><i class="fa fa-flash"></i> Détail</span>',
                    select: function (ele) {
                        const eltData = ele.id().split("_");
                        window.location.href = '/' + eltData[0] + "s/" + eltData[1];
                    }
                },
                {
                    content: '<span class="fa fa-ban fa-2x"></span>',
                    select: function (ele) {
                        //console.log( ele.data('name') );
                    },
                    enabled: false
                },
                {
                    content: 'Text',
                    select: function (ele) {
                        console.log(ele.position());
                    }
                }
            ]
        });

        cy.cxtmenu({
            selector: 'core',
            commands: [
                {
                    content: 'Light',
                    select: function () {
                        $('#'+selector).css('background', "#FDFFFC");
                    }
                },
                {
                    content: 'Dark',
                    select: function () {
                        $('#'+selector).css('background', "#343a40");
                    }
                }
            ]
        });

    }

    static getNodesByApplication(environnement_id) {
        console.log(">>> getNodesByApplication" , environnement_id);

        return window.axios.get("/dashboard/graphNodes", {
            params: {
                environnement_id: environnement_id
            }
        });
    }

}

export default Graph;
