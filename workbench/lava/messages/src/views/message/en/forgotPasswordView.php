<h3 style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 1.3; word-break: normal; font-size: 30px; margin: 0; padding: 15px 0;" align="left">
    Dear <?php echo $view_data['name']; ?>,
</h3>
<p class="lead" style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 25px; font-size: 16px; margin: 0 0 25px; padding: 0;" align="left">
    We received a request to reset the password for your <?php echo $view_data['productName']; ?> account for 
    <?php if ($view_data['field'] == 'phone'): ?>
        phone <?php echo $view_data['send_to']; ?>
    <?php else: ?>
        email address <?php echo $view_data['send_to']; ?>
    <?php endif; ?>
</p>
<?php if (($view_data['role_id'] == 3)): ?>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left">Kindly use this code to reset your password</p>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left">Security code:<b><?php echo $view_data['resetCode']; ?></b></p>
<?php else: ?>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left">If you want to reset your password, please click on the link below (or copy and paste the link (URL) onto your browser):</p>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left"><?php echo $view_data['url']; ?></p>
    <p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 25px 0 10px; padding: 0;" align="left">This link takes you to a secure page where you can change your password which needs to have a minimum of <?php echo $view_data['passwordMinCharacters']; ?> characters. </p>
<?php endif; ?>

<p style="color: #222222; font-family: 'Helvetica Neue', 'Arial', sans-serif; font-weight: normal; text-align: left; line-height: 19px; font-size: 14px; margin: 10px 0; padding: 0;" align="left">If you don't want to change your password, you can safely ignore this email and continue using <?php echo $view_data['productName']; ?> with your existing password. We're happy to help, so please feel free to contact us with any questions or feedback.</p>

