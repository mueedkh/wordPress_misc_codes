<?php

//Repeater Fields for Any Post Type

add_action('admin_init', 'mk_add_meta_boxes', 2);

function mk_add_meta_boxes() {
add_meta_box( 'repeater-field', 'My Repeater Field', 'repeater_fields_display', 'POST_TYPE', 'normal', 'high');
}

function repeater_fields_display() {
    global $post;
    $my_fields_group = get_post_meta($post->ID, 'my_fields_group', true);
     wp_nonce_field( 'mk_fields_nonce', 'mk_fields_nonce' );
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
            var row = $( '.empty-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
    });
  </script>
  <table id="repeatable-fieldset-one" width="100%">
  <tbody>
    <?php
     if ( $my_fields_group ) :
      foreach ( $my_fields_group as $field ) {
    ?>
    <tr>
      <td width="15%">
            <select name="icon[]">
                <option>-- Select --</option>
                <?php
$iconss = array("icon1","icon2","icon3","icon4");
foreach ($iconss as $icon) {

    if($icon == $field['icon'] ){

          echo "<option value='". $icon ."' selected>
{$icon}
            </option>";
    }else{
          echo "<option value='". $icon ."'>
{$icon}
            </option>";
}
}
                ?>
            </select>
      </td>
      <td width="70%">
        <input type="text"  placeholder="Field Details" name="YourField[]" value="<?php if($field['YourField'] != '') echo esc_attr( $field['amenity'] ); ?>" style="width: 100%;"/></td> 
      <td width="15%"><a class="button remove-row" href="#1">Remove</a></td>
    </tr>
    <?php
    }
    else :
    // show a blank one
    ?>
    <tr>
        <td width="15%">
             <select name="icon[]">
                <option>-- Select --</option>
                <?php
$iconss = array("icon1","icon2","icon3","icon4");
foreach ($iconss as $icon) {
          echo "<option value='". $icon ."'>
{$icon}
            </option>";
}
                ?>
            </select>
      </td>
      <td width="70%"> 
      <input type="text" placeholder="Field Details" name="YourField[]" style="width: 100%;"/>
      </td>
      <td><a class="button  mk-remove-row-button button-disabled" href="#">Remove</a></td>
    </tr>
    <?php endif; ?>

    <!-- empty hidden one for jQuery -->
    <tr class="empty-row screen-reader-text">
        <td width="15%">
             <select name="icon[]">
                <option>-- Select --</option>
                <?php
$iconss = array("icon1","icon2","icon3","icon4");
foreach ($iconss as $icon) {
          echo "<option value='". $icon ."'>
{$icon}
            </option>";
}
                ?>
            </select>
      </td>
      <td>
        <input type="text" placeholder="Field Details" name="YourField[]" style="width: 100%;"/></td>
      <td><a class="button remove-row" href="#">Remove</a></td>
    </tr>
  </tbody>
</table>
<p><a id="add-row" class="button" href="#">Add another</a></p>
 <?php
}
//Saving Amenities Fields Data here
add_action('save_post', 'amenities_data_save');
function amenities_data_save($post_id) {
    if ( ! isset( $_POST['mk_fields_nonce'] ) ||
    ! wp_verify_nonce( $_POST['mk_fields_nonce'], 'mk_fields_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'my_fields_group', true);
    $new = array();
    $icons = $_POST['icon'];
    $YourField = $_POST['YourField'];
     $count = count( $YourField );
     for ( $i = 0; $i < $count; $i++ ) {
        if ( $YourField[$i] != '' ) :
            $new[$i]['icon'] = $icons[$i]; 
            $new[$i]['YourField'] = stripslashes( strip_tags( $YourField[$i] ) );
        endif;
    }
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'my_fields_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'my_fields_group', $old );


}
