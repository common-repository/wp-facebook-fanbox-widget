<?php
if (!defined('ABSPATH'))
     exit; // Exit if accessed directly

function ViFbFanBox_fb_wp_head() {
     global $wp_version;
     if (isset($_GET['page']) && "fb_box_settings" == $_GET['page']) {
          wp_enqueue_script('fb_main_script', plugins_url('js/script.js', __FILE__));
          wp_enqueue_style('tip_stylesheet', plugins_url('css/jquery.tooltip.css', __FILE__));
          wp_enqueue_script('tip_script', plugins_url('js/jquery.tooltip.js', __FILE__));
          wp_enqueue_script('tip_myscript', plugins_url('js/myscript.js', __FILE__));
     }
     if ($wp_version < 3.8)
          wp_enqueue_style('fb_old_stylesheet', plugins_url('css/wp3.8_lesser.css', __FILE__));
     else
          wp_enqueue_style('fb_current_stylesheet', plugins_url('css/style.css', __FILE__));
}

function ViFbFanBox_fb_like_bx_settings_page() {
     $fb_like_bx_settings = get_option('fb_like_bx_options');
     $copy = false;
     $message = $error = "";
     $shortcode = '';
     $plugin_info = get_plugin_data(__FILE__);
     if (isset($_REQUEST['fb_form_submit']) && check_admin_referer(plugin_basename(__FILE__), 'fb_nonce')) {
          $options['streams'] = sanitize_text_field($_REQUEST['streams']);
          $options['borderdisp'] = sanitize_text_field($_REQUEST['borderdisp']);
          $options['colorScheme'] = sanitize_text_field($_REQUEST['colorScheme']);
          $options['showFaces'] = sanitize_text_field($_REQUEST['showFaces']);
          $options['header'] = sanitize_text_field($_REQUEST['header']);
          $options['lang'] = sanitize_text_field($_REQUEST['lang']);
          ViFbFanBox_fb_like_bx_update_options($options);
          $fb_like_bx_settings = get_option('fb_like_bx_options');
     }
     ?>

     <div class="fb_like_bx_wrap">
          <div class="icon32 icon32-bws" id="icon-options-general"></div>

          <div class="postbox settings_wrap left">

               <h3 class="hndle" style="padding:10px;"><?php _e("FB Fan Box Settings", "viva-fb-fanbox") ?></h3>
               <div class="inside">
                    <div class="updated fade" <?php if (empty($message) || "" != $error) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
                    <div id="fb_admin_notice" class="updated fade" style="display:none"><p><strong>Notice:</strong>
                              <?php _e("Plugin's settings have been changed. To save them please click the 'Save Changes' button before navigating away the page.", "viva-fb-fanbox") ?> </p></div>
                    <div class="error" <?php if ("" == $error) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>

                    <?php if (!isset($_GET['action'])) { ?>
                         <form name="form1" method="post" action="" enctype="multipart/form-data" id="fcbkbttn_settings_form">

                              <table class="form-table">
                                   <tr>
                                        <th>
                                             <?php _e("Show Posts:", "viva-fb-fanbox") ?>								
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline"><div class="cmb_radio_inline_option">
                                                       <input type="radio" name="streams" id="streams1" value="yes" <?php
                                                       if (isset($fb_like_bx_settings['streams']) && $fb_like_bx_settings['streams'] == "yes") {
                                                            echo 'checked="checked"';
                                                       }
                                                       ?>><label for="streams1">Yes</label></div>
                                                  <div class="cmb_radio_inline_option"><input type="radio" name="streams" id="streams2" value="no" <?php
                                                       if (isset($fb_like_bx_settings['streams']) && $fb_like_bx_settings['streams'] == "no") {
                                                            echo 'checked';
                                                       }
                                                       ?>><label for="streams2">No</label></div>
                                                  <img border="0"  class="tip" value="Tipisset( $_REQUEST['fb_form_submit'] )" src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="Specifies whether to display a stream of the latest posts by the Page.">
                                             </div>
                                        </td>
                                   </tr>

                                   <tr>
                                        <th>
                                                       <?php _e("Colour Scheme:", "viva-fb-fanbox") ?>								
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline"><div class="cmb_radio_inline_option">
                                                       <input type="radio" name="colorScheme" id="colorScheme1" value="light" <?php
                                                                                              if (isset($fb_like_bx_settings['colorScheme']) && $fb_like_bx_settings['colorScheme'] == "light") {
                                                                                                   echo 'checked';
                                                                                              }
                                                                                              ?>><label for="colorScheme1">Light</label></div>
                                                  <div class="cmb_radio_inline_option"><input type="radio" name="colorScheme" id="colorScheme2" value="dark" <?php
                                                                                              if (isset($fb_like_bx_settings['colorScheme']) && $fb_like_bx_settings['colorScheme'] == "dark") {
                                                                                                   echo 'checked';
                                                                                              }
                                                                                              ?>><label for="colorScheme2">Dark</label></div>
                                                  <img border="0" class="tip" value="Tip" src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="The color scheme used by the plugin. Can be 'light' or 'dark'.">
                                             </div>
                                        </td>
                                   </tr>
                                   <tr>
                                        <th>
                                                       <?php _e("Show Border:", "viva-fb-fanbox") ?>								
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline"><div class="cmb_radio_inline_option">
                                                       <input type="radio" name="borderdisp" id="borderdisp1" value="yes" <?php
                                             if (isset($fb_like_bx_settings['borderdisp']) && $fb_like_bx_settings['borderdisp'] == "yes") {
                                                  echo 'checked';
                                             }
                                             ?>><label for="borderdisp1">Yes</label></div>
                                                  <div class="cmb_radio_inline_option"><input type="radio" name="borderdisp" id="borderdisp2" value="no" <?php
                                             if (isset($fb_like_bx_settings['borderdisp']) && $fb_like_bx_settings['borderdisp'] == "no") {
                                                  echo 'checked';
                                             }
                                             ?>><label for="borderdisp2">No</label></div>
                                                  <img border="0"  class="tip" value="Tip" src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="Specifies whether or not to show a border around the plugin.">
                                             </div>
                                        </td>
                                   </tr>
                                   <tr>
                                        <th>
          <?php _e("Show Friends' Faces:", "viva-fb-fanbox") ?>								
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline"><div class="cmb_radio_inline_option">
                                                       <input type="radio" name="showFaces" id="showFaces1" value="yes" <?php
          if (isset($fb_like_bx_settings['showFaces']) && $fb_like_bx_settings['showFaces'] == "yes") {
               echo 'checked';
          }
          ?>><label for="showFaces1">Yes</label></div>
                                                  <div class="cmb_radio_inline_option"><input type="radio" name="showFaces" id="showFaces2" value="no"  <?php
                                                              if (isset($fb_like_bx_settings['showFaces']) && $fb_like_bx_settings['showFaces'] == "no") {
                                                                   echo 'checked';
                                                              }
                                                              ?>><label for="showFaces2">No</label></div>
                                                  <img border="0"  value="Tip" class="tip" src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="Specifies whether to display profile photos of people who like the page.">
                                             </div>
                                        </td>
                                   </tr>
                                   <tr>
                                        <th>
                                             <?php _e("Show Header:", "viva-fb-fanbox") ?>							
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline"><div class="cmb_radio_inline_option">
                                                       <input type="radio" name="header" id="header1" value="yes" <?php
                                   if (isset($fb_like_bx_settings['header']) && $fb_like_bx_settings['header'] == "yes") {
                                        echo 'checked';
                                   }
                                             ?>><label for="header1">Yes</label></div>
                                                  <div class="cmb_radio_inline_option"><input type="radio" name="header" id="header2" value="no" <?php
                                                       if (isset($fb_like_bx_settings['header']) && $fb_like_bx_settings['header'] == "no") {
                                                            echo 'checked';
                                                       }
                                                       ?>><label for="header2">No</label></div>
                                                  <img border="0"  value="Tip" class="tip" title="Specifies whether to display the Facebook header at the top of the plugin." src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="Show the 'Find Us on Facebook' header on the plugin">
                                             </div>
                                        </td>
                                   </tr>						
                                   <tr>
                                        <th>
                                                       <?php _e("Select Your Language:", "viva-fb-fanbox") ?>								
                                        </th>
                                        <td>
                                             <div class="cmb_radio_inline">
                                                  <div class="cmb_radio_inline_option">

                                                       <?php
                                                       $lang = array();
                                                       $lang['af_ZA'] = 'Afrikaans';
                                                       $lang['sq_AL'] = 'Albanian';
                                                       $lang['ar_AR'] = 'Arabic';
                                                       $lang['hy_AM'] = 'Armenian';
                                                       $lang['ay_BO'] = 'Aymara';
                                                       $lang['az_AZ'] = 'Azeri';
                                                       $lang['eu_ES'] = 'Basque';
                                                       $lang['be_BY'] = 'Belarusian';
                                                       $lang['bn_IN'] = 'Bengali';
                                                       $lang['bs_BA'] = 'Bosnian';
                                                       $lang['bg_BG'] = 'Bulgarian';
                                                       $lang['ca_ES'] = 'Catalan';
                                                       $lang['ck_US'] = 'Cherokee';
                                                       $lang['hr_HR'] = 'Croatian';
                                                       $lang['cs_CZ'] = 'Czech';
                                                       $lang['da_DK'] = 'Danish';
                                                       $lang['nl_NL'] = 'Dutch';
                                                       $lang['nl_BE'] = 'Dutch (Belgi?)';
                                                       $lang['en_GB'] = 'English (UK)';
                                                       $lang['en_PI'] = 'English (Pirate)';
                                                       $lang['en_UD'] = 'English (Upside Down)';
                                                       $lang['en_US'] = 'English (US)';
                                                       $lang['eo_EO'] = 'Esperanto';
                                                       $lang['et_EE'] = 'Estonian';
                                                       $lang['fo_FO'] = 'Faroese';
                                                       $lang['tl_PH'] = 'Filipino';
                                                       $lang['fi_FI'] = 'Finnish';
                                                       $lang['fb_FI'] = 'Finnish (test)';
                                                       $lang['fr_CA'] = 'French (Canada)';
                                                       $lang['fr_FR'] = 'French (France)';
                                                       $lang['gl_ES'] = 'Galician';
                                                       $lang['ka_GE'] = 'Georgian';
                                                       $lang['de_DE'] = 'German';
                                                       $lang['el_GR'] = 'Greek';
                                                       $lang['gn_PY'] = 'Guaran?';
                                                       $lang['gu_IN'] = 'Gujarati';
                                                       $lang['he_IL'] = 'Hebrew';
                                                       $lang['hi_IN'] = 'Hindi';
                                                       $lang['hu_HU'] = 'Hungarian';
                                                       $lang['is_IS'] = 'Icelandic';
                                                       $lang['id_ID'] = 'Indonesian';
                                                       $lang['ga_IE'] = 'Irish';
                                                       $lang['it_IT'] = 'Italian';
                                                       $lang['ja_JP'] = 'Japanese';
                                                       $lang['jv_ID'] = 'Javanese';
                                                       $lang['kn_IN'] = 'Kannada';
                                                       $lang['kk_KZ'] = 'Kazakh';
                                                       $lang['km_KH'] = 'Khmer';
                                                       $lang['tl_ST'] = 'Klingon';
                                                       $lang['ko_KR'] = 'Korean';
                                                       $lang['ku_TR'] = 'Kurdish';
                                                       $lang['la_VA'] = 'Latin';
                                                       $lang['lv_LV'] = 'Latvian';
                                                       $lang['fb_LT'] = 'Leet Speak';
                                                       $lang['li_NL'] = 'Limburgish';
                                                       $lang['lt_LT'] = 'Lithuanian';
                                                       $lang['mk_MK'] = 'Macedonian';
                                                       $lang['mg_MG'] = 'Malagasy';
                                                       $lang['ms_MY'] = 'Malay';
                                                       $lang['ml_IN'] = 'Malayalam';
                                                       $lang['mt_MT'] = 'Maltese';
                                                       $lang['mr_IN'] = 'Marathi';
                                                       $lang['mn_MN'] = 'Mongolian';
                                                       $lang['ne_NP'] = 'Nepali';
                                                       $lang['se_NO'] = 'Northern S?mi';
                                                       $lang['nb_NO'] = 'Norwegian (bokmal)';
                                                       $lang['nn_NO'] = 'Norwegian (nynorsk)';
                                                       $lang['ps_AF'] = 'Pashto';
                                                       $lang['fa_IR'] = 'Persian';
                                                       $lang['pl_PL'] = 'Polish';
                                                       $lang['pt_BR'] = 'Portuguese (Brazil)';
                                                       $lang['pt_PT'] = 'Portuguese (Portugal)';
                                                       $lang['pa_IN'] = 'Punjabi';
                                                       $lang['qu_PE'] = 'Quechua';
                                                       $lang['ro_RO'] = 'Romanian';
                                                       $lang['rm_CH'] = 'Romansh';
                                                       $lang['ru_RU'] = 'Russian';
                                                       $lang['sa_IN'] = 'Sanskrit';
                                                       $lang['sr_RS'] = 'Serbian';
                                                       $lang['zh_CN'] = 'Simplified Chinese (China)';
                                                       $lang['sk_SK'] = 'Slovak';
                                                       $lang['sl_SI'] = 'Slovenian';
                                                       $lang['so_SO'] = 'Somali';
                                                       $lang['es_LA'] = 'Spanish';
                                                       $lang['es_CL'] = 'Spanish (Chile)';
                                                       $lang['es_CO'] = 'Spanish (Colombia)';
                                                       $lang['es_MX'] = 'Spanish (Mexico)';
                                                       $lang['es_ES'] = 'Spanish (Spain)';
                                                       $lang['sv_SE'] = 'Swedish';
                                                       $lang['sy_SY'] = 'Syriac';
                                                       $lang['tg_TJ'] = 'Tajik';
                                                       $lang['ta_IN'] = 'Tamil';
                                                       $lang['tt_RU'] = 'Tatar';
                                                       $lang['te_IN'] = 'Telugu';
                                                       $lang['th_TH'] = 'Thai';
                                                       $lang['zh_HK'] = 'Traditional Chinese (Hong Kong)';
                                                       $lang['zh_TW'] = 'Traditional Chinese (Taiwan)';
                                                       $lang['tr_TR'] = 'Turkish';
                                                       $lang['uk_UA'] = 'Ukrainian';
                                                       $lang['ur_PK'] = 'Urdu';
                                                       $lang['uz_UZ'] = 'Uzbek';
                                                       $lang['vi_VN'] = 'Vietnamese';
                                                       $lang['cy_GB'] = 'Welsh';
                                                       $lang['xh_ZA'] = 'Xhosa';
                                                       $lang['yi_DE'] = 'Yiddish';
                                                       $lang['zu_ZA'] = 'Zulu';
                                                       ?>
                                                       <select name="lang">
                         <?php
                         foreach ($lang as $key => $val) {
                              $selected = '';
                              if ($fb_like_bx_settings['lang'] == $key)
                                   $selected = "selected";
                              echo '<option value="' . $key . '" ' . $selected . ' >' . $val . '</option>';
                         }
                         ?>
                                                       </select><img border="0"  value="Tip" class="tip" title="Select the language for FB Fanbox" src="<?php echo plugins_url('images/help.png', __FILE__) ?>" title="Show the 'Find Us on Facebook' header on the plugin">
                                                  </div>
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="2">
                                             <input type="hidden" name="fb_form_submit" value="submit" />
                                             <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'viva-fb-fanbox') ?>" />
                                        </td>
                                   </tr>
                              </table>
          <?php wp_nonce_field(plugin_basename(__FILE__), 'fb_nonce'); ?>
                         </form>
     <?php } ?>
               </div>
          </div>
           <div class="right">
                    <center>
                         <div class="bottom">
                              <h3 id="download-comments-wvpd" class="title"><?php _e('Download Free Plugins', 'wvpd'); ?></h3>

                              <div id="downloadtbl-comments-wvpd" class="togglediv">  
                                   <h3 class="company">
                                        <p class='p_content_left_info'> Startbit IT Solutions Pvt. Ltd. is an ISO 9001:2008 Certified Company is a Global IT Services company with expertise in outsourced product development and custom software development with focusing on software development, IT consulting, customized development.We have 200+ satisfied clients worldwide.</p>	
     <?php _e('Our Top 5 Latest Plugins', 'wvpd'); ?>:
                                   </h3>
                                   <ul class="social_link_ul">
                                        <li><a target="_blank" href="https://wordpress.org/plugins/woocommerce-social-buttons/">Woocommerce Social Buttons</a></li>
                                        <li><a target="_blank" href="https://wordpress.org/plugins/vi-random-posts-widget/">Vi Random Post Widget</a></li>
                                        <li><a target="_blank" href="http://wordpress.org/plugins/wp-infinite-scroll-posts/">WP EasyScroll Posts</a></li>
                                        <li><a target="_blank" href="https://wordpress.org/plugins/buddypress-social-icons/">BuddyPress Social Icons</a></li>
                                        <li><a target="_blank" href="http://wordpress.org/plugins/wp-fb-share-like-button/">WP FB Share & Like Button</a></li>
                                   </ul>
                              </div> 
                         </div>		
                    </center>


               </div>

     </div>
     <div class="clear"></div>
     <div class="postbox">
          <h3 class="hndle" style="padding:10px;"><span>ShortCode</span></h3>
          <div class="inside">
               You can use this shortcode in your code, where you want to display this FB Fanbox.
               <br>	
               <br>	
     <?php
     $shortcode = '';

     $shortcode = '[facebook_fanbox  href=""  appid=""  language=""  width=""  height=""  colorscheme=""  showfaces=""  header=""  stream=""  showborder="" ]';

     echo $shortcode;
     ?>
               <br><br>
     <?php _e('You can edit these parameter according self in shortcode and use.', 'viva-fb-fanbox'); ?><br><br>
               <p>
                    href = <?php _e('Give your valid Facebook Pageurl like www.facebook.com/example.', 'viva-fb-fanbox'); ?> <br>
                    appid = <?php _e('Give your valid Facebook AppId.', 'viva-fb-fanbox'); ?> <br>
                    language = <?php _e('Give language code.', 'viva-fb-fanbox'); ?> <br>
                    width = <?php _e('Give the width.', 'viva-fb-fanbox'); ?> <br>
                    height = <?php _e('Give the height.', 'viva-fb-fanbox'); ?> <br>
                    colorscheme = <?php _e('Give one of these value : dark,light', 'viva-fb-fanbox'); ?> <br>
                    showfaces = <?php _e('Give one of these value : true,false', 'viva-fb-fanbox'); ?> <br>
                    header = <?php _e('Give one of these value : true,false', 'viva-fb-fanbox'); ?> <br>
                    stream = <?php _e('Give one of these value : true,false', 'viva-fb-fanbox'); ?> <br>
                    showborder = <?php _e('Give one of these value : true,false', 'viva-fb-fanbox'); ?> <br> 
               </p>
          </div>
     </div>
     <?php
}

function ViFbFanBox_fb_like_bx_update_options($data) {
     update_option('fb_like_bx_options', $data);
}

function ViFbFanBox_fb_admin_init_menu() {
     add_menu_page('VIVA Plugins', 'VIVA Plugins', 'manage_options', 'viva_plugins', 'ViFbFanBox_fb_like_bx_settings_page', '', 1001);
     add_submenu_page('viva_plugins', 'FB FanBox Settings', 'FB FanBox', 'manage_options', "fb_box_settings", 'ViFbFanBox_fb_like_bx_settings_page');
}

// The shortcode callback
function ViFbFanBox_facebook_generate_code($atts) {
     $content = '';
     extract(shortcode_atts(array(
         'href' => '',
         'appid' => '',
         'language' => 'en_US',
         'width' => '250',
         'height' => '260',
         'colorscheme' => 'dark',
         'showfaces' => 'true',
         'header' => 'true',
         'stream' => 'false',
         'showborder' => 'true'
                     ), $atts));
     echo '<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/' . $language . '/all.js#xfbml=1&appId=' . $appid . '";fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
     $content = "<fb:like-box href=\"$href\" width=\"$width\" height=\"$height\" show_faces=\"$showfaces\" border_color=\"$showborder\" stream=\"$stream\" header=\"$header\" data-colorscheme=\"$colorscheme\" data-show-border=\"$showborder\"></fb:like-box>";
     return $content;
}

add_shortcode('facebook_fanbox', 'ViFbFanBox_facebook_generate_code');
add_action('admin_menu', 'ViFbFanBox_fb_admin_init_menu');
add_action('wp_enqueue_scripts', 'ViFbFanBox_fb_wp_head');
add_action('admin_enqueue_scripts', 'ViFbFanBox_fb_wp_head');
?>