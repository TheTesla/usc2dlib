<?php
header("Content-Type: application/xml");
?>
<?xml version='1.0' encoding='ISO-8859-1'?>
<?xml-stylesheet type='text/xsl' href='image_metadata_stylesheet.xsl'?>
<dataset>
<name>imglab dataset</name>
<comment>Converted from USC format by USC2dlib.php.</comment>
<images>
<?php
	$annodirname = "USCPedestrianSetA";
	$annofilenamevec = scandir($annodirname, SCANDIR_SORT_ASCENDING);
	foreach($annofilenamevec as $annofilename) {
		if(".gt.xml"!=substr($annofilename, -7)) continue;
		$p = xml_parser_create();
		$annofile = fopen($annodirname."/".$annofilename , "r") or die("Unable to open file!");
		$imgfilename = substr($annofilename, 0, -7) . ".bmp";
		$boxveclen = 0;
		$simple = fread($annofile, filesize($annodirname."/".$annofilename));
		xml_parse_into_struct($p, $simple, $vals, $index);
		
		echo "<image file='$imgfilename'>";
		foreach($vals as $val){
			if(3 == $val['level']){
				$x = $val['attributes']['X'];
				$y = $val['attributes']['Y'];
				$w = $val['attributes']['WIDTH'];
				$h = $val['attributes']['HEIGHT'];
				echo "<box top='$y' left='$x' width='$w' height='$h'/>";
			}
		}
		xml_parser_free($p);
		echo "</image>";
		fclose($annofile);
	}

?>
</images>
</dataset>
