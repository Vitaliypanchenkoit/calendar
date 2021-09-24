<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\ValidateNewsIdRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\PersistModule\PersistNews;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function create(CreateNewsRequest $request): mixed
    {
        try {
            $data = $request->validated();
            $now = now();
            $data['date'] = $now->format('Y-m-d');
            $data['time'] = $now->format('H:i');

            $persistModule = new PersistNews();
            $news = $persistModule->create($data);

            CacheHelper::createOrUpdateRecord(CacheHelper::NEWS, $data['date'], $news);

            return new NewsResource($news);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    /**
     * @param ValidateNewsIdRequest $request
     * @return mixed
     */
    public function edit(ValidateNewsIdRequest $request)
    {
        $data = $request->validated();

        return News::find($data['id']);

    }
}
