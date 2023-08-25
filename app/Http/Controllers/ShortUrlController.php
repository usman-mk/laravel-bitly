<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // query all data
        $models = ShortUrl::all();
        return view('short-url.index', [
            'models' => $models
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // parse url
        $parse_url = parseUrl($request->original_url);
        // query duplicate url
        $model = ShortUrl::where('original_url', $parse_url)->first();
        if ($model) {
            return redirect()->route('short-url.short-url.show', $model->code);
        }

        // create code
        $request->merge(['code' => Str::random(10)]);
        // create validate
        $request->validateWithBag('store', [
            'code' => ['required', Rule::unique((new ShortUrl())->getTable())],
            'original_url' => 'required|max:200',
        ]);
        // insert data
        $requestData = $request->all();
        $requestData['original_url'] = $parse_url;
        $query = ShortUrl::create($requestData);

        return redirect()->route('short-url.short-url.show', $query->code);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortUrl $shortUrl)
    {
        return view('short-url.show', ['model' => $shortUrl]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortUrl $shortUrl)
    {
        return view('short-url.edit', ['model' => $shortUrl]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        // create validate
        $request->validateWithBag('update', [
            'code' => ['required', Rule::unique((new ShortUrl())->getTable())->ignore($request->code, 'code')],
            'original_url' => 'required',
        ]);
        // update date
        $requestData = $request->all();
        $requestData['original_url'] = parseUrl($request->original_url);
        $query = $shortUrl->update($requestData);

        return redirect()->route('short-url.short-url.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortUrl $shortUrl)
    {
        // delete data
        $query = $shortUrl->delete();

        return redirect()->route('short-url.short-url.index');
    }

    public function redirect(ShortUrl $shortUrl) {
        try {
            // check url
            $response = Http::get($shortUrl->original_url);
            if($response->successful()) {
                return redirect()->to($shortUrl->original_url);
            }
            return abort(404);
        } catch (\Throwable $th) {
            return abort(404);   
        }
    }
}
