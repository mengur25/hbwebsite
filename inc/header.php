<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'inc/links.php' ?>
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="./css/darkmode.css">
    <title><?php echo $settings_r['site_title'] ?></title>
</head>

<body>
    <nav id="nav-bar" class="navbar navbar-expand-lg bg-body-tertiary bg-white px-lg-3 py-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <button type="button" id="themeToggleBtn" class="btn btn-outline-dark shadow-none me-lg-3 me-2">
                        <i class="bi bi-moon-fill"></i> <span id="themeText">Dark Mode</span>
                    </button>
                    <?php
                    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                        $path = USERS_IMG_PATH;
                        echo <<<data
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <img src="$path{$_SESSION['uPic']}" style="width: 25px; height: 25px;" class="me-1 rounded-circle">    
                                    {$_SESSION['uName']}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        data;
                    } else {
                        echo <<<data
                            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                            <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register
                            </button>
                        data;
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="login-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i> User Login
                        </h1>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email / Mobile</label>
                            <input type="text" name="email_mob" class="form-control shadow-none">
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control shadow-none">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <button type="submit" class="btn btn-dark shadow-none">LOGIN</button>
                            <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">
                                Forgot Password?
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="register-form" method="POST" action="login_register.php">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center">
                            <i class="bi bi-person-lines-fill fs-3 me-2"></i> User Registration
                        </h1>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill text-bg-light mb-3 text-wrap lh-base">
                            Note: Your details must match with your ID (identity card, passport, driving license, etc.)
                            that will be required during check-in.
                        </span>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control shadow-none" placeholder="Your name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                                    <input name="email" type="email" class="form-control shadow-none" placeholder="name@example.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                                    <input name="phonenum" type="number" class="form-control shadow-none" placeholder="Phone number" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Picture</label>
                                    <input name="profile" type="file" accept=".png, .jpg, .jpeg, .webp" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Address</label>
                                    <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Pincode</label>
                                    <input name="pincode" type="number" class="form-control shadow-none" placeholder="Pincode" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Date of birth</label>
                                    <input name="dob" type="date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Password</label>
                                    <input name="pass" type="password" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Confirm Password</label>
                                    <input name="cpass" type="password" class="form-control shadow-none" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-1">
                            <button type="submit" name="register" class="btn btn-dark shadow-none">REGISTER</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="forgot-form">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 d-flex align-items-center">
                            <i class="bi bi-person-circle fs-3 me-2"></i> Forgot Password
                        </h1>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="badge rounded-pill text-bg-light mb-3 text-wrap lh-base">
                            Note: A link will be sent to your email to reset your password!
                        </span>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control shadow-none">
                        </div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">
                                CANCEL
                            </button>
                            <button type="submit" class="btn btn-dark shadow-none">SEND LINK</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeText = document.getElementById('themeText');
    const body = document.body;

    // Check if elements exist
    if (!themeToggleBtn || !themeText) {
        console.error('Theme toggle button or text element not found.');
        return;
    }

    // Check for saved theme in localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        themeText.textContent = 'Light Mode';
        const icon = themeToggleBtn.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-moon-fill');
            icon.classList.add('bi-sun-fill');
        }
    } else {
        body.classList.remove('dark-mode');
        themeText.textContent = 'Dark Mode';
        const icon = themeToggleBtn.querySelector('i');
        if (icon) {
            icon.classList.remove('bi-sun-fill');
            icon.classList.add('bi-moon-fill');
        }
    }

    // Toggle theme on button click
    themeToggleBtn.addEventListener('click', () => {
        const isDarkMode = body.classList.toggle('dark-mode');
        const icon = themeToggleBtn.querySelector('i');
        if (isDarkMode) {
            localStorage.setItem('theme', 'dark');
            themeText.textContent = 'Light Mode';
            if (icon) {
                icon.classList.remove('bi-moon-fill');
                icon.classList.add('bi-sun-fill');
            }
        } else {
            localStorage.setItem('theme', 'light');
            themeText.textContent = 'Dark Mode';
            if (icon) {
                icon.classList.remove('bi-sun-fill');
                icon.classList.add('bi-moon-fill');
            }
        }
    });
});
    </script>
</body>

</html>