
<html>
<link rel="stylesheet" href="crawler.css">	
<body class="body">
	<div class="part">
	<form name='url' action='' method='GET' align="center">
	<font size="7"><p align="center">Add WebSite Using Crawler</p></font>
	
		<table align="center" id="table"> 
			<tr><td>
				URL:</td><td> <input type='url' name='url_to_crawl' id='url_to_crawl'/> 
			</td></tr>
			<tr>
			<td colspan="2" align="center"><br><font size="10px">OR</font><br></td></tr>
			<tr><td> Keyword:</td><td> <input type='text' name='keyword' id='keyword'/>
			</td></tr>
			
			<tr><td align="center" colspan="2"><br><input type='submit' name='search' value='search' id="searchbt"/>	
				<input type='submit' name='stop' value='stop' id="stopbt"/>
				<a href='http://localhost/projects/search.html'><input type='Button' value='Home' id="backbt"/></a>
			</td></tr>
		</table>
		<font size="40px"><p align="center">00</p><font>
	</form></div>
</body></html>
<?php
/*
 * howCode Web Crawler Tutorial Series Source Code
 * Copyright (C) 2016
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * https://howcode.org
 *
*/


if(array_key_exists('search',$_GET)){
	Search_start();
}

function Search_start(){
	$start="";
if($_GET['url_to_crawl']){
	$start=$_GET['url_to_crawl'];
}else if($_GET['keyword']){
	$start="https://www.google.com/search?client=firefox-b-d&q=".$_GET['keyword'];
}

//$_GET['search_text']
if($start){
// This is our starting point. Change this to whatever URL you want.
echo "start ";
echo $start;
// Our 2 global arrays containing our links to be crawled.

$already_crawled = array();
$crawling = array();
function get_details($url) {

	// The array that we pass to stream_context_create() to modify our User Agent.
	$options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: howBot/0.1\n"));
	// Create the stream context.
	$context = stream_context_create($options);
	// Create a new instance of PHP's DOMDocument class.
	$doc = new DOMDocument();
	// Use file_get_contents() to download the page, pass the output of file_get_contents()
	// to PHP's DOMDocument class.
	@$doc->loadHTML(@file_get_contents($url, false, $context));

	// Create an array of all of the title tags.
	$title = $doc->getElementsByTagName("title");
	// There should only be one <title> on each page, so our array should have only 1 element.
	$title = $title->item(0)->nodeValue;
	// Give $description and $keywords no value initially. We do this to prevent errors.
	$description = "";
	$keywords = "";
	// Create an array of all of the pages <meta> tags. There will probably be lots of these.
	$metas = $doc->getElementsByTagName("meta");
	// Loop through all of the <meta> tags we find.
	for ($i = 0; $i < $metas->length; $i++) {
		$meta = $metas->item($i);
		// Get the description and the keywords.
		if (strtolower($meta->getAttribute("name")) == "description")
			$description = $meta->getAttribute("content");
		if (strtolower($meta->getAttribute("name")) == "keywords")
			$keywords = $meta->getAttribute("content");

    }
    
    include("connection.php");
        $website_title=$title;
        $website_link=$url;
        $website_keywords=$keywords;
        $website_desc=$description;
    
            $query="INSERT INTO add_website VALUES('$website_title','$website_link','$website_keywords','$website_desc',' ')";
            $data=mysqli_query($conn,$query);
            if($data){
                echo "'website inserted')</script>\n\n";

            }
            else{
                echo "<script>alert('faild')</script>";
            }
    
       

	// Return our JSON string containing the title, description, keywords and URL.
	return '{ "Title": "'.str_replace("\n", "", $title).'", "Description": "'.str_replace("\n", "", $description).'", "Keywords": "'.str_replace("\n", "", $keywords).'", "URL": "'.$url.'"},';
	if(array_key_exists('stop',$GET)){
		echo "stop";
	}		
}

function follow_links($url) {
	// Give our function access to our crawl arrays.
	global $already_crawled;
	global $crawling;
	// The array that we pass to stream_context_create() to modify our User Agent.
	$options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: howBot/0.1\n"));
	// Create the stream context.
	$context = stream_context_create($options);
	// Create a new instance of PHP's DOMDocument class.
	$doc = new DOMDocument();
	// Use file_get_contents() to download the page, pass the output of file_get_contents()
	// to PHP's DOMDocument class.
	@$doc->loadHTML(@file_get_contents($url, false, $context));
	// Create an array of all of the links we find on the page.
	$linklist = $doc->getElementsByTagName("a");
	// Loop through all of the links we find.
	foreach ($linklist as $link) {
		$l =  $link->getAttribute("href");
		// Process all of the links we find. This is covered in part 2 and part 3 of the video series.
		if (substr($l, 0, 1) == "/" && substr($l, 0, 2) != "//") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l;
		} else if (substr($l, 0, 2) == "//") {
			$l = parse_url($url)["scheme"].":".$l;
		} else if (substr($l, 0, 2) == "./") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].dirname(parse_url($url)["path"]).substr($l, 1);
		} else if (substr($l, 0, 1) == "#") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].parse_url($url)["path"].$l;
		} else if (substr($l, 0, 3) == "../") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
		} else if (substr($l, 0, 11) == "javascript:") {
			continue;
		} else if (substr($l, 0, 5) != "https" && substr($l, 0, 4) != "http") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
		}
		// If the link isn't already in our crawl array add it, otherwise ignore it.
		if (!in_array($l, $already_crawled)) {
				$already_crawled[] = $l;
				$crawling[] = $l;
				// Output the page title, descriptions, keywords and URL. This output is
				// piped off to an external file using the command line.
				echo get_details($l)."\n";
		}

	}
	// Remove an item from the array after we have crawled it.
	// This prevents infinitely crawling the same page.
	array_shift($crawling);
	// Follow each link in the crawling array.
	foreach ($crawling as $site) {
		follow_links($site);
	}

}

// Begin the crawling process by crawling the starting link first.
follow_links($start);
}else{
	echo "nothing is going on";
}
}