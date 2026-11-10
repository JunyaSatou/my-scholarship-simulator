<?php

namespace App\Http\Controllers;

use App\Services\ScholarshipSimulator;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScholarshipSimulationController extends Controller
{
    public function index(): View
    {
        return view('scholarships.simulator');
    }

    public function simulate(Request $request, ScholarshipSimulator $simulator): View|RedirectResponse
    {
        $validated = $request->validate([
            'principal' => ['required', 'integer', 'min:30000', 'max:100000000'],
            'annual_rate' => ['required', 'numeric', 'min:0'],
            'lending_end_month' => ['required', 'date_format:Y-m'],
            'early_repayments' => ['nullable', 'array', 'max:30'],
            'early_repayments.*.date' => ['required', 'date_format:Y-m'],
            'early_repayments.*.amount' => ['required', 'integer', 'min:1', 'max:100000000'],
        ], [], [
            'principal' => '返済総額',
            'annual_rate' => '年利',
            'lending_end_month' => '貸与終了年月',
            'early_repayments.*.date' => '繰上返済年月',
            'early_repayments.*.amount' => '繰上返済額',
        ]);

        try {
            $result = $simulator->simulate(
                (int) $validated['principal'],
                (float) $validated['annual_rate'],
                $validated['lending_end_month'],
                array_values($validated['early_repayments'] ?? []),
            );
        } catch (DomainException $exception) {
            return back()->withInput()->withErrors(['simulation' => $exception->getMessage()]);
        }

        return view('scholarships.simulator', [
            'result' => $result,
            'earlyRepayments' => $validated['early_repayments'] ?? [],
        ]);
    }
}
