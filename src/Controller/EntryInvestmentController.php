<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Investment;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InvestmentRepository;
use DateTime;

class EntryInvestmentController extends AbstractController
{
    private EntityManagerInterface $entityManager;    
    private InvestmentRepository $investmentRepository;   

    public function __construct(InvestmentRepository $investmentRepository, EntityManagerInterface $entityManager)
    {
        $this->investmentRepository = $investmentRepository;
        $this->entityManager = $entityManager;
    }   

    #[Route('/api/investment/{investmentId}', methods: 'GET')]
    public function viewInvestment($investmentId)
    {
        $investmentId = (int) $investmentId; 

        $investment = $this->getInvestmentById($investmentId);

        if (!$investment) {
            return new JsonResponse(['error' => 'Investimento não encontrado. Verifique o identificador do investimento e tente novamente.'], 404);
        }

        $investmentDetails = $this->calcularInvestment($investment);

        return new JsonResponse(['investment_data' => $investmentDetails]);
    }

    private function getInvestmentById(int $investmentId)
    {
        return $this->investmentRepository->find($investmentId);
    }

    private function calcularInvestment(Investment $investment)
    {
        $currentDate = new DateTime();
        $startDate = $investment->getCreatedAt();

        $daysInvested = $startDate->diff($currentDate)->days;
        $annualInterestRate = 0.052;

        $earnedInterest = $investment->getValue() * (pow(1 + $annualInterestRate, $daysInvested / 365) - 1);

        $expectedBalance = $investment->getValue() + $earnedInterest;

        return [
            'id' => $investment->getId(),
            'name' => $investment->getOwner()->getName(),
            'amount' => $investment->getValue(),
            'earnings' => $earnedInterest,
            'expected_balance' => $expectedBalance,
            'days_invested' => $daysInvested,
        ];
    }
}
