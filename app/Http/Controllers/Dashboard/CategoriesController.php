<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if(Gate::denies('categories.view')){
            abort(403);
        }
        $request=request();
        $categories = Category::with('parent')
        /*leftjoin('category as parents','parents.id','=','categories.parent_id')
        ->select([
        'categories.*',
        'parents.name as parent_name'
        ])*/
        ->withCount([
            'products as products_number'=>function($query)
            {
                $query->where('status','=','active');
            }
            ])
        ->filter($request->query())
        ->orderBy('categories.name')
        ->paginate(); //return collection class - object not array but deal with it as array
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image'] =$this->uploadimage($request);
   

        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::findOrFail($id);
        return view ('dashboard.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findorFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Record not found!');
        }

        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })
            ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));
        $category = Category::findorFail($id);
        $old_image=$category->image;
        $data = $request->except('image');

        $new_image =$this->uploadimage($request);
        if($new_image){
            $data['image']=$new_image;
        }
        if($old_image && $new_image){
            Storage::disk('public')->delete($old_image);
        }
        $category->update($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $category=Category::findorFail($id);
         $category->delete();//don't delete object but delete data from data base

          //Category::destroy($id);

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted');
    }
    protected function uploadimage(Request $request){

        if (!$request->hasFile('image')) {
        return;
        }
            $file = $request->file('image'); //uploaded file object
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            return $path;
        
    }
    public function trash()
    {
        $categories=Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }
    
    public function restore(Request $request,$id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success','Category restore');
    }
    public function forcedelete($id)
    {
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if($category->image)
        {
              Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success','Category deleted forever');
    }
}
