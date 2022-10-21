<?
/*!
	@file /models/storage.php
	@brief Модель складов
	@details Модель складов
*/

/*!
	@author Худякова Наталья
	@date 25.11.2021
	@version 1.00
	@brief Модель складов
	@details Модель складов
*/
Class Storage Extends Model
{
	/*!
		@brief Правила обработки полей модели складов
		@details Правила обработки полей модели складов
	*/
	public function rules()
	{
		return [
			[['nameStorage','addressStorage','telStorage','emailStorage','modeStorage','modeStorageM','modeStorageW','payStorage','coordStorage'], 'str'],
			[['ID'], 'int'],
			[['pickupStorage'], 'bit']
		];
	}


	/*!
		@brief Получение списка складов
		@details Получение списка складов
		@return <b>array</b> $table Массив со списком складов
	*/
	public function storage_list()
	{
        $query='SELECT * FROM Филиалы_список_расширенный(1) ORDER BY Сортировка desc,НаименованиеСклада';
        $req = $this->db->prepare('SELECT * FROM Филиалы_список_расширенный(1) ORDER BY Сортировка desc,НаименованиеСклада');
		$req->execute([$query]);
		$ret = $req->fetchAll(PDO::FETCH_NAMED);

		return $ret;
	}

	/**
	 * Получение кода склада по коду оператора
	 * @param int $operator_id КодОператора
	 * @return int
	 */
	public function get_id_by_operator_id(int $operator_id): int {
		$error = $this->exec_proc(
			'ОператорСклад_Получить',
			['UserID' => $operator_id],
			PDO::FETCH_ASSOC,
			false
		);

		if ($error['КодОшибки']) {
			var_dump($error);
			return 0;
		}

		$this->query->nextRowset();
		$items = $this->query->fetchAll(PDO::FETCH_ASSOC);
		return $items[0]['КодСклада'];
	}

	use traits\procedure;
}
