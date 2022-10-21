<?
	/*!
		@file menu_left.tpl
		@brief Шаблон левого меню панели администрирования
		@details Шаблон левого меню панели администрирования
	*/

?>

<style>
#aside {height:100vh}
#aside nav {height:94vh}
#aside .user {height:6vh}
#aside nav .logo {height:5vh}
#aside nav ul.sidebar.sidebar-nav {
	max-height:88vh;
	overflow-y: auto;
	scrollbar-color: #1B2631 #2e3e4e;
	scrollbar-width: thin;
}
#aside nav ul.sidebar.sidebar-nav::-webkit-scrollbar {
	width: 8px;
}
#aside nav ul.sidebar.sidebar-nav::-webkit-scrollbar-thumb {
	background-color: #1B2631;
}
#aside nav ul.sidebar.sidebar-nav::-webkit-scrollbar-track {
	background-color: #2e3e4e;
}

</style>
<div class="main">
	<div class="aside" id="aside">
		<nav>
			<div class="logo">
				<div class="m-3">
					<a href="/" class="sidebar-brand nowrap">КИП-Сервис<sup><small class="text-muted">&nbsp;v<?=VERSION_SITE?></small></sup></a>
				</div>
				<!-- Бутерброд -->
				<div class="m-1">
					<a class="btn btn-dark btn-sm" id="buter"><i class="fa fa-bars"></i></a>
				</div>
			</div>
			<!-- Левое меню -->
			<ul class="sidebar sidebar-nav">
				<li class="sidebar-item">
					<a href="#structure" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-sitemap fa-fw"></i>Структура</a>
					<ul id="structure" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/structure">Направления, Категории</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/family">Семейства</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/type">Группы товаров</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/brand">Бренды</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/equipments">Комплектации</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#content" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-desktop fa-fw"></i>Контент</a>
					<ul id="content" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/content">Управление контентом</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/banner">Баннеры</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#related_documents" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-link fa-fw"></i>Связанные документы</a>
					<ul id="related_documents" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/related_documents/types">Типы документов</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/related_documents/create_document">Создать новый документ</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/related_documents/documents">Привязка документов к товарам</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/related_documents/goods">Привязка товаров к документам</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#contragents" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-university fa-fw"></i>Контрагенты</a>
					<ul id="contragents" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/requisites">Заявки на изменение реквизитов</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/contracts">Договоры</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/producers">Производители</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/providers">Поставщики</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/compare_pp">Привязка поставщиков, производителей и брендов</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/edoservice">ЭДО</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#trade" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-money fa-fw"></i>Товаровед</a>
					<ul id="trade" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/debriefing">Разбор проплат</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/payment_management">Управление оплатами</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/costs">Управление расходами</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/transport">Транспортные компании</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/customs_declaration">Учёт ГТД/РНПТ</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#order" class="sidebar-link collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-exclamation fa-fw"></i>Порядок</a>
					<ul id="order" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item"><a class="sidebar-link" href="/reports/alone_goods">Товары без категорий</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/reports_db/items">Целостность товаров БД</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/filechecker">Обходчик файлов</a></li>
						<li class="sidebar-item"><a class="sidebar-link" href="/scanserver">Сканирование</a></li>
						<!--<li class="sidebar-item"><a class="sidebar-link" href="/scanserver_b2bit">Сканирование - B2BIT</a></li>-->
						<li class="sidebar-item"><a class="sidebar-link" href="/kassserver?userKey=418E36FC80CB9A1580BC9912F074EA09">Кассовый сервер</a></li>
					</ul>
				</li>

				<li class="sidebar-item">
					<a href="#storage_export" class="sidebar-link" data-toggle="collapse" aria-expanded="true">
						<i class="fa fa-archive"></i>
						Склад
					</a>

					<ul id="storage_export" class="sidebar-dropdown list-unstyled collapse">
						<li class="sidebar-item">
							<a href="/export_shipment" class="sidebar-link">Массовая отгрузка</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<div class="user">
			<div class="mx-3"><small><i class="fa fa-user-o fa-fw"></i> <?=$_SESSION['user']?> </small></div>
			<div class="mx-3 mb-2"><small><i class="fa fa-desktop fa-fw"></i> <?=$_SESSION['ip_adress']?></small></div>
		</div>
	</div>
	<!-- Основной контентный блок -->
	<div class="page_wrapper" style="overflow: unset; margin: 0rem">
