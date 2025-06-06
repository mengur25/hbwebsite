<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2"><?php echo $settings_r['site_title'] ?></h3>
            <p><?php echo $settings_r['site_about'] ?> </p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="index.php" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a> <br>
            <a href="rooms.php" class="d-inline-block mb-2 text-dark text-decoration-none">Rooms</a> <br>
            <a href="facilities.php" class="d-inline-block mb-2 text-dark text-decoration-none">Facilities</a> <br>
            <a href="contact.php" class="d-inline-block mb-2 text-dark text-decoration-none">Contact us</a> <br>
            <a href="about.php" class="d-inline-block mb-2 text-dark text-decoration-none">About</a>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow us</h5>
            <?php
            if ($contact_r['tiktok'] != '') {
                echo <<< data
                    <a href="$contact_r[tiktok]" class="d-inline-block text-dark text-decoration-none mb-2">
                        <i class="bi bi-tiktok me-1"></i>Tiktok
                    </a>
                    <br>
                data;
            }
            ?>

            <a href="<?php echo $contact_r['facebook'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-facebook me-1"></i>Facebook
            </a>
            <br>
            <a href="<?php echo $contact_r['instagram'] ?>" class="d-inline-block text-dark text-decoration-none">
                <i class="bi bi-instagram me-1"></i>Instagram
            </a>
        </div>
    </div>
</div>
<h6 class="text-center bg-dark text-white p-3 m-0">Designed and Developed by ND an TN</h6>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
        <div class="alert ${bs_class}  alert-dismissible fade show " role="alert">
                    <strong class = "me-3">${msg}</strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;

        if (position == 'body') {
            document.body.append(element);
            element.classList.add('custom-alert');
        } else {
            document.getElementById(position).appendChild(element);
        }
        document.body.append(element);
        setTimeout(remAlert, 2000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }

    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let a_tags = navbar.getElementsByTagName('a');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];

            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }
    }

    // register
    let register_form = document.getElementById('register-form');
    register_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phonenum', register_form.elements['phonenum'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('cpass', register_form.elements['cpass'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('register', 'true');

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.responseText == 'pass_mismatch') {
                alert('error', 'Password Mismatch!');
            } else if (this.responseText == 'email_already') {
                alert('error', 'Email is already registered!');
            } else if (this.responseText == 'phone_already') {
                alert('error', 'Phone number is already registered!');
            } else if (this.responseText == 'inv_img') {
                alert('error', 'Only JPG, WEBP & PNG images are allowed!');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'Image uplaod failed!');
            } else if (this.responseText == 'mail_failed') {
                alert('error', 'Could not send confirmation email! Server Down!');
            } else if (this.responseText == 'ins_failed') {
                alert('error', 'Registetration failed!');
            } else {
                alert('success', 'Registetration successful. confirmation link sent to email.');
                register_form.reset();
            }
        }
        xhr.send(data);
    })


    // login
    document.addEventListener('DOMContentLoaded', () => {
        let login_form = document.getElementById('login-form');

        // Kiểm tra xem login_form có tồn tại không
        if (!login_form) {
            console.error('Login form not found!');
            return;
        }

        login_form.addEventListener('submit', (e) => {
            e.preventDefault();

            let data = new FormData();

            // Kiểm tra phần tử email_mob và pass trước khi truy cập value
            if (!login_form.elements['email_mob'] || !login_form.elements['pass']) {
                alert('error', 'Form elements not found!');
                return;
            }

            data.append('email_mob', login_form.elements['email_mob'].value);
            data.append('pass', login_form.elements['pass'].value);
            data.append('login', 'true');

            var myModal = document.getElementById('loginModal');
            var modal = bootstrap.Modal.getInstance(myModal);
            modal.hide();

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/login_register.php", true);

            xhr.onload = function() {
                try {
                    let response = JSON.parse(this.responseText);
                    if (response.success) {
                        const currentPath = window.location.pathname;
                        if (currentPath.includes('room_details.php')) {
                            // Tải lại trang hiện tại, giữ nguyên query string
                            window.location.reload();
                        } else {
                            // Chuyển hướng về trang chính (index.php)
                            window.location.href = 'index.php';
                        }

                    } else {
                        if (this.responseText == 'inv_email_mob') {
                            alert('error', 'Invalid Email or Mobile Number!');
                        } else if (this.responseText == 'not_verified') {
                            alert('error', 'Email is not verified');
                        } else if (this.responseText == 'inactive') {
                            alert('error', 'Account Suspended! Please contact Admin');
                        } else if (this.responseText == 'invalid_pass') {
                            alert('error', 'Incorrect password!');
                        } else {
                            alert('error', 'Login failed! Please try again.');
                        }
                    }
                } catch (e) {
                    alert('error', 'Invalid response from server!');
                    console.error('Parse error:', this.responseText);
                }
            };
            xhr.onerror = function() {
                alert('error', 'An error occurred while processing your request.');
            };
            xhr.send(data);
        });
    });

    // forgot
    let forgot_form = document.getElementById('forgot-form');
    forgot_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        // Kiểm tra phần tử email_mob và pass trước khi truy cập value
        // if (!login_form.elements['email_mob'] || !login_form.elements['pass']) {
        //     alert('error', 'Form elements not found!');
        //     return;
        // }

        data.append('email', forgot_form.elements['email'].value);
        data.append('forgot_pass', 'true');

        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);


        xhr.onload = function() {
            try {
                let response = JSON.parse(this.responseText);
                if (this.responseText == 1) {
                    alert('success', 'Reset link sent to email');
                    forgot_form.reset();
                } else {
                    if (this.responseText == 'inv_email') {
                        alert('error', 'Invalid Email!');
                    } else if (this.responseText == 'not_verified') {
                        alert('error', 'Email is not verified');
                    } else if (this.responseText == 'inactive') {
                        alert('error', 'Account Suspended! Please contact Admin');
                    } else if (this.responseText == 'mail_failed') {
                        alert('error', 'Account recovery failed. Server Down!');
                    } else {
                        alert('error', 'Something wrong!');
                    }
                }
            } catch (e) {
                alert('error', 'Invalid response from server!');
                console.error('Parse error:', this.responseText);
            }
        };

        xhr.onerror = function() {
            alert('error', 'An error occurred while processing your request.');
        };
        xhr.send(data);
    });

    function checkLoginToBook(status, room_id) {
        if (status) {
            window.location.href = 'confirm_booking.php?id=' + room_id;
        } else {
            alert('error', 'Please login to book room!');
        }
    }

    setActive();
</script>