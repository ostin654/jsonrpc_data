<?php


namespace App\Method;


use App\Entity\PageData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Positive;
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
            ->setNumber($paramList['number'])
            ->setPageUid($paramList['page_uid'])
            ->setCreatedAt(new \DateTime('now'))
            ->setUpdatedAt(new \DateTime('now'));

        $this->entityManager->persist($pageData);
        $this->entityManager->flush();

        return ['success' => true];
    }

    public function getParamsConstraint(): Constraint
    {
        return new Collection([
            'fields' => [
                'name' => new Required([
                    new Length(['min' => 3])
                ]),
                'notes' => new Optional(),
                'number' => new Optional([
                    new Positive()
                ]),
                'page_uid' => new Required([
                    new NotBlank(),
                    new Uuid()
                ])
            ]
        ]);
    }
}