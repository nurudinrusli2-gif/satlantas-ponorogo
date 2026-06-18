(function () {
	'use strict';

	var input = document.getElementById('vehicle-search-input');
	var results = document.getElementById('vehicle-search-results');
	var status = document.getElementById('vehicle-search-status');
	var config = window.satlantasVehicleSearch || {};
	var initialResults = results ? results.innerHTML : '';
	var timer = null;
	var controller = null;

	if (!input || !results || !config.ajaxUrl) {
		return;
	}

	function setStatus(message) {
		if (status) {
			status.textContent = message;
		}
	}

	function searchVehicle(query) {
		var data = new FormData();

		if (controller) {
			controller.abort();
		}

		controller = new AbortController();
		data.append('action', 'satlantas_search_vehicle');
		data.append('nonce', config.nonce || '');
		data.append('nomor_polisi', query);
		results.setAttribute('aria-busy', 'true');
		setStatus(config.searching || 'Mencari kendaraan...');

		fetch(config.ajaxUrl, {
			method: 'POST',
			body: data,
			signal: controller.signal,
			credentials: 'same-origin'
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (response) {
				if (!response.success || !response.data || !response.data.html) {
					throw new Error('Invalid search response');
				}

				results.innerHTML = response.data.html;
				setStatus('Hasil pencarian nomor polisi ' + query + ' ditampilkan.');
			})
			.catch(function (error) {
				if ('AbortError' !== error.name) {
					setStatus(config.error || 'Pencarian gagal. Silakan coba lagi.');
				}
			})
			.finally(function () {
				results.removeAttribute('aria-busy');
			});
	}

	input.addEventListener('input', function () {
		var query = input.value.trim();

		window.clearTimeout(timer);

		if (!query) {
			if (controller) {
				controller.abort();
			}

			results.innerHTML = initialResults;
			results.removeAttribute('aria-busy');
			setStatus('');
			return;
		}

		timer = window.setTimeout(function () {
			searchVehicle(query);
		}, 300);
	});
}());
