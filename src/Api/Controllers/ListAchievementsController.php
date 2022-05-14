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

use DuRoom\Api\Controller\AbstractListController;
use DuRoom\Achievements\Api\Serializers\AchievementSerializer;
use DuRoom\Achievements\Achievement;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListAchievementsController extends AbstractListController
{
    /**
     * @var AchievementSerializer
     */
    public $serializer = AchievementSerializer::class;

    /**
     * @param ServerRequestInterface $request
     * @param Document               $document
     *
     * @return mixed
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = $request->getAttribute('actor');
        $include = $this->extractInclude($request);

        //$actor->assertCan('administrate');

        $ach = Achievement::query()->whereVisibleTo($actor)->get();

        return $ach->load($include);
    }
}