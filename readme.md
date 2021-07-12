# Тестовое задание

## Создать модуль, в котором

### 1. Надо реализовать кастомный индекс, test_custom_product_index,
   который будет отображен в списке индексов Magento
   (System->Tools->IndexManagement) c лэйблом  Test Custom Product Index.
   Индекс должен поддерживать режимы работы OnSave и BySchedule,
   должна быть возможность выполнить reindex из консоли.

Таблица индекса test_custom_product_index содержит колонки id, product_id, result
(таблицу создать через db_schema.xml )

product_id - id обрабатываемого продукта,
result=1 если id продукта четное,
result=0 если id продукта нечетное,
(это чисто академическая задача. Поэтому используем простейшее условие на входе и простейший результат на выходе, чтобы не увеличивать объем работы.
В реальности этот могла бы быть проверка, например, на соответствие продукта сложным условиям, например [https://www.screencast.com/t/xgsJ83WNQ](https://www.screencast.com/t/xgsJ83WNQ)

После установки модуля по выполнению из cli команды
php bin/magento indexer:reindex test_custom_product_index
таблица должна заполниться данными для всех продуктов каталога.

Данные в таблице индексов должны обновляться при любом изменении атрибутов продукта или связей product<->category
(можно взять за пример indexer catalogrule_product)

### 2. Сделать доработку для Magento API

При запросе информации о продукте по sku (https://www.screencast.com/t/o9b40otss6jk url="/V1/products/:sku" method="GET")
должны получить в ответе значение result из test_custom_product_index
для этого продукта (Сделайте с помощью плагина и extension attributes [https://www.screencast.com/t/jUfXtfWH](https://www.screencast.com/t/jUfXtfWH))


### 3. Проверьте, пожалуйста, что ваш модуль рабочий, его можно установить, включить и проверить.
   И приложите ссылки на документацию и примеры (если были), которыми вы пользовались при разработке модуля.

----

### Ссылки

[https://devdocs.magento.com/guides/v2.4/extension-dev-guide/indexing-custom.html](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/indexing-custom.html)
[https://devdocs.magento.com/guides/v2.4/extension-dev-guide/extension_attributes/adding-attributes.html](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/extension_attributes/adding-attributes.html)