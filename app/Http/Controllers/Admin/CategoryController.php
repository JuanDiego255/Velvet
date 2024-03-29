<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    protected $expirationTime;

    public function __construct()
    {
        // Define el tiempo de expiración en minutos
        $this->expirationTime = 60; // Por ejemplo, 60 minutos
    }
    public function index()
    {
        $categories = Cache::remember('categories', $this->expirationTime, function () {
            return Categories::simplePaginate(8);
        });
        
        return view('admin.categories.index', compact('categories'));
    }
    public function add()
    {
        return view('admin.categories.add');
    }
    public function edit($id)
    {
        $categories = Cache::remember('category_' . $id, $this->expirationTime, function () use ($id) {
            return Categories::find($id);
        });
        
        return view('admin.categories.edit', compact('categories'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $category =  new Categories();
            if ($request->hasFile('image')) {
                $category->image = $request->file('image')->store('uploads', 'public');
            }
            $category->name = $request->name;
            $category->slug = $request->name;
            $category->description = $request->description;
            $category->status = $request->status == "1" ? '1' : '0';
            $category->popular = $request->popular == "1" ? '1' : '0';
            $category->meta_title = $request->meta_title;
            $category->meta_descrip = $request->meta_descrip;
            $category->meta_keywords = $request->meta_keywords;
            $category->save();
            DB::commit();
            return redirect('/categories')->with(['status' => 'Categoría Agregada Exitosamente!', 'icon' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/categories')->with(['status' => 'Ocurrió un error al agregar la categoría!', 'icon' => 'error']);
        }
    }
    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $category = Categories::findOrfail($id);
            $category->name = $request->name;
            $category->slug = $request->name;
            $category->description = $request->description;
            $category->status = $request->status == "1" ? '1' : '0';
            $category->popular = $request->popular == "1" ? '1' : '0';
            $category->meta_title = $request->meta_title;
            $category->meta_descrip = $request->meta_descrip;
            $category->meta_keywords = $request->meta_keywords;
            if ($request->hasFile('image')) {

                Storage::delete('public/' . $category->image);
                $image = $request->file('image')->store('uploads', 'public');
                $category->image = $image;
            }
            $category->update();
            DB::commit();
            return redirect('categories')->with(['status', 'Categoría Editada Exitosamente!', 'icon' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/categories')->with(['status' => 'Ocurrió un error al editar la categoría!', 'icon' => 'error']);
        }
    }
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $category = Categories::findOrfail($id);
            $category_name = $category->name;
            if (
                Storage::delete('public/' . $category->image)

            ) {
                Categories::destroy($id);
            }
            Categories::destroy($id);
            DB::commit();
            return redirect()->back()->with(['status'  =>  '(' . $category_name . ') se ha borrado la categoría con éxito', 'icon' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/categories')->with(['status' => 'Ocurrió un error al eliminar la categoría!', 'icon' => 'error']);
        }
    }
}
