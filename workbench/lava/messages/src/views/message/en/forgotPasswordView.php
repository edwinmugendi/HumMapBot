<p>Dear <?php echo $view_data['name']; ?>,</p>
<p>We received a request to reset the password for your <?php echo $view_data['productName']; ?> account for 
    <?php if ($view_data['field'] == 'phone'): ?>
        phone <?php echo $view_data['send_to']; ?>
    <?php else: ?>
        email address <?php echo $view_data['send_to']; ?>
    <?php endif; ?>
</p>
<?php if (($view_data['role_id'] == 3)): ?>
    <p>Kindly use this code to set your password</p>
    <p>Security code:<b><?php echo $view_data['resetCode']; ?></b></p>
<?php else: ?>
    <p>If you want to reset your password, please click on the link below (or copy and paste the link (URL) onto your browser):</p>
    <p><?php echo $view_data['url']; ?></p>
    <p>This link takes you to a secure page where you can change your password which needs to have a minimum of <?php echo $view_data['passwordMinCharacters']; ?> characters. </p>
<?php endif; ?>
<p>If you don't want to change your password, you can safely ignore this email and continue using <?php echo $view_data['productName']; ?> with your existing password. We're happy to help, so please feel free to contact us with any questions or feedback.</p>
