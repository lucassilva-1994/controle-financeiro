<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Model;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    use Model;
    use Helper;
    private function payments(string $id = null){
        //Retornando a soma dos valores do lançamentos vinculado a cada forma de pagamento.
        //Ordenando as formas de pagamentos das que tem mais lançamentos para menos lançamentos.
        $payments = Payment::with('releases')->withSum('releases','value')->withCount('releases')->orderBy('releases_count','DESC')->whereUserId($this->id())->get();
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
        $request->validate(['name' => 'required|between:3,20']);
        if(self::setData($request->except('_token'),Payment::class))
            return self::redirect('success','criado');
        return self::redirect('error','criar');
    }

    public function update(Request $request){
        $request->validate(['name' => 'required|between:3,20']);
        if(self::updateData($request->except('id','_method','_token'),Payment::class,['id'=> $request->id])){
            return self::redirect('success','atualizado');
        }
        return self::redirect('error','atualizar');
    }

    public function delete(string $id){
        if(Payment::find($id)->delete()){
         return self::redirect('success','excluído');
        }
        return self::redirect('error','excluir');
    }

    private function id(){
        return auth()->user()->id;
    }
}
