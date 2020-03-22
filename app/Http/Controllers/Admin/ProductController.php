<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Validator;
use App\Helpers\ArrayHelper;

class ProductController extends BaseController
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
        return view('product.productList');
    }

    public function getProductList(Request $request)
    {
        $input    = $request->all();
        $pageSize = array_get($input, 'page_size', 10);
        $products = Product::query();
        if($request->get('search')){
            $category = Category::where("name", "LIKE", "%{$request->get('search')}%")->first();
            if(!empty($category)) {
                $products = $products->where('category_id', $category->id);
            }
            $products = $products->where("name", "LIKE", "%{$request->get('search')}%");
        }

        if (isset($input['product_id'])) {
            $products = $products->where("id", $input['product_id']);
            return $this->responseSuccess($products->first());
        }

        $productInfo = $products->orderBy('id', 'DESC');
        $productInfo = $products->paginate($pageSize);

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
        $isExist = Product::checkProductNameExist($input['name']);
        if ($isExist) {
            return $this->responseError('Product Name already Exist');
        }

        $input['featured'] = isset($input['featured']) ? (($input['featured'] == 'on') ? 1 : 0) : 0;
        $create = Product::create($input);

        return response($create);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
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
        $isExist = Product::checkProductNameExist($input['name'], $id);
        if ($isExist) {
            return $this->responseError('Product Name already Exist');
        }

        $input['featured'] = isset($input['featured']) ? (($input['featured'] == 'on') ? 1 : 0) : 0;
        $product=Product::find($id);

        $product->update($input);
        $product=Product::find($id);

        return response($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $isDelete = Product::where('id',$id)->delete();
        if ($isDelete)
            return $this->responseSuccess();

        return $this->responseError([], 'Something Went wrong');
    }

    /**
     * Image upload.
     *
     * @param Request $_FILES
     * @return string
     * @author Chigs Patel <info@webnappdev.in>
     * @Date 3rd Nov 2018
     */
    public function imageUpload(Request $request)
    {
        $image           = [];
        $validExtensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt'); // valid extensions
        $basePath        = url('uploads'); // upload directory
        $path            = public_path('/uploads'); // upload directory
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $this->validateMsg = $validator->errors()->all();
            $image['code'] = -1;
            $image['msg'] = implode(",", $this->validateMsg);
            return $image;
        }

        if($_FILES['image'])
        {
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $finalImage = rand(1000,1000000).$img;
            $finalImage = array_first(ArrayHelper::fileSeoName([$finalImage]));
        // check's valid format
            if(in_array($ext, $validExtensions)) 
            { 
                $path = $path."/".strtolower($finalImage); 
                if(move_uploaded_file($tmp, $path)) 
                {
                    $image['code'] = 0;
                    $image['data']['image_name'] = "/uploads/".$finalImage;
                    $image['data']['image_path'] = $basePath."/".$finalImage;
                }
            }

            return $image;
        }
    }

}
