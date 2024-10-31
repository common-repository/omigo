<?php
/**
 * Plugin Name: OMIGO
 * Plugin URI: http://omigo.org
 * Description: Pay and Donate with OMIGO
 * Version: 3.3
 * Author: OMIGO
 * Author URI: http://amdentechnologies.com
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
use Eusonlito\Captcha\Captcha;

function omigo_register_session(){
	if( !session_id() )
		session_start();

	Captcha::sessionName('rafscaptcha');
}
add_action('init','omigo_register_session');

// OMIGO Service URL
global $omigo_portal_url;
$omigo_portal_url = "https://portal.omigo.org/";

// Terms of Service
global $tos;
$tos = '<ol>
	<li><span style="font-family: helvetica, arial, sans-serif;">By using the OMIGO fundraising website, you accept and agree to all the terms and conditions listed. If you disagree with any part of these terms and conditions, you hereby agree not to use this service.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You must be a legal United States resident or citizen, of legal age, to use this service.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You must provide proof of your identity in compliance with Federal AML and KYC regulations, which includes but not limited to proof of your legal status in the form of a United States Passport. If you do not have a United States Passport, then we will require you to submit two valid government issued picture identification cards.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You understand and agree that OMIGO is owned and operated by OMI International, and that your use of OMIGO does not constitute membership into OMI International. No rights or privileges of membership are granted or implied.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You understand that by using this service, OMIGO does not share or distribute, your information or any donor information.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">If you are not a 501c3, and you are signing up for an individual account, you understand that prior to your approval that you will be sent an Affidavit of Support via email that will explain the rules and regulations that you must abide by. This document must be printed, signed, and notarized and returned to our office within 14 days of registration payment. </span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree to use OMIGO for fundraising purposes only, and that you will not use this service for business “for-profit” purposes. Violation of this Federal law IRC 170(c); 501(c)(3) will result in legal prosecution at your own expense.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree and understand that the registration fee is non-refundable even if your application is rejected.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">In the event that your application is rejected, you will be given a reason as to why it was rejected. If you wish to apply again, you will be required to pay the registration fee again.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree and understand that when a donation is processed through OMIGO, your donation will be pooled, validated, and then distributed to your banking institution for processing. OMIGO cannot determine when funds will be made available to you by your banking institution. Therefore, by agreeing to use this service, you will not hold OMIGO, OMI International, its agents or subsidiaries, responsible for the time it takes to process your funds and the length of time it takes for the bank to make your funds available to you. In general, deposits may take 2-5 business days to appear in your bank account, however, processing times vary from bank to bank.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree to contact our team if your deposit does not arrive after 5 business days. You can also check with your bank to see if anything is being held up on their end. The quickest way to get a response is to contact us using the number provided in your OMIGO Fundraising confirmation email.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You understand that there will be processing fees for each transaction. Fees range from 2%+.30 cents to no more than 11% + 30 cents. Fees are determined based on the total number of transactions occuring within a 30 day period. Fees can be negotiated at anytime by contacting OMIGO.</span><br />
        <span style="font-family: helvetica, arial, sans-serif;">You must not use the OMIGO fundraising in any way or take any action that causes, or may cause, damage to our servers or impairment of the performance, availability or accessibility of the OMIGO portal website.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree that you must not use the OMIGO fundraising in any way that is unlawful, illegal, fraudulent or harmful, or in connection with any unlawful, illegal, fraudulent, terrorist or any activity that does not comply with IRC 501(c.)3</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You must not use the OMIGO fundraising website to copy, store, host or distribute harmful material.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You are 100% liable for the accuracy, and content of what you post. OMIGO is not liable for any content that you post, and cannot be held liable for actions resulting in issues related to the content.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree and understand that we will randomly review the content on your website. Your content must not be illegal or unlawful, and must not:</span></li>
</ol>
<ul>
	<li><span style="font-family: helvetica, arial, sans-serif;">(a) be libelous, obscene, indecent, depict violence in an explicit, graphic or gratuitous manner, pornographic, lewd, suggestive or sexually explicit;</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">(b) infringe any copyright, moral right, database right, trade mark right, design right, right in passing off, or other intellectual property right;</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">(c) constitute negligent advice or contain any negligent statement;</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">(d) incitement to commit a crime, instructions for the commission of a crime or the promotion of criminal activity;</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">(e) contain any instructions, advice or other information which may be acted upon and could, if acted upon, cause illness, injury or death, or any other loss or damage;</span></li>
</ul>
<ol start="16">
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree to use a strong password on your website in which you will keep confidential. You must notify OMIGO immediately in writing, should you become aware of disclosure of your password. </span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You are responsible for any and all activity, fraudulent or otherwise while using OMIGO, including activities arising out of failure to comply with this policy, and you will be held liable for all losses arising from non-compliance.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You understand that your account can be suspended, canceled, and/or edited at any time at OMIGO sole discretion without notice or explanation.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">OMI International reserves the right to restrict access to areas of the OMIGO website, or indeed the OMI International whole website, at the company’s discretion; you must not circumvent or bypass, or attempt to circumvent or bypass, the system, coding, and safe guards.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You may cancel your OMIGO fundraising account at any time by notifying OMIGO via <a href="mailto:admin@omigo.org">admin@omigo.org</a> that you wish to close the account.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">OMIGO does guarantee continual access to the OMIGO fundraising. OMIGO cannot be held liable for any information or lost data that resulted from a system failure or system error. OMIGO will not be liable to you in respect to any special, indirect or consequential loss or damage. OMIGO will not be liable to you in respect of any business losses, including (without limitation) loss of income. OMIGO will not be liable to you in respect of any loss or corruption of any data, database or software.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">You agree that you will not bring any claim personally or otherwise against OMIGO, its officers, members, subsidiaries, partners, affiliates, users or employees in respect of any losses you suffer in connection with the website or service.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">If you violate the terms of this service agreement, OMIGO will suspend or block your access to the OMIGO Fundraing, and you must not take any action to circumvent such suspension.</span></li>
	<li><span style="font-family: helvetica, arial, sans-serif;">OMIGO reserves the right to update the Terms of Service at any time. Any changes will be posted on the OMIGO fundraising website. This Term of Service is valid as of July 1, 2021 and supersedes all other Terms of Service agreements. Your continued use of this site signifies that you agree to the terms and conditions thereof.</span></li>
</ol>';

function setup_omigo_admin_menus() {
    $page = add_menu_page('OMIGO API', 'OMIGO API', 'publish_posts', 'omigo', 'omigo_settings', 'dashicons-money', 82 );

    add_submenu_page('omigo',
        'Settings', 'Settings', 'publish_posts',
        'omigo', 'omigo_settings');

    add_submenu_page('omigo',
        'View Donors', 'View donors', 'publish_posts',
        'omigo-api-donors', 'omigo_api_donors');

    add_submenu_page('omigo',
        'Exemption Letter', 'Exemption Letter', 'publish_posts',
        'omigo-api-letter', 'omigo_api_letter');

    // Load the CSS
    //add_action( 'omigo-load-' . $page, 'omigo_load_admin_css' );

    // Load the JS
    //add_action( 'omigo-load-' . $page, 'omigo_load_admin_js' );
}
add_action("admin_menu", "setup_omigo_admin_menus");

add_action( 'admin_enqueue_scripts', 'omigo_admin_scripts_and_styles' );
function omigo_admin_scripts_and_styles($hook) {
    $allowed_hooks = array(
        'omigo',
        'toplevel_page_omigo',
        'omigo-api_page_omigo-api-donors',
        'omigo-api_page_omigo-api-letter',
    );
    if(!in_array($hook, $allowed_hooks)) {
        return;
    }
    global $omigo_portal_url;
    $omigo_wp_obj = array(
        'omigo_portal_url' => $omigo_portal_url,
        'omigo_host' => $_SERVER['HTTP_HOST'],
        'omigo_ajax_admin_url' => admin_url('admin-ajax.php'),
    );
    wp_enqueue_style( 'omigo_admin_css', plugins_url('css/admin-style.css', __FILE__) );
    wp_register_script( 'omigo_admin_js', plugins_url('js/admin.js', __FILE__ ), array('jquery'));
    wp_localize_script( 'omigo_admin_js', 'omigo_wp_obj', $omigo_wp_obj );
    wp_enqueue_script( 'omigo_admin_js' );

    // Enqueue WordPress media scripts
    wp_enqueue_media();
}


function omigo_get_submerchant_id() {
    global $omigo_portal_url;
    $request = array('action' => 'get_submerchant_id');
    $omigos = get_option('omigos');
    $request['token'] = $omigos['token'];

    $response = wp_remote_get( $omigo_portal_url, array('body' => $request) );

	return json_decode($response['body']);
}

function omigo_scripts() {
    global $omigo_portal_url;
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', array(), null, false);

    wp_register_script('braintree_script', plugins_url( 'js/braintree-2.32.1.min.js', __FILE__ ));
	wp_register_script('omigo_script', plugins_url( 'js/omigo.js', __FILE__ ));
    wp_localize_script('omigo_script', 'omigoAjax', array('ajaxurl' => admin_url('admin-ajax.php'), 'pluginsUrl' => plugins_url(), 'donateNonce' => wp_create_nonce( 'omigo_donate_1' )));
    wp_localize_script('omigo_script', 'omigoPortal', array('ajaxurl' => $omigo_portal_url));
    wp_enqueue_script('braintree_script');
    wp_enqueue_script('omigo_script');
}
add_action('wp_enqueue_scripts','omigo_scripts');


// Load all of the styles that need to appear on all pages
function omigo_styles()
{
	wp_enqueue_style( 'omigo_styles', plugins_url( 'css/omigo.css', __FILE__ ));
}
add_action('wp_enqueue_scripts', 'omigo_styles');

function omigo_api_letter() {

    if (isset($_POST['omigo_email1']) && isset($_POST['omigo_letter_nonce'])) {
        if (wp_verify_nonce( $_REQUEST['omigo_letter_nonce'], 'save_omigo_letter')) {
            update_option('omigo_email1', sanitize_email($_POST['omigo_email1']));
            update_option('omigo_email2', sanitize_email($_POST['omigo_email2']));
            update_option('omigo_email3', sanitize_email($_POST['omigo_email3']));
            update_option('omigo_thankyou', sanitize_textarea_field($_POST['omigo_thankyou']));
            update_option('omigo_exempt_tax', sanitize_textarea_field($_POST['omigo_exempt_tax']));
            update_option('omigo_footer_message', sanitize_textarea_field($_POST['omigo_footer_message']));
            $omigos = get_option('omigos');
            if (is_array($omigos) && isset($omigos['token']) && !empty($omigos['token'])) {

                global $omigo_portal_url;
                $post = array(
                    'thankyou' => sanitize_textarea_field($_POST['omigo_thankyou']),
                    'tax_exempt' => sanitize_textarea_field($_POST['omigo_exempt_tax']),
                    'footer_message' => sanitize_textarea_field($_POST['omigo_footer_message']),
                    'token' => sanitize_text_field($omigos['token']),
                    'action' => 'update_tax_exempt',
                    'email1' => sanitize_email($_POST['omigo_email1']),
                    'email2' => sanitize_email($_POST['omigo_email2']),
                    'email3' => sanitize_email($_POST['omigo_email3']),
                );
                $response = wp_remote_post( $omigo_portal_url, array('body' => $post) );
            }
        }
        else {
             wp_nonce_ays();
        }
    }

    $email1 = get_option('omigo_email1', '');
    $email2 = get_option('omigo_email2', '');
    $email3 = get_option('omigo_email3', '');
    $thankyou = get_option('omigo_thankyou', '');
    //$exempt_tax = get_option('omigo_exempt_tax', 'YYY is a 501(c)(3) non-profit corporation. Federal Tax ID# XX-XXXXXXX. No goods or services were received in consideration for this gift. This email will serve as your tax receipt for filing purposes.');
    $exempt_tax = get_option('omigo_exempt_tax', '');
    $footer_message = get_option('omigo_footer_message', '');
    echo '<div class="wrap">
    <img src="' . plugin_dir_url( __FILE__ ) . '/img/omigo_logo.png" class="float-right">
    <h3>OMIGO Notifications</h3>';
    echo 'Use this section to set up notifications to you and your donors.';
    echo '<form method="post">';
    wp_nonce_field( 'save_omigo_letter', 'omigo_letter_nonce' );
    echo '<div class="letter-section">';
    echo 'When someone makes a donation, what emails would you like to use to receive notification?<br>(You may use up to 3)<br><br>';
    echo '<table>
        <tr><td>Email 1: </td><td><input type="email" name="omigo_email1" value="' . esc_attr($email1) . '" required> (mandatory)</td></tr>
        <tr><td>Email 2: </td><td><input type="email" name="omigo_email2" value="' . esc_attr($email2) . '"></td></tr>
        <tr><td>Email 3: </td><td><input type="email" name="omigo_email3" value="' . esc_attr($email3) . '"></td></tr>
    </table>';
    echo '</div>';
    echo '<div class="letter-section">';
    echo 'When people donate, they will receive an email with your custom information.
         This will be their receipt for tax purposes. What special message would you like to state?<br><br>';
    echo '<table class="omigo-email-text">
        <tr><td>Your "Thank you" message:</td><td><textarea placeholder="Write a special message to the person who donated" name="omigo_thankyou">' . esc_textarea($thankyou) . '</textarea></td></tr>
        <tr><td>Tax exempt statement:</td><td><textarea name="omigo_exempt_tax">' . esc_textarea($exempt_tax) . '</textarea></td></tr>
        <tr><td>Optional footer message:</td><td><textarea placeholder="Write an optional footer message. It can be your contact information, website, or social media connections." name="omigo_footer_message">' . esc_textarea($footer_message) . '</textarea></td></tr>
    </table>';
    echo '</div><br><input type="submit" value="Save changes" class="button button-primary">';
    echo '</form>';
    echo '</div>';
}

function omigo_api_donors() {
    echo '<div class="wrap">
	    <img src="' . plugin_dir_url( __FILE__ ) . '/img/omigo_logo.png" class="float-right">    
        <h3>OMIGO Donors</h3>';

    // Show donors
    global $omigo_portal_url;
    $omigos = get_option('omigos');
    if (is_array($omigos)) {
	    $post = array(
		    'token'  => $omigos['token'],
		    'action' => 'get_donor_list',
	    );

	    $response = wp_remote_post( $omigo_portal_url, array( 'body' => $post ) );
	    $results  = json_decode( $response['body'] );
    }
    else {
        $results = new stdClass();
    }
    if (isset($results->result) && !empty($results->result)) {
        echo '
            <table class="donors">
                <thead><tr><th>Name</th><th>Email</th><th>Donation</th><th>Date</th></thead>
                <tbody>
        ';

        foreach ($results->result as $row) {
            echo '<tr><td>' . sanitize_text_field($row->donor_name) . '</td><td>' . sanitize_email($row->donor_email) . '</td><td>$' . (float)$row->donation_amount . '</td><td>' . sanitize_text_field($row->donation_date) . '</td></tr>';
        }

        echo '</tbody></table>';
    }
    else {
      echo "No donations yet.";
    }

    echo '</div>';
}

function omigo_settings() {
    global $tos;

    //if (wp_verify_nonce( $_REQUEST['omigo_letter_nonce'], 'save_omigo_letter')) {
        /*update_option('omigo_email1', sanitize_email($_POST['omigo_email1']));
        update_option('omigo_email2', sanitize_email($_POST['omigo_email2']));
        update_option('omigo_email3', sanitize_email($_POST['omigo_email3']));
        update_option('omigo_thankyou', sanitize_textarea_field($_POST['omigo_thankyou']));
        update_option('omigo_exempt_tax', sanitize_textarea_field($_POST['omigo_exempt_tax']));
        update_option('omigo_footer_message', sanitize_textarea_field($_POST['omigo_footer_message']));
        $omigos = get_option('omigos');
        if (is_array($omigos) && isset($omigos['token']) && !empty($omigos['token'])) {


        }
    //}
    //else {
    //    wp_nonce_ays();
    //}*/

    ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap omiraf">

        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
        <?php settings_errors(); ?>
        <?php
            $tmp = get_option('omi_client_set', 0);
            $omigo_client_set = (isset($tmp) && $tmp) ? 1 : 0;
            print '<input type="hidden" id="omigo_options_nonce" value="' . wp_create_nonce( 'save_omigo_settings' ) . '">';
        ?>

        <!-- Create the form that will be used to render our options -->
        <form method="post" action="options.php">

            <div class="omigo-terms">
                <div><img src="<?php print plugin_dir_url( __FILE__ ) . '/img/omigo_logo.png'; ?>" ><br></div>
				<div><h3>Terms Of Service:</h3></div>
                <div class="tos-wrapper">
                    <?php print $tos; ?>
                </div>
                <br><br>

                <input type="checkbox" name="omigos[omigo_accept_terms]" id="omi_accept_terms" value="1"<?php print ($omigo_client_set) ? ' disabled="disabled" checked="checked"' : ''; ?>>
                 I accept the terms of service
                <br><br>
                 <?php submit_button(); ?>
            </div>

            <div class="omigo">
                <?php settings_fields( 'omigos' ); ?>
                <?php do_settings_sections( 'omigo' ); ?>
                <input type="hidden" name="omigos[omigo_client_set]" id="omi_client_set" value="<?php print $omigo_client_set; ?>">
                <?php

	            if (!$omigo_client_set) {
		            print '<h4>' . __('Please provide your token to activate the OMIGO services.', 'text-domain') . '<br><br>' . sprintf( wp_kses( __( 'If you are an individual, you can register for a token by clicking <a href="%s" target="_blank">here</a>.', 'text-domain' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://portal.omigo.org/signup/signup.php' ) ) . '<br><br>'    
					. sprintf( wp_kses( __( 'If you are a 501c3 organization, you must register for your token by clicking <a href="%s" target="_blank">here</a>.', 'text-domain' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://portal.omigo.org/organization-signup/signup.php' ) ) .
					
					'</h4>';
	            }
	            else {
	                $subid = omigo_get_submerchant_id();
	                $link = 'N/A';
	                if (!$subid->error) {
                        $link = 'https://payment.omigo.org/' . $subid->result . '/25/';
	                }
                    ?>
                    <div>
                        Your donation URL is:<br>
                        <div>
                            <input type="text" style="min-width: 400px;" value="<?php print $link; ?>" class="form-control" id="omigo-read-url" readonly> <input type="button" class="button button-primary" id="omigo-copy-url" value="Copy now">
                        </div>
                        <p>
                            Instructions: You can use your donation URL anywhere. You can use it on social media post, email, text messages, and even on websites. Just copy and paste.
                            It’s that simple. But there’s more! If you want to customize the amount of the donation, all you have to do is change the last number in the url to whatever whole dollar amount you want.
                            Right now the default is 25. Just change that number to whatever you want. Then when people click on the url link, your dollar amount will appear.  Remember: Do not delete the “/” . If you do, just add it.
                        </p>
                        <p>
                            <img src="<?php print plugin_dir_url( __FILE__ ) . '/img/omigo_url_image.png'; ?>" style="max-width: 620px;">
                        </p>
                    </div>
                    <?php
	            }
	            ?>

            </div>
        </form>
        <script>
            jQuery('#omigo-copy-url').on('click', function() {
                var textBox = document.getElementById("omigo-read-url");
                textBox.select();
                document.execCommand("copy");
            });

            jQuery(document).ready(function($){
              var mediaUploader;
              $('#upload_image_button').click(function(e) {
                e.preventDefault();
                  if (mediaUploader) {
                  mediaUploader.open();
                  return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                  title: 'Choose Image',
                  button: {
                  text: 'Choose Image'
                }, multiple: false });
                mediaUploader.on('select', function() {
                  var attachment = mediaUploader.state().get('selection').first().toJSON();
                  $('#background_image').val(attachment.url);
                  $('#omigo_bgsrc').attr('src', attachment.url);
                });
                mediaUploader.open();
              });
            });
        </script>

    </div><!-- /.wrap -->
    <?php
}


function omigo_donate_button($args = array()) {
    $color = isset($args['color']) ? $args['color'] : 'btn';
    $id = isset($args['id']) ? $args['id'] : substr(md5(mt_rand(0, 99999) . mt_rand(0, 99999)), 5, 12);
    $amount = isset($args['amount']) ? (int)$args['amount'] : NULL;
    $text = isset($args['text']) ? __($args['text'], 'text-domain') : __('Donate', 'text-domain');
    $nonce = wp_create_nonce( 'omigo_donate_0' );
	$content  = '<a href="#"' . (($amount) ? ' data-nonce="' . $nonce . '" data-amount="' . $amount . '"' : '') . ' id="' . esc_attr($id) . '" class="omigo-donate-button ' . str_replace(' ', '', esc_attr($color)) . '">' . $text . '</a>';

	return $content;
}
add_shortcode('omigo_donate_button', 'omigo_donate_button');


function omigo_pay_no_access() {
	print '404 Not found';
	die();
}

function set_omi_client_id() {
	$request = $_REQUEST;
	$client_id = sanitize_text_field($request['omi_client_id']);
	$bn = sanitize_text_field($request['business_name']);
	$ein = sanitize_text_field($request['ein']);
	$nonce = sanitize_text_field($request['nonce']);
	$error = 0;
	$msg = 'All good';

    // Verify nonce
	if (wp_verify_nonce( sanitize_text_field($nonce), 'save_omigo_settings' )) {
      update_option('omigo_exempt_tax', $bn . ' is a 501(c)(3) non-profit corporation. Federal Tax ID# ' . $ein . '. No goods or services were received in consideration for this gift. This email will serve as your tax receipt for filing purposes.');
      update_option('omi_client_id', $client_id);
      update_option('omi_client_set', 1);
      update_option('omigo_email1', sanitize_email($request['email']));
    }
    else {
        $error = 1;
        $msg = "Submit failed. Please try reloading the page and try again.";
    }

	print json_encode(array('error' => $error, 'msg' => $msg));
	die();
}


function create_sales_customer() {
    omigo_pay_init_payment();
    die();
}

// CURL needs to be installed on server
function omigo_pay_init_payment() {
    global $omigo_portal_url;
	Captcha::sessionStart();
	Captcha::sessionName('rafscaptcha');
    $request = $_REQUEST;
    $omigos = get_option('omigos');

    if (!wp_verify_nonce( sanitize_text_field($_REQUEST['wpnonce']), 'omigo_donate_0' ) && !wp_verify_nonce( sanitize_text_field($_REQUEST['wpnonce']), 'omigo_donate_1')) {
        print json_encode(array('error' => 1, 'error_msg' => 'Action is not allowed.'));
        return;
    }

	$captcha = $_REQUEST['rafscaptcha'];
    if (!Captcha::check($captcha)) {
	    print json_encode(array('error' => 1, 'error_msg' => 'Captcha is wrong. Please try again.'));
	    exit;
    }

    $request['token'] = $omigos['token'];
    $request['thankyou'] = get_option('omigo_thankyou', '');
    $request['footer_message'] = get_option('omigo_footer_message', '');
    $request['exempt_tax'] = get_option('omigo_exempt_tax', '');
    $request['email1'] = get_option('omigo_email1', '');
    $request['email2'] = get_option('omigo_email2', '');
    $request['email3'] = get_option('omigo_email3', '');

    $response = wp_remote_post( $omigo_portal_url, array('body' => $request, 'timeout' => 20) );

    if ( is_wp_error( $response ) ) {
        print json_encode(array('error' => 1, 'error_msg' => 'There was a problem retrieving the response from the server. Please send the error message to the domain owner. ' . print_r($response, TRUE)));
    }
    else {
        $res = json_decode($response['body']);
        $err = $res->error;
	    if ((int)$err == 0 && sanitize_text_field($request['ptype']) == "onetime") {
		    update_option('omigo_monthly_progress', (int)$res->result->donation_amount);
	    }
	    //error_log(print_r($response, TRUE));
        print $response['body'];
    }
    exit;
}

function omigo_get_captcha() {
	Captcha::sessionStart();
	Captcha::sessionName('rafscaptcha');
    Captcha::setNoise(array(5, 9), array(3, 7));
    Captcha::setBackground('transparent');
	Captcha::setLetters('ABCDEFGHJKLMNPRSTUVWXYZ123456789!&%#+?');
	print Captcha::img(array(3, 5), 240, 90);
    die();
}

function omigo_updated_option($option, $old_value, $value ) {
    if ($option == "omigos") {
        global $omigo_portal_url;
        $post = array(
            'background_image' => sanitize_textarea_field($value['background_image']),
            'token' => sanitize_text_field($value['token']),
            'action' => 'save_background_image',
        );
        $response = wp_remote_post( $omigo_portal_url, array('body' => $post) );
    }
}

function omigo_theme_options_init() {

    add_action("updated_option", "omigo_updated_option", 10, 3);
	add_action("wp_ajax_create_sales_customer", "create_sales_customer");
    add_action("wp_ajax_nopriv_create_sales_customer", "create_sales_customer");

    add_action("wp_ajax_get_captcha", "omigo_get_captcha");
    add_action("wp_ajax_nopriv_get_captcha", "omigo_get_captcha");

	add_action("wp_ajax_set_omi_client_id", "set_omi_client_id");
	add_action("wp_ajax_nopriv_set_omi_client_id", "omigo_pay_no_access");


	if( false == get_option( 'omigos' ) ) {
		add_option( 'omigos' );
	}

	add_settings_section(
		'omigo_settings_section',            // ID used to identify this section and with which to register options
		'OMIGO Frundraising Account Registration For Individuals and Organizations',                  // Title to be displayed on the administration page
		'omigo_options_callback',   // Callback used to render the description of the section
		'omigo'                           // Page on which to add this section of options
	);

	add_settings_field(
		'token',                  // ID used to identify the field throughout the theme
		'Token',                  // The label to the left of the option interface element
		'omigo_field_token_callback',   // The name of the function responsible for rendering the option interface
		'omigo',                  // The page on which this option will be displayed
		'omigo_settings_section'  // The name of the section to which this field belongs
	);

	add_settings_section(
		'omigo_settings3_section',      // ID used to identify this section and with which to register options
		'',                             // Title to be displayed on the administration page
		'omigo_options_callback',   // Callback used to render the description of the section
		'omigo'                         // Page on which to add this section of options
	);

	add_settings_field(
		'monthly_budget',                  // ID used to identify the field throughout the theme
		'Monthly Budget Goal',  // The label to the left of the option interface element
		'omigo_field_monthly_budget_callback',   // The name of the function responsible for rendering the option interface
		'omigo',                   // The page on which this option will be displayed
		'omigo_settings3_section',  // The name of the section to which this field belongs
		array('class' => 'budget-class')
	);

	add_settings_field(
		'payment_image',                  // ID used to identify the field throughout the theme
		'Payment image (used on payment.omigo.org)',  // The label to the left of the option interface element
		'omigo_field_payment_image_callback',   // The name of the function responsible for rendering the option interface
		'omigo',                   // The page on which this option will be displayed
		'omigo_settings3_section',  // The name of the section to which this field belongs
		array('class' => 'budget-file-class')
	);

	register_setting(
		'omigos',
		'omigos',
		'omi_strip_tags'
	);

}
add_action( 'admin_init', 'omigo_theme_options_init' );

function omigo_options_callback() {}

function omigo_field_token_callback($args) {
	$options = get_option('omigos');
	if (is_array($options)) {
	    $value = esc_attr($options['token']);
	}
	else {
        $value = '';
	}
	$html = '<input type="text" id="token" name="omigos[token]" size="44" value="' . $value . '" required>';
	echo $html;
}

function omigo_field_monthly_budget_callback($args) {
	$options = get_option('omigos');
	if (is_array($options)) {
	    $value = esc_attr($options['monthly_budget']);
	}
	else {
        $value = '';
	}
	$html = '<input type="text" id="monthly_budget" name="omigos[monthly_budget]" value="' . $value . '" required>';
	echo $html;
}
function omigo_field_payment_image_callback($args) {
	$options = get_option('omigos');
	if (is_array($options)) {
	    $p = $options['background_image'] ?? null;
	}
	else {
        $p = NULL;
	}

    $html = '<input id="background_image" type="text" name="omigos[background_image]" style="width: 250px;" value="' . $p . '" />' .
        '<input id="upload_image_button" type="button" class="button-primary" value="Choose new image" />';
    if ($p) {
        $html .= '<div style="margin-top: 25px;margin-bottom:25px;"><img src="' . $p . '" id="omigo_bgsrc" style="max-width: 400px;max-height: 300px; width: auto; height: auto;" /></div>';
    }
	echo $html;
}

function omigo_uninstall() {
	update_option('omi_client_id', '');
	update_option('omigos', '');
	update_option('omi_client_set', 0);
}
register_uninstall_hook(__FILE__, 'omigo_uninstall');
register_deactivation_hook(__FILE__, 'omigo_uninstall');

class omigo_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'omigo_widget',
            'Omigo payment widget',
            array( 'description' => 'Shows the monthly payment box')
        );
    }
    public function widget( $args, $instance ) {
        global $wpdb;

        $amount = (int)get_option('omigo_monthly_progress', 0);

        $option = get_option('omigos', 0);
        if (!is_array($option) || !isset($option['monthly_budget']) || empty($option['monthly_budget'])) {
            $option = [];
            $option['monthly_budget'] = 0;
        }
        $monthly_budget = number_format($option['monthly_budget'], 0, '', ',');
        if (!$option['monthly_budget']) {
            $progress = 0;
        }
        else {
            $progress = (int)$amount / (int)$option['monthly_budget'];
        }
        $progress = $progress * 100;
        if ($progress > 100) {
            $progress = 100;
        }

        $nonce = wp_create_nonce( 'omigo_donate_0' );
        echo '
        <div>
            <div class="one-time-donation-wrapper">
                <div class="label-monthly-budget">
                    <h2>Monthly Goal</h2>
                </div>
                <div class="monthly-budget">
                    <span class="omigo-dollar-sign">$</span>' . $monthly_budget . '
                </div>
                <div class="monthly-progress">
                    <div class="meter">
                        <span style="width: ' . round($progress) . '%;' . ((round($progress) == 100) ? ' border-top-right-radius:20px;border-bottom-right-radius:20px;' : '') . '"></span>
                    </div>
                    $' . $amount . ' raised towards monthly goal
                </div>
                <div class="enter-one-time">
                    <span class="bold">Enter your ONE-TIME donation</span>
                </div>
                <div class="one-time-donation-input-wrapper">
                    $<input type="text" value="" name="one_time_donation_amount" id="one-time-donation-amount" maxlength="5">.00
                    <span class="one-time-donation-currency">&nbsp;USD</span>
                </div>

                <div class="one-time-donation-recurring">
                    <input type="checkbox" value="1" name="one_time_donation_recurring" id="one-time-donation-recurring"> Make this a monthly recurring payment
                </div>

                <div class="one-time-donation-submit-wrapper">
                    <img src="' . plugin_dir_url( __FILE__ ) . 'img/omigo_small_logo.png" class="omigo-image-widget">
                    <input type="hidden" value="' . $nonce . '" id="omigowpnonce" name="omigowpnonce">
                    <button type="button" id="one-time-donate-submit" class="btn btn-success wepay-ifr">Donate</button>
                </div>
            </div>
        </div>';
    }

    public function form( $instance ) {

    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        return $instance;
    }
}


function omigo_load_custom_widgets() {
    register_widget( 'omigo_widget' );
}
add_action( 'widgets_init', 'omigo_load_custom_widgets' );

function omigo_get_monthly_goal_status() {
    global $omigo_portal_url;
    $request = array('action' => 'get_monthly_status');
    $omigos = get_option('omigos');
    $request['token'] = $omigos['token'];

    $response = wp_remote_post( $omigo_portal_url, array('body' => $request) );
    $res = json_decode($response['body']);
    if ((int)$res->error == 0) {
        update_option('omigo_monthly_progress', (int)$res->result->donation_amount);
    }
}
add_action( 'omigo_cron_once_a_day',    'omigo_get_monthly_goal_status' );

function omigo_activate() {
    wp_schedule_event(time() + 100, 'daily', 'omigo_cron_once_a_day');
}

function omigo_deactivate() {
    wp_clear_scheduled_hook('omigo_cron_once_a_day');
}

register_activation_hook( __FILE__, 'omigo_activate' );
register_deactivation_hook( __FILE__, 'omigo_deactivate' );

/* Include the sweet alert */
function sweet_omigo_scripts(){
	wp_enqueue_style( 'swal_css', plugin_dir_url( __FILE__ ).'css/sweet-alert.css' );
	wp_register_script('swal_js', plugin_dir_url( __FILE__ ).'js/sweet-alert.min.js', array(), false, true);
	wp_enqueue_script('swal_js');
}
add_action('wp_enqueue_scripts','sweet_omigo_scripts');

// Use only hostname as referer when using cURL
add_action('http_api_curl', function( $handle ){
    curl_setopt($handle, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
 }, 10);

