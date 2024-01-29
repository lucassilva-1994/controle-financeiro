<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel, Messages};
use App\Http\Requests\ReleaseRequest;
use App\Models\{File,Release};

class ReleasesController extends Controller
{
    use HelperModel, Messages;
    public function index()
    {
        return Release::with(['payment:id,name','category:id,name','clientOrCreditor'])->paginate(50)->flatten();
    }

    public function show(Release $release)
    {
        if ($release) {
            return $release->load(['payment','category']);
        }
        return $this->messageNotFound();
    }

    public function create(ReleaseRequest $request)
    {
        try {
            $create = self::setData($request->except('files'), Release::class);
            foreach ($request->file('files') as $file) {
                $data['path']       = $file->store("releases/".$create->id);
                $data['name']       = $file->getClientOriginalName();
                $data['release_id'] = $create->id;
                self::setData($data,File::class);
            }
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
            // return $this->messageFailed();
        }
    }

    public function update(ReleaseRequest $request)
    {
        try {
            self::updateData($request->all(), Release::class, ['id' => $request->id]);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
            //return $this->messageFailed();
        }
    }

    public function delete(Release $release)
    {
        try {
            if ($release->delete()) {
                return $this->messageDeleted();
            }
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }
}
