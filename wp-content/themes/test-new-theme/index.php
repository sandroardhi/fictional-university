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
    'title' => 'Welcome to our blog!',
    'subtitle' => 'Keep up with our latest news.'
])
?>

<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        the_post(); ?>

        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
            <div class="metabox">
                <p>Posted by <?php the_author_posts_link() ?> on <?php the_time('d M Y') ?> in <?php echo get_the_category_list(', ') ?></p>
            </div>
            <div class="generic-content">
                <?php the_excerpt() ?>
                <p class="btn btn--blue"><a href="<?php the_permalink() ?>">Continue reading &raquo;</a></p>
            </div>
        </div>

    <?php }
    // pagination
    echo paginate_links()
    ?>
</div>

<?php
get_footer()
?>