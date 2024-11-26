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

	//
});
document.addEventListener('DOMContentLoaded', () => {
	const currentPage = window.location.pathname.split('/').pop(); // Pobierz nazwę bieżącej strony, dzieli po /link i pop() zwraca ostani elemeny czyli nasz href
	const navLinks = document.querySelectorAll('.nav__links__item');

	navLinks.forEach((link) => {
		if (link.getAttribute('href') === currentPage) {
			link.classList.add('active');
		}
	});
});
// na mobile
document.addEventListener('DOMContentLoaded', () => {
	const currentPage = window.location.pathname.split('/').pop(); // Pobierz nazwę bieżącej strony, dzieli po /link i pop() zwraca ostani elemeny czyli nasz href
	const navLinks = document.querySelectorAll('.nav__links__mobile-item');

	navLinks.forEach((link) => {
		if (link.getAttribute('href') === currentPage) {
			link.classList.add('active');
		}
	});
});
