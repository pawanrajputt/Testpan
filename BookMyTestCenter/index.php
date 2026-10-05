<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {

    $api_base_url = 'http://localhost/TestpanExamCenter/';
    $admin_base_url = 'http://localhost/TestpanAdminPanel/';
} else {

    $api_base_url = 'https://center.bookmytestcenter.com/';
    $admin_base_url = 'https://bookmytestcenter.com/sandbox/';
}

$api_url = $api_base_url . 'api/v1/get-setting-list';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

curl_close($ch);

$result = json_decode($response);

$company_logos = $result->company_logos ?? [];

$settings = $result->data ?? [];

$site_title = 'BookMyTestCenter'; // Default title
$site_description = 'The First & Only one-stop digital solution for Exam center Booking.'; // Default description

foreach ($settings as $setting) {

    if (
        isset($setting->setting_key) &&
        $setting->setting_key === 'site_title'
    ) {
        $site_title = $setting->setting_value ?? 'BookMyTestCenter';
    }

    if (
        isset($setting->setting_key) &&
        $setting->setting_key === 'site_description'
    ) {
        $site_description = $setting->setting_value ?? 'The First & Only one-stop digital solution for Exam center Booking.';
    }
}

$header_logo = './assete/header-logo.png';
$footer_logo = './assete/footer-logo.png';

foreach ($settings as $setting) {

    if ($setting->setting_key === 'header_logo') {
        $header_logo = $setting->setting_value ?? $header_logo;
        break;
    }

    if ($setting->setting_key === 'footer_logo') {
        $footer_logo = $setting->setting_value ?? $footer_logo;
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($site_title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css?v=<?php echo filemtime('./css/style.css'); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Inside <head> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
    <!-- moving-circle start -->
    <div class="cursor-circle"></div>
    <!-- moving-circle end -->


    <!-- Header section start -->
    <header class="header py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <img src="<?= htmlspecialchars($header_logo) ?>" alt="BMTC Logo" class="logo me-4" style="width: 100px; height: auto;" />
            </div>
            <div class="d-flex align-items-center">
                <nav class="d-none d-md-flex align-items-center">
                    <a href="#heroSection" class="nav-link active-link">About BMTC</a>
                    <a href="#bookingSection" class="nav-link">Booking Features</a>
                    <a href="#benefitSection" class="nav-link">Benefits</a>
                    <a href="#clientSection" class="nav-link">Our Clients</a>
                    <a href="#testpanSection" class="nav-link">About Testpan</a>

                    <!-- Dropdown for Get In Touch -->
                    <div class="dropdown hover-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="getInTouchDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Get In Touch
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="getInTouchDropdown">
                            <li><a class="dropdown-item" href="#contactSection">Contact Us</a></li>
                            <li><a class="dropdown-item" href="#FAQsection">FAQs</a></li>
                        </ul>
                    </div>
                    <a href="#Subscription" class="nav-link">Subscription</a>

                </nav>
            </div>
            <div class="d-flex align-items-center">
                <!-- Login Dropdown -->
                <div class="dropdown me-2">
                    <button class="btn btn-outline-login dropdown-toggle" data-bs-toggle="dropdown">
                        Login <i class="bi bi-arrow-right"></i>
                    </button>

                    <ul class="dropdown-menu modern-dropdown">
                        <li>
                            <a class="dropdown-item" target="_blank" href="https://center.bookmytestcenter.com/">
                                <i class="bi bi-person"></i> Login As Center
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" target="_blank" href="https://clients.bookmytestcenter.com/">
                                <i class="bi bi-person"></i> Login As Client
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" target="_blank" href="https://manpowerx.co.in/login">
                                <i class="bi bi-person"></i> Login As Manpower
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Signup Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-signup dropdown-toggle" data-bs-toggle="dropdown">
                        Sign up <i class="bi bi-arrow-right"></i>
                    </button>

                    <ul class="dropdown-menu modern-dropdown">
                        <li>
                            <a class="dropdown-item" target="_blank" href="https://center.bookmytestcenter.com/">
                                <i class="bi bi-person-plus"></i> Register As Center
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" target="_blank" href="https://clients.bookmytestcenter.com/">
                                <i class="bi bi-person-plus"></i> Register As Client
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" target="_blank" href="https://manpowerx.co.in/signup">
                                <i class="bi bi-person-plus"></i> Register As Manpower
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- Header section start -->


    <!-- Main section start -->
    <main>
        <!-- Hero section start-->
        <section class="hero-section">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6 hero-content">
                        <div>
                            <h1>India's First One-Stop Digital Solution</h1>
                            <p>for Examination Center Bookings and <br> Infrastructure Support Services</p>
                            <div class="store-buttons mt-4">
                                <a href="https://cal.com/testpan/30min?month=2025-08&layout=mobile&date=2025-08-27"
                                    class="btn book-demo">Book live demo</a>
                                <a href="#contactSection" class="btn contact-us">Contact us</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 hero-img-wrapper">
                        <img src="./assete/mobile-app.png" alt="App on phone" class="hero-phone">
                    </div>
                </div>
            </div>
        </section>

        <!-- Hero section end-->

        <!-- About section start -->
        <section class="about-section" id="heroSection">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Image -->
                    <div class="col-md-6 text-center mb-4 mb-md-0">
                        <img src="./assete/about-img.png" alt="BMTC About Image" class="img-fluid about-img">
                    </div>

                    <!-- Right Content -->
                    <div class="col-md-6">
                        <p class="about-label  horizental-line mb-2">ABOUT BMTC</p>
                        <h2 class="about-title mb-3">App-enabled examination center booking and verification</h2>
                        <p class="about-text">
                            BookMyTestCenter (BMTC) is a product of Testpan India Pvt Ltd, a trusted global provider of
                            examination delivery and infrastructure in private and public sectors with the expertise to
                            execute customized services.
                        </p>
                        <p class="about-text">
                            The examination center booking process in India is highly unorganized, time-consuming
                            (manually driven), unverified and unaudited, without any facility of ‘real-time’
                            availability.
                            BMTC seeks to address these challenges and streamline the process of finding, connecting,
                            and booking test centers for assessment companies and examination centers through an
                            automated booking system.
                        </p>
                        <button class="btn know-more-btn mt-3">Know More <span>&rarr;</span></button>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section end-->

        <!-- Stats section start -->
        <section class="stats-section py-4 position-relative">
            <div class="container">
                <div class="row text-center justify-content-center bg-white shadow-sm rounded-4 py-4 stats-box">
                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                        <h3 class="stat-number">63</h3>
                        <p class="stat-label">Assessment Organization</p>
                    </div>
                    <div class="col-12 col-md-4 mb-3 mb-md-0 border-md-start border-md-end">
                        <h3 class="stat-number">3,645</h3>
                        <p class="stat-label">Examination Centers</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <h3 class="stat-number">18L</h3>
                        <p class="stat-label">Assessment Candidates</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Stats section end -->

        <!-- client-section start -->
        <section class="client-section" id="clientSection">
            <div class="container">
                <p class="about-label mb-2 horizental-line">PARTNERS</p>
                <h4>Our Esteemed Partner Brands</h4>
                <div class="logo-carousel">
                    <div class="logo-track">
                        <!-- Repeat the logos twice for infinite loop effect -->
                        <img src="./assete/clients/company-1.png" alt="Amazon">
                        <img src="./assete/clients/company-2.png" alt="Hero">
                        <img src="./assete/clients/company-3.png" alt="TCS iON">
                        <img src="./assete/clients/company-4.png" alt="Embibe">
                        <img src="./assete/clients/company-4.png" alt="HCL">
                        <img src="./assete/clients/company-5.png" alt="Aspiring Minds">
                        <img src="./assete/clients/company-6.png" alt="Wisebox">
                        <img src="./assete/clients/company-7.png" alt="Edutest">
                        <img src="./assete/clients/company-8.png" alt="Armezo">

                        <!-- Repeat for smooth loop -->
                        <img src="./assete/clients/company-9.png" alt="Amazon">
                        <img src="./assete/clients/company-10.png" alt="Hero">
                        <img src="./assete/clients/company-11.png" alt="TCS iON">
                        <img src="./assete/clients/company-12.png" alt="Embibe">
                        <img src="./assete/clients/company-13.png" alt="HCL">
                        <img src="./assete/clients/company-14.png" alt="Aspiring Minds">
                        <img src="./assete/clients/company-15.png" alt="Wisebox">
                        <img src="./assete/clients/company-16.png" alt="Edutest">
                        <img src="./assete/clients/company-17.png" alt="Armezo">
                    </div>
                </div>
            </div>
        </section>
        <!-- client-section end -->

        <!-- Booking section start -->
        <section class="booking-section" id="bookingSection">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <div class="subtitle horizental-line">Web Booking Features</div>
                        <h2 class="feature-title">Book the Examination Center <br>of Your Choice</h2>
                        <ul class="feature-list">
                            <li>
                                <div class="feature-number">1</div>
                                <div class="feature-heading">Simplified Search</div>
                                <div class="feature-desc">Based on location, capacity, and specialties.</div>
                            </li>
                            <li>
                                <div class="feature-number">2</div>
                                <div class="feature-heading">Secure Communication</div>
                                <div class="feature-desc">Between assessment companies and test centers.</div>
                            </li>
                            <li>
                                <div class="feature-number">3</div>
                                <div class="feature-heading">Effortless Booking</div>
                                <div class="feature-desc">Eliminating manual processes and paperwork.</div>
                            </li>
                            <li>
                                <div class="feature-number">4</div>
                                <div class="feature-heading">Streamlined Management</div>
                                <div class="feature-desc">Of examination delivery, scheduling, communication, and
                                    reporting.</div>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-6 text-center mt-4 mt-lg-0">
                        <img src="./assete/dashord-new.jpeg" alt="Laptop Person" class="laptop-img" />
                    </div>
                </div>
            </div>
        </section>
        <!-- Booking section end -->


        <!-- App-feature-section -->
        <section class="feature-section">
            <h5 class="horizental-line text-white">APP BOOKING FEATURES</h5>
            <h2>Connecting All Your Daily Payment<br />Needs Easily With Bestkit</h2>
            <div class="container">
                <div class="row app-features-row">

                    <!-- Left Feature Cards -->
                    <div class="col-md-4 feature-col">
                        <div class="feature-box">
                            <h6><img src="https://img.icons8.com/color/30/settings--v1.png" /> Manage Examination
                                Centers</h6>
                            <p>Add/remove/edit details about a particular examination center</p>
                        </div>
                        <div class="feature-box">
                            <h6><img src="https://img.icons8.com/color/30/calendar--v1.png" /> Calendar Access</h6>
                            <p>To see if a center is available or booked for a particular date or time band</p>
                        </div>
                    </div>

                    <!-- Center Phone Image -->
                    <div class="col-md-4 d-flex justify-content-center align-items-center feature-col">
                        <img src="./assete/app-booking-img.png" alt="Phone" class="phone-img">
                    </div>

                    <!-- Right Feature Cards -->
                    <div class="col-md-4 feature-col">
                        <div class="feature-box">
                            <h6><img src="https://img.icons8.com/color/30/alarm.png" /> Real Time Notifications</h6>
                            <p>Real-time availability and confirmation of the examination center</p>
                        </div>
                        <div class="feature-box">
                            <h6><img src="https://img.icons8.com/color/30/news.png" /> Live News Feed</h6>
                            <p>Examination Centers can track the latest on the assessment industry, e.g., rules,
                                industry trends etc.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- App-feature-section -->



        <!-- All-banifits-section -->
        <section class="benefits-section" id="benefitSection">
            <div class="container">
                <div class="benefits-title">
                    <h6 class="horizental-line">All Benefits</h6>
                    <h2>Book with BMTC for Multiple Benefits</h2>
                </div>

                <!-- First Row -->
                <div class="benefit-row">
                    <div class="img-container">
                        <img src="./assete/all-benifit-1.png" alt="Exam Center">
                    </div>
                    <div class="benefit-box">
                        <h5>Benefits for Examination Centers</h5>
                        <div class="row mt-3">
                            <div class="col-sm-6 mb-2">
                                <div class="number">1</div>
                                <p>A wide repository of assessment companies seeking examination centers</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">2</div>
                                <p>Opportunity to expand the customer base through new clients</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">3</div>
                                <p>Efficient communication and management of bookings</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">4</div>
                                <p>Real-time calendar to view upcoming examination schedules</p>
                            </div>
                            <div class="col-sm-12">
                                <div class="number">5</div>
                                <p>State-wide verified list of vendors providing examination-related auxiliary services
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="benefit-row">
                    <div class="benefit-box">
                        <h5>Benefits for Assessment Companies</h5>
                        <div class="row mt-3">
                            <div class="col-sm-6 mb-2">
                                <div class="number">1</div>
                                <p>A global network of verified and audited institutions</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">2</div>
                                <p>App-enabled examination center booking and verification</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">3</div>
                                <p>One-stop digital solution with smart algorithms</p>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div class="number">4</div>
                                <p>Real-time availability of examination centers for booking</p>
                            </div>
                            <div class="col-sm-12">
                                <div class="number">5</div>
                                <p>Extensive coverage across India</p>
                            </div>
                        </div>
                    </div>
                    <div class="img-container">
                        <img src="./assete/all-benifit-2.png" alt="Assessment Company">
                    </div>
                </div>
            </div>
        </section>
        <!-- All-banifits-section -->

        <!-- video-section start -->
        <section class="video-section">
            <div class="video-wrapper">
                <!-- Replace src with your actual video file path or URL -->
                <video controls poster="./assete/video-img.png" width="100%">
                    <source src="./assete/video/WhatsApp Video 2025-05-22 at 3.10.23 PM.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </section>
        <!-- video-section end -->

        <!-- about-testpan-section -->
        <div class="about-testpan-section" id="testpanSection">
            <div class="container">
                <div class="testpan-heading">
                    <h6 class="horizental-line">ABOUT TESTPAN US</h6>
                    <h2>About Testpan India</h2>
                </div>

                <div class="row g-4 align-items-start">
                    <!-- Left Side -->
                    <div class="col-md-6">
                        <div class="equal-box mb-3">
                            <img src="./assete/testpan-img.png" alt="Testpan Logo">
                        </div>
                        <p class="about-text">
                            TESTPAN India is a trusted examination delivery and infrastructure provider in the public
                            and private sectors. On their behalf, we securely deliver a reliable, convenient and
                            hassle-free examination experience to those seeking to improve their lives by starting a new
                            career or developing skills/qualifications for professional development.
                        </p>
                        <div class="certifications">
                            <img src="./assete/testpan-catogary1.png" alt="Startup India" height="40">
                            <img src="./assete/testpan-catogary2.png" alt="ISO 9001" height="40">
                            <img src="./assete/testpan-catogary3.png" alt="ISO 27001" height="40">
                            <img src="./assete/testpan-catogary4.png" alt="ISO 20000" height="40">
                            <img src="./assete/testpan-catogary5.png" alt="Informatics NIC" height="40">
                            <img src="./assete/testpan-catogary6.png" alt="Informatics NIC" height="40">
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="col-md-6">
                        <h5><strong>Founded in early 2016</strong></h5>
                        <p>
                            And recognized as a Startup Company by the Department for Promotion for Industry & Internal
                            Trade (DPIIT), TESTPAN India has been a pioneer in providing examination delivery, process
                            and assessment solutions, and infrastructural support to Educational Institutions,
                            Government/Public Sector and Corporates.
                        </p>
                        <div class="equal-box mt-4">
                            <img src="./assete/testpan-img-2.png" alt="Testpan Student">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- about-testpan-section -->

        <!-- Count-section start -->
        <?php

        if (empty($_COOKIE['bmtc_visitor_id'])) {

            $visitor_id = bin2hex(random_bytes(32));

            setcookie(
                'bmtc_visitor_id',
                $visitor_id,
                time() + (10 * 365 * 24 * 60 * 60), // 10 years
                '/',
                '',
                isset($_SERVER['HTTPS']),
                true
            );
        } else {

            $visitor_id = $_COOKIE['bmtc_visitor_id'];
        }

        $increase_api = $api_base_url . 'api/v1/increase-visitor-count';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $increase_api);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'visitor_id' => $visitor_id
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);

        curl_close($ch);


        // Fetch Visitor Count
        $count_api = $api_base_url . 'api/v1/get-visitor-count';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $count_api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($response);

        $total_visitors = $result->total_visitors ?? 0;

        ?>
        <section class="count-section py-4">
            <div class="container">
                <div class="row text-center text-white">
                    <div class="col-6 col-md border-end">
                        <h3 class="fw-bold">17</h3>
                        <p class="mb-0">Countries</p>
                    </div>
                    <div class="col-6 col-md border-end">
                        <h3 class="fw-bold">2407</h3>
                        <p class="mb-0">Examination Delivery Manpower</p>
                    </div>
                    <div class="col-6 col-md border-end mt-4 mt-md-0">
                        <h3 class="fw-bold">524</h3>
                        <p class="mb-0">Cities</p>
                    </div>
                    <div class="col-6 col-md border-end mt-4 mt-md-0">
                        <h3 class="fw-bold">11</h3>
                        <p class="mb-0">Examination Delivery Partners</p>
                    </div>
                    <div class="col-12 col-md mt-4 mt-md-0">
                        <h3 class="fw-bold">605</h3>
                        <p class="mb-0">Projects</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Count-section-end -->

        <!-- Contact-us-section -->
        <section class="contact-section" id="contactSection">
            <div class="container">
                <div class="contact-heading">
                    <h6 class="horizental-line">Connect With Us</h6>
                    <h2>Contact Us</h2>
                    <?php
                    // session_start();
                    ?>
                    <?php if (isset($_SESSION['flash'])): ?>
                        <div
                            class="alert alert-<?php echo ($_SESSION['flash']['type'] == 'success') ? 'success' : 'danger'; ?>">
                            <?php echo $_SESSION['flash']['msg']; ?>
                        </div>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>
                </div>
                <div class="row align-items-center g-4">
                    <!-- Left: Form -->
                    <div class="col-lg-7">
                        <div class="form-box">
                            <form method="POST" action="sendmail.php">
                                <div class="mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="mb-3">
                                    <input type="tel" name="phone" class="form-control" placeholder="Phone" required>
                                </div>

                                <div class="checkbox-grid">
                                    <div>
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="category[]" value="Examination Center">
                                            Examination Center
                                        </label><br>
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="category[]" value="Assessment Company">
                                            Assessment Company
                                        </label><br>
                                    </div>
                                    <div>
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="category[]" value="Center Vendor"> Center
                                            Vendor
                                        </label><br>
                                        <label class="checkbox-option">
                                            <input type="checkbox" name="category[]" value="Manpower Vendor"> Manpower
                                            Vendor
                                        </label>
                                    </div>
                                </div>

                                <div class="submit-btn-box mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right: Image -->
                    <div class="col-lg-5 text-center">
                        <img src="./assete/contact-us.png" alt="Contact Girl" class="contact-img">
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact-us-sectin -->


        <!-- Subscription-section -->
        <?php

        $api_url = $api_base_url . 'api/v1/fetch-subscription-packages';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($response);

        $packages = $result->data ?? [];

        ?>
        <?php
        if (count($packages) > 0) { ?>
            <section class="pricing-section" id="Subscription">
                <div class="container">

                    <div class="section-title">
                        <h2>Choose Your Subscription Plan</h2>
                        <p class="text-white">Flexible plans for your portal</p>
                    </div>

                    <div class="row g-4">

                        <?php foreach ($packages as $package): ?>

                            <?php

                            $gst_amount = ($package->price * $package->gst_percent) / 100;

                            $total_amount = $package->price + $gst_amount;

                            $keyPoints = trim($package->key_points);

                            $features = json_decode($keyPoints, true);

                            // Backward compatibility for old newline-separated data
                            if (!is_array($features)) {
                                $features = preg_split('/\r\n|\r|\n/', $keyPoints);
                            }

                            ?>

                            <div class="col-md-4">

                                <div class="card-custom <?= $package->is_recommended == 1 ? 'gold' : '' ?>">

                                    <?php if ($package->is_recommended == 1): ?>

                                        <div class="ribbon" style=" background: <?= $package->package_color ?>;color:#fff;">

                                            <?= !empty($package->tag_line)
                                                ? $package->tag_line
                                                : 'Most Popular'
                                            ?>

                                        </div>

                                    <?php endif; ?>

                                    <h4>
                                        <?= $package->name ?>
                                    </h4>

                                    <div class="price">
                                        ₹
                                        <?= number_format($package->price) ?>
                                        <small style="font-size: 16px;">
                                            /
                                            <?= $package->duration ?>
                                            <?= ucfirst($package->duration_type) ?>
                                        </small>
                                    </div>

                                    <p>
                                        <?= $package->gst_percent ?>% GST included
                                    </p>

                                    <!-- Package Meta -->

                                    <div class="package-meta">

                                        <!-- Centers -->

                                        <div class="meta-item">

                                            <div class="meta-icon">
                                                <i class="fa fa-building"></i>
                                            </div>

                                            <div>

                                                <div class="meta-title">
                                                    Centers
                                                </div>

                                                <div class="meta-value">

                                                    <?= $package->max_centers == -1
                                                        ? 'Unlimited'
                                                        : $package->max_centers
                                                    ?>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- Bookings -->

                                        <div class="meta-item">

                                            <div class="meta-icon">
                                                <i class="fa fa-calendar-check-o"></i>
                                            </div>

                                            <div>

                                                <div class="meta-title">
                                                    Bookings
                                                </div>

                                                <div class="meta-value">

                                                    <?= $package->max_bookings == -1
                                                        ? 'Unlimited'
                                                        : number_format($package->max_bookings)
                                                    ?>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- Support -->

                                        <div class="meta-item">

                                            <div class="meta-icon">
                                                <i class="fa fa-headphones"></i>
                                            </div>

                                            <div>

                                                <div class="meta-title">
                                                    Support
                                                </div>

                                                <div class="meta-value">

                                                    <?= ucfirst($package->support_type) ?>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- Badge -->

                                        <div class="meta-item">

                                            <div class="meta-icon">
                                                <i class="fa fa-check-circle"></i>
                                            </div>

                                            <div>

                                                <div class="meta-title">
                                                    Verified Badge
                                                </div>

                                                <div class="meta-value">

                                                    <?= $package->verified_badge == 1
                                                        ? 'Included'
                                                        : 'Not Included'
                                                    ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <ul class="features">

                                        <?php foreach ($features as $feature): ?>

                                            <?php if (!empty(trim($feature))): ?>

                                                <li>
                                                    <i class="fa fa-check"></i>
                                                    <?= htmlspecialchars(trim($feature)) ?>
                                                </li>

                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                    </ul>

                                    <button class="btn btn-custom w-100"
                                        style="background: <?= $package->package_color ?>; color:#fff;" data-bs-toggle="modal"
                                        data-bs-target="#planModal"
                                        onclick="selectPlan('<?= $package->id ?>','<?= $package->name ?>')">
                                        Choose Plan
                                    </button>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </section>
        <?php } ?>
        <!-- Subscription-section -->

        <!-- FAQ section start -->
        <section class="faq-section bg-light" id="FAQsection">
            <div class="container">
                <div class="row">
                    <!-- Left Section -->
                    <div class="col-lg-4 faq-left">
                        <h6 class="horizental-line">FAQ</h6>
                        <h2>Frequently Asked Questions</h2>
                        <p>Here are some of the common questions we get asked. If you don't see your question here, feel
                            free to contact us.</p>
                        <a href="#contactSection" class="btn btn-success">Contact Us</a>
                    </div>

                    <!-- Right Section (Accordion) -->
                    <div class="col-lg-8">
                        <div class="accordion" id="faqAccordion">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqOne" aria-expanded="true">
                                        How does a test center recieve bookings
                                    </button>
                                </h2>
                                <div id="faqOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Our clients send test requirements to us, and on the basis of the general and
                                        technical requirements of the exam, we route those requests to you (only if they
                                        match). You confirm the availability of the center and the requirements, and we
                                        book you.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqTwo">
                                        How much time does it take to get started with web portal
                                    </button>
                                </h2>
                                <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Getting started usually takes 1–3 working days after documentation is completed.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqThree">
                                        Who do i get in touch with if i get stuck or if there is an issue
                                    </button>
                                </h2>
                                <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You will be assigned a support manager who you can contact via phone or email.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqFour">
                                        I am a company, how do I actually send you test requirements
                                    </button>
                                </h2>
                                <div id="faqFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can send your test requirements through our company portal or by directly
                                        contacting our sales/support team.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faqFive">
                                        Is there a common portal for Assessment Company and Test Center
                                    </button>
                                </h2>
                                <div id="faqFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, we offer a unified platform that connects both assessment companies and
                                        test centers.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ section end -->

    </main>
    <!-- Main section start -->

    <!-- Plan Modal -->
    <div class="modal fade" id="planModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Continue With Subscription
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body text-center">

                    <h4 id="selectedPlanName"></h4>

                    <p class="mt-3">
                        If you already have an account,
                        please login to continue your purchase.
                    </p>

                    <p>
                        If you are new,
                        please register first.
                    </p>

                </div>

                <div class="modal-footer justify-content-center">

                    <a id="loginBtn" href="#" target="_blank" class="btn btn-dark">
                        Login
                    </a>

                    <a id="registerBtn" href="#" target="_blank" class="btn btn-primary">
                        Register
                    </a>

                </div>

            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container">
            <div class="row gy-4">

                <!-- Logo & Text -->
                <div class="col-md-3">
                    <div class="logo-footer">
                        <img src="<?= htmlspecialchars($footer_logo) ?>" class="logo" alt="Logo" style="width: 100px;">
                    </div>

                    <div class="logo-text">
                        <?= htmlspecialchars($site_description) ?>
                    </div>
                    <div class="company-logo-wrapper">

                        <?php foreach ($company_logos as $logo): ?>

                            <div class="company-logo-box">
                                <img
                                    src="<?= htmlspecialchars($logo->logo) ?>"
                                    alt="<?= htmlspecialchars($logo->company_name) ?>"
                                    class="company-logo">
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="#heroSection">About BMTC</a></li>
                        <li><a href="#bookingSection">Booking Features</a></li>
                        <li><a href="#benefitSection">Benefits</a></li>
                        <li><a href="#clientSection">Our Clients</a></li>
                        <li><a href="#testpanSection">About Testpan</a></li>
                        <li><a href="#contactSection">Contact Us</a></li>
                        <li><a href="#FAQsection">FAQ’s</a></li>
                    </ul>
                </div>

                <!-- Contact Details -->
                <div class="col-md-3">
                    <h6>Contact Details</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope"></i> info@testpanindia.com</li>
                        <li><i class="fas fa-envelope"></i> info@bookmytestcenter.com</li>
                        <li><i class="fas fa-phone"></i> +91 9801 47334</li>
                        <li><i class="fas fa-phone"></i> +91 99588 08021</li>
                        <li><i class="fas fa-phone"></i> +91 11 2852 0481</li>
                        <li><i class="fas fa-phone"></i> +91 11 4246 8200</li>
                    </ul>
                </div>

                <!-- Corporate Office -->
                <div class="col-md-3">
                    <h6>Corporate Office</h6>
                    <p><i class="fas fa-map-marker-alt"></i> 1390/7, 2nd Floor, (Above MTNL Exchange),<br>
                        Pankha Road, Nangal Raya,<br>
                        New Delhi - 110046, India
                    </p>
                    <div class="app-download d-flex justify-content-start align-items-center">
                        <a href="https://play.google.com/store/apps/details?id=com.testpan.bmtcapp" target="_blank" class="">
                            <img src="./image/playStore.png" alt="play store" width="150">
                        </a>
                        <a href="https://apps.apple.com/in/app/bookmytestcenter/id6764005554" target="_blank" class="">
                            <img src="./image/appStore.png" alt="app store" width="150">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Social Icons -->
            <div class="row mt-4">

            </div>


            <!-- Footer Bottom -->
            <div class="footer-bottom mt-3 d-flex justify-content-between align-items-center">
            
                <div class="text-left social-icons d-flex">
                    <a href="https://www.youtube.com/@testpanindiaprivatelimited5851">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://x.com/testpanindia">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/testpan">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/bookmytestcenter/">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/showcase/testpan-india-pvt-ltd/posts/?feedView=all">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            
                <div>
                    <h3 class="fw-bold"><?= number_format($total_visitors) ?>+</h3>
                    <p class="mb-0">Trusted Visitors</p>
                </div>
            
                <div class="text-center">
                    <div class="mb-1">
                        <a target="_blank" href="<?=$admin_base_url?>cms/privacy-policy"
                           class="text-decoration-none me-3">
                            Privacy Policy
                        </a>
            
                        <a target="_blank" href="<?=$admin_base_url?>cms/terms-condition"
                           class="text-decoration-none">
                            Terms & Conditions
                        </a>
                    </div>
            
                    <div>
                        &copy; <?= date('Y') ?> BMTC, All rights reserved
                    </div>
                </div>
            
            </div>
        </div>
        <script id="messenger-widget-b" src="https://cdn.botpenguin.com/website-bot.js" defer>
            6741988 bffa240a9e3d9f835, 673 db69f03a6cc3f9ae6f879
        </script>
    </footer>
    <!-- Footer End -->
    
    <!-- 1. The Launcher Button -->
    <button id="testpan-launcher-btn" aria-label="Open Chat">
        <img src="https://manpowerx.co.in/assets/images/assistance.png" height="60" width="60" class="rounded-circle">
    </button>
    
    <!-- 2. The Modal Overlay -->
    <div id="testpan-chat-overlay"></div>
    
    <!-- 3. The Iframe Container -->
    <div id="testpan-chat-iframe-container">
        <iframe
            id="testpan-chat-iframe"
            src="https://chatbot.bookmytestcenter.com/widget.html?site=bmtc"
            title="ManpowerX Support Chat">
        </iframe>
    </div>

    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectPlan(packageId, packageName) {
            document.getElementById('selectedPlanName').innerText = packageName;

            let baseUrl = "<?= $api_base_url ?>";

            document.getElementById('loginBtn').href =
                baseUrl + "";

            document.getElementById('registerBtn').href =
                baseUrl + "";
        }
    </script>
    
    <!-- 4. The Control Script -->
    <script>
        (function() {
            const launcherBtn = document.getElementById('testpan-launcher-btn');
            const overlay = document.getElementById('testpan-chat-overlay');
            const iframeContainer = document.getElementById('testpan-chat-iframe-container');
            const iframe = document.getElementById('testpan-chat-iframe');
    
            function openChat() {
                overlay.style.display = 'block';
                iframeContainer.style.display = 'block';
                launcherBtn.style.display = 'none';
                document.body.style.overflow = 'hidden'; // Prevent background scroll
            }
    
            function closeChat() {
                overlay.style.display = 'none';
                iframeContainer.style.display = 'none';
                launcherBtn.style.display = 'flex';
                document.body.style.overflow = ''; // Restore background scroll
            }
    
            launcherBtn.addEventListener('click', openChat);
            overlay.addEventListener('click', closeChat);
    
            window.addEventListener('message', function(event) {
                // Security: Ensure the message is from the chatbot's origin
                if (event.origin !== new URL(iframe.src).origin) return;
                
                if (event.data === 'testpan-chat-close') {
                    closeChat();
                }
            });
        })();
    </script>
</body>

</html>