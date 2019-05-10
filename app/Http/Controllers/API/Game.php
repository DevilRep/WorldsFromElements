<?php

namespace App\Http\Controllers\API;

use App\Models\AvailableElement;
use App\Models\InitialElement;
use App\Services\Elements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Game extends Controller
{
    public function store()
    {
        $initial_elements = array_column(InitialElement::all()->all(), null, 'element_id');
        AvailableElement::whereNotIn('element_id', array_keys($initial_elements))->delete();
        $available = array_column(AvailableElement::all()->all(), null, 'element_id');
        foreach ($initial_elements as $element) {
            if (isset($available[$element->element_id])) {
                continue;
            }
            AvailableElement::create(['element_id' => $element->element_id]);
        }
        return response()->json(AvailableElement::with('element')->get()->map(function ($record) {
            return $record->element;
        }));
    }

    public function index(Elements $element_service)
    {
        $elements = AvailableElement::with('element')->get()->map(function ($record) {
            return $record->element;
        });
        $initial_count = InitialElement::query()->count();
        $created_count = $element_service->createdElementsCount();
        $recipes_count = $element_service->recipesCount();
        return response()->json([
            'end' => $created_count === $recipes_count,
            'new' => count($elements) === $initial_count,
            'progress' => [
                'current' => $created_count,
                'all' => $recipes_count
            ]
        ]);
    }
}
