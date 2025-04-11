function get_users() {
    let data = new FormData();
    data.append('get_users', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;

    }
    xhr.send(data);

}

function toggle_status(id, val) {
    let data = new FormData();
    data.append('toggle_status', id);
    data.append('value', val);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    xhr.onload = function () {

        if (this.responseText) {
            alert('success', 'Status toggled!');
            get_users();
        } else {
            alert('error', 'Server Down!');
            console.log("Server Response:", this.responseText);
        }

    }
    xhr.send(data);
}

function remove_user(user_id) {
    if (confirm("Are you sure you want to delete this user?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);

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
                alert('success', 'User Removed!');
                get_users();
            } else {
                console.error("Error: ", response.error || 'User Removal Failed');
                alert('error', response.error || 'User Removal Failed');
            }
        };

        xhr.send(data);
    }
}

function search_user(username) {
    let data = new FormData();
    data.append('search_user', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;

    }
    data.append('name', username);
    xhr.send(data);
}

window.onload = function () {
    get_users();
}