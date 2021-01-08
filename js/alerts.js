window.confirm = (message) => {
    $('#PromiseConfirm .modal-body p').html(message);
    var PromiseConfirm = $('#PromiseConfirm').modal({
        keyboard: false,
        backdrop: 'static'
    }).modal('show');
    let confirm = false;
    $('#PromiseConfirm .btn-success').on('click', e => {
        confirm = true;
    });
    return new Promise(function (resolve, reject) {
        PromiseConfirm.on('hidden.bs.modal', (e) => {
            resolve(confirm);
        });
    });
};