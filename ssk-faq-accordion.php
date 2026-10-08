<?php
/**
 * Plugin Name: SSK FAQ Accordion
 * Description: Task 1. Five-question FAQ accordion, one answer open at a time. Use the shortcode [ssk_faq].
 * Version:     1.0.0
 * Author:      Shabir Ahmad Khan
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SSK_FAQ_VERSION', '1.0.0' );
define( 'SSK_FAQ_URL', plugin_dir_url( __FILE__ ) );

/** Five question/answer pairs (test content). */
function ssk_faq_get_items() {
	return array(
		array( 'q' => 'How long does shipping take?', 'a' => 'Orders usually arrive within 3 to 5 working days after they are dispatched.' ),
		array( 'q' => 'Can I return an item?', 'a' => 'Yes. Unused items can be returned within 14 days of delivery for a full refund.' ),
		array( 'q' => 'Do you ship internationally?', 'a' => 'We ship to most countries. Delivery times and costs are shown at checkout.' ),
		array( 'q' => 'How can I track my order?', 'a' => 'Once your order ships, we email you a tracking link you can open at any time.' ),
		array( 'q' => 'How do I contact support?', 'a' => 'Use the contact page or reply to any order email. We answer within one working day.' ),
	);
}

/** Load assets only on pages that use the shortcode. */
function ssk_faq_enqueue() {
	$post = get_post();
	if ( is_singular() && $post && has_shortcode( $post->post_content, 'ssk_faq' ) ) {
		wp_enqueue_style( 'ssk-faq', SSK_FAQ_URL . 'assets/css/style.css', array(), SSK_FAQ_VERSION );
		wp_enqueue_script( 'ssk-faq', SSK_FAQ_URL . 'assets/js/script.js', array(), SSK_FAQ_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'ssk_faq_enqueue' );

function ssk_faq_shortcode() {
	static $instance = 0;
	$instance++;
	$faqs = ssk_faq_get_items();

	ob_start();
	?>
	<div class="ssk-faq" data-ssk-faq>
		<?php foreach ( $faqs as $i => $faq ) :
			$btn_id   = 'ssk-faq-' . $instance . '-btn-' . $i;
			$panel_id = 'ssk-faq-' . $instance . '-panel-' . $i;
			?>
			<div class="ssk-faq__item">
				<h3 class="ssk-faq__heading">
					<button type="button" class="ssk-faq__button" id="<?php echo esc_attr( $btn_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
						<span class="ssk-faq__question"><?php echo esc_html( $faq['q'] ); ?></span>
						<span class="ssk-faq__icon" aria-hidden="true"></span>
					</button>
				</h3>
				<div class="ssk-faq__panel" id="<?php echo esc_attr( $panel_id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $btn_id ); ?>" hidden>
					<p><?php echo esc_html( $faq['a'] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ssk_faq', 'ssk_faq_shortcode' );
