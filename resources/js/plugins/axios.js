import {api} from '@/api'
import {useAuthStore} from '@/stores/authStore'

export default function ({store}) {

    api.interceptors.request.use(function (config) {

        const authStore = useAuthStore();

        if (authStore.token) {
            config.headers['Authorization'] = `Bearer ${authStore.token}`;
        }

        return config;

    }, function (error) {
        return Promise.reject(error);
    });

}
