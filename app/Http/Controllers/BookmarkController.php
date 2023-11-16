<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{

    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmark = Bookmark::where('user_id', $this->user->id)->get(['id', 'title', 'url', 'platform', 'created_at', 'updated_at'])->toArray();
        
        return response()->json([
            'success' => true,
            'data' => $bookmark
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =
        [
            'title' => $request->title,
            'url' => $request->url,
            'platform' => $request->platform,
            'user_id' => $this->user->id
        ];

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'url' => ['required', 'string', 'max:255', 'url'],
            'platform' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $bookmark = Bookmark::create($data);

        return response()->json([
            'message' => 'Bookmark created successfully',
            'bookmark' => $bookmark
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function show(Bookmark $bookmark)
    {
        $bookmark = Bookmark::where('user_id', $this->user->id)->find($bookmark->id);

        if (!$bookmark) {
            return response()->json([
                'message' => 'Bookmark not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return $bookmark;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        $data =
        [
            'title' => $request->title,
            'url' => $request->url,
            'platform' => $request->platform,
            'user_id' => $this->user->id
        ];

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'url' => ['required', 'string', 'max:255', 'url'],
            'platform' => 'required|string',
            'user_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $bookmark = Bookmark::where('user_id', $this->user->id)->find($bookmark->id);

        if (!$bookmark) {
            return response()->json([
                'message' => 'Bookmark not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $bookmark->update($data);

        return response()->json([
            'message' => 'Bookmark updated successfully',
            'data' => $bookmark
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark = Bookmark::where('user_id', $this->user->id)->find($bookmark->id);

        if (!$bookmark) {
            return response()->json([
                'message' => 'Bookmark not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $bookmark->delete();

        return response()->json([
            'message' => 'Bookmark deleted successfully'
        ], Response::HTTP_OK);
    }
}
