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

use DuRoom\Achievements\Api\Serializers\AchievementUserSerializer;
use DuRoom\Achievements\Achievement;
use DuRoom\Achievements\AchievementUser;
use DuRoom\Achievements\AchievementValidator;
use DuRoom\Api\Controller\AbstractShowController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateAchievementUserController extends AbstractShowController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = AchievementUserSerializer::class;

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
        
        $data = Arr::get($request->getParsedBody(), 'data', []);
        $attributes = Arr::get($data, 'attributes', []);

        if (isset($attributes['new'])) {
            $achuser = AchievementUser::where("id",$id)
                ->where("user_id",Arr::get($attributes,"user_id"))
                ->update(['new' => $attributes['new']]);
            
            return $achuser;
        }
    }
}