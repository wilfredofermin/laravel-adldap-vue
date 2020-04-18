/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

// FORMATEO DE CONTENIDOS -
//  TEXTOS A CAPITALIZE -  REFERENCIA : https://vuejs.org/v2/guide/filters.html
Vue.filter("capitalize", function(text) {
    if (!text) return "";
    text = text.toString();
    return text.charAt(0).toUpperCase() + text.slice(1);
});

// TEXTOS A MAYUSCULAS
Vue.filter("mayusculas", function(text) {
    if (!text) return "";
    text = text.toString();
    return text.toUpperCase();
});

// FORMATEO DE FECHAS - REFERENCIA : https://momentjs.com/
import moment from "moment";
Vue.filter("fechas", function(created) {
    if (!created) return "";
    return moment(created).format("lll");
});

// Tuggle Button - Referencia : http://vue-js-toggle-button.yev.io/
import ToggleButton from "vue-js-toggle-button";
Vue.use(ToggleButton);

//VUE ROUTER - REFERENCIA : https://router.vuejs.org/installation.html
import VueRouter from "vue-router";
Vue.use(VueRouter);

let routes = [
    {
        path: "/serviceskit",
        component: require("./components/Serviceskit.vue").default
    }
];

const router = new VueRouter({
    routes, // short for `routes: routes`,
    mode: "history" // Esto evitar #/tusitio
});

const app = new Vue({
    el: "#app",
    router
});
