<?php

/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Achievements;

use DuRoom\Foundation\AbstractValidator;

class AchievementValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'name' => ['required'],
    ];
}