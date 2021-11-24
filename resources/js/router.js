import { createRouter, createWebHashHistory } from 'vue-router'
import PropertyCreate from './pages/PropertyCreate'
import PropertyEdit from './pages/PropertyEdit'
import PropertyList from './pages/PropertyList'

const routes = [
    { path: '/', component: PropertyList, name: 'property.list' },
    { path: '/create', component: PropertyCreate, name: 'property.create' },
    { path: '/edit', component: PropertyEdit, name: 'property.edit' },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes, // short for `routes: routes`
})

export default router;
