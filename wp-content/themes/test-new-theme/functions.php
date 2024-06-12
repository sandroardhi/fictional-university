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
    // for google map frontend
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAJdQ7thzDqYP3X-5hxZRcnBsQPHDpotdQ', null, '1.0', true);
    // the argument is name for this queue, the getter funvtion for the js file, is there dependencies for that file, the version of the script (idk what this means), and boolean for 'do you want to render this script in the bottom of the html or in the head?' true for bottom
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    wp_localize_script('main-university-js', 'universityData', [
        'root_url' => get_site_url()
    ]);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    add_theme_support('title-tag');
    // for featured image
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
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

    // for post type campus' archive
    if (!is_admin() && is_post_type_archive('campus') && $query->is_main_query()) {
        $query->set('posts_per_page', -1);
    };
};

add_action('pre_get_posts', 'university_adjust_queries');


// this kindof like a composables
function pageBanner($args = null)
{
    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image') and !is_archive() and !is_home()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url( <?php echo $args['photo'] ?> )"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'] ?></p>
            </div>
        </div>
    </div>
<?php }

// for adding api key to the Advanced Custom Field Google Maps Api field
function universityMapKey($api) {
    $api['key'] = 'AIzaSyAJdQ7thzDqYP3X-5hxZRcnBsQPHDpotdQ';
    return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');


// this is for customizing rest api call
function university_custom_rest() {
    // here we want to add a custom field for post type posts, the custom field is the name of the author of that post
    register_rest_field('post', 'authorName', [
        'get_callback' => function () {
            return get_the_author();
        }
    ]);
}
add_action('rest_api_init', 'university_custom_rest');