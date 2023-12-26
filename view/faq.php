<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <?php include("userHeader.php"); ?>
    <style>
        /* Your CSS styles here */
        /* CSS for the background overlay with animation */
        /* CSS for the white overlay effect with animation */
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0);
            /* Start with 0 opacity */
            z-index: -1;
            animation: fadeIn 1s ease-in-out forwards;
        }

        /* CSS for the blur effect with animation */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("../images/back.jpg");
            background-size: cover;
            background-attachment: fixed;
            filter: blur(0px);
            /* Start with no blur */
            z-index: -1;
            animation: blurIn 1s ease-in-out forwards;
        }

        /* Animation for fading in the overlay */
        @keyframes fadeIn {
            from {
                background-color: rgba(255, 255, 255, 0);
            }

            to {
                background-color: rgba(255, 255, 255, 0.5);
                /* Adjust the final opacity as needed */
            }
        }

        /* Animation for blurring the background image */
        @keyframes blurIn {
            from {
                filter: blur(0px);
            }

            to {
                filter: blur(4px);
                /* Adjust the final blur intensity as needed */
            }
        }



        .section-title {
            text-align: center;
            padding: 30px;
            opacity: 0;
            /* Start with 0 opacity */
            transform: translateY(20px);
            /* Start slightly below its normal position */
            animation: fadeInUp 1s ease-in-out forwards;
            /* Animation properties */
        }

        /* Keyframes for the fade-in animation */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            font-family: "Raleway", sans-serif;
        }

        .footer-hashen {
            position: absolute;
            bottom: 0;
            left: 45%;
            font-size: 13px;
            animation: transitionIn-Y-over 0.5s;
        }

        .section-title h2::before {
            content: "";
            position: absolute;
            display: block;
            width: 120px;
            height: 1px;
            background: #ddd;
            bottom: 1px;
            left: calc(50% - 60px);
        }

        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        .section-title h2::after {
            content: "";
            position: absolute;
            display: block;
            width: 40px;
            height: 3px;
            background: #1977cc;
            bottom: 0;
            left: calc(50% - 20px);
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 20px;
            position: relative;
            color: #2c4964;
            margin-top: 50px;
        }

        .faq .faq-list {
            padding: 0 100px;
            margin-top: 20px;
        }

        .faq .faq-list ul {
            padding: 0;

            list-style: none;
        }

        .faq .faq-list li+li {
            margin-top: 15px;
        }

        .faq .faq-list li {
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            position: relative;
        }

        .faq .faq-list a {
            display: block;
            position: relative;

            font-size: 16px;
            line-height: 24px;
            font-weight: 500;
            padding: 0 30px;
            outline: none;
            cursor: pointer;
            color: black;

        }

        .faq .faq-list a:hover {
            display: block;
            position: relative;
            font-size: 16px;
            line-height: 24px;
            font-weight: 500;
            padding: 0 30px;
            outline: none;
            cursor: pointer;
            color: #1977cc;
        }

        .faq .faq-list .icon-show,
        .faq .faq-list .icon-close {
            font-size: 24px;
            position: absolute;
            right: 0;
            color: black;
            margin-top: 3px;

        }

        .faq .faq-list p {
            margin-bottom: 0;
            padding: 10px 0 0 0;

        }

        .faq .faq-list .icon-show {
            display: none;
        }

        .faq .faq-list a.collapsed {
            color: #343a40;

        }

        .faq .faq-list a.collapsed:hover {
            color: #1977cc;

        }

        .faq .faq-list a.collapsed .icon-show {
            display: none;
        }

        .faq .faq-list a.collapsed .icon-close {
            display: none;
        }

        @media (max-width: 1200px) {
            .faq .faq-list {
                padding: 0;
            }
        }

        a:hover {
            text-decoration: none;
            color: blue;
        }


        /* Added styles for FAQ question and answer toggle */
        .faq .faq-list .answer {
            display: none;

        }



        /* Add this CSS to your existing styles */
        .faq-list1 {
            padding: 0 100px;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .faq-content {
            max-height: 200px;
            /* Set a fixed maximum height */
            overflow: auto;
            /* Add scrollbars if content overflows the fixed height */
        }

        .faq-item {
            width: 48%;
            float: left;
            /* Align items to the top */
            margin-right: 2%;

        }

        .faq-item i {
            font-size: 24px;
            /* Adjust the icon size as needed */
            margin-right: 20px;
            /* Adjust the spacing between the icon and question text */
            color: #7EB5EE;
            position: absolute;
            margin-top: -5px;

            /* Set the icon color to light blue */
        }



        .faq-item1 i {
            font-size: 24px;
            /* Adjust the icon size as needed */
            margin-right: 10px;
            /* Adjust the spacing between the icon and question text */
            color: #7EB5EE;
            position: absolute;
            margin-top: -7px;

            /* Set the icon color to light blue */
        }

        /* Clear the margin for the last item in a row */
        .faq-item:last-child {
            margin-right: 0;
        }

        .faq-item1 a .icon-show {
            color: black;
        }

        /* Responsive layout: On smaller screens, make items stack vertically again */
        @media (max-width: 768px) {
            .faq-item {
                display: block;
                width: 100%;
                margin-right: 0;
            }
        }

        h4 {
            text-align: center;
        }

        .u2 {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <!-- FAQ Section -->
    <section id="faq" class="faq section-bg">
        <div class="container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
            </div>

            <div class="faq-list">
                <h4>OPERATING HOURS & REGISTRATION</h4>
                <br>
                <ul>
                    <li data-aos="fade-up" data-toggle="collapse" class="faq-item1">
                        <i class="uil uil-question-circle"></i>
                        <a class="faq-question" href="#faq-list-1">
                            Where is UTM Health Centre (PKU)?
                            <i class="uil uil-angle-down icon-show"></i>
                            <i class="uil uil-angle-up icon-close"></i>
                        </a>
                        <div id="faq-list-1" class="collapse">
                            <p>
                                PKU is located within Universiti Teknologi Malaysia. Visitors can get to PKU with
                                the following information:<span> </span>
                                <a href="https://goo.gl/maps/emFpHhUpb9mHhxu58" target="_blank"
                                    rel="noopener noreferrer">http://map.pku.utm.my/</a>
                            </p>
                        </div>
                    </li>
                    <li data-aos="fade-up" class="faq-item1">
                        <i class="uil uil-question-circle"></i>
                        <a class="faq-question" href="#faq-list-2">What are the registration and
                            operating hours? <i class="uil uil-angle-down icon-show"></i>
                            <i class="uil uil-angle-up icon-close"></i></a>
                        <div id="faq-list-2" class="collapse">
                            <p><strong>Academic Week:</strong></p>
                            <table border="1"
                                style="border-collapse: collapse;width: 100%;margin-left: auto;margin-right: auto">
                                <tbody>
                                    <tr>
                                        <td style="width: 50%;text-align: center"><strong>DAY</strong></td>
                                        <td style="width: 50%;text-align: center"><strong>TIME</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;text-align: center">Sunday &#8211; Wednesday</td>
                                        <td style="width: 50%;text-align: center">8.00 am – 10.00 pm</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;text-align: center">Thursday</td>
                                        <td style="width: 50%;text-align: center">8.00 am – 10.00 pm</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;text-align: center">Friday &amp; Saturday</td>
                                        <td style="width: 50%;text-align: center">8.30 am – 12.30 pm</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;text-align: center"><span
                                                style="color: #ff0202"><strong>Public Holiday</strong></span></td>
                                        <td style="width: 50%;text-align: center"><span
                                                style="color: #ff0202"><strong>CLOSE</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="text-align: left"><strong>Semester Break:</strong></p>
                            <table border="1" style="border-collapse: collapse;width: 100%;height: 120px">
                                <tbody>
                                    <tr style="height: 24px;text-align: center">
                                        <td style="width: 50%;height: 24px"><strong>DAY</strong></td>
                                        <td style="width: 50%;height: 24px"><strong>TIME</strong></td>
                                    </tr>
                                    <tr style="height: 24px;text-align: center">
                                        <td style="width: 50%;height: 24px">Sunday &#8211; Wednesday</td>
                                        <td style="width: 50%;height: 24px">8.00 am – 5.00 pm</td>
                                    </tr>
                                    <tr style="height: 24px;text-align: center">
                                        <td style="width: 50%;height: 24px">Thursday</td>
                                        <td style="width: 50%;height: 24px">8.00 am – 3.30 pm</td>
                                    </tr>
                                    <tr style="height: 24px;text-align: center">
                                        <td style="width: 50%;height: 24px">Friday &amp; Saturday</td>
                                        <td style="width: 50%;height: 24px">8.30 am – 12.30 pm</td>
                                    </tr>
                                    <tr style="height: 24px">
                                        <td style="width: 50%;height: 24px;text-align: center"><span
                                                style="color: #ff0202"><strong>Public Holiday</strong></span></td>
                                        <td style="width: 50%;height: 24px;text-align: center"><span
                                                style="color: #ff0202"><strong>CLOSE</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            </p>
                            <p>Please note that <strong>last registration</strong> is <span
                                    style="color: #ff0202"><strong>30 minutes</strong></span> prior to lunch or closing
                                hours. However, registration may close earlier depending on the volume of patients.</p>
                        </div>

                    </li>

                    <li data-aos="fade-up" class="faq-item1">
                        <i class="uil uil-question-circle"></i>
                        <a class="faq-question" href="#faq-list-3">What do I need to bring for
                            each visit? <i class="uil uil-angle-down icon-show"></i>
                            <i class="uil uil-angle-up icon-close"></i></a>
                        <div id="faq-list-3" class="collapse ">
                            <p>
                                Please bring along your identification card (such as Student Matric card, Staff card or
                                NRIC) for verification purposes.
                        </div>
                    </li>
                </ul>
                <div class="u2">
                    <h4>GENERAL HEALTH SERVICES</h4>
                    <br>
                    <ul class="faq-list1">
                        <li data-aos="fade-up" class="faq-item1">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-4">Are radiology (X-ray)
                                services
                                available in PKU? Do I need to schedule an appointment? <i
                                    class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-4" class="collapse">
                                <div class="faq-content">
                                    <p>X-ray services are available on Sunday to Thursday. No appointment is required.
                                        However a doctor's consultation is required before proceeding with your x-ray.
                                    </p>
                                    <!-- Content for the first FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item1">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-7">Do I need to consult a
                                doctor
                                before I proceed for my laboratory test?
                                <i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-7" class="collapse">
                                <div class="faq-content">
                                    <p>
                                        You may like to consider consulting our doctor for advice regarding any health
                                        concerns you may have or medical examinations you are considering to undergo.
                                    </p>

                                    <p>Costs for medical examinations and tests varies, you may enquire on yours when
                                        registering.</p><!-- Content for the second FAQ item -->
                                </div>
                            </div>
                        </li>

                        <li data-aos="fade-up" class="faq-item1">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-7">Are medical consultation
                                and
                                medication chargeable at PKU?
                                <i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-7" class="collapse">
                                <div class="faq-content">
                                    <p>
                                        Charges are generally dependent on the type of consultation medication/treatment
                                        plan which you require and service scheme which you are covered.</p>
                                    <!-- Content for the second FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item1">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-8">I have changed my
                                programme/faculty, would my new faculty be informed of my medical results? <i
                                    class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-8" class="collapse">
                                <div class="faq-content">
                                    <p>Medical results will be forwarded to the faculty which you've indicated on your
                                        Medical Examination Form. Alternatively, please email pku@utm.my to inform PKU
                                        of
                                        any changes.</p> <!-- Content for the first FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-9">What are the available
                                modes
                                of payment?
                                <i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-9" class="collapse">
                                <div class="faq-content">
                                    <p>Cash only are acceptable modes of payment.</p>
                                    <!-- Content for the second FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-10">How soon will I receive
                                my
                                results? <i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-10" class="collapse">
                                <div class="faq-content">
                                    <p>Depending on the type of test or screening you have undergone, results will be
                                        ready
                                        within one (1) to three (3) hours.</p> <!-- Content for the first FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-6">Are dental service
                                available
                                at PKU?<i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-6" class="collapse">
                                <div class="faq-content">
                                    <p>Yes. Dental services are available on Sunday to Thursday.</p>
                                    <!-- Content for the first FAQ item -->
                                </div>
                            </div>
                        </li>
                        <li data-aos="fade-up" class="faq-item" data-animation-delay="200">
                            <i class="uil uil-question-circle"></i>
                            <a class="faq-question" data-toggle="collapse" href="#faq-list-11">Are dialysis service
                                available at PKU?
                                <i class="uil uil-angle-down icon-show"></i>
                                <i class="uil uil-angle-up icon-close"></i></a>
                            <div id="faq-list-11" class="collapse">
                                <div class="faq-content">
                                    <p>Yes. Dialysis services are available at PKU. Our Dialysis Centre (also known as
                                        Hemodialysis unit) is operating at G27, Kolej Rahman Putra.</p>
                                    <!-- Content for the second FAQ item -->
                                </div>
                            </div>
                        </li>
                        <!-- Add more FAQ items here with unique IDs -->
                    </ul>
                </div>
            </div>

    </section><!-- End Frequently Asked Questions -->

    <!-- JavaScript to toggle FAQ sections -->
    <script>
        // JavaScript to toggle FAQ sections
        document.addEventListener('DOMContentLoaded', function () {
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(function (question) {
                question.addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent the default anchor link behavior

                    const answer = this.nextElementSibling;
                    const showIcon = this.querySelector('.icon-show');
                    const closeIcon = this.querySelector('.icon-close');

                    if (answer.classList.contains('show')) {
                        answer.classList.remove('show');
                        showIcon.style.display = 'inline-block';
                        closeIcon.style.display = 'none';
                        this.style.color = 'black';
                    } else {
                        answer.classList.add('show');
                        showIcon.style.display = 'none';
                        closeIcon.style.display = 'inline-block';
                        this.style.color = '#1977D4';
                    }

                    // Toggle the "clicked" class for the question text
                    this.classList.toggle('clicked');
                });

                const answer = question.nextElementSibling;
                const showIcon = question.querySelector('.icon-show');
                const closeIcon = question.querySelector('.icon-close');
                answer.classList.remove('show');
                showIcon.style.display = 'inline-block';
                closeIcon.style.display = 'none';
                question.style.color = 'black';
            });
        });

    </script>



    <!-- Include other scripts and libraries as needed -->
</body>

</html>
<?php include("../landingfooter.html"); ?>