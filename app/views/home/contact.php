<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= asset('css/styles.css') ?>">
    <title>Contact</title>
</head>

<body>

    <div class="contact-container">
        <div class="contact-hero">
            <h1 class="contact-title">Let's Work Together</h1>
            <p class="contact-subtitle">Have a project in mind? I'd love to hear from you!</p>
        </div>

        <div class="contact-content">
            <!-- Contact Information Cards -->
            <div class="contact-info-section">
                <div class="info-card">
                    <div class="info-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p id="email-text">your.email@example.com</p>
                        <button class="copy-btn" onclick="copyToClipboard('your.email@example.com')">
                            Copy
                        </button>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Location</h3>
                        <p>Your City, Country</p>
                        <p class="timezone">Timezone: GMT+0</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Response Time</h3>
                        <p>Usually within 24 hours</p>
                        <div class="availability-badge">
                            <span class="status-dot"></span>
                            Available for projects
                        </div>
                    </div>
                </div>

                <div class="info-card social-card">
                    <div class="info-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 2H7C4.79 2 3 3.79 3 6v12c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4V6c0-2.21-1.79-4-4-4z"></path>
                            <circle cx="12" cy="12" r="4"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <div class="info-content">
                        <h3>Social Links</h3>
                        <div class="social-links">
                            <a href="https://linkedin.com/in/yourprofile" target="_blank" class="social-link" title="LinkedIn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                            </a>
                            <a href="https://github.com/yourprofile" target="_blank" class="social-link" title="GitHub">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/yourprofile" target="_blank" class="social-link" title="Twitter">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2 class="form-title">Send Me a Message</h2>

                <?php if (isset($_SESSION['flash'])): ?>
                    <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?>">
                        <?= htmlspecialchars($_SESSION['flash']['message']) ?>
                    </div>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>

                <form action="<?= url('contact.submit') ?>" method="POST" class="contact-form" id="contactForm">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="name">Your Name *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            placeholder="John Doe"
                            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                        <span class="error-message" id="name-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            placeholder="john@example.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        <span class="error-message" id="email-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            required
                            placeholder="Project Inquiry"
                            value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
                        <span class="error-message" id="subject-error"></span>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message *</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            placeholder="Tell me about your project..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <span class="error-message" id="message-error"></span>
                        <span class="char-count">0 / 1000</span>
                    </div>

                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span class="btn-text">Send Message</span>
                        <span class="btn-loader" style="display: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" opacity="0.25"></circle>
                                <path d="M12 2a10 10 0 0 1 10 10" opacity="0.75"></path>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= asset('js/contact.js') ?>"></script>
    <script src="<?php echo asset('js/pageListingsNoScrolling.js') ; ?>"></script>
</body>

</html>