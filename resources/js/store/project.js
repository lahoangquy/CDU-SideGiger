export default {
    namespaced: true,
    state: {
        project: {},
        projects: [],
        statuses: [{
                id: 1,
                name: 'Available'
            },
            {
                id: 2,
                name: 'In-Process'
            },
            {
                id: 3,
                name: 'Completed'
            }
        ]
    },
    getters: {
        project: (state) => {
            return state.project || {};
        },
        projects: (state) => {
            return state.projects || [];
        },
        statuses: (state) => {
            return state.statuses;
        }
    },
    mutations: {
        SET_PROJECT(state, payload) {
            state.project = payload;
        },
        SET_PROJECTS(state, payload) {
            state.projects = Object.values(payload);
        }
    },
    actions: {
        async getProjectByOwner({
            commit
        }) {
            commit('SET_PROJECTS', await this.$util.get(`projects/by-owner`));
        },
        async getProject({
            commit
        }, projectId) {
            commit('SET_PROJECT', await this.$util.get(`projects/${projectId}`));
        },
        async getAllProjects({
            commit
        }) {
            commit('SET_PROJECTS', await this.$util.get(`projects/lists`));
        }
    }
};
