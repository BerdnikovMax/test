<?php
	
	class Help
	{
		public function pw($num, $p) //функция возведения в степень
		{
			if ($p == 0) {
				return 1;
			}

			$result = $num;
			for ($i = 0; $i < $p-1; $i++) {
				$result *= $num;
			}
			return $result;
		}

		public function mn($arr) //функция поиска минимального значения
		{
			$min = null;
			foreach ($arr as $value) {
				if ($value != 0 && $min === null) {
					$min = $value;
				}
				if ($value < $min) {
					$min =$value;
				}
			}
			unset($value);
			return $min;
		}
	}

	class F1
	{	
		private $hl;

		public function __construct(Help $h)
    	{
       	 	$this->hl = $h;
    	}

		public function func($a, $b, $c) //вычисление по формуле 1
		{
			echo "f1 = ($a * $b ^ $c + ((($a / $c) ^ $b) % 3) ^ min($a, $b, $c)) = ";
			return $a * $this->hl->pw($b, $c) + $this->hl->pw((($this->hl->pw(($a / $c), $b)) % 3), $this->hl->mn([$a, $b, $c]));
		}
	}

	class F2
	{
		private $hl;

		public function __construct(Help $h)
    	{
       	 	$this->hl = $h;
    	}

		public function func($a, $b, $c) //вычисление по формуле 2
		{
			echo "f2 = (($a + $b) ^ $c * ($a / $c) ^ min($a, $b, $c)) = ";
			return $this->hl->pw(($a + $b), $c) * $this->hl->pw(($a / $c), $this->hl->mn([$a, $b, $c]));
		}
	}

	class Table
	{
		private $table = '<br/><table border="1">';

		private function header($key)
		{
			$this->table .= '<th style = "color:white; background-color:black;">' . "$key</th>";
		}

		private function column($key, $val)
		{
			if ($key == "ch" && $val === true) {
				$this->table .= "<td>+</td>";
			} else $this->table .= "<td>$val</td>";
		}

		private function line($a)
		{
			$this->table .= '<tr>';
			foreach ($a as $key => $value) {
				$this->column($key, $value);
			}
			$this->table .= '</tr>';
		}

		public function draw($arr)
		{
			foreach ($arr[0] as $key => $value) {
				$this->header($key);
			}
			unset($value, $key);

			foreach ($arr as $a) {
				$this->line($a);
			}
			unset($value, $a, $key);

			$this->table .= '</table>';
			return $this->table;
		}
	}
?>