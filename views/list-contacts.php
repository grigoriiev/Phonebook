<?php require 'header.php'; ?>

<body>
    <h1>
        <?= $page; ?>
    </h1>

    <div class="error success">

    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Телефонный номер</th>
                <th scope="col">Удаление контакта</th>
            </tr>
        </thead>
        <tbody class="tableContent">
            <?php
            if ($phoneBooks) {
                $n = 0;
                foreach ($phoneBooks as $key => $value) {
                    $n++;
                    ?>
                    <tr data-tel="<?= $value['tel']; ?>" data-name="<?= $value['name']; ?>">
                        <th scope='row'><?= $n; ?></th>
                        <td><?= $value['name']; ?></td>
                        <td><?= $value['tel']; ?></td>
                        <td><button type='button' class='btn btn-danger deleteButton'>Удалить</button></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
    <?php require 'footer.php'; ?>
    <script>
        $(document).ready(function () {
            document.querySelectorAll(".deleteButton").forEach((element, index) => {

                element.addEventListener("click", deleteUser);
            })

            function deleteUser(e) {
                let elementCurrent = e.currentTarget;
                let element = e.currentTarget.parentElement.parentElement;
                let elementTel = e.currentTarget.parentElement.parentElement.dataset.tel;
                let elementName = e.currentTarget.parentElement.parentElement.dataset.name;
                elementCurrent.removeEventListener("click", deleteUser)
                element.remove()



                $.ajax({
                    type: 'POST',
                    url: '/listContacts/deleteContact', // Обработчик собственно
                    data: {
                        tel: elementTel,
                        name: elementName

                    },
                    success: function (data) {
                        // запустится при успешном выполнении запроса и в data будет ответ скрипта
                        //  alert('Успех!');
                        let p = JSON.parse(data)
                        //      alert(p.error);
                        if ($(".alert").length > 0) {
                            $(".alert").remove();
                        }
                        if (p.error) {

                            $(".error").append("<div class='alert alert-danger' role='alert'>" +
                                p.message + "</div>")
                            setTimeout(function () {
                                $(".alert").remove();
                            }, 4000)

                        } else {
                            $(".success").append("<div class='alert alert-success' role='alert'>" +
                                p.message + "</div>")
                            setTimeout(function () {
                                $(".alert").remove();
                            }, 4000)
                        }


                        //            console.log(p)
                        //             alert(p);
                    },
                    error: function (data) {
                        //                 alert('Ошибка!');
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


                //          alert("Пользователь удален!")
            }

        });
    </script>
</body>

</html>