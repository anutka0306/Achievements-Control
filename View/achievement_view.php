<div class ="col-sm-12">
    <div class="d-flex justify-content-between">
        <div class="ach__main-info">
            <h2><?=$data['info']['name'];?></h2>
            <small class="ach-description"><?=$data['info']["description"]?></small>
            <p>Status: <?=$data['info']["status_name"]?></p>
        </div>

        <div class="ach__actions-list">
            <h3>Действия цели</h3>
            <?php if(!empty($data['actions'])):?>
            <ul>
            <?php foreach ($data['actions'] as $action):?>
                <li class="d-flex justify-content-between ach__actions-list_item"><?=$action['name']?>
                    <div class="d-flex align-items-center">
                        <a class="ach__actions-list_edit"><i class="fas fa-pencil-alt"></i></a>
                        <form id="delete_action_form<?=$action['id']?>" class="fff" action="/achievement/delete_action/<?=$action['id']?>" method="post">
                            <a href="#"
                               class="ach__actions-list_del"><i class="fas fa-times-circle"></i></a>
                        </form>
                    </div>
                </li>

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

<script>
    $(document).ready(function () {

        // Submit form by click by a-element - delete link
       /* $(".ach__actions-list_del").on('click', function (e) {
            e.preventDefault();
            let formId = $(this).parent().attr('id');
            $('#'+formId).submit();
        });*/

        $(".ach__actions-list_del").on('click',
            async (e) =>{
                e.preventDefault();
                let parentForm = e.target.parentNode.parentNode.id;
                if(await confirm('Вы уверены, что хотите удалить действие?<br> <strong>Внимание!</strong><br> Все графики и история, свзанные с данным действием удалятся безвозвратно!')){
                    $('#'+parentForm).submit();
                }
            }
            );

    })
</script>