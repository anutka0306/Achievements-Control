<div class="col-md-8">
    <h3>Achivments Areas</h3>
    <div class="d-flex ach-areas flex-wrap ">
     <?php if(count($data) > 0): ?>

      <?php foreach ($data as $area):?>
        <div class="card-wrapper d-flex flex-column <? if($area['status'] == 2) echo 'completed-area';?>">
            <div class="card" id="card_<?=$area['id'];?>">
                <div class="card-header">
                    <small class="area-status"><?=$area['status_name'];?></small>
                        <small class="area__end-date"><?=$area['end_date'];?></small>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$area['name'];?></h5>
                    <p class="card-text overflow-multiply" title="<?=$area['description'];?>"><?=$area['description'];?></p>
                    <a href="/dashboard/achievement/<?=$area['id'];?>" class="card-link">See...</a>

                    <? if($area['status'] == 1):?>
                    <a href="#" class="icons-small" data-toggle="collapse" data-target="#card__edit-area_<?=$area['id'];?>" aria-expanded="false" aria-controls="card__edit-area_<?=$area['id'];?>"><i class="fas fa-edit"></i></a>
                    <? endif;?>

                    <a href="#" class="icons-small delete_area" title="Удалить задачу" data-id="<?=$area['id'];?>"><i class="fas fa-trash-alt" data-id="<?=$area['id'];?>"></i></a>

                    <? if($area['status'] == 1):?>
                    <a href="#" class="icons-small complete_area" data-id="<?=$area['id'];?>" title="Завершить задачу"><i class="fa fa-flag-checkered" data-id="<?=$area['id'];?>" aria-hidden="true"></i></a>
                    <? endif;?>
                </div>
                <div class="card-footer">
                    <small>Дата начала: <span class="date"> <?=$area['start_date'];?></span></small>
                </div>
            </div>

            <!-- Edit card area   -->
             <div class="collapse" id="card__edit-area_<?=$area['id'];?>">
                 <div class="card card-body">
                     <form method="post" action="" id="edit_area_form_<?=$area['id'];?>">
                         <div class="form-group">
                             <input name="areaId" type="hidden" class="form-control" value="<?=$area['id'];?>">
                         </div>
                         <div class="form-group">
                             <label for="formGroupAreaName">Название</label>
                             <input name="areaName" type="text" class="form-control" value="<?=$area['name'];?>">
                         </div>
                         <div class="form-group">
                             <label for="formGroupAreaDescription">Описание зоны</label>
                             <textarea name="areaDescription" class="form-control" rows="5"><?=$area['description'];?></textarea>
                         </div>
                         <div class="form-group">
                             <label for="startDate">Дата начала</label>
                             <input type="date" name="startDate" class="form-control" value="<?=$area['start_date']?>">
                         </div>
                         <button type="submit" value="<?=$area['id']?>" class="btn btn-success mb-2 edit_area_btn" id="edit_area_btn_<?=$area['id']?>">Изменить</button>
                     </form>
                 </div>
             </div>
        </div>
       <?php endforeach; ?>
     <?php else: ?>
        <div class="alert alert-info" role="alert">
            <small>У вас еще нет ни одной зоны контроля достижений. Создайте первую прямо сейчас!</small>
        </div>
     <?php endif;?>
    </div>
</div>

<div class="col-md-4">
    <div id="new-area_wrapper" class="d-flex flex-column align-items-center">
        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Новая зона
        </button>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="post" action="" id="create_area_form">
                    <div class="form-group">
                        <label for="formGroupAreaName">Название</label>
                        <input name="areaName" type="text" class="form-control" id="formGroupAreaName" placeholder="Имя новой зоны">
                    </div>
                    <div class="form-group">
                        <label for="formGroupAreaDescription">Описание зоны</label>
                        <textarea name="areaDescription" class="form-control" id="formGroupAreaDescription" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success mb-2" id="create_area_btn">Создать</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $("#create_area_btn").on('click',
            function () {
                addAreaAjaxForm('message-block','create_area_form','/dashboard/create_area');
                return false;
            }
        );

        $(document).on('click', ".delete_area",
           async (e) => {
                e.preventDefault();
               let id = e.target.attributes['data-id'].nodeValue;
                if (await confirm('Вы уверены, что хотите удалить зону?')) {

                    delAreaAjax('message-block', '/dashboard/delete_area/' + id, id);
                    //console.log(id.target.attributes['data-id'].nodeValue);
                }
                return false;
            });

        $(document).on('click',".edit_area_btn",
            function (e) {
                e.preventDefault();
                let id = $(this).attr("value");
                editAreaAjax('message-block','edit_area_form_'+id, '/dashboard/edit_area/' + id);
                return false;
            }
        )

        $(document).on('click', ".complete_area",
            async (e) => {
                e.preventDefault();
                let id = e.target.attributes['data-id'].nodeValue;
                if (await confirm('Вы уверены, что хотите завершить задачу?')) {

                    completeAreaAjax('message-block', '/dashboard/complete_area/' + id, id);
                }
                return false;
            });
    });


</script>