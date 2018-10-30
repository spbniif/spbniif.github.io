<?php return array (
  'plugins.importexport.pubmed.displayName' => 'Модуль «Экспорт в PubMed XML»',
  'plugins.importexport.pubmed.description' => 'Экспортирует метаданные статей в формат PubMed XML для индексирования в MEDLINE.',
  'plugins.importexport.pubmed.export' => 'Экспортировать данные',
  'plugins.importexport.pubmed.export.issues' => 'Экспортировать выпуски',
  'plugins.importexport.pubmed.export.selectIssue' => 'Выберите выпуск для экспорта.',
  'plugins.importexport.pubmed.export.articles' => 'Экспортировать статьи',
  'plugins.importexport.pubmed.export.selectArticle' => 'Выберите статьи для экспорта.',
  'plugins.importexport.pubmed.cliUsage' => 'Вызов: 
{$scriptName} {$pluginName} [ИмяФайлаXML] [путь_журнала] articles [IdСтатьи1] [IdСтатьи2] ...
{$scriptName} {$pluginName} [ИмяФайлаXML] [путь_журнала] issue [IdВыпуска]',
  'plugins.importexport.pubmed.cliError' => 'ОШИБКА:',
  'plugins.importexport.pubmed.export.error.issueNotFound' => 'Нет выпуска с указанным ID выпуска «{$issueId}».',
  'plugins.importexport.pubmed.export.error.articleNotFound' => 'Нет статьи с указанным ID статьи «{$articleId}».',
); ?>