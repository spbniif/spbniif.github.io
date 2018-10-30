<?php return array (
  'plugins.importexport.doaj.displayName' => 'Модуль «Экспорт в DOAJ»',
  'plugins.importexport.doaj.description' => 'Экспортирует журнал для DOAJ.',
  'plugins.importexport.doaj.export.contact' => 'Связаться с DOAJ для добавления журнала',
  'plugins.importexport.doaj.registrationIntro' => 'Если вы хотите зарегистрировать статьи прямо из OJS, пожалуйста, введите ваш ключ API DOAJ. Если у вас нет ключа API DOAJ, вы все равно сможете экспортировать в формат DOAJ XML, но не сможете зарегистрировать ваши статьи с DOAJ напрямую из OJS.',
  'plugins.importexport.doaj.settings.form.apiKey' => 'Ключ API DOAJ',
  'plugins.importexport.doaj.settings.form.apiKey.description' => 'Вы найдете ключ API на своей странице пользователя DOAJ.',
  'plugins.importexport.doaj.settings.form.automaticRegistration.description' => 'OJS будет автоматически депонировать статьи в DOAJ. Обратите внимание, что это может потребовать небольшого количества времени после публикации для обработки (например, в зависимости от настроек вашего cron). Вы можете проверить все незарегистрированные статьи.',
  'plugins.importexport.doaj.settings.form.testMode.description' => 'Использовать тестовый API DOAJ (среда тестирования) для регистрации. Пожалуйста, не забудьте убрать этот параметр для реальной работы.',
  'plugins.importexport.doaj.senderTask.name' => 'Задача автоматической регистрации DOAJ',
  'plugins.importexport.doaj.register.error.mdsError' => 'Депонирование не удалось! API DOAJ  вернул ошибку : «{$param}».',
  'plugins.importexport.doaj.cliUsage' => 'Вызов:
{$scriptName} {$pluginName} export [ИмяФайлаXML] [путь_журнала] articles IdОбъекта1 [IdОбъекта2] ...',
); ?>