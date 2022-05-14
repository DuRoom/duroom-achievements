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

use DuRoom\Achievements\Api\Serializers\AchievementSerializer;
use DuRoom\Achievements\Achievement;
use DuRoom\Achievements\AchievementUser;
use DuRoom\Achievements\AchievementValidator;
use DuRoom\Api\Controller\AbstractShowController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateAchievementController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = AchievementSerializer::class;

    /**
     * @var AchievementValidator
     */
    protected $validator;

    /**
     * @param AchievementValidator $validator
     *
     * @return void
     */
    public function __construct(AchievementValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $id = Arr::get($request->getQueryParams(), 'id');
        $ach = Achievement::find($id);
        $data = Arr::get($request->getParsedBody(), 'data', []);
        $attributes = Arr::get($data, 'attributes', []);
        

        // app('log')->error(print_r(isset($attributes['new']),TRUE));
        if (isset($attributes['new'])) {
            $achuser = AchievementUser::where("achievement_id",$id)
                ->where("user_id",Arr::get($attributes,"user_id"))
                ->update(['new' => 0]);
            return $ach;
        }

        

        $request->getAttribute('actor')->assertCan('administrate');

        if (isset($attributes['name'])) {
            $ach->name = Arr::get($attributes,"name");
            $ach->description = Arr::get($attributes,"description");
            $ach->computation = Arr::get($attributes,"computation");
            $ach->points = Arr::get($attributes,"points");
            $ach->image = Arr::get($attributes,"image");
            $ach->rectangle = Arr::get($attributes,"rectangle");
            $ach->active = Arr::get($attributes,"active");
            $ach->hidden = Arr::get($attributes,"hidden");
        }

        $this->validator->assertValid($ach->getDirty());

        $ach->save();

        return $ach;
    }
}