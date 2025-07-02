- `#[Autowire]` - used for choosing specific service while type-hinting with the interface (
  `App\Controller\DailyQuoteController::liked()`)
- `#[Autowire]` - used for binding non-service arguments (TODO)
- `#[AsAlias]` - used for choosing what concrete service will be injected when type-hinting with the interface (
  `App\Quote\RandomSelector`)
- `#[AsDecorator]` - used to configure that a service decorates and replaces another one sharing the same interface (
  `App\Quote\AuthorBioEnrichDecorator` and `App\Quote\TitleCaseLettersDecorator`)
