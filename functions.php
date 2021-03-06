<?php

require_once('wp_bootstrap_navwalker.php');
add_action('after_setup_theme', 'thomascoward_setup');
function thomascoward_setup()
{
    load_theme_textdomain('thomascoward', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    global $content_width;
    if (!isset($content_width)) $content_width = 640;
    register_nav_menus(
        array('main-menu' => __('Main Menu', 'thomascoward'))
    );
}

add_action('wp_enqueue_scripts', 'thomascoward_load_scripts');
function thomascoward_load_scripts()
{
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
    wp_enqueue_script('bundle', get_template_directory_uri() . '/js/bundle.js', false, false, true);
}

add_action('comment_form_before', 'thomascoward_enqueue_comment_reply_script');
function thomascoward_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_filter('the_title', 'thomascoward_title');
function thomascoward_title($title)
{
    if ($title == '') {
        return '&rarr;';
    } else {
        return $title;
    }
}

add_filter('wp_title', 'thomascoward_filter_wp_title');
function thomascoward_filter_wp_title($title)
{
    return $title . esc_attr(get_bloginfo('name'));
}

add_action('widgets_init', 'thomascoward_widgets_init');
function thomascoward_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar Widget Area', 'thomascoward'),
        'id' => 'primary-widget-area',
        'before_widget' => '<div id="%1$s" class="panel panel-default widget-container %2$s">',
        'after_widget' => "</div>",
        'class' => 'test',
        'before_title' => '<div class="panel-heading"">',
        'after_title' => '</div>',
    ));
}

function thomascoward_custom_pings($comment)
{
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
    <?php
}

add_filter('get_comments_number', 'thomascoward_comments_number');
function thomascoward_comments_number($count)
{
    if (!is_admin()) {
        global $id;
        $comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}