<!-- <?php
        while (have_posts()) {
            the_post(); ?>
    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <p><?php the_content(); ?></p>
    <hr>
<?php } ?> -->

<?php get_header();

pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone.'
])
?>


<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            the_post(); ?>

            <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>

        <?php }
        // pagination
        echo paginate_links()
        ?>
    </ul>

</div>

<?php
get_footer()
?>