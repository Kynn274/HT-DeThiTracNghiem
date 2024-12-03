(function($) {
	'use strict';

	function siteMenuClone() {
		// Clone menu chính vào mobile menu
		const $mobileMenu = $('.site-mobile-menu-body');
		const $mainNav = $('.site-navigation').find('.js-clone-nav');
		console.log($mainNav);
		if (!$mobileMenu.length || !$mainNav.length) return;

		// Tạo mobile nav
		const $mobileNav = $('<ul>').addClass('site-nav-wrap mx-auto fw-bold');
		
		// Clone menu items
		$mainNav.children('li').each(function() {
			$mobileNav.append($(this).clone());
		});

		// Thêm separator
		$('<hr>').css({
			margin: '20px 0',
			borderColor: 'rgba(255,255,255,0.1)'
		}).appendTo($mobileNav);

		// Thêm auth buttons
		const $authButtons = $('<li>').addClass('mobile-auth-buttons');
		
		// Kiểm tra trạng thái đăng nhập
		const $loginBtn = $('.auth-btn.login-btn');
		if ($loginBtn.length) {
			// Chưa đăng nhập
			const $registerBtn = $('.auth-btn.register-btn');
			$authButtons.append(
				$loginBtn.clone(),
				$registerBtn.clone()
			);
		} else {
			// Đã đăng nhập
			const $userInfoBtn = $('.auth-btn.userInfo-btn');
			const $logoutBtn = $('.auth-btn.logout-btn');
			$authButtons.append(
				$userInfoBtn.clone(),
				$logoutBtn.clone()
			);
		}

		// Append vào mobile menu
		$mobileNav.append($authButtons);
		$mobileMenu.append($mobileNav);

		// Setup dropdowns
		setupDropdowns();
		
		// Setup menu toggle
		setupMenuToggle();
	}

	function setupDropdowns() {
		setTimeout(function() {
			$('.site-mobile-menu .has-children').each(function(index) {
				const $menu = $(this);
				const $link = $menu.find('> a');
				const $dropdown = $menu.find('.dropdown');

				// Tạo toggle button
				const $toggleBtn = $('<span>')
					.addClass('arrow-collapse collapsed')
					.attr({
						'data-bs-toggle': 'collapse',
						'data-bs-target': '#collapseItem' + index
					});

				// Setup dropdown
				$dropdown
					.addClass('collapse')
					.attr('id', 'collapseItem' + index);

				// Insert toggle button
				$toggleBtn.insertBefore($link);
			});
		}, 1000);
	}

	function setupMenuToggle() {
		const $toggleBtns = $('.js-menu-toggle');
		const $mobileMenu = $('.site-mobile-menu');

		// Toggle menu khi click button
		$toggleBtns.on('click', function() {
			$('body').toggleClass('offcanvas-menu');
			$toggleBtns.toggleClass('active');
		});

		// Đóng menu khi click outside
		$(document).on('click', function(e) {
			const isClickInside = $mobileMenu.has(e.target).length > 0;
			const isClickOnToggle = $toggleBtns.has(e.target).length > 0;

			if (!isClickInside && !isClickOnToggle && $('body').hasClass('offcanvas-menu')) {
				$('body').removeClass('offcanvas-menu');
				$toggleBtns.removeClass('active');
			}
		});
	}

	// Initialize khi document ready
	$(function() {
		siteMenuClone();
	});

})(jQuery);