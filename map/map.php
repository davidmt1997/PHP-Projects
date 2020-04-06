<?php
	header("Content-Type: image/png");

	(isset($_REQUEST['w'])) ? $width = $_REQUEST['w'] : $width = 500;
	(isset($_REQUEST['h'])) ? $height = $_REQUEST['h'] : $height = 500;

	$image = ImageCreate($width, $height);

	$black = ImageColorAllocate($image, 0, 0, 0);
	$colors = [
		ImageColorAllocate($image, 0, 65, 106),
		ImageColorAllocate($image, 255, 255, 255),
		ImageColorAllocate($image, 244, 244, 65),
		ImageColorAllocate($image, 244, 184, 65),
		ImageColorAllocate($image, 244, 0, 0),
		ImageColorAllocate($image, 0, 244, 0)];

		ImageFilledRectangle($image, 0,0,$width,$height, $colors[0]);

		$degLimit = [
		'min_lat' => -90,
		'max_lat' => 90,
		'min_lon' => -180,
		'max_lon' => 180,];

		function updateLimits($deg, $limit){
			if($deg['min_lat'] < $limit['min_lat']) $limit['min_lat'] = $deg['min_lat'];
			if($deg['max_lat'] > $limit['max_lat']) $limit['max_lat'] = $deg['max_lat'];
			if($deg['min_lon'] < $limit['min_lon']) $limit['min_lon'] = $deg['min_lon'];
			if($deg['max_lon'] > $limit['max_lon']) $limit['max_lon'] = $deg['max_lon'];
			return $limit;
		}

		function getSize(){
			isset($_REQUEST['size']) ? $size = $_REQUEST['size'] : $size = 500;
			return $size;
		}

		/*function drawCountry($degLimit, $image, $stmt, $colors, $val, $black){
			$polygons = [];
			$size = getSize();
		
			
			while($row = $stmt->fetch()){
				#foreach ($row as $r) {
				print_r($row);
				$polygons[$row['poly']] = (($row['lon']-$degLimit['max_lon'])/($degLimit['max_lon']-$degLimit['min_lon'])*$size);
				$polygons[$row['poly']] = (($row['lat']-$degLimit['max_lat'])/($degLimit['max_lat']-$degLimit['min_lat'])*$size);
				#}
				#print_r($polygons);
			}
			#foreach ($polygons as $p) {	
				ImageFilledPolygon($image, $polygons, count($polygons)/2, $colors[$val]);
				ImagePolygon($image, $polygons, count($polygons)/2, $black);
			#}
			
		}*/

		try {
			$dbh = new PDO('mysql:host=localhost;dbname=nations', 'randy', "");

			$query = "SELECT MAX(Latitude) AS max_lat, MIN(Latitude) AS min_lat, MAX(Longitude) AS max_lon, MIN(Longitude) AS min_lon FROM edges JOIN polygons ON edges.Polygon=polygons.Polygon WHERE polygons.Code LIKE ?;";
			$stmt = $dbh->prepare($query);

			foreach($_REQUEST as $key){
				if(strlen($key) == 2){
					if($stmt->execute([$key])){
						$row = $stmt->fetch();
						$degLimit = updateLimits($row, $degLimit);
					}
				}
			}

			$query2 = "SELECT Latitude AS lat, Longitude AS lon, edges.Polygon AS poly FROM edges JOIN polygons ON edges.Polygon = polygons.Polygon WHERE polygons.Code LIKE ? order by edge;";
			$stmt = $dbh->prepare($query2);
			foreach($_REQUEST as $key => $val){
				if($stmt->execute([$key])){
					$polygons = [];
					$size = getSize();
					while($row = $stmt->fetch()){
						$polygons[$row['poly']][] = (($row['lon']-$degLimit['min_lon'])/($degLimit['max_lon']-$degLimit['min_lon'])*$size);
						$polygons[$row['poly']][] = ($size-($row['lat']-$degLimit['min_lat'])/($degLimit['max_lat']-$degLimit['min_lat'])*$size);
						
						
					}
					#print_r($polygons);
					foreach ($polygons as $p) {	
						ImageFilledPolygon($image, $p, count($p)/2, $colors[$val]);
						ImagePolygon($image, $p, count($p)/2, $black);
					}

				}
			}
		}

		
		catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		ImagePNG($image);
		ImageDestroy($image);

?>