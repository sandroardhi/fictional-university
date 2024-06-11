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
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content() ?></div>

        <?php
        $relatedProfessors = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'order' => 'ASC',
            'orderby' => 'title',
            // custom meta query, like some kind of filter for this query, this specific query is for filtering post that are already past
            'meta_query' => [
                // this for filtering events thats only related to this program
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);

        if ($relatedProfessors->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';

            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post()
        ?>
                <li class="professor-card__list-item">
                    <a href="<?php the_permalink() ?>" class="professor-card">
                        <img src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="Professor Photo" class="professor-card__image">
                        <span class="professor-card__name"><?php the_title() ?></span>
                    </a>
                </li>
            <?php }
            echo '</ul>';
        }

        // wp_reset_postdata() iku gae ngereset postdata seng digae nak query e kyke, soale lek gak dikei ngene, query pertama bakal neghijack si postdata e so query selanjutnya bakal aneh.. 
        // cth: the_ID() sebelume query pertama (query professor) iku 107 (berarti id e si post e), marie query professor, id e berubah dadi id e professor. nah query selanjute lek gak dikei wp_reset_postdata bakal nggae id e professor gae query e, duduk id post e.
        wp_reset_postdata();


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
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);

        if ($eventsRelatedToProgram->have_posts()) {

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

            while ($eventsRelatedToProgram->have_posts()) {
                $eventsRelatedToProgram->the_post();
                get_template_part('template-parts/content', 'event');
            }
        }

        wp_reset_postdata();

        $relatedCampuses = get_field('related_campus');

        if ($relatedCampuses) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() .' is Available At These Campuses:</h2>';
            echo '<ul class="min-list link-list">';

            foreach ($relatedCampuses as $campus) { ?>
                <li><a href="<?php echo get_the_permalink($campus) ?>"><?php echo get_the_title($campus) ?></a></li>
            <?php }
            echo '</ul>';
        }
        ?>
    </div>
<?php }


get_footer()
?>