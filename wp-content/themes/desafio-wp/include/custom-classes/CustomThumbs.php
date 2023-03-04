<?php

class CustomThumbs {

	public $metaValue;
	public $metaBoxTitle;
	public $post_type;
	public $metaboxPosition;
	public $extraFunction;

	public function __construct($metaValue, $metaBoxTitle, $post_type, $metaboxPosition = 'side', $extraFunction = false) {
		$this->metaValue = sanitize_title($metaValue);
		$this->metaBoxTitle = $metaBoxTitle;
		$this->post_type = $post_type;
		$this->metaboxPosition = $metaboxPosition;
		$this->extraFunction = $extraFunction;
		add_action( 'save_post', array($this, 'save_metaValue'), 1, 2); // save the custom fields
		add_action( 'add_meta_boxes', array($this, 'set_metabox' ));
	}

	public function set_metabox(){
		add_meta_box($this->post_type.'_'.$this->metaValue, $this->metaBoxTitle, array($this, 'the_metabox'), $this->post_type, $this->metaboxPosition, 'default');
	}

	public function save_metaValue($post_id, $post) {
		if (!isset($_POST[$post->post_type.'_thumbs_'.$this->metaValue.'_nonce']) || !wp_verify_nonce( $_POST[$post->post_type.'_thumbs_'.$this->metaValue.'_nonce'], plugin_basename(__FILE__) ))
			return $post->ID;

		if ( !current_user_can( 'edit_post', $post->ID ))
			return false;

		set_post_meta($post->ID, $this->metaValue);
	}

	public function the_metabox(){
		global $post;

		$foto = get_post_meta($post->ID, $this->metaValue, true);
		echo '<input type="hidden" name="'.$post->post_type.'_thumbs_'.$this->metaValue.'_nonce" value="'.wp_create_nonce(plugin_basename(__FILE__)) . '" />'; ?>
        <div>
            <ul id="cthumbs_<?php echo $this->metaValue;?>" class="cthumbs">
            <?php if($foto){	 ?>
                <li>
                    <img id="edit_<?php echo $this->metaValue;?>" img="<?php echo $foto; ?>" class="edit-cthumbs" src="<?php echo wp_get_attachment_image_url( $foto, 'full' ); ?>"/>
                    <input type="hidden" name="<?php echo $this->metaValue;?>" value="<?php echo $foto; ?>"/>
                    <p class="hide-if-no-js howto">Clicar sobre a imagem para editar ou atualizar.</p>
                    <div id="del_<?php echo $this->metaValue;?>" img="<?php echo $foto; ?>" class=" pt-1 del-cthumbs">Remover imagem</div>
                </li>
            <?php }else{ ?>
                <li><div id="add_<?php echo $this->metaValue;?>" class="add-cthumbs">Definir imagem</div></li>
            <?php } ?>
            </ul>
        </div>
        <style>
            .add-cthumbs, .del-cthumbs {
                color: #0073aa;
                text-decoration: underline;
                font-size: 13px;
                line-height: 1.5;
                transition-property: border,background,color;
                transition-duration: .05s;
                transition-timing-function: ease-in-out;
                cursor: pointer;
            }
            .add-cthumbs:hover, .del-cthumbs:hover {
                color: #00a0d2;
            }
            .cthumbs li img {
                width: 100%;
                object-fit: cover;
            }
            .edit-cthumbs {
                cursor: pointer;
            }
        </style>
        <script type='text/javascript'>
            jQuery(document).ready(function($){
                function add_cthumbs_<?php echo $this->metaValue;?>(button_class) {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('body').on('click', button_class, function(e) {
                        var button_id = '#'+$(this).attr('id');
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(button_id);
                        _custom_media = true;
                        wp.media.editor.send.attachment = function(props, attachment){
                            if ( _custom_media ) {
                                $('#cthumbs_<?php echo $this->metaValue;?>').html('<li><img id="edit_<?php echo $this->metaValue;?>" img="'+attachment.id+'" class="edit-cthumbs" src="'+attachment.url+'" /><input type="hidden" name="<?php echo $this->metaValue;?>" value="'+attachment.id+'" /><p class="hide-if-no-js howto">Clicar sobre a imagem para editar ou atualizar.</p><div id="del_<?php echo $this->metaValue;?>" img="'+attachment.id+'" class="pt-1 del-cthumbs">Remover imagem</div></li>');
                                del_cthumbs_<?php echo $this->metaValue;?>();
                                edit_cthumbs_<?php echo $this->metaValue;?>();
                            } else {
                                return _orig_send_attachment.apply( button_id, [props, attachment] );
                            }
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                }
                function edit_cthumbs_<?php echo $this->metaValue;?>(){
                    $('#edit_<?php echo $this->metaValue;?>').off().on('click', function () {
                        var button = $(this);

                        custom_uploader = wp.media.frames.file_frame = wp.media({
                            title: 'Editar imagem',
                            button: {
                                text: 'Confirmar'
                            },
                            multiple: false
                        });
                        custom_uploader.on('select', function() {
                            var attachment = custom_uploader.state().get('selection').first().toJSON();
                            $('#cthumbs_<?php echo $this->metaValue;?>').html('<li><img id="edit_<?php echo $this->metaValue;?>" img="'+attachment.id+'" class="edit-cthumbs" src="'+attachment.url+'" /><input type="hidden" name="<?php echo $this->metaValue;?>" value="'+attachment.id+'" /><p class="hide-if-no-js howto">Clicar sobre a imagem para editar ou atualizar.</p><div id="del_<?php echo $this->metaValue;?>" img="'+attachment.id+'" class="pt-1 del-cthumbs">Remover imagem</div></li>');
                            del_cthumbs_<?php echo $this->metaValue;?>();
                            edit_cthumbs_<?php echo $this->metaValue;?>();
                        });
                        custom_uploader.on('open', function() {
                            var selection = custom_uploader.state().get( 'selection' );
                            selection.add( wp.media.attachment( $(button).attr('img') ) );
                        });
                        custom_uploader.open();
                        return false;
                    });
                }
                function del_cthumbs_<?php echo $this->metaValue;?>(){
                    $('#del_<?php echo $this->metaValue;?>').off().on('click', function () {
                        $('#cthumbs_<?php echo $this->metaValue;?>').html('<li><div id="add_<?php echo $this->metaValue;?>" class="add-cthumbs">Definir imagem</div></li>');
                        add_cthumbs_<?php echo $this->metaValue;?>('#add_<?php echo $this->metaValue;?>');
                    });
                }
                del_cthumbs_<?php echo $this->metaValue;?>();
                edit_cthumbs_<?php echo $this->metaValue;?>();
                add_cthumbs_<?php echo $this->metaValue;?>('#add_<?php echo $this->metaValue;?>');
            });
        </script>
<?php
        if($this->extraFunction){
            if(is_array($this->extraFunction)){
	            $reflection = new ReflectionMethod( $this->extraFunction[0], $this->extraFunction[1] );
            }else{
	            call_user_func($this->extraFunction);
            }
        }
	}

}