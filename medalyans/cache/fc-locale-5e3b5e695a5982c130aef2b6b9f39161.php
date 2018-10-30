<?php return array (
  'plugins.importexport.native.displayName' => 'Модуль «Собственный XML»',
  'plugins.importexport.native.description' => 'Импортирует и экспортирует статьи и выпуски в собственном XML-формате OJS.',
  'plugins.importexport.native.import' => 'Импортировать',
  'plugins.importexport.native.import.instructions' => 'Загрузите файл XML для импорта',
  'plugins.importexport.native.exportSubmissionsSelect' => 'Выберите статьи для экспорта',
  'plugins.importexport.native.exportSubmissions' => 'Экспортировать статьи',
  'plugins.importexport.native.exportIssues' => 'Экспортировать выпуски',
  'plugins.importexport.native.results' => 'Результаты',
  'plugins.inportexport.native.uploadFile' => 'Пожалуйста загрузите файл в раздел «Импортировать», чтобы продолжить.',
  'plugins.importexport.native.importComplete' => 'Импорт успешно завершен. Следующие элементы были импортированы:',
  'plugins.importexport.native.cliUsage' => 'Вызов: {$scriptName} {$pluginName} [команда] ...
Команды:
	import [ИмяФайлаXML] [путь_журнала] [имя_пользователя] ...
	export [ИмяФайлаXML] [путь_журнала] articles [IdСтатьи1] [IdСтатьи2] ...
	export [ИмяФайлаXML] [путь_журнала] article [IdСтатьи]
	export [ИмяФайлаXML] [путь_журнала] issues [IdВыпуска1] [IdВыпуска1] ...
	export [ИмяФайлаXML] [путь_журнала] issue [IdВыпуска]

Для импорта данных требуются те или иные дополнительные параметры в зависимости 
от корневого узла XML-документа.

Если корневой узел <article> или <articles>, требуются дополнительные параметры.
Разрешены следующие форматы:

{$scriptName} {$pluginName} import [ИмяФайлаXML] [путь_журнала] [имя_пользователя]
	issue_id [IdВыпуска] section_id [IdРаздела]

{$scriptName} {$pluginName} import [ИмяФайлаXML] [путь_журнала] [имя_пользователя]
	issue_id [IdВыпуска] section_name [НазваниеРаздела]

{$scriptName} {$pluginName} import [[ИмяФайлаXML] [путь_журнала]
	issue_id [IdВыпуска] section_abbrev [АббревиатураРаздела]',
  'plugins.importexport.native.error.unknownSection' => 'Неизвестный раздел {$param}',
  'plugins.importexport.native.error.unknownUser' => 'Указанный пользователь, «{$userName}», не существует.',
  'plugins.importexport.native.import.error.sectionTitleMismatch' => 'Название раздела «{$section1Title}» и название раздела «{$section2Title}» в выпуске «{$issueTitle}» совпали с различными существующими разделами журнала.',
  'plugins.importexport.native.import.error.sectionTitleMatch' => 'Название раздела «{$sectionTitle}» в выпуске «{$issueTitle}» совпало с существующим разделом журнала, но другое название этого раздела не совпадает с другим названием существующего раздела журнала.',
  'plugins.importexport.native.import.error.sectionAbbrevMismatch' => 'Аббревиатура раздела «{$section1Abbrev}» и аббревиатура раздела «{$section2Abbrev}» в выпуске «{$issueTitle}» совпали с различными существующими разделами журнала.',
  'plugins.importexport.native.import.error.sectionAbbrevMatch' => 'Аббревиатура раздела «{$sectionAbbrev}» в выпуске «{$issueTitle}» совпала с существующим разделом журнала, но другая аббревиатура этого раздела не совпала с другой аббревиатурой существующего раздела журнала.',
  'plugins.importexport.native.import.error.issueIdentificationMatch' => 'Ни одного выпуска или более одного выпуска совпало с указанной идентификацией выпуска «{$issueIdentification}».',
  'plugins.importexport.native.import.error.issueIdentificationDuplicate' => 'Существующий выпуск с идентификатором {$issueId} совпадает с указаной идентификацией выпуска «{$issueIdentification}». Этот выпуск не будет изменен, но статьи будут добавлены.',
  'plugins.importexport.native.import.error.issueIdentificationMissing' => 'Элемент идентификации выпуска отсутствует для статьи «{$articleTitle}».',
  'plugins.importexport.native.import.error.publishedDateMissing' => 'Статья «{$articleTitle}» есть в выпуске, но для нее не указана дата публикации.',
); ?>