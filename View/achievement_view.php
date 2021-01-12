
<div class ="col-sm-12">
    <div class="d-flex justify-content-between">
        <div class="ach__main-area_wrapper">
            <div class="ach__main-area_info">
                <h2><?=$data['info']['name'];?></h2>
                <small class="ach-description"><?=$data['info']["description"]?></small>
                <p>Status: <?=$data['info']["status_name"]?></p>
            </div>

            <div class="ach__main-area_charts">
                <?php foreach ($data['actions'] as $action): ?>
                <div id="chart_div<?=$action['id']?>"></div>
                <?php endforeach;?>
            </div>
        </div>

        <div class="ach__actions-list">
            <h3>Действия цели</h3>
            <?php if(!empty($data['actions'])):?>
            <ul>
            <?php foreach ($data['actions'] as $action):?>

                <li class="d-flex justify-content-between ach__actions-list_item">
                    <p>
                    <?=$action['name']?>
                    <small> (<?=$action['measure'];?>)</small>
                    </p>
                    <div class="d-flex align-items-center">
                        <a class="ach__actions-list_edit" data-toggle="collapse" data-target="#collapseEditAction<?=$action['id']?>" aria-expanded="false" aria-controls="collapseEditAction<?=$action['id']?>">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form id="delete_action_form<?=$action['id']?>" action="/achievement/delete_action/<?=$action['id']?>" method="post">
                            <a href="#"
                               class="ach__actions-list_del"><i class="fas fa-times-circle"></i></a>
                        </form>
                    </div>
                </li>

                <!-- Hidden edit block -->
                <form action="/achievement/edit_action/<?=$action['id']?>" method="post" class="form-inline ach__actions_edit-form collapse" id="collapseEditAction<?=$action['id']?>">

                    <div class="form-group mx-sm-2 mb-2">
                        <input type="text" class="form-control" name="actionEditName" placeholder="<?=$action['name'];?>" value="<?=$action['name'];?>">
                    </div>
                    <div class="form-group mx-sm-2 mb-2">
                        <select class="custom-select" name="actionEditMeasure"  required>
                            <option value="" disabled>Выберите</option>
                            <?php foreach ($data['measures'] as $measure):?>
                                <option value="<?=$measure['id']?>"
                                    <?php
                                        if($measure['id'] == $action['mesure_id']){
                                            echo 'selected';
                                        }
                                    ?>
                                >
                                    <?=$measure['measure']?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-info mb-2">Изменить</button>
                </form>
                <!-- Hidden edit block end -->

            <?php endforeach;?>
            </ul>
            <?php endif;?>

            <div id="new-action_wrapper" class="d-flex flex-column align-items-center">
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Добавить действие
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <form method="post" action="/achievement/add_action/<?=$data['info']['id']?>" id="create_action_form">
                            <div class="form-group">
                                <label for="formGroupActionName">Название</label>
                                <input required name="actionName" type="text" class="form-control" id="formGroupAreaName" placeholder="Название действия">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Ед. измерения</label>
                                </div>
                                <select class="custom-select" name="actionMeasure" id="inputGroupSelect01" required>
                                    <option value="" selected disabled>Выберите</option>
                                    <?php foreach ($data['measures'] as $measure):?>
                                        <option value="<?=$measure['id']?>">
                                            <?=$measure['measure']?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success mb-2" id="create_action_btn">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$chart_data = $data['charts'];
var_dump($data['charts']);

for($i = 0; $i < count($data['actions']); $i++){
    if($data['actions'][$i]['id'] == 40){
        echo '40';
        break;
    }
}

$result = array();
$result1 = array();
foreach ($chart_data as $key =>$chart){

    $result[$chart['action_id']][] = $chart;
}


foreach ($result as $key=>$value){
    foreach ($value as $el){
        $result1[$key][0][] = [$el['date'], (int)$el['quantity']];
    }
    for($i = 0; $i < count($data['actions']); $i++){
        if($data['actions'][$i]['id'] == $key){
            //echo $key;
            $result1[$key][] = $data['actions'][$i]['name'];
            $result1[$key][] = $data['actions'][$i]['measure'];
            break;
        }
    }

}

echo '<pre>';
var_dump($result1);
echo '</pre>';
?>
<script>
    $(document).ready(function () {

        // Submit form by click by a-element - delete link

        $(".ach__actions-list_del").on('click',
            async (e) =>{
                e.preventDefault();
                let parentForm = e.target.parentNode.parentNode.id;
                if(await confirm('Вы уверены, что хотите удалить действие?<br> <strong>Внимание!</strong><br> Все графики и история, свзанные с данным действием удалятся безвозвратно!')){
                    $('#'+parentForm).submit();
                }
            }
            );

// Charts
        let chartData = <?=json_encode($result1)?>;

        let allChartsData = [];
        let allChartsId = [];
        for(let key in chartData){
            allChartsData[key] = [];
            allChartsId.push(key);
            let chartDataModified = chartData[key][0].map(function (el) {
                let elDate = moment(el[0]).subtract('days', 1);
                elDate = new Date(elDate);
                console.log(elDate);
                //ВОТ ЗДЕСЬ ЧТО-ТО ИДЕТ НЕ ТАК
                return [elDate, el[1]];
            });
            console.log(chartDataModified);

            allChartsData[key].push(chartDataModified);
            allChartsData[key].push(chartData[key][1]);
            allChartsData[key].push(chartData[key][2]);

        }

        allChartsData = allChartsData.filter(function(e){return e});

        allChartsData.forEach((item)=>{
            let cur = item[0][0][0];
            for(let count = 0; count < item[0].length; count++){

                if(cur < item[0][count][0]){
                    console.log('----');
                    console.log(moment(item[0][count][0]).diff(moment(cur), 'days'));

                    let daysCount = moment(item[0][count][0]).diff(moment(cur), 'days');

                    item[0].splice(count,0,[new Date(cur), 0]);

                }
                cur = item[0][count][0];
                cur = cur.setDate(cur.getDate() + 1);
            }

        });


        google.charts.load('current', {packages: ['corechart', 'line']});
        google.charts.setOnLoadCallback(drawBackgroundColor);




        function drawBackgroundColor() {
            for(let count = 0; count < allChartsData.length; count++) {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', allChartsData[count][1]);

                data.addRows(allChartsData[count][0]);

                var options = {
                    hAxis: {
                        title: 'Дни'
                    },
                    vAxis: {
                        title: allChartsData[count][2]
                    },
                    backgroundColor: '#f1f8e9'
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'+allChartsId[count]));
                chart.draw(data, options);
            }

        }

    })
</script>