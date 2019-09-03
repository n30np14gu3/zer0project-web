$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#login-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#login-form').serialize(),
        url: "/login",
        method: "POST",
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                showToast(data.message, 'error','microchip');
            }
            else{
                document.location.replace('/dashboard');
            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    });
});

$('#register-form').submit(function (e) {
    e.preventDefault();
    let errors = $('#register-form-errors');
    $.ajax({
        data: $('#register-form').serialize(),
        url: "/register",
        method: "POST",
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = "block";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else{
                errors[0].style.display = "none";
                errors[0].innerHTML = "";
                showToast('Регистрация успешно завершена! На Ваш почтовый ящик были отправлены дальшейшие инструкции', 'success', 'microchip')
            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    });
});

$('#change-password-form').submit(function (e) {
    e.preventDefault();
    let errors = $('#change-password-errors');
    $.ajax({
        data: $('#change-password-form').serialize(),
        url: "/action/change_password",
        method: "POST",
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = "block ";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else{
                errors[0].style.display = "none";
                errors[0].innerHTML = "";
                showToast('Пароль был успешно сменен', 'success', 'microchip');
                $('#change-password-form')[0].reset();

            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    })
});

$('#activate-promo-form').submit(function (e) {
    e.preventDefault();
    let errors = $('#activate-promo-errors');
    $.ajax({
        data: $('#activate-promo-form').serialize(),
        url: "/action/activate_promo",
        method: "POST",
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = " block";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else{
                errors[0].style.display = "none";
                errors[0].innerHTML = "";
                showToast('Активация произошла успешно', 'success', 'microchip');
                $('#activate-promo-form')[0].reset();

            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    })
});
