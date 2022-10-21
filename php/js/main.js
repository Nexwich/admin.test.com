jQuery.stringify = (function ($) {
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
}(jQuery));

//Локали для интерфейса
strings = {
	'error_connect' : 'Ошибка. Возможно отсутствует сетевое соединение',
	'load_data': '<div class="wait_response"><span class="mute"><i class="fa fa-spinner fa-pulse" id="loadimg"></i></span></div>',
	'load_data_process' : '<i class="fa fa-spinner fa-pulse" id="loadimg"></i> Обработка',
	'cat_success_edit' : 'Успешно отредактирована категория/направление',
	'cat_success_add' : 'Успешно добавлена новая категория/направление',
	'cat_success_attach_product' : 'Привязка товара к категории успешно выполнена',
	'cat_success_attach_family' : 'Привязка семейства к категории успешно выполнена',
	'cat_success_attach_group' : 'Групповая привязка успешно выполнена',
	'cat_success_dup_select_main_cat' : 'Для данного или семейства эта категория уже является главной',
	'cat_success_select_main_cat_fam' : 'Для данного семейства категория успешно выбрана как главная',
	'cat_success_select_main_cat_prod' : 'Для данного товара категория успешно выбрана как главная',
	'cat_process_attach' : 'Выполняется привязка семейс/товаров к категории...',
	'cat_error_attach' : 'Ошибка привязки. Обновите страницу и попробуйте снова',
	'dupl_url_cat' : 'Такой URL уже имеется в данном направлении или списке направлений. Введите другое URL для SEO',
	'upload_error_100' : 'Ошибка загрузки файла, попробуйте отправить форму повторно',
	'upload_error_101' : 'Ошибка загрузки файла, попробуйте отправить форму повторно',
	'upload_error_102' : 'Формат не соответствует установленному!',
	'new_family_header' : 'Создание семейства',
	'new_family_button' : 'Добавить семейство',
	'edit_family_header' : 'Редактирование семейства',
	'edit_family_button' : 'Сохранить изменения',
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
	'fam_error_operation': 'Ошибка групповой операции',
	'fam_list_open' : '<i class="fa fa-plus-square-o" aria-hidden="true"></i> Раскрыть семейства',
	'fam_list_close' : '<i class="fa fa-minus-square-o" aria-hidden="true"></i> Свернуть семейства'
};

//Создание блока с оповещением на Bootstrap
function create_alert_msg(msg_txt, type)
{
	if(type == 1) var info = 'success';
	else if(type == 0) var info = 'danger';
	else if(type == 2) var info = 'info';
	return '<div class="text-'+info+'"><small>'+msg_txt+'</small></div>';
};

// Сохранение формы с основными настройками категории/направления
function save_main_form()
{
	var data = new FormData();
	data.append('name_cat', $("#name_cat").val());
	data.append('image', $("#image")[0].files[0]);
	data.append('image2', $("#image2")[0].files[0]);
	data.append('image_url', $("#image_url").val());
	data.append('image_url_desc', $("#image_url_desc").val());
	data.append('id_root', $("#id_root").val());
	data.append('sort', $("#sort").val());
	data.append('on_off_cat', $("#on_off_cat").is(":checked"));
	data.append('id_category', $("#id_category").val());
	data.append('opisanie', $("#opisanie").val());
	data.append('color', $("#color").val());
	$('#form_category_main').find(':submit').attr('disabled','disabled');
	$("#results").html('');
	$.ajax({
		url: '/structure/api_save_main_form',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				if(obj.text == 'cat_success_edit')
				{
					$("#results").html(create_alert_msg(strings[obj.text], 1));
					setTimeout('location.reload()', 1000);
				}
				else if(obj.text == 'cat_success_add')
				{
					$("#results").html(create_alert_msg(strings[obj.text], 1));
					setTimeout('location.replace("/structure/view?id='+obj.id+'")', 1000);
				}
			}
			else
			{
				var name = 'upload_error_'+obj.status;
				$("#results").html(create_alert_msg(strings[name], 0));
			}
		},
		error:  function(xhr, str){
			$("#results").html(create_alert_msg(strings['error_connect'], 0));
			console.log("Error structure/api_save_main_form: " + xhr.status);
		},
		complete:  function (){
			$('#form_category_main').find(':submit').removeAttr('disabled');
		}
	});
};

// Сохранение формы с SEO настройками категории/направления
function save_seo_form()
{
	var msg = $("#form_category_seo").serialize();
	$('#form_category_seo').find(':submit').attr('disabled','disabled');
	$("#results2").html('');
	$.ajax({
		type: "POST",
		url: "/structure/api_save_seo_form",
		data: msg,
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				$("#results2").html(create_alert_msg(strings[obj.text], 1));
				setTimeout('location.reload()', 1000);
			}
			else
			{
				$("#results2").html(create_alert_msg(strings[obj.text], 0));
			}
		},
		error:  function(xhr, str){
			$("#results2").html(create_alert_msg(strings['error_connect'], 0));
			console.log("Error structure/api_save_seo_form: " + xhr.status);
		},
		complete:  function (){
			$('#form_category_seo').find(':submit').removeAttr('disabled');
		}
	});
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
		url: "/db_family/api_get_list_items",
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
			console.log("Error db_family/api_get_list_items: " + xhr.status);
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
		url: "/db_family/api_change_sort_items",
		data: {id_family: id_family, id_item: id_item, index: index},
		success: function(data) {
			$("table tbody ul").sortable("enable");
			$("table tbody").sortable("enable");
		},
		error:  function(xhr, str){
			console.log("Error db_family/api_change_sort_items: " + xhr.status);
		}
	});
}

/*
	Изменение индексов сортировки для товаров и семейств привязанных к категории/направлению
	id_record - id записи в таблице Интернет_категории_семейства_товары с семейством или товаром
	index - новое значение индекса сортировки
*/
function change_priority_fam_prod(id_record, index)
{
	$.ajax({
		type: "POST",
		url: "/structure/api_change_sort_fam_items",
		data: {id_record: id_record, index: index},
		success: function(data) {
			$("table tbody ul").sortable("enable");
			$("table tbody").sortable("enable");
		},
		error:  function(xhr, str){
			console.log("Error structure/api_change_sort_fam_items: " + xhr.status);
		}
	});
}

// Удаление связи категории/направления с семействами и товарами
function structure_del_relation(id_record)
{
	$.ajax({
		type: "POST",
		url: "/structure/api_delete_relation",
		data: {id_record: id_record},
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				$("table tbody tr").find(`[data-element='${id_record}']`).off("click", ".del-relation");
				$("table tbody").find(`[data-element='${id_record}']`).remove();
			}
			if(obj.status == -1)
			{
				var id_product = obj.id_product;
				var name_product = obj.name_product;
				var name_family = obj.name_family;
				structure_select_main_category(id_product, name_product, name_family, 1);
			}
		},
		error:  function(xhr, str){
			console.log("Error structure/api_delete_relation: " + xhr.status);
		}
	});
}

// Выборка возможностей присоединения товара или семейства к категории
function structure_select_attach(id_product, id_category)
{
	$.ajax({
		type: "POST",
		url: "/structure/api_select_attach",
		data: {id_product: id_product, id_category: id_category},
		success: function(data) {
			var obj = $.parseJSON(data);
			if(parseInt(obj.id_family) > 0) obj.family_exist = true;
			get_template( '/template/chunks/structure_product_attach.tpl', false);
			$("#structure_good_add_modal").html(Mustache.render(templates['/template/chunks/structure_product_attach.tpl'], obj));
			$(".family-list-attach").button().on("click", function() {
				var self = $(this);
				if(typeof self.data('family') != 'undefined')
				{
					var key = self.data('family');
					family_list(key, '#family_list');
				}
			});
			var name_family = obj.name_family;
			var name_product = obj.name_product;
			$(".attach-fam-product").button().on("click", function() {
				$(".attach-fam-product").attr('disabled','disabled');
				var var_attach = $("#select_var_attach:checked").val();
				var id_family = $("#attach_id_family").val();
				var id_product = $("#attach_id_product").val();
				structure_change_attach(var_attach, id_product, id_family, name_product, name_family);
			});
		},
		error:  function(xhr, str){
			console.log("Error structure/api_select_attach: " + xhr.status);
		}
	});
}

// Изменение привязки товаров и семейств к категории
function structure_change_attach(var_attach, id_product, id_family, name_product, name_family, type = 0)
{
	var id_category = $("#id_category").val();
	$.ajax({
		type: "POST",
		url: "/structure/api_change_attach",
		async: false,
		data: {
				var_attach: var_attach,
				id_product: id_product,
				id_family: id_family,
				id_category: id_category
			},
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				if(obj.main_category == 1)
				{
					if(type == 0)
					{
						$("#results_attach").html(create_alert_msg(strings[obj.text], 1));
						setTimeout('location.reload()', 1000);
					}
					else $("div").data("status_func", 1);
				}
				else
				{
					if(type == 0) structure_select_main_category(id_product, name_product, name_family, 0);
					else $("div").data("status_func", -1);
				}
			}
			else
			{
				if(type == 0) $("#results_attach").html(create_alert_msg(strings[obj.text], 0));
				else $("div").data("status_func", 0);
			}
		},
		error:  function(xhr, str){
			console.log("Error structure/api_change_attach: " + xhr.status);
		}
	});
}

/* Выборка текущей главной категории для товара с учётом главной категории семейства
	type = 0 - выборка главной категории после привязки
	type = 1 - выборка главной категории при удалении связи
*/
function structure_select_main_category(id_product, name_product, name_family, type)
{
	$.ajax({
		type: "POST",
		url: "/structure/api_select_main_category",
		data: {id_product: id_product},
		success: function(data) {
			var obj = $.parseJSON(data);
			obj.name_product = name_product;
			obj.name_family = name_family;
			obj.select.forEach(function(select, i, arr) {
				if(select['главная_категория'] == 1 && type == 0)
				{
					select['selected'] = true;
				}
				if(select['главная_категория'] == 1 && type == 1)
				{
					select['disabled'] = true;
				}
			});
			get_template( '/template/chunks/structure_main_category.tpl', false);
			$("#structure_good_main_modal").html(Mustache.render(templates['/template/chunks/structure_main_category.tpl'], obj));
			$(".save-main-cat").button().on("click", function() {
				var id_category = $("#good_main").val();
				structure_save_main_category(id_product, id_category);
			});
			$("#structure_good_add_modal").modal("hide");
			$("body").data("reload", 1);
			$("#structure_good_main_modal").modal("show");
		},
		error:  function(xhr, str){
			console.log("Error structure/api_select_main_category: " + xhr.status);
		}
	});
}

// Сохранение выбора главной категории для товара (семейства, куда входит товар)
function structure_save_main_category(id_product, id_category)
{
	$.ajax({
		type: "POST",
		url: "/structure/api_save_main_category",
		data: {id_product: id_product, id_category: id_category},
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				$("#results_attach2").html(create_alert_msg(strings[obj.text], 1));
				setTimeout('location.reload()', 1000);
			}
		},
		error:  function(xhr, str){
			console.log("Error structure/api_save_main_category: " + xhr.status);
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
		url: "/db_family/api_change_sort_fam",
		data: {id_family: id_family, index: index},
		success: function(data) {
			$(".sort_families").sortable("enable");
		},
		error:  function(xhr, str){
			console.log("Error db_family/api_change_sort_fam: " + xhr.status);
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
		url: "/db_family/api_save_family_form",
		async: false,
		data: msg,
		success: function(data) {
			var obj = $.parseJSON(data);
			if(obj.status == 1)
			{
				$("#results_save_family").html(create_alert_msg(strings[obj.text], 1));
				if(reload == true) setTimeout('location.replace("/db_family?type='+$("#id_type").val()+'")', 1000);
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
			console.log("Error db_family/api_save_family_form: " + xhr.status);
		}
	});
}

/* Групповые операции для семейств
	action - код групповой операции
	parameter1 - список семейств или товаров через запятую
	parameter2 - код семейства для групповой операции с кодом 4
*/
function family_group_operation(action, parameter1, parameter2 = 0)
{
	$.ajax({
		type: "POST",
		url: "/db_family/api_family_group_operation",
		data: {action: action, parameter1: parameter1, parameter2: parameter2},
		success: function(data) {
			if(data == 1)
			{
				setTimeout('location.replace("/db_family?type='+$("#id_type").val()+'")', 1000);
			}
			else
			{
				$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
			}
		},
		error:  function(xhr, str){
			console.log("Error db_family/api_family_group_operation: " + xhr.status);
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
						url: '/db_family/api_get_list_families',
						async: false,
						data: {"id_type": obj.id_type},
						dataType: 'json',
						success: function(data) {
							obj.list_families = data; // Получение списка семейств для указанного типа
						},
						error:  function(xhr, str){
							$("#results_group_oper_family").html(create_alert_msg(strings['fam_error_operation'], 0));
							console.log("Error db_family/api_get_list_families: " + xhr.status);
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
				$("#family_main_modal").modal("show");
				$(".confirm-family-operation").button().on("click", function() { // Биндинг для кнопки "Подтвердить"
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
					if($("#results_group_oper_family").html() == "") family_group_operation(action, parameter1, parameter2); // Если нет сообщения об ошибке выполняем групповую операцию
				});
			}
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
