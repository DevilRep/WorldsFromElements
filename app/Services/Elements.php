<?php

namespace App\Services;

use App\Exceptions\ComponentsNotFound;
use App\Exceptions\ComponentsError;
use App\Exceptions\ElementNotAvailable;
use App\Exceptions\ElementNotExist;
use App\Exceptions\RecipeNotExist;
use App\Models\AvailableElement;
use App\Models\Element;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class Elements
{

    /**
     * @param array $components
     * @return mixed
     * @throws ComponentsError
     * @throws ComponentsNotFound
     * @throws ElementNotAvailable
     * @throws ElementNotExist
     * @throws RecipeNotExist
     */
    public function searchRecipe(array $components)
    {
        if (!count($components)) {
            throw new ComponentsNotFound();
        }

        if (count($components) !== 2) {
            throw new ComponentsError('There must be only two components');
        }

        $available = array_column(AvailableElement::all()->all(), null, 'element_id');
        $elements = array_column(Element::whereIn('id', $components)->get()->all(), null, 'id');
        foreach ($components as $component_id) {
            if (!isset($elements[$component_id])) {
                throw new ElementNotExist($component_id);
            }
            if (!isset($available[$component_id])) {
                throw new ElementNotAvailable($elements[$component_id]->name);
            }
        }

        $recipes_of_components = [];
        Recipe::whereIn('component_id', $components)->get()->map(function (Recipe $item) use (&$recipes_of_components) {
            if (empty($recipes_of_components[$item->component_id])) {
                $recipes_of_components[$item->component_id] = [];
            }
            $recipes_of_components[$item->component_id][] = $item->element_id;
        });

        if (count($recipes_of_components) < count($components)) {
            throw new RecipeNotExist();
        }
        $potential_recipes = array_intersect(...$recipes_of_components);
        $recipes_components_count = Recipe::groupBy('element_id')
            ->select('element_id', DB::raw('count(*) as total'))
            ->whereIn('element_id', $potential_recipes)
            ->pluck('total', 'element_id')
            ->all();

        foreach ($recipes_components_count as $element_id => $count) {
            if ($count === count($components)) {
                return $element_id;
            }
        }

        throw new RecipeNotExist();
    }
}
