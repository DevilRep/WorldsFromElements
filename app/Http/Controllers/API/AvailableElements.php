<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApplicationError;
use App\Services\Elements;
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
        return $this->availableElements();
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
        return $this->availableElements();
    }

    public function store(Request $request, Elements $element_service)
    {
        try {
            $new_element_id = $element_service->searchRecipe($request->components);
            AvailableElement::create(['element_id' => $new_element_id]);
            return $this->availableElements();
        } catch (ApplicationError $e) {
            return response()
                ->setStatusCode(400)
                ->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return response()
                ->setStatusCode(500)
                ->json(['error' => $e->getMessage()]);
        }
    }

    protected function availableElements()
    {
        return response()->json(AvailableElement::with('element')->get()->map(function ($record) {
            return $record->element;
        }));
    }
}
