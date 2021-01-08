function completeAreaAjax(result_form, url, id) {
    $.ajax({
        url: url,
        method: "GET",

        success: function (response) {
            $("."+result_form).html("");
            response = JSON.parse(response);
            if(response.error){
                response.error.forEach(function (item) {
                    $("."+ result_form).append(item);
                });
            }else if(response.message) {
                console.log(response);
                response.message.forEach(function (item) {
                    $("." + result_form).append(item);
                });
                $("#card_" + response['data']['id'] + " .card-header .area-status").text(response['data']['status_name']);
                $("#card_" + response['data']['id'] + " .card-header .area__end-date").text(response['data']['end_date']);
                $("#card_" + response['data']['id']).parent().addClass("completed-area");
                $("a.complete_area[data-id="+response['data']['id']+"]").remove();
                $("a[data-target='#card__edit-area_"+response['data']['id']+"']").remove();
            }
        },
        error: function (response) {
            alert("Error");
        }
    });
}

function editAreaAjax(result_form, ajax_form, url) {
    $.ajax({
        url: url,
        method: "POST",
        dataType: "html",
        data: $("#" + ajax_form).serialize(),
        success: function (response) {
            console.log(response);
            $("." + result_form).html("");
            response = JSON.parse(response);
            if (response.error) {
                response.error.forEach(function (item) {
                    $("." + result_form).append(item);
                });
            } else if (response.message) {
                response.message.forEach(function (item) {
                    $("." + result_form).append(item);
                });
                $("#card_" + response['data']['id'] + " h5.card-title").text(response['data']['name']);
                $("#card_" + response['data']['id'] + " p.card-text").text(response['data']['description']);
                $("#card_" + response['data']['id'] + " .card-footer small span.date").text(response['data']['start_date']);
                $("#card__edit-area_"+response['data']['id']).removeClass('show');
            }
        },
        error: function (response) {
            alert("Error");
        }
    });

}

function delAreaAjax(result_form, url, id) {
    $.ajax({
        url: url,
        method: "POST",

        success: function (response) {
            $("."+ result_form).html("");
            response = JSON.parse(response);
            if (response.error){
                response.error.forEach(function (item) {
                    $("."+ result_form).append(item);
                });
            }else if(response.message) {
                console.log(response);
                response.message.forEach(function (item) {
                    $("." + result_form).append(item);
                });
                $("#card_"+id).remove();
            }
        },
        error: function (response) {
            alert("Error");
        }
    });
}

function addAreaAjaxForm(result_form, ajax_form, url) {
    $.ajax({
        url: url,
        method: "POST",
        dataType: "html",
        data: $("#"+ ajax_form).serialize(),
        success: function (response) {
            console.log(response);
            $("."+ result_form).html("");
            response = JSON.parse(response);
            if (response.error){
                response.error.forEach(function (item) {
                    $("."+ result_form).append(item);
                });
            }else if(response.message){
                response.message.forEach(function (item) {
                    $("."+ result_form).append(item);
                });
                $(".ach-areas").append("<div class=\"card-wrapper d-flex flex-column\"><div class=\"card\" id=\"card_"+response['data']['id']+"\" style=\"width: 18rem;\">\n" +
                    "                <div class=\"card-header\">\n" +
                    "                    <small class=\"area-status\">"+response['data']['status_name']+"</small>\n" +
                    "<small class=\"area__end-date\"></small>"+
                    "                </div>\n" +
                    "                <div class=\"card-body\">\n" +
                    "                    <h5 class=\"card-title\">"+response['data']['name']+"</h5>\n" +
                    "                    <p class=\"card-text\">"+response['data']['description']+"</p>\n" +
                    "                    <a href=\"/achievement/area/"+response['data']['id']+"\" class=\"card-link\">See...</a>\n" +
                    "\n" +
                    "                    <a href=\"#\" class=\"icons-small\" data-toggle=\"collapse\" data-target=\"#card__edit-area_"+response['data']['id']+"\" aria-expanded=\"false\" aria-controls=\"card__edit-area_"+response['data']['id']+"\"><i class=\"fas fa-edit\"></i></a>\n" +
                    "\n" +
                    "                    <a href=\"#\" class=\"icons-small delete_area\" title=\"Удалить задачу\" data-id=\""+response['data']['id']+"\"><i class=\"fas fa-trash-alt\" data-id=\""+response['data']['id']+"\"></i></a>\n" +
                    "\n" +
                    "                    <a href=\"#\" class=\"icons-small complete_area\" data-id=\""+response['data']['id']+"\" title=\"Завершить задачу\"><i class=\"fa fa-flag-checkered\" data-id=\""+response['data']['id']+"\" aria-hidden=\"true\"></i></a>\n" +
                    "                </div>\n" +
                    "                <div class=\"card-footer\">\n" +
                    "                    <small>Дата начала: <span class=\"date\"> "+response['data']['start_date']+"</span></small>\n" +
                    "                </div>\n" +
                    "            </div><div class=\"collapse\" id=\"card__edit-area_"+response['data']['id']+"\">\n" +
                    "                 <div class=\"card card-body\">\n" +
                    "                     <form method=\"post\" action=\"\" id=\"edit_area_form_"+response['data']['id']+"\">\n" +
                    "                         <div class=\"form-group\">\n" +
                    "                             <input name=\"areaId\" type=\"hidden\" class=\"form-control\" value=\""+response['data']['id']+"\">\n" +
                    "                         </div>\n" +
                    "                         <div class=\"form-group\">\n" +
                    "                             <label for=\"formGroupAreaName\">Название</label>\n" +
                    "                             <input name=\"areaName\" type=\"text\" class=\"form-control\" value=\""+response['data']['name']+"\">\n" +
                    "                         </div>\n" +
                    "                         <div class=\"form-group\">\n" +
                    "                             <label for=\"formGroupAreaDescription\">Описание зоны</label>\n" +
                    "                             <textarea name=\"areaDescription\" class=\"form-control\" rows=\"5\">"+response['data']['description']+"</textarea>\n" +
                    "                         </div>\n" +
                    "                         <div class=\"form-group\">\n" +
                    "                             <label for=\"startDate\">Дата начала</label>\n" +
                    "                             <input type=\"date\" name=\"startDate\" class=\"form-control\" value=\""+response['data']['start_date']+"\">\n" +
                    "                         </div>\n" +
                    "                         <button type=\"submit\" value=\""+response['data']['id']+"\" class=\"btn btn-success mb-2 edit_area_btn\" id=\"edit_area_btn_"+response['data']['id']+"\">Изменить</button>\n" +
                    "                     </form>\n" +
                    "                 </div>\n" +
                    "             </div>");
            }

        },
        error: function (response) {
            alert("Error");
        }
    });
}