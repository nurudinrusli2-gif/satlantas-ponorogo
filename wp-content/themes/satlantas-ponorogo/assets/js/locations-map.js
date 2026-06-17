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
		var hero = document.querySelector('[data-location-hero]');
		var locationButtons = Array.prototype.slice.call(document.querySelectorAll('.location-item[data-location-id]'));
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

		function setText(fieldName, value) {
			var field = hero ? hero.querySelector('[data-location-field="' + fieldName + '"]') : null;

			if (!field) {
				return;
			}

			field.textContent = value || '';
		}

		function setVisibility(fieldName, visible) {
			var field = hero ? hero.querySelector('[data-location-field="' + fieldName + '"]') : null;

			if (!field) {
				return;
			}

			field.hidden = !visible;
		}

		function updateHero(location) {
			var meta = location.meta || {};
			var title = location.title || meta.alamat || 'Lokasi Layanan';
			var summary = meta.alamat && meta.alamat !== title ? meta.alamat : '';
			var mapsUrl = meta.maps_url || location.permalink || '#';
			var mapsLink = hero ? hero.querySelector('[data-location-field="maps-link"]') : null;

			setText('label', String(location.id) === initialLocationId ? 'Lokasi Utama' : 'Lokasi Terpilih');
			setText('title', title);
			setText('address', summary);
			setText('hours', meta.jam_operasional || '');
			setText('phone', meta.nomor_telepon || '');
			setVisibility('address', Boolean(summary));
			setVisibility('hours-wrap', Boolean(meta.jam_operasional));
			setVisibility('phone-wrap', Boolean(meta.nomor_telepon));

			if (mapsLink) {
				mapsLink.href = mapsUrl;

				if (meta.maps_url) {
					mapsLink.target = '_blank';
					mapsLink.rel = 'noopener noreferrer';
				} else {
					mapsLink.removeAttribute('target');
					mapsLink.removeAttribute('rel');
				}
			}
		}

		function updateMap(location) {
			var mapUrl = buildMapEmbedUrl(location);

			if (mapFrame.src !== mapUrl) {
				mapFrame.src = mapUrl;
			}

			mapElement.dataset.locationId = String(location.id || '');
		}

		function setActiveButton(locationId) {
			locationButtons.forEach(function (button) {
				var isActive = String(button.dataset.locationId || '') === String(locationId);
				button.classList.toggle('is-active', isActive);
				button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
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
			updateHero(location);
			updateMap(location);
		}

		locationButtons.forEach(function (button) {
			button.addEventListener('click', function () {
				selectLocation(button.dataset.locationId);
			});
		});

		selectLocation(initialLocationId || locationButtons[0] && locationButtons[0].dataset.locationId);
	}

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', initServiceMap);
	} else {
		initServiceMap();
	}
}());
