<?php

add_action( 'admin_menu', 'zkcz_create_meta_box' );
add_action( 'save_post', 'zkcz_update_campaign_id' );

function zkcz_create_meta_box(){
  if( function_exists('add_meta_box') ){
    add_meta_box( 'zkcz-campaign-box', 'zferral Campaign ID', 'zkcz_campaign_box', 'page' );
  }
}

function zkcz_campaign_box(){
  global $post;
  $campaign_id = get_post_meta( $post->ID, 'zkcz_campaign_id', true );
  ?>
  <table class="form_table">
    <tr>
      <th width="30%"><label for="zkcz_campaign_id">zferral Campaign ID</label></th>
      <td width="70%"><input type="text" size="60" name="zkcz_campaign_id" value="<?php echo $campaign_id ?>" /></td>
    </tr>
  </table>
  <?php
}

function zkcz_update_campaign_id( $post_id ){
  if( isset($_POST['zkcz_campaign_id']) ){
    update_post_meta( $post_id, 'zkcz_campaign_id', $_POST['zkcz_campaign_id'] );
  }
}
?>
