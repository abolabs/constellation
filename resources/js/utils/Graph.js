import {hideAll} from 'tippy.js';
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
        this.cy.layout({
            name: 'fcose',
            animate: false,
            nodeRepulsion: 4500,
            idealEdgeLength: 200,
            edgeElasticity: 0.45,
            randomize: false,
        }).run();
    }

    load(selector, loadNodesCallback, showTags=true) {

        this.cy = window.cy = window.cytoscape({
            container: document.getElementById(selector),

            ready: function () {
                let layoutUtilities = this.layoutUtilities({
                    desiredAspectRatio: this.width() / this.height()
                });

                this.layout({
                    name: 'fcose',
                    animate: false,
                    nodeRepulsion: 5500,
                    idealEdgeLength: 200,
                    edgeElasticity: 0.45,
                    randomize: false,
                }).run();
            },
            zoom: 0.7,
            minZoom: 0.7,
            maxZoom: 1.25,
            wheelSensitivity: 0.25,
            refresh: 20,
            padding:150,
            style: [
                {
                    selector: 'node',
                    css: {
                        'content': 'data(name)',
                        "shape": "roundrectangle",
                        "text-halign": "center",
                        "text-valign": "top",
                        "opacity": "1",
                        'font-family': '"Nunito", sans-serif',
                        'color': '#FDFFFC'
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
                    selector: 'node.selected',
                    style: {
                        'border-color': '#177E89',
                        'border-width': 4,
                        'border-style': 'dotted',
                        'text-outline-width': 2,
                        'text-outline-color': '#FDFFFC',
                        'color': '#084C61',
                    }
                },
                {
                    selector: 'edge',
                    css: {
                        'curve-style': 'unbundled-bezier',
                        'target-arrow-shape': 'triangle',
                        'target-arrow-color': '#DB3A34',
                        'source-arrow-color': '#177E89',
                        'line-opacity': 0.85,
                        'width': 2,
                        'font-family': '"Nunito", sans-serif',
                    }
                },
                {
                    selector: 'edge.selected',
                    css: {
                        'line-style': 'dashed',
                        'width': 3,
                    }
                },
                {
                    selector: '.level_1',
                    css: {
                        'line-color': '#177E89',
                    }
                },
                {
                    selector: '.level_2',
                    css: {
                        'line-color': '#FFC857',
                    }
                },
                {
                    selector: '.level_3',
                    css: {
                        'line-color': '#DB3A34',
                    }
                },
                {
                    selector: 'node.serviceInstance',
                    style: {
                        'background-color': '#084C61',
                        //'border-width': '2',
                        'text-wrap': 'wrap',
                        'text-valign': 'center',
                        'text-halign': 'center',
                        'text-max-width': '100px',
                        'label': 'data(name)',
                        'width': 'label',
                        //'height': 'label',
                        'padding': 10,
                    }
                },
                {
                    selector: '.container',
                    style: {
                        "text-valign": "top",
                        "shape": "roundrectangle",
                        "text-margin-y": "0px",
                        "font-weight" : "bold",
                        "border-color": "#084C61",
                        "padding": 30,
                        "border-color": "#555555",
                        'color': '#323031'
                    }
                },
                {
                    selector: '.dark',
                    style: {
                        "color": "#858d94",
                    }
                },
                {
                    selector: '.disabled',
                    style: {
                        "background-color": "#FFC857",
                        "border-color": "#f8d999",
                        "color": "#6c757d",
                    }
                }
            ],
           elements: loadNodesCallback
        });

        cy.on('layoutstart', ( (event) => {
            $('div[id^="tippy-"]').remove();
        }))

        cy.on('layoutready',( (event) => {
            const serviceInstances =  cy.nodes(`.serviceInstance`);
            if(showTags){
                serviceInstances.map((elt) => {
                    Graph.generateTag(elt, elt.data('tag')).show();
                });
            }
        }))

        var edge_style_added = false;
        cy.bind('tap', 'node', function(event) {
            cy.edges().removeClass('selected')
            cy.nodes().removeClass('selected')

            event.target.addClass('selected');
            event.target.connectedEdges().map(edge => {
                edge.addClass('selected');
                cy.nodes('#'+edge.data('source')).addClass('selected');
            })
            edge_style_added = true;
        })
        $('#cy').click( (event) => {
            // Suppression edge style si clic background
            if (!edge_style_added) {
                cy.edges().removeClass('selected')
                cy.nodes().removeClass('selected')
            }
            edge_style_added = false;
        })

        cy.ready(function() {
            const serviceInstances =  cy.nodes(`.serviceInstance`);
            if(showTags){
                serviceInstances.map((elt) => {
                    Graph.generateTag(elt, elt.data('tag')).show();
                });
            }
        })

        // Menu contextuel
        cy.cxtmenu({
            selector: 'node',
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
            ]
        });

        cy.cxtmenu({
            selector: 'core',
            commands: [
                {
                    content: 'Light',
                    select: function () {
                        $('#'+selector).css('background', "#FDFFFC");
                        cy.nodes(`.container`).removeClass('dark');
                    }
                },
                {
                    content: 'Dark',
                    select: function () {
                        $('#'+selector).css('background', "#343a40");
                        cy.nodes(`.container`).addClass('dark');
                    }
                }
            ]
        });

    }

    static generateTag(ele, text, placement='bottom', theme='material', arrow=false){
        var ref = ele.popperRef();

        // Since tippy constructor requires DOM element/elements, create a placeholder
        var dummyDomEle = document.createElement('div');

        var tip = tippy( dummyDomEle, {
            getReferenceClientRect: ref.getBoundingClientRect,
            trigger: 'manual', // mandatory
            // dom element inside the tippy:
            content: text,
            // your own preferences:
            theme: theme,
            arrow: arrow,
            zIndex:0,
            placement: placement,
            hideOnClick: false,
            plugins: [window.tippyPluginSticky],
            sticky: "reference",
            // if interactive:
            interactive: false,
            appendTo: document.body // or append dummyDomEle to document.body
        } );

        return tip;
    };

    static hideAllTag(){
        hideAll();
    }

    // Chargement des données par application
    static getNodesByApplication(params) {
        return window.axios.get("/applicationMapping/graphNodesByApp", {
            params: params
        });
    }

    // Chargement des données par hébergement
    static getNodesByHosting(params) {
        return window.axios.get("/applicationMapping/graphNodesByHosting", {
            params: params
        });
    }

     // Chargement des données par hébergement
     static getNodesAppMap(params) {
        return window.axios.get("/applicationMapping/graphNodesAppMap", {
            params: params
        });
    }
}

export default Graph;
