<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function cases(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $year = $request->input('year', date('Y'));

        $months = collect(range(1, 12))->mapWithKeys(function ($month) {
            return [$month => Carbon::create()->month($month)->shortMonthName];
        });

        $casesPerMonth = $user->cases()->selectRaw('MONTH(created_at) as month, COUNT(*) as total_cases')
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

        $reviewedCases = DB::table('cases')
            ->leftJoin('comments', 'cases.id', '=', 'comments.case_id')
            ->selectRaw('MONTH(cases.created_at) as month, COUNT(DISTINCT cases.id) as reviewed_cases')
            ->whereYear('cases.created_at', $year)
            ->whereNotNull('comments.case_id')
            ->where('comments.user_id', '!=', DB::raw('cases.user_id'))
            ->whereNotIn('cases.case_type', ['share_image_diagnosis', 'ask_ai_image_diagnosis'])
            ->where('cases.user_id', $user->id)
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($case) {
                return [$case->month => (int) $case->reviewed_cases];
            });

        $unreviewedCases = DB::table('cases')
            ->leftJoin('comments', 'cases.id', '=', 'comments.case_id')
            ->selectRaw('MONTH(cases.created_at) as month, COUNT(DISTINCT cases.id) as unreviewed_cases')
            ->whereYear('cases.created_at', $year)
            ->whereNull('comments.case_id')
            ->whereNotIn('cases.case_type', ['share_image_diagnosis', 'ask_ai_image_diagnosis'])
            ->where('cases.user_id', $user->id)
            ->groupBy('month')
            ->get()
            ->mapWithKeys(function ($case) {
                return [$case->month => (int) $case->unreviewed_cases];
            });

        $commentsCasesData = $months->mapWithKeys(function ($shortMonthName, $month) use ($reviewedCases, $unreviewedCases) {
            return [
                $shortMonthName => [
                    'reviewed' => $reviewedCases[$month] ?? 0,
                    'unreviewed' => $unreviewedCases[$month] ?? 0,
                ],
            ];
        });

        $casesBySpecialty = $user->cases()->selectRaw('MONTH(created_at) as month, diagnosed_disease, COUNT(*) as total_cases')
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

        $casesByQuality = $user->cases()->selectRaw('MONTH(created_at) as month, image_quality, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'image_quality')
            ->orderBy('month')
            ->get();

        $image_qualities = $casesByQuality->pluck('image_quality')->unique();

        $qualityData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByQuality, $image_qualities) {
            $monthData = $image_qualities->mapWithKeys(function ($quality) use ($casesByQuality, $month) {
                $case = $casesByQuality->first(function ($c) use ($month, $quality) {
                    return $c->month == $month && $c->image_quality == $quality;
                });

                return [$quality => $case ? $case->total_cases : 0];
            });

            $monthDataWithNoEmptyKeys = $monthData->mapWithKeys(function ($value, $key) {
                return [empty($key) ? 'N/A' : $key => $value];
            });

            return [$shortMonthName => $monthDataWithNoEmptyKeys];
        });

        $casesByEaseOfDiagnosis = $user->cases()->selectRaw('MONTH(created_at) as month, ease_of_diagnosis, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'ease_of_diagnosis')
            ->orderBy('month')
            ->get();

        $easeOfDiagnosis = $casesByEaseOfDiagnosis->pluck('ease_of_diagnosis')->unique();

        $easeOfDiagnosisData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByEaseOfDiagnosis, $easeOfDiagnosis) {
            $monthData = $easeOfDiagnosis->mapWithKeys(function ($ease) use ($casesByEaseOfDiagnosis, $month) {
                $case = $casesByEaseOfDiagnosis->first(function ($c) use ($month, $ease) {
                    return $c->month == $month && $c->ease_of_diagnosis == $ease;
                });

                return [$ease => $case ? $case->total_cases : 0];
            });

            $monthDataWithNoEmptyKeys = $monthData->mapWithKeys(function ($value, $key) {
                return [empty($key) ? 'N/A' : $key => $value];
            });

            return [$shortMonthName => $monthDataWithNoEmptyKeys];
        });

        $casesByCertainty = $user->cases()->selectRaw('MONTH(created_at) as month, certainty, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'certainty')
            ->orderBy('month')
            ->get();

        $certainty = $casesByCertainty->pluck('certainty')->unique();

        $certaintyData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByCertainty, $certainty) {
            $monthData = $certainty->mapWithKeys(function ($certainty) use ($casesByCertainty, $month) {
                $case = $casesByCertainty->first(function ($c) use ($month, $certainty) {
                    return $c->month == $month && $c->certainty == $certainty;
                });

                return [$certainty => $case ? $case->total_cases : 0];
            });

            $monthDataWithNoEmptyKeys = $monthData->mapWithKeys(function ($value, $key) {
                return [empty($key) ? 'N/A' : $key => $value];
            });

            return [$shortMonthName => $monthDataWithNoEmptyKeys];
        });

        $casesBySegment = $user->cases()->selectRaw('MONTH(created_at) as month, segment, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'segment')
            ->orderBy('month')
            ->get();

        $segment = $casesBySegment->pluck('segment')->unique();

        $segmentData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesBySegment, $segment) {
            $monthData = $segment->mapWithKeys(function ($segment) use ($casesBySegment, $month) {
                $case = $casesBySegment->first(function ($c) use ($month, $segment) {
                    return $c->month == $month && $c->segment == $segment;
                });

                return [$segment => $case ? $case->total_cases : 0];
            });

            $monthDataWithNoEmptyKeys = $monthData->mapWithKeys(function ($value, $key) {
                return [empty($key) ? 'N/A' : $key => $value];
            });

            return [$shortMonthName => $monthDataWithNoEmptyKeys];
        });

        $casesByEthnicity = $user->cases()->selectRaw('MONTH(created_at) as month, ethnicity, COUNT(*) as total_cases')
            ->whereYear('created_at', $year)
            ->groupBy('month', 'ethnicity')
            ->orderBy('month')
            ->get();

        $ethnicity = $casesByEthnicity->pluck('ethnicity')->unique();

        $ethnicityData = $months->mapWithKeys(function ($shortMonthName, $month) use ($casesByEthnicity, $ethnicity) {
            $monthData = $ethnicity->mapWithKeys(function ($ethnicity) use ($casesByEthnicity, $month) {
                $case = $casesByEthnicity->first(function ($c) use ($month, $ethnicity) {
                    return $c->month == $month && $c->ethnicity == $ethnicity;
                });

                return [$ethnicity => $case ? $case->total_cases : 0];
            });

            $monthDataWithNoEmptyKeys = $monthData->mapWithKeys(function ($value, $key) {
                return [empty($key) ? 'N/A' : $key => $value];
            });

            return [$shortMonthName => $monthDataWithNoEmptyKeys];
        });

        $imageTypes = DB::table('case_images')
            ->join('cases', 'case_images.case_id', '=', 'cases.id')
            ->join('image_types', 'case_images.type', '=', 'image_types.id')
            ->selectRaw('MONTH(cases.created_at) as month, case_images.type, image_types.name as type_name, COUNT(case_images.id) as total_cases')
            ->where('cases.user_id', $user->id)
            ->whereYear('cases.created_at', $year)
            ->groupBy('month', 'case_images.type', 'image_types.name')
            ->orderBy('month')
            ->get();

        $imageTypeData = $months->mapWithKeys(function ($shortMonthName, $month) use ($imageTypes) {
            $monthData = $imageTypes->filter(function ($item) use ($month) {
                return $item->month == $month;
            });

            $typeData = $monthData->mapWithKeys(function ($item) {
                return [$item->type_name => $item->total_cases];
            });

            return [$shortMonthName => $typeData];
        });

        return view('user.analytics.cases', compact('commentsCasesData', 'imageTypeData', 'ethnicityData', 'segmentData', 'certaintyData', 'easeOfDiagnosisData', 'qualityData', 'casesData', 'specialtyData', 'year', 'months'))->with('title', 'Analytics');
    }

    public function casesInsights(Request $request)
    {
        $user = Auth::user();

        $year = $request->input('year', date('Y'));

        $caseViewsData = DiagnosticCase::where('user_id', $user->id) // Filter by user ID
            ->withCount(['views as total_views' => function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            }])->get()->map(function ($case) {
                return [
                    'case' => $case->diagnosis_title ?? 'N/A',
                    'views' => $case->total_views ?? 0,
                ];
            });

        $caseLikesData = DiagnosticCase::where('user_id', $user->id) // Filter by user ID
            ->withCount(['likes as total_likes' => function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            }])->get()->map(function ($case) {
                return [
                    'case' => $case->diagnosis_title ?? 'N/A',
                    'likes' => $case->total_likes ?? 0,
                ];
            });

        $caseCommentsData = DiagnosticCase::where('user_id', $user->id) // Filter by user ID
            ->withCount(['comments as total_comments' => function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            }])->get()->map(function ($case) {
                return [
                    'case' => $case->diagnosis_title ?? 'N/A',
                    'comments' => $case->total_comments ?? 0,
                ];
            });

        return view('user.analytics.cases-insights', compact('year', 'caseViewsData', 'caseLikesData', 'caseCommentsData'))->with('title', 'Analytics');
    }
}
