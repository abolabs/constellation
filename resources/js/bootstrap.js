window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
    console.log(e);
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

/**
 * selector utils
 */
window.selector = require('./utils/selector');

/**
 * Cytoscape
 */
window.cytoscape = require('cytoscape');
require('cytoscape-cxtmenu');
require('cytoscape-layout-utilities');
require('cytoscape-fcose');

/**
 * Graph
 */
 import('./utils/Graph').then((Graph) => {
    window.Graph = Graph.default;
 });

/**
 * Environnement
 */
 import('./utils/Environnement').then((Environnement) => {
    window.Environnement = Environnement.default;
    console.log("ICI ");
 });

/**
 * Datatable
 */
 var DataTable = require('datatables.net');
 require( 'datatables.net-buttons' );
 require( 'datatables.net-responsive' );

 $.fn.dataTable = DataTable;
 $.fn.dataTableSettings = DataTable.settings;
 $.fn.dataTableExt = DataTable.ext;
 DataTable.$ = $;

 import('./utils/DataTableRenderer').then((DataTableRenderer) => {
    window.DataTableRenderer = DataTableRenderer.default;
 });



