<!-- <?php
        while (have_posts()) {
            the_post(); ?>
    <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <p><?php the_content(); ?></p>
    <hr>
<?php } ?> -->

<?php get_header();

pageBanner([
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses'
])
?>


<div class="container container--narrow page-section">
    <div class="acf-map">
        <?php
        while (have_posts()) {
            the_post();
            $mapLocation = get_field('map_location');
        ?>
            <div data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>" class="marker">
                <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                <?php echo $mapLocation['address'] ?>
            </div>
        <?php }
        ?>
    </div>
    <?php
    print_r($mapLocation['lat'])

    ?>

</div>

<?php
get_footer()
?>