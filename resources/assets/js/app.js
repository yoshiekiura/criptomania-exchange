import 'viewerjs/dist/viewer.css'
import VueViewer from 'v-viewer';

var utf8 = require('utf8');

require('./bootstrap');
window.Vue = require('vue');

Vue.use(VueViewer, {defaultOptions: {zIndex: 9999}});

