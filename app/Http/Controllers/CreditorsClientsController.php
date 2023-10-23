<?php

namespace App\Http\Controllers;

use App\Models\CreditorClient;
use Illuminate\Http\Request;

class CreditorsClientsController extends Controller
{
    private function creditorsClients(string $id = null){
        $creditorsClients = CreditorClient::whereUserId($this->id())->oldest('name')->get();
        $creditorClient_id = CreditorClient::whereUserIdAndId($this->id(),$id)->first();
        return view('dashboard.creditorsclients', compact('creditorsClients','creditorClient_id'));
    }

    public function new(){
        return $this->creditorsClients();
    }

    public function edit(string $id){
        return $this->creditorsClients($id);
    }

    private function redirect($session,$message){
        return redirect()->back()->with($session,$message);
    }

    public function create(Request $request){
        $request->validate(
            ['name' => 'required|between:3,50'],
            ['name.required' => 'Nome é obrigatório.','name.between' => 'O nome deve ter entre :min e :max carcteres.']
        );
        if(CreditorClient::createOrUpdate($request->except('_token'))){
            return $this->redirect('success','Registro cadastrado com sucesso.');
        }
        return $this->redirect('error','Falha no registro.');
    }

    public function update(Request $request){
        $request->validate(
            ['name' => 'required|between:3,50'],
            ['name.required' => 'Nome é obrigatório.','name.between' => 'O nome deve ter entre :min e :max carcteres.']
        );
        if(CreditorClient::createOrUpdate($request->except('_token','_method'))){
            return $this->redirect('success','Registro atualizado com sucesso.');
        }
        return $this->redirect('error','Falha no registro.');
    }

    public function delete(string $id){
        if(CreditorClient::forDelete($id)){
            return $this->redirect('success','Registro removido com sucesso.');
        }
        return $this->redirect('error','Falha ao remover registro.');
    }


    private function id(){
        return auth()->user()->id;
    }
}
