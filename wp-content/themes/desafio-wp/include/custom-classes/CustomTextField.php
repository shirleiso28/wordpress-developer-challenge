<?php

class CustomTextField {

	public $metaValue;
	public $metaBoxTitle;
	public $post_type;
	public $context;
	public $type;

	public function __construct($metaValue, $metaBoxTitle, $post_type, $context='normal', $type='text') {
	    $this->metaValue = sanitize_title( $metaValue );
	    $this->context = $context;
		$this->metaBoxTitle = $metaBoxTitle;
		$this->post_type = $post_type;
		$this->type = $type;
		add_action( 'save_post', array($this, 'save_metaValue'), 1, 2); // save the custom fields
		add_action( 'add_meta_boxes', array($this, 'set_metabox' ));
	}

	public function set_metabox(){
		add_meta_box($this->post_type.'_'.$this->metaValue, $this->metaBoxTitle, array($this, 'the_metabox'), $this->post_type, $this->context, 'default');
	}

	public function save_metaValue($post_id, $post) {
		if (!isset($_POST[$post->post_type.'_textField_nonce']) || !wp_verify_nonce( $_POST[$post->post_type.'_textField_nonce'], plugin_basename(__FILE__) ))
			return $post->ID;

		if ( !current_user_can( 'edit_post', $post->ID ))
			return false;

		set_post_meta($post->ID, $this->metaValue);
	}

	public function the_metabox(){
		global $post;
		echo '<input type="hidden" name="'.$post->post_type.'_textField_nonce" id="'.$post->post_type.'_textFields_nonce" value="'.wp_create_nonce(plugin_basename(__FILE__)) . '" />';
		echo '<input class="componentTitleInput" type="'.$this->type.'" name="'.$this->metaValue.'" value="'.get_post_meta($post->ID, $this->metaValue, true).'"  placeholder="" />';
	}
}