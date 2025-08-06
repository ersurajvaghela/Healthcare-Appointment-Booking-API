<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HealthCare+ - Coming Soon</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                text-align: center;
            }

            .container {
                max-width: 600px;
                padding: 2rem;
            }

            .logo {
                font-size: 3rem;
                margin-bottom: 1rem;
            }

            h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            p {
                font-size: 1.2rem;
                margin-bottom: 2rem;
            }

            .email-form {
                background: rgba(255, 255, 255, 0.1);
                padding: 2rem;
                border-radius: 10px;
                margin-bottom: 2rem;
            }

            input {
                padding: 1rem;
                font-size: 1rem;
                border: none;
                border-radius: 5px;
                margin-right: 1rem;
                width: 250px;
            }

            button {
                padding: 1rem 2rem;
                font-size: 1rem;
                background: white;
                color: #667eea;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background: #f0f0f0;
            }

            .contact {
                font-size: 1rem;
            }

            @media (max-width: 768px) {
                h1 {
                    font-size: 2rem;
                }

                input {
                    width: 200px;
                    margin-bottom: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">🏥</div>
            <h1>HealthCare+</h1>
            <p>We're building something amazing for healthcare appointments.</p>
            <p>Coming Soon!</p>

            <div class="email-form">
                <h3>Get Notified</h3>
                <input type="email" id="email" placeholder="Enter your email">
                <button onclick="subscribe()">Notify Me</button>
            </div>

            <div class="contact">
                <p>Questions? Email us at info@healthcareplus.com</p>
            </div>
        </div>

        <script>
            function subscribe() {
                const email = document.getElementById('email').value;
                if (email && email.includes('@')) {
                    alert('Thanks! We\'ll notify you when we launch.');
                    document.getElementById('email').value = '';
                } else {
                    alert('Please enter a valid email.');
                }
            }
        </script>
    </body>
</html>