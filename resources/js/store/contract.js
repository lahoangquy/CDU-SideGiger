export default {
    namespaced: true,
    state: {
        statuses: [{
                id: 1,
                name: 'In-Process'
            },
            {
                id: 2,
                name: 'Completed'
            },
        ]
    },
    getters: {
        statuses: (state) => {
            return state.statuses;
        }
    },
};
