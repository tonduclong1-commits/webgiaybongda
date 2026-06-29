// MAIN.JS - Client-side interactivity and form validation

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Size Picker Interactivity on Detail Page
    const sizeButtons = document.querySelectorAll('.size-btn');
    const selectedSizeInput = document.getElementById('selected-size');
    
    if (sizeButtons.length > 0 && selectedSizeInput) {
        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                sizeButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Set the value in hidden input field
                selectedSizeInput.value = this.getAttribute('data-size');
            });
        });
    }

    // 2. Alert message auto-close
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);
    }

    // 3. Register form client-side validation
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const user = document.getElementById('user').value.trim();
            const email = document.getElementById('email').value.trim();
            const pass = document.getElementById('pass').value;
            const repass = document.getElementById('repass').value;
            const phone = document.getElementById('dien_thoai').value.trim();
            
            let errors = [];

            if (user.length < 3) {
                errors.push('Tên đăng nhập phải chứa ít nhất 3 ký tự.');
            }

            if (email === '') {
                errors.push('Vui lòng nhập địa chỉ Email.');
            } else if (!validateEmail(email)) {
                errors.push('Địa chỉ Email không đúng định dạng.');
            }

            if (phone === '') {
                errors.push('Vui lòng nhập số điện thoại.');
            } else if (!validatePhone(phone)) {
                errors.push('Số điện thoại không hợp lệ (phải có 10 chữ số bắt đầu bằng 03, 05, 07, 08 hoặc 09).');
            }

            if (pass.length < 6) {
                errors.push('Mật khẩu phải chứa ít nhất 6 ký tự.');
            }

            if (pass !== repass) {
                errors.push('Mật khẩu nhập lại không trùng khớp.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                showClientAlert(errors.join('<br>'), 'danger');
            }
        });
    }

    // 4. Login form client-side validation
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const user = document.getElementById('user').value.trim();
            const pass = document.getElementById('pass').value;

            let errors = [];

            if (user === '') {
                errors.push('Vui lòng nhập tên đăng nhập.');
            }
            if (pass === '') {
                errors.push('Vui lòng nhập mật khẩu.');
            }

            if (errors.length > 0) {
                e.preventDefault();
                showClientAlert(errors.join('<br>'), 'danger');
            }
        });
    }

    // 5. Contact form submission confirmation
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // Form is static, let's show success confirmation
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            if (name === '' || email === '' || message === '') {
                e.preventDefault();
                showClientAlert('Vui lòng điền đầy đủ tất cả các trường thông tin.', 'danger');
            } else if (!validateEmail(email)) {
                e.preventDefault();
                showClientAlert('Địa chỉ Email không hợp lệ.', 'danger');
            } else {
                // If backend processing is not implemented, we can let it submit or mock it
                // We have a PHP action, so we let it submit.
            }
        });
    }

    // 6. Homepage Hero Banner Slider Carousel
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');
    let currentSlide = 0;
    let slideInterval;

    if (slides.length > 0) {
        function showSlide(index) {
            if (index >= slides.length) currentSlide = 0;
            else if (index < 0) currentSlide = slides.length - 1;
            else currentSlide = index;

            slides.forEach((slide, i) => {
                if (i === currentSlide) {
                    slide.classList.add('active');
                    slide.style.opacity = '1';
                    slide.style.zIndex = '2';
                } else {
                    slide.classList.remove('active');
                    slide.style.opacity = '0';
                    slide.style.zIndex = '1';
                }
            });

            dots.forEach((dot, i) => {
                if (i === currentSlide) {
                    dot.classList.add('active');
                    dot.style.width = '24px';
                    dot.style.backgroundColor = 'var(--primary)';
                } else {
                    dot.classList.remove('active');
                    dot.style.width = '12px';
                    dot.style.backgroundColor = 'rgba(255,255,255,0.4)';
                }
            });
        }

        function startSlideShow() {
            slideInterval = setInterval(() => {
                showSlide(currentSlide + 1);
            }, 5000);
        }

        function resetSlideShow() {
            clearInterval(slideInterval);
            startSlideShow();
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                showSlide(currentSlide + 1);
                resetSlideShow();
            });
        }
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                showSlide(currentSlide - 1);
                resetSlideShow();
            });
        }

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                showSlide(i);
                resetSlideShow();
            });
        });

        startSlideShow();
    }

    // 7. Homepage Dynamic Category Tabs Switcher
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    if (tabButtons.length > 0) {
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                tabButtons.forEach(button => button.classList.remove('active'));
                tabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    pane.style.display = 'none';
                });

                this.classList.add('active');

                const targetPane = document.getElementById(`tab-${targetTab}`);
                if (targetPane) {
                    targetPane.classList.add('active');
                    targetPane.style.display = 'block';
                }
            });
        });
    }

    // Helper functions
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        const re = /^(0[3|5|7|8|9])+([0-9]{8})$/;
        return re.test(phone);
    }

    function showClientAlert(message, type) {
        // Remove existing client alerts
        const existingAlert = document.getElementById('client-alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.id = 'client-alert';
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = message;

        const container = document.querySelector('.auth-card') || document.querySelector('.info-layout');
        if (container) {
            const firstChild = container.querySelector('.auth-header') || container.querySelector('.info-header') || container.firstChild;
            firstChild.parentNode.insertBefore(alertDiv, firstChild.nextSibling);
            
            // Auto close after 4s
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.5s ease';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 4000);
        }
    }

    // 8. Countdown Timer Logic for Deal Tốt - Giá Hời
    const hoursEl = document.getElementById('hours');
    const minutesEl = document.getElementById('minutes');
    const secondsEl = document.getElementById('seconds');

    if (hoursEl && minutesEl && secondsEl) {
        function updateCountdown() {
            const now = new Date();
            const tomorrow = new Date();
            tomorrow.setHours(24, 0, 0, 0); // Count down to the end of today

            const diff = tomorrow - now;

            const h = Math.floor(diff / (1000 * 60 * 60));
            const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((diff % (1000 * 60)) / 1000);

            hoursEl.textContent = h.toString().padStart(2, '0');
            minutesEl.textContent = m.toString().padStart(2, '0');
            secondsEl.textContent = s.toString().padStart(2, '0');
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // 9. Hot Deals Tab Switcher
    const dealTabButtons = document.querySelectorAll('.deal-tab-btn');
    const dealTabPanes = document.querySelectorAll('.deal-tab-pane');

    if (dealTabButtons.length > 0) {
        dealTabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-deal-tab');

                dealTabButtons.forEach(button => button.classList.remove('active'));
                dealTabPanes.forEach(pane => {
                    pane.classList.remove('active');
                    pane.style.display = 'none';
                });

                this.classList.add('active');

                const targetPane = document.getElementById(`deal-pane-${targetTab}`);
                if (targetPane) {
                    targetPane.classList.add('active');
                    targetPane.style.display = 'block';
                }
            });
        });
    }

    // 10. Color Swatch Selector
    const swatchDots = document.querySelectorAll('.swatch-dot');
    if (swatchDots.length > 0) {
        swatchDots.forEach(dot => {
            dot.addEventListener('click', function() {
                const parent = this.parentElement;
                const dotsInParent = parent.querySelectorAll('.swatch-dot');
                dotsInParent.forEach(d => {
                    d.classList.remove('active');
                    d.style.border = '2px solid #fff';
                    d.style.outline = '1px solid #cbd5e1';
                });

                this.classList.add('active');
                this.style.border = '2px solid #ef4444';
                this.style.outline = '1px solid #cbd5e1';
                this.style.outlineOffset = '1px';
            });
        });
    }

    // 11. Click Toggle Dropdown Menu for Touch/Mobile support (multiple dropdowns)
    const dropdownItems = document.querySelectorAll('.has-dropdown');

    if (dropdownItems.length > 0) {
        dropdownItems.forEach(item => {
            const dropdownLink = item.querySelector('a');
            const dropdownArrow = item.querySelector('.fa-angle-down');
            const dropdownMenu = item.querySelector('.dropdown');

            if (dropdownLink && dropdownMenu) {
                // Toggle when clicking the arrow specifically
                if (dropdownArrow) {
                    dropdownArrow.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        // Close other dropdowns first
                        dropdownItems.forEach(otherItem => {
                            if (otherItem !== item) {
                                const otherMenu = otherItem.querySelector('.dropdown');
                                const otherArrow = otherItem.querySelector('.fa-angle-down');
                                if (otherMenu) otherMenu.classList.remove('open');
                                if (otherArrow) otherArrow.classList.remove('rotate');
                            }
                        });
                        dropdownMenu.classList.toggle('open');
                        this.classList.toggle('rotate');
                    });
                }

                // On mobile view, first click on main link toggles dropdown, second click navigates
                dropdownLink.addEventListener('click', function(e) {
                    if (window.innerWidth <= 992) {
                        if (!dropdownMenu.classList.contains('open')) {
                            e.preventDefault();
                            // Close other dropdowns first
                            dropdownItems.forEach(otherItem => {
                                if (otherItem !== item) {
                                    const otherMenu = otherItem.querySelector('.dropdown');
                                    const otherArrow = otherItem.querySelector('.fa-angle-down');
                                    if (otherMenu) otherMenu.classList.remove('open');
                                    if (otherArrow) otherArrow.classList.remove('rotate');
                                }
                            });
                            dropdownMenu.classList.add('open');
                            if (dropdownArrow) dropdownArrow.classList.add('rotate');
                        }
                    }
                });
            }
        });

        // Close all dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.has-dropdown')) {
                dropdownItems.forEach(item => {
                    const dropdownMenu = item.querySelector('.dropdown');
                    const dropdownArrow = item.querySelector('.fa-angle-down');
                    if (dropdownMenu) dropdownMenu.classList.remove('open');
                    if (dropdownArrow) dropdownArrow.classList.remove('rotate');
                });
            }
        });
    }

    // 12. Toggle Sidebar Category Menu in Shop Page
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarMenu = document.getElementById('sidebar-menu');
    const sidebarArrow = document.querySelector('#sidebar-toggle .sidebar-arrow');

    if (sidebarToggle && sidebarMenu) {
        // Automatically start collapsed on small screens (mobile/tablet)
        if (window.innerWidth <= 992) {
            sidebarMenu.classList.add('collapsed');
            if (sidebarArrow) {
                sidebarArrow.classList.remove('fa-angle-up');
                sidebarArrow.classList.add('fa-angle-down');
            }
        }

        sidebarToggle.addEventListener('click', function() {
            const isCollapsed = sidebarMenu.classList.toggle('collapsed');
            if (sidebarArrow) {
                if (isCollapsed) {
                    sidebarArrow.classList.remove('fa-angle-up');
                    sidebarArrow.classList.add('fa-angle-down');
                } else {
                    sidebarArrow.classList.remove('fa-angle-down');
                    sidebarArrow.classList.add('fa-angle-up');
                }
            }
        });
    }

    // 13. Toggle Sidebar Brand Menu in Shop Page
    const brandToggle = document.getElementById('brand-toggle');
    const brandMenu = document.getElementById('brand-menu');
    const brandArrow = document.querySelector('#brand-toggle .sidebar-arrow');

    if (brandToggle && brandMenu) {
        // Automatically start collapsed on small screens (mobile/tablet)
        if (window.innerWidth <= 992) {
            brandMenu.classList.add('collapsed');
            if (brandArrow) {
                brandArrow.classList.remove('fa-angle-up');
                brandArrow.classList.add('fa-angle-down');
            }
        }

        brandToggle.addEventListener('click', function() {
            const isCollapsed = brandMenu.classList.toggle('collapsed');
            if (brandArrow) {
                if (isCollapsed) {
                    brandArrow.classList.remove('fa-angle-up');
                    brandArrow.classList.add('fa-angle-down');
                } else {
                    brandArrow.classList.remove('fa-angle-down');
                    brandArrow.classList.add('fa-angle-up');
                }
            }
        });
    }

});

