document.addEventListener('DOMContentLoaded', function () {
	const burger = document.querySelector('.burger');
	const close = document.querySelector('.close');
	const navLinks = document.querySelector('.nav__links__mobile');

	burger.addEventListener('click', () => {
		setTimeout(() => {
			navLinks.classList.toggle('nav__links__mobile-active');
		}, 500);
	});
	close.addEventListener('click', () => {
		setTimeout(() => {
			navLinks.classList.toggle('nav__links__mobile-active');
		}, 500);
	});

	const footerBTn = document.getElementById('footerBTN');
	footerBTn.addEventListener('click', () => {
		window.scrollTo({ top: 0, behavior: 'smooth' });
	});
	//
});
