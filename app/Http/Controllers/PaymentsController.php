<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    private function payments(string $id = null){
        //Retornando a soma dos valores do lançamentos vinculado a cada forma de pagamento.
        //Ordenando as formas de pagamentos das que tem mais lançamentos para menos lançamentos.
        $payments = Payment::withSum('releases','value')->withCount('releases')->orderBy('releases_count','DESC')->whereUserId($this->id())->get();
        $payment = Payment::whereUserIdAndId($this->id(),$id)->first();
        return view('dashboard.payments', compact('payments','payment'));
    }

    public function new(){
        return $this->payments();
    }

    public function edit(string $id){
        return $this->payments($id);
    }

    public function create(Request $request){
        $request->validate(['name' => 'required|between:3,20'],['name.required' => 'O nome é obrigatório.','name.between' => 'O nome precisa ter entre :min a :max caracteres.']);
        if(Payment::createOrUpdate($request->except(['_token','_method']))){
            return $this->redirect("success", "Cadastrado com sucesso.");
        }
        return $this->redirect("error", "Falha ao cadastrar.");
    }

    public function update(Request $request){
        $request->validate(['name' => 'required|between:3,20'],['name.required' => 'O nome é obrigatório.','name.between' => 'O nome precisa ter entre :min a :max caracteres.']);
        if(Payment::createOrUpdate($request->except(['_token','_method']))){
            return $this->redirect("success","Atualizado com sucesso.");
        }
        return $this->redirect("error","Falha ao atualizar.");
    }

    private function redirect($classCss, $message){
        return redirect()->back()->with($classCss, $message);
    }

    public function delete(string $id){
        if(Payment::forDelete($id)){
         return $this->redirect("success","Removido com sucesso.");
        }
        return $this->redirect("error","Falha ao remover.");
    }

    private function id(){
        return auth()->user()->id;
    }
}
