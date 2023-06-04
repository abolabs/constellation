// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

import Cytoscape from "cytoscape";
import cxtmenu from "cytoscape-cxtmenu";
import layoutUtilities from "cytoscape-layout-utilities";
import fcose from "cytoscape-fcose";
import "tippy.js/dist/tippy.css";

Cytoscape.use(fcose);
Cytoscape.use(cxtmenu);
Cytoscape.use(layoutUtilities);

class Graph {
  constructor(cy) {
    this.cy = cy;
  }

  static baseLayoutConfig = {
    name: "fcose",
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
    nodeRepulsion: (node) => 100,
    // Ideal edge (non nested) length
    idealEdgeLength: (edge) => 350,
    // Divisor to compute edge forces
    edgeElasticity: (edge) => 0.45,
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
  };

  static style(theme) {
    return [
      {
        selector: "node",
        css: {
          content: "data(name)",
          shape: "roundrectangle",
          "text-halign": "center",
          "text-valign": "top",
          opacity: "1",
          "font-family": '"Nunito", sans-serif',
          color: theme.palette.text.primary, // #FDFFFC
          "font-size": "3em",
        },
      },
      {
        selector: "node:selected",
        style: {
          "background-color": theme.palette.grey[100], // #343a40
          "border-color": theme.palette.primary.main, // "#FDFFFC"
        },
      },
      {
        selector: "node.selected",
        style: {
          "border-color": theme.palette.success.main, // "#177E89"
          "border-width": 15,
          color: theme.palette.success.dark, // "#084C61"
        },
      },
      {
        selector: "node.focused",
        style: {
          "border-color": theme.palette.error.main, // "#d02536"
          "border-width": 15,
          color: theme.palette.primary.main, // "#084C61"
        },
      },
      {
        selector: "edge",
        css: {
          "curve-style": "unbundled-bezier",
          "target-arrow-shape": "triangle",
          "target-arrow-color": theme.palette.error.main, // "#DB3A34"
          "source-arrow-color": theme.palette.success.main, // "#177E89"
          "line-opacity": 0.75,
          width: 8,
          "font-family": '"Nunito", sans-serif',
        },
      },
      {
        selector: "edge.selected",
        css: {
          "line-style": "dashed",
          width: 6,
        },
      },
      {
        selector: ".level_1",
        css: {
          "line-color": theme.palette.success.main, // "#177E89"
        },
      },
      {
        selector: ".level_2",
        css: {
          "line-color": theme.palette.warning.main, // "#FFC857"
        },
      },
      {
        selector: ".level_3",
        css: {
          "line-color": theme.palette.error.main, // "#DB3A34"
        },
      },
      {
        selector: "node.serviceInstance",
        style: {
          shape: "ellipse",
          "background-color": theme.palette.secondary.dark, // "#084C61"
          //'border-width': '2',
          "text-wrap": "wrap",
          //'text-valign': 'center',
          //'text-halign': 'center',
          "text-max-width": "150px",
          //'label': 'data(name)',
          //'width': (node) => { return node.data('name').length * 15 },
          //'height': (node) => { return node.data('name').length * 15 },
          padding: 50,
          color: theme.palette.success.dark, // "#323031"
          "text-background-color": theme.palette.success.contrastText, // "#FDFFFC"
          "text-background-opacity": 0.45,
          "text-background-shape": "round-rectangle",
          "text-background-padding": "0.5em",
          "text-margin-y": "-1em",
        },
      },
      {
        selector: ".container",
        style: {
          "text-valign": "top",
          shape: "roundrectangle",
          "text-margin-y": "0px",
          "font-weight": "bold",
          padding: 75,
          "border-color": theme.palette.background.paper, // "#555555"
          color: theme.palette.text.primary, // "#323031"
          "overlay-color": theme.palette.text.primary, // "#FDFFFC"
          "overlay-opacity": 0.25,
        },
      },
      {
        selector: ".container:selected",
        style: {
          "border-color": theme.palette.primary.dark, // "#555555"
        },
      },
      {
        selector: ".disabled",
        style: {
          "background-color": theme.palette.grey[700],
        },
      },
    ];
  }

  replaceData(newEleJsons) {
    this.cy.json({
      elements: newEleJsons,
      zoom: 0.7,
    });
    this.refreshLayout();
  }

  refreshLayout() {
    this.cy.layout(Graph.baseLayoutConfig).run();
  }

  load({ selector, elements, theme }) {
    let currentGraph = this;
    this.cy = Cytoscape({
      container: document.getElementById(selector),

      ready: function () {
        this.layoutUtilities({
          desiredAspectRatio: this.width() / this.height(),
        });

        let initLayoutConfig = Graph.baseLayoutConfig;
        initLayoutConfig.randomize = true;
        this.layout(initLayoutConfig).run();
      },
      zoom: 0.7,
      minZoom: 0.25,
      maxZoom: 1.0,
      wheelSensitivity: 0.12,
      refresh: 50,
      padding: 200,
      style: Graph.style(theme),
      elements: elements,
    });

    var edge_style_added = false;
    this.cy.off("tap");
    this.cy.on("tap", "node", (event) => {
      currentGraph.resetFocusedElts();

      event.target.addClass("selected");
      event.target.connectedEdges()?.forEach((edge) => {
        edge.addClass("selected");
        this.cy.nodes("#" + edge.data("source")).addClass("selected");
      });
      edge_style_added = true;
    });
    this.cy.on("tap", (event) => {
      if (event?.target !== this?.cy) {
        return;
      }
      // Suppression edge style si clic background
      if (edge_style_added) {
        this.resetFocusedElts();
      }
      edge_style_added = false;
    });

    // Menu contextuel
    this.cy.cxtmenu({
      selector: "node",
      commands: [
        {
          content: '<span><i class="fa fa-flash"></i> common.details </span>',
          select: (ele) => {
            let eltData = ele.id().split("_");
            const eltId = eltData.pop();
            const routePath = eltData.join("_");

            window.location.href = `/${routePath}/${eltId}/show`;
          },
        },
        {
          content:
            '<span><i class="fa fa-bomb"></i> ' +
            "infra.impacts_detection" +
            " </span>",
          select: (ele) => {
            currentGraph.resetFocusedElts();
            return currentGraph.recursiveConnectedEdges(ele, null);
          },
        },
        {
          content: '<span class="fa fa-ban fa-2x"></span>',
          select: (ele) => {
            //console.log( ele.data('name') );
          },
          enabled: false,
        },
      ],
    });
  }

  resetFocusedElts() {
    this.cy.edges().removeClass("selected");
    this.cy.nodes().removeClass("selected");
    this.cy.nodes().removeClass("focused");
  }

  recursiveConnectedEdges(node, sourceNode, detectedNodes = [], delay = 500) {
    let currentGraph = this;

    node.delay(delay, function () {
      node.addClass("focused");
    });

    detectedNodes.push(node.data("id"));
    node.connectedEdges(function (el) {
      if (
        !el.source().anySame(sourceNode) &&
        detectedNodes.indexOf(el.source().data("id")) < 0
      ) {
        currentGraph.recursiveConnectedEdges(
          el.source(),
          node,
          detectedNodes,
          delay + 500
        );
      }
    });
  }
}

export default Graph;
