<?php
/**
Plugin Name: Taiyyab Manage Movies
Plugin URI: https://www.google.com/
Description: Movies Management use shortcode to show movies list [movies_list]
Version: 1.0
Requires at least: 5.8
Requires PHP: 8.1
Author: Taiyyab Pinjari
Author URI: https://www.google.com/
License: GPLv2 or later
Text Domain: movies
**/

//// Create Movies
function movies_post_type() {
    register_post_type( 'movies',
        array(
            'labels' => array(
                'name' => __( 'Movies' ),
                'singular_name' => __( 'Movie' )
            ),
            'public' => true,
            'show_in_rest' => true,
        'supports' => array('title', 'thumbnail'),
        'has_archive' => true,
        'rewrite'   => array( 'slug' => 'taiyyab-movies' ),
            'menu_position' => 5,
        'menu_icon' => 'dashicons-food',
        // 'taxonomies' => array('cuisines', 'post_tag') // this is IMPORTANT
        )
    );
}
add_action( 'init', 'movies_post_type' );

//// Add movies taxonomy
add_action('admin_init','add_metabox_post_movies');

function create_movies_taxonomy() {
    register_taxonomy('genres','movies',array(
        'hierarchical' => false,
        'labels' => array(
            'name' => _x( 'Genres', 'taxonomy general name' ),
            'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
            'menu_name' => __( 'Genres' ),
            'all_items' => __( 'All Genres' ),
            'edit_item' => __( 'Edit Genre' ), 
            'update_item' => __( 'Update Genre' ),
            'add_new_item' => __( 'Add Genre' ),
            'new_item_name' => __( 'New Genre' ),
        ),
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    ));
    register_taxonomy('categories','movies',array(
        'hierarchical' => false,
        'labels' => array(
            'name' => _x( 'Categories', 'taxonomy general name' ),
            'singular_name' => _x( 'Ingredient', 'taxonomy singular name' ),
            'menu_name' => __( 'Categories' ),
            'all_items' => __( 'All Categories' ),
            'edit_item' => __( 'Edit Category' ), 
            'update_item' => __( 'Update Category' ),
            'add_new_item' => __( 'Add Category' ),
            'new_item_name' => __( 'New Category' ),
        ),
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    ));
}
add_action( 'init', 'create_movies_taxonomy', 0 );


/*
 * Funtion to add a meta box to movies.
 */
function add_metabox_post_movies()
{
    add_meta_box("Movie Advanced Fields", "Advanced Fields", "movies_meta_fields", "movies", "normal", "low");
}

function movies_meta_fields(){
    global $post;
    $customData = get_post_custom($post->ID );
      
    $movie_name = isset( $customData['movie_name'] ) ? esc_attr( $customData['movie_name'][0] ) : '';
    $movie_release_year = isset( $customData['movie_release_year'] ) ? esc_attr( $customData['movie_release_year'][0] ) : '';
    $movie_length = isset( $customData['movie_length'] ) ? esc_attr( $customData['movie_length'][0] ) : '';
    $movie_url = isset( $customData['movie_url'] ) ? esc_attr( $customData['movie_url'][0] ) : '';
    $movie_poster = isset( $customData['movie_poster'] ) ? esc_attr( $customData['movie_poster'][0] ) : '';
    ?>

    <label for="movie_name">Movie Name:</label><br>
    <input type="text" name="movie_name" id="movie_name" value="<?php echo $movie_name; ?>">
       
    <br> <br>
    <label for="movie_release_year">Movie Release Year:</label><br>
    <input type="text" name="movie_release_year" id="movie_release_year" value="<?php echo $movie_release_year; ?>">
    <br> <br>
    <label for="movie_length">Movie Length:</label><br>
    <input type="text" name="movie_length" id="movie_length" value="<?php echo $movie_length; ?>">
     <br> <br>
    <label for="movie_url">Movie URL:</label><br>
    <input type="text" name="movie_url" id="movie_url" value="<?php echo $movie_url; ?>">       

    <br> <br>
    <label for="movie_poster">Movie Poster:</label><br>
    <input type="file" name="movie_poster" id="movie_poster">  
    <br> <br>
    <?php
    if($movie_poster){
    	$custom_attach = get_post_meta( $post->ID, 'movie_poster', true );
    	
    	echo '<img src="'.$custom_attach['url'].'" height="200px" width="300px">';
    }
}
/**
 * Add functionality for file upload.
 */
function update_edit_form() {
	echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );
/*
 * Save the movies meta box value
 */

add_action('save_post','save_metabox_post_movies');
function save_metabox_post_movies($post_id)
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
   
    if ( isset( $_REQUEST['movie_name'] ) ) {
        update_post_meta( $post_id, 'movie_name', sanitize_text_field( $_POST['movie_name'] ) );
    }    
    if ( isset( $_REQUEST['movie_release_year'] ) ) {
        update_post_meta( $post_id, 'movie_release_year', sanitize_text_field( $_POST['movie_release_year'] ) );
    }    
    if ( isset( $_REQUEST['movie_length'] ) ) {
        update_post_meta( $post_id, 'movie_length', sanitize_text_field( $_POST['movie_length'] ) );
    }    
    if ( isset( $_REQUEST['movie_url'] ) ) {
        update_post_meta( $post_id, 'movie_url', sanitize_text_field( $_POST['movie_url'] ) );
    }

  	if ( ! empty( $_FILES['movie_poster']['name'] ) ) {
		$supported_types = array( 'image/jpeg','image/jpg', 'image/png' );
		$arr_file_type = wp_check_filetype( basename( $_FILES['movie_poster']['name'] ) );
		$uploaded_type = $arr_file_type['type'];
		
		if ( in_array( $uploaded_type, $supported_types ) ) {
			$upload = wp_upload_bits($_FILES['movie_poster']['name'], null, file_get_contents($_FILES['movie_poster']['tmp_name']));
			if ( isset( $upload['error'] ) && $upload['error'] != 0 ) {
				wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
			} else {
				add_post_meta( $post_id, 'movie_poster', $upload );
				update_post_meta( $post_id, 'movie_poster', $upload );
			}
		}
		else {
			wp_die( "The file type that you've uploaded is not allowed.  Only jpg,jpge,png allowed" );
		}
	}
}



// Create Short Code for Movies List
function movies_list_shortcode(){
	$movie_name_get = $movie_release_year_get = '';
	$genres_terms = get_terms('genres', 'orderby=none&hide_empty');
	$genres_get = '';
	if(isset($_GET['movie_name'])){
		
		$genres_get = $_GET['genres'];
		$genres_get_array = [];
		if($genres_get){
			$genres_get_array =	array(
						        array(
						        'taxonomy' => 'genres',
						        'field' => 'term_id',
						        'terms' => $genres_get
						    	)
						    );
		}

		$movie_name_get = $_GET['movie_name'];
		$movie_release_year_get = $_GET['movie_release_year'];
		$movie_name_get_array = $movie_release_year_get_array = [];
		if($movie_name_get){
			$movie_name_get_array =	array(
			            'key' => 'movie_name',
			            'value' => sanitize_text_field( $_GET['movie_name'] ),
			            'compare' => 'LIKE'
			        );
		}
		if($movie_release_year_get){
			$movie_release_year_get_array =	array(
			            'key' => 'movie_release_year',
			            'value' => sanitize_text_field( $_GET['movie_release_year'] ),
			            'compare' => '='
			        );
		}
		
		
		$args = array( 
				'meta_query' => array(
			        'relation' => 'OR',
			        $movie_name_get_array,
			        $movie_release_year_get_array
			        
			    ),
			    'tax_query' => $genres_get_array,
				'post_type' => 'movies', 
				'posts_per_page' => 10 

			);
	} else {
		$args = array( 'post_type' => 'movies', 'posts_per_page' => 10 );
	}
	
    $loop = new WP_Query( $args );
    
    if ( $loop->have_posts() ) {
    	global $wp;
		$current_url = home_url(add_query_arg(array(), $wp->request));
		

    ?>
    <form action="" method="get">
    	<label for="movie_name">Movie Name:</label><br>
    	<input type="text" name="movie_name" id="movie_name" value="<?php echo $movie_name_get; ?>">
       
    	<br> <br>
    	<label for="movie_release_year">Movie Release Year:</label><br>
	    <input type="text" name="movie_release_year" id="movie_release_year" value="<?php echo $movie_release_year_get; ?>">
	    <br> <br>

		<?php
			if($genres_terms){
				echo '<label for="movie_release_year">Taxonomy Genres:</label><br><select name="genres"><option value="">Select Genres</option>';
				foreach ($genres_terms as $genres_terms_key => $genres_terms_value) {
					if($genres_get == $genres_terms_value->term_id){
						echo '<option value="'.$genres_terms_value->term_id.'" selected>'.$genres_terms_value->name.'</option>';
					} else{
						echo '<option value="'.$genres_terms_value->term_id.'">'.$genres_terms_value->name.'</option>';
					}
					
				}
				echo '</select>';
			} 
		?>
	    <br> <br>
	    <input type="Submit" value="Search Movie">
	    <a href="<?php echo $current_url; ?>">Reset Form</a>
    </form>
    <?php	
    while ( $loop->have_posts() ) : $loop->the_post();
    $customData = get_post_custom(get_the_ID());
    $categories_list = get_the_terms(get_the_ID(), 'categories');
    $genres_list = get_the_terms(get_the_ID(), 'genres');
    
    
    $movie_name = isset( $customData['movie_name'] ) ? esc_attr( $customData['movie_name'][0] ) : '';
    $movie_release_year = isset( $customData['movie_release_year'] ) ? esc_attr( $customData['movie_release_year'][0] ) : '';
    $movie_length = isset( $customData['movie_length'] ) ? esc_attr( $customData['movie_length'][0] ) : '';
    $movie_url = isset( $customData['movie_url'] ) ? esc_attr( $customData['movie_url'][0] ) : '';
    $movie_poster = isset( $customData['movie_poster'] ) ? esc_attr( $customData['movie_poster'][0] ) : '';

    echo '<hr>';

    
    ?>
    
    <br> <br>
    <label for="movie_name">Title:<?php echo the_title(); ?></label><br>    

    <br>
    <label for="movie_name">Movie Name:<?php echo $movie_name; ?></label><br>
	       
    <br>
    <label for="movie_release_year">Movie Release Year:<?php echo $movie_release_year; ?></label><br>
    
    <br>
    <label for="movie_length">Movie Length:<?php echo $movie_length; ?></label><br>
    
     <br>
    <label for="movie_url">Movie URL: <?php echo $movie_url; ?></label><br> <br>
    <?php
    if($categories_list){
    	$categories_list_types = '';
    	foreach($categories_list as $categories_list_key) {
		    $categories_list_types .= ucfirst($categories_list_key->slug).', ';
		}
		$categories_list_types_string = rtrim($categories_list_types, ', ');
		?>
		
    <label for="categories">Categories : <?php echo $categories_list_types_string; ?></label><br><br>  
		<?php
		
    }

    if($genres_list ){
    	$genres_list_types = '';
    	foreach($genres_list as $genres_list_key) {
		    $genres_list_types .= ucfirst($genres_list_key->slug).', ';
		}
		$genres_list_types_string = rtrim($genres_list_types, ', ');
		?>
		
    <label for="genres">Genres : <?php echo $genres_list_types_string; ?></label><br><br>  
		<?php
		
    }
     	if($movie_poster){
	    	$custom_attach = get_post_meta( get_the_ID(), 'movie_poster', true );
	    	
	    	echo '<label for="movie_poster">Movie Poster:</label> <br><br><img src="'.$custom_attach['url'].'" height="200px" width="300px">';
	    }
    echo '<hr>';
    endwhile;
	} else {
		echo 'No Post Found';
	}
}
add_shortcode('movies_list', 'movies_list_shortcode');