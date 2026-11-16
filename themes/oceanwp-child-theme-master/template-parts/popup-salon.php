<?php
/**
 * Pop-up qui annonce la participation au salon.
 * Les textes viennent des champs ACF de la page « Salon » (ID 161).
 *
 * @package medit-child
 */

// Sans ACF, get_field() n'existe pas : on n'affiche rien plutôt que de casser le site.
if ( ! function_exists( 'get_field' ) ) {
	return;
}

$medit_page_salon = 161;

$titre       = get_field( 'titre', $medit_page_salon );
$description = get_field( 'description', $medit_page_salon );
$lieu        = get_field( 'lieu', $medit_page_salon );
$date        = get_field( 'date', $medit_page_salon );
$lien        = get_field( 'lien_google_maps', $medit_page_salon );

if ( ! $titre ) {
	return;
}
?>

<div class="popup-overlay" hidden>
	<div class="popup-salon" role="dialog" aria-modal="true" aria-labelledby="popup-salon-titre">
		<div class="popup-header">
			<h3 id="popup-salon-titre"><?php echo esc_html( $titre ); ?></h3>
			<button type="button" class="popup-close" aria-label="<?php esc_attr_e( 'Fermer', 'oceanwp' ); ?>">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>

		<?php echo wp_kses_post( $description ); ?>

		<div class="popup-details">
			<div class="popup-address">
				<p><b>Le lieu</b></p>
				<?php echo wp_kses_post( $lieu ); ?>
				<?php if ( $lien ) : ?>
					<a class="popup-link" href="<?php echo esc_url( $lien ); ?>" target="_blank" rel="noopener">
						Voir sur Google Maps<span class="screen-reader-text"> (nouvel onglet)</span>
					</a>
				<?php endif; ?>
			</div>
			<div class="popup-address">
				<p><b>La date</b></p>
				<?php echo wp_kses_post( $date ); ?>
			</div>
		</div>

		<p class="popup-informations">Vous souhaitez plus d'informations concernant cet événement ?</p>
		<?php echo do_shortcode( '[contact-form-7 id="f836ce7" title="Formulaire salon New York"]' ); ?>
	</div>
</div>
