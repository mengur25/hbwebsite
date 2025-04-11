function get_bookings(search='') {
    let data = new FormData();
    data.append('get_bookings', '');
    data.append('search', search);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/refund_bookings.php", true);

    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;

    }
    xhr.send(data);

}



function refund_booking(id){
    if (confirm("Refund money for this booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('refund_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/refund_bookings.php", true);

        xhr.onload = function () {
            console.log("Server Response: ", this.responseText);
            if (this.responseText.trim() === '') {
                console.error("Error: Server returned empty response");
                alert('error', 'Server returned empty response');
                return;
            }
            let response;
            try {
                response = JSON.parse(this.responseText);
            } catch (e) {
                console.error("Error: Invalid server response", this.responseText);
                alert('error', 'Invalid server response');
                return;
            }
            if (response.success) {
                alert('success', 'Refund successful!');
                get_bookings();
            } else {
                console.error("Error: ", response.error || 'Refund Failed');
                alert('error', response.error || 'RefundFailed');
            }
        };

        xhr.send(data);
    }
}


window.onload = function () {
    get_bookings();
}