import { API_URL, AUTH_HEADER as headers } from '../constants'
import axios from "axios";

const resource = `${API_URL}/owners`

export default {
    get() {
        return axios.get(`${resource}`, { headers });
    },
};
