<?php
	
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

	include ('classes.php');
	require_once ('sql.php');

	function roll($str) //функция перворачивающая строку
	{
		$len = strlen($str);
		$result = '';

		for ($i = 0; $i < $len; $i++) { 
			$result = $str[$i] . $result;
		}

		return $result;
	}

	function str($str, $find) //функция заменяющая второе вхождение подстроки на инвертированную подстроку
	{
		$len = strlen($find);
		$result = '';

		if (substr_count($str, $find) <= 1) {
			echo "Подстрока не входит в строку, или входит менее двух раз<br/>";
			return;
		}

		$pos = strpos($str, $find, strpos($str, $find) + $len);
		$result = substr($str, 0, $pos) . roll($find) . substr($str, $pos + $len);

		return $result;
	}

	function msort($arr, $key, $up) //сортировка методом выбора
	{
		$temp = array();
		$len = count($arr);

		if ($up) {
			for ($i = 0; $i < $len - 1; $i++) { 
				$minindex = $i;
				$min = $arr[$i][$key];
				for ($j = $i + 1; $j < $len; $j++) { 
					if ($arr[$j][$key] < $min) {
						$min = $arr[$j][$key];
						$minindex = $j;
					}
				}
				$temp = $arr[$i];
				$arr[$i] = $arr[$minindex];
				$arr[$minindex] = $temp;
			}

			return $arr;
		} else {
			for ($i = 0; $i < $len - 1; $i++) { 
				$maxindex = $i;
				$max = $arr[$i][$key];
				for ($j = $i + 1; $j < $len; $j++) { 
					if ($arr[$j][$key] > $max) {
						$max = $arr[$j][$key];
						$maxindex = $j;
					}
				}
				$temp = $arr[$i];
				$arr[$i] = $arr[$maxindex];
				$arr[$maxindex] = $temp;
			}

			return $arr;
		}
	}

	function sql($s, $lk){ //выполнение sql запроса
		$arr = array();
		$query = $lk->prepare($s);
		$query->execute();
		$arr = $query->fetchAll();
		return $arr;
	}

	function drawtable($arr){
		$table = '<table border="1">'
				. '<tr><td>id</td>'
				. '<td>Код</td>'
				. '<td>Название</td> '
				. '<td>Цена</td> '
				. '<td>Тип цены</td></tr>';

		foreach ($arr as $a) {
			$table .= "<tr><td>$a[ID]</td>"
					. "<td>$a[Key]</td>"
					. "<td>$a[Name]</td>"
					. "<td>$a[Price]</td>"
					. "<td>$a[Type]</td></tr>";
		}
		$table .= '</table>';
		return $table;
	}

	function xml($arr, &$xml, $p){ //вывод в xml
		foreach ($arr as $a) {
			$product = $p->appendChild($xml->createElement('product'));
			$product->setAttribute('id', $a['ID']);
			$product->setAttribute('key', $a['Key']);
			$product->setAttribute('name', $a['Name']);
			$product->setAttribute('price', $a['Price']);
			$product->setAttribute('type', $a['Type']);
			$product->setAttribute('rubric', $a['RubricID']);
		}
	}

	function rubric($ParentID, $lvl, $lk) { 
	 
		global $lvl;
		$lvl++; 
		 
		$s = "SELECT * FROM rubric WHERE Pid = " . $ParentID . " ORDER BY Name";

		$query = $lk->prepare($s);
		$query->execute();
		 
		echo("<ul>");
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$ID1 = $row["ID"];
			echo("<li>" . $row["Name"] . "</li>");
			//echo("<a href = ?ID=" . $ID1 . ">" . $row["Name"] . "</a><br/>");
			rubric($ID1, $lvl, $lk); 
			$lvl--;
		}
		echo("</ul>");
	 
	}

	echo 'Перевернуть 2 подстроку:<br/><form action="" method="POST">'
		. 'Введите строку <input type="text" name="str"><br/>'
		. 'Введите подстроку <input type="text" name="pstr"><br/>'
		. '<input type="submit" name="roll" value="Перевернуть">'
		. '</form>'; //создание формы

	if (isset($_POST['roll'])) {
		echo str($_POST['str'], $_POST['pstr']) . '<br/>';
	}

	echo '<hr align="left" width="500" size="2" color="#ff0000"/>';

	$mass = array();

	for ($i = 0; $i < 4; $i++) { //заполнение массива
		$mass[$i]["a"] = rand(0, 10);
		$mass[$i]["b"] = rand(0, 10);
		$mass[$i]["c"] = rand(0, 10);
		$mass[$i]["d"] = rand(0, 10);
		$mass[$i]["e"] = rand(0, 10);
	}

	$tbl = new Table;
	echo $tbl->draw($mass);
	unset($tbl);

	echo '<br/>Сортировка массива:<br/><form action="" method="POST">'
		. 'Введите ключ <input type="text" name="key"><br/>'
		. 'По возрастанию <input type="checkbox" name="up"><br/>'
		. '<input type="submit" name="sort" value="Сортировка">'
		. '</form>'; //создание формы

	if (isset($_POST['sort'])) {
		if (isset($_POST['up'])) {
			$mass = msort($mass, $_POST['key'], true); //msort(массив, ключ, по возрастанию)
		} else {
			$mass = msort($mass, $_POST['key'], false);
		}

		$tbl = new Table;
		echo '<br/>Отсортированный массив:' . $tbl->draw($mass);
		unset($tbl);
	}

	echo '<hr align="left" width="500" size="2" color="#ff0000"/>';

	$link = new PDO(
	    "mysql:host=$host;dbname=$database;",
	    $user,
	    $password
	);
	$link->exec("SET NAMES UTF8");
 
	$goods = sql('SELECT * FROM goods
					JOIN prices
					ON prices.ID = goods.ID', $link);

	echo 'Список товаров:<br/>' . drawtable($goods);

	echo '<br/>Вывод в xml:<br/><form action="" method="POST">'
		. '<input type="submit" name="save" value="Сохранить">'
		. '</form>'; //создание формы

	if (isset($_POST['save'])) {
		$xml=new DomDocument('1.0','utf-8');
		$products = $xml->appendChild($xml->createElement('products'));
		xml($goods, $xml, $products);
		$xml->save('goods.xml');
	}

	$goods = sql('SELECT * FROM goods
					JOIN prices
					ON prices.ID = goods.ID
					ORDER BY prices.Price DESC LIMIT 1', $link); //вывод максимальной цены

	echo 'Максимальная цена:<br/>' . drawtable($goods);

	$goods = sql('SELECT * FROM goods 
					JOIN prices
					ON prices.ID = goods.ID
					ORDER BY prices.Price LIMIT 1', $link); //вывод минимальной цены

	echo '<br/>Минимальная цена:<br/>' . drawtable($goods);

	echo '<br/><form action="" method="POST">'
		. '<input type="text" name="text">'
		. '<input type="submit" name="submit" value="Фильтр">'
		. '</form>'; //создание формы

	if (isset($_POST['submit'])) { //применение фильтра
  		$goods = sql('SELECT * FROM goods
  						JOIN prices
  						ON prices.ID = goods.ID
  						WHERE Name = "' . $_POST['text'] . '"', $link);

		echo drawtable($goods);
	}

	echo '<br/>Запись xml в БД:<br/><form action="" method="POST">'
		. '<input type="submit" name="load" value="Загрузить в базу">'
		. '</form>'; //создание формы

	if (isset($_POST['load'])) {
		$xml_file = "goodsIN.xml";

		if (file_exists($xml_file)) {
			$xml = simplexml_load_file($xml_file);
			foreach ($xml->xpath("//products/product") as $segment) {
				$row = $segment->attributes();
				$sql = "INSERT INTO goods (`ID`, `Key`, `Name`, `RubricID`) VALUES(" . $row["id"] . ", " . $row["key"] . ", '" . $row["name"] . "', " . $row["rubric"] . ");";
				$link->exec($sql);
				//echo '<br/>' . $sql . '<br/>';
			}

			foreach ($xml->xpath("//products/product") as $segment) {
				$row = $segment->attributes();
				$sql = "INSERT INTO prices (`ID`, `Price`, `Type`) VALUES(" . $row["id"] . ", " . $row["price"] . ", '" . $row["type"] . "');";
				$link->exec($sql);
				//echo '<br/>' . $sql . '<br/>';
			}

		} else {
			exit('Не удалось открыть файл ' . $xml_file);
		}
	}
	 
	rubric(0, 0, $link);
?>