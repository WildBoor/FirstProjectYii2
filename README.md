Общие сведения

    1.	Пользователи делятся на контрагентов и администраторов. Администратор присутствует один в системе изначально (с логином и паролем).	
    
    2.	В системе есть внутренние счета и контрагенты
    
    3.	Администратор может перечислить средства любому контрагенту. Контрагент может перечислить средства как администратору, так и другому контрагенту.

Интерфейс пользователя

    1.	Пользователь может зарегистрироваться или ввести email / пароль и войти в систему (присутствуют соотв. валидаторы).

Панель администратора

    1.	После входа в систему администратор видит название своего счёта, количество средств на нём и три элемента меню: список контрагентов, список переводов, перевод средств. 
    
    2.	В списке контрагентов присутствуют все зарегистрированные контрагенты, представленные в таблице с фильтрами по соответствующим столбцам и с пагинацией по страницам (GridView).
    
    3.	В списке переводов присутствуют все переводы(операции), представленные в таблице с фильтрами и пагинацией по страницам (GridView).
    
    4.	На странице перевод средств присутствует форма для ввода email получателя и суммы перевода (присутствуют соотв. валидаторы). Отправитель не может отправить себе средства и не может перечислить сумму, превышающую сумму на его счёте.
    
Панель контрагента

    После входа в систему контрагент видит название своего счёта, количество средств на нём и два три элемента меню: история переводов, перевод средств.
    
    1.	В списке переводов присутствуют все переводы(операции) с участием контрагента, представленные в таблице с фильтрами и пагинацией по страницам (GridView).
    
    2.	На странице перевод средств присутствует форма для ввода email получателя и суммы перевода (присутствуют соотв. валидаторы). Отправитель не может отправить себе средства и не может перечислить сумму, превышающую сумму на его счёте.
    
Порядок развёртывания проекта

    1)Заходим в корневую папку, и в консоле прописываем composer install .
    
    2)Далее прописываем php init и выбираем между dev и prod версией
    
    3)При запуске браузера открывается список папок приложения, заходим в frontend\web (см.ниже "Не решённые проблемы")
    
    4)Присутствуют миграции в папке console\migrations. В базе при накате миграций сразу присутствует админ:
    
        username - admin
        
        email - admin@mail.ru
        
        password - admin
        
    4)Наблюдая за функционалом нужно 
    
        •	зарегистрировать одного или более пользователей
        
        •	 зайти по емейлу и паролю администратора 
        
        •	перечислить средства контрагентам, зайти как контрагент, перечислить средства админу и другим контрагентам
        
    Основной контроллер находится в папки frontend\controllers\SiteController.php, где присутствуют различные комментарии. 
    
    Присутствуют таблицы связанные с помощью ActiveRecord (внешние ключи прописаны в миграциях, но закомментированы). 
    
Не решённые проблемы: 

    1.	Не смог разделить сайт на frontend и backend с помощью RBAC (Role-based access control), поэтому часто встречаются конструкции типа if($role !== 1){}, где $role - роль пользователя, записанная в таблицу user. 
    
    2.	Не смог решить проблему первоначального запуска сайта со списка папок проекта, с вынужденным входом в папку frontend\web.

СУБД - PostgreSQL, фреймворк - Yii2 advanced, локальный сервер - OpenServer (Модули: HTTP - Nginx-1.12, PHP - 7.1 x64, PostgreSQL - 9.6 x64)




"# FirstProjectYii2" 
