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
		$('.site-mobile-menu .has-children').each(function(index) {
			const $menu = $(this);
			const $link = $menu.find('> a');
			const $dropdown = $menu.find('.dropdown');

			// Tạo toggle button
			const $toggleBtn = $('<span>')
				.addClass('arrow-collapse collapsed rotate-180')
				.attr({
					'data-bs-toggle': 'collapse',
					'data-bs-target': '#collapseItem' + index
				});

			// Setup dropdown
			$dropdown
				.addClass('collapse')
				.attr('id', 'collapseItem' + index);

			// Insert toggle button
			$toggleBtn.insertBefore($link)
		});
		$('.arrow-collapse').click(function() {
			if($(this).hasClass('active')){
				$(this).removeClass('active rotate-180');
				$(this).parent().find('.dropdown').slideUp(200);
			} else {
				$(this).addClass('active rotate-180');
				$(this).parent().find('.dropdown').slideDown(200);
			}
		});
	}

	function setupMenuToggle() {
		const $toggleBtns = $('.open-menu');
		const $mobileMenu = $('.site-mobile-menu');
		const closeMenu = $('.close-menu');
		$toggleBtns.click(function() {
			$('body').toggleClass('offcanvas-menu');
			closeMenu.toggleClass('active');
		});
		closeMenu.click(function() {
			$('body').removeClass('offcanvas-menu');
			$(this).removeClass('active');
		});
	}

	// Initialize khi document ready
	$(function() {
		siteMenuClone();
	});

})(jQuery);