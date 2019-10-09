<?php
/**
 * Add meta box
 */
function food_add_meta_boxes( $post ){
	add_meta_box( 'YOUR_METABOX_ID','YOUR_METABOX_TITLE', 'YOUR_METABOX_CALLBACK_FUNCTION', 'POST_TYPE', 'PLACEMENT (side or normal etc)', 'PRIORITY (high, low etc)' ); //REPLACE YOUR VALUES WITH CAPITAL TEXTS
}
add_action( 'add_meta_boxes', 'mkwebs_add_meta_boxes' );


//Callback function that returns custom fields to the meta box we have created above
function cd_meta_box_cb( $post )
{
//GET and save existing fields value of the fields and save them in variable 
$values = get_post_custom( $post->ID ); //retrieves post meta data
$text = isset( $values['MY_META_BOX_TEXT'] ) ? esc_attr( $values['MY_META_BOX_TEXT'][0] ) : ”;
   
//Add as many fields as you want   
   ?>
<p>
    <label for="MY_META_FIELD_ID">Text Label</label>
    <input type="text" name="MY_META_BOX_TEXT" id="MY_META_FIELD_ID" value="<?php echo $text; ?>" />
        </p>
    <?php        
}

//To save our data, we're going to rely on another WordPress hook: save_post.
add_action( 'save_post', 'mkwebs_save_meta_fields' );
function mkwebs_save_meta_fields( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // Make sure your data is set before trying to save it
    if( isset( $_POST['MY_META_BOX_TEXT'] ) )
        update_post_meta( $post_id, 'MY_META_BOX_TEXT' );
      
}
