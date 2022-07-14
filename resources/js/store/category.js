export default {
    namespaced: true,
    state: {
        categories: [],
    },
    getters: {
        categories: (state) => {
            return state.categories || [];
        }
    },
    mutations: {
        SET_CATEGORIES(state, payload) {
            state.categories = Object.values(payload);
        }
    },
    actions: {
        async getAllCategories({
            commit
        }) {
            commit('SET_CATEGORIES', await this.$util.get(`categories`));
        }
    }
};
