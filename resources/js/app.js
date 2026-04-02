import './bootstrap';

const API_KEY = 'kpR85bh5hge%$';

document.addEventListener('DOMContentLoaded', function () {
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', submitForm);
    }

    const generateBtn = document.getElementById('generateBtn');
    if (generateBtn) {
        generateBtn.addEventListener('click', generateMock);
    }
});

/**
 * CLEAR FIELD ERRORS
 */
function clearErrors() {
    [
        'title','description','price','photo_url','contacts',
        'brand','model','year','body','mileage'
    ].forEach(id => {
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
 * ALERTS
 */
function clearAlerts() {
    document.querySelectorAll('.alert').forEach(el => el.remove());
}

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
 * CHECK OPTIONS FILLED
 */
function getOptions() {
    const brand = document.getElementById('brand').value.trim();
    const model = document.getElementById('model').value.trim();
    const year = document.getElementById('year').value.trim();
    const body = document.getElementById('body').value.trim();
    const mileage = document.getElementById('mileage').value.trim();

    const anyFilled =
        brand || model || year || body || mileage;

    return {
        anyFilled,
        data: {
            brand,
            model,
            year,
            body,
            mileage
        }
    };
}

/**
 * VALIDATE OPTIONS (if needed)
 */
function validateOptions(options) {
    const errors = [];

    if (!options.brand) errors.push('brand');
    if (!options.model) errors.push('model');
    if (!options.year) errors.push('year');
    if (!options.body) errors.push('body');
    if (!options.mileage) errors.push('mileage');

    return errors;
}

/**
 * SUBMIT FORM
 */
async function submitForm() {
    clearErrors();
    clearAlerts();

    const options = getOptions();

    let optionsPayload = [];

    /**
     * RULE:
     * if ANY option filled → all required
     */
    if (options.anyFilled) {
        const missing = validateOptions(options.data);

        if (missing.length > 0) {
            missing.forEach(field => {
                setError(field, 'Это поле обязательно');
            });

            showAlert('Заполните все опции автомобиля', 'danger');
            return;
        }

        optionsPayload = [options.data];
    }

    const form = {
        title: document.getElementById('title').value,
        description: document.getElementById('description').value,
        price: document.getElementById('price').value,
        photo_url: document.getElementById('photo_url').value,
        contacts: document.getElementById('contacts').value,
        options: optionsPayload
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

    if (!response.ok && response.status === 422) {
        showAlert(data.message || 'Ошибка валидации', 'danger');

        if (data.errors) {
            Object.keys(data.errors).forEach(field => {
                setError(field, data.errors[field][0]);
            });
        }
        return;
    }

    if (!response.ok) {
        showAlert(data.message || 'Ошибка сервера', 'danger');
        return;
    }

    showAlert('Успешно создано!', 'success');

    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    document.getElementById('price').value = '';
    document.getElementById('photo_url').value = '';
    document.getElementById('contacts').value = '';

    document.getElementById('brand').value = '';
    document.getElementById('model').value = '';
    document.getElementById('year').value = '';
    document.getElementById('body').value = '';
    document.getElementById('mileage').value = '';
}

/**
 * MOCK DATA
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

        const opt = data.options?.[0];

        document.getElementById('brand').value = opt?.brand ?? '';
        document.getElementById('model').value = opt?.model ?? '';
        document.getElementById('year').value = opt?.year ?? '';
        document.getElementById('body').value = opt?.body ?? '';
        document.getElementById('mileage').value = opt?.mileage ?? '';

        // showAlert('Тестовые данные загружены', 'info');

    } catch (e) {
        showAlert('Ошибка генерации данных', 'danger');
    }

}

console.log('App loaded');
