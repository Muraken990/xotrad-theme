/**
 * World One Trading - Theme JavaScript
 */

(function () {
  'use strict';

  // === Theme Toggle ===
  const themeToggle = document.getElementById('theme-toggle');
  const html = document.documentElement;

  function setTheme(theme) {
    if (theme === 'light') {
      html.setAttribute('data-theme', 'light');
    } else {
      html.removeAttribute('data-theme');
    }
    localStorage.setItem('wot-theme', theme);
  }

  // Initialize: default to dark
  var stored = localStorage.getItem('wot-theme');
  if (stored === 'light') {
    setTheme('light');
  }

  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      var current = html.getAttribute('data-theme');
      setTheme(current === 'light' ? 'dark' : 'light');
    });
  }

  // === Mobile Menu ===
  var mobileMenuBtn = document.getElementById('mobile-menu-btn');
  var mobileNav = document.getElementById('mobile-nav');

  if (mobileMenuBtn && mobileNav) {
    mobileMenuBtn.addEventListener('click', function () {
      mobileNav.classList.toggle('active');
      document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
    });

    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('active');
        document.body.style.overflow = '';
      });
    });
  }

  // === Sticky Header Shadow ===
  var header = document.getElementById('site-header');

  window.addEventListener('scroll', function () {
    if (header) {
      if (window.scrollY > 50) {
        header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.3)';
      } else {
        header.style.boxShadow = 'none';
      }
    }
  });

})();
