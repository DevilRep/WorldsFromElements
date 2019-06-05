<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApplicationError;
use App\Exceptions\ElementNotExist;
use App\Exceptions\RecipeNotExist;
use App\Services\Elements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\{AvailableElement as AvailableElementModel};

class AvailableElement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->availableElements($request);
    }

    public function store(Request $request, Elements $element_service)
    {
        try {
            $new_element_id = $element_service->searchRecipe($request->components);
            AvailableElementModel::firstOrCreate([
                'element_id' => $new_element_id,
                'user_id' => $request->user()->id
            ]);
            return $this->availableElements($request);
        } catch (ElementNotExist $e) {
            return response()
                ->json(['message' => $e->getMessage()], 404);
        } catch (RecipeNotExist $e) {
            return response()
                ->json(['message' => $e->getMessage()], 404);
        } catch (ApplicationError $e) {
            return response()
                ->json(['message' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()
                ->json(['message' => $e->getMessage()], 500);
        }
    }

    protected function availableElements(Request $request)
    {
        return response()
            ->json(
                AvailableElementModel::with('element')
                    ->where('user_id', $request->user()->id)
                    ->get()
                    ->map(function ($record) {
                        return $record->element;
                    })
            );
    }
}
