<?php


class View
{
    function generate($content_view, $template_view, $data = null, $UID = null){

        /*
		if(is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		}
		*/

        include 'View/'.$template_view;
    }
}