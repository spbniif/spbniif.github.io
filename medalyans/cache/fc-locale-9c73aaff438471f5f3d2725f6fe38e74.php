<?php return array (
  'plugins.importexport.medra.displayName' => 'Модуль «Экспорт/регистрация mEDRA»',
  'plugins.importexport.medra.description' => 'Экспортирует метаданные выпуска, статьи и гранки в формат Onix for DOI (O4DOI) и регистрирует DOI в регистрационном агентстве mEDRA.',
  'plugins.importexport.medra.intro' => 'Если вы хотите зарегистрировать DOI в mEDRA, пожалуйста, следуйте указаниям на
		<a href="http://www.medra.org/en/guide.htm" target="_blank">главной странице mEDRA</a>,
		что бы получить имя пользователя и пароль. Если у вас нет вашего собственного имени пользователя и
		пароля, вы все равно сможете экспортировать в формат mEDRA XML (Onix for DOI),
		но не сможете зарегистрировать ваши DOI в mEDRA из OJS.
		Пожалуйста, обратите внимание, что пароль будет сохраняться как простой текст, то есть не будет шифроваться,
		это требования службы регистрации mEDRA.',
  'plugins.importexport.medra.settings.form.description' => 'Пожалуйста, настройте модуль экспорта mEDRA:',
  'plugins.importexport.medra.settings.form.username' => 'Имя пользователя',
  'plugins.importexport.medra.settings.form.usernameRequired' => 'Пожалуйста, введите ваше имя пользователя mEDRA. Имя пользователя не может содержать двоеточия.',
  'plugins.importexport.medra.settings.form.registrantName' => 'Название организации, зарегистрированной в mEDRA',
  'plugins.importexport.medra.settings.form.registrantNameRequired' => 'Пожалуйста, введите название организации, зарегистрированной в mEDRA.',
  'plugins.importexport.medra.settings.form.fromFields' => 'Лицо, с которым должно связываться mEDRA при возникновении технических проблем:',
  'plugins.importexport.medra.settings.form.fromCompany' => 'Организация',
  'plugins.importexport.medra.settings.form.fromCompanyRequired' => 'Пожалуйста, введите название организации, которая технически отвечает за экспорт DOI (например, организация, которая предоставляет хостинг вашему веб-серверу).',
  'plugins.importexport.medra.settings.form.fromName' => 'Контактное лицо',
  'plugins.importexport.medra.settings.form.fromNameRequired' => 'Пожалуйста, введите имя контактного лица по техническим вопросам.',
  'plugins.importexport.medra.settings.form.fromEmail' => 'Адрес электронной почты',
  'plugins.importexport.medra.settings.form.fromEmailRequired' => 'Пожалуйста, введите правильный адрес электронной почты контактного лица по техническим вопросам.',
  'plugins.importexport.medra.settings.form.publicationCountry' => 'Пожалуйста, выберите страну, которая должна быть проинформирована как «страна издания» в mEDRA.',
  'plugins.importexport.medra.settings.form.exportIssuesAs' => 'Пожалуйста выберите, хотите ли вы экспортировать выпуски как <a href="http://www.medra.org/en/metadata_td.htm" target="_blank">«работы» или «манифестации»</a>.',
  'plugins.importexport.medra.settings.form.work' => 'работа',
  'plugins.importexport.medra.settings.form.manifestation' => 'манифестация',
  'plugins.importexport.medra.settings.form.exportIssuesAs.label' => 'Экспортировать номера как',
  'plugins.importexport.medra.settings.form.automaticRegistration.description' => 'OJS будет регистрировать  присвоенные DOI автоматически в mEDRA. Обратите внимание, что это может потребовать небольшого количества времени после публикации для обработки (например, в зависимости от настроек вашего cron). Вы можете проверить все незарегистрированные DOI.',
  'plugins.importexport.medra.settings.form.testMode.description' => 'Использовать тестовый API mEDRA (среда тестирования) для регистрации DOI. Пожалуйста, не забудьте убрать этот параметр для реальной работы.',
  'plugins.importexport.medra.workOrProduct' => 'ПОМНИТЕ: DOI, присвоенные статьям, будут экспортированы в mEDRA как <a href="http://www.medra.org/en/metadata_td.htm" target="_blank">«работы» (works)</a>. DOI, присвоенные гранкам, будут экспортироваться как <a href="http://www.medra.org/en/metadata_td.htm" target="_blank">«манифестации» (manifestations)</a>.',
  'plugins.importexport.medra.senderTask.name' => 'Задача автоматической регистрации mEDRA',
  'plugins.importexport.medra.cliUsage' => 'Вызов:
{$scriptName} {$pluginName} export [ИмяФайлаXML] [путь_журнала] {issues|articles|galleys} IdОбъекта1 [IdОбъекта2] ...
{$scriptName} {$pluginName} register [путь_журнала] {issues|articles|galleys} IdОбъекта1 [IdОбъекта2] ...',
); ?>