import PropertyApi from '../../api/PropertyApi'

const state = {
    properties: {},

    errors: [],
}

const getters = {
    properties: (state) => state.properties,

    errors: (state) => state.errors,
}

const actions = {
    getProperties: async ({ commit }, params) => {
        await PropertyApi.get(params)
            .then((response) => {
                commit('setProperties', response.data)
            })
            .catch((error) => {
                commit(
                    'setErrors',
                    error.response ? error.response.data.errors : []
                )
            })
    },

    getProperty: ({ commit }, propertyId) => {
        return PropertyApi.show(propertyId)
    },

    storeProperty: ({ commit }, payload) => {
        return PropertyApi.store(payload)
    },

    updateProperty: ({ commit }, { propertyId, payload }) => {
        return PropertyApi.update(payload, propertyId)
    },

    deleteProperty: ({ commit }, propertyId) => {
        return PropertyApi.delete(propertyId)
    },
}

const mutations = {
    setProperties: (state, properties) => {
        state.properties = properties
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
