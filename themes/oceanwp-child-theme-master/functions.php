<?php
/**
 * Fonctions du thème enfant Medit (OceanWP Child).
 *
 * @package medit-child
 */

/**
 * Charge le style du thème enfant et le script de la pop-up.
 * La version = date de modification du fichier : le navigateur recharge
 * le CSS ou le JS dès qu'on le modifie (pas de vieux cache).
 */
function medit_child_enqueue() {
	$dir = get_stylesheet_directory();
	$uri = get_stylesheet_directory_uri();

	wp_enqueue_style(
		'child-style',
		$uri . '/style.css',
		array( 'oceanwp-style' ),
		filemtime( $dir . '/style.css' )
	);

	wp_enqueue_script(
		'medit-popup',
		$uri . '/scripts/script.js',
		array( 'jquery' ),
		filemtime( $dir . '/scripts/script.js' ),
		true // dans le pied de page, après le HTML de la pop-up
	);
}
add_action( 'wp_enqueue_scripts', 'medit_child_enqueue' );

/**
 * Font Awesome est déjà chargé par OceanWP : on retire la copie d'Elementor
 * (environ 160 Ko de polices en double).
 */
function medit_child_dequeue_duplicate_icons() {
	foreach ( array( 'elementor-icons-shared-0', 'elementor-icons-fa-solid', 'elementor-icons-fa-brands', 'elementor-icons-fa-regular' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
}
// Elementor ajoute ses icônes tard : on les retire juste avant l'impression des styles.
add_action( 'wp_print_styles', 'medit_child_dequeue_duplicate_icons', 100 );
add_action( 'wp_print_footer_scripts', 'medit_child_dequeue_duplicate_icons', 1 );

/**
 * Ajoute le bouton « Nous contacter » au menu principal seulement.
 * Il est placé dans un <li> : un <ul> ne peut contenir que des <li>.
 */
function contact_btn( $items, $args ) {
	if ( 'main_menu' !== $args->theme_location ) {
		return $items;
	}

	$items .= sprintf(
		'<li class="menu-item menu-item-contact"><a href="%s" class="contact-btn">%s</a></li>',
		esc_url( home_url( '/contact/' ) ),
		esc_html__( 'Nous contacter', 'oceanwp' )
	);

	return $items;
}
add_filter( 'wp_nav_menu_items', 'contact_btn', 10, 2 );

/**
 * La page FAQ contient le shortcode [faq], mais l'extension qui le gérait n'est plus là :
 * la page affichait « [faq] » tel quel. Si aucune extension ne déclare ce shortcode,
 * on affiche un message à la place.
 */
function medit_child_faq_fallback() {
	if ( shortcode_exists( 'faq' ) ) {
		return;
	}

	add_shortcode(
		'faq',
		function () {
			return '<p class="medit-faq-vide">' . esc_html__( 'Aucune question pour le moment. Une question ? Contactez-nous.', 'oceanwp' ) . '</p>';
		}
	);
}
add_action( 'init', 'medit_child_faq_fallback', 20 );
