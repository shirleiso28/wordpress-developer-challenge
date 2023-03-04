<?php
$length = get_post_meta(get_the_ID(), 'txt_length', true);
?>
<div class="card-videos">
    <a href="<?php the_permalink(); ?> " title="<?php the_title(); ?>">
        <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail('img_capa', array('class' => 'thumbnail')); ?>
        <?php endif; ?>
    </a>
    <a class="btn btn-outline" href="<?php the_permalink();?>" title="<?php the_title(); ?>"><?php echo $length;?></a>
    <h3 class="has-title-font-size"><a href="<?php the_permalink(); ?> " title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
</div>

