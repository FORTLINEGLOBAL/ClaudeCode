/**
 * Fortline Theme JavaScript
 *
 * @package Fortline
 */

document.addEventListener('DOMContentLoaded', function() {

	/**
	 * Navigation Scroll Behavior
	 */
	const navbar = document.querySelector('.navbar');
	let lastScrollTop = 0;

	if (navbar) {
		window.addEventListener('scroll', function() {
			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

			if (scrollTop > 80) {
				navbar.classList.add('scrolled');
			} else {
				navbar.classList.remove('scrolled');
			}

			lastScrollTop = scrollTop;
		});
	}

	/**
	 * Mobile Menu Toggle
	 */
	const mobileMenuToggle = document.getElementById('mobileMenuToggle');
	const mobileMenu = document.getElementById('mobileMenu');

	if (mobileMenuToggle) {
		mobileMenuToggle.addEventListener('click', function() {
			navbar.classList.toggle('mobile-open');
		});
	}

	// Close mobile menu when a link is clicked
	if (mobileMenu) {
		const mobileLinks = mobileMenu.querySelectorAll('a');
		mobileLinks.forEach(function(link) {
			link.addEventListener('click', function() {
				navbar.classList.remove('mobile-open');
			});
		});
	}

	/**
	 * Smooth Scroll for Anchor Links
	 */
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			const href = this.getAttribute('href');
			if (href !== '#' && document.querySelector(href)) {
				e.preventDefault();
				const element = document.querySelector(href);
				const offsetTop = element.offsetTop - 100;
				window.scrollTo({
					top: offsetTop,
					behavior: 'smooth'
				});
			}
		});
	});

	/**
	 * Fade-in on Scroll using IntersectionObserver
	 */
	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -100px 0px'
	};

	const observer = new IntersectionObserver(function(entries) {
		entries.forEach(function(entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('fade-in');
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	// Observe all post cards for fade-in effect
	document.querySelectorAll('.post-card').forEach(function(card) {
		card.style.opacity = '0';
		observer.observe(card);
	});

	/**
	 * Search Form
	 */
	const searchForm = document.querySelector('.search-form');
	if (searchForm) {
		const searchInput = searchForm.querySelector('input[type="search"]');
		if (searchInput) {
			searchInput.addEventListener('focus', function() {
				searchForm.style.boxShadow = '0 0 0 3px rgba(37, 99, 235, 0.1)';
			});

			searchInput.addEventListener('blur', function() {
				searchForm.style.boxShadow = 'none';
			});
		}
	}

	/**
	 * Set active nav links
	 */
	const currentUrl = window.location.pathname;
	document.querySelectorAll('.navbar a').forEach(function(link) {
		if (link.pathname === currentUrl) {
			link.classList.add('current');
		}
	});

});
