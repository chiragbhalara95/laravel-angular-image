<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\File;
use Symfony\Component\HttpKernel\Tests\Debug\FileLinkFormatterTest;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\StringHelper;

class FilesController extends BaseController
{
    /**
     * Load Files View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function files()
    {
        return view('files');
    }

    /**
     * List Uploaded files
     *
     * @return array
     */
    public function listFiles()
    {
        return ['files' => File::orderBy('id', 'DESC')->get()];
    }


    /**
     * Upload new File
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            'name' => 'required|min:3',
            'image_file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {

            $errors = [];
            foreach ($validator->messages()->all() as $error) {
                array_push($errors, $error);
            }

            return response()->json(['errors' => $errors, 'status' => 400], 400);
        }

        $fileObj    = $request->file('image_file');
        $folderName = '/image_uploads/';
        $fileName   = array_get($params, 'name', pathinfo($fileObj->getClientOriginalName(), PATHINFO_FILENAME));
        $ext        = $fileObj->extension();
        $name       = StringHelper::generateFileName($fileName, $ext);
        $destinationPath = public_path($folderName);

        $file = File::create([
            'name'      => $fileName,
            'file_path' => $folderName.$name,
            'type'      => $ext,
            'size'      => $fileObj->getClientSize(),
        ]);

        $request->file('image_file')->move($destinationPath, $name);

        return response()->json(['errors' => [], 'files' => File::all(), 'status' => 200], 200);
    }

    /**
     * Delete existing file from the server
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $id   = $request->input('id');
        $file = File::find($id);
        Storage::delete(public_path($file->file_path));
        unlink(public_path($file->file_path));

        $file->delete();

        return response()->json(['errors' => [], 'message' => 'File Successfully deleted!', 'status' => 200], 200);
    }
}
