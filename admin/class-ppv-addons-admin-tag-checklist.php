<?php

/**
 * Use checkbox term selection for non-hierarchical taxonomies
 *
 * @link       http://picturesquephotoviews.com/
 * @since      1.4.4
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/admin
 */

/**
 * Use checkbox term selection for non-hierarchical taxonomies
 *
 * Usage:
 *
 * new Tag_Checklist( 'taxonomy_name', 'post_type', 'show_add_tax' );
 *
 * Based on:
 * @link  https://gist.github.com/hlashbrooke/5983859
 */
class Tag_Checklist {

    private $taxonomy;
    private $post_type;
    private $showaddtax;
    /**
     * @param string  $taxonomy    taxonomy name
     * @param array   $post_type   post type
     * @param bool    $showaddtax  show add taxonomy in metabox
     */
	function __construct( $taxonomy, $post_type, $showaddtax = true ) {
		$this->taxonomy = $taxonomy;
		$this->post_type = $post_type;
		$this->showaddtax = $showaddtax;

		// Remove default taxonomy meta box
		add_action( 'admin_menu', array( $this, 'ppv_remove_meta_box' ) );

		// Add new meta box
		add_action( 'add_meta_boxes', array( $this, 'ppv_add_meta_box' ) );

	}

	/**
	 * Remove default meta box
	 * @return void
	 */
	public function ppv_remove_meta_box() {
		remove_meta_box('tagsdiv-' . $this->taxonomy, $this->post_type, 'normal');
	}

	/**
	 * Add new metabox
	 * @return void
	 */
	public function ppv_add_meta_box() {
		$tax = get_taxonomy( $this->taxonomy );
		add_meta_box( 'taglist-' . $this->taxonomy, $tax->labels->name, array( $this, 'metabox_content' ), $this->post_type, 'side', 'core' );
	}

	/**
	 * Generate metabox content
	 * @param  obj $post Post object
	 * @return void
	 */
	public function metabox_content( $post ) {
        $taxonomy = $this->taxonomy;
        $tax = get_taxonomy( $taxonomy );
		?>
		<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">

		    <div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
		    	<input type="hidden" name="tax_input[<?php echo $taxonomy; ?>][]" value="0" />
		        <ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy; ?>" class="categorychecklist form-no-clear">
					<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ,  ) ) ?>
				</ul>
		   </div>

			<?php if (( current_user_can($tax->cap->edit_terms)) && ( $this->showaddtax )) : ?>
				<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
					<h4>
						<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
							<?php
								/* translators: %s: add new taxonomy label */
								printf( __( '+ %s' ), $tax->labels->add_new_item );
							?>
						</a>
					</h4>
					<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
						<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
						<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
						<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
						<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
						<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
					</p>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}
?>