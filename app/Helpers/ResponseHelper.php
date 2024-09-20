<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ResponseHelper
{
    /**
     * Return a success response with data.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], $message , $statusCode)
    {
        // Initialize the response structure
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ];

        // If the data is paginated (LengthAwarePaginator or Paginator), include pagination details
        if ($data instanceof LengthAwarePaginator || $data instanceof Paginator) {
            $response['data'] = $data->items(); // Use items() to get the collection data
            $response['pagination'] = [
                'current_page' => $data->currentPage(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
                'total_items' => $data->total(),
                'items_per_page' => $data->perPage(),
            ];
        }

        // Custom formatting for specific data types (Post, Image, Video, Comment)
        if ($data instanceof \App\Models\Post) {
            $response['data'] = [
                'id' => $data->id,
                'title' => $data->title,
                'body' => $data->body,
                'author' => $data->author->name,
                'created_at' => $data->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $data->updated_at->format('Y-m-d H:i:s'),
                'comments_count' => $data->comments()->count(),
            ];
        } elseif ($data instanceof \App\Models\Image) {
            $response['data'] = [
                'id' => $data->id,
                'description' => $data->description,
                'image_url' => url('storage/' . $data->image),
                'author' => $data->author->name,
                'comments_count' => $data->comments()->count(),
                'uploaded_at' => $data->created_at->format('Y-m-d H:i:s'),
            ];
        } elseif ($data instanceof \App\Models\Video) {
            $response['data'] = [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
                'video_url' => url('storage/' . $data->video),
                'author' => $data->author->name,
                'comments_count' => $data->comments()->count(),
                'uploaded_at' => $data->created_at->format('Y-m-d H:i:s'),
            ];
        } elseif ($data instanceof \App\Models\Comment) {
            $response['data'] = [
                'id' => $data->id,
                'body' => $data->body,
                'commentable_type' => $data->commentable_type,
                'commentable_id' => $data->commentable_id,
                'commented_by' => $data->author->name,
                'created_at' => $data->created_at->format('Y-m-d H:i:s'),
            ];
        }

        // Return the JSON response
        return response()->json($response, $statusCode);
    }

    /**
     * Return an error response.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }
}
