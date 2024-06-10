<!-- <?php
        while (have_posts()) {
            the_post(); ?>
    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <p><?php the_content(); ?></p>
    <hr>
    <?php } ?> -->

<?php
get_header();
pageBanner([
    'title' => 'All Events',
    'subtitle' => 'See what is going on on the campus.'
])
?>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post();

        get_template_part('template-parts/content', 'event');
    }
    // pagination
    echo paginate_links()
    ?>

    <hr class="section-break">
    <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive.</a></p>
</div>

<?php
get_footer()
?>