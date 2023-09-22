<?php
if (isset($_GET['submitted']) && $_GET['submitted'] === 'true') {
  echo '<script>alert("Form submitted successfully.");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>UniHealth</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/contact.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,700;0,800;1,100;1,400&display=swap"
        rel="stylesheet">
  <?php include("userHeader.php"); ?>
</head>

<body>
  <section class="contact">
    <div class="container">
      <div class="section-title">
        <h2>Contact</h2>
        <p>Welcome to UniHealth's contact page. We value your inquiries and feedback. Whether you have questions about
          our services, want to collaborate, or simply want to get in touch, we're here to assist you. Our dedicated
          team is ready to provide you with the information you need. Reach out to us using the contact form below, and one of our representatives will get back to you promptly.
          Your satisfaction and well-being are our top priorities.
        <p>Thank you for considering UniHealth as your healthcare partner. We look forward to hearing from you and
          providing the best assistance possible.</p>

      </div>
    </div>

    <div>
      <iframe style="border:0; width: 100%; height: 500px;"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.340634371365!2d103.62479167496622!3d1.5594287984260051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da76af1f67f15b%3A0x55859cb64612767b!2sUTM%20Health%20Centre!5e0!3m2!1sen!2smy!4v1691862496292!5m2!1sen!2smy"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <div class="container">
      <div class="row mt-5">
        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="fa fa-map-marker"></i>
              <h4>Location:</h4>
              <p>Pusat Pentadbiran Universiti Teknologi Malaysia, 80990 Skudai, Johor</p>
            </div>
            <div class="email">
              <i class="fa fa-envelope"></i>
              <h4>Email:</h4>
              <p>UniHealth@example.com</p>
            </div>
            <div class="phone">
              <i class="fa fa-phone"></i>
              <h4>Call:</h4>
              <p>+(60)75530999</p>
            </div>
          </div>
        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">
          <form action="../database/contactuser_form.php" method="post" class="php-email-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="number" class="form-control" name="contact" id="contact" placeholder="Contact Number" required>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit">Send Message</button></div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->

</html>

<?php include("../landingfooter.html"); ?>