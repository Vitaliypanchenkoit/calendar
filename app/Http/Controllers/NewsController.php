<?php

namespace App\Http\Controllers;

use App\Helpers\CacheHelper;
use App\Http\Requests\News\CreateNewsRequest;
use App\Http\Requests\News\MarkNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Requests\News\ValidateNewsIdRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\NewsMark;
use App\Notifications\NewsWasMarkAsImportant;
use App\PersistModule\PersistNews;
use App\Repositories\NewsMarkRepository;
use App\Repositories\NewsRepository;
use App\Sevices\NewsService;
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

        $repository = new NewsRepository();

        return $repository->getSingleNews($data['id']);

    }

    /**
     * @param UpdateNewsRequest $request
     * @return NewsResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateNewsRequest $request)
    {
        try {
            $data = $request->validated();
            $repository = new NewsRepository();

            $news = $repository->getSingleNews($data['id']);
            if ($news->author_id !== auth()->user()->id) {
                throw new \Exception(__('You haven\'t an access to update this news'));
            }

            $persistModule = new PersistNews();
            $result = $persistModule->update($data);

            if ($result) {
                $news = $news->fresh();
                CacheHelper::createOrUpdateRecord(CacheHelper::NEWS, $news->date, $news);
            }

            return new NewsResource($news);

        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }
    }

    /**
     * @param MarkNewsRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function mark(MarkNewsRequest $request)
    {
        try {
            $data = $request->validated();
            $service = new NewsService();
            $service->markNews($data['newsId'], $data['key'], $data['value']);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

    }
}
