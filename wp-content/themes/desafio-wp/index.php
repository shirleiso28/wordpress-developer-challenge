<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package sp
 */

get_header();


$args = array(
    'post_type' => 'videos',
    'post_status' => 'publish',
    'posts_per_page' => 1
);

$queryBanner = new WP_Query ( $args );

if($queryBanner->have_posts()){
    $queryBanner->the_post();

    //Recuperar imagem do banner adicionada no post
    $img_banner = get_post_meta(get_the_ID(),'img_banner',true);

    if(!empty($img_banner)) {
        $bkg_banner = wp_get_attachment_image_url($img_banner, 'full');
    }
    /*else{
        $bkg_topo =  get_template_directory_uri().'/images/banner-topo.png';
    }*/

    //Recuperar duração
    $length = get_post_meta(get_the_ID(), 'txt_length', true);

}

?>

    <div class="banner" style="background-image: url(<?php echo $bkg_banner;?>)">
        <h1 class="hide-h1"><?php echo esc_attr( get_bloginfo( 'name' ) ); ?></h1>
        <div class="container">
            <div class="col-10 col-sm-8 col-md-10 col-xl-8 col-xxl-6 content-banner">
                <div class="details">
                    <div class="btn btn-white"><?php the_terms( get_the_ID(), 'categoria_videos', '', ', ', '' );?></div>
                    <p class="btn btn-outline"><?php echo $length;?></p>
                </div>
                <h2 class="has-title-x-large-font-size"><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <a class="btn btn-red" href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php echo __('Mais informações','template');?></a>
            </div>
        </div>
    </div>
    <main class="main-home">

            <?php
                /*Usei a busca dos termos da categoria, pois assim, se forem adicionadas mais categorias de videos  será pego automaticamente*/

                $terms = get_terms( array(
                    'taxonomy' => 'categoria_videos',
                    'orderby ' => 'date',
                    'order' => 'DESC',
                    'hide_empty' => false,
                ) );


                
                foreach ($terms as $key => $term):

                    $term_tax = $term->slug;

                    $args = array(
                        'post_type' => 'videos',
                        'post_status' => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categoria_videos',
                                'field'    => 'slug',
                                'terms'    => $term_tax,
                            ),
                        ),
                        'order' => 'ASC',
                        'posts_per_page' => 20
                    );

                    

                    $queryFilmes = new WP_Query ( $args );?>


                    <section class="list-videos ">
                        <div class="container">
                            <?php 
                                $term = get_term_by('slug', $term_tax, 'categoria_videos'); 
                                $name = $term->name;
                            ?>
                            <h2 class="has-title-Med-font-size title-video"><?php echo $name;?></h2>
                        </div>
                            <div class="swiper slide-<?php echo $term_tax;?>">
                                <div class="swiper-wrapper">
                                    <?php if($queryFilmes->have_posts()):?>
                                        <?php while($queryFilmes->have_posts()):?>
                                            <?php $queryFilmes->the_post();?>
                                            
                                                    <div class="swiper-slide">
                                                        <?php get_template_part('template-parts/card_video');?>
                                                    </div>
                                                  
                                        <?php endwhile;?>
                                        <?php wp_reset_query();?>
                                    <?php endif;?>
                                </div>
                            </div>
                         </div>
                    </section>
                <?php endforeach;?>

    </main>
<?php
get_footer();