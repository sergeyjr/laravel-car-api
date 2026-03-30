const { createApp } = Vue;

createApp({
    data() {
        return {
            cars: [],
            page: 1,
            total: 0,
            perPage: 6,
            loading: false,
            token: null
        };
    },

    async mounted() {
        this.token = localStorage.getItem('token');

        if (!this.token) {
            await this.login();
        }

        await this.loadCars();
    },

    methods: {
        async login() {
            const res = await axios.post('/api/v1/auth/login', {
                login: 'admin',
                password: '123456'
            });

            this.token = res.data.data.token;
            localStorage.setItem('token', this.token);
        },

        async loadCars(page = 1) {
            this.loading = true;

            try {
                const res = await axios.get('/api/v1/car/list', {
                    params: {
                        page,
                        pageSize: this.perPage
                    },
                    headers: {
                        Authorization: `Bearer ${this.token}`
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

        getImageUrl(path) {
            return path ? `/files/${path}` : '/images/cars/default.jpg';
        },

        nextPage() {
            this.loadCars(this.page + 1);
        },

        prevPage() {
            if (this.page > 1) {
                this.loadCars(this.page - 1);
            }
        }
    }
}).mount('#app');
