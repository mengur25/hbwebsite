function booking_analytics(period = 1) {
    let data = new FormData();
    data.append('booking_analytics', true);
    data.append('period', period);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);

    xhr.onload = function () {
        try {
            let data2 = JSON.parse(this.responseText);
            document.getElementById('total_bookings').textContent = data2.total_bookings;
            document.getElementById('total_amt').textContent = 'VND ' + data2.total_amt;
            document.getElementById('active_bookings').textContent = data2.active_bookings;
            document.getElementById('active_amt').textContent = 'VND ' + data2.active_amt;
            document.getElementById('cancelled_bookings').textContent = data2.cancelled_bookings;
            document.getElementById('cancelled_amt').textContent = 'VND ' + data2.cancelled_amt;
        } catch (e) {
            console.error('Error parsing booking_analytics response:', e);
        }
    };
    xhr.onerror = function () {
        console.error('Request failed for booking_analytics');
    };
    xhr.send(data);
}

function user_analytics(period = 1) {
    let data = new FormData();
    data.append('user_analytics', true);
    data.append('period', period);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/dashboard.php", true);

    xhr.onload = function () {
        console.log('Raw response:', this.responseText);
        try {
            let data2 = JSON.parse(this.responseText);
            document.getElementById('total_new_reg').textContent = data2.total_new_reg;
            document.getElementById('total_queries').textContent = data2.total_queries;
            document.getElementById('total_reviews').textContent = data2.total_reviews;
        } catch (e) {
            console.error('Error parsing user_analytics response:', e);
        }
    };
    xhr.onerror = function () {
        console.error('Request failed for user_analytics');
    };
    xhr.send(data);
}

window.onload = function () {
    booking_analytics();
    user_analytics();
};