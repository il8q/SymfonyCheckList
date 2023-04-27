<?php
namespace App\Service;
namespace App\Domain\CheckListContext\Infrastructure;

use App\Domain\CheckListContext\Entities\CheckList;
use App\Domain\CheckListContext\Entities\CheckListArray;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EntitySerializer
{
    private Serializer $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $datetimeNormalizer = new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i']);
        $this->serializer = new Serializer([$datetimeNormalizer, $normalizer]);
    }

    /**
     * @throws ExceptionInterface
     */
    public function serializeForList(CheckListArray $checkLists): array
    {
        return $this->serializer->normalize($checkLists, null, ['groups' => 'for_list']);
    }

    /**
     * @throws ExceptionInterface
     */
    public function serializeFull(CheckList $checkList): array
    {
        return $this->serializer->normalize($checkList, null, ['groups' => 'full']);
    }
}