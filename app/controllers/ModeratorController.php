<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use \Definition;

class ModeratorController extends BaseController {

	public function getModerators()
	{
		if (!Sentry::check()){
			return Redirect::to('user/login?from=moderators');
		}
		return $this->theme->scope('moderators.home')->render();
	}

	public function getPendingExpressions()
	{
		$definition = Definition::with('expression', 'ratings')
			->where('definitions.status', '=', 1)
			->orderBy(DB::raw('RANDOM()'))
			->first();
		$args = array();
		$args['definition'] = $definition;
		return $this->theme->scope('moderators.pendingExpressions', $args)->render();
	}

	public function approveExpression()
	{
		$definitionId = Input::get('definitionId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s approved definition %d', $user->id, $definitionId));
		$definition = Definition::where('id', '=', $definitionId)->firstOrFail();
		$definition->status = 2;
		$definition->save();
		return Redirect::to('/moderators/pendingExpressions')
			->with('success', 'Definition approved!');
	}

	public function rejectExpression()
	{
		$definitionId = Input::get('definitionId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s rejected definition %d', $user->id, $definitionId));
		$definition = Definition::where('id', '=', $definitionId)->firstOrFail();
		$definition->status = 3;
		$definition->save();
		return Redirect::to('/moderators/pendingExpressions')
			->with('success', 'Definition rejected!');
	}

}