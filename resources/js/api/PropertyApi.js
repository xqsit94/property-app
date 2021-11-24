import { API_URL, AUTH_HEADER as headers } from '../constants'
import axios from "axios";

const resource = `${API_URL}/properties`

export default {
    get(params) {
        return axios.get(`${resource}`, { headers, params });
    },
    show(id) {
        return axios.get(`${resource}/${id}`, { headers });
    },
    store(payload) {
        return axios.post(`${resource}`, payload, { headers });
    },
    update(payload, id) {
        return axios.put(`${resource}/${id}`, payload, { headers });
    },
    delete(id) {
        return axios.delete(`${resource}/${id}`, { headers })
    },
};
