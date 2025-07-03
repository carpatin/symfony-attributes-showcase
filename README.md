# Pet Your Pet

Controller: `App\Controller\PetYourPetController`

URL's:

- GET  https://localhost:8000/pets/ - listing of pets and their status
- GET  https://localhost:8000/pets/{name} - single pet status page + controls for commands
- POST https://localhost:8000/pets/pet - execute petting command based on POSTed form data

Showcased Symfony features:

- `#[MapQueryParameter]` for mapping route parameters to arguments in a GET request controller, including validations.
- `#[Route('/{name:pet}', name: 'app_petyourpet_status', methods: ['GET'])]` for mapped route parameters for argument
  `Pet $pet`.
- `#[MapRequestPayload]` for mapping entire POST request body to a DTO, including nested DTOs.
- `#[AutowireLocator]` for defining a custom service locator and autowiring services by their class name mapped by
  string keys.
- `#[MapEntityByPayloadField]` a custom attribute that extends `#[ValueResolver]` and allows loading and mapping a given
  entity to a controller argument based on a configured field and value in the request body.
- `#[AsTargetedValueResolver]` used for setting an alias for our custom value resolver used by
  `#[MapEntityByPayloadField]`
- `#[Required]` together with `#[Autowire('@monolog.logger.pet_your_pet')]` used in a trait that adds a getter and sets
  up getter injection for any using class, with custom logger.
- Use of Pagerfanta pagination for simple pagination of pets listing.

# Text Beautify

Controller: `App\Controller\TextBeautifyController`

URL's:

TODO

# Daily Quote

Controller: `App\Controller\TextBeautifyController`

URL's:

TODO
