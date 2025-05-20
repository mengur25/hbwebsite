let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');
let facilityDescEditor;

document.getElementById('facility-s').addEventListener('shown.bs.modal', function () {
    if (!facilityDescEditor) {
        ClassicEditor
            .create(document.querySelector('#facility_desc_editor'))
            .then(editor => {
                facilityDescEditor = editor;

                editor.model.document.on('change:data', () => {
                    const plainText = editor.ui.getEditableElement().innerText.trim();
                    document.querySelector('textarea[name="facility_desc"]').value = plainText;
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
    }
});

document.getElementById('facility-s').addEventListener('hidden.bs.modal', function () {
    if (facilityDescEditor) {
        facilityDescEditor.setData('');
    }
});
feature_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_feature();
});

function add_feature() {
    let data = new FormData();
    data.append('name', feature_s_form.elements['feature_name'].value);
    data.append('add_feature', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('feature-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 1) {
            alert('success', 'New feature added!');
            feature_s_form.elements['feature_name'].value = '';
            get_features();
        } else {
            alert('error', 'Server down!');

        }
    }
    xhr.send(data);
}

function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('features-data').innerHTML = this.responseText;
    }
    xhr.send('get_features');
}

function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        //console.log("Response từ server:", this.responseText);
        try {
            var resp = JSON.parse(this.responseText);
            if (resp.success) {
                alert('success', 'Feature removed!');
                get_features();
            } else if (resp.room_added) {
                alert('error', 'Feature is added in room!');
            } else {
                alert('error', 'Server down!');
            }
        } catch (e) {
            // console.error("Lỗi JSON:", e);
            // console.error("Dữ liệu nhận được:", this.responseText);
            alert('error', 'Server Error!!');
        }
    }
    xhr.send('rem_feature=' + val);
}

facility_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_facility();
});

function add_facility() {
    let data = new FormData();
    data.append('name', facility_s_form.elements['facility_name'].value);
    data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc', facility_s_form.elements['facility_desc'].value);
    data.append('add_facility', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('facility-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG and PNG images are allowed');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 1MB!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server down!');
        } else {
            alert('success', 'New facility added!');
            facility_s_form.reset();
            get_facilities();
        }

    }
    xhr.send(data);
}

function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('facilities-data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities');
}

function rem_facility(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        //console.log("Response từ server:", this.responseText);
        try {
            var resp = JSON.parse(this.responseText);
            if (resp.success) {
                alert('success', 'Facility removed!');
                get_facilities();
            } else if (resp.room_added) {
                alert('error', 'Facility is added in room!');
            } else {
                alert('error', 'Server down!');
            }
        } catch (e) {
            // console.error("Lỗi JSON:", e);
            // console.error("Dữ liệu nhận được:", this.responseText);
            alert('error', 'Server Error!');
        }
    }
    xhr.send('rem_facility=' + val);
}
window.onload = function () {
    get_features();
    get_facilities();
}
