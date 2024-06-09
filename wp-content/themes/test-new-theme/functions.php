<?php

function university_files()
{
    // CSS
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    // CDN STYLESHEET
    wp_enqueue_style('google-fonts-roboto', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('google-fonts-karla', '//fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap');
    wp_enqueue_style('google-fonts-rubik', '//fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    //  SCRIPT
    // the argument is name for this queue, the getter funvtion for the js file, is there dependencies for that file, the version of the script (idk what this means), and boolean for 'do you want to render this script in the bottom of the html or in the head?' true for bottom
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    add_theme_support('title-tag');
    // for dynamic menu in wordpress admin page, first argument for its location (used in the html like this wp_nav_menu(['theme_location' => 'headerMenuLocation'])) the second argument is for the one in wordpress admin (like a description)
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
};

add_action('after_setup_theme', 'university_features');

// manipulating wordpress' default url based query
function university_adjust_queries($query)
{
    // we only want to manipulate the query on our frontend  and only on the event archive (/events) and only the default url based query so we dont accidentally manipulate other query on that event archive page (if its exist)
    if (!is_admin() && is_post_type_archive('event') && $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query',  [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            ]
        ]);
    };

    // for post type program's archive
    if (!is_admin() && is_post_type_archive('program') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
    };
};

add_action('pre_get_posts', 'university_adjust_queries');
