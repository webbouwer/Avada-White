<?php
/* Travel post-type search
 * example https://tussendoor.nl/handleidingen/wordpress-theming/wordpress-search-custom-post-type
 */
// Register and load the widget
function load_travel_search_widget() {
    register_widget( 'travel_search_widget' );
}
add_action( 'widgets_init', 'load_travel_search_widget' );

// Creating the widget
class travel_search_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'travel_search_widget',

// Widget name will appear in UI
__('Travel Search Widget', 'travel_search_widget_domain'),

// Widget description
array( 'description' => __( 'Search in travel content', 'travel_search_widget_domain' ), )
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    //echo __( 'Hello, World!', 'travel_search_widget_domain' );
    ?>

    <form id="searchform" action="<?php bloginfo('url'); ?>/" method="get">
        <input id="s" maxlength="150" name="s" type="text" value="" class="txt" />
        <input name="post_type" type="hidden" value="travel" />
        <input type="submit" value="zoeken">
    </form>

    <?php

echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'travel_search_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here
?>
