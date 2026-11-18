<?php

namespace App\Services;

use DateTimeImmutable;
use DomainException;

class ScholarshipSimulator
{
    /**
     * @param array<int, array{date: string, amount: int}> $earlyRepayments
     * @return array<string, mixed>
     */
    public function simulate(
        int $principal,
        float $annualRate,
        string $lendingEndMonth,
        string $repaymentStartMonth,
        array $earlyRepayments = [],
    ): array
    {
        if ($principal < 30_000) {
            throw new DomainException('返済総額は30,000円以上で入力してください。');
        }

        if ($annualRate < 0) {
            throw new DomainException('年利は0%以上で入力してください。');
        }

        $lendingEndMonthDate = DateTimeImmutable::createFromFormat('!Y-m-d', $lendingEndMonth.'-01');
        $repaymentStartMonthDate = DateTimeImmutable::createFromFormat('!Y-m-d', $repaymentStartMonth.'-01');
        if ($lendingEndMonthDate === false || $lendingEndMonthDate->format('Y-m') !== $lendingEndMonth) {
            throw new DomainException('貸与終了年月を正しく入力してください。');
        }
        if ($repaymentStartMonthDate === false || $repaymentStartMonthDate->format('Y-m') !== $repaymentStartMonth) {
            throw new DomainException('返済開始年月を正しく入力してください。');
        }

        $repaymentYears = $this->repaymentYears($principal);
        $installments = $repaymentYears * 12;
        $monthlyRate = $annualRate / 100 / 12;
        $lendingEndDate = $lendingEndMonthDate->modify('+1 month')->modify('-1 day');
        $firstPaymentMonth = $repaymentStartMonthDate->setDate(
            (int) $repaymentStartMonthDate->format('Y'),
            (int) $repaymentStartMonthDate->format('n'),
            27,
        );
        $firstPaymentDate = $this->businessPaymentDate($firstPaymentMonth);

        if ($firstPaymentDate <= $lendingEndDate) {
            throw new DomainException('返済開始年月は貸与終了年月より後に指定してください。');
        }

        $deferredInterestDays = (int) $lendingEndDate->diff($firstPaymentDate)->days;
        $deferredInterestTotal = (int) ($principal * ($annualRate / 100) * $deferredInterestDays / 365);
        $monthlyDeferredInterest = intdiv($deferredInterestTotal, $installments);
        $deferredInterestRemainder = $deferredInterestTotal - ($monthlyDeferredInterest * $installments);
        $baseMonthlyPayment = $monthlyRate === 0.0
            ? (int) ($principal / $installments)
            : (int) ($principal * $monthlyRate * (1 + $monthlyRate) ** $installments / ((1 + $monthlyRate) ** $installments - 1));
        $monthlyPayment = $baseMonthlyPayment + $monthlyDeferredInterest;

        $schedule = [];
        $balance = $principal;
        $baseDate = $repaymentStartMonthDate->setDate(
            (int) $repaymentStartMonthDate->format('Y'),
            (int) $repaymentStartMonthDate->format('n'),
            27,
        );

        for ($index = 0; $index < $installments && $balance > 0; $index++) {
            $interest = (int) ($balance * $monthlyRate);
            $date = $this->businessPaymentDate($baseDate->modify("+{$index} months"));
            $remainingInstallments = $installments - $index;

            if ($balance <= $monthlyPayment) {
                $amount = $balance + $deferredInterestRemainder;
                $schedule[] = $this->row(
                    $remainingInstallments, $balance, $date, $amount, $balance,
                    $monthlyDeferredInterest, $interest,
                    $deferredInterestRemainder - $monthlyDeferredInterest - $interest,
                    0, false,
                );
                $balance = 0;
                break;
            }

            $principalPayment = $baseMonthlyPayment - $interest;
            $balance -= $principalPayment;
            $schedule[] = $this->row(
                $remainingInstallments, $balance + $principalPayment, $date, $monthlyPayment,
                $principalPayment, $monthlyDeferredInterest, $interest, 0, $balance, false,
            );
        }

        $regularPaymentTotal = array_sum(array_column($schedule, 'amount'));

        foreach ($earlyRepayments as $earlyRepayment) {
            $this->applyEarlyRepayment(
                $schedule,
                (string) $earlyRepayment['date'],
                (int) $earlyRepayment['amount'],
                $monthlyRate,
                $monthlyPayment,
            );
        }

        $totalPaid = array_sum(array_column($schedule, 'amount'));
        $earlyPaymentCount = count(array_filter($schedule, fn (array $row): bool => $row['early']));

        return [
            'principal' => $principal,
            'annual_rate' => $annualRate,
            'lending_end_month' => $lendingEndMonth,
            'repayment_start_month' => $repaymentStartMonth,
            'deferred_interest_days' => $deferredInterestDays,
            'repayment_years' => $repaymentYears,
            'installments' => $installments,
            'monthly_payment' => $monthlyPayment,
            'regular_total' => $regularPaymentTotal,
            'total_paid' => $totalPaid,
            'savings' => $earlyPaymentCount === 0 ? 0 : $regularPaymentTotal - $totalPaid,
            'early_payment_count' => $earlyPaymentCount,
            'schedule' => $schedule,
        ];
    }

    private function repaymentYears(int $principal): int
    {
        $divisor = match (true) {
            $principal <= 200_000 => 30_000,
            $principal <= 400_000 => 40_000,
            $principal <= 500_000 => 50_000,
            $principal <= 600_000 => 60_000,
            $principal <= 700_000 => 70_000,
            $principal <= 900_000 => 80_000,
            $principal <= 1_100_000 => 90_000,
            $principal <= 1_300_000 => 100_000,
            $principal <= 1_500_000 => 110_000,
            $principal <= 1_700_000 => 120_000,
            $principal <= 1_900_000 => 130_000,
            $principal <= 2_100_000 => 140_000,
            $principal <= 2_300_000 => 150_000,
            $principal <= 2_500_000 => 160_000,
            $principal <= 3_400_000 => 170_000,
            default => null,
        };

        return $divisor === null ? 20 : intdiv($principal, $divisor);
    }

    private function businessPaymentDate(DateTimeImmutable $date): DateTimeImmutable
    {
        return match ((int) $date->format('w')) {
            0 => $date->modify('+1 day'),
            6 => $date->modify('+2 days'),
            default => $date,
        };
    }

    /** @return array<string, int|string|bool> */
    private function row(
        int $remainingCount,
        int $balance,
        DateTimeImmutable $date,
        int $amount,
        int $principal,
        int $deferredInterest,
        int $interest,
        int $remainder,
        int $balanceAfter,
        bool $early,
    ): array {
        return [
            'remaining_count' => $remainingCount,
            'balance' => $balance,
            'date' => $date->format('Y年n月j日'),
            'amount' => $amount,
            'principal' => $principal,
            'deferred_interest' => $deferredInterest,
            'interest' => $interest,
            'remainder' => $remainder,
            'balance_after' => $balanceAfter,
            'early' => $early,
        ];
    }

    /**
     * @param array<int, array<string, int|string|bool>> $schedule
     */
    private function applyEarlyRepayment(array &$schedule, string $yearMonth, int $budget, float $monthlyRate, int $minimumBudget): void
    {
        if ($budget < $minimumBudget * 2) {
            throw new DomainException('繰上返済額は月返済額の2か月分以上で入力してください。');
        }

        $targetIndex = null;
        foreach ($schedule as $index => $row) {
            if (! $row['early'] && preg_match('/^(\d{4})年(\d{1,2})月/', (string) $row['date'], $matches)
                && sprintf('%04d-%02d', $matches[1], $matches[2]) === $yearMonth) {
                $targetIndex = $index;
                break;
            }
        }

        if ($targetIndex === null) {
            throw new DomainException("{$yearMonth} は繰上返済できる返済月ではありません。");
        }

        $target = $schedule[$targetIndex];
        $firstInterest = (int) ($target['balance'] * $monthlyRate);
        $remainingBudget = $budget - $firstInterest;
        $paidAmount = $firstInterest;
        $principalPaid = 0;
        $deferredInterestPaid = 0;
        $remainderPaid = 0;
        $coveredInstallments = 0;
        $nextBalance = 0;

        for ($index = $targetIndex; $index < count($schedule); $index++) {
            $row = $schedule[$index];
            $installment = $row['principal'] + $row['deferred_interest'] + $row['remainder'];

            if ($remainingBudget < $installment) {
                $nextBalance = $row['balance'];
                break;
            }

            $remainingBudget -= $installment;
            $paidAmount += $installment;
            $principalPaid += $row['principal'];
            $deferredInterestPaid += $row['deferred_interest'];
            $remainderPaid += $row['remainder'];
            $coveredInstallments++;
        }

        $targetDate = $this->dateFromJapanese((string) $target['date']);
        $schedule[$targetIndex] = [
            ...$target,
            'amount' => $paidAmount,
            'principal' => $principalPaid,
            'deferred_interest' => $deferredInterestPaid,
            'interest' => $firstInterest,
            'remainder' => $remainderPaid,
            'balance_after' => $nextBalance,
            'early' => true,
        ];

        if ($coveredInstallments > 1) {
            array_splice($schedule, $targetIndex + 1, $coveredInstallments - 1);
            $shiftedDate = $targetDate->modify('+1 month');

            for ($index = $targetIndex + 1; $index < count($schedule); $index++) {
                $schedule[$index]['date'] = $this->businessPaymentDate($shiftedDate)->format('Y年n月j日');
                $shiftedDate = $shiftedDate->modify('+1 month');
            }
        }
    }

    private function dateFromJapanese(string $date): DateTimeImmutable
    {
        preg_match('/^(\d{4})年(\d{1,2})月(\d{1,2})日$/', $date, $matches);

        return new DateTimeImmutable(sprintf('%04d-%02d-27', $matches[1], $matches[2]));
    }
}
