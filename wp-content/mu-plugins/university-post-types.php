<?php
// mu plugins will render this post type even if the admin change the wordpress theme (functions.php live in the theme folder so if we place this in functions.php and user change its theme, this event type will dissapear)
// another perks of using mu_plugins (stands for must use plugins) is that plugins inside of this folder cannot be deactivated by admin.

// making new post type
function university_post_types()
{
    // first argument is the type name
    register_post_type('event', [
        'has_archive' => true,
        'show_in_rest' => true,
        'public' => true,
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
};

add_action('init', 'university_post_types');
