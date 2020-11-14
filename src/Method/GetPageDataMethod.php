<?php

namespace App\Method;

use App\Entity\PageData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Uuid;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class GetPageDataMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function apply(array $paramList = null)
    {
        $pageData = $this->entityManager->getRepository(PageData::class)
            ->findBy(['pageUid' => $paramList['page_uid']], ['createdAt' => 'desc']);

        if ($pageData === null) {
            return [];
        }

        return $this->serializer->normalize($pageData, null, [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['id'],
        ]);
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'page_uid' => new Required([
                    new NotBlank(),
                    new Uuid(),
                ]),
            ]
        ]);
    }
}