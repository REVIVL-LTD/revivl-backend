function Toast(type, css, msg) {
    this.type = type;
    this.css = css;
    this.msg = msg ;
}


export function sendSuccessToastr(messageText = null) {
    const toastsSuccess = new Toast('success', 'toast-top-right', 'Успешно');
    toastr.options.positionClass = toastsSuccess.css
    toastr[toastsSuccess.type](messageText ? messageText : toastsSuccess.msg);
}

export function sendInfoToastr(messageText = null) {
    const toastsInfo = new Toast('info', 'toast-top-right', 'Ресурс не доступен');
    toastr.options.positionClass = toastsInfo.css
    toastr[toastsInfo.type](messageText ? messageText : toastsInfo.msg);
}

export function sendErrorToastr(messageText = null) {
    const toastsError = new Toast('error', 'toast-top-right', 'Ошибка сервера')
    toastr.options.positionClass = toastsError.css
    toastr[toastsError.type](messageText ? messageText : toastsError.msg);
}