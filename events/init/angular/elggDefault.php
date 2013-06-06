<?php

$elggDefault = $object;

$elggDefault
	->registerDirective('elggFocusModel')
	// ->registerDirective('elggInputHtml') // Broken
	// ->registerDirective('elggResponses')
	->registerDirective('elggComments')
	// ->registerDirective('elggRiver')
	// ->registerDirective('elggRiverComment')
	// ->registerDirective('elggRiverItem')
	// ->registerDirective('elggUsers')
	->registerFilter('elggEcho')
	->registerValue('elgg', 'elgg')
	->registerService('elggDatabase', 'elgg/Database')
	->registerFactory('elggUser')
	->registerDep('ngSanitize');
