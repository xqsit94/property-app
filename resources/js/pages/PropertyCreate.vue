<template>
    <form
        class="form-horizontal"
        @submit.prevent="createProperty(payload)"
    >
        <div class="card">
            <div class="card-header">
                Property Create
            </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="address" class="col-sm-4 col-form-label">Property Address</label>
                        <div class="col-sm-8">
                            <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                autofocus
                                :class="{
                                    'is-invalid': formErrors.hasOwnProperty(
                                        'address'
                                    ),
                                }"
                                v-model="payload.address"
                            />
                            <span
                                v-if="formErrors.address"
                                class="error invalid-feedback"
                            >{{ formErrors.address[0] }}</span
                            >
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <label for="postcode" class="col-sm-4 col-form-label">Postcode</label>
                        <div class="col-sm-8">
                            <input
                                type="text"
                                class="form-control"
                                id="postcode"
                                name="postcode"
                                :class="{
                                    'is-invalid': formErrors.hasOwnProperty(
                                        'postcode'
                                    ),
                                }"
                                v-model="payload.postcode"
                            />
                            <span
                                v-if="formErrors.postcode"
                                class="error invalid-feedback"
                            >{{ formErrors.postcode[0] }}</span
                            >
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <label for="owners" class="col-sm-4 col-form-label">Owners</label>
                        <div class="col-sm-8">
                            <Multiselect
                                v-model="payload.owners"
                                :options="owners"
                                mode="tags"
                                :closeOnSelect="false"
                                :searchable="true"
                                :createTag="true"
                                track-by="first_name"
                                valueProp="id"
                                placeholder="Choose Owners"
                                label="first_name"
                                :class="{
                                    'is-invalid': formErrors.hasOwnProperty(
                                        'owners'
                                    ),
                                }"
                            />
                            <span
                                v-if="formErrors.owners"
                                class="error invalid-feedback"
                            >{{ formErrors.owners[0] }}</span
                            >
                        </div>
                    </div>
                    <div class="form-group row mt-4" v-if="selectedOwners">
                        <label for="main-owner" class="col-sm-4 col-form-label">Main Owner</label>
                        <div class="col-sm-8">
                            <Multiselect
                                v-model="payload.main_owner"
                                :options="selectedOwners"
                                :closeOnSelect="true"
                                :searchable="true"
                                valueProp="id"
                                placeholder="Choose Main Owner"
                                label="first_name"
                                :class="{
                                    'is-invalid': formErrors.hasOwnProperty(
                                        'main_owner'
                                    ),
                                }"
                            />
                            <span
                                v-if="formErrors.main_owner"
                                class="error invalid-feedback"
                            >{{ formErrors.main_owner[0] }}</span
                            >
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-start">
                        <router-link to="/" class="btn btn-primary">Back</router-link>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-info">Save</button>
                    </div>
                </div>
        </div>
    </form>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Multiselect
    },

    data: () => ({
        payload: {
            address: null,
            postcode: null,
            owners: null,
            main_owner: null
        },
        selectedOwners: [],
        formErrors: [],
    }),

    watch: {
        'payload.owners': function (owners) {
            this.selectedOwners = []
            if (owners) {
                let data
                owners.forEach(id => {
                    data = this.owners.find(owner => {
                        return owner.id === id
                    })
                    this.selectedOwners.push(data)
                })
            }
        }
    },

    created() {
        if (_.isEmpty(this.owners)) {
            this.getOwners()
        }
    },

    computed: {
        ...mapGetters({
            owners: 'OwnerStore/owners',
            errors: 'PropertyStore/errors',
        }),
    },

    methods: {
        ...mapActions({
            getOwners: 'OwnerStore/getOwners',
            storeProperty: 'PropertyStore/storeProperty',
        }),

        createProperty(payload) {
            this.storeProperty(payload)
                .then((response) => {
                    this.$router.push({ name: 'property.list' })
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        this.$store.commit(
                            'PropertyStore/setErrors',
                            error.response.data.errors
                        )
                    }
                    this.formErrors = error.response.data.errors
                })
        },
    },
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
