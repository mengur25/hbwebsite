let general_data, contacts_data;

let general_s_form = document.getElementById('general_s_form');
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

let contacts_s_form = document.getElementById('contacts_s_form');

let team_s_form = document.getElementById('team_s_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

let siteAboutEditor;
document.getElementById('general-s').addEventListener('shown.bs.modal', function () {
    if (!siteAboutEditor) {
        ClassicEditor
            .create(document.querySelector('#site_about_editor'))
            .then(editor => {
                siteAboutEditor = editor;
                editor.setData(general_data.site_about);
                console.log(general_data.site_about);
                editor.model.document.on('change:data', () => {
                    const editableEl = editor.ui.getEditableElement();
                    const plainText = editableEl.innerText.trim();
                    document.getElementById('site_about_inp').value = plainText;
                });
            })
            .catch(error => {
                console.error(error);
            });
    }
});

team_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
});

function get_general() {
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');

    let shutdow_toggle = document.getElementById('shutdow_toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        general_data = JSON.parse(this.responseText);

        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;

        if (general_data.shutdown == 0) {
            shutdow_toggle.checked = false;
            shutdow_toggle.value = 0;
        } else {
            shutdow_toggle.checked = true;
            shutdow_toggle.value = 1;
        }
    }
    xhr.send('get_general');
}

general_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
})

function upd_general(site_title_val, site_about_val) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        var response = JSON.parse(this.responseText);

        var myModal = document.getElementById('general-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (response.success) {
            alert('success', 'Changes saved!');
            get_general();
        } else {
            alert('error', 'No change saved!');
        }
    }
    xhr.send('site_title=' + encodeURIComponent(site_title_val) +
        '&site_about=' + encodeURIComponent(site_about_val) +
        '&upd_general=1');
}

function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        var res = JSON.parse(this.responseText);
        if (res.success && general_data.shutdown == 0) {
            alert('success', 'Site has been shutdown!');


        }
        else {
            alert('success', 'Shutdown mode off!');
        }
        get_general();
    }

    xhr.send('upd_shutdown=' + val);
}

function get_contacts() {

    let contacts_p_id = ['address', 'gmap', 'pn1', 'pn2', 'email', 'tiktok', 'fb', 'ig'];
    let iframe = document.getElementById('iframe');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        contacts_data = JSON.parse(this.responseText);
        contacts_data = Object.values(contacts_data);
        // console.log(contacts_data);

        for (i = 0; i < contacts_p_id.length; i++) {
            let element = document.getElementById(contacts_p_id[i]);
            if (element) {
                element.innerText = contacts_data[i + 1] || '';
            }
            else {
                console.warn("Element not found:", contacts_p_id[i]);
            }

        }

        iframe.src = contacts_data[9];
        contacts_inp(contacts_data);
    }
    xhr.send('get_contacts');
}

function contacts_inp(data) {
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'tiktok_inp', 'fb_inp', 'ig_inp', 'iframe_inp'];

    for (i = 0; i < contacts_inp_id.length; i++) {
        document.getElementById(contacts_inp_id[i]).value = data[i + 1];
    }
}

contacts_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    upd_contacts();
})

function upd_contacts() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'tiktok', 'fb', 'ig', 'iframe'];
    let contacts_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'tiktok_inp', 'fb_inp', 'ig_inp', 'iframe_inp'];
    let data_str = "";

    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
    }

    data_str += "upd_contacts=1";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        var myModal = document.getElementById('contacts-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        var resp = JSON.parse(this.responseText);
        console.log(resp);
        if (resp.success) {
            alert('success', 'Changes saved!');


        }
        else {
            alert('error', 'No changes made!');
        }
    }

    xhr.send(data_str);

}

team_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_member();
})

function add_member() {
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);

    xhr.onload = function () {
        // console.log("Server Response: ", this.responseText);
        // var response1 = JSON.parse(this.responseText);
        // console.log(response1);
        var myModal = document.getElementById('team-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG and PNG images are allowed');
        }
        else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2MB!');
        }
        else if (this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server down!');
        }
        else {
            alert('success', 'New member added!');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();
        }
    }
    xhr.send(data);
}

function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
}

function rem_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        //console.log("Response từ server:", this.responseText);
        try {
            var resp = JSON.parse(this.responseText);
            if (resp.success) {
                alert('success', 'Member removed!');
                get_members();
            }
            else {
                alert('error', 'Server down!');
            }
        } catch (e) {
            // console.error("Lỗi JSON:", e);
            // console.error("Dữ liệu nhận được:", this.responseText);
            alert('error', 'Server Error!');
        }
    }
    xhr.send('rem_member=' + val);
}

window.onload = function () {
    get_general();
    get_contacts();
    get_members();
}
