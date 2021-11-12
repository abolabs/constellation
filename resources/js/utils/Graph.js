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

                this.layout({
                    name: 'fcose',
                    animate: false,
                    nodeRepulsion: 5500,
                    idealEdgeLength: 200,
                    edgeElasticity: 0.45,
                }).run();
            },
            zoom: 0.75,
            minZoom: 0.750,
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
                        "border-color": "#555555",
                        'font-family': '"Nunito", sans-serif',
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
                        'text-wrap': 'wrap',
                        'text-valign': 'center',
                        'text-halign': 'center',
                        'text-max-width': '100px',
                        'label': 'data(name)',
                        'width': 'label',
                        'height': 'label',
                        'color':  '#FDFFFC',
                        'padding': 10,
                    }
                },
                {
                    selector: '.application',
                    style: {
                        "text-valign": "top",
                        "shape": "roundrectangle",
                        "text-margin-y": "0px",
                        "font-weight" : "bold",
                        "border-color": "#084C61",
                        "padding": 30,
                    }
                }
            ],
           elements: loadNodesCallback
        });

        cy.on('layoutstart', ( (event) => {
            $('div[id^="tippy-"]').remove();
        }))

        cy.on('layoutready',( (event) => {
            const appInstances =  cy.nodes(`.appInstance`);
            appInstances.map((elt) => {
                Graph.generateTag(elt, elt.data('tag')).show();
            });
        }))

        cy.ready(function() {
            const appInstances =  cy.nodes(`.appInstance`);
            appInstances.map((elt) => {
                Graph.generateTag(elt, elt.data('tag')).show();
            });
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

    static generateTag(ele, text, placement='bottom', theme='material'){
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
            arrow: false,
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
}

export default Graph;
