<?php
/*
Plugin Name: Custom Email Sender
Description: This plugin is to send emails using wp_mail().
Version: 0.01
Author: Ali Nawaz Sahi
*/

function custom_email_sender_menu() {
    add_menu_page(
        'Email Sender',
        'Email Sender',
        'manage_options',
        'custom-email-sender',
        'custom_email_sender_page'
    );
}
add_action('admin_menu', 'custom_email_sender_menu');

function custom_email_sender_page() {
    ?>
   <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #f5f5f5; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); text-align: center;">

<h2 style="color: #007cba; margin-bottom: 20px; font-family: 'Arial', sans-serif; font-size: 24px;">Email Sender</h2>

<form method="post" action="">
    <div style="margin-bottom: 20px;">
        <label for="recipient" style="display: block; margin-bottom: 5px; color: #555; font-size: 16px;">Recipient:</label>
        <input type="email" name="recipient" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; margin-bottom: 10px; font-size: 14px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="subject" style="display: block; margin-bottom: 5px; color: #555; font-size: 16px;">Subject:</label>
        <input type="text" name="subject" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; margin-bottom: 10px; font-size: 14px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="message" style="display: block; margin-bottom: 5px; color: #555; font-size: 16px;">Message:</label>
        <textarea name="message" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; margin-bottom: 10px; height: 150px; font-size: 14px;"></textarea>
    </div>

    <div>
        <input type="submit" name="send_email" class="button-primary" value="Send Email" style="background-color: #007cba; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold;">
    </div>
</form>

</div>

    <?php
}

function handle_email_submission() {
    if (isset($_POST['send_email'])) {
        $recipient = sanitize_email($_POST['recipient']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = wp_kses_post($_POST['message']);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Your Name <your-email@example.com>',
        );

        $result = wp_mail($recipient, $subject, $message, $headers);

        if ($result) {
            echo '<div style="margin-top: 20px; padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; color: #155724;">Email sent successfully!</div>';
        } else {
            echo '<div style="margin-top: 20px; padding: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">Error sending email. Please try again.</div>';
        }
    }
}

add_action('admin_init', 'handle_email_submission');

