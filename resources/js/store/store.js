import Vue from 'vue';
import Vuex from 'vuex';
import project from './project'
import category from './category'
import contract from './contract'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        project,
        category,
        contract
    },
    state: {},
    getters: {},
    mutations: {},
    actions: {}
});
