<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReleaseRequest;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Release;

class ReleasesController extends Controller
{
    public function show()
    {
        $releases = Release::latest('sequence')->get();
        return view('dashboard.releases.show', compact('releases'));
    }
    private function index(string $id = null)
    {
        $categories = $this->getListCategory();
        $payments = $this->getListPayment();
        $releases = Release::latest('sequence')->limit(3)->get();
        $release_id = Release::where(['id' => $id])->first();
        return view("dashboard.releases.form", compact('categories', 'payments', 'releases', 'release_id'));
    }

    public function new()
    {
        return $this->index();
    }

    public function edit(string $id)
    {
        return $this->index($id);
    }

    public function create(ReleaseRequest $request)
    {
        return Release::createOrUpdate($request->except(['_token']));
    }

    public function update(Request $request)
    {
        return Release::createOrUpdate($request->except(['_token', '_method']));
    }

    public function delete(string $id)
    {
        return Release::deleteRelease($id);
    }

    private function getListCategory()
    {
        return Category::where('user_id', session('user_id'))->oldest('name')->get();
    }

    private function getListPayment()
    {
        return Payment::where('user_id', session('user_id'))->oldest('name')->get();
    }
}
