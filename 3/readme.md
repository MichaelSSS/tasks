Изначально дан такой html код:
```
<form method="post">

<input type="text" placeholder="Улица" /><button>Искать</button>

</form>
```
Необходимо доработать его с помощью javascript/jquery и php так, чтобы по мере набора названия улицы под полем ввода появлялся прокручивающийся список подходящих вариантов.

Сам html код при этом не трогать вообще.

**Как будет устроен механизм ?**

Данные для списка будут загружаться через AJAX с сервера. Условие в SQL запросе будет `WHERE name LIKE :search`, с параметрами `[ ':search'  => "%$searchString%" ]`. На стороне клиента можно сделать кеширование в переменной. Данные передавать в виде массива в JSON. Когда данные получены, формируется html-код списка.

**По какому событию будет срабатывать запуск этого механизма ?**

Когда меняется содержимое поля ввода. В современных браузерах поддерживается событие `input`. Для лучшей совместимости можно добавить `keyup`, но нужно проверять на нажатие специальных клавиш. Им можно назначить специальное поведение. Например, клавиши "вверх", "вниз"" позволяют перемещаться по списку, когда он открыт. Enter делает выбор, Esc скрывает список. Если используется несколько событий (input, keyup, keypress), запрос нужно делать по первому сработавшему, чтобы не делать одинаковых запросов.

Можно делать задержку перед запросом, чтобы избежать лишних запросов при быстром изменении.

Можно не делать запрос, если введене меньше некоторого минимальнлого количества символов.

**Какие есть нюансы работы: если улиц много или мало ?**

Если улиц много, список может получится большим, на сервере нужно ограничивать выборку. Если мало, можно не найти ни одной улицы, тогда нужно как-то показать, что список пустой.

**Какие нюансы валидации формы ?**

На клиенте названия улиц сложно валидировать, можно только проверять на наличие некоторых специальных символов, которые точно не могут быть в названии. На сервере - защита от sql инъекций.

**Как лучше выдать улицы по релевантности ?**

Сначала выводить названия, которые начинаются со строки поиска, потом у которых она в середине. Но проще по алфавиту и подсвечивать часть названия, совпадающую со строкой поиска.

**Какие есть логические нюансы UI ?**

Мы показываем список, когда пользователь изменил содержимое поля ввода и при этом длина строки больше минимальной. Скрываем список, когда он выбрал значение из списка или когда поле ввода теряет фокус. В последнем случае пользователь мог не закончить вводить и когда он вернется в поле ввода, мы можем сразу показать список.

 Поле ввода потеряет фокус, когда пользователь собирается кликнуть на элементе списка. Нужно проверять это и не скрывать список в этом случае, иначе список скроется раньше, чем пользователь сможет кликнуть на нем.
