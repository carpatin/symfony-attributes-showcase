<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Attribute\MapEntityByPayloadField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

//// This attribute is available since Symfony 6.3
// It's purpose is to:
// 1. Registers the value resolver (tags the service) with an alias 'entity_by_payload_field'
//    Ensures only called when explicitly referenced: in our case from the custom attribute,
//    but generally you can directly reference a value resolver through #[ValueResolver('the_alias')]
// 2. Prevents global invocation: Symfony won't even consider this resolver unless it’s explicitly targeted.
//    That’s a big performance and clarity win.
// 3. Using an alias also helps when using directly #[ValueResolver('the_alias')] from controllers, since the multiple
//    occurrences of the attribute will reference the alias and not couple to a class full name.
#[AsTargetedValueResolver('entity_by_payload_field')]
class MapEntityByPayloadFieldValueResolver implements ValueResolverInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
        //
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        // get the attribute of our custom type from the argument metadata
        $attribute = $argument->getAttributes(MapEntityByPayloadField::class)[0] ?? null;
        if (!$attribute instanceof MapEntityByPayloadField) {
            // skip resolving altogether if we could not find our supported attribute
            return [];
        }

        // get the request body as an input bag and try to find the field name provided through the attribute
        $value = $request->request->get($attribute->field);
        if (!$value) {
            return [];
        }

        // attempt loading the entity identified by the field value
        $entity = $this->entityManager
            ->getRepository($argument->getType())
            ->findOneBy([$attribute->field => $value]);

        // return the loaded entity and single array element if found
        return $entity ? [$entity] : [];
    }
}
