<?php

add_action( 'wp_footer', 'zkcz_insert_pixel' );

require_once dirname(__FILE__) . '/Chargify-PHP-Client/lib/Chargify.php';

$subscription_id  = $_REQUEST['subscription_id'];
$transaction_id   = $_REQUEST['transaction_id'];

$test_mode        = get_option( 'test_mode' );

function zkcz_insert_pixel(){
  //zkcz_check_referrer() && echo( zkcz_pixel_html );
  echo( zkcz_pixel_html() );
}

function zkcz_check_referrer(){
  $subdomain = ( get_option('test_mode',0) ) ? get_option('test_subdomain') : get_option('subdomain');
  $domain = parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST );

  return $domain == "$subdomain.chargify.com";
}

function zkcz_pixel_html(){
  $src = zkcz_pixel_src();
  return <<<HTML
<img src="$src" style="border: none; display: none" alt="" />
HTML;
}

function zkcz_pixel_src(){
  global $subscription_id, $transaction_id;

  $subdomain        = zkcz_zferral_subdomain();
  $campaign_id      = zkcz_zferral_campaign_id();
  $revenue          = zkcz_chargify_revenue();

  return "http://$subdomain.zferral.com/e/$campaign_id?rev=$revenue&customerId=$subscription_id&uniqueId=$transaction_id";
}

function zkcz_zferral_subdomain(){
  return get_option( 'zferral_subdomain' );
}

function zkcz_zferral_campaign_id(){
  global $post;
  return get_post_meta( $post->ID, 'zkcz_campaign_id', true );
}

function zkcz_chargify_revenue(){
  global $subscription_id, $transaction_id, $test_mode;

  $api_key    = ( $test_mode ) ? get_option( 'test_api_key' ) : get_option( 'api_key' );
  $subdomain  = ( $test_mode ) ? get_option( 'test_subdomain' ) : get_option( 'subdomain' );

  if(!$api_key) {
	error_log("No key specified, plugin is probably unconfigured.. Exit stage left.. "); 
	return true; 
  }
 
  $cents = NULL;

  try {
    $chargify       = new ChargifyTransaction( NULL, $test_mode, $subdomain, $api_key );
    $results        = $chargify->getBySubscriptionID( $subscription_id );

    foreach( $results as $transaction ){
      if( $transaction->memo == 'Initial/Startup fees' ){
        $cents = $transaction->amount_in_cents;
      }
    }
  } catch( Exception $e ){
    error_log( $e->getMessage );
  }

  if( is_null($cents) ){
    error_log( "Could not find revenue for subscription $subscription_id" );
  } else {
    return zkcz_format_cents_as_dollars( $cents );
  }
}

function zkcz_format_cents_as_dollars( $cents ){
  return substr_replace( $cents, '.', -2, 0 );
}

?>
