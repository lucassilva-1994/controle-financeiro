<?php

namespace App\Http\Controllers;

use App\Helpers\Model;
use App\Helpers\Helper;
use App\Http\Requests\ReleaseRequest;
use App\Models\Category;
use App\Models\CreditorClient;
use App\Models\File;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Release;
use Illuminate\Support\Facades\Storage;

class ReleasesController extends Controller
{
    use Model;
    use Helper;
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
            $releases_total = Release::with('payment','category','creditorClient')->whereUserId($this->id())->get();
            $balance_total = $this->calculate($releases_total);
            return view('dashboard.releases.show', compact('releases','balance','balance_total','releases_total'));
        }
        $releases = Release::with('payment','category','creditorClient')->whereUserId($this->id())->latest('date')->paginate(10);
        $balance = $this->calculate($releases);
        $releases_total = Release::with('payment','category','creditorClient')->whereUserId($this->id())->get();
        $balance_total = $this->calculate($releases_total);
        return view('dashboard.releases.show', compact('releases','balance','balance_total','releases_total'));
    }

    private function index(string $id = null)
    {
        $categories = $this->getListCategories();
        $payments = $this->getListPayments();
        $creditorsClients = $this->getListCreditosClients();
        $releases = Release::with('payment','category','creditorClient')->whereUserId($this->id())->latest('date')->limit(5)->get();
        $release_id = Release::with('payment','category')->whereId($id)->first();
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
        $request['value'] =  self::formatCurrency($request['value']);
        $create = self::setData($request->except('_token'),Release::class);
        if ($create) {
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    File::createFiles($create->id, $create->user_id, $file);
                }
            }
            return self::redirect('success','criado');
        }
        return self::redirect('error','criar');
    }

    public function update(Request $request)
    {
        $request['value'] =  self::formatCurrency($request['value']);
        if(self::updateData($request->except('id','_method','_token','files'),Release::class,['id' => $request->id])){
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    File::createFiles($request->id, $this->id(), $file);
                }
            }
            return self::redirect('success','atualizado');
        }
    }

    public function delete(string $id)
    {
        $release = Release::find($id);
        $files = File::whereReleaseId($release->id)->get();
        if($files){
            foreach($files as $file)
                Storage::delete($file->path);
        }
        if (Release::find($id)->delete()) :
            return self::redirect('success','excluido');
        else :
            return self::redirect('error','excluir');
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
