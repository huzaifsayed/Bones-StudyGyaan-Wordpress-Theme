			<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

				<div id="inner-footer" class="wrap cf">

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => 'div',                           // enter '' to remove nav container (just make sure .footer-links in _base.scss isn't wrapping)
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
    					'after' => '',                                  // after the menu
    					'link_before' => '',                            // before each link
    					'link_after' => '',                             // after each link
    					'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

					<p class="source-org copyright "> 
						&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. 
						Download <a target="_blank" href="https://studygyaan.com/download-free-premium-wordpress-theme">Theme</a>.
						<div id="share-buttons" class="post-sharer">
							<a id="facebook" target="_blank" href="https://www.facebook.com/ProfessionalCipher/" class="share-button facebook">Facebook</a>
							<a id="twitter" target="_blank" href="https://twitter.com/studygyaan" class="share-button twitter">Twitter</a>
							<a id="pinterest" target="_blank" href="https://www.instagram.com/studygyaan/" class="share-button pinterest">Pinterest</a>
							<a id="linkedin" target="_blank" href="https://www.linkedin.com/in/study-gyaan-94847b18a" class="share-button linkedin">Linkedin</a>
							<a id="youtube" target="_blank" href="https://www.youtube.com/channel/UCXDuUu3Mu9ktnfUWIbkEKgw" class="share-button youtube">YouTube</a>
						</div>
						
					</p>

					

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>

		<?php wp_footer(); ?>

		<!-- Sticky Sidebar -->
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.content, .sidebar').theiaStickySidebar({
			// Settings
			additionalMarginTop: 30
			});
		});
		</script>

	</body>

</html> <!-- end of site. what a ride! -->
