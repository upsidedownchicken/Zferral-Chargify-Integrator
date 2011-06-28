<?php

add_action( 'admin_menu', 'zkcz_plugin_menu' );

function zkcz_plugin_menu(){
  if( function_exists('add_options_page') ){
    add_options_page( 'zckz Settings', 'zkcz', 'manage_options', 'zkcz', 'zkcz_configuration' );
  }
}

function zkcz_configuration(){
  if( isset($_POST['submit']) ){
    update_option( 'api_key',           $_POST['api_key'] );
    update_option( 'subdomain',         $_POST['subdomain'] );
    update_option( 'test_api_key',      $_POST['test_api_key'] );
    update_option( 'test_mode',         $_POST['test_mode'] );
    update_option( 'test_subdomain',    $_POST['test_subdomain'] );
    update_option( 'zferral_subdomain', $_POST['zf_subdomain'] );
  }

  $api_key        = get_option( 'api_key' );
  $subdomain      = get_option( 'subdomain' );
  $test_api_key   = get_option( 'test_api_key' );
  $test_mode      = get_option( 'test_mode' );
  $test_subdomain = get_option( 'test_subdomain' );
  $zf_subdomain   = get_option( 'zferral_subdomain' );
?>
  <div class="wrap">
  <h2>zkcz Configuration</h2>

  <form method="post">
    <fieldset>
      <h3><legend>zferral Settings</legend></h3>
      <p>
        <label for="zf_subdomain">Subdomain</label>
        <input type="text" name="zf_subdomain" value="<?php echo $zf_subdomain ?>" />.zferral.com
      </p>
    </fieldset>
    <fieldset>
      <h3><legend>Chargify API Settings</legend></h3>
      <p>
        <label for="api_key">API Key</label>
        <input type="text" name="api_key" value="<?php echo $api_key ?>" />
      </p>
      <p>
        <label for="subdomain">Subdomain</label>
        <input type="text" name="subdomain" value="<?php echo $subdomain ?>" />.chargify.com
      </p>
    </fieldset>
    <fieldset>
      <h3><legend>Chargify Testing API Settings</legend></h3>
      <p>
        <label for="test_mode">Test Mode</label>
        <input type="radio" name="test_mode" value="0"<?php if( $test_mode == 0 ) : ?> checked="checked"<?php endif; ?> /> Off
        <input type="radio" name="test_mode" value="1"<?php if( $test_mode == 1 ) : ?> checked="checked"<?php endif; ?> /> On
      </p>
      <p>
        <label for="test_api_key">Test API Key</label>
        <input type="text" name="test_api_key" value="<?php echo $test_api_key ?>" />
      </p>
      <p>
        <label for="test_subdomain">Subdomain</label>
        <input type="text" name="test_subdomain" value="<?php echo $test_subdomain ?>" />.chargify.com
      </p>
    </fieldset>
    <p>
      <input type="submit" name="submit" value="       Save       " />
    </p>
  </form>
  </div>
<?php
}
?>
