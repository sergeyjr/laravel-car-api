export const ORDER_STATUS = {
    pending_payment: 'pending_payment',
    processing: 'processing',
    packed: 'packed',
    shipped: 'shipped',
    completed: 'completed',
    cancelled: 'cancelled',
    refunded: 'refunded'
}

export const orderStatusLabel = (status) => {
    const map = {
        pending_payment: 'Ожидает оплаты',
        processing: 'В обработке',
        packed: 'Собран',
        shipped: 'Отправлен',
        completed: 'Завершён',
        cancelled: 'Отменён',
        refunded: 'Возврат'
    }

    return map[status] || status
}

export const orderStatusClass = (status) => {
    const map = {
        pending_payment: 'pending_payment',
        processing: 'processing',
        packed: 'packed',
        shipped: 'shipped',
        completed: 'completed',
        cancelled: 'cancelled',
        refunded: 'refunded'
    }

    return map[status] || ''
}
