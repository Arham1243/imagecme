<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function cases(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::create()->month($month)->shortMonthName];
        });

        $casesPerMonth = DiagnosticCase::selectRaw('MONTH(created_at) as month, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($case) {
                return [$case->month => (int) $case->total_cases];
            });

        $casesData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesPerMonth) {
            return [$shortMonthName => $casesPerMonth[$month] ?? 0];
        });

        $casesBySpecialty = DiagnosticCase::selectRaw('MONTH(created_at) as month, diagnosed_disease, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'diagnosed_disease')
            ->orderBy('month')
            ->get();

        $specialties = $casesBySpecialty->pluck('diagnosed_disease')->unique();

        $specialtyData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesBySpecialty, $specialties) {
            $monthData = $specialties->mapWithKeys(function ($specialty) use ($casesBySpecialty, $month) {
                $case = $casesBySpecialty->first(function ($c) use ($month, $specialty) {
                    return $c->month == $month && $c->diagnosed_disease == $specialty;
                });

                return [$specialty => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        $casesByType = DiagnosticCase::selectRaw('MONTH(created_at) as month, case_type, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'case_type')
            ->orderBy('month')
            ->get();

        $specialties = $casesByType->pluck('case_type')->unique();

        $caseTypeData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByType, $specialties) {
            $monthData = $specialties->mapWithKeys(function ($type) use ($casesByType, $month) {
                $case = $casesByType->first(function ($c) use ($month, $type) {
                    return $c->month == $month && $c->case_type == $type;
                });

                return [getRelativeType($type) => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        return view('admin.analytics.cases', compact('caseTypeData', 'casesData', 'specialtyData', 'year', 'months'))->with('title', 'Analytics');
    }

    public function users(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::create()->month($month)->shortMonthName];
        });

        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($case) {
                return [$case->month => (int) $case->total_cases];
            });

        $usersData = $months->mapWithKeys(function ($shortMonthName, $month) use ($usersPerMonth) {
            return [$shortMonthName => $usersPerMonth[$month] ?? 0];
        });

        $usersByspeciality = User::selectRaw('MONTH(created_at) as month, speciality, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'speciality')
            ->orderBy('month')
            ->get();

        $specialties = $usersByspeciality->pluck('speciality')->unique();

        $specialtyData = $months->mapWithKeys(function ($shortMonthName, $month) use ($usersByspeciality, $specialties) {
            $monthData = $specialties->mapWithKeys(function ($speciality) use ($usersByspeciality, $month) {
                $case = $usersByspeciality->first(function ($c) use ($month, $speciality) {
                    return $c->month == $month && $c->speciality == $speciality;
                });

                return [$speciality => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        $casesByRole = User::selectRaw('MONTH(created_at) as month, role, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'role')
            ->orderBy('month')
            ->get();

        $specialties = $casesByRole->pluck('role')->unique();

        $userRoleData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByRole, $specialties) {
            $monthData = $specialties->mapWithKeys(function ($type) use ($casesByRole, $month) {
                $case = $casesByRole->first(function ($c) use ($month, $type) {
                    return $c->month == $month && $c->role == $type;
                });

                return [$type => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        return view('admin.analytics.users', compact('userRoleData', 'usersData', 'specialtyData', 'year', 'months'))->with('title', 'Analytics');
    }

    public function usersSpecific()
    {
        $users = User::where('status', 'active')->latest()->get();

        return view('admin.analytics.users-specific')->with('title', 'Analytics')->with(compact('users'));
    }

    public function userSpecificCharts(Request $request, $id)
    {
        $user = User::find($id);

        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::create()->month($month)->shortMonthName];
        });

        // Get the user's cases and filter them by user_id
        $casesPerMonth = $user->cases() // Use the user's `cases()` relationship
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($case) {
                return [$case->month => (int) $case->total_cases];
            });

        $casesData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesPerMonth) {
            return [$shortMonthName => $casesPerMonth[$month] ?? 0];
        });

        // Get the user's cases by specialty
        $casesBySpecialty = $user->cases() // Use the user's `cases()` relationship
            ->selectRaw('MONTH(created_at) as month, diagnosed_disease, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'diagnosed_disease')
            ->orderBy('month')
            ->get();

        $specialties = $casesBySpecialty->pluck('diagnosed_disease')->unique();

        $specialtyData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesBySpecialty, $specialties) {
            $monthData = $specialties->mapWithKeys(function ($specialty) use ($casesBySpecialty, $month) {
                $case = $casesBySpecialty->first(function ($c) use ($month, $specialty) {
                    return $c->month == $month && $c->diagnosed_disease == $specialty;
                });

                return [$specialty => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        // Get the user's cases by type
        $casesByType = $user->cases() // Use the user's `cases()` relationship
            ->selectRaw('MONTH(created_at) as month, case_type, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'case_type')
            ->orderBy('month')
            ->get();

        $caseTypes = $casesByType->pluck('case_type')->unique();

        $caseTypeData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByType, $caseTypes) {
            $monthData = $caseTypes->mapWithKeys(function ($type) use ($casesByType, $month) {
                $case = $casesByType->first(function ($c) use ($month, $type) {
                    return $c->month == $month && $c->case_type == $type;
                });

                return [getRelativeType($type) => $case ? $case->total_cases : 0];
            });

            return [$shortMonthName => $monthData];
        });

        return view('admin.analytics.user-specific', compact('caseTypeData', 'casesData', 'specialtyData', 'year', 'months'))->with('title', 'Analytics');
    }
}
