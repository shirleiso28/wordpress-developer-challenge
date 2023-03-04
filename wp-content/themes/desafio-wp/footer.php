<?php
/**
 * Footer - O modelo para exibir o rodapé
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package solucaodigital
 */

?>
</div>  <!--.wrap-page @header -->
<footer>
    <div class="container">
        <div class="footer-copy">
            <?php 
                if(has_custom_logo()){
                    the_custom_logo();  
                }
            ?>
            <p class="has-text-font-size">&copy; 2020 — <?php bloginfo('name'); ?> — Todos os direitos reservados.</p>
            <!-- Para ano sempre atualizado - usar código abaixo -->
            <!-- <p class="has-text-font-size">&copy;  <?php echo date('Y');?> — <?php bloginfo('name'); ?> — Todos os direitos reservados.</p> -->
        </div>
    </div>
    <!-- Área do menu mobile-->
    <div class="col-12 menu-mobile d-md-none d-block">
        <div class="container">
            <?php 
            if(has_nav_menu('bottom')){
                wp_nav_menu(array(
                    'theme_location' => 'bottom',
                    'container' => 'nav',
                    'container_class' => 'navbar',
                    'fallback_cb' => false,
                    'menu_class' => 'nav navbar-nav'
                ));
            }
            ?>
        </div>
    </div>
    <!-- Fim área menu mobile-->
</footer>



<?php wp_footer(); ?>
</body>
</html>
