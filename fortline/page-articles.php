<?php
/**
 * Template Name: Articles
 * Description: Articles page
 */

get_header(); ?>

<style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #ffffff;
            --bg-light: #f7f8fa;
            --bg-section: #f0f2f5;
            --bg-dark: #0a1628;
            --gold: #1e3a5f;
            --gold-light: #2563eb;
            --gold-bright: #3b82f6;
            --text-dark: #111827;
            --text-mid: #374151;
            --text-light: #6b7280;
            --border: #e5e7eb;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-body);
            color: var(--text-dark);
            background: var(--bg);
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        nav .logo {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--gold);
        }

        nav .menu {
            display: flex;
            gap: 2rem;
            align-items: center;
            list-style: none;
        }

        nav a {
            text-decoration: none;
            color: var(--text-mid);
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--gold);
        }

        nav .nav-cta {
            background: var(--gold);
            color: var(--bg) !important;
            padding: 0.6rem 1.4rem;
            border-radius: 0.5rem;
            font-weight: 600;
        }

        nav .nav-cta:hover {
            background: var(--gold-light);
            color: var(--bg) !important;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 0.4rem;
        }

        .hamburger span {
            width: 24px;
            height: 2px;
            background: var(--text-dark);
            transition: 0.3s;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--bg);
            padding: 8rem 2rem 4rem;
            text-align: center;
            margin-top: 70px;
        }

        .hero h1 {
            font-family: var(--font-heading);
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.25rem;
            opacity: 0.95;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Articles Grid */
        .articles-section {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            margin-top: 3rem;
        }

        .article-card {
            background: var(--bg-light);
            border-radius: 0.75rem;
            padding: 2rem;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            border-color: var(--gold-light);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.1);
            transform: translateY(-2px);
        }

        .article-tag {
            display: inline-block;
            background: var(--gold-bright);
            color: var(--bg);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            margin-bottom: 1rem;
            width: fit-content;
        }

        .article-card h3 {
            font-family: var(--font-heading);
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .article-card p {
            color: var(--text-mid);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .article-card a {
            display: inline-block;
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .article-card a:hover {
            color: var(--gold-light);
            transform: translateX(4px);
        }

        /* Footer */
        footer {
            background: var(--bg-dark);
            color: var(--bg);
            padding: 4rem 2rem 2rem;
            margin-top: 6rem;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-col h4 {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col li {
            margin-bottom: 0.8rem;
        }

        .footer-col a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .footer-col a:hover {
            color: var(--gold-bright);
        }

        .footer-logo {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold-bright);
            margin-bottom: 0.5rem;
        }

        .footer-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem;
            }

            nav .menu {
                display: none;
            }

            nav .menu.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: var(--bg);
                border-bottom: 1px solid var(--border);
                padding: 1rem;
                gap: 0.5rem;
            }

            nav .menu.open a {
                padding: 0.8rem;
            }

            .hamburger {
                display: flex;
            }

            .hero {
                padding: 6rem 1.5rem 3rem;
                margin-top: 70px;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .articles-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    
</style>


    <!-- Navigation -->
    <nav>
        <div class="logo">Fortline</div>
        <ul class="menu">
            <li><a href="<?php echo home_url('/'); ?>#pillars">Solutions</a></li>
            <li><a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a></li>
            <li><a href="<?php echo home_url('/execution/'); ?>">Execution</a></li>
            <li><a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a></li>
            <li><a href="<?php echo home_url('/unique-technology/'); ?>">Unique Tech</a></li>
            <li><a href="shield6000.html#mg6000">Technology</a></li>
            <li><a href="<?php echo home_url('/customers/'); ?>">Who We Serve</a></li>
            <li><a href="<?php echo home_url('/about/'); ?>">About</a></li>
            <li><a href="<?php echo home_url('/articles/'); ?>">Articles</a></li>
<div id="lang-toggle"></div>
            <li><a href="<?php echo home_url('/customers/'); ?>#contact" class="nav-cta">Contact Us</a></li>
        </ul>
        <div class="hamburger" onclick="document.querySelector('.menu').classList.toggle('open')">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Insights & Analysis</h1>
        <p>Thought leadership on defense protection, infrastructure resilience, and the future of civil security across the Gulf region and beyond.</p>
    </section>

    <!-- Articles Grid -->
    <section class="articles-section">
        <div class="articles-grid">
            <!-- Article 1 -->
            <div class="article-card">
                <span class="article-tag">Critical Infrastructure Protection UAE</span>
                <h3>Why Critical Infrastructure Protection in the UAE Demands a New Approach</h3>
                <p>The UAE's rapid development creates unprecedented infrastructure exposure. Discover why traditional perimeter security is no longer sufficient against modern threats, and what the missing layer looks like.</p>
                <div class="article-meta">
                    <span>April 2026</span>
                    <span>8 min read</span>
                </div>
                <a href="<?php echo home_url('/article-critical-infrastructure-uae/'); ?>">Read Article -></a>
            </div>

            <!-- Article 2 -->
            <div class="article-card">
                <span class="article-tag">Blast Resistant Building Fortification</span>
                <h3>Blast-Resistant Building Fortification: What Gulf States Can Learn from 30 Years of Civil Defense Doctrine</h3>
                <p>The world's most battle-tested civil defense programs have perfected mandatory protection standards. Explore how Gulf states can leapfrog traditional methods and adopt proven fortification strategies.</p>
                <div class="article-meta">
                    <span>April 2026</span>
                    <span>9 min read</span>
                </div>
                <a href="<?php echo home_url('/article-blast-resistant-fortification/'); ?>">Read Article -></a>
            </div>

            <!-- Article 3 -->
            <div class="article-card">
                <span class="article-tag">Safe Room Retrofit Technology</span>
                <h3>Safe Room Retrofit Technology: Converting Any Existing Space into a Certified Protected Zone</h3>
                <p>Converting existing buildings into protected spaces doesn't require costly reconstruction. Learn how spray-applied fortification technology creates defense-grade protection in days, not months.</p>
                <div class="article-meta">
                    <span>April 2026</span>
                    <span>8 min read</span>
                </div>
                <a href="<?php echo home_url('/article-safe-room-retrofit/'); ?>">Read Article -></a>
            </div>

            <!-- Article 4 -->
            <div class="article-card">
                <span class="article-tag">Passive Protection Defense GCC</span>
                <h3>The Case for Passive Protection: Why GCC Defense Strategies Must Go Beyond Active Systems</h3>
                <p>Active defense systems alone cannot protect against all threats. Understand why passive protection is the critical complementary layer that leading defense nations rely on.</p>
                <div class="article-meta">
                    <span>April 2026</span>
                    <span>9 min read</span>
                </div>
                <a href="<?php echo home_url('/article-passive-protection-gcc/'); ?>">Read Article -></a>
            </div>

            <!-- Article 5 -->
            <div class="article-card">
                <span class="article-tag">Building Fortification Qatar</span>
                <h3>Qatar's Infrastructure Moment: How Spray-Applied Fortification Systems Protect What Matters Most</h3>
                <p>Qatar's post-World Cup infrastructure legacy and strategic assets demand specialized protection. Explore how spray-applied systems deliver climate-adapted resilience in record time.</p>
                <div class="article-meta">
                    <span>April 2026</span>
                    <span>8 min read</span>
                </div>
                <a href="<?php echo home_url('/article-qatar-infrastructure/'); ?>">Read Article -></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">Fortline</div>
                <p class="footer-desc">Advanced protection systems for critical infrastructure across the Middle East and beyond. Defense-certified, battle-tested, mission-ready.</p>
            </div>
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul>
                    <li><a href="<?php echo home_url('/'); ?>#pillars">Our Approach</a></li>
                    <li><a href="<?php echo home_url('/facility-assessment/'); ?>">Protection Advisory</a></li>
                    <li><a href="<?php echo home_url('/execution/'); ?>">Execution</a></li>
                    <li><a href="<?php echo home_url('/national-planning/'); ?>">National Regulation</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo home_url('/about/'); ?>">About Us</a></li>
                    <li><a href="<?php echo home_url('/articles/'); ?>">Articles</a></li>
                    <li><a href="<?php echo home_url('/customers/'); ?>">Who We Serve</a></li>
                    <li><a href="<?php echo home_url('/customers/'); ?>#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Get In Touch</h4>
                <p class="footer-desc">Ready to discuss your infrastructure protection requirements.</p>
                <a href="<?php echo home_url('/customers/'); ?>#contact" style="color: var(--gold-bright); font-weight: 600; text-decoration: none;">Contact Us</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Fortline Global. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.querySelectorAll('.menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelector('.menu').classList.remove('open');
            });
        });
    </script>


<script>
        document.querySelectorAll('.menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelector('.menu').classList.remove('open');
            });
        });
    </script>

<?php get_footer(); ?>