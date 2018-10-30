<?php return array (
  'plugins.importexport.datacite.displayName' => 'Модуль «Экспорт/регистрация DataCite»',
  'plugins.importexport.datacite.description' => 'Экспортирует или регистрирует метаданные выпуска, статьи, гранки и дополнительных файлов в формате DataCite.',
  'plugins.importexport.datacite.settings.description' => 'Пожалуйста, настройте модуль экспорта DataCite перед его первым использованием.',
  'plugins.importexport.datacite.intro' => 'Если вы хотите зарегистрировать DOI в DataCite, пожалуйста, свяжитесь с управляющим
		агентом через <a href="http://datacite.org/contact" target="_blank">главную страницу
		DataCite</a>, который перенаправит вас к вашему региональному члену DataCite. Как только вы
		установите отношения с организацией-членом DataCite, вы будете получить
		доступ к службе DataCite для выдачи постоянных идентификаторов (DOI)
		и регистрации связанных с ними метаданных. Если у вас нет вашего собственного имени пользователя и
		пароля, вы все равно сможете экспортировать в формат DataCite XML, но
		не сможете зарегистрировать ваши DOI в DataCite из OJS.
		Пожалуйста, обратите внимание, что пароль будет сохраняться как простой текст, то есть не будет шифроваться,
		это требования службы регистрации DataCite.',
  'plugins.importexport.datacite.settings.form.username' => 'Имя пользователя (символ)',
  'plugins.importexport.datacite.settings.form.usernameRequired' => 'Пожалуйста, введите имя пользователя (символ), который вы получили от DataCite. Имя пользователя не может содержать двоеточия.',
  'plugins.importexport.datacite.settings.form.automaticRegistration.description' => 'OJS будет депонировать DOI автоматически в DataCite. Обратите внимание, что это может потребовать небольшого количества времени после публикации для обработки (например, в зависимости от настроек вашего cron). Вы можете проверить все незарегистрированные DOI.',
  'plugins.importexport.datacite.settings.form.testMode.description' => 'Использовать тестовый префикс DataCite для регистрации DOI. Пожалуйста, не забудьте убрать этот параметр этот параметр для реальной работы.',
  'plugins.importexport.datacite.senderTask.name' => 'Задача автоматической регистрации DataCite',
  'plugins.importexport.datacite.cliUsage' => 'Вызов:
{$scriptName} {$pluginName} export [ИмяФайлаВывода] [путь_журнала] {issues|articles|galleys} IdОбъекта1 [IdОбъекта2] ...
{$scriptName} {$pluginName} register [путь_журнала] {issues|articles|galleys} IdОбъекта1 [IdОбъекта2] ...',
); ?>