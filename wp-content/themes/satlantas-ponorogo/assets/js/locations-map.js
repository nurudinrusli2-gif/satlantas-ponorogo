(function () {
	'use strict';

	function escapeHtml(value) {
		return String(value || '').replace(/[&<>"']/g, function (character) {
			return {
				'&': '&amp;',
				'<': '&lt;',
				'>': '&gt;',
				'"': '&quot;',
				"'": '&#039;'
			}[character];
		});
	}

	function createPopup(location) {
		var meta = location.meta || {};
		var html = '<strong>' + escapeHtml(location.title) + '</strong>';

		if (meta.alamat) {
			html += '<p>' + escapeHtml(meta.alamat) + '</p>';
		}

		if (meta.nomor_telepon) {
			html += '<small>Telp: ' + escapeHtml(meta.nomor_telepon) + '</small>';
		}

		if (meta.maps_url) {
			html += '<a class="leaflet-popup-button" href="' + escapeHtml(meta.maps_url) + '" target="_blank" rel="noopener noreferrer">Google Maps</a>';
		}

		return html;
	}

	function initServiceMap() {
		var mapElement = document.getElementById('satlantas-service-map');
		var config = window.satlantasLocationsMap || {};
		var locations = Array.isArray(config.locations) ? config.locations : [];

		if (!mapElement || !locations.length || typeof window.L === 'undefined') {
			return;
		}

		var map = window.L.map(mapElement, {
			scrollWheelZoom: false
		});
		var bounds = [];

		window.L.tileLayer(config.tileUrl, {
			attribution: config.attribution,
			maxZoom: 19
		}).addTo(map);

		// Build markers only from locations with valid coordinates supplied by PHP.
		locations.forEach(function (location) {
			var meta = location.meta || {};
			var latitude = parseFloat(meta.latitude);
			var longitude = parseFloat(meta.longitude);

			if (!Number.isFinite(latitude) || !Number.isFinite(longitude)) {
				return;
			}

			window.L.marker([latitude, longitude])
				.addTo(map)
				.bindPopup(createPopup(location));

			bounds.push([latitude, longitude]);
		});

		// One marker should feel local; multiple markers should reveal the whole service area.
		if (!bounds.length) {
			map.remove();
			mapElement.hidden = true;
			return;
		}

		if (1 === bounds.length) {
			map.setView(bounds[0], 15);
		} else {
			map.fitBounds(bounds, {
				padding: [28, 28]
			});
		}

		window.setTimeout(function () {
			map.invalidateSize();
		}, 150);
	}

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', initServiceMap);
	} else {
		initServiceMap();
	}
}());
