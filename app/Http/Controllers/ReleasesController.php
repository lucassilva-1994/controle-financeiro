<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReleaseRequest;
use App\Models\Category;
use App\Models\CreditorClient;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Release;

class ReleasesController extends Controller
{
    private function calculate($list){
        $balance = ["expenses"=> 0, "revenues" => 0];

        foreach($list as $item){
            $value = str_replace([".", ","], ["", "."], $item["value"]);
            if($item["type"] == "ENTRADA" && $item->payment->calculate == "YES"  && $item['status_pay'] == "QUITADO"){
                $balance["revenues"] += $value;
            }
            if($item["type"] == "SAIDA" && $item->payment->calculate == "YES" && $item['status_pay'] == "QUITADO"){
                $balance["expenses"] += $value;
            }
        }
        return $balance;
    }
    public function show(Request $request)
    {
        if($request->words && Release::whereUserId($this->id())->first()){
            $releases = Release::whereLike($request->words);
            $balance = $this->calculate($releases);
            $releases_total = Release::whereUserId($this->id())->get();
            $balance_total = $this->calculate($releases_total);
            return view('dashboard.releases.show', compact('releases','balance','balance_total','releases_total'));
        }
        $releases = Release::whereUserId($this->id())->latest('date')->paginate(10);
        $balance = $this->calculate($releases);
        $releases_total = Release::whereUserId($this->id())->get();
        $balance_total = $this->calculate($releases_total);
        return view('dashboard.releases.show', compact('releases','balance','balance_total','releases_total'));
    }

    private function index(string $id = null)
    {
        $categories = $this->getListCategories();
        $payments = $this->getListPayments();
        $creditorsClients = $this->getListCreditosClients();
        $releases = Release::whereUserId($this->id())->latest('date')->limit(5)->get();
        $release_id = Release::whereId($id)->first();
        return view("dashboard.releases.form", compact('categories', 'payments', 'releases', 'release_id','creditorsClients'));
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
        if (Release::createOrUpdate($request->except('_token'))) {
            return redirect()->back()->with('success', 'Lançamento cadastrado com sucesso.');
        }
        return redirect()->back()->with('error', 'Falha ao cadastrar lançamento.');
    }

    public function update(Request $request)
    {
        if (Release::createOrUpdate($request->except('_token', '_method'))) :
            return  redirect()->back()->with('success', 'Lançamento atualizado com sucesso.');
        else :
            return redirect()->back()->with('error', 'Falha ao atualizar registro.');
        endif;
    }

    public function delete(string $id)
    {
        if (Release::forDelete($id)) :
            return redirect()->back()->with('success', 'Lançamento removido com sucesso');
        else :
            return redirect()->back()->with('error', 'Falha ao remover registro.');
        endif;
    }

    private function getListCategories()
    {
        return Category::whereUserId($this->id())->oldest('name')->get();
    }

    private function getListPayments()
    {
        return Payment::whereUserId($this->id())->oldest('name')->get();
    }
    private function getListCreditosClients()
    {
        return CreditorClient::whereUserId($this->id())->oldest('name')->get();
    }

    private function id(){
        return auth()->user()->id;
    }
}
