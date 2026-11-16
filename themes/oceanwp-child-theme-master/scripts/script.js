/**
 * Pop-up du salon.
 * - s'affiche une seule fois : la fermeture est mémorisée dans le navigateur ;
 * - se ferme avec la croix, la touche Échap ou un clic sur le fond sombre ;
 * - le focus clavier va dans la pop-up à l'ouverture et y reste (Tab).
 */
jQuery(function ($) {
	const $overlay = $('.popup-overlay');
	if (!$overlay.length) {
		return;
	}

	const CLE = 'medit-popup-salon-fermee';
	const dejaFermee = () => {
		try { return localStorage.getItem(CLE) === '1'; } catch (e) { return false; }
	};
	if (dejaFermee()) {
		return;
	}

	const $popup = $overlay.find('.popup-salon');
	const focusables = 'a[href], button, input, select, textarea, [tabindex]:not([tabindex="-1"])';
	let dernierFocus = null;

	function ouvrir() {
		dernierFocus = document.activeElement;
		$overlay.prop('hidden', false);
		$overlay.find('.popup-close').trigger('focus');
	}

	function fermer() {
		$overlay.prop('hidden', true);
		try { localStorage.setItem(CLE, '1'); } catch (e) { /* navigation privée : tant pis */ }
		if (dernierFocus) {
			dernierFocus.focus();
		}
	}

	$overlay.on('click', '.popup-close', fermer);

	// Clic sur le fond sombre (pas sur la fenêtre elle-même).
	$overlay.on('click', function (e) {
		if (e.target === this) {
			fermer();
		}
	});

	$(document).on('keydown', function (e) {
		if ($overlay.prop('hidden')) {
			return;
		}
		if (e.key === 'Escape') {
			fermer();
			return;
		}
		if (e.key === 'Tab') {
			const $f = $popup.find(focusables).filter(':visible');
			const premier = $f.get(0);
			const dernier = $f.get($f.length - 1);
			if (e.shiftKey && document.activeElement === premier) {
				e.preventDefault();
				dernier.focus();
			} else if (!e.shiftKey && document.activeElement === dernier) {
				e.preventDefault();
				premier.focus();
			}
		}
	});

	ouvrir();
});
