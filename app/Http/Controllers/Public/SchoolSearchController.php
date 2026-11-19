<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SchoolSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'q' => ['required', 'string', 'min:2', 'max:60'],
        ]);

        if ($validator->fails()) {
            return $this->json(['message' => 'Please enter at least 2 characters.'], 422);
        }

        $term = trim($request->string('q')->toString());
        $escapedTerm = addcslashes(mb_strtolower($term), '%_\\');
        $containsPattern = "%{$escapedTerm}%";
        $startsWithPattern = "{$escapedTerm}%";

        // School has no tenant global scope; SoftDeletes remains active here,
        // so deleted schools are excluded without bypassing deletion safety.
        $schools = School::query()
            ->select(['id', 'school_name', 'slug', 'city', 'logo'])
            ->whereNotNull('registration_id')
            ->where('status', 'active')
            ->where(function ($query) use ($containsPattern) {
                $query->whereRaw('LOWER(school_name) LIKE ?', [$containsPattern]);
            })
            ->orderByRaw('CASE WHEN LOWER(school_name) LIKE ? THEN 0 ELSE 1 END', [$startsWithPattern])
            ->orderBy('school_name')
            ->limit(8)
            ->get();

        $data = $schools->map(function (School $school): array {
            $logo = null;
            if ($school->logo && Storage::disk('public')->exists($school->logo)) {
                $logo = url(Storage::disk('public')->url($school->logo));
            }

            return [
                'name' => $school->school_name,
                'location' => $school->city,
                'logo' => $logo,
                'url' => route('login'),
            ];
        })->values()->all();

        return $this->json(['data' => $data]);
    }

    private function json(array $payload, int $status = 200): JsonResponse
    {
        return response()->json($payload, $status)->header('Cache-Control', 'no-store');
    }
}
