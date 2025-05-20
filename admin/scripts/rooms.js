let add_room_form = document.getElementById('add_room_form');
add_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_room();
})

function add_room() {
    let data = new FormData();
    data.append('add_room', '');
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('desc', add_room_form.elements['desc'].value);

    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));



    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('add-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New room added!');
            add_room_form.reset();
            get_all_rooms();
        } else {
            alert('error', 'Server down!');

        }
    }
    xhr.send(data);
}

function get_all_rooms() {
    let data = new FormData();
    data.append('get_all_rooms', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room-data').innerHTML = this.responseText;

    }
    xhr.send(data);

}

let edit_room_form = document.getElementById('edit_room_form');
edit_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    submit_edit_room();
});

function submit_edit_room() {
    let data = new FormData();
    data.append('edit_room', '');
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('desc', edit_room_form.elements['desc'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });

    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));



    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('edit-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'Room data edited!');
            edit_room_form.reset();
            get_all_rooms();
        } else {
            alert('error', 'Server down!');

        }
    }
    xhr.send(data);
}

let roomData = {};

function edit_details(id) {
    // Xóa dữ liệu cũ để tránh sử dụng giá trị cũ
    roomData = {};

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            try {
                let data = JSON.parse(this.responseText);
                // Gán dữ liệu phòng vào roomData
                roomData = data.roomdata || {};
                console.log('roomData:', roomData); // Kiểm tra dữ liệu

                // Populate form fields
                const form = document.getElementById('edit_room_form');
                if (form) {
                    form.elements['name'].value = roomData.name || '';
                    form.elements['area'].value = roomData.area || '';
                    form.elements['price'].value = roomData.price || '';
                    form.elements['quantity'].value = roomData.quantity || '';
                    form.elements['adult'].value = roomData.adult || '';
                    form.elements['children'].value = roomData.children || '';
                    form.elements['room_id'].value = roomData.id || '';

                    // Populate checkboxes for features
                    const featureInputs = form.querySelectorAll('[name="features"]');
                    featureInputs.forEach(el => {
                        el.checked = data.features.includes(Number(el.value));
                    });

                    // Populate checkboxes for facilities
                    const facilityInputs = form.querySelectorAll('[name="facilities"]');
                    facilityInputs.forEach(el => {
                        el.checked = data.facilities.includes(Number(el.value));
                    });

                    // Kích hoạt sự kiện để khởi tạo CKEditor
                    const event = new CustomEvent('roomDataLoaded', { detail: roomData });
                    document.dispatchEvent(event);
                } else {
                    console.error('Form element #edit_room_form not found');
                }
            } catch (e) {
                console.error('Error parsing response:', e);
            }
        } else {
            console.error('AJAX request failed with status:', this.status);
        }
    };

    xhr.onerror = function () {
        console.error('AJAX request error');
    };

    xhr.send('get_room=' + encodeURIComponent(id));
}

function toggle_status(id, val) {
    let data = new FormData();
    data.append('toggle_status', id);
    data.append('value', val);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {

        if (this.responseText) {
            alert('success', 'Status toggled!');
            get_all_rooms();
        } else {
            alert('error', 'Server Down!');
            console.log("Server Response:", this.responseText);
        }

    }
    xhr.send(data);
}

let add_image_form = document.getElementById('add_image_form');

add_image_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
});

function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        console.log("Server Response: ", this.responseText);
        let response;
        try {
            response = JSON.parse(this.responseText);
        } catch (e) {
            response = this.responseText;
        }
        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG WEBP or PNG images are allowed', 'image-alert');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2MB!', 'image-alert');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server down!', 'image-alert');
        } else {
            alert('success', 'New image added!', 'image-alert');
            room_images(add_image_form.elements['room_id'].value, document.querySelector("#room-images .modal-title").innerText);
            add_image_form.reset();
        }
    }
    xhr.send(data);
}


function room_images(id, rname) {
    document.querySelector("#room-images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';

    let data = new FormData();
    data.append('get_room_images', id);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }

    xhr.send(data);
}


function rem_image(img_id, room_id) {
    console.log("Removing image:", img_id, "for room:", room_id);
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('rem_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        console.log("Server Response: ", this.responseText);
        let response;
        try {
            response = JSON.parse(this.responseText);
        } catch (e) {
            response = this.responseText;
        }
        if (response.success === true) {
            alert('success', 'Image Removed!', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } else if (this.responseText === "Error: Image not found!") {
            console.log("Image already removed or not found.");
        } else {
            alert('error', 'Image Removal Failed', 'image-alert');
        }
    }
    xhr.send(data);
}

function thumb_image(img_id, room_id) {
    // console.log("Removing image:", img_id, "for room:", room_id);
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/rooms.php", true);

    xhr.onload = function () {
        console.log("Server Response: ", this.responseText);
        let response;
        try {
            response = JSON.parse(this.responseText);
        } catch (e) {
            response = this.responseText;
        }
        if (response.success === true) {
            alert('success', 'Image Thumbnail Changed!', 'image-alert');
            room_images(room_id, document.querySelector("#room-images .modal-title").innerText);
        } else if (this.responseText === "Error: Image not found!") {
            console.log("Image already removed or not found.");
        } else {
            alert('error', 'Thumbnail Update Failed', 'image-alert');
        }
    }
    xhr.send(data);
}

function remove_room(room_id) {
    if (confirm("Are you sure you want to delete this room?")) {
        let data = new FormData();
        data.append('room_id', room_id);
        data.append('remove_room', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/rooms.php", true);

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
                alert('success', 'Room Removed!');
                get_all_rooms();
            } else {
                console.error("Error: ", response.error || 'Room Removal Failed');
                alert('error', response.error || 'Room Removal Failed');
            }
        };

        xhr.send(data);
    }
}

window.onload = function () {
    get_all_rooms();
}

let descriptionEditorAdd, descriptionEditorEdit;

document.getElementById('add-room').addEventListener('shown.bs.modal', function () {
    if (!descriptionEditorAdd) {
        ClassicEditor
            .create(document.querySelector('#description_editor_add'))
            .then(editor => {
                descriptionEditorAdd = editor;
                editor.setData('');
                editor.model.document.on('change:data', () => {
                    const plainText = editor.ui.getEditableElement().innerText.trim();
                    document.getElementById('description_hidden_add').value = plainText;
                });
            })
            .catch(error => {
                console.error(error);
            });
    }
});

document.getElementById('edit-room').addEventListener('shown.bs.modal', function () {
    if (descriptionEditorEdit) {
        descriptionEditorEdit.destroy()
            .then(() => {
                descriptionEditorEdit = null;
                initializeEditEditor();
            })
            .catch(error => {
                console.error('Error destroying edit editor:', error);
                initializeEditEditor();
            });
    } else {
        initializeEditEditor();
    }
});

function initializeEditEditor() {
    ClassicEditor
        .create(document.querySelector('#description_editor_edit'), {
            htmlSupport: {
                allow: [{
                    name: 'p'
                },
                {
                    name: 'br'
                }
                ]
            }
        })
        .then(editor => {
            descriptionEditorEdit = editor;
            if (roomData && roomData.description) {
                editor.setData(roomData.description);
            } else {
                editor.setData('No description available');
                console.warn('roomData.description is not available:', roomData);
            }
            editor.model.document.on('change:data', () => {
                const plainText = editor.ui.getEditableElement().innerText.trim();
                document.getElementById('description_hidden_edit').value = plainText;
            });
        })
        .catch(error => {
            console.error('Error creating edit editor:', error);
        });
}
