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

  // === Collection Page Filters ===

  // Filter toggle for mobile
  var filterToggle = document.getElementById('filter-toggle-mobile');
  var filterContent = document.getElementById('filter-content');

  if (filterToggle && filterContent) {
    filterToggle.addEventListener('click', function () {
      filterContent.classList.toggle('active');
      var icon = filterToggle.querySelector('.material-symbols-outlined');
      if (icon) {
        icon.textContent = filterContent.classList.contains('active') ? 'close' : 'tune';
      }
    });
  }

  // Filter group collapse/expand
  var filterGroups = document.querySelectorAll('.filter-group');
  filterGroups.forEach(function (group) {
    var header = group.querySelector('.filter-group-header');
    var content = group.querySelector('.filter-group-content');
    var icon = group.querySelector('.toggle-icon');

    if (header && content) {
      header.addEventListener('click', function () {
        group.classList.toggle('collapsed');

        if (group.classList.contains('collapsed')) {
          content.style.display = 'none';
          if (icon) icon.textContent = 'add';
        } else {
          content.style.display = 'block';
          if (icon) icon.textContent = 'remove';
        }
      });
    }
  });

  // Filter checkbox auto-submit
  var filterCheckboxes = document.querySelectorAll('.filter-checkbox input[type="checkbox"]');
  filterCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      var filterType = this.getAttribute('data-filter-type');
      var filterValue = this.value;
      var url = new URL(window.location.href);
      var paramKey = filterType + '[]';

      // Get current values for this filter type
      var currentValues = url.searchParams.getAll(paramKey);

      // Clear all values for this filter type first
      url.searchParams.delete(paramKey);

      if (this.checked) {
        // Add the new value and all existing values
        currentValues.forEach(function (val) {
          url.searchParams.append(paramKey, val);
        });
        if (currentValues.indexOf(filterValue) === -1) {
          url.searchParams.append(paramKey, filterValue);
        }
      } else {
        // Add back all values except the unchecked one
        currentValues.forEach(function (val) {
          if (val !== filterValue) {
            url.searchParams.append(paramKey, val);
          }
        });
      }

      // Reset to first page when filtering
      url.searchParams.delete('paged');

      window.location.href = url.toString();
    });
  });

  // Quick Add button functionality
  var quickAddBtns = document.querySelectorAll('.quick-add-btn');
  quickAddBtns.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var productId = this.getAttribute('data-product-id');
      if (!productId || typeof wotData === 'undefined') return;

      var button = this;
      button.disabled = true;

      fetch(wotData.ajaxUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'wot_add_to_cart',
          nonce: wotData.nonce,
          product_id: productId,
          quantity: 1
        })
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (data) {
          if (data.success) {
            // Update cart count if element exists
            var cartCount = document.querySelector('.cart-count');
            if (cartCount && data.data.cart_count) {
              cartCount.textContent = data.data.cart_count;
            }

            // Visual feedback
            var icon = button.querySelector('.material-symbols-outlined');
            if (icon) {
              icon.textContent = 'check';
              setTimeout(function () {
                icon.textContent = 'add_shopping_cart';
              }, 1500);
            }
          }
          button.disabled = false;
        })
        .catch(function () {
          button.disabled = false;
        });
    });
  });

  // Quick Add overlay click
  var quickAddOverlays = document.querySelectorAll('.quick-add-overlay');
  quickAddOverlays.forEach(function (overlay) {
    overlay.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var card = this.closest('.collection-product-card');
      var quickAddBtn = card ? card.querySelector('.quick-add-btn') : null;
      if (quickAddBtn) {
        quickAddBtn.click();
      }
    });
  });

  /* Checkout Confirmation Modal - Moved to plugin: wc-order-confirmation-modal */

})();
