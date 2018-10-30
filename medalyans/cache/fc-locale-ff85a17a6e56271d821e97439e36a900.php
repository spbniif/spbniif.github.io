<?php return array (
  'plugins.importexport.users.displayName' => 'Модуль «Пользователи в XML»',
  'plugins.importexport.users.description' => 'Импортирует и экспортирует пользователей',
  'plugins.importexport.users.cliUsage' => 'Вызов: {$scriptName} {$pluginName} [команда] ...
Команды:
	import [ИмяФайлаXML] [путь_журнала]
	export [ИмяФайлаXML] [путь_журнала]
	export [ИмяФайлаXML] [путь_журнала] [IdПользователя1] [IdПользователя2] ...',
  'plugins.importexport.users.cliUsage.examples' => 'Примеры:
	Импортировать пользователей в myJournal из файла myImportFile.xml:
	{$scriptName} {$pluginName} import myImportFile.xml myJournal

	Экспортировать всех пользователей из myJournal:
	{$scriptName} {$pluginName} export myExportFile.xml myJournal

	Экспортировать всех пользователей, указанных своими ID:
	{$scriptName} {$pluginName} export myExportFile.xml myJournal 1 2',
  'plugins.importexport.users.import.importUsers' => 'Импортировать пользователей',
  'plugins.importexport.users.import.instructions' => 'Выберите файл данных XML, содержащий информацию о пользователях, для импорта в этот журнал. Подробности о формате этого файла смотрите в помощи журнала.<br /><br />Обратите внимание, что если импортируемый файл содержит имена пользователей или адреса электронной почты, уже существующие в системе, то данные для этих пользователей не будут импортированы, а все новые роли, которые должны были быть созданы, будут назначены существующим пользователям.',
  'plugins.importexport.users.import.dataFile' => 'Файл с данными пользователей',
  'plugins.importexport.users.import.sendNotify' => 'Отправить каждому импортированному пользователю уведомление по электронной почте с указанием его имени пользователя и пароля.',
  'plugins.importexport.users.import.continueOnError' => 'Продолжить импорт остальных пользователей при возникновении ошибки.',
  'plugins.importexport.users.import.usersWereImported' => 'Следующие пользователи были успешно импортированы в систему',
  'plugins.importexport.users.import.errorsOccurred' => 'При импорте произошли ошибки',
  'plugins.importexport.users.import.confirmUsers' => 'Подтвердите, что это те самые пользователи, которых вы хотите импортировать в систему',
  'plugins.importexport.users.import.warning' => 'Предупреждение',
  'plugins.importexport.users.import.encryptionMismatch' => 'Нельзя использовать пароли, хэшированные алгоритмом {$importHash}; OJS сейчас настроен на использование {$ojsHash}. Если вы продолжите, то вам будет необходимо сбросить пароли импортированных пользователей.',
  'plugins.importexport.users.unknownPress' => 'Был указан неизвестный путь журнала «{$journalPath}».',
  'plugins.importexport.users.export.exportUsers' => 'Экспортировать пользователей',
  'plugins.importexport.users.export.exportByRole' => 'Экспортировать по ролям',
  'plugins.importexport.users.export.exportAllUsers' => 'Экспортировать всех',
  'plugins.importexport.users.export.errorsOccurred' => 'При экспорте произошли ошибки',
  'plugins.importexport.users.export.couldNotWriteFile' => 'Не могу записать в файл «{$fileName}».',
  'plugins.importexport.users.importComplete' => 'Импорт выполнен успешно. Пользователи с их именами пользователей и адресами электронной почты, которые еще не использовались, были импортированы вместе с соответствующими группами пользователей.',
  'plugins.importexport.users.results' => 'Результаты',
  'plugins.importexport.users.uploadFile' => 'Пожалуйста, загрузите файл в раздел «Импортировать пользователей», чтобы продолжить.',
); ?>