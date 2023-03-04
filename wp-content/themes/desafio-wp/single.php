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
get_header();?>

    <main>
        <div class="container">
            <?php if(have_posts()):?>
                <?php while(have_posts()):?>
                    <?php the_post();?>
                    <?php 
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

                        //Recupera url do youtube
                        $url_youtube = get_post_meta(get_the_ID(),'url_youtube',true);

                        if (strpos($url_youtube, 'youtu') > 0) { // If Youtube
                            $regExp = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";
                            preg_match($regExp, $url_youtube, $video);
                            $url = $video[7];
                        }
                    ?>
                    <div class="col-10 col-xxl-8 data">
                        <div class="details">
                            <p class="btn btn-white"><?php the_terms( get_the_ID(), 'categoria_videos', '', ', ', '' );?></p>
                            <p class="btn btn-outline"><?php echo $length;?></p>
                        </div>
                        <h1 class="has-title-large-font-size"><a href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
                    </div>
                    <div class="play-video" onclick="reproduzirVideo('<?php echo $url;?>','<?php the_title();?>');">
                        <img src="<?php echo $bkg_banner;?>" title="<?php the_title();?>" alt="<?php the_title();?>"/>
                    </div>
                    <div class="reproduzirVideo"></div>

                    <div class="col-10 col-xxl-8 content">
                       <?php the_content();?>
                    </div>
               <?php endwhile;?>
           <?php endif;?>
        </div>
    </main>

<?php get_footer();