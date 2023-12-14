<?php get_header(); ?>
<?php
if ( have_posts() ) :
   while(have_posts()) : the_post();    
?>
    <!-- Start Page Title Area -->
    <div class="page-title-area">
        <div class="d-table blog_banner_content">
            <div class="d-table-cell">
                <div class="container">
                    <div class="page-title-content">
                        <h2>Single Blog</h2>
                        <ul>
                            <li><a href="<?php echo site_url(); ?>">Home</a>
                            </li>
                            <li><a href="<?php echo site_url(); ?>/blog">Blog</a>
                            </li>
                            <li class="active">Blog details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title Area -->

    <div class="bg-shape-wrapper">
        <!-- Start Blog Details Area -->
        <section class="blog-details-area pb-0 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="blog-details-desc">
                            <?php 
                            if (has_post_thumbnail( $post->ID ) ) {
                               $blog_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                            ?>  
                            <div class="article-image">
                                <img src="<?php echo $blog_image[0]; ?>" alt="image">
                            </div>
                           <?php } ?>
                            <div class="article-content">
                                <div class="entry-meta">
                                    <ul>
                                        <li> <span>Posted On:</span> <a href="#"><?php the_date('F d - Y'); ?></a>
                                        </li>
                                        <li> <span>Posted By:</span> <a href="#"><?php echo get_the_author(); ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <h3><?php echo get_the_title( $post->ID ); ?></h3>
                                <?php the_content() ?>
                            </div>
                            <?php setPostViews($post->ID); endwhile;  wp_reset_query(); ?>
                            <?php endif; ?>   
                            <div class="article-footer">
                                <div class="article-tags"> 
                                    
                                    <?php
                                      if(get_the_tags($post->ID)){
                                        ?>
                                        <span>
                                          <i class="fa fa-hashtag"></i>
                                        </span>
                                        <?php
                                        foreach(get_the_tags($post->ID) as $tag) {
                                          echo '<a href="javascript:void(0)">'.$tag->name.'</a>' . ', ';
                                        } 
                                      }
                                       
                                    ?>
                                    <!-- <a href="#">Solutions</a>, <a href="#">Guide</a> -->
                                </div>
                                <div class="article-share">
                                    <ul class="social">
                                        <li><span>Share:</span>
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/sharer?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" target="_blank" rel="noopener noreferrer"> <i class="fab fa-facebook-f"></i>
                    </a>
                                        </li>
                                        <li>
                                          <!-- Twitter -->
                                          <a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><i class="fab fa-twitter"></i></a>

                                           <!--  <a href="#"> <i class="fab fa-twitter"></i></a> -->
                                        </li>
                                        <li>
                                          <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;summary=&amp;source=<?php the_title(); ?>" target="_new" rel="noopener noreferrer"><i class="fab fa-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="post-navigation">
                                <div class="navigation-links">
                                    <?php
                                    echo '<div class="nav-previous">';
                                    previous_post_link('%link', 'Prev Post <i class="fa fa-arrow-left"></i>');
                                    echo '</div>';
                                    echo '<div class="nav-next">';
                                    next_post_link('%link', 'Next Post <i class="fa fa-arrow-right"></i>');
                                    echo '</div>';
                                    /*
                                     $previous = get_previous_post();
                                      $next = get_next_post();
                                      if ( get_previous_post() ) { 
                                    ?>
                                    <div class="nav-previous">
                                        <a href="<?php echo  previous_post_link(); ?>"> <i class="fa fa-arrow-left"></i> Prev Post</a>
                                       
                                    </div>
                                    <?php } ?>
                                    <?php
                                    if ( get_next_post() ) { 
                                    ?>
                                    <div class="nav-next"> <a href="<?php echo next_post_link(); ?>">
                                          
                                            <i class="fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                    <?php } */?>
                                </div>
                            </div>
                            
                            <div class="comments-area">
                               <!--  <ol class="comment-list">
                                    <li class="comment">
                                        <article class="comment-body">
                                            <footer class="comment-meta">
                                                <div class="comment-author vcard">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/client/1.jpg" class="avatar" alt="image"> <b class="fn">Wilson Swanson</b>
                                                    <span class="says">says:</span>
                                                </div>
                                                <div class="comment-metadata">
                                                    <a href="#">
                          <span>October 15 - 2020 12:30 PM</span>
                        </a>
                                                </div>
                                            </footer>
                                            <div class="comment-content">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation.</p>
                                            </div>
                                            <div class="reply"> <a href="#" class="comment-reply-link">Reply</a>
                                            </div>
                                        </article>
                                        <ol class="children">
                                            <li class="comment">
                                                <article class="comment-body">
                                                    <footer class="comment-meta">
                                                        <div class="comment-author vcard">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/img/client/2.jpg" class="avatar" alt="image"> <b class="fn">Ella Hodges</b>
                                                            <span class="says">says:</span>
                                                        </div>
                                                        <div class="comment-metadata">
                                                            <a href="#">
                              <span>October 15 - 2020 12:30 PM</span>
                            </a>
                                                        </div>
                                                    </footer>
                                                    <div class="comment-content">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation.</p>
                                                    </div>
                                                    <div class="reply"> <a href="#" class="comment-reply-link">Reply</a>
                                                    </div>
                                                </article>
                                            </li>
                                        </ol>
                                    </li>
                                    <li class="comment">
                                        <article class="comment-body">
                                            <footer class="comment-meta">
                                                <div class="comment-author vcard">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/client/4.jpg" class="avatar" alt="image"> <b class="fn">Melissa Bryant</b>
                                                    <span class="says">says:</span>
                                                </div>
                                                <div class="comment-metadata">
                                                    <a href="#">
                          <span>October 15 - 2020 12:30 PM</span>
                        </a>
                                                </div>
                                            </footer>
                                            <div class="comment-content">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. enim ad minim veniam, quis nostrud exercitation.</p>
                                            </div>
                                            <div class="reply"> <a href="#" class="comment-reply-link">Reply</a></div>
                                        </article>
                                    </li>
                                </ol> -->
                                <div class="comment-respond">
                                  <?php $comments_args = array(
                                      // change the title of send button 
                                      'label_submit'=>'Post Comment',
                                      // change the title of the reply section
                                      'title_reply'=>'<h3 class="comment-reply-title">Leave a Reply</h3><p class="comment-notes"> <span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span>
                                        </p>',
                                      // remove "Text or HTML to be displayed after the set of comment fields"
                                      'comment_form_top' => 'ds',
                                      'comment_notes_before' => '',
                                      'comment_notes_after' => '',
                                      // redefine your own textarea (the comment body)
                                      'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="Your Comment* " aria-required="true"  cols="45" rows="5" maxlength="65525" required="required"></textarea></p>',
                                      'fields' => apply_filters( 'comment_form_default_fields', array(

                                  'author' =>
                                    '<p class="comment-form-author">'  .
                                    '<input id="author" class="blog-form-input" placeholder="Your Name* " name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
                                    '" size="30"' . $aria_req . '  required="required" /></p>',

                                  'email' =>
                                    '<p class="comment-form-email">'.
                                    '<input id="email" class="blog-form-input" placeholder="Your Email Address* " name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
                                    '" size="30"' . $aria_req . '  required="required" /></p>',

                                  'url' =>
                                    '<p class="comment-form-url">'.
                                    '<input id="url" class="blog-form-input" placeholder="Your Website URL" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
                                    '" size="30" /></p>'
                                  )
                                ),
                              );

                              comment_form($comments_args);
                              ?>
                                   <!--  <h3 class="comment-reply-title">Leave a Reply</h3>
                                    <form class="comment-form">
                                        <p class="comment-notes"> <span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span>
                                        </p>
                                        <p class="comment-form-comment">
                                            <label>Comment</label>
                                            <textarea name="comment" id="comment" cols="45" rows="5" maxlength="65525" required="required"></textarea>
                                        </p>
                                        <p class="comment-form-author">
                                            <label>Name <span class="required">*</span>
                    </label>
                                            <input type="text" id="author" name="author" required="required">
                                        </p>
                                        <p class="comment-form-email">
                                            <label>Email <span class="required">*</span>
                    </label>
                                            <input type="email" id="email" name="email" required="required">
                                        </p>
                                        <p class="comment-form-url">
                                            <label>Website</label>
                                            <input type="url" id="url" name="url">
                                        </p>
                                        <p class="comment-form-cookies-consent">
                                            <input type="checkbox" value="yes" name="wp-comment-cookies-consent" id="wp-comment-cookies-consent">
                                            <label for="wp-comment-cookies-consent">Save my name, email, and website in this browser for the next time I comment.</label>
                                        </p>
                                        <p class="form-submit">
                                            <input type="submit" name="submit" id="submit" class="submit" value="Post Comment">
                                        </p>
                                    </form> -->
                                </div>
                            </div>
                        </div>
                    </div>

                      
                    <div class="col-lg-4 col-md-12">
                        <aside class="widget-area" id="secondary">
                            <section class="widget widget_search">
                                <form class="search-form search-top">
                                    <label> <span class="screen-reader-text">Search for:</span>
                  <input type="search" class="search-field" placeholder="Search...">
                </label>
                                    <button type="submit"> <i class="fa fa-search"></i>
                </button>
                                </form>
                            </section>
                            <section class="widget widget_warivo_posts_thumb">
                                <h3 class="widget-title">Popular Posts</h3>
                                <?php
                                  query_posts('meta_key=post_views_count&posts_per_page=5&orderby=meta_value_num&
                                  order=DESC');
                                  if (have_posts()) : while (have_posts()) : the_post();
                               ?>
                                <article class="item">
                                    <a href="<?php the_permalink(); ?>" class="thumb"> <span class="fullimage cover bg1" role="img"></span>
                                               </a>
                                    <div class="info">
                                        <span><?php the_date('F d, Y'); ?></span>
                                        <h4 class="title usmall">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h4>
                                    </div>
                                </article>
                               
                               <?php
                               endwhile; endif;
                               wp_reset_query();
                               ?>                               
                            </section>
                            <section class="widget widget_categories">
                                <h3 class="widget-title">Categories</h3>
                                <ul>
                                    <li> <a href="#">Solutions</a>
                                    </li>
                                    <li> <a href="#">Technology</a>
                                    </li>
                                    <li> <a href="#">Mobile Apps</a>
                                    </li>
                                    <li> <a href="#">App Store</a>
                                    </li>
                                    <li> <a href="#">App Development</a>
                                    </li>
                                </ul>
                            </section>
                            <section class="widget widget_archive">
                                <h3 class="widget-title">Archives</h3>
                                <ul>
                                    <li> <a href="#">Oct 2021</a>
                                    </li>
                                    <li> <a href="#">Nov 2021</a>
                                    </li>
                                    <li> <a href="#">Dec 2021</a>
                                    </li>
                                </ul>
                            </section>
                            <section class="widget widget_tag_cloud">
                                <h3 class="widget-title">Tags</h3>
                                <div class="tagcloud"> <a href="#">
                                        IT 
                                        <span class="tag-link-count"> (3)</span>
                                    </a>
                                    <a href="#"> Technology
                                        <span class="tag-link-count"> (3)</span>
                                    </a>
                                    <a href="#">
                                        Applications 
                                        <span class="tag-link-count"> (2)</span>
                                    </a>
                                    <a href="#">
                                        Solutions 
                                        <span class="tag-link-count"> (2)</span>
                                    </a>
                                    <a href="#">
                                        App Store
                                        <span class="tag-link-count"> (1)</span>
                                    </a>
                                    <a href="#">
                                        Industry 
                                        <span class="tag-link-count"> (1)</span>
                                    </a>
                                    <a href="#">
                                        Marketing 
                                        <span class="tag-link-count"> (1)</span>
                                    </a>
                                    <a href="#">
                                        App Development 
                                        <span class="tag-link-count"> (2)</span>
                                    </a>
                                </div>
                            </section>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Blog Details Area -->
  
<?php get_footer(); ?>