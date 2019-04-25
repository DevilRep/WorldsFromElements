<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\{AvailableElement, InitialElement};

class AvailableElements extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(AvailableElement::with('element')->get()->map(function ($record) {
                return $record->element;
            }));
    }

    public function newGame()
    {
        $initial_elements = array_column(InitialElement::all()->all(), null, 'element_id');
        AvailableElement::whereNotIn('id', array_keys($initial_elements))->delete();
        $available = array_column(AvailableElement::all()->all(), null, 'element_id');
        foreach ($initial_elements as $element) {
            if (isset($available[$element->element_id])) {
                continue;
            }
            AvailableElement::create(['element_id' => $element->element_id]);
        }
        return response()->json([
            'items' => AvailableElement::with('element')->get()->map(function ($record) {
                return $record->element;
            })
        ]);
    }
}
