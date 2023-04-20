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
        $releases = Release::where('user_id', session('user_id'))->latest('sequence')->get();
        return view('dashboard.releases.show', compact('releases'));
    }
    private function index(string $id = null)
    {
        $categories = $this->getListCategory();
        $payments = $this->getListPayment();
        $releases = Release::where('user_id', session('user_id'))->latest('sequence')->limit(3)->get();
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
        if (Release::createOrUpdate($request->except('_token'))) :
            return redirect()->back()->with('success', 'Lançamento cadastrado com sucesso.');
        else :
            return redirect()->back()->with('error', 'Falha ao cadastrar lançamento.');
        endif;
    }

    public function update(Request $request)
    {
        if (Release::createOrUpdate($request->except('_token','_method'))) :
            return  redirect()->back()->with('success', 'Lançamento atualizado com sucesso.');
        else :
            return redirect()->back()->with('error', 'Falha ao atualizar registro.');
        endif;
    }

    public function delete(string $id)
    {
        if (Release::deleteRelease($id)) :
            return redirect()->back()->with('success', 'Lançamento removido com sucesso');
        else :
            return redirect()->back()->with('error', 'Falha ao remover registro.');
        endif;
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
