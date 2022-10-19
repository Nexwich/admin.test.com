// Общий Ява-Скрипт
var main = {

	//Получение значение cookie
	getcookie: function(name){
		var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	},
	//Установка значения cookie
	setcookie: function(name, value, options){
		options = options || {};
		var expires = options.expires;

		if (typeof expires == "number" && expires)
		{
			var d = new Date();
			d.setTime(d.getTime() + expires * 1000);
			expires = options.expires = d;
		}

		if(expires && expires.toUTCString)
		{
			options.expires = expires.toUTCString();
		}

		value = encodeURIComponent(value);
		var updatedCookie = name + "=" + value;

		for(var propName in options)
		{
			updatedCookie += "; " + propName;
			var propValue = options[propName];
			if(propValue !== true)
			{
				updatedCookie += "=" + propValue;
			}
		}
		document.cookie = updatedCookie;
	}
}

/*jQuery.stringify = (function ($) {
  var _PRIMITIVE, _OPEN, _CLOSE;
  if (window.JSON && typeof JSON.stringify === "function")
    return JSON.stringify;

  _PRIMITIVE = /string|number|boolean|null/;

  _OPEN = {
    object: "{",
    array: "["
  };

  _CLOSE = {
    object: "}",
    array: "]"
  };

  //actions to execute in each iteration
  function action(key, value) {
    var type = $.type(value),
      prop = "";

    //key is not an array index
    if (typeof key !== "number") {
      prop = '"' + key + '":';
    }
    if (type === "string") {
      prop += '"' + value + '"';
    } else if (_PRIMITIVE.test(type)) {
      prop += value;
    } else if (type === "array" || type === "object") {
      prop += toJson(value, type);
    } else return;
    this.push(prop);
  }

  //iterates over an object or array
  function each(obj, callback, thisArg) {
    for (var key in obj) {
      if (obj instanceof Array) key = +key;
      callback.call(thisArg, key, obj[key]);
    }
  }

  //generates the json
  function toJson(obj, type) {
    var items = [];
    each(obj, action, items);
    return _OPEN[type] + items.join(",") + _CLOSE[type];
  }

  //exported function that generates the json
  return function stringify(obj) {
    if (!arguments.length) return "";
    var type = $.type(obj);
    if (_PRIMITIVE.test(type))
      return (obj === null ? type : obj.toString());
    //obj is array or object
    return toJson(obj, type);
  }
}(jQuery));*/

//Локали для интерфейса
strings = {
	'error_connect' : 'Ошибка. Возможно отсутствует сетевое соединение',
	'load_data': '<div class="wait_response"><span class="mute"><i class="fa fa-spinner fa-pulse" id="loadimg"></i></span></div>',
	'load_data_process' : '<i class="fa fa-spinner fa-pulse" id="loadimg"></i> Обработка',
	'upload_error_100' : 'Ошибка загрузки файла, попробуйте отправить форму повторно',
	'upload_error_101' : 'Ошибка загрузки файла, попробуйте отправить форму повторно',
	'upload_error_102' : 'Формат не соответствует установленному!',
	'new_family_header' : 'Создание семейства',
	'new_family_button' : 'Добавить семейство',
	'edit_family_header' : 'Редактирование семейства',
	'edit_family_button' : '<i class="fa fa-floppy-o"></i> Сохранить изменения',
	'fam_success_add' : 'Успешно добавлено новое семейство',
	'fam_success_edit' : 'Успешно отредактировано семейство',
	'fam_error_dupl_name' : 'Для данной группы товаров уже имеется семейство с таким именем',
	'fam_error_min_name' : 'Минимальная длина наименования семейства составляет 3 символа',
	'fam_group_operation_1' : 'Вы уверены, что хотите отвязать все товары от семейства?',
	'fam_group_operation_header_1' : 'Удаление привязки всех товаров',
	'fam_group_operation_2' : 'Вы уверены, что хотите отвязать все товары от семейства и <b>удалить его</b>?',
	'fam_group_operation_header_2' : 'Удаление привязки всех товаров и семейства',
	'fam_group_operation_3' : 'Введите наименования нового семейства, к которому будут привязаны выбранные товары.',
	'fam_group_operation_header_3' : 'Привязка товаров к новому семейству',
	'fam_group_operation_4' : 'Выберите из списка семейство, к которому будут привязаны выбранные товары.',
	'fam_group_operation_header_4' : 'Привязка товаров к существующему семейству',
	'fam_group_operation_5' : 'Вы уверены, что хотите удалить выбранные семейства?',
	'fam_group_operation_header_5' : 'Удаление пустых семейств',
	'fam_group_operation_6' : 'Вы уверены, что хотите отвязать выбранные товары от семейства?',
	'fam_group_operation_header_6' : 'Удаление привязки выбранных товаров',
	'fam_group_operation_7' : 'Создайте новое семейство или привяжите товары к существующему семейству.',
	'fam_group_operation_header_7' : 'Привязка выбранных товаров к другому семейству',
	'fam_group_operation_8' : 'Выберите из списка группу товаров, к которой будут привязаны товары. При этом будет удалена текущая связь выбранных товаров и семейства.',
	'fam_group_operation_header_8' : 'Перемещение выбранных товаров в группу товаров',
	'fam_group_operation_9' : 'Выберите из списка группу товаров, к которой будут привязаны товары.',
	'fam_group_operation_header_9' : 'Перемещение выбранных товаров в группу товаров',
	'fam_group_operation_10' : 'Выберите из списка группу товаров, к которой будут привязаны семейства и входящие в них товары.',
	'fam_group_operation_header_10' : 'Перемещение выбранных семейств в группу товаров',
	'fam_error_operation': 'Ошибка групповой операции',
	'fam_list_open' : '<i class="fa fa-plus-square-o"></i> Раскрыть семейства',
	'fam_list_close' : '<i class="fa fa-minus-square-o"></i> Свернуть семейства',
	'edit_discount_header' : 'Редактирование скидки',
	'discount_group_cant_be_deleted' : 'Группа скидок не может быть удалена',
};

//Создание блока с оповещением на Bootstrap
function create_alert_msg(msg_txt, type)
{
	if(type == 1) var info = 'success';
	else if(type == 0) var info = 'danger';
	else if(type == 2) var info = 'info';
	/* veu@ 14-02-2019 слишком большие алерты, надо проще
	return '<div class="alert alert-'+info+' alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'+msg_txt+'</strong></div>';*/
	return '<div class="text-'+info+'"><small>'+msg_txt+'</small></div>';
};

// Получение списка товаров, входящих в семейство
function family_list(id_family, block, sort = 1)
{
	if($(block).data(""+id_family+"") == 0 || $(block).data(""+id_family+"") === undefined)
	{
		$(block).data(""+id_family+"", 1);
		$(block).find(`[data-family='${id_family}']`).after(strings['load_data']);
		$(block).find(`[data-family-icon='${id_family}']`).removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
	}
	else
	{
		$(block).data(""+id_family+"", 0);
		$(block).find(`[data-ul='${id_family}']`).remove();
		$(block).find(`[data-family-icon='${id_family}']`).removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
		return;
	}

	$.ajax({
		type: "POST",
		url: "/family/api_get_list_items",
		data: {id_family: id_family},
		success: function(data) {
			var obj = {item: $.parseJSON(data)};
			obj.family = id_family;
			obj.item.forEach(function(item, i, arr) {
				var str = location.search;
				if(item['Код товара'] == $("#id_search").val()) item['color'] = true;
				if(item['ПривязкаКатегорияВыводСайт'] == 0 && location.pathname == "/reports/alone_goods" && str.search(/type=0/i) > -1) item['color_red'] = true;
				if(item['ПривязкаКатегорияЦена'] == 0 && location.pathname == "/reports/alone_goods" && str.search(/type=1/i) > -1) item['color_red'] = true;
			});
			if(sort == 2)
			{
				if(templates['/template/chunks/list_items_family.tpl'] == undefined) get_template( '/template/chunks/list_items_family.tpl', false);
			}
			else
			{
				if(templates['/template/chunks/list_items.tpl'] == undefined) get_template( '/template/chunks/list_items.tpl', false);
			}
			$(".wait_response").remove();

			if(sort == 2)
			{
				$(block).find(`[data-family='${id_family}']`).after(Mustache.render(templates['/template/chunks/list_items_family.tpl'], obj));
				binding_oper_items();
			}
			else $(block).find(`[data-family='${id_family}']`).after(Mustache.render(templates['/template/chunks/list_items.tpl'], obj));

			if(Object.keys(obj.item).length == 0) $(block).find(`[data-family='${id_family}']`).after('<ul data-ul='+id_family+'><li>Товары отсутствуют</li></ul>');

			if(block == "td" && sort == 1)
			{
				$("table tbody ul").sortable( {
					update: function(event, ui)
					{
						var index = $(ui.item).index() * 2;
						$("table tbody ul").sortable("disable");
						$("table tbody").sortable("disable");
						family_change_priority_products(id_family, $(ui.item).data("item"), index);
					},
					placeholder: "ui-state-highlight"
				});
			}
		},
		error:  function(xhr, str){
			console.log("Error family/api_get_list_items: " + xhr.status);
		}
	});
}

/*
	Изменение индексов сортировки для товаров входящих в семейства
	id_family - id семейства
	id - id товара, которому меняется индекс сортировки
	index - новое значение индекса сортировки
*/
function family_change_priority_products(id_family, id_item, index)
{
	$.ajax({
		type: "POST",
		url: "/family/api_change_sort_items",
		data: {id_family: id_family, id_item: id_item, index: index},
		success: function(data) {
			$("table tbody ul").sortable("enable");
			$("table tbody").sortable("enable");
		},
		error:  function(xhr, str){
			console.log("Error family/api_change_sort_items: " + xhr.status);
		}
	});
}

/*
	Изменение индексов сортировки для семейств привязанных к типу
	id_family - id семейства в таблице Семейства_наименование
	index - новое значение индекса сортировки
*/
function change_priority_fam_type(id_family, index)
{
	$.ajax({
		type: "POST",
		url: "/family/api_change_sort_fam",
		data: {id_family: id_family, index: index},
		success: function(data) {
			$(".sort_families").sortable("enable");
		},
		error:  function(xhr, str){
			console.log("Error family/api_change_sort_fam: " + xhr.status);
		}
	});
}

// Сохранение формы с новым или отредактированным семейством
function save_family_form(reload = true)
{
	$(".save-family").html(strings['load_data_process']);
	$(".save-family").attr('disabled','disabled');
	var msg = $("#form_family").serialize();
	$.ajax({
		type: "POST",
		url: "/family/api_save_family_form",
		async: false,
		data: msg,
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				$("#results_save_family").html(create_alert_msg(strings[obj.text], 1));
				if(reload == true) setTimeout('location.replace("/family?type='+$("#id_type").val()+'")', 1000);
				else $("#parameter2").val(obj.id_family);
			}
			else
			{
				if(reload == true) $("#results_save_family").html(create_alert_msg(strings[obj.text], 0));
				else $("#results_group_oper_family").html(create_alert_msg(strings[obj.text], 0));
			}
		},
		error:  function(xhr, str){
			$("#results_save_family").html(create_alert_msg(strings['error_connect'], 0));
			console.log("Error family/api_save_family_form: " + xhr.status);
		}
	});
}

/* Групповые операции для семейств
	action - код групповой операции
	parameter1 - список семейств или товаров через запятую
	parameter2 - код семейства для групповой операции с кодом 4, код группы товаров для групповой операции с кодом 5
*/
function family_group_operation(action, parameter1, parameter2 = 0)
{
	$.ajax({
		type: "POST",
		url: "/family/api_family_group_operation",
		data: {action: action, parameter1: parameter1, parameter2: parameter2},
		success: function(data) {
			if(data == 1)
			{
				setTimeout('location.replace("/family?type='+$("#id_type").val()+'")', 1000);
			}
			else
			{
				$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
			}
		},
		error:  function(xhr, str){
			console.log("Error family/api_family_group_operation: " + xhr.status);
		}
	});
}

/*
	Сбор в список выделенных галочкой семейств/товаров
	block - html-блок в котором производим поиск проставленных галочек
	find_block - блок поиска в html-разметке
	data_block - тип
*/
function family_select_checkbox(block, find_block, data_block)
{
	var str = '';
	var i = 0;
	var parameters = [];
	$(block).find(find_block).each(function () {
		parameters[i] = $(this).data(data_block);
		i++;
	});
	str = parameters.join(',');

	return str;
}

// Биндинг для выпадающих списков при раскрытии не пустых семейств на странице "Семейства"
function binding_oper_items()
{
	$(".group-oper-items").off();
	$(".group-oper-items").on("change", function() {
		if($(this).val() > 0)
		{
			var find_block, data_block, action, var_group;
			var_group = parseInt($(this).val());
			var family = $(this).data('family-goods');
			switch(var_group)
			{
				case 6: // Если выбран пункт отвязки выбранных товаров от семейства
					find_block = '[data-checkbox-all="4"][data-family-goods="'+family+'"]:checked';
					data_block = 'item';
					action = 3;
				break;
				case 7: // Если выбран пункт отвязки выбранных товаров от семейства и привязки их к новому или существующему
					find_block = '[data-checkbox-all="4"][data-family-goods="'+family+'"]:checked';
					data_block = 'item';
					action = 4;
				break;
				case 8: // Если выбран пункт смены группы товаров для выбранных товаров
					find_block = '[data-checkbox-all="4"][data-family-goods="'+family+'"]:checked';
					data_block = 'item';
					action = 6;
				break;
			}
			var parameters = family_select_checkbox('.main', find_block, data_block);
			if(parameters != '') // Если есть выделенные чекбоксы, то запускаем групповую обработку
			{
				get_template('/template/chunks/check_family_operation.tpl', false);
				var obj = {};
				obj.parameter1 = parameters;
				obj.parameter2 = 0;
				obj.action = action;
				var name_header = 'fam_group_operation_header_'+$(this).val();
				var name_body = 'fam_group_operation_'+$(this).val();
				obj.text_header = strings[name_header];
				obj.text = strings[name_body];
				if(var_group == 7)
				{
					obj.new_family = true;
					obj.exist_family = true;
					obj.id_type = $("#id_type").val();
					obj.hide_new_family = true;
					obj.select_attach = true;
					$.ajax({
						type: 'POST',
						url: '/family/api_get_list_families',
						async: false,
						data: {"id_type": obj.id_type},
						dataType: 'json',
						success: function(data) {
							obj.list_families = data; // Получение списка семейств для указанного типа
						},
						error:  function(xhr, str){
							$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
							console.log("Error family/api_get_list_families: " + xhr.status);
						}
					});
				}
				else if(var_group == 8)
				{
					obj.change_type = true; // Рендерим из шаблона блок с выбором из списка для смены группы товаров
					$.ajax({
						type: 'POST',
						url: '/family/api_get_list_types',
						async: false,
						dataType: 'json',
						success: function(data) {
							obj.list_types = data; // Получение списка групп товаров
						},
						error:  function(xhr, str){
							$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
							console.log("Error family/api_get_list_types: " + xhr.status);
						}
					});
				}
				$("#family_main_modal").html(Mustache.render(templates['/template/chunks/check_family_operation.tpl'], obj));
				$("#list_families").on("change", function() {
					$("#parameter2").val($("#list_families").val());
				});
				if(var_group == 7) // Если выбран вариант привязки выбранных товаров к новому или существующему семейству проверим какой radiobutton выбран
				{
					$("#parameter2").val($("#list_families").val());
					$("[name=select_var_attach]").on("click", function() { // Биндинг для radiobutton с показом/скрытием блоков создания и выбора семейств
						if($("#select_var_attach:checked").val() == "1")
						{
							$("#form_family").addClass("hide");
							$("#exist_family").removeClass("hide");
							$("#parameter2").val($("#list_families").val());
						}
						else
						{
							$("#form_family").removeClass("hide");
							$("#exist_family").addClass("hide");
							$("#parameter2").val(0);
						}
					});
				}
				if(var_group == 8)
				{
					$("#parameter2").val($("#list_types").val());
					$("#list_types").on("change", function() {
						$("#parameter2").val($("#list_types").val());
					})
				}
				$("#family_main_modal").modal("show");
				// Биндинг для кнопки "Подтвердить"
				$(".confirm-family-operation").button().on("click", function() {
					$(".confirm-family-operation").html(strings['load_data_process']);
					$(".confirm-family-operation").attr('disabled','disabled');
					var action = parseInt($("#action").val());
					if(action == 4)
					{
						if($("#select_var_attach:checked").val() != undefined)
						{
							if($("#select_var_attach:checked").val() == "2") save_family_form(false);
						}
					}
					var parameter2 = $("#parameter2").val();
					var parameter1 = $("#parameter1").val();
					if(var_group == 8)
					{
						if($("#results_group_oper_family").html() == "") type_group_operation(action, parameter1, parameter2); // Если нет сообщения об ошибке, то выполняется групповая операция по смене группы товаров
						return;
					}
					if($("#results_group_oper_family").html() == "") family_group_operation(action, parameter1, parameter2); // Если нет сообщения об ошибке выполняем групповую операцию
				});
			}
		}
	});
}

/* Групповые операции для семейств и товаров по смене группы товаров
	action - код групповой операции
	parameter1 - список семейств или товаров через запятую
	parameter2 - код группы товаров
*/
function type_group_operation(action, parameter1, parameter2 = 0)
{
	$.ajax({
		type: "POST",
		url: "/family/api_type_change_operation",
		data: {action: action, parameter1: parameter1, parameter2: parameter2},
		success: function(data) {
			if(data == 1)
			{
				setTimeout('location.reload()', 1000);
			}
			else
			{
				$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
			}
		},
		error:  function(xhr, str){
			console.log("Error family/api_type_change_operation: " + xhr.status);
		}
	});
}

$(function () {
	// Биндинг элемента для скрывающегося меню слева. Часть 1
	$('#buter').bind('click', function() {
		$('#aside').addClass('toggled');
		$('#brod').removeClass('hide');
	});
	// Биндинг элемента для скрывающегося меню слева. Часть 2
	$('#brod').bind('click', function() {
		$('#aside').removeClass('toggled');
		$('#brod').addClass('hide');
	});
	// Инициализация всплывающих подсказок
	$('[data-toggle="tooltip"]').tooltip();
});

// Аякс загрузка контента
$('body').on('click', '.js-ajax', (event) => {
  let $this = $(event.currentTarget);
	let data = $this.data('ajax');

  $.ajax({
    url: data.url,
    success: (response) => {
			let $response = $(response);
			let html = $response.find(data.selector);

      $(data.insertSelector).html(html);
    },
  });
});

$('.js-data-table').each((index, table) => {
	let $table = $(table);
	let data = $table.data('table');

	$table.DataTable(data);
})
