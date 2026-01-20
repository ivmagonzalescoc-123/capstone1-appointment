
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azucena's Dental Clinic - Modern Dental Care</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/landing-style.css" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-tooth"></i> Azucena's Dental Clinic
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="nav-buttons ms-auto">
                    <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="bi bi-person-plus"></i> Register
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <!-- Carousel Background -->
        <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/clinic.png?w=1200&h=600&fit=crop" alt="Dental Clinic" class="carousel-img">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/clinic1.png?w=1200&h=600&fit=crop" alt="Modern Clinic" class="carousel-img">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/clinic2.png?w=1200&h=600&fit=crop" alt="Professional Team" class="carousel-img">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <div class="container hero-content">
            <h1>Welcome to Azucena's Dental Clinic</h1>
            <div class="d-flex justify-content-center hero-buttons flex-wrap">
                <button class="btn btn-primary-hero" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Get Started
                </button>
                <a href="#about" class="btn btn-outline-light">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section class="about" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>About Us</h2>
                    <p>At Azucena Dental Clinic, we're committed to providing exceptional dental care to our community. With over 20 years of experience, our team of highly qualified dentists and hygienists are dedicated to helping you achieve and maintain optimal oral health.</p>
                    <p>We believe in creating a welcoming environment where every patient feels comfortable and valued. Our clinic is equipped with the latest dental technology to ensure accurate diagnoses and effective treatments.</p>
                    <p>Whether you need a routine checkup or a complex dental procedure, we're here to help you maintain a healthy, beautiful smile.</p>
                </div>
                <div class="col-lg-6">
                    <h2>Our Location</h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3926.0234567890123!2d124.64805!3d8.48722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32ffc9c9c9c9c9c9%3A0x0!2sMetz%20Arcade%2C%20Barangay%2024%2C%20Capt.%20Vicente%20Roa%20St%2C%20Cagayan%20de%20Oro%2C%209000!5e0!3m2!1sen!2sph!4v1234567890123" width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h4>Address: Metz Arcade, Barangay 24, Capt. Vicente Roa St, Cagayan de Oro, 9000</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-calendar2-check"></i>
                        </div>
                        <h4>Easy Scheduling</h4>
                        <p>Book appointments online anytime, anywhere </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h4>Secure Records</h4>
                        <p>Your medical records are protected with enterprise-grade security and privacy</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4>Expert Team</h4>
                        <p>Our experienced dentists are dedicated to your oral health</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section class="services" id="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="service-item">
                        <h5><i class="bi bi-tooth"></i> General Dentistry</h5>
                        <p>Routine checkups, cleanings, and preventive care to keep your teeth healthy</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <h5><i class="bi bi-lightning"></i> Cosmetic Dentistry</h5>
                        <p>Enhance your smile with teeth whitening, veneers, and other cosmetic procedures</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <h5><i class="bi bi-wrench"></i> Restorative Services</h5>
                        <p>Fillings, crowns, bridges, and implants to restore your natural smile</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <h5><i class="bi bi-scissors"></i> Orthodontics</h5>
                        <p>Advanced braces and aligners to straighten your teeth and improve your bite</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="contact" id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="bi bi-telephone"></i>
                    <p><strong>Phone</strong><br>0917 984 3031</p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <p><strong>Email</strong><br>azucena@gmail.com</p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <p><strong>Location</strong><br>Metz Arcade, Barangay 24, Capt. Vicente Roa St, Cagayan de Oro, 9000</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p>&copy; 2026 Azucena Dental Clinic. All rights reserved.</p>
        </div>
    </footer>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-arrow-in-right"></i> Login</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="loginAlert"></div>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="loginEmail" placeholder="your@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" placeholder="Enter password" required>
                        </div>
                        <button type="submit" class="btn btn-login w-100">Login</button>
                    </form>
                    <hr>
                    <p class="text-center">Don't have an account? <a href="#" class="form-link" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- REGISTER MODAL -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-plus"></i> Create Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="registerAlert"></div>
                    <form id="registerForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="registerFirstName" placeholder="John" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="registerMiddleName" placeholder="Optional">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="registerLastName" placeholder="Doe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" id="registerUsername" placeholder="Username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="registerEmail" placeholder="your@email.com" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="registerDOB" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-control" id="registerGender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="registerPhone" placeholder="09xxxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="registerAddress" placeholder="Your address" rows="2" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="registerPassword" placeholder="Min 6 characters" required minlength="6">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="registerPasswordConfirm" placeholder="Confirm password" required minlength="6">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-login w-100">Create Account</button>
                    </form>
                    <hr>
                    <p class="text-center">Already have an account? <a href="#" class="form-link" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Login Form Handler
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const alertDiv = document.getElementById('loginAlert');

            try {
                const response = await fetch('assets/api/auth/login_api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (data.success) {
                    alertDiv.innerHTML = '<div class="alert alert-success">Login successful! Redirecting...</div>';
                    setTimeout(() => {
                        window.location.href = data.user.role + '/index.php';
                    }, 1000);
                } else {
                    alertDiv.innerHTML = `<div class="alert alert-danger">${data.message || 'Login failed'}</div>`;
                }
            } catch (error) {
                alertDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                console.error('Error:', error);
            }
        });

        // Register Form Handler
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const firstName = document.getElementById('registerFirstName').value;
            const middleName = document.getElementById('registerMiddleName').value;
            const lastName = document.getElementById('registerLastName').value;
            const username = document.getElementById('registerUsername').value;
            const email = document.getElementById('registerEmail').value;
            const dob = document.getElementById('registerDOB').value;
            const gender = document.getElementById('registerGender').value;
            const phone = document.getElementById('registerPhone').value;
            const address = document.getElementById('registerAddress').value;
            const password = document.getElementById('registerPassword').value;
            const passwordConfirm = document.getElementById('registerPasswordConfirm').value;
            const alertDiv = document.getElementById('registerAlert');

            if (password !== passwordConfirm) {
                alertDiv.innerHTML = '<div class="alert alert-danger">Passwords do not match</div>';
                return;
            }

            try {
                const response = await fetch('assets/api/auth/register_api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        first_name: firstName,
                        middle_name: middleName,
                        last_name: lastName,
                        username: username,
                        email, 
                        date_of_birth: dob,
                        gender: gender,
                        phone_number: phone,
                        address: address,
                        password,
                        role: 'patient'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alertDiv.innerHTML = '<div class="alert alert-success">Account created successfully! Redirecting...</div>';
                    setTimeout(() => {
                        window.location.href = 'patient/index.php';
                    }, 1500);
                } else {
                    alertDiv.innerHTML = `<div class="alert alert-danger">${data.message || 'Registration failed'}</div>`;
                }
            } catch (error) {
                alertDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                console.error('Error:', error);
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>
