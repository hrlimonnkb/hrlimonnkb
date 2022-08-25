<?php

if (!isset($_GET['app'])) {
	http_response_code(404);
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	exit('404 not found');
}

require_once('wp-load.php');

$post = get_post($_GET['app']);

if (!$post) {
	header("HTTP/1.1 404 Not Found");
	$notfound = get_404_template();
	include $notfound;
	return;
}

$image = get_the_post_thumbnail_url($_GET['app']);
$image_name = pathinfo($image, PATHINFO_FILENAME);
$appId = str_replace('-', '.', $image_name);
$uri = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

// Remove Break
$content = $text = str_replace(["\n", "\r"], "", strip_tags($post->post_content));

// Remove Tab
$content = preg_replace('/\t+/', ' ', $content);

// Remove link
$content = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $content);

// Text Shorten
$content_short = mb_substr($content, 0, 140);

function DOMinnerHTML(DOMNode $element)
{
    $innerHTML = "";
    $children = $element->childNodes;
    foreach ($children as $child)
    {
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    return $innerHTML;
}

// This not use this project
function getElContentsByTagClass($html,$tag,$class)
{
    $doc = new DOMDocument();
    $doc->loadHTML(htmlspecialchars($html));//Turn the $html string into a DOM document
    $els = $doc->getElementsByTagName($tag); //Find the elements matching our tag name ("div" in this example)
    foreach($els as $el)
    {
        //for each element, get the class, and if it matches return it's contents
        $classAttr = $el->getAttribute("class");
        if(preg_match('#\b'.$class.'\b#',$classAttr) > 0) 
        	return DOMinnerHTML($el);
    }
}

// For introduction
function getElementById($content, $id)
{
	$doc = new DOMDocument();
	$doc->loadHTML(htmlspecialchars($content));
	$elments = $doc->getElementById($id);
	if ($elments) {
		return DOMinnerHTML($elments); //with html
		// return $elments->textContent; //without html
	}
}

$introduction = getElementById($post->post_content, 'introduction');

// For Table
function contentBetweenTags($content, $tagname, $attr = ""){
    $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
    preg_match($pattern, $content, $matches);
    
    if(empty($matches))
        return;
    
    $str = "<$tagname $attr>".$matches[1]."</$tagname>";
    return $str;
}

// Head Section

function custom_document_title( $title ) {
	global $post;
    return 'Download '.$post->post_title;
}

function my_hook_header() {
	global $content_short, $post, $uri, $image;

	echo '<meta name="description" content="Download pc windows and mac application '.$content_short.'" />
	<meta name="robots" content="noindex, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
	<link rel="canonical" href="'.$uri.'" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:site_name" content="'.get_bloginfo().'" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="'.$post->post_title.'" />
	<meta property="og:description"Download pc windows and mac application '.$content_short.'" />
	<meta property="og:url" content="'.$uri.'" />
	<meta property="og:image" content="'.$image.'" />
	<meta property="og:image:secure_url" content="'.$image.'" />
	<meta property="og:image:width" content="989" />
	<meta property="og:image:height" content="571" />
	<meta property="article:published_time" content="'.$post->post_date.'" />
	<meta property="article:modified_time" content="'.$post->post_modified.'" />';
}

add_filter('pre_get_document_title', 'custom_document_title', 99 );
add_action('wp_head', 'my_hook_header', 1);
get_header();
?>

<style>
:root {
  --mastercolor: #3571FE;
}
table.frhd-table{margin-bottom:10px}table.frhd-table tr svg{height:18px;width:18px;fill:var(--mastercolor);margin-right:7px;margin-bottom:-2px}table.frhd-table tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}table.frhd-table td{padding:10px}.frhd-table thead h2{padding:10px;background:#d9edf7}.frhd-table thead tr th{background:#d9edf7;padding:12px;font-size:20px}a.frhd-after-tbl-btn svg{width:20px;height:20px;fill:#fff;margin-right:7px;margin-bottom:-3px}a.frhd-after-tbl-btn{width:100%;background:var(--mastercolor);display:block;text-align:center;border-radius:5px;padding:5px;color:#fff;text-decoration:none}.frhd-table caption{background:var(--mastercolor);color:#fff;text-align:center;font-weight:700}@media screen and (min-width:600px){table.frhd-table tr td:first-child{width:30%}}@media screen and (max-width:600px){table.frhd-table{border:0}table.frhd-table caption{font-size:1.3em;border-bottom:1px solid gray}table.frhd-table thead{border:none;clip:rect(0 0 0 0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}table.frhd-table tr{border-bottom:3px solid #ddd;display:block;margin-bottom:.625em}table.frhd-table td{border-bottom:1px solid #ddd!important;display:block;font-size:1em;text-align:center}table.frhd-table td::before{content:attr(data-label);float:left;font-weight:700;text-transform:uppercase}table.frhd-table td:last-child{border-bottom:0!important}table.frhd-table td:first-child{background:#d9edf7!important}}a.frhd-gp-link svg{width:140px!important;height:50px!important}
</style>

<!-- You Can Change From This -->

<div id="post" class="ct-container" style="margin: 0 auto;">
	<main id="main" class="site-main">
		<article id="post-904221" class="post-904221 download type-download status-publish has-post-thumbnail hentry no-featured-image-padding" itemtype="https://schema.org/CreativeWork" itemscope="">
			<div class="inside-article">
				<header class="entry-header">
					<h1 class="entry-title" itemprop="headline"><?php echo $post->post_title; ?> for Windows 10/8/7 PC and Mac Download Free</h1> 
				</header>
				<div class="entry-content" itemprop="text">

					<?php if ($introduction): ?>
					<p><?php echo $introduction; ?></p>
					<?php endif ?>

					<h4>Technical Information: <?php echo $post->post_title; ?> for Windows 10/8/7 PC and Mac Download Free</h4>

					<!-- Table -->
					<?php echo contentBetweenTags($post->post_content, "table", "class='frhd-table'"); ?>

					<p><a href="https://play.google.com/store/apps/details?id=<?php echo $appId; ?>"><button id="downloadButton">Download</button></a></p>
					<p><strong>Step 1</strong>: Download the <a href="https://www.bluestacks.com/download.html">Bluestacks Android emulator</a> from the link above</p>
					<p><strong>Step 2</strong>: When the download is complete, double click on the bluestacks.exe file. So, now you are ready to install Bluestacks on your Windows computer.</p>
					<p><strong>Step 3</strong>: The installation doesn’t consume a lot of time. After installing the emulator, click on the Bluestacks icon. Wait for a few moments so that the emulator can launch itself initially. Now, you need to Log in with your Google account on the emulator.</p>
					<p><strong>Step 4</strong>: After logging into your Google account, you will find the emulator’s home screen. <strong>Find Google Play store app on</strong> the home screen or app list, and click on it.</p>
					<p><strong>Step 5</strong>: After waiting for a few minutes, Google play store will open. After that, search for the app on your computer.</p>
					<p><strong>Step 6</strong>: Now, click on the <strong>install button to</strong> start installing this App– Original. When the installation is complete, locate the app on the app list.</p>
					<p>Now, you are ready to use this app on your computer. The app will work just like your smartphone.<br>
						<a href="https://play.google.com/store/apps/details?id=<?php echo $appId; ?>"><button id="downloadButton">Download</button></a>
					</p>
					<h4><span id="Method_2">Download For PC Windows 10/8/7 – Method 2</span></h4>
					<p><strong>Nox App Play</strong>.is another great emulator for game freaks. Play your favorite <strong>high-end games like PUBG, Battlefield games, NFC, etc </strong>on your computer using Nox app play. This emulator is lightweight compared to Bluestacks. However, this one is not that good in terms of graphics. So, without further ado, let’s move on with how to install <strong>this app – Original for PC Windows 10/8/7</strong> using Nox app Play.</p>
					<p><strong>Step 1</strong>: Just like the first one, the Download Nox app plays an Emulator on your computer. Here we have a download link for <a href="https://www.bignox.com/">Nox app Play</a>.</p>
					<p><strong>Step 2</strong>: After downloading the .exe file, double click on it<strong>.</strong> Wait for 2 to 3 minutes as the installation proceeds.</p>
					<p><strong>Step 3</strong>: Just like Bluestacks, in Nox app play Google Playstore comes pre-installed<strong>.</strong> You can see when the app is installed. Now, you need to double-tap on the icon to open it.</p>
					<p><strong>Step 4</strong>: After that, log in with your Google account<strong>.</strong>Then, search for the app you want to install the app we are going to install.</p>
					<p><strong>Step 5</strong>: You need to find the right app by <strong>Magikbee. </strong>Then you find the app icon on the home screen and then, tap the <strong>Install</strong></p>
					<p>The best thing about the Nox app play is Simplicity. Yes, it is not that great in terms of graphics. But the UI is very smooth and user friendly to run faster. That is a major pro for many users whose computer configuration is not that good.</p>
					<center><iframe width="950" height="400" src="https://www.youtube.com/embed/klu47EDvCHo" title="How to install Google Play Store App on PC or Laptop | Download Play Store Apps on PC" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>
				</div>
			</div>
		</article>
	</main>
</div>

<!-- You can change this far -->

<?php get_footer(); ?>