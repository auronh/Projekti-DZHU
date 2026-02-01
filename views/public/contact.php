<?php
require_once '../../config/config.php';
$contactController = new ContactController();
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $contactController->submitContact($_POST);
    if ($result['success']) {
        $success = $result['message'];
        $_POST = [];
    } else {
        $errors = $result['errors'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - <?php echo SITE_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        #contact {
            min-height: 100vh;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .contact-form {
            
            max-width: 700px;
            width: 100%;
            background: var(--card);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .contact-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--accent), #f59e0b, var(--accent));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .contact-form h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .contact-form > p {
            color: var(--muted);
            margin-bottom: 40px;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text);
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.5);
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
            line-height: 1.6;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(156, 163, 175, 0.5);
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, var(--accent), #dc2626);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .contact-info {
            margin-top: 40px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }

        .contact-info-item {
            text-align: center;
            padding: 20px;
            background: rgba(15, 23, 42, 0.3);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .contact-info-item:hover {
            background: rgba(15, 23, 42, 0.6);
            transform: translateY(-5px);
        }

        .contact-info-item .icon {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .contact-info-item h4 {
            color: var(--text);
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .contact-info-item p {
            color: var(--muted);
            font-size: 0.9rem;
            margin: 0;
        }

        .alert {
            padding: 20px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert::before {
            font-size: 1.5rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 2px solid #10b981;
            color: #10b981;
        }

        .alert-success::before {
            content: '✓';
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 2px solid var(--accent);
            color: var(--accent);
        }

        .alert-error::before {
            content: '⚠';
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
            list-style: none;
        }

        .alert ul li {
            margin: 5px 0;
        }

        .alert ul li::before {
            content: '•';
            margin-right: 10px;
        }

        .char-counter {
            text-align: right;
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 5px;
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-primary.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .contact-form {
                padding: 30px 25px;
            }
            
            .contact-form h2 {
                font-size: 2rem;
            }
            
            .contact-info {
                grid-template-columns: 1fr;
            }
            
            .btn-primary {
                padding: 16px 30px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="contact">
        <div class="contact-form">
            <h2>Get In Touch</h2>
            <p>Have a question or feedback? We'd love to hear from you!</p>
            
            <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <div>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="alert alert-success">
                <div><?php echo htmlspecialchars($success); ?></div>
            </div>
            <?php endif; ?>

            <form method="POST" id="contactForm">
                <div class="form-group">
                    <label for="name">Your Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        placeholder="John Doe"
                        value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="john@example.com"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input 
                        type="text" 
                        id="subject" 
                        name="subject" 
                        placeholder="What's this about?"
                        value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        required 
                        placeholder="Tell us what's on your mind..."
                        maxlength="1000"
                    ><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span> / 1000
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    Send Message
                </button>
            </form>

            <div class="contact-info">
                <div class="contact-info-item">
                    <div class="icon">📧</div>
                    <h4>Email</h4>
                    <p>support@albflix.com</p>
                </div>
                <div class="contact-info-item">
                    <div class="icon">📞</div>
                    <h4>Phone</h4>
                    <p>+383 44 111 111</p>
                </div>
                <div class="contact-info-item">
                    <div class="icon">📍</div>
                    <h4>Location</h4>
                    <p>Kosovo</p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script>
        const messageInput = document.getElementById('message');
        const charCount = document.getElementById('charCount');
        
        messageInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        charCount.textContent = messageInput.value.length;

        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !message) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return;
            }

            submitBtn.classList.add('loading');
            submitBtn.textContent = '';
        });

        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html>