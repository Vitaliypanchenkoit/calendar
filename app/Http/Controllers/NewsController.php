<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateNewsIdRequest;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
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
