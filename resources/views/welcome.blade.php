<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/aos/aos.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }} " rel="stylesheet">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/custom/style.css') }}">

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container">
            <div class="header-container d-flex align-items-center justify-content-between">
                <div class="logo">
                    <h1 class="text-light"><a href="/"><span>{{ env('APP_NAME') }}</span></a></h1>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto active" href="#hero">Home&emsp;&emsp;</a></li>
                        <li><a class="nav-link scrollto" href="#about">About&emsp;&emsp;</a></li>
                        <li><a class="nav-link scrollto" href="#services">Internships&emsp;&emsp;</a></li>
                        <li><a class="nav-link scrollto" href="#contact">Contact&emsp;&emsp;</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('login') }}">Login&emsp;&emsp;</a></li>
                        <li><a class="nav-link scrollto" href="{{ route('register') }}">Register&emsp;&emsp;</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </div>
    </header>
    <!-- ======= End Header ======= -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200">
            <h1>Interners</h1>
            <h2>Online Internship Applicant System</h2>
        </div>
    </section>
    <!-- ======= End Hero Section ======= -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">
                <div class="row content">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <h2>About Us</h2>
                        <h3>This web based internship applicant tracking system is a tool to manage internship
                            applicants easly. </h3>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" data-aos-delay="200">
                        <p>
                            Online Applicant System have:
                        </p>
                        <ul>
                            <li><i class="ri-check-double-line"></i> Internship post</li>
                            <li><i class="ri-check-double-line"></i> Manage internship applicants</li>
                            <li><i class="ri-check-double-line"></i> Manage Universities, Companies, Facuility and
                                Student</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= End About Section ======= -->

        <!-- ======= Count Section ======= -->
        <section id="counts" class="counts">
            <div class="container">
                <div class="row counters">
                    <div class="col-lg-3 col-6 text-center"> <span data-purecounter-start="0"
                            data-purecounter-end="{{ $stats['applications'] }}" data-purecounter-duration="0"
                            class="purecounter">{{ $stats['applications'] }}</span>
                        <p>Applications</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center"> <span data-purecounter-start="0"
                            data-purecounter-end="{{ $stats['applicants'] }}" data-purecounter-duration="0"
                            class="purecounter">{{ $stats['applicants'] }}</span>
                        <p>Applicants</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center"> <span data-purecounter-start="0"
                            data-purecounter-end="{{ $stats['internships'] }}" data-purecounter-duration="0"
                            class="purecounter">{{ $stats['internships'] }}</span>
                        <p>Internships</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center"> <span data-purecounter-start="0"
                            data-purecounter-end="{{ $stats['departments'] }}" data-purecounter-duration="0"
                            class="purecounter">{{ $stats['departments'] }}</span>
                        <p>Departments</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= End Count Section ======= -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="section-title" data-aos="fade-right">
                            <h2>Internships</h2>
                            <p>You can explore our recent internships</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row" id="searchResultDiv">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <a class="cta-btn" href="{{ env('APP_URL') }}/user/home">Explore more</a>
                    </div>
                </div>

            </div>
        </section>
        <!-- ======= End Services Section ======= -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4" data-aos="fade-right">
                        <div class="section-title">
                            <h2>Contact</h2>
                        </div>
                    </div>

                    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.3412367809183!2d38.76032677354962!3d9.03260338893554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b858a20bd2b09%3A0x9b593f7d0a324bfb!2zTWluaXN0cnkgb2YgRWR1Y2F0aW9uIHwgNCBraWxvIHwg4Ym14Yid4YiF4Yit4Ym1IOGImuGKkuGIteGJtOGIrSB8IDQg4Yqq4YiO!5e0!3m2!1sen!2sus!4v1711232821382!5m2!1sen!2sus" 
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="info mt-4">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>Addis Abeba, Ethiopia</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-4">
                                <div class="info">
                                    <i class="bi bi-envelope"></i>
                                    <h4>Email:</h4>
                                    <p>info@moe.gov.et</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info w-100 mt-4">
                                    <i class="bi bi-phone"></i>
                                    <h4>Call:</h4>
                                    <p> +251-11-155-3133</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ======= End Contact Section ======= -->

    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-contact">

                        <img class="logo-footer shadow-lg rounded-circle" src="assets/dist/img/logom.png"
                            alt="Logo Image" style="height: 6rem; align-items: center;">
                        <p class="pt-4">
                            FDRE Ministry of Education is a governmental organization headquartered in Addis Ababa,
                            Arada sub-city. "
                        </p>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-links">
                        <h3>Contact Us</h3>
                        <p>
                        <p>
                            <i class="bi bi-geo-alt"></i>
                            Arada Sub-City, Addis Ababa
                        </p>
                        <br>
                        <strong>E-mail</strong> : info@moe.gov.et<br>
                        <strong>Website</strong>: www.moe.gov.et<br>
                        <strong>Tel</strong> : +251-11-155-3133<br>
                        </p>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-links">
                        <h4>Our link</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="{{ env('APP_URL') }}/admin/home">Admin
                                </a></li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ env('APP_URL') }}/university/home">University</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ env('APP_URL') }}/department/home">Department</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="{{ env('APP_URL') }}/user/home">User</a>
                            </li>
                            <li><i class="bx bx-chevron-right"></i> <a
                                    href="{{ env('APP_URL') }}/company/home">Company</a></li>
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <a target="_blank" href="https://moe.gov.et"><b>Ministry of Science and Higher
                            Education</b><em></em></a>.
                    All Rights Reserved
                </div>

            </div>

            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="http://twitter.com/fdremoe" target="_blank" class="twitter">
                    <i class="bx bxl-twitter"></i>
                </a>
                <a href="https://www.facebook.com/fdremoe/" target="_blank" class="facebook">
                    <i class="bx bxl-facebook"></i>
                </a>
                <a href="https://www.youtube.com/channel/UChrmtas-4cE6LdG1fGl91Cw" target="_blank" class="youtube">
                    <i class="bx bxl-youtube"></i>
                </a>

                <a href="https://www.linkedin.com/company/ministry-of-education-ethiopia" target="_blank"
                    class="linkedin">
                    <i class="bx bxl-linkedin"></i>
                </a>
            </div>
        </div>
    </footer>
    <!-- ======= End Footer ======= -->

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }} "></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }} "></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }} "></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }} "></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }} "></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/custom/script.js') }}"></script>
    <script>
        $(function() {
            loadInternship();
        });

        function loadInternship() {
            $.get('{{ env('APP_URL') }}/api/internship', function(data) {
                if (data.length == 0) {
                    let dom =
                        '<div class="col-md-12 mt-5">' +
                        '<center>' +
                        'Oops, we couldn\'t find any data!' +
                        '</center>' +
                        '</div>'
                    $('#searchResultDiv').html(dom);
                } else {
                    $('#searchResultDiv').html('');
                    for (var i = 0; i < 2 && i < data.length; i++) {
                        let dom =
                            '<div class="col-md-6 d-flex align-items-stretch">' +
                            '<div class="icon-box aos-init aos-animate" data-aos="zoom-in" data-aos-delay="100">' +
                            '<h4><a href="{{ env('APP_URL') }}/user/internship/view/' + data[i]
                            .id + '">' + data[i].title + '</a></h4>' +
                            '<p class="msgTextTimp">' + data[i].description + '</p>' +
                            '</div>' +
                            '</div>';
                        $('#searchResultDiv').append(dom);
                    }
                    $(".msgTextTimp").each(function() {
                        $(this).text($(this).text().substr(0, 100));
                        $(this).append('...');
                    });
                }
            });
        }
    </script>
</body>

</html>
