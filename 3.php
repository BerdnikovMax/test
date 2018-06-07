<?php
	
	include ('classes.php');

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

	echo str('abcdbce', 'bc') . '<br/>';

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

	$mass = msort($mass, "a", true); //msort(массив, ключ, по возрастанию)
	
	$tbl = new Table;
	echo $tbl->draw($mass);
	unset($tbl);
?>