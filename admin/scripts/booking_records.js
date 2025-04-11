function get_bookings(search='',page=1) {
    let data = new FormData();
    data.append('get_bookings', '');
    data.append('search', search);
    data.append('page', page);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/booking_records.php", true);

    xhr.onload = function () {
        let data2 = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML = data2.table_data;
        document.getElementById('table-pagination').innerHTML = data2.pagination;
    }
    xhr.send(data);

}


function change_page(page){
    get_bookings(document.getElementById('search_input').value,page);
}

function download(id){
    window.location.href = 'generate_pdf.php?gen_pdf&id=' +id;
}

window.onload = function () {
    get_bookings();
}