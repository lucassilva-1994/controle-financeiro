<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel, Messages};
use App\Http\Requests\ReleaseRequest;
use App\Models\File;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ReleasesController extends Controller
{
    use HelperModel, Messages;
    public function index()
    {
        return Release::with(['payment:id,name','category:id,name','clientOrCreditor'])->paginate();
    }

    public function show(Release $release)
    {
        if ($release) {
            return $release->load(['payment','category']);
        }
        return $this->messageNotFound();
    }

    public function create(Request $request)
    {
        $request['category_id'] = Arr::random(auth()->user()->categories->pluck('id')->toArray());
        $request['payment_id']  = Arr::random(auth()->user()->payments->pluck('id')->toArray());
        //$request['value'] = fake()->randomFloat(2, 10, 1500);
        //$request['value'] = self::formatCurrency($request['value']);
        $request['date']  = date('Y-m-d');
        $request['status'] = Arr::random(['PENDING', 'PAID']);
        $request['type']    = Arr::random(['INCOME', 'EXPENSE']);
        try {
            $create = self::setData($request->except('files'), Release::class);
            foreach ($request->file('files') as $file) {
                $file->store('uploads');
            }
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
            //return $this->messageFailed();
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
