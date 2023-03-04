<?php

class CustomLinkField {

	public $metaValue;
	public $metaBoxTitle;
	public $post_type;
	public $context;

	public function __construct($metaValue, $metaBoxTitle, $post_type, $context='normal') {
	    $this->metaValue = sanitize_title( $metaValue );
	    $this->context = $context;
		$this->metaBoxTitle = $metaBoxTitle;
		$this->post_type = $post_type;
		add_action( 'save_post', array($this, 'save_metaValue'), 1, 2); // save the custom fields
		add_action( 'add_meta_boxes', array($this, 'set_metabox' ));
	}

	public function set_metabox(){
		add_meta_box($this->post_type.'_'.$this->metaValue, $this->metaBoxTitle, array($this, 'the_metabox'), $this->post_type, $this->context, 'default');
	}

	public function save_metaValue($post_id, $post) {
		if (!isset($_POST[$post->post_type.'_linkField_nonce']) || !wp_verify_nonce( $_POST[$post->post_type.'_linkField_nonce'], plugin_basename(__FILE__) ))
			return $post->ID;

		if ( !current_user_can( 'edit_post', $post->ID ))
			return false;

		set_post_meta($post->ID, $this->metaValue);
		if(!isset($_POST[$this->metaValue.'_target'])||empty($_POST[$this->metaValue.'_target']))
			$_POST[$this->metaValue.'_target'] = '_self';
		set_post_meta($post->ID, $this->metaValue.'_target');
	}

	public function the_metabox(){
		global $post;
		$linkTarget = get_post_meta($post->ID, $this->metaValue.'_target', true);
		$checked = '';
		if($linkTarget === '_blank')
			$checked = ' checked="checked" ';
		echo '<input type="hidden" name="'.$post->post_type.'_linkField_nonce" id="'.$post->post_type.'_linkFields_nonce" value="'.wp_create_nonce(plugin_basename(__FILE__)) . '" />';
		echo '<input class="widefat" type="text" name="'.$this->metaValue.'" value="'.get_post_meta($post->ID, $this->metaValue, true).'"  placeholder="https://..." />';
	}
}