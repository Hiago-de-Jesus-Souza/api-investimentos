<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Investment;
use App\Entity\Person;
use App\Repository\InvestmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Nelmio\ApiDocBundle\Annotation\Model as SWGModel;
use Nelmio\ApiDocBundle\Annotation\SWG;

class InvestmentController extends AbstractController

{
    private EntityManagerInterface $entityManager;   
    private InvestmentRepository $investmentRepository;

    public function __construct(InvestmentRepository $investmentRepository, EntityManagerInterface $entityManager){       
        $this->investmentRepository=$investmentRepository;
        $this->entityManager=$entityManager;
    }   

    #[Route('/api/investment', methods:"POST")]    
    public function createInvestiment(Request $request)
    {        
        $requestData = $request->toArray();

        $name = isset($requestData['name']) ? $requestData['name'] : null;

        $value = isset($requestData['value']) ? $requestData['value'] : null;

        $createdAt = isset($requestData['created_at']) ? new \DateTimeImmutable($requestData['created_at']) : new \DateTimeImmutable('-1 year');

        if ($name === null || $value === null) {
            return $this->json(['message' => 'Erro: Os campos "name" e "value" são obrigatórios.'], 400);
        }

        $person = new Person();
        $person->setName($name);

        $investment = new Investment();
        $investment->setValue($value);
        $investment->setCreatedAt($createdAt);

        $person->addInvestment($investment);
            
        $this->entityManager->persist($person);    
        $this->entityManager->flush();

        return $this->json(['success' => true, 'message' => 'Investment has been successfully created.']);
    }

    private function getInvestmentById(int $investmentId)
    {
        return $this->entityManager->getRepository(Investment::class)->find($investmentId);
    }
}
