<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateiframeRequest;
use App\Http\Requests\UpdateiframeRequest;
use App\Repositories\IframeRepository;
use App\Models\Iframe;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class IframeController extends AppBaseController
{


    private $iframeRepo;

    public function __construct(IframeRepository $iframeRepo)
    {
        $this->iframeRepo = $iframeRepo;
    }

    public function store(CreateiframeRequest $request): JsonResponse
    {
        $input = $request->all();

        $iframe = $this->iframeRepo->store($input);

        return $this->sendResponse($iframe, __('Iframe store successfully'));
    }

    public function edit(Iframe $iframe): JsonResponse
    {
        return $this->sendResponse($iframe, 'Iframes successfully retrieved.');
    }


    public function update(UpdateiframeRequest $request, Iframe $iframe): JsonResponse
    {

        $input = $request->all();

        $iframe = $this->iframeRepo->update($input, $iframe->id);

        return $this->sendResponse($iframe, __('Iframe update successfully'));
    }


    public function destroy(Iframe $iframe): JsonResponse
    {
        $iframe->delete();

        return $this->sendSuccess('Iframe deleted successfully.');
    }

}
