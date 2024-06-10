<?php
// mu plugins will render this post type even if the admin change the wordpress theme (functions.php live in the theme folder so if we place this in functions.php and user change its theme, this event type will dissapear)
// another perks of using mu_plugins (stands for must use plugins) is that plugins inside of this folder cannot be deactivated by admin.

// making new post type
function university_post_types()
{
    // EVENT POST TYPE
    // first argument is the type name
    register_post_type('event', [
        'show_in_rest' => true,
        'public' => true,
        'has_archive' => true,
        // this is to rewrite the archive link
        'rewrite' => [
            'slug' => 'events'
        ],
        'supports' => [
            'title',
            'editor',
            'excerpt'
        ],
        'labels' => [
            'name' => 'Events',
            'add_new_item' => 'Add New Events',
            'edit_item' => 'Edit Events',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ],
        'menu_icon' => 'dashicons-calendar'
    ]);

    // PROGRAM POST TYPE
    register_post_type('program', [
        'show_in_rest' => true,
        'public' => true,
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'programs'
        ],
        'supports' => [
            'title',
            'editor',
        ],
        'labels' => [
            'name' => 'Programs',
            'add_new_item' => 'Add New Programs',
            'edit_item' => 'Edit Programs',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon' => 'dashicons-awards'
    ]);

    // PROFESSOR POST TYPE
    register_post_type('professor', [
        'show_in_rest' => true,
        'public' => true,
        'supports' => [
            'title',
            'editor',
            // for featured image
            'thumbnail'
        ],
        'labels' => [
            'name' => 'Professors',
            'add_new_item' => 'Add New Professors',
            'edit_item' => 'Edit Professors',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);
};

add_action('init', 'university_post_types');
