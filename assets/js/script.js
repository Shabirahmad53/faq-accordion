(function () {
	'use strict';

	function initFaq(root) {
		var buttons = root.querySelectorAll('.ssk-faq__button');

		function setState(button, open) {
			var panel = document.getElementById(button.getAttribute('aria-controls'));
			button.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (panel) {
				panel.hidden = !open;
			}
		}

		buttons.forEach(function (button) {
			button.addEventListener('click', function () {
				var isOpen = button.getAttribute('aria-expanded') === 'true';

				// Close every answer first, so only one stays open.
				buttons.forEach(function (other) {
					setState(other, false);
				});

				// Open the clicked one unless it was already open.
				if (!isOpen) {
					setState(button, true);
				}
			});
		});
	}

	document.querySelectorAll('[data-ssk-faq]').forEach(initFaq);
})();
