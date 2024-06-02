<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EazyHotel ERP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e1e1e1;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            color: #4CAF50;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://yourwebsite.com/logo.png" alt="EazyHotel ERP Logo">
        </div>
        <div class="content">
            <h1>Welcome to EazyHotel ERP!</h1>
            <p>Dear {{ $user->name }},</p>
            <p>We are thrilled to have you on board and are excited to help you streamline your hotel management processes. EazyHotel ERP is designed to make your hotel operations more efficient, organized, and profitable.</p>
            <h2>Your EazyHotel ERP Account</h2>
            <p>You have successfully signed up for EazyHotel ERP, and your account is now active. Below are your login details:</p>
            <ul>
                <li><strong>Username:</strong>{{ $user->email }}</li>
                <li><strong>Password:</strong> [Your Password]</li>
            </ul>
            <p><a href="https://yourwebsite.com/login" class="button">Log in to Your Account</a></p>
            <h2>Getting Started</h2>
            <p>To help you get started, we have outlined a few steps to make your onboarding process as smooth as possible:</p>
            <ol>
                <li><strong>Explore the Dashboard:</strong> Get a quick overview of your hotel’s key metrics and performance indicators.</li>
                <li><strong>Set Up Your Hotel Profile:</strong> Add detailed information about your hotel, including rooms, amenities, and services.</li>
                <li><strong>Manage Reservations:</strong> Easily create, edit, and manage reservations for your guests.</li>
                <li><strong>Billing and Invoicing:</strong> Generate accurate invoices for your guests.</li>
                <li><strong>Inventory Management:</strong> Keep track of your inventory levels.</li>
            </ol>
            <h2>Need Help?</h2>
            <p>We are committed to providing you with the best support possible. If you have any questions or need assistance, our dedicated support team is here to help you 24/7.</p>
            <ul>
                <li><strong>Help Center:</strong> <a href="https://yourwebsite.com/help">Help Center Link</a></li>
                <li><strong>Email Support:</strong> <a href="mailto:support@yourwebsite.com">support@yourwebsite.com</a></li>
                <li><strong>Phone Support:</strong> +256 743152570 </li>
            </ul>
            <h2>Join Our Community</h2>
            <p>Stay connected with other EazyHotel ERP users to share insights, ask questions, and get the latest updates. Join our community forum here: <a href="https://yourwebsite.com/forum">Community Forum Link</a></p>
            <p>Thank you for choosing EazyHotel ERP. We are confident that our platform will help you enhance your hotel management processes and deliver exceptional experiences to your guests. We look forward to being a part of your success story.</p>
            <p>Warm regards,</p>
            <p>The EazyHotel ERP Team</p>
        </div>
        <div class="footer">
            <p>Connect with Us:</p>
            <p>
                <a href="https://facebook.com/yourpage">Facebook</a> |
                <a href="https://twitter.com/yourpage">Twitter</a> |
                <a href="https://linkedin.com/company/yourpage">LinkedIn</a>
            </p>
            <p>EazyHotel ERP<br>Nakasero Road, Kampala</p>
        </div>
    </div>
</body>
</html>
