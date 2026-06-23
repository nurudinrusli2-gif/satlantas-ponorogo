(function () {
	'use strict';

	function buildMapEmbedUrl(location) {
		var meta = location.meta || {};
		var latitude = parseFloat(meta.latitude);
		var longitude = parseFloat(meta.longitude);
		var queryParts = [];
		var query = '';

		if (Number.isFinite(latitude) && Number.isFinite(longitude)) {
			return 'https://www.google.com/maps?q=' + encodeURIComponent(latitude + ',' + longitude) + '&z=15&output=embed&hl=id';
		}

		if (location.title) {
			queryParts.push(location.title);
		}

		if (meta.alamat && meta.alamat !== location.title) {
			queryParts.push(meta.alamat);
		}

		query = queryParts.join(', ') || 'Satlantas Polres Ponorogo';

		return 'https://www.google.com/maps?q=' + encodeURIComponent(query) + '&z=15&output=embed&hl=id';
	}

	function initServiceMap() {
		var mapElement = document.getElementById('satlantas-service-map');
		var config = window.satlantasLocationsMap || {};
		var locations = Array.isArray(config.locations) ? config.locations : [];
		var locationItems = Array.prototype.slice.call(document.querySelectorAll('.location-item[data-location-id]'));
		var initialLocationId = String(locations[0] && locations[0].id ? locations[0].id : '');
		var mapFrame = null;

		if (!mapElement || !locations.length) {
			return;
		}

		mapFrame = mapElement.querySelector('iframe');

		if (!mapFrame) {
			mapFrame = document.createElement('iframe');
			mapFrame.className = 'location-service-map__frame';
			mapFrame.title = 'Peta lokasi layanan Satlantas Polres Ponorogo';
			mapFrame.loading = 'lazy';
			mapFrame.referrerPolicy = 'no-referrer-when-downgrade';
			mapFrame.allowFullscreen = true;
			mapElement.appendChild(mapFrame);
		}

		function updateMap(location) {
			var mapUrl = buildMapEmbedUrl(location);

			if (mapFrame.src !== mapUrl) {
				mapFrame.src = mapUrl;
			}

			mapElement.dataset.locationId = String(location.id || '');
		}

		function setActiveButton(locationId) {
			locationItems.forEach(function (item) {
				var button = item.querySelector('.location-item__select');
				var isActive = String(item.dataset.locationId || '') === String(locationId);

				item.classList.toggle('is-active', isActive);

				if (button) {
					button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
				}
			});
		}

		function selectLocation(locationId) {
			var location = locations.find(function (item) {
				return String(item.id) === String(locationId);
			});

			if (!location) {
				return;
			}

			setActiveButton(location.id);
			updateMap(location);
		}

		locationItems.forEach(function (item) {
			var button = item.querySelector('.location-item__select');
			var mapsLink = item.querySelector('.location-item__action');

			if (button) {
				button.addEventListener('click', function () {
					selectLocation(item.dataset.locationId);
				});
			}

			if (mapsLink) {
				mapsLink.addEventListener('click', function () {
					selectLocation(item.dataset.locationId);
				});
			}
		});

		selectLocation(initialLocationId || locationItems[0] && locationItems[0].dataset.locationId);
	}

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', initServiceMap);
	} else {
		initServiceMap();
	}
}());
