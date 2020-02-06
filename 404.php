<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all cf" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">

						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'Epic 404 - Article Not Found', 'bonestheme' ); ?></h1>

							</header>
	
							<section class="entry-content">

								<p><?php _e( "The page you are looking for no longer exists. Perhaps you can return back to the site's <a href='" . home_url( '/' ) . "'>homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form bellow.", 'bonestheme' ); ?></p>

								<p>
								<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
									<div>
										<label for="s" class="screen-reader-text" id='search-label'>Search more than <?php $total = wp_count_posts()->publish; echo $total; ?> articles:</label>
										<input type="search" id="s" name="s" value="">

										<button type="submit" id="searchsubmit">Search</button>
									</div>
								</form>
								</p>

								
							</section>
							
						</article>

					</main>

				</div>

			</div>

<?php get_footer(); ?>
