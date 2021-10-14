<?php


echo '<html>'."\n";
echo '<head>'."\n";
echo '<title>První</title>'."\n";
echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />'."\n";
echo '<link rel="stylesheet" type="text/css" media="screen" href="./bootstrap/css/bootstrap.css" />'."\n";
echo '</head>'."\n";
echo '<body>'."\n";

echo '<div class="container">'."\n";

echo '<h1>Vytvoření XML</h1>'."\n";

        $dom = new DOMDocument();
		$dom->encoding = 'utf-8';
		$dom->xmlVersion = '1.0';
		$dom->formatOutput = true;

	    $xml_file_name = 'movies_list.xml';

	    $root = $dom->createElement('Movies');

	    $movie_node = $dom->createElement('movie');

	    $attr_movie_id = new DOMAttr('movie_id', '5467');
        $movie_node->setAttributeNode($attr_movie_id);

		$child_node_title = $dom->createElement('Title', 'The Campaign');
		$movie_node->appendChild($child_node_title);

		$child_node_year = $dom->createElement('Year', 2012);
		$movie_node->appendChild($child_node_year);

		$child_node_genre = $dom->createElement('Genre', 'Drama');
		$movie_node->appendChild($child_node_genre);

		$child_node_rating = $dom->createElement('Rating', 6.2);
		$movie_node->appendChild($child_node_rating);

		$root->appendChild($movie_node);
		$dom->appendChild($root);
        $dom->save($xml_file_name);

	    //echo "$xml_file_name byl úspěšně vytvořen";

echo '</div>'."\n";
echo '</body>'."\n"; 
echo '</html>'."\n"; 

?>
