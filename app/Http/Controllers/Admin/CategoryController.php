<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        return view('category.categoryList');
    }
    public function getCategoryList(Request $request)
    {
        $input    = $request->all();
        $products = Category::query();
        if($request->get('search')){
            $products = $products->where("name", "LIKE", "%{$request->get('search')}%");
        }

        if (isset($input['need_all'])) {
            $products = $products->get();
            return $this->responseSuccess($products);
        }

        if (isset($input['category_id'])) {
            $products = $products->where("id", $input['category_id']);
            return $products->first();
        }

        $products = $products->orderBy('id', 'DESC');
        $productInfo = $products->paginate(10);

        return ['moviesData' => $productInfo];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $isExist = Category::checkCategoryNameExist($input['name']);
        if ($isExist) {
            return $this->responseError('Category Name already Exist');
        }

        $create = Category::create($input);

        return $this->responseSuccess();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Category::find($id);
        return response($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $isExist = Category::checkCategoryNameExist($input['name'], $id);
        if ($isExist) {
            return $this->responseError('Category Name already Exist');
        }

        $product=Category::find($id);
        $product->update($input);
        $product=Category::find($id);

        return $this->responseSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::where('id',$id)->delete();

        return $this->responseSuccess();
    }

}
