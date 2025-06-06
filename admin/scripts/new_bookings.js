function get_bookings(search='') {
    let data = new FormData();
    data.append('get_bookings', '');
    data.append('search', search);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);

    xhr.onload = function () {
        document.getElementById('table-data').innerHTML = this.responseText;

    }
    xhr.send(data);

}

let assign_room_form = document.getElementById('assign_room_form');
function assign_room(id){
    assign_room_form.elements['booking_id'].value =id;
}

assign_room_form.addEventListener('submit', function(e){
    e.preventDefault();


    let data = new FormData();
    data.append('room_no', assign_room_form.elements['room_no'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room','');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if(response1.success){
            alert('success','Room Number Alloted! Booking Finalized');
            assign_room_form.reset();
            get_bookings();
        }
        else{
            alert('error', 'Server Down!')
        }

    }
    xhr.send(data);
});

function cancel_booking(id){
    if (confirm("Are you sure you want to cancel this booking?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings.php", true);

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
                alert('success', 'Booking Removed!');
                get_bookings();
            } else {
                console.error("Error: ", response.error || 'Booking Removal Failed');
                alert('error', response.error || 'Booking Removal Failed');
            }
        };

        xhr.send(data);
    }
}


window.onload = function () {
    get_bookings();
}