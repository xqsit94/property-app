import OwnerApi from '../../api/OwnerApi'

const state = {
    owners: {},

    errors: [],
}

const getters = {
    owners: (state) => state.owners,

    errors: (state) => state.errors,
}

const actions = {
    getOwners: async ({ commit }, params) => {
        await OwnerApi.get(params)
            .then((response) => {
                commit('setOwners', response.data)
            })
            .catch((error) => {
                commit(
                    'setErrors',
                    error.response ? error.response.data.errors : []
                )
            })
    },
}

const mutations = {
    setOwners: (state, owners) => {
        state.owners = owners
    },

    setErrors: (state, errors) => {
        state.errors = errors
    },
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}
