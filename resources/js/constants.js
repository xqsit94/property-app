const _wl = window.location

const BASE_URL = `${_wl.protocol}//${_wl.host}`
export const API_URL = `${BASE_URL}/api`

export const AUTH_HEADER = {
    Accept: 'application/json',
}
