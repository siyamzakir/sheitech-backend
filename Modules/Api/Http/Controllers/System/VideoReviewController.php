<?php

namespace Modules\Api\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\VideoReviews;
use Illuminate\Support\Facades\Cache;
use Modules\Api\Http\Resources\System\VideoReviewResource;


class VideoReviewController extends Controller
{
    public function index()
    {
        // Use Cache::rememberForever to simplify cache checking and storing logic
        $data = Cache::rememberForever('video_reviews', function () {
            $reviews = VideoReviews::all();  // Fetch all video reviews
            return VideoReviewResource::collection($reviews);  // Transform data with resource
        });
    
        return $this->respondWithSuccessWithData($data);
    }
}
