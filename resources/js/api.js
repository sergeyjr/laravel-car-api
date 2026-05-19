import axios from "axios";
import {useAlertStore} from '@/stores/alertStore'

export const api = axios.create({
    baseURL: '/',
    withCredentials: true,
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        "Accept": "application/json",
    },
});

const IGNORE_ALERT_STATUSES = [
    401, // Unauthorized
    403, // Forbidden
];

const IGNORE_ALERT_URLS = [
    '/api/me'
];

/**
 * RESPONSE INTERCEPTOR — обработка ошибок
 */
api.interceptors.response.use(
    response => response,
    error => {

        const alert = useAlertStore()

        if (error.response?.status === 401) {
            localStorage.removeItem('api_token')
        }

        const status = error.response?.status;
        const url = error.config?.url;

        const isIgnoredStatus = IGNORE_ALERT_STATUSES.includes(status);
        const isIgnoredUrl = IGNORE_ALERT_URLS.some(u => url?.includes(u));

        if (isIgnoredStatus || isIgnoredUrl) {
            return Promise.reject(error);
        }

        const message = error.response?.data?.message;

        if (message) {
            alert.add('error', message);
        }

        const errors = error.response?.data?.errors;

        if (errors) {
            Object.values(errors).forEach(arr => {
                arr.forEach(msg => alert.add('error', msg));
            });
        }

        return Promise.reject(error);
    }
);

export default api;
