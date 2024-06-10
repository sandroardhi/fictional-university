<!-- <?php
        while (have_posts()) {
            the_post(); ?>
    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <p><?php the_content(); ?></p>
    <hr>
    <?php } ?> -->

<?php get_header();
pageBanner([
    'title' => 'Past Events',
    'subtitle' => 'All of our past events.'
]);
?>

<div class="container container--narrow page-section">
    <?php
    $today = date('Ymd');
    $pastEvents = new WP_Query([
        'post_type' => 'event',
        'order' => 'ASC',
        // this is how we orderby post by custom field named event_date
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        // custom meta query, like some kind of filter for this query, this specific query is for filtering post that are already past
        'meta_query' => [
            [
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today,
                'type' => 'numeric'
            ]
        ],
        // because this is a custom query inside of a page, wordpress dont help us build pagination links automatically
        // this is for listening and making the query know of the pages' pagination
        'paged' => get_query_var('paged', 1),
    ]);

    while ($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('template-parts/content', 'event');
    }
    // pagination
    echo paginate_links([
        'total' => $pastEvents->max_num_pages
    ])
    ?>
</div>

<?php
get_footer()
?>