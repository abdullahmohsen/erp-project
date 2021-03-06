<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::parent()->when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        // $subCategories = Category::child()->when($request->search, function ($q) use ($request) {

        //     return $q->whereTranslationLike('name', '%' . $request->search . '%');

        // })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories'));

    }//end of index

    public function show($id)
    {
        $category = Category::where('id', $id)->get();
        $subcategories = Category::findOrFail($id)->where('parent_id', $id)->get();
        return view('dashboard.categories.show', compact('subcategories', 'category'));
    }//end of show

    public function create()
    {
        return view('dashboard.categories.create');

    }//end of create

    public function store(Request $request)
    {

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')],
            'slug' => ['required', Rule::unique('categories', 'slug')]];

        }//end of foreach

        if(!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $request->validate($rules);

        // dd($request->all());

        try{
            Category::create($request->all());
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.categories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.categories.index');
        }//end of try
    }//end of store

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));

    }//end of edit

    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')],
                                            'slug' => ['required', Rule::unique('categories', 'slug')->ignore($category->id)]];
        }//end of foreach

        $request->validate($rules);

        if(!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        try{
            $category->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.categories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.categories.index');
        }
    }//end of update

    public function destroy(Category $category)
    {
        try{
            $category->delete();
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('dashboard.categories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.categories.index');
        }//end of try
    }//end of destroy

}//end of controller
