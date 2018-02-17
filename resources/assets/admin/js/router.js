import VueRouter from 'vue-router';

import SiteOptions from './vues/SiteOptions/index.vue';

// 1. Define route components.
// These can be imported from other files
const Bar = { template: '<div>bar</div>' };

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
  { path: '/site', component: SiteOptions },
  { path: '/bar', component: Bar },
];

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
export default new VueRouter({
  routes, // short for `routes: routes`
});
