import {hideAll} from 'tippy.js';
class Graph {

    static baseLayoutConfig = {
        name: 'fcose',
         // 'draft', 'default' or 'proof'
        // - "draft" only applies spectral layout
        // - "default" improves the quality with incremental layout (fast cooling rate)
        // - "proof" improves the quality with incremental layout (slow cooling rate)
        quality: "proof",
        // Use random node positions at beginning of layout
        // if this is set to false, then quality option must be "proof"
        randomize: false,
        // Whether or not to animate the layout
        animate: false,
        // Duration of animation in ms, if enabled
        animationDuration: 1000,
        // Easing of animation, if enabled
        animationEasing: undefined,
        // Fit the viewport to the repositioned nodes
        fit: true,
        // Padding around layout
        padding: 30,
        // Whether to include labels in node dimensions. Valid in "proof" quality
        nodeDimensionsIncludeLabels: true,
        // Whether or not simple nodes (non-compound nodes) are of uniform dimensions
        uniformNodeDimensions: true,
        // Whether to pack disconnected components - cytoscape-layout-utilities extension should be registered and initialized
        packComponents: true,
        // Layout step - all, transformed, enforced, cose - for debug purpose only
        step: "all",

        /* spectral layout options */

        // False for random, true for greedy sampling
        samplingType: true,
        // Sample size to construct distance matrix
        sampleSize: 250,
        // Separation amount between nodes
        nodeSeparation: 150,
        // Power iteration tolerance
        piTol: 0.00000001,

        /* incremental layout options */

        // Node repulsion (non overlapping) multiplier
        nodeRepulsion: node => 100,
        // Ideal edge (non nested) length
        idealEdgeLength: edge => 350,
        // Divisor to compute edge forces
        edgeElasticity: edge => 0.45,
        // Nesting factor (multiplier) to compute ideal edge length for nested edges
        nestingFactor: 0.1,
        // Maximum number of iterations to perform - this is a suggested value and might be adjusted by the algorithm as required
        numIter: 2500,
        // For enabling tiling
        tile: true,
        // Represents the amount of the vertical space to put between the zero degree members during the tiling operation(can also be a function)
        tilingPaddingVertical: 10,
        // Represents the amount of the horizontal space to put between the zero degree members during the tiling operation(can also be a function)
        tilingPaddingHorizontal: 10,
        // Gravity force (constant)
        gravity: 0.25,
        // Gravity range (constant) for compounds
        gravityRangeCompound: 1.5,
        // Gravity force (constant) for compounds
        gravityCompound: 1.0,
        // Gravity range (constant)
        gravityRange: 3.8,
        // Initial cooling factor for incremental layout
        initialEnergyOnIncremental: 1.3,

        /* constraint options */

        // Fix desired nodes to predefined positions
        // [{nodeId: 'n1', position: {x: 100, y: 200}}, {...}]
        fixedNodeConstraint: undefined,
        // Align desired nodes in vertical/horizontal direction
        // {vertical: [['n1', 'n2'], [...]], horizontal: [['n2', 'n4'], [...]]}
        alignmentConstraint: undefined,
        // Place two nodes relatively in vertical/horizontal direction
        // [{top: 'n1', bottom: 'n2', gap: 100}, {left: 'n3', right: 'n4', gap: 75}, {...}]
        relativePlacementConstraint: undefined,
    }

    static style = [
        {
            selector: 'node',
            css: {
                'content': 'data(name)',
                "shape": "roundrectangle",
                "text-halign": "center",
                "text-valign": "top",
                "opacity": "1",
                'font-family': '"Nunito", sans-serif',
                'color': '#FDFFFC',
                'font-size': '3em',
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
                'border-width': 20,
                'color': '#084C61',
            }
        },
        {
            selector: 'node.focused',
            style: {
                'border-color': '#d02536',
                'border-width': 20,
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
                'line-opacity': 0.75,
                'width': 8,
                'font-family': '"Nunito", sans-serif',
            }
        },
        {
            selector: 'edge.selected',
            css: {
                'line-style': 'dashed',
                'width': 6,
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
                "shape": "ellipse",
                'background-color': '#084C61',
                //'border-width': '2',
                'text-wrap': 'wrap',
                //'text-valign': 'center',
                //'text-halign': 'center',
                'text-max-width': '150px',
                //'label': 'data(name)',
                //'width': (node) => { return node.data('name').length * 15 },
                //'height': (node) => { return node.data('name').length * 15 },
                'padding': 50,
                'color': '#323031',
                'text-background-color': '#FDFFFC',
                'text-background-opacity': 0.25,
                'text-background-shape': 'round-rectangle',
                'text-background-padding': '0.5em',
                "text-margin-y": "-1em",
            }
        },
        {
            selector: '.container',
            style: {
                "text-valign": "top",
                "shape": "roundrectangle",
                "text-margin-y": "0px",
                "font-weight" : "bold",
                "padding": 75,
                "border-color": "#555555",
                'color': '#323031',
                'overlay-color': '#FDFFFC',
                'overlay-opacity': 0.25,


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
    ]

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
        this.cy.layout(Graph.baseLayoutConfig).run();
    }

    load(selector, loadNodesCallback, showTags=true) {

        let currentGraph = this;
        this.cy = window.cy = window.cytoscape({
            container: document.getElementById(selector),

            ready: function () {
                this.layoutUtilities({
                    desiredAspectRatio: this.width() / this.height()
                });

                let initLayoutConfig = Graph.baseLayoutConfig;
                initLayoutConfig.randomize = true;
                this.layout(initLayoutConfig).run();
            },
            zoom: 0.7,
            minZoom: 0.25,
            maxZoom: 1.00,
            wheelSensitivity: 0.15,
            refresh: 50,
            padding:200,
            style: Graph.style,
           elements: loadNodesCallback
        });

        cy.on('layoutstart', ( (event) => {
            $('div[id^="tippy-"]').remove();
        }))

        cy.on('layoutready',( (event) => {
            currentGraph.manageTags(showTags);
        }))

        var edge_style_added = false;
        cy.bind('tap', 'node', function(event) {
            currentGraph.resetFocusedElts();

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
                currentGraph.resetFocusedElts();
            }
            edge_style_added = false;
        })

        cy.ready(function() {
            currentGraph.manageTags(showTags);
        })

        // Menu contextuel
        cy.cxtmenu({
            selector: 'node',
            commands: [
                {
                    content: '<span><i class="fa fa-flash"></i> '+window.lang.get('common.details') + '</span>',
                    select: (ele) => {
                        const eltData = ele.id().split("_");
                        window.location.href = '/' + eltData[0] + "s/" + eltData[1];
                    }
                },
                {
                    content: '<span><i class="fa fa-bomb"></i> '+window.lang.get('infra.impacts_detection')+' </span>',
                    select: (ele) => {
                        currentGraph.resetFocusedElts();
                        return currentGraph.recursiveConnectedEdges(ele, null);
                    }
                },
                {
                    content: '<span class="fa fa-ban fa-2x"></span>',
                    select: (ele) => {
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

    resetFocusedElts(){
        cy.edges().removeClass('selected');
        cy.nodes().removeClass('selected');
        cy.nodes().removeClass('focused');
    }

    recursiveConnectedEdges(node, sourceNode, detectedNodes = [], delay=500){
        let currentGraph = this;

        node.delay( delay, function(){
            node.addClass('focused');
        });

        detectedNodes.push(node.data('id'));
        node.connectedEdges(function(el){
            if(!el.source().anySame( sourceNode ) && detectedNodes.indexOf(el.source().data('id')) < 0){
                currentGraph.recursiveConnectedEdges(el.source(), node, detectedNodes, delay+500);
            }
        });
    }

    manageTags(showTags){
        const serviceInstances =  cy.nodes(`.serviceInstance`);
        if(showTags){
            serviceInstances.map((elt) => {
                if(elt.data('tag') != ''){
                    Graph.generateTag(elt, elt.data('tag')).show();
                }
            });
        }
    }

    static generateTag(ele, text, placement='bottom', theme='material', arrow=false){
        var ref = ele.popperRef();

        // Since tippy constructor requires DOM element/elements, create a placeholder
        var dummyDomEle = document.createElement('div');

        return tippy( dummyDomEle, {
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
    }

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
