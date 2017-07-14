<?php
/*
Plugin Name: MooTools Accessible Accordion
Plugin URI: http://wordpress.org/extend/plugins/mootools-accessible-accordion/
Description: WAI-ARIA Enabled Accordion Plugin for Wordpress
Author: Kontotasiou Dionysia
Version: 3.0
Author URI: http://www.iti.gr/iti/people/ThOikon.html, http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
include_once 'getRecentPosts.php';
include_once 'getRecentComments.php';
include_once 'getArchives.php';

add_action("plugins_loaded", "MooToolsAccessibleAccordion_init");
function MooToolsAccessibleAccordion_init() {
    register_sidebar_widget(__('MooTools Accessible Accordion'), 'widget_MooToolsAccessibleAccordion');
    register_widget_control(   'MooTools Accessible Accordion', 'MooToolsAccessibleAccordion_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_MooToolsAccessibleAccordion') ) {
        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('mootools-core', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-accordion/lib/mootools-core.js'));
        wp_enqueue_script('mootools-core');

        wp_register_script('mootools-more-accordion', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-accordion/lib/mootools-more-accordion.js'));
        wp_enqueue_script('mootools-more-accordion');

        wp_register_script('MooToolsAccessibleAccordion', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-accordion/lib/MooToolsAccessibleAccordion.js'));
        wp_enqueue_script('MooToolsAccessibleAccordion');
		
		wp_register_script('accordion', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-accordion/lib/accordion.js'));
        wp_enqueue_script('accordion');

        wp_register_style('MooToolsAccessibleAccordion_css', ( get_bloginfo('wpurl') . '/wp-content/plugins/mootools-accessible-accordion/lib/MooToolsAccessibleAccordion.css'));
        wp_enqueue_style('MooToolsAccessibleAccordion_css');
    }
}

function widget_MooToolsAccessibleAccordion($args) {
    extract($args);

    $options = get_option("widget_MooToolsAccessibleAccordion");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Accordion',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    MooToolsAccessibleAccordionContent();
    echo $after_widget;
}

function MooToolsAccessibleAccordionContent() {
    $recentPosts = get_recent_posts();
    $recentComments = get_recent_comments();
    $archives = get_my_archives();

    $options = get_option("widget_MooToolsAccessibleAccordion");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Accordion',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    echo '<div class="demo" role="application">
    <div id="accordionMooToolsAccessible">
        <h3 class="togglerAccordionMooToolsAccessible">' . $options['archives'] . '</h3>
	<div class="elementAccordionMooToolsAccessible">
            <p><ul>
                ' . $archives . '
            </ul></p>
	</div>
	<h3 class="togglerAccordionMooToolsAccessible">' . $options['recentPosts'] . '</h3>
	<div class="elementAccordionMooToolsAccessible">
            <p><ul>
                ' . $recentPosts . '
            </ul></p>
	</div>
	<h3 class="togglerAccordionMooToolsAccessible">' . $options['recentComments'] . '</h3>
	<div class="elementAccordionMooToolsAccessible">
            <p><ul>
                ' . $recentComments . '
            </ul></p>
	</div>
    </div>
</div>';
}

function MooToolsAccessibleAccordion_control() {
    $options = get_option("widget_MooToolsAccessibleAccordion");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'MooTools Accessible Accordion',
            'archives' => 'Archives',
            'recentPosts' => 'Recent Posts',
            'recentComments' => 'Recent Comments'
        );
    }

    if ($_POST['MooToolsAccessibleAccordion-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['MooToolsAccessibleAccordion-WidgetTitle']);
        update_option("widget_MooToolsAccessibleAccordion", $options);
    }
    if ($_POST['MooToolsAccessibleAccordion-SubmitArchives']) {
        $options['archives'] = htmlspecialchars($_POST['MooToolsAccessibleAccordion-WidgetArchives']);
        update_option("widget_MooToolsAccessibleAccordion", $options);
    }
    if ($_POST['MooToolsAccessibleAccordion-SubmitRecentPosts']) {
        $options['recentPosts'] = htmlspecialchars($_POST['MooToolsAccessibleAccordion-WidgetRecentPosts']);
        update_option("widget_MooToolsAccessibleAccordion", $options);
    }
    if ($_POST['MooToolsAccessibleAccordion-SubmitRecentComments']) {
        $options['recentComments'] = htmlspecialchars($_POST['MooToolsAccessibleAccordion-WidgetRecentComments']);
        update_option("widget_MooToolsAccessibleAccordion", $options);
    }
    ?>
    <p>
        <label for="MooToolsAccessibleAccordion-WidgetTitle">Widget Title: </label>
        <input type="text" id="MooToolsAccessibleAccordion-WidgetTitle" name="MooToolsAccessibleAccordion-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="MooToolsAccessibleAccordion-SubmitTitle" name="MooToolsAccessibleAccordion-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleAccordion-WidgetArchives">Translation for "Archives": </label>
        <input type="text" id="MooToolsAccessibleAccordion-WidgetArchives" name="MooToolsAccessibleAccordion-WidgetArchives" value="<?php echo $options['archives'];?>" />
        <input type="hidden" id="MooToolsAccessibleAccordion-SubmitArchives" name="MooToolsAccessibleAccordion-SubmitArchives" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleAccordion-WidgetRecentPosts">Translation for "Recent Posts": </label>
        <input type="text" id="MooToolsAccessibleAccordion-WidgetRecentPosts" name="MooToolsAccessibleAccordion-WidgetRecentPosts" value="<?php echo $options['recentPosts'];?>" />
        <input type="hidden" id="MooToolsAccessibleAccordion-SubmitRecentPosts" name="MooToolsAccessibleAccordion-SubmitRecentPosts" value="1" />
    </p>
    <p>
        <label for="MooToolsAccessibleAccordion-WidgetRecentComments">Translation for "Recent Comments": </label>
        <input type="text" id="MooToolsAccessibleAccordion-WidgetRecentComments" name="MooToolsAccessibleAccordion-WidgetRecentComments" value="<?php echo $options['recentComments'];?>" />
        <input type="hidden" id="MooToolsAccessibleAccordion-SubmitRecentComments" name="MooToolsAccessibleAccordion-SubmitRecentComments" value="1" />
    </p>
    
    <?php
}

?>
