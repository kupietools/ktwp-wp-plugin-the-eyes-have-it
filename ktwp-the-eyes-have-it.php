<?php
/*
Plugin Name: KupieTools The Eyes Have It
Description: It's watching you. Eyes on your WordPress page, watching your every move, watching, always watching. Built with the KTWP KupieTools WordPress Plugin Framework
Version: 1.0
Author: Michael Kupietz
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


/* add section for this plugin to KupieTools admin area menu, if desired, otherwise remove this section */

add_action('admin_menu', function () {
    global $menu;
    $exists = false;
    
    if ($menu) {
        foreach($menu as $item) {
            if (isset($item[0]) && $item[0] === 'KupieTools') {
                $exists = true;
                break;
            }
        }
    }
    
    if (!$exists) {
        add_menu_page(
            'KupieTools Settings',
            'KupieTools',
            'manage_options',
            'kupietools',
            function() {
                echo '<div class="wrap"><h1>KupieTools</h1>';
                do_action('kupietools_sections');
                echo '</div>';
            },
            'dashicons-admin-tools'
        );
    }
});


// Register settings
    add_action('admin_init', function() {
        register_setting('ktwp_eyesHaveIt_options', 'ktwp_eyesHaveIt_checkbox_1');
    });
    

// Add THIS plugin's section
    add_action('kupietools_sections', function() {
        ?>
        <details class="card ktwpcache" style="max-width: 800px; padding: 20px; margin-top: 20px;" open="true">
            <summary style="font-weight:bold;">The Eyes Have It settings</summary>
            <!-- SETTINGS SECTION DESCRIPTION OR INSTRUCTIONS GO HERE -->
            <form method="post" action="options.php">
                <?php
                settings_fields('ktwp_eyesHaveIt_options');
                ?>
                <div>
                    <p>
                        <label>
                            <input type="checkbox" name="ktwp_eyesHaveIt_checkbox_1" value="1" 
                                <?php checked(get_option('ktwp_eyesHaveIt_checkbox_1', '1'), '1'); /* default checked */ ?>> 
                            <strong>Blink</strong>
                        </label>
                    </p>
                  
                </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        </details>
        <?php
    });
//}); 

$blink = get_option('ktwp_eyesHaveIt_checkbox_1','1'); /* default checked, if never set before */
 
 /* End Kupietools menu entry */


/* Create UI Tab if desired. Otherwise remove this section */

// Add the control panel HTML and required scripts/styles
function ktwp_eyesHaveIt_enqueue_assets() {
    wp_enqueue_style('ktwp_eyesHaveIt-styles', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('ktwp_eyesHaveIt-script', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'ktwp_eyesHaveIt_enqueue_assets');



/* if you want to display the panel in a wordpress page with a shortcode, this will let you. Remove this if not needed. */
add_shortcode("ktwp_eyes","ktwp_eyesHaveIt_plugin_content");
/* end shortcode */


//function to generate the plugin visual content
function ktwp_eyesHaveIt_plugin_content($args = [], $content = null /* you can remove these parameters if you're not using a shortcode */) {
/* you can remove this shortcode parameter block if you're not using a shortcode */
$args = shortcode_atts(
        [
            "blink" => "1"
        ],
        $args,
        "ktwp_eyesHaveIt_plugin_content"
    );
 /* end of shortcode parameter block */   
?>

            <div class="ktwp_eyesHaveIt-panel-content">
              <!-- PANEL CONTENT HERE -->
		 <div class="ktwp-wp-eyes-eye">
            <div class="ktwp-wp-eyes-pupil"></div>
        </div>
        <div class="ktwp-wp-eyes-eye">
            <div class="ktwp-wp-eyes-pupil"></div>
        </div>
            </div>
			<!-- <button id="ktwp_eyesHaveIt-reset-button" style="width: 100%; padding: 8px; background: #808080; color: white; border: none; border-radius: 3px; cursor: pointer; margin-top: 10px;">RESET BUTTON TEXT, IF YOU WANT ONE</button> -->
   
       <?php
}


// Add the popup control panel HTML to the footer
function ktwp_eyesHaveIt_add_control_panel_popup() {
/*note: ktwp-kupietabs-tab-div class will identify all tabs created this way so other instances of this framework—or any other plugin, like KupieTools Draggable Elements for instance—can find them. */
    ?>
    <div id="ktwp_eyesHaveIt-control" class="ktwp_eyesHaveIt-control">
       <button class="ktwp_eyesHaveIt-icon">
    <!-- TO-DO NOTE: maybe add a title attribute here later, and make KupieTools Draggable Elements add its "drag me" text, rather than just replacing it, if it doesn't do that already. Or, um, does it do that on the parent #ktwp_eyesHaveIt-control div? Check this. -->
    <!-- ICON GOES HERE, INCLUDING EITHER AN HREF, A JAVASCRIPT CALL TO  -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.015 7c4.751 0 8.063 3.012 9.504 4.636-1.401 1.837-4.713 5.364-9.504 5.364-4.42 0-7.93-3.536-9.478-5.407 1.493-1.647 4.817-4.593 9.478-4.593zm0-2c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 7l-3.36-2.171c-.405.625-.64 1.371-.64 2.171 0 2.209 1.791 4 4 4s4-1.791 4-4-1.791-4-4-4c-.742 0-1.438.202-2.033.554l2.033 3.446z"/></svg>
    <span class="ktwp_eyesHaveIt-hover-text">Open Your Eyes</span>
</button>
		
    </div> <div ID="ktwp_eyesHaveIt-panel" class="ktwp_eyesHaveIt-panel ktwp-kupietabs-panel-div">
            <div class="ktwp_eyesHaveIt-panel-header">
               <!--  <span>PANEL TITLE GOES HERE</span>  -->
                <button class="ktwp_eyesHaveIt-close-button">&times;</button>
            </div>
<?php ktwp_eyesHaveIt_plugin_content() ?>
            </div>
<script id="ktwp_eyesHaveIt-inline_script">
/* stop event listeners from bubbling */	['mousedown','mouseover','mousemove','dragstart','touchstart','touchmove','click'].forEach(thisAction => {
const thisPan=document.getElementById("ktwp_eyesHaveIt-panel");
if(thisPan) {thisPan.addEventListener(thisAction, function(event) { event.stopPropagation();});}

});

/* I originally created a parent container so I could have a flexbox to append the divs to as children so multiple plugins' tabs stacked automatically; but I decided that's not needed, I'll just count the kupietab elements and multiply to calculate the right top, so it's set explicitly. 
*/

/* move the new tab to stack under tabs from other KupieTools plugins, if desired (which it probably is.) Remove this section if you don't want that. */ 
const ktwp_eyesHaveIt_numOfKupieTabs=document.getElementsByClassName("ktwp-kupietabs-tab-div").length; /* start at 0 so no offset from 182px */
const ktwp_eyesHaveIt_thisTab=document.getElementById("ktwp_eyesHaveIt-control");
	ktwp_eyesHaveIt_thisTab.classList.add("ktwp-kupietabs-tab-div"); /* have to do it this way because sometimes page optimizers defer scripts... this might not run at all until after all tabs have been added to the page */
	ktwp_eyesHaveIt_thisTab.style.top = (130 /* eventually this should be 130, but I haven't converted other tabbed plugins to this framework yet. */+ ktwp_eyesHaveIt_numOfKupieTabs * 38) + "px";
	ktwp_eyesHaveIt_thisTab.style.display = "block";
/* end move the new tab to stack under tabs from other KupieTools plugins */

	const ktwp_eyesHaveIt_thisPanel=document.getElementById("ktwp_eyesHaveIt-panel");
ktwp_eyesHaveIt_thisPanel.style.top = (140 + ktwp_eyesHaveIt_numOfKupieTabs * 38) + "px";
	ktwp_eyesHaveIt_thisPanel.style.left="20px";
</script>
    <?php
}
add_action('wp_footer', 'ktwp_eyesHaveIt_add_control_panel_popup');

/* End create UI Tab */

