(function () {
	'use strict';

	var config = window.satlantasVisitorCounter || {};
	var fields = {
		today: document.querySelector('[data-visitor-count="today"]'),
		month: document.querySelector('[data-visitor-count="month"]'),
		total: document.querySelector('[data-visitor-count="total"]')
	};

	if (!config.ajaxUrl || !fields.today || !fields.month || !fields.total) {
		return;
	}

	function updateCounter(recordVisit) {
		var data = new FormData();

		data.append('action', 'satlantas_visitor_counter');
		data.append('nonce', config.nonce || '');
		data.append('record', recordVisit ? '1' : '0');

		fetch(config.ajaxUrl, {
			method: 'POST',
			body: data,
			credentials: 'same-origin'
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (response) {
				if (!response.success || !response.data) {
					return;
				}

				fields.today.textContent = response.data.today;
				fields.month.textContent = response.data.month;
				fields.total.textContent = response.data.total;
			})
			.catch(function () {
				// Keep the server-rendered values when the live request fails.
			});
	}

	updateCounter(true);
	window.setInterval(function () {
		updateCounter(false);
	}, 30000);
}());
