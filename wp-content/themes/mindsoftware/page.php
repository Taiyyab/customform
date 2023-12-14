<?php get_header(); ?>
<!-- Start Content Div -->
<?php
if ( have_posts() ) :
   while(have_posts()) : the_post();    
?>

     <?php the_content() ?>

<?php  endwhile;  wp_reset_query(); ?>
<?php endif; ?>     
<!-- End Content Div -->  
<?php get_footer(); ?>