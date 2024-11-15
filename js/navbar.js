(function(){
	'use strict'

	var siteMenuClone = function() {
		var jsCloneNavs = document.querySelectorAll('.js-clone-nav>li')
		var siteMobileMenuBody = document.querySelector('.site-mobile-menu-body');
		var newNavWrap = document.createElement('ul');
		newNavWrap.classList.add('site-nav-wrap', 'mx-auto', 'fw-bold');
		// Clone menu
		jsCloneNavs.forEach(nav => {
			var navCloned = nav.cloneNode(true);
			console.log(navCloned);
			newNavWrap.appendChild(navCloned);
		});
		var separator = document.createElement('hr');
			separator.style.margin = '20px 0';
			separator.style.borderColor = 'rgba(255,255,255,0.1)';
			newNavWrap.appendChild(separator);

		var CloneButtons = document.createElement('li');
			CloneButtons.classList.add('mobile-auth-buttons');

		var loginBtn = document.querySelector('.auth-btn.login-btn');
		if(loginBtn){
			loginBtnClone = loginBtn.cloneNode(true);
			CloneButtons.appendChild(loginBtn);
			var registerBtn = document.querySelector('.auth-btn.register-btn').cloneNode(true);
			CloneButtons.appendChild(registerBtn);
		}else{
			var userInfoBtn = document.querySelector('.auth-btn.userInfo-btn').cloneNode(true);
			CloneButtons.appendChild(userInfoBtn);
			var logoutBtn = document.querySelector('.auth-btn.logout-btn').cloneNode(true);
			CloneButtons.appendChild(logoutBtn);
		}
		// var loginBtn = document.querySelector('.auth-btn.login-btn').cloneNode(true);
		// CloneButtons.appendChild(loginBtn);
		// var registerBtn = document.querySelector('.auth-btn.register-btn').cloneNode(true);
		// CloneButtons.appendChild(registerBtn);
		
		newNavWrap.appendChild(CloneButtons);
		siteMobileMenuBody.appendChild(newNavWrap);

		setTimeout(function(){
			var hasChildrens = document.querySelector('.site-mobile-menu').querySelectorAll(' .has-children');

			var counter = 0;
			hasChildrens.forEach( hasChild => {
				var refEl = hasChild.querySelector('a');
				var newElSpan = document.createElement('span');
				newElSpan.setAttribute('class', 'arrow-collapse collapsed');
				
				hasChild.insertBefore(newElSpan, refEl);

				var arrowCollapse = hasChild.querySelector('.arrow-collapse');
				arrowCollapse.setAttribute('data-bs-toggle', 'collapse');
				arrowCollapse.setAttribute('data-bs-target', '#collapseItem' + counter);

				var dropdown = hasChild.querySelector('.dropdown');
				dropdown.setAttribute('class', 'collapse');
				dropdown.setAttribute('id', 'collapseItem' + counter);

				counter++;
			});
		}, 1000);


		var menuToggle = document.querySelectorAll(".js-menu-toggle");
		var mTog;
		menuToggle.forEach(mtoggle => {
			mTog = mtoggle;
			mtoggle.addEventListener("click", (e) => {
				if ( document.body.classList.contains('offcanvas-menu') ) {
					document.body.classList.remove('offcanvas-menu');
					mtoggle.classList.remove('active');
					mTog.classList.remove('active');
				} else {
					document.body.classList.add('offcanvas-menu');
					mtoggle.classList.add('active');
					mTog.classList.add('active');
				}
			});
		})

		var specifiedElement = document.querySelector(".site-mobile-menu");
		var mt, mtoggleTemp;
		document.addEventListener('click', function(event) {
			var isClickInside = specifiedElement.contains(event.target);
			menuToggle.forEach(mtoggle => {
				mtoggleTemp = mtoggle
				mt = mtoggle.contains(event.target);
			})

			if (!isClickInside && !mt) {
				if ( document.body.classList.contains('offcanvas-menu') ) {
					document.body.classList.remove('offcanvas-menu');
					mtoggleTemp.classList.remove('active');
				}
			}
		});
	}; 
	siteMenuClone();
})()