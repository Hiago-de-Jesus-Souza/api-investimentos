<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Investment;
use App\Repository\InvestmentRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

class WithdrawInvestmentController extends AbstractController
{
    private EntityManagerInterface $entityManager;   
    private InvestmentRepository $investmentRepository;
    
    public function __construct(InvestmentRepository $investmentRepository, EntityManagerInterface $entityManager)
    {
        $this->investmentRepository = $investmentRepository;
        $this->entityManager = $entityManager;
    }  

    #[Route('/api/investment/{investmentId}/withdraw', methods: "PUT")]
    public function withdrawInvestiment(int $investmentId)
    {
        $investment = $this->getInvestmentById($investmentId);
        
        if (!$investment) {            
            return $this->json(['error' => 'Erro: Investimento não encontrado. Verifique o ID fornecido.'], 404);
        }

        $withdrawResult = $this->calcularWithdrawal($investment);

        if ($withdrawResult['success']) {
            $this->entityManager->flush();
            return $this->json(['success' => true, 'message' => 'Saque do investimento realizado com sucesso', 'withdrawal_amount' => $withdrawResult['withdrawal_amount']]);
        } else {
            return $this->json(['error' => 'Erro ao retirar investimento: ' . $withdrawResult['message']], 400);
        }
    }    

    private function calcularWithdrawal(Investment $investment)
{
    $currentBalance = $investment->getBalance();
    $initialValue = $investment->getValue();

    $currentDate = new \DateTime();
    $startDate = $investment->getCreatedAt();
    $daysInvested = $startDate->diff($currentDate)->days;

    $monthlyInterestRate = 0.0052;  
    $earnedInterest = $initialValue * pow(1 + $monthlyInterestRate, $daysInvested / 30) - $initialValue;

    if ($earnedInterest <= 0) {
        return ['success' => false, 'message' => 'Insufficient funds for withdrawal'];
    }

    $age = (new \DateTime())->diff($investment->getCreatedAt())->y;
    $taxRate = $this->calculateTaxRate($age);

    $totalAmount = $currentBalance + $earnedInterest;

    $withdrawAmount = $totalAmount - ($earnedInterest * $taxRate);

    if ($withdrawAmount <= 0) {
        return ['success' => false, 'message' => 'Retirada não bem-sucedida devido a fundos insuficientes após dedução de impostos'];
    }

    $investment->setEarnings($investment->getEarnings() + $earnedInterest);

    return [
        'success' => true,
        'total_amount' => $totalAmount,
        'withdrawal_amount' => $withdrawAmount,
    ];
}

    private function calculateTaxRate($age)
    {
        if ($age < 1) {
            return 0.225;  
        } elseif ($age < 2) {
            return 0.185;  
        } else {
            return 0.15;   
        }
    }

    private function calcularInvestment(Investment $investment, $gain, $taxRate)
    {
        $currentBalance = $investment->getBalance();
        $currentDate = new DateTime();
        $startDate = $investment->getCreatedAt();

        $daysInvested = $startDate->diff($currentDate)->days;  
        $monthlyInterestRate = 0.0052;  
        $earnedInterest = $investment->getValue() * pow(1 + $monthlyInterestRate, $daysInvested / 30); 

        $withdrawAmount = $currentBalance - ($gain * $taxRate);

        return [
            'id' => $investment->getId(),
            'name' => $investment->getOwner()->getName(),
            'amount' => $investment->getValue(),
            'earnings' => $earnedInterest,
            'expected_balance' => $investment->getValue() + $earnedInterest,
            'withdrawal_amount' => $withdrawAmount,
            'days_invested' => $daysInvested,
        ];
    }

    private function getInvestmentById(int $investmentId)
    {
        return $this->investmentRepository->find($investmentId);
    }
}
