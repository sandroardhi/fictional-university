<!-- this single-event.php file will be used by post with type event -->

<?php get_header() ?>

<!-- <h1>We are inside of an event post!</h1> -->
<?php
while (have_posts()) {
    the_post();
    pageBanner();
?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content() ?></div>

        <div class="acf-map">
            <?php $mapLocation = get_field('map_location') ?>
            <div data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>" class="marker">
                <h3><?php the_title() ?></h3>
                <?php echo $mapLocation['address'] ?>
            </div>
        </div>
        <?php
        $relatedPrograms = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'program',
            'order' => 'ASC',
            'orderby' => 'title',
            // custom meta query, like some kind of filter for this query, this specific query is for filtering post that are already past
            'meta_query' => [
                // this for filtering programs thats only related to this campus
                [
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);

        if ($relatedPrograms->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs Available At This Campus</h2>';

            echo '<ul class="min-list link-list">';
            while ($relatedPrograms->have_posts()) {
                $relatedPrograms->the_post()
        ?>
                <li>
                    <a href="<?php the_permalink() ?>" >
                        <?php the_title() ?>
                    </a>
                </li>
        <?php }
            echo '</ul>';
        }

        wp_reset_postdata();
        ?>
    </div>
<?php }


get_footer()
?>