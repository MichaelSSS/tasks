На каких полях нужно расставить индексы и почему ?

Какой тип лучше использовать для таблицы c_items, в которую идет активная запись, а не чтение; и уже более 300.000 строк ?

Воспроизведите структуру таблиц.
```
select

i.id,

i.type,

l_metros.title AS metro,

l_directions.title AS direction

from c_items i

left join l_metros on l_metros.id = i.metro

left join l_directions on l_directions.id = i.direction

where i.id > 0 and i.deleted = 'N' and l_directions.display = 'Y'

order by direction
```

**На каких полях нужно расставить индексы и почему ?**

* поля id во всех таблицах будут первичными ключами.
* поля c_items.metro, c_items.direction, т.к. они участвуют в join. Можно также сделать их внешнмими ключами. 
* на полях c_items.deleted, l_directions.display делать смысла нет, т.к. мало разных значений.


**Какой тип лучше использовать для таблицы c_items, в которую идет активная запись, а не чтение; и уже более 300.000 строк ?**

MyISAM быстрее, т.к. меньше операций при записи. InnoDB работает на транзакциях, что потенциально делает его более медленным по сравнеию с MyISAM. InnoDB можно ускорить при групповых вставках.
