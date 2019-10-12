<?php
/*
 * Template Name: Travel
 * Template Post Type: travel
 */


// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>
<section id="content" <?php Avada()->layout->add_class( 'content_class' ); ?> <?php Avada()->layout->add_style( 'content_style' ); ?>>


<?php
//query_posts('post_type=travel&posts_per_page=6'); /* We gaan 6 reizen items per pagina tonen */
// https://10for2.com/2017/05/30/add-custom-post-types-avada/
query_posts(
    array(  'post_type' => 'travel',
            'order'     => 'DESC',
            'orderby'   => 'ept_travel_date_start', //or 'meta_value_num'
    )
);
?>

<div id="travel_list">


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <?php
        $title= str_ireplace('"', '', trim(get_the_title()));
        $desc= str_ireplace('"', '', trim(get_the_excerpt()));

        $categories = get_the_taxonomies($post->ID);
        //$type = $categories["travel-type"];
        $type = get_the_taxonomies();
    ?>

    <div class="item">
        <!--
                <div class="img"><a title="<?=$title?>: <?=$desc?>" rel="lightbox[work]" href="<?php print  get_travel_thumbnailurl($post->ID) ?>"><?php the_post_thumbnail(); ?></a></div>
                <p><strong><?=$title?>:</strong> <?php print get_the_excerpt(); ?> <a title="<?=$title?>: <?=$desc?>" rel="lightbox[work]" href="<?php print  get_travel_thumbnailurl($post->ID) ?>">(lees meer)</a></p>
                <?php $site= get_post_custom_values('externallink');
                    if($site[0] != ""){

                ?>
                    <p><a href="<?=$site[0]?>" target="new">Bezoek deze website</a></p>

                <?php }else{ ?>
                    <p><em>Geen link beschikbaar</em></p>
                <?php } ?>
        -->

        <a href="<?php the_permalink(); ?>"><?php echo $title; ?></a>

            <div class="travel-time">
    <?php get_the_travel_start_date(); ?> - <?php get_the_travel_end_date(); ?>
    </div>

    <div class="travel-description">
        <?php print_r($type); ?>
        <?php echo $desc; ?>
    </div>



            </div>

<?php endwhile; endif; ?>

</div> <!-- end travel list -->

</section> <!-- end main section -->
<?php do_action( 'avada_after_content' ); ?>
<?php get_footer(); ?>
