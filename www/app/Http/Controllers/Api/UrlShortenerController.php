<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description"
 * )
 *
 * @OA\Server(
 *      url="L5_SWAGGER_CONST_HOST",
 *      description="Laravel OpenApi Demo Server"
 * )
 */
class UrlShortenerController
{

    /**
     * Redirect to original URL.
     *
     * @OA\Get(
     *     path="/{shortened}",
     *     tags={"URL Shortener"},
     *     summary="Redirect to original URL",
     *     description="Redirect to original URL",
     *     @OA\Parameter(
     *         name="shortened",
     *         in="path",
     *         required=true,
     *         description="Shortened URL",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirect to original URL"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function redirect($shortened)
    {
        $shortUrl = ShortUrl::where('shortened_url', $shortened)->firstOrFail();
        return redirect($shortUrl->original_url);
    }

    /**
     * Get all shortened URLs.
     *
     * @OA\Get(
     *     path="/url",
     *     tags={"URL Shortener"},
     *     summary="Get all URLs",
     *     description="Retrieve all shortened URLs",
     *     @OA\Response(
     *         response=200,
     *         description="List of URLs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="original_url", type="string", example="https://www.google.com"),
     *                 @OA\Property(property="shortened_url", type="string", example="http://localhost:8000/abc123")
     *             )
     *         )
     *     )
     * )
     */
    public function getUrls()
    {
        return response()->json(ShortUrl::all());
    }

    /**
     * Shorten a URL.
     *
     * @OA\Post(
     *     path="/url/shorten",
     *     tags={"URL Shortener"},
     *     summary="Shorten a URL",
     *     description="Shorten a URL",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"url"},
     *             @OA\Property(property="url", type="string", example="https://www.google.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Shortened URL",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="original_url", type="string", example="https://www.google.com"),
     *             @OA\Property(property="shortened_url", type="string", example="http://localhost:8000/abc123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     )
     * )
     */
    public function shorten(Request $request)
    {
        $request->validate(['url' => 'required|url|max:255']);

        $shortUrl = ShortUrl::create([
            'original_url' => e($request->url),
            'shortened_url' => ShortUrl::generateShortUrl(),
        ]);

        return response()->json($shortUrl);
    }

    /**
     * Remove a shortened URL.
     *
     * @OA\Delete(
     *     path="/url/{shortened}",
     *     tags={"URL Shortener"},
     *     summary="Remove a URL",
     *     description="Remove a URL by shortened identifier",
     *     @OA\Parameter(
     *         name="shortened",
     *         in="path",
     *         required=true,
     *         description="Shortened URL",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL removed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="URL removed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function remove($shortened)
    {
        $shortUrl = ShortUrl::where('id', $shortened)->firstOrFail();
        $shortUrl->delete();

        return response()->json(['message' => 'URL removed']);
    }
}
