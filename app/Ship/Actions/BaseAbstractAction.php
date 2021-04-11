<?php

namespace App\Ship\Actions;

use App\Ship\Exceptions\Actions\BaseRepositoryInterfaceException;
use App\Ship\Exceptions\Actions\NullRepositoryException;
use App\Ship\Interfaces\Actions\BaseActionInterface;
use App\Ship\Interfaces\Repositories\BaseRepositoryInterface;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Log;

abstract class BaseAbstractAction implements BaseActionInterface
{
    public function handle()
    {
        // preRun()
        $this->preRun();

        // run()
        $returnValue = call_user_func_array([$this, 'run'], func_get_args());

        // postRun()
        $this->postRun();

        return $returnValue;
    }

    public function preRun()
    {

    }

    /**
     * Action Class postRun()
     *
     * This is used to persist the models and fire the event once the action has been ran.
     *
     */
    public function postRun()
    {
        // Persist all of the models in the models Collection if they are dirty
        $this->persistModels();

        // Fire the event
        $this->fireEvent();
    }

    /**
     * Persist the models that have been provided
     */
    private function persistModels()
    {
        // Log the model being persisted (if in debug mode)
        if (config('app.debug')) {
            Log::debug(get_class($this) . ": persistModels()");
        }

        DB::transaction(function () {
            // Fetch the models to be persisted
            $models = $this->models();

            // Iterate over the models collection and call the persistModel function on each Model in the collection
            $models->each(Closure::fromCallable([$this, 'persistModel']));
        });
    }

    /**
     * Fire the defined event
     */
    private function fireEvent()
    {
        // Log the model being persisted (if in debug mode)
        if (config('app.debug')) {
            Log::debug(get_class($this) . ": fireEvent()");
        }

        // Fetch the event class name
        $eventClassName = $this->event();

        // Has the event class has been defined
        if (class_exists($eventClassName)) {
            // Create the Event with the provided arguments
            $event = app()->makeWith($eventClassName, $this->eventArguments());

            // Log the event firing (if in debug mode)
            if (config('app.debug')) {
                Log::debug(get_class($this) . ": Firing Event: {$eventClassName}");
            }

            // Fire the event
            event($event);
        }
    }

    /**
     * Persist (Save) the model if it is found to be dirty.
     *
     * @param Model $model
     * @throws Exception
     */
    private function persistModel(Model $model)
    {
        $repositoryMap = $this->repositoryMap();

        $modelClass = get_class($model);
        $repository = Arr::get($repositoryMap, $modelClass);

        if (null === $repository) {
            throw new NullRepositoryException(get_class($this) . ": Repository for {$modelClass} not found in repositoryMap()");
        }

        if (!($repository instanceof BaseRepositoryInterface)) {
            throw new BaseRepositoryInterfaceException(get_class($this) . ": Repository for {$modelClass} does not implement BaseRepositoryInterface");
        }

        // Check if the model is dirty
        if ($repository->isDirty($model)) {
            // Log the model being persisted (if in debug mode)
            if (config('app.debug')) {
                Log::debug("Persisting Model: {$modelClass}");
            }

            // If so then persist (save) the model
            $repository->persist($model);
        }
    }
}