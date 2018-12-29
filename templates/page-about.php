<div class="container">
	<article>
		<h2 class="title is-2">
			About This Blog
		</h2>
		
		<section class="content">
			<p>
				This blog was created to demonstrate the API Blog software.
				
				It is a very simple, very light CMS. It consists of:
			</p>
			
			<ul>
				<li>
					SEO-friendly Clean URLs
				</li>
				
				<li>
					API class <code>Blog</code> with CRUD and pagination functionality for blog posts, essentially a proto-Model class
				</li>
				
				<li>
					A very basic proto-Controller system; URIs are matched against an array of functions (<code>$routes</code>) which return the page's content.
					It can find a route that matches the first part of the URL (split by <code>/</code>), so anything after the route's name can be used
					as a parameter (e.g. <code>archive/page/2/</code> matches route <code>archive</code>, and <code>2</code> is the page number parameter)
				</li>
				
				<li>
					A view function, <code>template($file, $vars = [])</code>, which grabs a template part from the <code>./templates/</code> directory, makes
					everything in the associative array <code>$vars</code> local to the template, and returns the output
				</li>
				
				<li>
					A painfully simple fatal error function (<code>FatalError($e)</code>) which takes down the page, gives a 500 header, and logs the given
					error (if there is one). Check out the 500 page <a href="<?=url()?>/500/">here</a>, just for fun!
				</li>
				
				<li>
					A database static class (<code>DB</code>) which makes sure all necessary tables exist on page load, simplifies SQL error handling with
					<code>FatalError()</code>, and makes global access to the database easy, since a static class can be called from anywhere (no need to
					mess with <code>global</code> or <code>$GLOBALS</code>!)
				</li>
			</ul>
		</section>
	</article>
</div>