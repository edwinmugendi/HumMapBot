<p>Dear <?php echo $view_data['name']; ?>,</p>
<p>Welcome to <?php echo $view_data['productName']; ?>!</p>

<?php if ($view_data['status'] == 1): ?>
    <p>Start enjoying our services:</p>
<?php else: ?>
    <p>To start enjoying our services:</p>
<?php endif; ?>
<p>1. Search car wash near you,</p>
<p>2. View services offered by the car wash,</p>
<p>3. Instantly pay using your credit card,</p>
<p>4. Earn loyalty points for each car wash,</p>
<p>5. Get a free car wash from your loyalty points or promotions that run from time to time,</p>
<?php if ($view_data['status'] == 0): ?>
    <p>Kindly click on the link below (or copy and paste the link (URL) onto your browser):</p>
    <p><?php echo $view_data['url']; ?></p>
<?php endif; ?>
<p>If you didn't create an account on <?php echo $view_data['productName']; ?> kindly ignore this email or consider creating one.</p>
