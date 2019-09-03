$('#new-cheat-form').submit(function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    let errors = $('#new-cheat-errors');
    $.ajax({
        method: "POST",
        url: "/action/admin/new_cheat",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = "block";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else {
                window.location.reload();
            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    });
});

$('#update-cheat').on('click', function () {
    let errors = $('#update-cheat-errors');
   $.ajax({
       data: {
           'cheat-id': this.value,
       },
       url: '/action/admin/get_info',
       method: 'POST',
       success: function (data) {
           data = JSON.parse(data);
           if(data.status !== "OK"){
               errors[0].style.display = "block";
               errors[0].innerHTML = "";
               for(let i = 0; i < data.message.length; i++){
                   errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
               }
           }
           else {
               errors[0].style.display = "none";
               errors[0].innerHTML = "";
               $('#process-name').val(data.response.process_name);
           }
       },
       error: function () {
           showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
       }
   });
});

$('#update-cheat-form').submit(function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    let errors = $('#update-cheat-errors');
    $.ajax({
        method: "POST",
        url: "/action/admin/update_cheat",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = "block";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else {
                errors[0].style.display = "none";
                errors[0].innerHTML = "";
                showToast('Чит был успешно обновлен', 'success', 'microchip');
                $('#update-cheat-form')[0].reset();
            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    });
});

$('#generate-promo-form').submit(function (e) {
    e.preventDefault();
    let errors = $('#generate-promo-errors');
    let generated_promo = $('#generated-promo');
    $.ajax({
        method: "POST",
        url: "/action/admin/generate_promo",
        data: $('#generate-promo-form').serialize(),
        success: function (data) {
            data = JSON.parse(data);
            if(data.status !== "OK"){
                errors[0].style.display = "block";
                errors[0].innerHTML = "";
                for(let i = 0; i < data.message.length; i++){
                    errors[0].innerHTML += "<li>"+ data.message[i] + "</li>";
                }
            }
            else {
                errors[0].style.display = "none";
                errors[0].innerHTML = "";
                generated_promo[0].style.display = "block";
                $('#generate-promo-form')[0].reset();
                generated_promo.val(data.promo_codes);
            }
        },
        error: function () {
            showToast('При выполнении запроса произошла ошибка', 'error', 'microchip')
        }
    });
});
