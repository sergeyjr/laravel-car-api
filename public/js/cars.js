const { createApp } = Vue;

const API_KEY = 'kpR85bh5hge%$';

axios.interceptors.request.use((config) => {
    config.headers['X-API-KEY'] = API_KEY;
    return config;
});

createApp({
    data() {
        return {
            cars: [],
            car: null,

            page: 1,
            total: 0,
            perPage: 6,

            ready: false,
            loading: false,

            carId: globalThis.carId
        };
    },

    async mounted() {
        if (this.carId) {
            await this.loadCar();
        } else {
            await this.loadCars();
        }

        this.ready = true;
    },

    methods: {
        async loadCars(page = 1) {
            this.loading = true;

            try {
                const res = await axios.get('/api/v1/car/list', {
                    params: {
                        page,
                        pageSize: this.perPage
                    }
                });

                const data = res.data.data;

                this.cars = data.items;
                this.page = data.page;
                this.total = data.total;
                this.perPage = data.perPage;
            } finally {
                this.loading = false;
            }
        },

        async loadCar() {
            this.loading = true;

            try {
                const res = await axios.get(`/api/v1/car/${this.carId}`);
                this.car = res.data.data;
            } finally {
                this.loading = false;
            }
        },

        goToCar(id) {
            globalThis.location.href = `/cars/${id}`;
        },

        goBack() {
            globalThis.location.href = '/cars';
        },

        nextPage() {
            this.loadCars(this.page + 1);
        },

        prevPage() {
            if (this.page > 1) {
                this.loadCars(this.page - 1);
            }
        },

        getImageUrl(path) {
            return path ? `/files/${path}` : '/images/cars/default.jpg';
        }
    }
}).mount('#app');
