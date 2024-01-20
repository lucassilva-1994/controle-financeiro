<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Model;
use App\Models\CreditorClient;
use Illuminate\Http\Request;

class CreditorsClientsController extends Controller
{
    use Model;
    use Helper;
    private function creditorsClients(string $id = null){
        $creditorsClients = CreditorClient::withSum('releases','value')->whereUserId($this->id())->oldest('name')->get();
        $creditorClient_id = CreditorClient::whereUserIdAndId($this->id(),$id)->first();
        return view('dashboard.creditorsclients', compact('creditorsClients','creditorClient_id'));
    }

    public function new(){
        return $this->creditorsClients();
    }

    public function edit(string $id){
        return $this->creditorsClients($id);
    }

    public function create(Request $request){
        $request->validate(
            ['name' => 'required|between:3,50']
        );
        if(self::setData($request->except('_token'),CreditorClient::class)){
            return self::redirect('success','criado');
        }
        return self::redirect('error','criar');
    }

    public function update(Request $request){
        $request->validate(
            ['name' => 'required|between:3,50']
        );
        if(self::updateData($request->except('_token','_method'),CreditorClient::class,['id' => $request->id])){
            return self::redirect('success','atualizado');
        }
        return self::redirect('error','atualizar');
    }

    public function delete(string $id){
        if(CreditorClient::find($id)->delete()){
            return self::redirect('success','excluido');
        }
        return self::redirect('error','excluir');
    }
    
    private function id(){
        return auth()->user()->id;
    }
}
