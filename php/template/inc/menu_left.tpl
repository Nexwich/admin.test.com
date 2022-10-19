<?
/*!
		@file menu_left.tpl
		@brief Шаблон левого меню панели администрирования
		@details Шаблон левого меню панели администрирования
	*/
?>

<div class="main">
	<div class="aside" id="aside">
		<nav>
			<div class="logo">
				<div class="m-3">
					<a href="../" class="sidebar-brand">КИП-Сервис</a> <sup class="text-muted">v841</sup>
				</div>
				<!-- Бутерброд -->
				<div class="m-1">
					<a class="btn btn-dark btn-sm" id="buter"><i class="fa fa-bars"></i></a>
				</div>
			</div>
			<!-- Левое меню -->
			<ul class="sidebar sidebar-nav">
				<li class="sidebar-item">
					<a href="#trade" class="sidebar-link" data-toggle="collapse" aria-expanded="true"><i class="fa fa-money"></i>Товаровед</a>
					<ul id="trade" class="sidebar-dropdown list-unstyled collapse show">
						<li class="sidebar-item"><a class="sidebar-link" href="../scan">Сканирование</a></li>
						<li class="sidebar-item active"><a class="sidebar-link" href="payment_management">Управление оплатами </a></li>
						<li class="sidebar-item active"><a class="sidebar-link" href="debriefing">Разбор проплат <span class="sidebar-badge badge badge-primary">7</span></a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#related_documents" class="sidebar-link" data-toggle="collapse" aria-expanded="true"><i class="fa fa-money"></i>Связанные докумменты</a>
					<ul id="related_documents" class="sidebar-dropdown list-unstyled collapse show">
						<li class="sidebar-item"><a href="/related_documents/types" class="sidebar-link">Редактор Типов документов</a></li>
						<li class="sidebar-item"><a href="/related_documents/goods" class="sidebar-link">Привязка Товаров к Документам</a></li>
						<li class="sidebar-item"><a href="/related_documents/documents" class="sidebar-link">Привязка Документов к Товарам</a></li>
						<li class="sidebar-item"><a href="/related_documents/document_create" class="sidebar-link">Добавление нового Документа</a></li>
						<li class="sidebar-item"><a href="/related_documents/document_edit" class="sidebar-link">Редактирование Документа</a></li>
						<li class="sidebar-item"><a href="/related_documents/analytics" class="sidebar-link">Аналитика</a></li>
					</ul>
				</li>
				<li class="sidebar-item">
					<a href="#crm_analytics2" class="sidebar-link" data-toggle="collapse" aria-expanded="true"><i class="fa fa-money"></i>Аналитика</a>
					<ul id="crm_analytics2" class="sidebar-dropdown list-unstyled collapse show">
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="1">Аналитика счета</a></li>
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="2">Аналитика приходов</a></li>
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="3">Аналитика опросов</a></li>
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="4">Аналитика звонков</a></li>
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="5">Аналитика внесения предприятия</a></li>
						<li class="sidebar-item"><a href="/crm_analytics2" class="sidebar-link analythic" id="6">Аналитика линии звонков</a></li>
					</ul>
				</li>

				<li class="sidebar-item">
					<a href="#export" class="sidebar-link" data-toggle="collapse" aria-expanded="true">
						Экспорт
					</a>

					<ul id="export" class="sidebar-dropdown list-unstyled collapse show">
						<li class="sidebar-item">
							<a href="/export_shipment" class="sidebar-link" id="1">Массовая отгрузка</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<div class="user">
			<div class="user_place">
				<!-- Оповещение пользователя -->
				<div class="m-1">
					<a class="btn btn-dark" href="#" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell-o" aria-hidden="true"></i>
						<span class="badge badge-danger">4</span>
					</a>
					<div class="dropdown-menu" aria-labelledby="userDropdown">
						<div class="list-group list-group-flush">
							<a href="#" class="list-group-item list-group-item-action">
								<div class="row no-gutters align-items-center">
									<div class="col-2">
										<span class="badge badge-warning">1</span>
									</div>
									<div class="col-10 pl-2">Сканирование</div>
								</div>
							</a>
							<a href="#" class="list-group-item list-group-item-action">
								<div class="row no-gutters align-items-danger">
									<div class="col-2">
										<span class="badge badge-danger">2</span>
									</div>
									<div class="col-10 pl-2">Разбор проплат</div>
								</div>
							</a>
						</div>
					</div>
				</div>
				<!-- Меню пользователя -->
				<div class="m-1">
					<a class="btn btn-dark" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o"></i> <?= $_SESSION['user'] ?></a>
					<div class="dropdown-menu" aria-labelledby="userDropdown">
						<a class="dropdown-item" href="#"><i class="fa fa-user-o" aria-hidden="true"></i> Профиль</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i> Выйти</a>
					</div>
				</div>
			</div>
			<!-- Возможность выбора БД / убрать с продакшена -->
			<div class="mb-3">
				<a class="btn btn-secondary progress-bar-striped" href="#" id="bdDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">TradeTest2</a>
				<div class="dropdown-menu" aria-labelledby="bdDropdown">
					<a class="dropdown-item" href="#">TradeZAE</a>
					<a class="dropdown-item" href="#">F</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Основной контентный блок -->
	<div class="page_wrapper">
