function showToast(text, type, icon) {
    $('body')
        .toast({
            class: type.toString(),
            showIcon: icon.toString(),
            showProgress: 'bottom',
            message: text
        })
    ;
}
