<?php
/**
 * Template Name: Homepage
 * The front page template file
 *
 * @package Fanartikel
 */

get_header();
?>

<main class="site-main homepage">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Fanschals mit Logo – individuell werben mit Erfolg!</h1>
                <p class="hero-subtitle">Fanartikel bedrucken lassen ab 5 Stück. Gestalte deine individuellen Fanschals,
                    Mützen und mehr mit unserem Online-Konfigurator.</p>
                <div class="hero-buttons">
                    <a href="#konfigurator" class="btn btn-primary">Jetzt gestalten</a>
                    <a href="#produkte" class="btn btn-secondary">Produkte entdecken</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="produkte" class="products-section">
        <div class="container">
            <div class="section-header">
                <h2>Unsere Fanartikel</h2>
                <p>Hochwertige Produkte für Vereine, Events und Firmen</p>
            </div>

            <div class="products-grid">
                <div class="product-card">
                    <div class="product-icon">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="16" width="48" height="32" rx="4" stroke="currentColor" stroke-width="2" />
                            <path d="M16 24 L48 24" stroke="currentColor" stroke-width="2" />
                            <path d="M16 32 L48 32" stroke="currentColor" stroke-width="2" />
                            <path d="M16 40 L48 40" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <h3>Fanschals</h3>
                    <p>Gestrickte Fanschals mit individuellem Logo und Design. Perfekt für Vereine und Events.</p>
                    <ul class="product-features">
                        <li>Ab 5 Stück</li>
                        <li>Freie Farbwahl</li>
                        <li>Individuelles Logo</li>
                    </ul>
                </div>

                <div class="product-card">
                    <div class="product-icon">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="32" cy="28" r="16" stroke="currentColor" stroke-width="2" />
                            <path d="M20 44 Q32 36 44 44" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <h3>Strickmützen</h3>
                    <p>Warme Strickmützen mit Logo-Bestickung für kalte Spieltage und Outdoor-Events.</p>
                    <ul class="product-features">
                        <li>Hochwertige Materialien</li>
                        <li>Logo-Bestickung</li>
                        <li>Verschiedene Farben</li>
                    </ul>
                </div>

                <div class="product-card">
                    <div class="product-icon">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="32" cy="32" rx="20" ry="8" stroke="currentColor" stroke-width="2" />
                            <path d="M12 32 L12 40 Q12 44 16 44 L48 44 Q52 44 52 40 L52 32" stroke="currentColor"
                                stroke-width="2" />
                        </svg>
                    </div>
                    <h3>Badelatschen</h3>
                    <p>Bedruckte Badelatschen für Sommer-Events, Schwimmbäder und Freizeitaktivitäten.</p>
                    <ul class="product-features">
                        <li>Vollflächiger Druck</li>
                        <li>Rutschfeste Sohle</li>
                        <li>Langlebig</li>
                    </ul>
                </div>

                <div class="product-card">
                    <div class="product-icon">
                        <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="24" y="12" width="16" height="40" rx="2" stroke="currentColor" stroke-width="2" />
                            <circle cx="32" cy="20" r="3" fill="currentColor" />
                        </svg>
                    </div>
                    <h3>Weitere Artikel</h3>
                    <p>Feuerzeuge, Schlüsselanhänger und viele weitere Werbeartikel mit Logo.</p>
                    <ul class="product-features">
                        <li>Große Auswahl</li>
                        <li>Günstige Preise</li>
                        <li>Schnelle Lieferung</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Konfigurator Section -->
    <section id="konfigurator" class="konfigurator-section">
        <div class="container">
            <div class="konfigurator-content">
                <div class="konfigurator-text">
                    <h2>Online-Konfigurator</h2>
                    <p>Gestalte deine Fanartikel ganz einfach selbst mit unserem intuitiven Online-Konfigurator.</p>
                    <ul class="konfigurator-features">
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Freie Farbwahl
                        </li>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Individueller Text
                        </li>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Logo-Upload
                        </li>
                        <li>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Live-Vorschau
                        </li>
                    </ul>
                    <a href="#" class="btn btn-primary">Zum Konfigurator</a>
                </div>
                <div class="konfigurator-image">
                    <div class="konfigurator-placeholder">
                        <svg width="400" height="300" viewBox="0 0 400 300" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f0f0f0" />
                            <text x="200" y="150" text-anchor="middle" fill="#999" font-size="18">Konfigurator
                                Vorschau</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advantages Section -->
    <section class="advantages-section">
        <div class="container">
            <div class="section-header">
                <h2>Warum Deine Fanartikel?</h2>
                <p>Deine Vorteile auf einen Blick</p>
            </div>

            <div class="advantages-grid">
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2" />
                            <path d="M16 24 L22 30 L32 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Ab 5 Stück</h3>
                    <p>Kleine Mindestmengen – perfekt für Vereine und kleine Events</p>
                </div>

                <div class="advantage-card">
                    <div class="advantage-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="12" width="32" height="24" rx="2" stroke="currentColor" stroke-width="2" />
                            <path d="M8 20 L40 20" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <h3>Schnelle Lieferung</h3>
                    <p>Kurze Produktionszeiten für deine individuellen Fanartikel</p>
                </div>

                <div class="advantage-card">
                    <div class="advantage-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 8 L28 20 L40 20 L30 28 L34 40 L24 32 L14 40 L18 28 L8 20 L20 20 Z"
                                stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Top Qualität</h3>
                    <p>Hochwertige Materialien und professioneller Druck</p>
                </div>

                <div class="advantage-card">
                    <div class="advantage-icon">
                        <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24" cy="20" r="8" stroke="currentColor" stroke-width="2" />
                            <path d="M12 40 C12 32 16 28 24 28 C32 28 36 32 36 40" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>Persönliche Beratung</h3>
                    <p>Unser Team hilft dir bei der Gestaltung deiner Fanartikel</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontakt" class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Kontaktiere uns</h2>
                    <p>Hast du Fragen zu unseren Produkten oder benötigst du ein individuelles Angebot? Wir helfen dir
                        gerne weiter!</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 8L10.89 13.26C11.5 13.67 12.5 13.67 13.11 13.26L21 8M5 19H19C20.1 19 21 18.1 21 17V7C21 5.9 20.1 5 19 5H5C3.9 5 3 5.9 3 7V17C3 18.1 3.9 19 5 19Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>info@deine-fanartikel.de</span>
                        </div>
                        <div class="contact-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 16.92V19.92C22 20.51 21.54 21 20.97 21C10.05 21 2 13.95 2 3.03C2 2.46 2.49 2 3.08 2H6.08C6.66 2 7.15 2.47 7.16 3.05C7.18 4.02 7.34 4.96 7.63 5.85C7.78 6.31 7.64 6.82 7.29 7.17L5.62 8.84C7.06 11.6 9.4 13.94 12.16 15.38L13.83 13.71C14.18 13.36 14.69 13.22 15.15 13.37C16.04 13.66 16.98 13.82 17.95 13.84C18.53 13.85 19 14.34 19 14.92V17.92C19 18.51 18.51 19 17.92 19Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>+49 (0) 123 456789</span>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="1" title="Kontaktformular"]'); ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
