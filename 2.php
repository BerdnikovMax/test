<?php

	include ('classes.php');
	
	function prime($num) //функция проверки на простые числа
	{
		for ($i = 2; $i <= sqrt($num); $i++) {
			if ($num % $i == 0) {
				return false;
			}
		}
    	return true;
	}

	function area($a, $b, $h) //функция рассчета площади трапеции
	{
		return (($a + $b) / 2) * $h;
	}

	/*function mnmass($arr)
	{
		$min = null;
		foreach ($arr as $a) {
			foreach ($a as $value) {
				if ($value != 0 && $min == null) {
					$min = $value;
				}
				if ($value < $min) {
					$min =$value;
				}
			}
		}
		unset($value, $a);
		return $min;
	}*/

	$start = 10;
	$end = 53;
	$count = 0;

	$mass = array();
	$temp = array();

	echo 'Простые числа: <br/>';

	for ($i = $start; $i <= $end; $i++) { //подсчёт простых чисел
		if (prime($i)) {
			echo "$i ";
			$temp[$count] = $i;
			$count++;
		}
	}
	echo "<br/>Количество простых чисел: $count<br/><br/>Массив:<br/>";

	for ($i = 0, $j = 0; $i <= 2; $i++, $j+=3) { //заполнение двумерного массива
		$mass[$i] = ["a" => $temp[$j], "b" => $temp[$j+1], "c" => $temp[$j+2]];
	}

	for ($i = 0, $m_l = count($mass); $i < $m_l; $i++) { //добавление в массив информации о площади
		$mass[$i]["s"] = area($mass[$i]["a"], $mass[$i]["b"], $mass[$i]["c"]);
	}

	foreach ($mass as $m) { //вывод массива
		foreach ($m as $key => $value) {
			echo "$key = $value<br/>";
		}
		echo "<br/>";
	}
	unset($value, $m, $key);

	$count = 0;
	$max = 0; //поиск максимальной площади меньше 1400
	do {
		if ($mass[$count]["s"] > $max && $mass[$count]["s"] < 1400) {
			$max = $mass[$count]["s"];
		}
		$count++;
	} while ($count < $m_l);
	echo "Самая большая площадь трапеции: $max<br/>";

	$h = new Help;
	$f1 = new F1($h);
	echo '<br/>Результаты вычислений f1:<br/>';
	for ($i = 0; $i < $m_l; $i++) {  //занесение в массив результатов вычислений f1 и вывод их на экран
		$mass[$i]["f1"] = $f1->func($mass[$i]["a"], $mass[$i]["b"], $mass[$i]["c"]);
		echo $mass[$i]["f1"], "<br/>";
	}

	$f2 = new F2($h);
	echo '<br/>Результаты вычислений f2:<br/>';
	for ($i = 0; $i < $m_l; $i++) {  //занесение в массив результатов вычислений f2 и вывод их на экран
		$mass[$i]["f2"] = $f2->func($mass[$i]["a"], $mass[$i]["b"], $mass[$i]["c"]);
		echo $mass[$i]["f2"], "<br/>";
	}

	foreach ($mass as $mkey => $m) { //проверка чётности площадей
                    $mass[$mkey]["ch"] = ($m["s"] % 2) == 0;
    }
	unset($value, $m, $mkey, $key);

	/*echo '<br/>Таблица:'; //вывод массива в таблице
	$table = '<br/><table border="1">'; 
	foreach ($mass[0] as $key => $value) {
		$table .= '<th style = "color:white; background-color:black;">' . "$key</th>";
	}
	unset($value, $key);
	foreach ($mass as $m) {
		$table .= '<tr>';
		foreach ($m as $key => $value) {
			$table .= "<td>$value</td>";
		}
		$table .= '</tr>';
	}
	unset($value, $m, $key);
	$table .= '</table>';
	echo $table;*/

	$tbl = new Table;
	echo $tbl->draw($mass);

?>