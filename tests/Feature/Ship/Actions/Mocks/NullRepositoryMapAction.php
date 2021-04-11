<?php


namespace Tests\Feature\Ship\Actions\Mocks;


use App\Containers\Example\Actions\WidgetStoreAction;
use App\Containers\Example\Models\Widget;

class NullRepositoryMapAction extends WidgetStoreAction
{
    public function repositoryMap(): array
    {
        return [
            Widget::class => null
        ];
    }
}