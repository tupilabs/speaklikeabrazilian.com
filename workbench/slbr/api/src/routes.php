<?php

Route::group(
	array('prefix' => 'api/v1'), function() 
	{
		Route::get('expressions/letters/{letter}', 'Slbr\Api\DefinitionController@getByLetter')->where('letter', '[a-zA-Z0-9]+');
		Route::get('expressions/newest', 'Slbr\Api\DefinitionController@getNewest');
		Route::get('expressions/{id}', 'Slbr\Api\ExpressionController@getExpression')->where('id', '[0-9]+');
		Route::get('expressions/{id}/definitions', 'Slbr\Api\DefinitionController@getDefinitions')->where('id', '[0-9]+');
		Route::get('definition', 'Slbr\Api\DefinitionController@getByExpressionText');
		Route::get('expressions/search', 'Slbr\Api\ExpressionController@searchByText');
		Route::post('expressions', 'Slbr\Api\ExpressionController@postExpression');
		Route::post('expressions/{id}/definitions', 'Slbr\Api\DefinitionController@postDefinition')->where('id', '[0-9]+');
	}
);