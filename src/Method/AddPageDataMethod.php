<?php


namespace App\Method;


use App\Entity\PageData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Uuid;
use Yoanm\JsonRpcParamsSymfonyValidator\Domain\MethodWithValidatedParamsInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class AddPageDataMethod implements JsonRpcMethodInterface, MethodWithValidatedParamsInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(array $paramList = null): array
    {
        $pageData = new PageData();
        $pageData
            ->setName($paramList['name'])
            ->setNotes($paramList['notes'])
            ->setPageUid($paramList['page_uid'])
            ->setCreatedAt(new \DateTime('now'));

        $this->entityManager->persist($pageData);
        $this->entityManager->flush();

        return ['success' => true];
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'name' => new Required([
                    new NotBlank(),
                ]),
                'notes' => new Required([
                    new NotBlank(),
                ]),
                'page_uid' => new Required([
                    new NotBlank(),
                    new Uuid()
                ])
            ]
        ]);
    }
}