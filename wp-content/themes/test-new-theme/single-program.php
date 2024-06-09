<!-- this single-event.php file will be used by post with type event -->

<?php get_header() ?>

<!-- <h1>We are inside of an event post!</h1> -->
<?php
while (have_posts()) {
    the_post(); ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title() ?></h1>
            <div class="page-banner__intro">
                <p>DONT FORGET MEEEE</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content() ?></div>

        <?php
        $today = date('Ymd');
        $eventsRelatedToProgram = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'order' => 'ASC',
            // this is how we orderby post by custom field named event_date
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            // custom meta query, like some kind of filter for this query, this specific query is for filtering post that are already past
            'meta_query' => [
                // this is for filtering past events
                [
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                ],
                // this for filtering events thats only related to this program
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"'.get_the_ID().'"' ,
                ]
            ]
        ]);

        if ($eventsRelatedToProgram->have_posts()) {

        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming '. get_the_title() .' Events</h2>';

        while ($eventsRelatedToProgram->have_posts()) {
            $eventsRelatedToProgram->the_post()
        ?>
            <div class="event-summary">
                <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
                    <span class="event-summary__month">
                        <?php
                        $eventDate = new DateTime(get_field('event_date'));
                        echo $eventDate->format('M')
                        ?></span>
                    <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                </a>
                <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
                    <p><?php has_excerpt() ? the_excerpt() : print(wp_trim_words(get_the_content(), 18)) ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
                </div>
            </div>
        <?php }
        }
        ?>
    </div>
<?php }


get_footer()
?>