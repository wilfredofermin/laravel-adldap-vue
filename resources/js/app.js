/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//VUE ROUTER - REFERENCIA : https://router.vuejs.org/installation.html
import VueRouter from "vue-router";
Vue.use(VueRouter);

let routes = [
    {
        path: "/nuevo-ingreso",
        component: require("./components/Nuevo-Ingreso.vue").default
    },
    {
        path: "/miembros",
        component: require("./components/Miembros.vue").default
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
