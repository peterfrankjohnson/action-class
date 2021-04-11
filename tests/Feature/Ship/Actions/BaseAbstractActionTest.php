<?php


namespace Tests\Feature\Ship\Actions;


use App\Containers\Example\Models\Widget;
use App\Ship\Exceptions\Actions\BaseRepositoryInterfaceException;
use App\Ship\Exceptions\Actions\NullRepositoryException;
use Tests\BaseTestCase;

class BaseAbstractActionTest extends BaseTestCase
{
    public function testRepositoryMapThrowsExceptionIfRepositoryDoesNotImplementBaseRepositoryInterface()
    {
        $this->expectException(BaseRepositoryInterfaceException::class);

        $widgetUpdateAction = app()->makeWith(Mocks\BrokenRepositoryMapAction::class);
        $widget             = $widgetUpdateAction->handle(new Widget());
    }

    public function testNullRepositoryMapThrowsException()
    {
        $this->expectException(NullRepositoryException::class);

        $widgetUpdateAction = app()->makeWith(Mocks\NullRepositoryMapAction::class);
        $widget             = $widgetUpdateAction->handle(new Widget());
    }
}