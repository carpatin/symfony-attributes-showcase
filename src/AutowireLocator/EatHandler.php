<?php

declare(strict_types=1);

namespace App\AutowireLocator;

use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('app.action_handler')]
class EatHandler
{
    public function doAction(): string
    {
        return 'Handling eat 🍽️ request...';
    }
}
