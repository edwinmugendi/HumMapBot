<h3 style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 30px; margin: 0; padding: 15px 0;" align="left">
    Dear <?php echo $view_data['name']; ?>,
</h3>
<p class="lead" style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 25px; font-size: 16px; margin: 0 0 25px; padding: 0;" align="left">
    Welcome to <?php echo $view_data['productName']; ?>!
</p>
<p class="lead" style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 25px; font-size: 16px; margin: 0 0 25px; padding: 0;" align="left">
    <?php if ($view_data['status'] == 1): ?>Start enjoying our services:
    <?php else: ?>To start enjoying our services:
    <?php endif; ?>
</p>
<p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left">
    1. Search car wash near you,<br/>
    2. View services offered by the car wash,<br/>
    3. Instantly pay using your credit card,<br/>
    4. Earn loyalty points for each car wash,<br/>
    5. Get a free car wash from your loyalty points or promotions that run from time to time,<br/>
</p>
<?php if ($view_data['status'] == 0): ?>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 10px 0; padding: 0;" align="left">Kindly click on the link below (or copy and paste the link (URL) onto your browser):</p>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 10px 0; padding: 0;" align="left"><?php echo $view_data['url']; ?></p>
<?php endif; ?>
<p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 10px 0; padding: 0;" align="left">If you didn't create an account on <?php echo $view_data['productName']; ?> kindly ignore this email or consider creating one.</p>