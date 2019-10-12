<?php

get_header();

// loop single
if (have_posts()) : while (have_posts()) : the_post();

    $title= str_ireplace('"', '', trim(get_the_title()));
    $desc= str_ireplace('"', '', trim(get_the_content()));

    ?>

    <h1><?php echo $title; ?></h1>

    <div class="travel-time">
    <?php get_the_travel_start_date(); ?> - <?php get_the_travel_end_date(); ?>
    </div>

    <div class="travel-description">
        <?php echo $desc; ?>
    </div>

<?php
endwhile; endif;

get_footer();

?>
