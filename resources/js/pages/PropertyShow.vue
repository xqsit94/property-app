<template>
    <div class="card" v-if="propertyData">
        <div class="card-header">
            Property - {{ propertyData.address.house_name_number }}
        </div>
        <div class="card-body">
            <h4>Property Detail</h4>
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td><strong>Property Address</strong></td>
                        <td>{{ propertyData.address.house_name_number }}</td>
                    </tr>
                    <tr>
                        <td><strong>Postcode</strong></td>
                        <td>{{ propertyData.address.postcode }}</td>
                    </tr>
                    <tr>
                        <td><strong>Owners</strong></td>
                        <td>
                            <span class="btn" v-for="owner in propertyData.sub_owners">
                                {{ owner.full_name }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h4>Main Owner Detail</h4>
            <table class="table table-bordered table-sm">
                <tbody>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{{ propertyData.main_owner.full_name }}</td>
                </tr>
                <tr v-if="propertyData.main_owner.phones">
                    <td><strong>Phone Number</strong></td>
                    <td>
                        <div v-for="phone in propertyData.main_owner.phones">
                            <strong>{{ phone.type }}: </strong> {{ phone.number }}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="float-start">
                <router-link to="/" class="btn btn-primary">Back</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
    data: () => ({
        propertyData: null,
    }),


    async created() {
        await this.get(this.$route.params.property)
    },

    computed: {
        ...mapGetters({
            errors: 'PropertyStore/errors',
        }),
    },

    methods: {
        ...mapActions({
            getProperty: 'PropertyStore/getProperty',
        }),

        async get(propertyId) {
            await this.getProperty(propertyId)
                .then((response) => {
                    this.propertyData = response.data
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        this.$store.commit(
                            'PropertyStore/setErrors',
                            error.response.data.errors
                        )
                    }
                })
        },
    },
}
</script>
