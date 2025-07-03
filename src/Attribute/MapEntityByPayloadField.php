<?php

declare(strict_types=1);

namespace App\Attribute;

use Attribute;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;

// Defining our own custom attribute that extends #[ValueResolver] offers us the benefit of receiving the
// field as metadata for the value resolving. This way we can implement a generic value resolver, that is able
// to use any field's value from the body as a criteria for finding an entity of the type hinted on the argument.
#[Attribute(Attribute::TARGET_PARAMETER)]
class MapEntityByPayloadField extends ValueResolver
{
    public function __construct(
        public string $field,
    ) {
        // By using the alias instead of the resolver class name, we make use of the benefits of
        // #[AsTargetedValueResolver] attribute that's set on the resolver. This makes the resolver only executed when
        // we are using this attribute to declare a controller argument.
        parent::__construct('entity_by_payload_field');
    }
}
