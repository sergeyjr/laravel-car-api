const API_KEY = 'kpR85bh5hge%$';

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submitBtn').addEventListener('click', submitForm);
});

function clearErrors() {
    ['title','description','price','photo_url','contacts'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.remove('is-invalid');
        }

        const feedback = document.querySelector(`#${id}-error`);
        if (feedback) feedback.innerText = '';
    });
}

function setError(field, message) {
    const el = document.getElementById(field);
    if (!el) return;

    el.classList.add('is-invalid');

    let feedback = document.getElementById(field + '-error');

    if (!feedback) {
        feedback = document.createElement('div');
        feedback.id = field + '-error';
        feedback.className = 'invalid-feedback';

        el.after(feedback);
    }

    feedback.innerText = message;
}

function showMessage(text) {
    document.getElementById('response').innerText = text;
}

async function submitForm() {
    clearErrors();

    const form = {
        title: document.getElementById('title').value,
        description: document.getElementById('description').value,
        price: document.getElementById('price').value,
        photo_url: document.getElementById('photo_url').value,
        contacts: document.getElementById('contacts').value,
        options: []
    };

    let response;

    try {
        response = await fetch('/api/v1/car/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-API-KEY': API_KEY
            },
            body: JSON.stringify(form)
        });
    } catch (e) {
        showMessage('Ошибка сети');
        return;
    }

    let data = await response.json();

    if (!response.ok) {

        if (response.status === 422) {

            showMessage(data.message || 'Ошибка валидации');

            Object.keys(data.errors || {}).forEach(field => {
                const msg = data.errors[field][0];
                setError(field, msg);
            });

            return;
        }

        showMessage(data.message || 'Ошибка сервера');
        return;
    }

    showMessage('Успешно создано!');
}

document.getElementById('generateBtn').addEventListener('click', async () => {
    const res = await fetch('/api/v1/cars/generate-mock');
    const json = await res.json();

    const data = json.data;

    document.getElementById('title').value = data.title;
    document.getElementById('description').value = data.description;
    document.getElementById('price').value = data.price;
    document.getElementById('photo_url').value = data.photo_url;
    document.getElementById('contacts').value = data.contacts;
});

