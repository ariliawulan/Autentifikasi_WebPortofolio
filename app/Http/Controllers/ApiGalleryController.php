<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ApiGalleryController extends Controller
{

    /**
    * @OA\Get(
        * path="/api/getgallery",
        * tags={"Get Data Gallery"},
        * summary="Untuk Mendapatkan Data Gallery",
        * description="Tes apakah API Gallery berjalan?",
        * operationId="GetGallery",
        
    * @OA\Response(
            * response="default",
            * description="successful operation"
        * )
    * )
    */

    public function getGallery()
    {

        $post = Post::all();
        return response()->json(["data"=>$post]);
    }

    public function index()
    {
        $data = array(
            'id' => "posts",
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=',
           '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
            );
            return view('gallery.index')->with($data);
    }


    /**
 * @OA\Post(
 *     path="/api/postGallery",
 *     tags={"Upload Gambar"},
 *     summary="Mengunggah Gambar",
 *     description="Endpoint yang digunakan untuk mengunggah gambar.",
 *     operationId="postGallery",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data unggahan gambar",
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="title",
 *                     description="Judul Gambar",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="description",
 *                     description="Deskripsi Gambar",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="picture",
 *                     description="File Gambar",
 *                     type="string",
 *                     format="binary"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Successful operation"
 *     )
 * )
 */

    public function postGallery(Request $request)
    {
        $this->validate($request, [
                'title' => 'required|max:255',
                'description' => 'required',
                'picture' => 'image|nullable|max:1999'
            ]);

            if ($request->hasFile('picture')) {
                $filenameWithExt = $request->file('picture')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('picture')->getClientOriginalExtension();
            
                $basename = uniqid() . time();
                $smallFilename = "small_{$basename}.{$extension}";
                $mediumFilename = "medium_{$basename}.{$extension}";
                $largeFilename = "large_{$basename}.{$extension}";
            
                $filenameSimpan = "{$basename}.{$extension}";
                $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
            } else {
                $filenameSimpan = 'noimage.png';
            }

            // dd($request->input());
            $post = new Post;
            $post->picture = $filenameSimpan;
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->save();
            
            return redirect('gallery')->with('success', 'Berhasil menambahkan data baru'); 
    }

    // public function createThumbnail($path, $width, $height)
    // {
    //     $img = Image::make($path)->resize($width, $height, function ($constraint) {
    //         $constraint->aspectRatio();
    //     });
    //     $img->save($path);
    // }


}
