<?php

namespace App\Http\Controllers;

use App\Constants\Message;
use App\Constants\Status;
use App\Http\Requests\UploadImageRequest;
use App\Models\Item;
use App\Services\ItemServices\WolfService;

class ItemController extends InitialController
{
    private WolfService $wolfService;

    public function __construct(WolfService $wolfService)
    {
        $this->wolfService = $wolfService;
    }

    public function uploadImage(UploadImageRequest $request, Item $item)
    {
        $result = $this->wolfService->uploadImage($request->file('image'), $item);

        return $this->jsonResponse(Status::STATUS_SUCCESS, Message::ITEM_IMAGE_UPLOADED_SUCCESSFULLY, $result);
    }
}
