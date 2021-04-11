# Action Class Example

An example of how to use action classes, traits and repositories to only persist (save) models if they are dirty and at 
the end of the action.

## Rationale
- Saving models should be wrapped in a transaction
- Transactions should be atomic (as small as possible)
- Laravel supports updating the model without saving
- We have in the past used code which meant models were updated multiple times
- Re-use of code from several places means models can be saved multiple times

## Proof of concept

This is a simple proof of concept on how action classes could be written to achieve atomic save operations within a database transaction which do not repeat themselves.

## Where to begin

Open app/Containers/Example/Actions/WidgetStoreAction.php and read from there tracing the code through.

## Difference between this and our normal method

- Entry point of the action class is handle() (This is in the BaseAbstractAction)
- Interface is used to define several required functions, `event()` `eventArguments()` `models()` `repositoryMap()` these define the event fired at the end of the action, the models to persist and the repositories to persist them with.

## Testing

- `vendor/bin/phpunit` (Without coverage) 
- `vendor/bin/phpunit --coverage-html logs` (With coverage)  