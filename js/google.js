document.addEventListener('DOMContentLoaded', function () {
	const slider = document.getElementById('slider');
	let currentIndex = 0; // Aktualny indeks slidera

	// Funkcja dynamicznego ładowania recenzji i wyświetlania średniej oceny
	function initMap() {
		const placeId = 'ChIJbwbImAoDekgRV_oO_zRYvck'; // Twoje Place ID
		const service = new google.maps.places.PlacesService(
			document.createElement('div')
		);

		service.getDetails({ placeId }, (place, status) => {
			if (status === google.maps.places.PlacesServiceStatus.OK) {
				// Wyświetlanie średniej oceny i liczby recenzji
				const averageRating = place.rating; // Średnia ocena
				const totalReviews = place.user_ratings_total; // Liczba wszystkich recenzji
				const reviewsSummary = document.getElementById('reviews-summary');

				reviewsSummary.innerHTML = `
					<p>
						Average rating from 
						<img src="img/google.png" class="review__img"/>  
						<strong>${averageRating.toFixed(1)} of 5</strong>, 
						based on <strong>${totalReviews} reviews</strong>
					</p>`;

				// Dodawanie recenzji do slidera
				place.reviews.forEach((review) => {
					const stars =
						'★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
					const reviewElement = document.createElement('div');
					reviewElement.className = 'slide';

					reviewElement.innerHTML = `
						<img src="${
							review.profile_photo_url || 'https://via.placeholder.com/80'
						}" alt="${review.author_name}">
						<strong>${review.author_name}</strong>
						<div class="stars">${stars}</div>
						<p>${review.text}</p>
						<small>${new Date(review.time * 1000).toLocaleDateString()}</small>
						<a href="https://www.google.com/maps/place/?q=place_id:${placeId}" 
							class="read-more" 
							target="_blank">Full Review &nbsp;<i class="fa-solid fa-arrow-right ml"></i>
						</a>
					`;

					slider.appendChild(reviewElement);
				});

				// Zainicjuj slider
				updateSlider();
			} else {
				console.error('Błąd podczas pobierania szczegółów miejsca:', status);
			}
		});
	}

	// Funkcja aktualizacji pozycji slidera
	function updateSlider() {
		const slideWidth = slider.children[0]?.offsetWidth || 0; // Pobierz szerokość slajdu
		slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
	}

	// Funkcja do przesuwania w prawo
	function nextSlide() {
		const totalSlides = slider.children.length;

		if (currentIndex < totalSlides - 1) {
			currentIndex++;
		} else {
			currentIndex = 0; // Powrót do początku
		}
		updateSlider();
	}

	// Funkcja do przesuwania w lewo
	function prevSlide() {
		const totalSlides = slider.children.length;

		if (currentIndex > 0) {
			currentIndex--;
		} else {
			currentIndex = totalSlides - 1; // Przejście do ostatniego slajdu
		}
		updateSlider();
	}

	// Przypisanie funkcji `nextSlide` i `prevSlide` do przycisków
	document.querySelector('.arrow.right')?.addEventListener('click', nextSlide);
	document.querySelector('.arrow.left')?.addEventListener('click', prevSlide);

	// Przypisanie funkcji initMap do globalnego kontekstu (dla Google Maps API)
	window.initMap = initMap;
});
