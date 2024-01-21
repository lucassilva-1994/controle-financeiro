<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;
use App\Helpers\Messages;
use App\Http\Requests\ClientCreditorRequest;
use App\Models\ClientCreditor;

class ClientsCreditorsController extends Controller
{
    use Messages, HelperModel;
    public function index(){
        return ClientCreditor::get();
    }

    public function show(string $id){
        if(ClientCreditor::find($id)){
            return ClientCreditor::find($id);
        }
        return $this->messageNotFound();
    }

    public function create(ClientCreditorRequest $request){
        try {
            self::setData($request->all(), ClientCreditor::class);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function update(ClientCreditorRequest $request){
        try {
            self::updateData($request->only('name','type'), ClientCreditor::class,['id' => $request->id]);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function delete(string $id){
        try {
            if(ClientCreditor::find($id)->delete()){
                return $this->messageDeleted();
            }
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }
}
