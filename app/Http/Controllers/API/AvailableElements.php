<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApplicationError;
use App\Exceptions\ElementNotExist;
use App\Exceptions\RecipeNotExist;
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
            AvailableElement::firstOrCreate(['element_id' => $new_element_id]);
            $elements = AvailableElement::with('element')->get()->map(function ($record) {
                return $record->element;
            });
            return response()->json([
                'elements' => $elements,
                'end' => count($elements) === count($element_service->usedElements())
            ]);
        } catch (ElementNotExist $e) {
            return response()
                ->json(['error' => $e->getMessage()], 404);
        } catch (RecipeNotExist $e) {
            return response()
                ->json(['error' => $e->getMessage()], 404);
        } catch (ApplicationError $e) {
            return response()
                ->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()
                ->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function availableElements()
    {
        return response()->json(AvailableElement::with('element')->get()->map(function ($record) {
            return $record->element;
        }));
    }
}
