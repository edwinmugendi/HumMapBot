<p>Dear <?php echo $viewData['name']; ?>,</p>
<p>We received a request to reset the password for your <?php echo $viewData['productName'];?> account for email address <?php echo $viewData['email']; ?></p>

<p>If you want to reset your password, please click on the link below (or copy and paste the link (URL) onto your browser):</p>

<p><?php echo $viewData['url']; ?></p>

<p>This link takes you to a secure page where you can change your password which needs to have a minimum of <?php echo $viewData['passwordMinCharacters'];?> characters. </p>

<p>If you don't want to change your password, you can safely ignore this email and continue using <?php echo $viewData['productName'];?> with your existing password. We're happy to help, so please feel free to contact us with any questions or feedback.</p>
