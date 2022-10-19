<?
/*!
	@file startup.php
	@brief Инициализация функционирования CMS сайта
	@details Инициализация функционирования CMS сайта (определение констант, подключение к БД, вспомогательные функции, отладка БД)
*/

include('debug.php');

if (version_compare(phpversion(), '5.1.0', '<') == true) { die('Ошибка: Версия PHP не соотвествует необходимой (слишком старая)'); }

//----------------------------------------------------
// Настройки:
// 1. ARG_STYLE - Стиль передачи аргументов

//Стили передачи аргументов
//0 - передаем аргументы в виде /controller/action?arg1=val1&arg2=val2...
//1 - передаем аргументы в виде /controller/action/val1/val2..
define('ARG_STYLE', 0);

//----------------------------------------------------
// Константы:

// 1. Разделитель дирректории
define('DIRSEP', DIRECTORY_SEPARATOR);

// 2. Путь до сайта (относительно корня)
$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
define('SITE_PATH', $site_path);

// 3. Адрес сайта
define('SITE_URL', isset($_SERVER['HTTPS']) ? 'https://' : 'http://' . $_SERVER['SERVER_NAME'].'/');

// 4. Версионирование скриптов (для автоочистки в кэше браузеров)
define('VERSION_SITE', 2134);

// 5. Путь хранилища временных файлов
define('SITE_FILES_TEMP', '/var/www/html/admin.test/tmp/');

// 6. Путь к хранилищу изображений направлений и категорий
define('SITE_IMG_CAT_PATH', '/var/www/html/totalkip.test.com/img/category/');

// 7. Путь к хранилищу изображений направлений и категорий в описаниях
define('SITE_IMG_CAT_DESC_PATH', '/var/www/html/totalkip.test.com/img/category/desc/');

// 8. Путь к хранилищу изображений контента
define('SITE_IMG_CONTENT_PATH', '/var/www/html/totalkip.test.com/img/content/');

// 9. Путь к хранилищу изображений ,баннера
define('SITE_IMG_BANNER_PATH', '/var/www/html/totalkip.test.com/img/info/');

// 10. Путь к хранилищу изображений направлений и категорий (внешняя ссылка)
define('SITE_IMG_CAT_PATH_URL', 'http://totalkip.test.com/img/category/');

// 11. Путь к хранилищу изображений направлений и категорий в описаниях (внешняя ссылка)
define('SITE_IMG_CAT_DESC_PATH_URL', 'http://totalkip.test.com/img/category/desc/');

// 12. Путь к хранилищу изображений контента (внешняя ссылка)
define('SITE_IMG_CONTENT_PATH_URL', 'http://totalkip.test.com/img/content/');

// 13. Путь к хранилищу изображений баннера (внешняя ссылка)
define('SITE_IMG_BANNER_PATH_URL', 'http://totalkip.test.com/img/info/');

// 14. Путь к сайту, подключенному к admin.test.com
define('SITE_URL_ADMIN', 'totalkip.test.com');

// 15. Путь к хранилищу документов контента
define('SITE_DOCS_CONTENT_PATH', '/var/www/html/totalkip.test.com/docs/content/');

// 16. Путь к хранилищу изображений контента (внешняя ссылка)
define('SITE_DOCS_CONTENT_PATH_URL', 'http://totalkip.test.com/docs/content/');

// 17. Путь к хранилищу изображений типов (групп товаров)
define('SITE_IMG_TYPES_PATH', '/var/www/html/totalkip.test.com/img/type/');

// 18. Путь к хранилищу изображений типов (групп товаров) (внешняя ссылка)
define('SITE_IMG_TYPES_PATH_URL', 'http://totalkip.test.com/img/type/');

// 19. Загрузка классов "на лету"
spl_autoload_register(function ($class) {
		$filename = strtolower($class) . '.php';
		$file = SITE_PATH . 'classes' . DIRSEP . $filename;
		if (file_exists($file)){
				include ($file);
				return;
		}else{
			$model = SITE_PATH . 'models' . DIRSEP . $filename;
			if (file_exists($model)){
				include ($model);
				return;
			} else {
				$exception = SITE_PATH . 'exceptions' . DIRSEP . $filename;
				if (file_exists($exception) == false)	return false;
				include ($exception);
			}
		}
});

require __DIR__ . '/../traits/procedure.php';

// 20. Выполнение событий для каждой страницы - попытка подключиться к БД
$registry = new Registry;
start();

// 21. HASH для Старикова на допуск генерации долгосрочных договоров
define('ALLOW_GEN_DOG', '05085604-92BB-4D29-B33B-845539C39585');

//----------------------------------------------------
// Функции

// Загрузка классов "на лету"
/*function __autoload($class_name)
{
	$filename = strtolower($class_name) . '.php';
	$file = SITE_PATH . 'classes' . DIRSEP . $filename;
	if (file_exists($file) == false) return false;
	include ($file);
}*/

/*
*Автоматическая проверка массив на многомерность
*/
function is_multi_array( $arr) {
	rsort( $arr );
	return isset( $arr[0] ) && is_array( $arr[0] );
}

/*!
	@brief Нормализация кодировки БД
	@details Нормализация кодировки БД
	@param array $array Массив
	@param integer $type Тип массива:
	<br>0 - одномерный
	<br>1 - двумерный массив
	@return <b>array</b> $return_array Нормализованный массив
*/
function db_rus($array, $type = 1)
{
	return $array;
}

/*!
		@brief Поиск значения в подмассивах
	@details Поиск значения в подмассивах
	@param integer|string|boolean $needle Искомое значение
	@param array $haystack Массив, в котором производится поиск
	@param string|integer $column_for_search Поле, по которому производится поиск
	@return integer|boolean $current_key Возвращает ключ, по которому можно обратиться к искомому значению, либо возвращает false, если ничего не найдено в подмассивах
*/
function recursive_array_search($needle, $haystack, $column_for_search)
{
    foreach($haystack as $key=>$value)
	{
        $current_key=$key;
        if(($needle === $value && $current_key == $column_for_search) || (is_array($value) && recursive_array_search($needle, $value, $column_for_search) !== false))
		{
            return $current_key;
        }
    }
    return false;
}

/*!
	@brief Замена тегов
	@details Замена тегов
	@param string $text Текст, в котором надо заменить теги
	@param array $tags Массив тегов, которые необходимо вырезать
	@return string $text Текст с вырезанными тегами (текст в тегах остается)
*/
function strip_selected_tags($text, $tags = array())
{
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
    foreach ($tags as $tag)
	{
        while(preg_match('/<'.$tag.'(|\W[^>]*)>(.*)<\/'. $tag .'>/iusU', $text, $found))
		{
            $text = str_replace($found[0],$found[2],$text);
        }
    }

    return preg_replace('/(<('.join('|',$tags).')(|\W.*)\/>)/iusU', '', $text);
}

/*!
	@brief Перемещение файлов из временной папки по указанному пути с проверкой форматов
	@details Перемещение файлов из временной папки по указанному пути с проверкой форматов
	@param string $name_tag Наименование элемента POST, который содержит файл (на html форме - input type="file")
	@param string $new_name_file Новое имя файла
	@param string $destination Новый путь назначения для файла
	@param array $ext Массив с допустимыми типами файлами для загрузки
	@return <b>integer</b> $status Статус выполнения перемещения:
	<br>1 - перемещение из временной папки успешно выполнено с совпадением заданного формата файла
	<br>100 - ошибка, не удалось переместить файл из временной папки php в папку admin/tmp/
	<br>101 - ошибка, не удалось переместить файл из временной папки admin/tmp/ в папку указанную в переменной "destination"
	<br>102 - ошибка, формат загружаемого файла не совпадает с форматами, которые заданны в массиве переменной "ext"
*/
function upload_file($name_tag, $new_name_file, $destination, $ext)
{
	/*
	Производится запись через промежуточную папку admin/tmp, из-за сложностей с правми записи напрямую в папку назначения
	*/
	$dest1 = SITE_FILES_TEMP.$_FILES[$name_tag]["name"];
	$move1 = move_uploaded_file($_FILES[$name_tag]["tmp_name"], $dest1);

	if($move1 == false) return 100; // Если файл не переместился из временной папки php в admin/tmp

	$FileType = strtolower(pathinfo($dest1, PATHINFO_EXTENSION)); // Получение формата файла после перемещения из временной папки php в admin/tmp

	if(in_array($FileType, $ext) == false) // Если формат загружаемого файла не совпадает с допустимыми форматами
	{
		unlink($dest1);
		return 102;
	}

	$dest2 = $destination.$new_name_file.'.'.$FileType;
	$move2 = rename($dest1, $dest2); // Перемещение файла из временной папки admin/tmp в папку по указанному пути, с заданным именем и сохранением формата

	if($move2 == false) // Если файл не переместился из папки admin/tmp в папку $destination
	{
		unlink($dest1);
		return 101;
	}
	chmod($dest2, 0777);
	return 1;
}

/*!
	@brief Создание пагинации страниц
	@details Создание пагинации страниц
	@param integer $total Всего записей
	@param integer $now_page Текущая страница
	@param integer $amount Количество записей на странице
	@param string $url Часть ссылки
	@param string $get Параметр для пагинации страниц
	@return html-разметка с пагинацией страниц
*/
function pagination($total, $now_page, $amount, $url, $get = 'lim')
{
	$total = ceil($total/$amount)-1; // всего страниц
	$now_page++;

	$rtn = '';

	// Пагинация появится если есть более 1 страницы
	if($total >= 1)
	{
		$rtn.= '<center><nav class="col-sm-12"><ul class="pagination">';
			if($total >= 7 )
			{
				if($total-$now_page > 2)
				{
					// клавиши пагинации
					$now_page--;
					if(($now_page)>0)
					$rtn.= '<li><a href="'.$url.'&'.$get.'=0"><i class="fa fa-arrow-left"></i></a></li>';

					if(($now_page)!=0)
					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($now_page-1).'">'.($now_page).'</a></li>';

					$rtn.= '<li class="active"><a href="'.$url.'&'.$get.'='.$now_page.'">'.($now_page+1).'</a></li>';

					if(($total)-($now_page)>0)
					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($now_page+1).'">'.($now_page+2).'</a></li>';

					if((($total-1)-($now_page+1))>1)
					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($now_page+2).'">'.($now_page+3).'</a></li>';

					if((($total-1)-($now_page+1))>1 && $now_page+3!=$total-1)
					$rtn.= '<li><a>&hellip;</a></li>';

					if(($total-1)-($now_page+1)>0)
					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($total-1).'">'.($total).'</a></li>';

					if(($total)-($now_page+1)>0)
					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($total).'">'.($total+1).'</a></li>';

					$rtn.= '<li><a href="'.$url.'&'.$get.'='.($total).'"><i class="fa fa-arrow-right"></i></a></li>';
				}
				else
				{
					$rtn.= '<li><a href="'.$url.'&'.$get.'=0"><i class="fa fa-arrow-left"></i></a></li>';

					for($i=$total-5;$i<=$total; $i++) $rtn.= '<li class="'.($i+1==$now_page?'active':'').'"><a href="'.$url.'&'.$get.'='.($i).'">'.($i+1).'</a></li>';

					if($now_page!=$total+1) $rtn.= '<li><a href="'.$url.'&'.$get.'='.($total).'"><i class="fa fa-arrow-right"></i></a></li>';
				}
			}
			else
			{
				if(($now_page)!=1)
				$rtn.= '<li><a href="'.$url.'&'.$get.'=0"><i class="fa fa-arrow-left"></i></a></li>';

				for($i=0;$i<=$total; $i++) $rtn.= '<li class="'.($i+1==$now_page?'active':'').'"><a href="'.$url.'&'.$get.'='.($i).'">'.($i+1).'</a></li>';

				if($now_page!=$total+1) $rtn.= '<li><a href="'.$url.'&'.$get.'='.($total).'"><i class="fa fa-arrow-right"></i></a></li>';
			}
		$rtn.= '</ul></nav></center>';
	}
	return $rtn;
}

/*!
	@brief Стартовая функция движка
	@details Стартовая функция движка (подключение к БД, генерация и валидация cookie для корзины)
*/
function start()
{
	global $registry;

	// Соединение с БД
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		// $db = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestTotalkipF", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_InternetAcquiring", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('db', $db);

	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$BaseGTD = new PDO("sqlsrv:Server=192.168.0.43;Database=Trade_RU_1C83", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$BaseGTD->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$BaseGTD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('BaseGTD', $BaseGTD);
	}
	catch(PDOException $e)
	{
		$BaseGTD = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$Library = new PDO("sqlsrv:Server=192.168.0.43;Database=Library", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$Library->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$Library->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('Library', $Library);
	}
	catch(PDOException $e)
	{
		$BaseGTD = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$db2 = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestStudents", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('db_2', $db2);
	}
	catch(PDOException $e)
	{
		$db2 = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$db3 = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestTVS", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db3->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('db_3', $db3);
	}
	catch(PDOException $e)
	{
		$db3 = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$zae = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestZAE", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$zae->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$zae->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('ZAE', $zae);
	}
	catch(PDOException $e)
	{
		$zae = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTest2 = new PDO("sqlsrv:Server=192.168.0.44;Database=TradeTest2", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTest2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTest2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTest2', $TradeTest2);
	}
	catch(PDOException $e)
	{
		$TradeTest2 = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestDebriefing = new PDO("sqlsrv:Server=192.168.0.43;Database=Trade_RU_1C83", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestDebriefing->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestDebriefing->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestDebriefing', $TradeTestDebriefing);
	}
	catch(PDOException $e)
	{
		$TradeTestDebriefing = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestRAV = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestRAVRelease", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestRAV->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestRAV->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestRAV', $TradeTestRAV);
	}
	catch(PDOException $e)
	{
		$TradeTestRAV = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestIncomes = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestIncomes", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestIncomes->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestIncomes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestIncomes', $TradeTestIncomes);
	}
	catch(PDOException $e)
	{
		$TradeTestIncomes = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestBTA = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTest_BTA", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestBTA->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestBTA->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestBTA', $TradeTestBTA);
	}
	catch(PDOException $e)
	{
		$TradeTestBTA = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestFR = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestForreplace", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestFR->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestFR->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestFR', $TradeTestFR);
	}
	catch(PDOException $e)
	{
		$TradeTestFR = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$Tradetest_KashServer = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_KashServer", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$Tradetest_KashServer->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$Tradetest_KashServer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('Tradetest_KashServer', $Tradetest_KashServer);
	}
	catch(PDOException $e)
	{
		$Tradetest_KashServer = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$db = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_InternetAcquiring", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestF', $db);
	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	//временно
	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$db = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_InternetAcquiring2", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestF2', $db);
	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$KS2 = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_KashServer2", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$KS2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$KS2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('KS2', $KS2);
	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$IA = new PDO("sqlsrv:Server=192.168.0.43;Database=Tradetest_InternetAcquiring", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$IA->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$IA->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('IA', $IA);
	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$db = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestCalcState", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('CalcState', $db);
	}
	catch(PDOException $e)
	{
		$db = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	// try
	// {
	// 	$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
	// 	$TradeTestZVY = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestZVY", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
	// 	$TradeTestZVY->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	// 	$TradeTestZVY->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// 	$registry->set('TradeTestZVY', $TradeTestZVY);
	// }
	// catch(PDOException $e)
	// {
	// 	$TradeTestZVY = false;
	// 	exit(__FUNCTION__.' Err_text: '.$e);
	// }

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestAS = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestAS", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestAS->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestAS->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestAS', $TradeTestAS);
	}
	catch(PDOException $e)
	{
		$TradeTestAS = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestAS2 = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestAS2", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestAS2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestAS2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestAS2', $TradeTestAS2);
	}
	catch(PDOException $e)
	{
		$TradeTestAS2 = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTest2_2609 = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTest2_2609", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTest2_2609->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTest2_2609->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTest2_2609', $TradeTest2_2609);
	}
	catch(PDOException $e)
	{
		$TradeTest2_2609 = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestRAVBuild = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestRAVBuild", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestRAVBuild->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestRAVBuild->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestRAVBuild', $TradeTestRAVBuild);
	}
	catch(PDOException $e)
	{
		$TradeTestRAVBuild = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeTestRAVBackup = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeTestRAVBackup", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeTestRAVBackup->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeTestRAVBackup->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeTestRAVBackup', $TradeTestRAVBackup);
	}
	catch(PDOException $e)
	{
		$TradeTestRAVBackup = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$Trade_Attributes = new PDO("sqlsrv:Server=192.168.0.43;Database=Trade_Attributes", 'gph_attr', 'b2433fd6f', $options); //Подключаемся к базе
		$Trade_Attributes->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$Trade_Attributes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('Trade_Attributes', $Trade_Attributes);
	}
	catch(PDOException $e)
	{
		$Trade_Attributes = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}

	try
	{
		$options = array(PDO::SQLSRV_ATTR_ENCODING=>PDO::SQLSRV_ENCODING_UTF8, "CharacterSet" => "UTF-8", PDO::ATTR_TIMEOUT => 5);
		$TradeLogs = new PDO("sqlsrv:Server=192.168.0.43;Database=TradeLogs", 'sa', '7vz54xmm4ev2', $options); //Подключаемся к базе
		$TradeLogs->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$TradeLogs->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$registry->set('TradeLogs', $TradeLogs);
	}
	catch(PDOException $e)
	{
		$TradeLogs = false;
		exit(__FUNCTION__.' Err_text: '.$e);
	}
}

session_save_path();
session_start();
$ip_adress = $_SERVER['REMOTE_ADDR'];
$get_role = new Get_role($registry,'db');
$auth = $get_role->get_id($ip_adress);
if (isset($auth[0]['УчетнаяЗапись']))
	$_SESSION['user']=$auth[0]['УчетнаяЗапись'];
else $_SESSION['user']='Гость'
?>
