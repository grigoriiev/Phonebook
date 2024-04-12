<?php require 'header.php'; ?>

<body>
    <h1>
        <?= $page; ?>
    </h1>
    <form id="form">

        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Имя">
        </div>
        <div class="mb-3">
            <label for="exampleInputTel1" class="form-label">Телефон</label>
            <input type="tel" class="form-control" id="exampleInputTel1" placeholder="123-45-678"
                pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
        </div>
        <div class="mb-3 success error">

        </div>
        <div class="mb-3 mt-5">
            <button type="button" class="btn btn-primary" id="submit">Добавить</button>
        </div>
    </form>

    <?php require 'footer.php'; ?>
</body>
<script>
    $(document).ready(function () {
        //var form = $('#'+form_id);

        $("#submit").on("click", function () {
            let name = document.querySelector('#exampleFormControlInput2').value;
            let tel = document.querySelector('#exampleInputTel1').value
            let button = document.querySelector('#submit');

            $.ajax({
                type: 'POST',
                url: '/contact/createContact', // Обработчик собственно
                data: {
                    name: name,
                    tel: tel
                },
                success: function (data) {
                    // запустится при успешном выполнении запроса и в data будет ответ скрипта
                    //                alert('Успех!');
                    let p = JSON.parse(data)
                    //                 alert(p.error);
                    if ($(".alert").length > 0) {
                        $(".alert").remove();
                    }
                    if (p.error) {

                        $(".error").append("<div class='alert alert-danger' role='alert'>" +
                            p.message + "</div>")
                        $('#form')[0].reset();
                        setTimeout(function () {
                            $(".alert").remove();
                        }, 4000)

                    } else {
                        $(".success").append("<div class='alert alert-success' role='alert'>" +
                            p.message + "</div>")
                        $('#form')[0].reset();
                        setTimeout(function () {
                            $(".alert").remove();
                        }, 4000)
                    }

                },
                error: function (data) {
                    let p = JSON.parse(data)
                    if ($(".alert").length > 0) {
                        $(".alert").remove();
                    }
                    if (p) {
                        $(".error").append("<div class='alert alert-danger' role='alert'>" +
                            p + "</div>")
                        setTimeout(function () {
                            $(".alert").remove();
                        }, 4000)
                    }
                }
            });
        });
    });
</script>

</html>