<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::child()->when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.subcategories.index', compact('categories'));

    }//end of index

    public function create()
    {
        $categories = Category::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.subcategories.create', compact('categories'));

    }//end of create

    public function store(Request $request)
    {
        // return $request;

        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')],
            'slug' => ['required', Rule::unique('categories', 'slug')],
            'parent_id' => ['required', Rule::exists('categories', 'id')]];

        }//end of foreach

        if(!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        $request->validate($rules);

        // dd($request->all());

        try{
            Category::create($request->all());
            // Category::create($request->except('_token'));
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.subcategories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.subcategories.index');
        }//end of try
    }//end of store

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.subcategories.edit', compact('category', 'categories'));
    }//end of edit

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $rules = [];

        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.name' => ['required', Rule::unique('category_translations', 'name')->ignore($category->id, 'category_id')],
                                'slug' => ['required', Rule::unique('categories', 'slug')->ignore($category->id)],
                                'parent_id' => ['required', Rule::exists('categories', 'id')]];
        }//end of foreach

        $request->validate($rules);

        if(!$request->has('is_active'))
            $request->request->add(['is_active' => 0]);
        else
            $request->request->add(['is_active' => 1]);

        // dd($request->all());

        try{
            $category->update($request->all());
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('dashboard.subcategories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.subcategories.index');
        }//end of try
    }//end of update

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        try{
            $category->delete();
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('dashboard.subcategories.index');
        } catch(\Exception $ex){
            session()->flash('success', __('site.try_again'));
            return redirect()->route('dashboard.subcategories.index');
        }//end of try
    }//end of destroy
}//end of controller
