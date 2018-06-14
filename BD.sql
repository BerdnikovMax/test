-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.40-log - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп данных таблицы test_rubric.goods: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
REPLACE INTO `goods` (`ID`, `Key`, `Name`, `RubricID`) VALUES
	(1, '3253', 'Товар1', 1),
	(2, '74568', 'Товар2', 1),
	(3, '3741', 'Товар3', 2),
	(4, '5638', 'Товар4', 2),
	(5, '3547', 'Товар5', 3);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;

-- Дамп данных таблицы test_rubric.prices: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
REPLACE INTO `prices` (`ID`, `Price`, `Type`) VALUES
	(1, 500, 'Розница'),
	(2, 400, 'Розница'),
	(3, 1000, 'Розница'),
	(4, 250, 'Розница'),
	(1, 350, 'Опт'),
	(3, 900, 'Опт'),
	(5, 900, 'Розница'),
	(5, 750, 'Опт');
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;

-- Дамп данных таблицы test_rubric.properties: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `properties` DISABLE KEYS */;
REPLACE INTO `properties` (`ID`, `Feature`) VALUES
	(1, 'Свойство1'),
	(2, 'Свойство2'),
	(3, 'Свойство3'),
	(4, 'Свойство4');
/*!40000 ALTER TABLE `properties` ENABLE KEYS */;

-- Дамп данных таблицы test_rubric.rubric: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `rubric` DISABLE KEYS */;
REPLACE INTO `rubric` (`ID`, `Key`, `Name`, `Pid`) VALUES
	(1, '985', 'Рубрика 1', 0),
	(2, '997', 'Рубрика 2', 0),
	(3, '936', 'Рубрика 1.1', 1),
	(4, '944', 'Рубрика 2.1', 2),
	(5, '854', 'Рубрика 1.2', 1),
	(6, '479', 'Рубрика 1.1.1', 3);
/*!40000 ALTER TABLE `rubric` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
