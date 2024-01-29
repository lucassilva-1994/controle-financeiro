<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Helpers\Messages;
use App\Http\Requests\PaymentRequest;
use App\Models\Payment;

class PaymentsController extends Controller
{
    use Messages, HelperModel;
    public function index(){
        return Payment::with('releases')->get();
    }

    public function show(string $id){
        if(Payment::find($id)){
            return Payment::find($id);
        }
        return $this->messageNotFound();
    }

    public function create(PaymentRequest $request){
        try {
            self::setData($request->all(), Payment::class);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function update(PaymentRequest $request){
        try {
            self::updateData($request->only('name','calculate'), Payment::class,['id' => $request->id]);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function delete(string $id){
        try {
            if(Payment::find($id)->delete()){
                return $this->messageDeleted();
            }
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }
}
