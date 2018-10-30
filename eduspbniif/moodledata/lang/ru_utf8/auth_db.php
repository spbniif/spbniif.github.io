<?php

// All of the language strings in this file should also exist in
// auth.php to ensure compatibility in all versions of Moodle.

$string['auth_dbdescription'] = 'Этот метод использует внешнюю базу данных для проверки пары логин/пароль. При создании новой учетной записи информация из полей может быть скопирована в систему.';
$string['auth_dbextrafields'] = '<p>Эти поля дополнительные. Вы можете выбрать предварительное заполнение некоторых полей пользовательских данных из полей внешней базы данных, указанной здесь. </p><p>Не заполняйте поле, для использования настроек по умолчанию.</p>
<p>В любом случае, пользователь сможет редактировать все поля после того, как он зайдет в систему.</p>';
$string['auth_dbfieldpass'] = 'Название поля, содержащего пароль';
$string['auth_dbfielduser'] = 'Название поля, содержащего логин';
$string['auth_dbhost'] = 'Компьютер, на котором запущен сервер базы данных';
$string['auth_dbname'] = 'Название базы данных';
$string['auth_dbpass'] = 'Пароль, соответствующий указанному логину';
$string['auth_dbpasstype'] = 'Определяет формат используемых паролей.  MD5-кодирование, наиболее подходящее при соединении с другими web-приложениями, например PostNuke';
$string['auth_dbtable'] = 'Название таблицы в базе данных';
$string['auth_dbtitle'] = 'Использовать внешнюю базу данных';
$string['auth_dbtype'] = 'Тип базы данных (См. <a href=\"../lib/adodb/readme.htm#drivers\">Документацию по ADO db</a> для деталей)';
$string['auth_dbuser'] = 'Логин пользователя с правами только на чтение для базы данных';