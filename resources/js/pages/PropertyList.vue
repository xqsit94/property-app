<template>
    <div class="card">
        <div class="card-header">
            Property List
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>Property Address</th>
                        <th>Postcode</th>
                        <th>Main Owner</th>
                        <th>Sub Owners</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(property, i) in properties.data" :key="i">
                        <td>{{ property.address.house_name_number }}</td>
                        <td>{{ property.address.postcode }}</td>
                        <td>{{ property.main_owner.full_name }}</td>
                        <td><div class="btn-sm" v-for="owner in property.sub_owners">{{ owner.full_name }}</div></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <router-link :to="`/show/${property.id}`" class="btn btn-sm btn-info">View</router-link>
                                <router-link :to="`/edit/${property.id}`" class="btn btn-sm btn-warning">Edit</router-link>
                                <button type="button" class="btn btn-sm btn-danger" @click="deleteData(property.id)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="float-start">
                <router-link to="/create" class="btn btn-primary">Create Property</router-link>
            </div>
            <div class="float-end" v-if="properties">
                <pagination v-model="properties.current_page" :records="properties.total" :per-page="properties.per_page" @paginate="listProperties"/>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Pagination from 'v-pagination-3'

export default {
    components: {
        Pagination
    },

    created() {
        if (_.isEmpty(this.properties)) {
            this.listProperties()
        }
    },

    computed: {
        ...mapGetters({
            properties: 'PropertyStore/properties',
            errors: 'PropertyStore/errors',
        }),
    },

    methods: {
        ...mapActions({
            getProperties: 'PropertyStore/getProperties',
            getProperty: 'PropertyStore/getProperty',
            deleteProperty: 'PropertyStore/deleteProperty',
        }),

        listProperties(page = 1) {
            let params = {}
            params = { page, ...params }
            this.getProperties(params)
        },

        deleteData(propertyId) {
            const confirmDelete = window.confirm('Are you sure do you want to delete this property?')
            if(confirmDelete) {
                this.deleteProperty(propertyId)
                    .then(() => {
                        this.listProperties()
                    })
                    .catch((error) => {
                        this.$store.commit(
                            'PropertyStore/setErrors',
                            error.response.data.errors
                        )
                    })
            }
        },
    },
}
</script>
