<?php
/* Travel posttype */
if ( function_exists( 'add_theme_support' ) ) {
 add_theme_support( 'post-thumbnails' );
 set_post_thumbnail_size( 400, 210, true ); // Post thumbnail afmetingen
 add_image_size( 'screen-shot', 800, 420 ); // Volledig grootte
}

/* register posttype */
add_action('init', 'travel_register');

function travel_register() {
    add_travel_post_type();
    add_travel_custom_taxonomy();
/*
$args = array(
'label' => __('Travels'),
'singular_label' => __('Travel'),
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => true,
'rewrite' => true,
'has_archive' => true,
'exclude_from_search' => false,
'publicly_queryable'  => true,
'supports' => array('title', 'editor', 'thumbnail')
);

/* custom post type
register_post_type( 'travel' , $args );
/* taxonomy (category)
register_taxonomy("travel-type", array("travel"), array("hierarchical" => true, "label" => "Travel categories", "singular_label" => "Travel category", "rewrite" => true));

*/
}


function add_travel_post_type() {
    $labels = array(
        'name'                => _x( 'Travels', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Travel', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Travels', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Product:', 'text_domain' ),
        'all_items'           => __( 'All Travels', 'text_domain' ),
        'view_item'           => __( 'View Travel', 'text_domain' ),
        'add_new_item'        => __( 'Add New Travel', 'text_domain' ),
        'add_new'             => __( 'New Travel', 'text_domain' ),
        'edit_item'           => __( 'Edit Travel', 'text_domain' ),
        'update_item'         => __( 'Update Travel', 'text_domain' ),
        'search_items'        => __( 'Search Travels', 'text_domain' ),
        'not_found'           => __( 'No Travels Found', 'text_domain' ),
        'not_found_in_trash'  => __( 'No Travels Found in Trash', 'text_domain' ),
    );

    $args = array(
        'label'               => __( 'Travels', 'text_domain' ),
        'description'         => __( 'Referable Travels', 'text_domain'),
        'labels'              => $labels,
        'hierarchical'        => false,
        'taxonomies'          => array('category'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'supports'        => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'menu_position'       => 5,
        'menu_icon'           => null,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        //'rewrite'             => array('slug' => 'travel'),
        'rewrite' => array( 'slug' => 'travels/%travel-type%', 'with_front' => false ),
    );


    register_post_type( 'travel', $args );

}

// Register Custom Taxonomy
function add_travel_custom_taxonomy()  {
    $labels = array(
        'name'                       => _x( 'Travel type', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Travel type', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Travel types', 'text_domain' ),
        'all_items'                  => __( 'All Travel types', 'text_domain' ),
        'parent_item'                => __( 'Parent Travel type', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Travel type:', 'text_domain' ),
        'new_item_name'              => __( 'New Travel type Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Travel type', 'text_domain' ),
        'edit_item'                  => __( 'Edit Travel type', 'text_domain' ),
        'update_item'                => __( 'Update Travel type', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate Travel types with commas', 'text_domain' ),
        'search_items'               => __( 'Search Travel types', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or Remove Travel types', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from Most Used Travel types', 'text_domain' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array('slug' => 'travels'),
    );

    register_taxonomy( 'travel-type', 'travel', $args );
}


function travel_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'travel' ){
        $terms = wp_get_object_terms( $post->ID, 'travel-type' );
        if( $terms ){
            return str_replace( '%travel-type%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}

add_filter( 'post_type_link', 'travel_permalinks', 1, 2 );



/* add custom meta fields/variables */
add_action("admin_init", "travel_meta_box");

function travel_meta_box(){
    add_meta_box("travel-meta", "Travel Options", "travel_meta_options", "travel", "side", "low");
}
function travel_meta_options(){
    global $post;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $link = $custom["externallink"][0];
    ?>
<p>
        <label>Link: </label><input name="externallink" value="<?php echo $link; ?>" />
</p>
    <?php
}



/* save post meta */
add_action('save_post', 'save_traveltype_meta');
function save_traveltype_meta(){
    global $post;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
        return $post_id;
    }else{
        //update_post_meta($post->ID, "startdate", $_POST["startdate"]);
        //update_post_meta($post->ID, "enddate", $_POST["enddate"]);
        update_post_meta($post->ID, "externallink", $_POST["externallink"]);
    }
}



/* ! not working
https://developer.wordpress.org/reference/functions/wp_enqueue_script/ ..

// posttype result page:
// https://tussendoor.nl/handleidingen/wordpress-theming/wordpress-search-custom-post-type
// https://wordpress.stackexchange.com/questions/89886/how-to-create-a-custom-search-for-custom-post-type
*/
add_filter( 'pre_get_posts', 'get_travel_search' );
function get_travel_search( $query ) {

    if ( $query->is_search ) {
        $query->set( 'post_type', array( 'post','travel' ) ); // 'post', 'products', 'portfolio'
        /* all types ?
        $post_types = get_post_types(array('public' => true, 'exclude_from_search' => false), 'objects');
		$searchable_types = array();
		// Add available post types
		if( $post_types ) {
			foreach( $post_types as $type) {
				$searchable_types[] = $type->name;
			}
		}
		$query->set( 'post_type', $searchable_types );
        */

    }

    return $query;

}
/*
// for now a js solution
function custom_searchtype(){
    //wp_enqueue_style('string $handle', mixed $src, array $deps, mixed $ver, string $meida );
    //wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/fatblog.css', array(), '1.0.0', 'all' );
    //wp_enqueue_style('string $handle', mixed $src, array $deps, mixed $ver, bol $in_footer );
    wp_enqueue_script('customsearchjs', get_template_directory_uri() . '/includes/searchtype.js', array(), '1.0.0', 'true' );
}
add_action('wp_enqueue_scripts', 'custom_searchtype');

*/


/* Date start - end */
function ep_travelposts_metaboxes() {
    add_meta_box( 'ept_travel_date_start', 'Start Date and Time', 'ept_travel_date', 'travel', 'side', 'default', array( 'id' => '_start') );
    add_meta_box( 'ept_travel_date_end', 'End Date and Time', 'ept_travel_date', 'travel', 'side', 'default', array('id'=>'_end') );
    //add_meta_box( 'ept_travel_location', 'travel Location', 'ept_travel_location', 'travel', 'side', 'default', array('id'=>'_end') );
}
add_action( 'admin_init', 'ep_travelposts_metaboxes' );



// Metabox HTML
function ept_travel_date($post, $args) {
    $metabox_id = $args['args']['id'];
    global $post, $wp_locale;

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ep_travelposts_nonce' );

    $time_adj = current_time( 'timestamp' );
    $month = get_post_meta( $post->ID, $metabox_id . '_month', true );

    if ( empty( $month ) ) {
        $month = gmdate( 'm', $time_adj );
    }

    $day = get_post_meta( $post->ID, $metabox_id . '_day', true );

    if ( empty( $day ) ) {
        $day = gmdate( 'd', $time_adj );
    }

    $year = get_post_meta( $post->ID, $metabox_id . '_year', true );

    if ( empty( $year ) ) {
        $year = gmdate( 'Y', $time_adj );
    }

    $hour = get_post_meta($post->ID, $metabox_id . '_hour', true);

    if ( empty($hour) ) {
        $hour = gmdate( 'H', $time_adj );
    }

    $min = get_post_meta($post->ID, $metabox_id . '_minute', true);

    if ( empty($min) ) {
        $min = '00';
    }

    $month_s = '<select name="' . $metabox_id . '_month">';
    for ( $i = 1; $i < 13; $i = $i +1 ) {
        $month_s .= "\t\t\t" . '<option value="' . zeroise( $i, 2 ) . '"';
        if ( $i == $month )
            $month_s .= ' selected="selected"';
        $month_s .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
    }
    $month_s .= '</select>';

    echo $month_s;
    echo '<input type="text" name="' . $metabox_id . '_day" value="' . $day  . '" size="2" maxlength="2" />';
    echo '<input type="text" name="' . $metabox_id . '_year" value="' . $year . '" size="4" maxlength="4" />';
    echo '<br />@ <input type="text" name="' . $metabox_id . '_hour" value="' . $hour . '" size="2" maxlength="2"/>:';
    echo '<input type="text" name="' . $metabox_id . '_minute" value="' . $min . '" size="2" maxlength="2" />';

}

function ept_travel_location() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'ep_travelposts_nonce' );
    // The metabox HTML
    //$travel_location = get_post_meta( $post->ID, '_travel_location', true );
    //echo '<label for="_travel_location">Location:</label>';
    //echo '<input type="text" name="_travel_location" value="' . $travel_location  . '" />';
}

// Save the Metabox Data

function ep_travelposts_save_meta( $post_id, $post ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( !isset( $_POST['ep_travelposts_nonce'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['ep_travelposts_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ) )
        return;

    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though

    $metabox_ids = array( '_start', '_end' );

    foreach ($metabox_ids as $key ) {
        $travels_meta[$key . '_month'] = $_POST[$key . '_month'];
        $travels_meta[$key . '_day'] = $_POST[$key . '_day'];
            if($_POST[$key . '_hour']<10){
                 $travels_meta[$key . '_hour'] = '0'.$_POST[$key . '_hour'];
             } else {
                   $travels_meta[$key . '_hour'] = $_POST[$key . '_hour'];
             }
        $travels_meta[$key . '_year'] = $_POST[$key . '_year'];
        $travels_meta[$key . '_hour'] = $_POST[$key . '_hour'];
        $travels_meta[$key . '_minute'] = $_POST[$key . '_minute'];
        $travels_meta[$key . '_traveltimestamp'] = $travels_meta[$key . '_year'] . $travels_meta[$key . '_month'] . $travels_meta[$key . '_day'] . $travels_meta[$key . '_hour'] . $travels_meta[$key . '_minute'];
    }

    // Add values of $travels_meta as custom fields

    foreach ( $travels_meta as $key => $value ) { // Cycle through the $travels_meta array!
        if ( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode( ',', (array)$value ); // If $value is an array, make it a CSV (unlikely)
        if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
            update_post_meta( $post->ID, $key, $value );
        } else { // If the custom field doesn't have a value
            add_post_meta( $post->ID, $key, $value );
        }
        if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank
    }

}

add_action( 'save_post', 'ep_travelposts_save_meta', 1, 2 );

/**
 * Helpers to display the date on the front end
 */

// Get the Month Abbreviation

function travelposttype_get_the_month_abbr($month) {
    global $wp_locale;
    for ( $i = 1; $i < 13; $i = $i +1 ) {
                if ( $i == $month )
                    $monthabbr = $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) );
                }
    return $monthabbr;
}

// Display the date

function get_the_travel_start_date() {
    $month = get_post_meta(get_the_ID(), '_start_month', true);
    $traveldate = travelposttype_get_the_month_abbr($month);
    $traveldate .= ' ' . get_post_meta(get_the_ID(), '_start_day', true) . ',';
    $traveldate .= ' ' . get_post_meta(get_the_ID(), '_start_year', true);
    //$traveldate .= ' at ' . get_post_meta(get_the_ID(), '_start_hour', true);
    //$traveldate .= ':' . get_post_meta(get_the_ID(), '_start_minute', true);
    echo $traveldate;
}
function get_the_travel_end_date() {
    $month = get_post_meta(get_the_ID(), '_end_month', true);
    $traveldate = travelposttype_get_the_month_abbr($month);
    $traveldate .= ' ' . get_post_meta(get_the_ID(), '_end_day', true) . ',';
    $traveldate .= ' ' . get_post_meta(get_the_ID(), '_end_year', true);
    //$traveldate .= ' at ' . get_post_meta(get_the_ID(), '_end_hour', true);
    //$traveldate .= ':' . get_post_meta(get_the_ID(), '_end_minute', true);
    echo $traveldate;
}

?>
