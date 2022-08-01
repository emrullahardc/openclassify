<?php namespace Visiosoft\CustomfieldsModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Illuminate\Support\Facades\DB;
use Visiosoft\CatsModule\Category\Contract\CategoryRepositoryInterface;

class AjaxController extends PublicController
{
    public function searchCategory(CategoryRepositoryInterface $categoryRepository)
    {
        $response = [];

        $categories = $this->searchCategoryByKeywords($this->request->q,$this->request->selected);

        foreach ($categories as $category) {
            $link = '';

            $parents = $categoryRepository->getParentCategoryById($category->id);

            krsort($parents);

            foreach ($parents as $key => $parent) {
                if ($key == 0) {
                    $link .= $parent->name . '';
                } else {
                    $link .= $parent->name . ' > ';
                }
            }

            $response[] = array(
                'id' => $category->id,
                'name' => $category->name,
                'parents' => $link,
                'slug' => $category->slug
            );
        }

        return response()->json(['category' => $response]);
    }

    public function searchCategoryByKeywords($keyword, $selected_categories = null)
    {

        $categories = DB::table('cats_category');

        if ($selected_categories) {
            $selected_categories = explode('-', $selected_categories);
            $categories = $categories->whereNotIn('cats_category.id', $selected_categories);
        }

        $categories = $categories->where('name', 'like', $keyword . '%')
            ->whereRaw('deleted_at IS NULL')
            ->leftJoin('cats_category_translations', function ($join) {
                $join->on('cats_category.id', '=', 'cats_category_translations.entry_id');
                $join->whereIn('cats_category_translations.locale', [config('app.locale'), setting_value('streams::default_locale'), 'en']);//active lang
            })->select('cats_category.*', 'cats_category_translations.name as name')
            ->orderBy('id', 'DESC')
            ->groupBy(['cats_category.id'])
            ->get();

        return $categories;
    }


}