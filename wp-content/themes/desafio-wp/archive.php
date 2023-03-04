<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sd
 */
get_header();

?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 description">
                    <h1 class="has-title-Med-font-size title-video"><?php the_archive_title(); ?></h1>
                    <?php the_archive_description();?>
                   
                    
                </div>
                <div class="col-12 col-md-6 list">
                    <?php 
                        $term_id = get_queried_object_id();
              
                        $args = array(
                            'post_type' => 'videos',
                            'post_status' => 'publish',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categoria_videos',
                                    'field'    => 'term_id',
                                    'terms'    => $term_id,
                                ),
                            ),
                            'posts_per_page' => 20
                        );

                        $queryVideos = new WP_Query ( $args );
                    ?>
                    <div class="row">
                        <?php if($queryVideos->have_posts()):?>
                            <?php while($queryVideos->have_posts()):?>
                                <?php $queryVideos->the_post();?>
                                
                                    <div class="col-6 col-lg-4">
                                            <?php get_template_part('template-parts/card_video');?>
                                    </div>
                                  
                            <?php endwhile;?>
                            <?php wp_reset_query();?>
                        <?php endif;?>
                    </div>

                </div>
            </div>
        </div>
    </main>
<?php get_footer();

