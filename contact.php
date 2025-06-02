<?php
session_start();
$message = $_SESSION['contact_message'] ?? '';
$success = $_SESSION['contact_success'] ?? false;
unset($_SESSION['contact_message'], $_SESSION['contact_success']);
?>

<?php if ($message): ?>
    <div class="<?= $success ? 'message-success' : 'message-error' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio | Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">

    <!-- Header Section -->
    <header>
        <div class="header-content">
            <h1>Get In Touch</h1>
            <p>I'd love to hear from you</p>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="index.html" class="active">Home</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        <section class="contact-intro">
            <h2>Ayok Terhubung!</h2>
            <p>Punya pertanyaan atau ingin berkolaborasi? Jangan ragu untuk menghubungi saya. Saya selalu terbuka untuk mendiskusikan proyek baru, ide-ide kreatif, atau kesempatan untuk menjadi bagian dari visi Anda.</p>
        </section>
        
        <section class="contact-container">
            <div class="contact-form">
                <h3>Kirimi saya pesan</h3>
                
                <?php if ($message): ?>
                    <div class="message-alert <?php echo $success ? 'message-success' : 'message-error'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <form action="submit_contact.php" method="post" id="contactForm">
                    <div class="form-group">
                        <label for="name">Nama Anda</label>
                        <input type="text" id="name" name="name" class="form-control" required maxlength="100">
                        <small class="form-text">Maksimal 100 karakter</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Anda</label>
                        <input type="email" id="email" name="email" class="form-control" required maxlength="100">
                        <small class="form-text">Contoh: nama@domain.com</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" class="form-control" required maxlength="200">
                        <small class="form-text">Maksimal 200 karakter</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Pesan Anda</label>
                        <textarea id="message" name="message" class="form-control" required maxlength="2000" rows="6" oninput="updateCharCount()"></textarea>
                        <small class="form-text">Maksimal 2000 karakter - <span id="charCount">0</span>/2000</small>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submitBtn">Kirim Pesan</button>
                </form>
            </div>
            
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-item-icon">📍</div>
                        <div>Bahu, Manado, Sulawesi Utara</div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-item-icon">📞</div>
                        <div>+6281340298862</div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-item-icon">✉️</div>
                        <div>elsasiwy026@student.unsrat.ac.id</div>
                    </div>
                </div>
                
                <div class="contact-social">
                    <h4>Temukan saya di</h4>
                    <div class="social-links-contact">
                        <a href="https://github.com/ElsaMonica77" class="social-link" title="GitHub">GH</a>
                        <a href="https://www.linkedin.com/in/elsa-monica-siwy-664352289?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="social-link" title="LinkedIn">LI</a>
                        <a href="https://wa.me/6281340298862" class="social-link" title="WhatsApp">WA</a>
                        <a href="https://www.instagram.com/elsamonicasiwy" class="social-link" title="Instagram">IG</a>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="map-container">
            <h3>Lokasi Kampus</h3>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.5448372678284!2d124.82769277473696!3d1.459710798815595!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32870a83651438f5%3A0xb8a2b86a0997182b!2sUniversitas%20Sam%20Ratulangi!5e0!3m2!1sid!2sid!4v1709988271962!5m2!1sid!2sid" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <p>Jl. Kampus Bahu, Malalayang, Kota Manado, Sulawesi Utara 95115</p>
        </section>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Elsa Portfolio. All rights reserved.</p>
            <div class="social-links">
                <a href="https://github.com/ElsaMonica77" title="GitHub">GitHub</a>
                <a href="https://www.linkedin.com/in/elsa-monica-siwy-664352289?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" title="LinkedIn">LinkedIn</a>
                <a href="https://wa.me/6281340298862" title="WhatsApp">WhatsApp</a>
                <a href="https://www.instagram.com/elsamonicasiwy" title="Instagram">Instagram</a>
            </div>
            <p>Universitas Sam Ratulangi</p>
        </div>
    </footer>

    <script>
        // Character counter for message textarea
        document.getElementById('message').addEventListener('input', function() {
            const charCount = this.value.length;
            document.getElementById('charCount').textContent = charCount;
            
            if (charCount > 2000) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '#28a745';
            }
        });
        
        // Form submission with loading state
        document.getElementById('contactForm').addEventListener('submit', function() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').textContent = 'Mengirim...';
        });
        
        // Auto-hide success message after 5 seconds
        const successMessage = document.querySelector('.message-success');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>