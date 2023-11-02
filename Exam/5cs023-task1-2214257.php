<?php

	try {
		$conn = new PDO("mysql:host=mi-linux.wlv.ac.uk;dbname=db2214257","2214257", "Darklord1966!");
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $conn->query("SELECT * FROM videogames ORDER BY Price;");
		$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
		?>
			<table border="1">
				<tr>
					<th>Game name</td>
					<th>Genre</td>
					<th>Price</td>
					<th>Date of release</td>
				</tr>
<?php
		foreach ($games as $game) {
?>
				<tr>
					<td><?=$game['Game_name']?></td>
					<td><?=$game['Genre']?></td>
					<td><?=$game['Price']?></td>
					<td><?=$game['Date of release']?></td>
				</tr>
<?php
		}
			echo '</table>';
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>