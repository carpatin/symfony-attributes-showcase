# Purpose

This application's sole purpose is to showcase some features of Symfony, with emphasis on using attributes and the magic
they bring to the newer versions of Symfony.
The examples are offered for learning purposes and are by no means a statement of best practices for using the
framework.

It features:
- register page
- login page
- main landing page after login with a menu
- four sections on four unrelated topics, each with corresponding domain and features:
  - a section about taking care of pets
  - a section about showing daily quotes from famous authors
  - a section for beautifying plain text
  - a section for uploading photos in a photo album and viewing them

# Documentation

https://symfony.com/doc/current/reference/attributes.html

# Symfony attributes under a spotlight

## Doctrine Bridge

- MapEntity

## Contracts

- Required

## Dependency Injection

- AsAlias
- AsDecorator
- AsTaggedItem
- Autowire
- AutoconfigureTag
- AutowireLocator
- AutowireIterator

## Event Dispatcher

- AsEventListener

## HttpKernel

- AsTargetedValueResolver
- MapQueryParameter
- MapRequestPayload
- MapUploadedFile
- WithHttpStatus

## Routing

- Route

## Security

- CurrentUser
- IsGranted

## Validator

- Constraints\NotBlank
- Constraints\NotNull
- Constraints\Length
- Constraints\GreaterThanOrEqual
- Constraints\LessThanOrEqual
- Constraints\Expression
- Constraints\Range
- Constraints\Regex
- Constraints\Valid
- Constraints\Choice
- Constraints\File
- Constraints\Image

## Twig

- Template
- AsTwigComponent
- AsTwigFilter

# Pet Your Pet

Controller: `App\Controller\PetYourPetController`

URL's:

- GET https://localhost:8000/pets/ - listing of pets and their status
- GET https://localhost:8000/pets/{name} - single pet status page + controls for commands
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

- GET https://localhost:8000/beautify/ - listing text beautification features
- POST https://localhost:8000/beautify/plain - beautify plain text payload using a selection of algorithms
- POST https://localhost:8000/beautify/emoji - beautify text using only word-to-emoji replacers
- POST https://localhost:8000/beautify/html - beautify text by wrapping it into HTML tags
- POST https://localhost:8000/beautify/padding - beautify text by padding it with emoji/symbols

Showcased Symfony features:

- `#[AutoconfigureTag]` for tagging services either by their interface or each service class individually
- `#[AsTaggedItem]` to provide an index for iterable services and a priority for ordering them when interated
- `#[AutowireIterator]` for injecting an iterable argument of similarly tagged services
- `#[MapRequestPayload]` for mapping to a controller input argument DTO the entire submitted form data

# Daily Quote

Controller: `App\Controller\DailyQuoteController`

URL's:

- GET https://localhost:8000/daily-quote/ - listing daily quote options
- GET https://localhost:8000/daily-quote/authors - lists all quote authors paginated
- GET https://localhost:8000/daily-quote/authors/{name}/quotes - list all quotes by author name
- GET https://localhost:8000/daily-quote/quote/random - show a randomly chosen quote
- GET https://localhost:8000/daily-quote/quote/liked - show a highly liked quote
- GET https://localhost:8000/daily-quote/quote/one - show either a random quote or a highly liked one depending on
  config
- POST https://localhost:8000/daily-quote/quote/{id}/like - add a like for a quote identified by ID

Showcased Symfony features:

- The EntityValueResolver that automatically fetches the entity from the database and injects it into the controller
  method (see the controller for adding likes)
- `#[MapEntity(class: Author::class, expr: 'repository.findAllPaginated()')]` for mapping a paginator object to a
  controller argument using the variant in which the requested entity type is given and then an expression to call
  repository method to get the data
- `#[MapEntity(class: Quote::class, expr: 'repository.findByAuthorName(name)')]` same as above just that this time with
  value route parameter passed directly to repository method, in the expression
- `#[MapEntity(mapping: ['name' => 'name'])]` for mapping one entity to an argument, and find that based on a route
  parameter value. Another variant: `#[MapEntity(expr: 'repository.findOneBy({"name": name})')]`
- `#[AsAlias]` used on the service class implementing an interface to instruct DI to autowire an instance of
  this service and not others implementing the interface
- `#[Autowire(service: MostLikesSelector::class)]` for direct selection of injected service
- `#[Autowire('%env(APP_AUTHOR_NAME_PATTERN)%')]` for injecting a parameter value
- `#[Autowire(expression: 'service("App\\\\DailyQuote\\\\QuoteSelectorResolver").resolveToSelector(env("APP_QUOTE_SELECTOR"))')]`
used with an expression in which another service (a resolver) is called with env variable value to resolve the
injected argument to a certain service
- `#[AsDecorator(decorates: QuoteSelectorInterface::class, priority: 100)]` for applying a decorator pattern,
  exemplified with two decorators applied on the same service identified by its interface
- `#[WithHttpStatus(500)]` for giving an exception an HTTP code for when caught by symfony so that the status code is
  returned in the response
- use of Twig macro

# Photo Album

Controller: `App\Controller\PhotoAlbumController`

URL's:

- GET https://localhost:8000/photo-album/ - page with a grid of photos and forms to upload one or batch of photos
- POST https://localhost:8000/photo-album/upload - upload single photo using a Symfony form
- POST https://localhost:8000/photo-album/multiple-upload - upload multiple photos using attributes to map texts to DTO
  and the images to an array argument of UploadedFile objects

Showcased Symfony features:

- `#[CurrentUser]` for injecting the currently logged-in user in a controller action
- `#[IsGranted('ROLE_UPLOADER')]` for ensuring that only users with a certain role are able to perform an action
- `#[IsCsrfTokenValid]` for checking the CSRF token in our multiple upload controller, that doesn't use a Symfony form
- `#[MapUploadedFile]` for mapping a POSTed file to an UploadedFile argument, or multiple files to an iterable argument
- `#[MapRequestPayload]` for mapping the title and description fields to a DTO
- `#[AsTwigComponent]` for configuring a Twig UX component class
- `#[AsTwigFilter]` for registering a filter in our custom Twig extension
- `#[AsEventListener]` for registering the ExceptionListener to check for CSRF exception and throw instead a bad request
- use of form for one photo upload
- use of a Twig UX component for a photo grid item
- use of custom Twig filters to prepare image base64 content for img tag
