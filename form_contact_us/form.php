<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
</head>
<body>
    <div class="form">
        <div class="form-group">
            <div class="heading">
                <h2>Форма обратной связи</h2>
            </div>
            <form action="send.php" method="post" enctype="multipart/form-data" onsubmit="return sendForm(event, 'send.php');">
                <div>
                    <label class="col-sm-2 col-form-label" for="fname">Имя:</label>
                    <input class="form-control" type="text" id="fname" name="fname" required placeholder="Ваше имя">
                </div>

                <div>
                    <label class="col-sm-2 col-form-label" for="lname">Фамилия:</label>
                    <input class="form-control" type="text" id="lname" name="lname" required placeholder="Ваша фамилия">
                </div>

                <div>
                    <label class="col-sm-2 col-form-label" for="email">Email:</label>
                    <input class="form-control" type="email" id="email" name="email" required placeholder="Ваш Email">
                </div>

                <div>
                    <label class="col-sm-2 col-form-label" for="tel">Телефон:</label>
                    <input class="form-control" type="tel" id="tel" name="tel" required placeholder="Ваш телефон">
                </div>

                <div class="form-group-option pt-3">
                    <label for="time"><h4>Когда удобно к вам позвонить?</h4></label>
                    <select class="form-control" name="time" id="time">
                        <option value="В первой половине дня">В первой половине дня</option>
                        <option value="Во второй половине дня">Во второй половине дня</option>
                        <option value="В любое время">В любое время</option>
                    </select>
                </div>

                <fieldset>
                    <div class="row">
                        <legend class="col-form-label col-sm-8 pt-3"><h4>По какому поводу обращаетесь?</h4></legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="occasion" id="employment" value="Работа" checked>
                                <label class="form-check-label" for="employment">
                                    Трудоустройство
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="occasion" id="services" value="Услуги">
                                <label class="form-check-label" for="services">
                                    Услуги
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group-file pt-3">
                    <label for="file"><h4>Прикрепите файл по вашей теме</h4></label>
                    <input class="form-control-file" type="file" name="file" id="file">
                </div>

                <div class="form-group-textrea pt-3">
                    <label for="msg"><h4>Напиши сопроводительное письмо</h4></label>
                    <textarea class="form-control" id="msg" name="msg" rows="3"></textarea>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" required type="checkbox" id="agree" name="agree" value="1">
                    <label class="form-check-label" for="agree">Соглашаюсь на обработку персональных данных</label>
                </div>

                <div>
                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="sendpro" value="Отправить">
                    <button class="btn btn-secondary btn-lg btn-block" type="reset">Сбросить</button>
                    <a href="table.php?page=1" class="btn btn-link btn-block" role="button" aria-disabled="true">Посмотреть таблицу</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Отправка формы на сервер без перезагрузки страницы
    function sendForm(event, url) {
        event.preventDefault();

        var form = event.target;
        var req = new XMLHttpRequest();
        req.open('POST', url, true);

        req.onload = function () {
            if (req.status >= 200 && req.status < 400) {
                var json;
                try {
                    json = JSON.parse(req.responseText);
                } catch (e) {
                    alert('Некорректный ответ сервера');
                    return;
                }

                if (json.result === 'success') {
                    alert('Сообщение отправлено');
                    form.reset();
                } else {
                    alert('Ошибка. Сообщение не отправлено');
                }
            } else {
                alert('Ошибка сервера. Номер: ' + req.status);
            }
        };

        // Если не удалось отправить запрос
        req.onerror = function () {
            alert('Ошибка отправки запроса');
        };

        req.send(new FormData(form));
        return false;
    }
    </script>
</body>
</html>
