<?php

/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Achievements\Api\Controllers;

use DuRoom\Achievements\Achievement;
use DuRoom\Api\Controller\AbstractDeleteController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class DeleteAchievementController extends AbstractDeleteController
{
    /**
     * {@inheritdoc}
     */
    protected function delete(ServerRequestInterface $request)
    {
        $id = Arr::get($request->getQueryParams(), 'id');
        $request->getAttribute('actor')->assertCan('administrate');

        $ach = Achievement::find($id);

        $ach->delete();

        return $ach;
    }
}