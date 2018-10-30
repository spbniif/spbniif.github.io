<?php return array (
  'plugins.importexport.crossref.displayName' => 'Модуль «Экспорт CrossRef XML»',
  'plugins.importexport.crossref.description' => 'Экспортирует метаданные статьи в формате CrossRef XML.',
  'plugins.importexport.crossref.requirements' => 'Требования',
  'plugins.importexport.crossref.requirements.satisfied' => 'Все требования модуля выполнены.',
  'plugins.importexport.crossref.error.publisherNotConfigured' => 'Издатель журнала не был настроен! Вы должны добавить организацию издателя на странице <a href="{$journalSettingsUrl}" target="_blank">настройки журнала</a>.',
  'plugins.importexport.crossref.error.issnNotConfigured' => 'ISSN журнала не был настроен! Вы должны добавить ISSN на странице <a href="{$journalSettingsUrl}" target="_blank">настройки журнала</a>.',
  'plugins.importexport.crossref.error.noDOIContentObjects' => 'Не выбраны статьи для присвоения DOI в модуле открытых идентификаторов DOI, поэтому нет возможности депонировать или экспортировать в этом модуле.',
  'plugins.importexport.crossref.settings.depositorIntro' => 'Следующая информация необходима для успешной передачи в депозитарий CrossRef.',
  'plugins.importexport.crossref.settings.form.depositorName' => 'Имя ответственного',
  'plugins.importexport.crossref.settings.form.depositorEmail' => 'E-mail ответственного',
  'plugins.importexport.crossref.settings.form.depositorNameRequired' => 'Пожалуйста, введите имя ответственного.',
  'plugins.importexport.crossref.settings.form.depositorEmailRequired' => '>Пожалуйста, введите адрес электронной почты ответственного.',
  'plugins.importexport.crossref.registrationIntro' => 'Если вы хотите использовать этот модуль для регистрации идентификаторов цифровых объектов(DOI) напрямую в CrossRef, то для этого вам потребуется имя пользователя и пароль (можно получить на <a href="http://www.crossref.org" target="_blank">CrossRef</a>). Если у вас нет собственного имени пользователя и пароля вы сможете экспортировать в формат CrossRef XML, но не сможете зарегистрировать ваши DOI в CrossRef из OJS.',
  'plugins.importexport.crossref.settings.form.username' => 'Имя пользователя',
  'plugins.importexport.crossref.settings.form.usernameRequired' => 'Пожалуйста, введите имя пользователя, которое вы получили от CrossRef.',
  'plugins.importexport.crossref.settings.form.automaticRegistration.description' => 'OJS будет депонировать присвоенные DOI автоматически в CrossRef. Обратите внимание, что это может потребовать небольшого количества времени после публикации для обработки (например, в зависимости от настроек вашего cron). Вы можете проверить все незарегистрированные DOI.',
  'plugins.importexport.crossref.settings.form.testMode.description' => 'Использовать тестовый API CrossRef (среда тестирования) для депонирования DOI. Пожалуйста, не забудьте убрать этот параметр для реальной работы.',
  'plugins.importexport.crossref.issues.description' => 'Примечание: Здесь для экспорта/регистрации будут рассматриваться только выпуски (а не статьи в этих выпусках).',
  'plugins.importexport.crossref.status.submitted' => 'Отправлен',
  'plugins.importexport.crossref.status.completed' => 'Депонирован',
  'plugins.importexport.crossref.status.failed' => 'Ошибка',
  'plugins.importexport.crossref.status.registered' => 'Активный',
  'plugins.importexport.crossref.status.markedRegistered' => 'Отмечен как активный',
  'plugins.importexport.crossref.statusLegend' => '<p>Статус депонирования:</p>
		<p>
		- Не депонирован: этот DOI не пытались депонировать.<br />
		- Отправлен: этот DOI был отправлен на депонирование.<br />
		- Депонирован: этот DOI был депонирован в Crossref, но может быть пока не активен.<br />
		- Активный: этот DOI был депонирован и корректно интерпретируется.<br />
		- Ошибка: депонирование DOI потерпело неудачу.<br />
		- Отмечен как активный: DOI был вручную отмечен как активный.
		</p>
		<p>Отображается только статус последней попытки депонирования.</p>
		<p>Если депонирование потерпело неудачу, пожалуйста, решите проблему и попробуйте зарегистрировать DOI снова.</p>',
  'plugins.importexport.crossref.action.export' => 'Скачать XML',
  'plugins.importexport.crossref.action.markRegistered' => 'Отметить как активный',
  'plugins.importexport.crossref.action.register' => 'Отправить',
  'plugins.importexport.crossref.action.checkStatus' => 'Проверить статус',
  'plugins.importexport.crossref.senderTask.name' => 'Задача автоматической регистрации CrossRef',
  'plugins.importexport.crossref.notification.failed' => 'Регистрация DOI потерпела неудачу. Пожалуйста, перейдите в Инструменты > Импорт/Экспорт > Модуль «Экспорт CrossRef XML», чтобы увидеть неудавшиеся депонирования.',
  'plugins.importexport.crossref.cliUsage' => 'Вызов:
{$scriptName} {$pluginName} export [ИмяФайлаXML] [путь_журнала] articles IdОбъекта1 [IdОбъекта2] ...
{$scriptName} {$pluginName} register [путь_журнала] articles IdОбъекта1 [IdОбъекта2] ...',
  'plugins.importexport.crossref.register.error.mdsError' => 'Отправка не удалась! Сервер регистрации DOI вернул ошибку: «{$param}».',
  'plugins.importexport.crossref.register.success' => 'Отправка прошла успешно!',
  'plugins.importexport.crossref.export.error.issueNotFound' => 'Нет выпуска, соответствующего указанному ID выпуска «{$issueId}».',
  'plugins.importexport.crossref.export.error.articleNotFound' => 'Нет статьи, соответствующей указанному ID статьи «{$articleId}».',
); ?>