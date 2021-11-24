import { createStore } from 'vuex'
import PropertyStore from "./modules/PropertyStore";
import OwnerStore from "./modules/OwnerStore";

const store = createStore({
    modules: {
        PropertyStore,
        OwnerStore
    },
})

export default store
