<?php

declare(strict_types=1);

namespace app\Definitions;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="imagePath", type="string"),
 *     @OA\Property(property="tasks", type="array", @OA\Items(ref="#/components/schemas/Task")),
 *     @OA\Property(property="childObjects", type="array", @OA\Items(ref="#/components/schemas/MyObjectForm")),
 * )
 */
class MyObject
{
}
