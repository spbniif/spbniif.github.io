<?php return array (
  'plugins.generic.subscriptionSSO.name' => 'Subscription SSO Plugin',
  'plugins.generic.subscriptionSSO.description' => 'This plugin delegates subscription checking to an external system for SSO (Single Sign On)-like behavior. When a request comes to OJS with the incoming parameter name specified -- this should be a parameter that OJS does not use internally -- the plugin will contact the verification URL with the value of the parameter appended. If the remove service\'s result matches the specified regular expression, the user will be considered valid. If not, the user will be redirected to the specified URL.',
  'plugins.generic.subscriptionSSO.settings' => 'Settings',
  'plugins.generic.subscriptionSSO.subscriptionSSOSettings' => 'Subscription Single Sign-On Settings',
  'plugins.generic.subscriptionSSO.settings.description' => 'Use the following form to configure the external service that will provide confirmation of subscription status to OJS\'s subscription content.',
  'plugins.generic.subscriptionSSO.settings.incomingParameterName' => 'Incoming parameter name',
  'plugins.generic.subscriptionSSO.settings.incomingParameterName.required' => 'The incoming parameter name is required and must contain only alphanumeric characters.',
  'plugins.generic.subscriptionSSO.settings.verificationUrl' => 'Verification URL',
  'plugins.generic.subscriptionSSO.settings.verificationUrl.required' => 'The verification URL is required and must contain a valid URL.',
  'plugins.generic.subscriptionSSO.settings.resultRegexp' => 'Verification Regular Expression',
  'plugins.generic.subscriptionSSO.settings.resultRegexp.required' => 'The verification regular expression is a required field and must contain a valid regular expression.',
  'plugins.generic.subscriptionSSO.settings.redirectUrl' => 'Redirect URL',
  'plugins.generic.subscriptionSSO.settings.redirectUrl.required' => 'The redirect URL is required and must contain a valid URL.',
  'plugins.generic.subscriptionSSO.settings.hoursValid' => 'Hours Valid',
  'plugins.generic.subscriptionSSO.settings.hoursValid.required' => 'The maximum number of hours the session is valid must be an integer.',
); ?>