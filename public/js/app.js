const { createApp } = Vue;

createApp({
    data() {
        return {
            form: {
                title: '',
                description: '',
                price: '',
                photo_url: '',
                contacts: '',
                options: []
            },
            response: null
        }
    },
    methods: {
        async submit() {
            try {
                const res = await fetch('/api/v1/car/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                this.response = await res.json();

            } catch (e) {
                this.response = e.toString();
            }
        }
    }
}).mount('#app');
