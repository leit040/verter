<?php

declare(strict_types=1);

namespace app\Definitions;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="imagePath", type="string"),
 *     @OA\Property(property="tasksList", type="array",@OA\Items(type="string")),
 * )
 */
class TaskForm
{
}
