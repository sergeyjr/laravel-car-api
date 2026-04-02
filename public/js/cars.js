const API_KEY = 'kpR85bh5hge%$';

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('submitBtn').addEventListener('click', submitForm);

    const generateBtn = document.getElementById('generateBtn');
    if (generateBtn) {
        generateBtn.addEventListener('click', generateMock);
    }
});

/**
 * CLEAR FIELD ERRORS
 */
function clearErrors() {
    ['title','description','price','photo_url','contacts'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.remove('is-invalid');

        const feedback = document.getElementById(id + '-error');
        if (feedback) feedback.remove();
    });
}

/**
 * FIELD ERROR
 */
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

/**
 * HIDE ALL LARAVEL ALERTS (BY CLASS)
 */
function clearAlerts() {
    document.querySelectorAll('.alert').forEach(el => el.remove());
}

/**
 * SHOW ALERT (Laravel style)
 */
function showAlert(message, type = 'info') {
    clearAlerts();

    const container = document.getElementById('alert-container');

    if (!container) return;

    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerText = message;

    container.prepend(alert);
}

/**
 * SUBMIT FORM
 */
async function submitForm() {
    clearErrors();
    clearAlerts();

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
        showAlert('Ошибка сети', 'danger');
        return;
    }

    let data = await response.json();

    /**
     * VALIDATION ERROR (422)
     */
    if (!response.ok && response.status === 422) {

        showAlert(data.message || 'Ошибка валидации', 'danger');

        if (data.errors) {
            Object.keys(data.errors).forEach(field => {
                setError(field, data.errors[field][0]);
            });
        }

        return;
    }

    /**
     * OTHER ERRORS
     */
    if (!response.ok) {
        showAlert(data.message || 'Ошибка сервера', 'danger');
        return;
    }

    /**
     * SUCCESS
     */
    showAlert('Успешно создано!', 'success');

    // optional reset
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('price').value = '';
    document.getElementById('photo_url').value = '';
    document.getElementById('contacts').value = '';
}

/**
 * GENERATE MOCK DATA
 */
async function generateMock() {
    try {
        const res = await fetch('/api/v1/cars/generate-mock');
        const json = await res.json();

        const data = json.data;

        document.getElementById('title').value = data.title;
        document.getElementById('description').value = data.description;
        document.getElementById('price').value = data.price;
        document.getElementById('photo_url').value = data.photo_url;
        document.getElementById('contacts').value = data.contacts;

        showAlert('Тестовые данные загружены', 'info');

    } catch (e) {
        showAlert('Ошибка генерации данных', 'danger');
    }
}
