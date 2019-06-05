<?php

namespace App\Http\Controllers\API;

use App\Models\AvailableElement;
use App\Models\InitialElement;
use App\Services\Elements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Game extends Controller
{
    public function store(Request $request)
    {
        $initial_elements = array_column(InitialElement::all()->all(), null, 'element_id');
        AvailableElement::whereNotIn('element_id', array_keys($initial_elements))->delete();
        $available = array_column(AvailableElement::all()->all(), null, 'element_id');
        foreach ($initial_elements as $element) {
            if (isset($available[$element->element_id])) {
                continue;
            }
            AvailableElement::create([
                'element_id' => $element->element_id,
                'user_id' => $request->user()->id
            ]);
        }
        return response()->json(
            AvailableElement::with('element')
                ->where('user_id', $request->user()->id)
                ->get()
                ->map(function ($record) {
            return $record->element;
        })
        );
    }

    public function index(Request $request, Elements $element_service)
    {
        $elements = AvailableElement::with('element')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(function ($record) {
            return $record->element;
        });
        $initial_count = InitialElement::query()->count();
        $created_count = $element_service->createdElementsCount($request->user());
        $recipes_count = $element_service->recipesCount();
        return response()->json([
            'end' => $created_count === $recipes_count,
            'new' => count($elements) === $initial_count,
            'progress' => [
                'current' => $created_count,
                'max' => $recipes_count
            ]
        ]);
    }
}
