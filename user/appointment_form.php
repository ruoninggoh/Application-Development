<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="../css/appointmentForm.css" />
  </head>
  <body>
    <?php
      include("userHeader.html");
    ?>
    <div class="container">
      <h1 class="form-title">Registration</h1>
      <form action="../database/appointment.php" method="POST">
        <div class="datetime-appointment">
          <div class="user-input-box">
            <label for="_date">Date</label>
            <input type="date" id="date" name="date" required>
          </div>
          <div class="user-input-box">
            <label for="_time">Time</label>
            <select id="time" name="time" required>
                <option value=" ">Select Time</option>
                <option value="08:00:00">08:00 AM</option>
                <option value="08:30:00">08:30 AM</option>
                <option value="09:00:00">09:00 AM</option>
                <option value="09:30:00">09:30 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="10:30:00">10:30 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="11:30:00">11:30 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="14:30:00">02:30 PM</option>
                <option value="15:00:00">03:00 PM</option>
                <option value="15:30:00">03:30 PM</option>
                <option value="16:00:00">04:00 PM</option>
                <option value="16:30:00">04:30 PM</option>
              </select>
          </div>
          
        </div>
        <div class="reason-details-box">
          <span class="form-title">Reason for Appointment</span>
          <div class="reason-category">
            <textarea id="reason" name="reason" rows="10" cols="100" placeholder="Briefly describe your condition" required></textarea>
          </div>
        </div>
        <div class="form-submit-btn">
        <div class="submit-button">
            <button type="submit"><span>Submit</span>
              <div class="success"><svg xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 29.756 29.756" style="enable-background:new 0 0 29.756 29.756;" xml:space="preserve">
                  <path d="M29.049,5.009L28.19,4.151c-0.943-0.945-2.488-0.945-3.434,0L10.172,18.737l-5.175-5.173   c-0.943-0.944-2.489-0.944-3.432,0.001l-0.858,0.857c-0.943,0.944-0.943,2.489,0,3.433l7.744,7.752   c0.944,0.943,2.489,0.943,3.433,0L29.049,8.442C29.991,7.498,29.991,5.953,29.049,5.009z">
                </svg>
            </button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>