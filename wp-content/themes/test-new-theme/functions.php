<?php 

function university_files () {
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

function university_features() {
    add_theme_support('title-tag');
    // for dynamic menu in wordpress admin page, first argument for its location (used in the html like this wp_nav_menu(['theme_location' => 'headerMenuLocation'])) the second argument is for the one in wordpress admin (like a description)
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
};

add_action('after_setup_theme', 'university_features');
?>